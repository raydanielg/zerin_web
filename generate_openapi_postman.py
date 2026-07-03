import re
import json
from pathlib import Path
from urllib.parse import urljoin

BASE_URL = 'https://zerinexpress.com'
WEB_DIR = Path('f:/Zerixa/drivemond-31/combo/web')
OUT_DIR = WEB_DIR / 'api-docs'
OUT_DIR.mkdir(exist_ok=True)

def parse_readme_api_routes():
    readme = WEB_DIR / 'README.md'
    text = readme.read_text(encoding='utf-8')

    routes = []
    # Pattern: ### `METHOD` `uri` followed by bullet lines
    pattern = re.compile(
        r'### `([^`]+)` `([^`]+)`\n\n'
        r'- \*\*Route name:\*\* ([^\n]+)\n'
        r'- \*\*Controller:\*\* `([^`]+)`\n'
        r'- \*\*Middleware:\*\* ([^\n]+)\n\n'
        r'((?:\*\*[^*]+\*\*[^\n]*\n+(?:\|[^\n]+\|[^\n]*\n)*)?)',
        re.MULTILINE
    )
    for m in pattern.finditer(text):
        methods = m.group(1).split(' | ')
        uri = m.group(2)
        name = m.group(3).strip()
        action = m.group(4)
        middleware_str = m.group(5)
        payload_block = m.group(6)

        # Skip HEAD only
        methods = [meth for meth in methods if meth != 'HEAD']
        if not methods:
            continue

        # Determine category
        category = categorize_route(uri, action, middleware_str)

        # Extract payload fields from markdown table if present
        fields = []
        for line in payload_block.splitlines():
            if line.startswith('| `') and 'Field' not in line and 'Rules' not in line:
                parts = line.split('|')
                if len(parts) >= 3:
                    field = parts[1].strip().strip('`')
                    rules = parts[2].strip()
                    fields.append({'field': field, 'rules': rules})

        routes.append({
            'methods': methods,
            'uri': uri,
            'name': name,
            'action': action,
            'middleware': middleware_str,
            'category': category,
            'fields': fields,
        })
    return routes

def categorize_route(uri, action, middleware_str):
    low = uri.lower()
    act = action.lower()
    mw = middleware_str.lower()
    if low.startswith('admin/'):
        return 'Admin'
    if '/driver/' in low or 'driver' in act:
        return 'Driver'
    if '/customer/' in low or '/user/' in low or 'customer' in act:
        return 'Customer'
    if 'auth' in act and ('customer' in act or 'customer' in low):
        return 'Customer'
    if 'auth' in act and ('driver' in act or 'driver' in low):
        return 'Driver'
    return 'Shared'

def parse_admin_routes():
    routes_file = WEB_DIR / 'routes_list_utf8.json'
    text = routes_file.read_text(encoding='utf-8-sig')
    data = json.loads(text)
    admin_routes = []
    for r in data:
        uri = r['uri']
        if not uri.lower().startswith('admin/'):
            continue
        methods = [m for m in r['method'].split('|') if m != 'HEAD']
        if not methods:
            continue
        admin_routes.append({
            'methods': methods,
            'uri': uri,
            'name': r.get('name', ''),
            'action': r.get('action', ''),
            'middleware': ', '.join(str(m) for m in r.get('middleware', [])),
            'category': 'Admin',
            'fields': [],
        })
    return admin_routes

def uri_to_path(uri, category):
    # Convert Laravel route params {id} to OpenAPI {id}
    # Customer/Driver APIs are under /api/ in Laravel
    # Admin routes are web routes under /admin/
    if category == 'Admin':
        return '/' + uri
    return '/api/' + uri

def build_openapi_spec(routes):
    spec = {
        'openapi': '3.0.3',
        'info': {
            'title': 'Drivemond API Documentation',
            'description': 'Auto-generated API docs for Driver, Customer, and Admin endpoints.\n\n- Customer and Driver paths are prefixed with `/api/` (Laravel API routes).\n- Admin paths are web routes served directly under the domain.',
            'version': '1.0.0',
            'contact': {'name': 'Drivemond Support'}
        },
        'servers': [
            {'url': BASE_URL, 'description': 'Production server'}
        ],
        'tags': [
            {'name': 'Customer', 'description': 'Customer / User mobile app APIs'},
            {'name': 'Driver', 'description': 'Driver mobile app APIs'},
            {'name': 'Admin', 'description': 'Admin panel APIs'},
            {'name': 'Shared', 'description': 'Shared or common APIs'}
        ],
        'paths': {},
        'components': {
            'schemas': {
                'Error': {
                    'type': 'object',
                    'properties': {
                        'message': {'type': 'string'},
                        'errors': {'type': 'object'}
                    }
                }
            }
        }
    }

    for route in routes:
        path = uri_to_path(route['uri'], route['category'])
        # Convert Laravel {param} to OpenAPI style already matches
        # Build parameters
        path_params = re.findall(r'\{([^}]+)\}', path)
        parameters = []
        for pp in path_params:
            parameters.append({
                'name': pp,
                'in': 'path',
                'required': True,
                'schema': {'type': 'string'}
            })

        # If GET and has query feel, add optional query params for limit/offset
        if 'GET' in route['methods']:
            if 'limit' in route['uri'].lower() or 'offset' in route['uri'].lower():
                parameters.append({'name': 'limit', 'in': 'query', 'schema': {'type': 'integer'}})
                parameters.append({'name': 'offset', 'in': 'query', 'schema': {'type': 'integer'}})

        operations = {}
        for method in route['methods']:
            op = {
                'tags': [route['category']],
                'summary': f"{route['name']} - {route['action']}",
                'operationId': f"{route['category']}_{route['name']}_{method}",
                'parameters': parameters.copy() if parameters else [],
                'responses': {
                    '200': {'description': 'Successful response'},
                    '401': {'description': 'Unauthorized', 'content': {'application/json': {'schema': {'$ref': '#/components/schemas/Error'}}}},
                    '404': {'description': 'Not found', 'content': {'application/json': {'schema': {'$ref': '#/components/schemas/Error'}}}},
                    '422': {'description': 'Validation error', 'content': {'application/json': {'schema': {'$ref': '#/components/schemas/Error'}}}}
                }
            }
            if method in ['POST', 'PUT', 'PATCH'] and route['fields']:
                props = {}
                required = []
                for f in route['fields']:
                    field_name = f['field']
                    rules = f['rules'].lower()
                    # Simple type inference
                    if 'integer' in rules or 'numeric' in rules:
                        schema = {'type': 'integer'}
                    elif 'boolean' in rules:
                        schema = {'type': 'boolean'}
                    elif 'array' in rules:
                        schema = {'type': 'array', 'items': {'type': 'string'}}
                    elif 'image' in rules or 'file' in rules or 'mimes' in rules:
                        schema = {'type': 'string', 'format': 'binary'}
                    else:
                        schema = {'type': 'string'}
                    props[field_name] = schema
                    if 'required' in rules:
                        required.append(field_name)
                op['requestBody'] = {
                    'required': True,
                    'content': {
                        'application/json': {
                            'schema': {
                                'type': 'object',
                                'properties': props,
                                'required': required
                            }
                        }
                    }
                }
            elif method in ['POST', 'PUT', 'PATCH']:
                op['requestBody'] = {
                    'required': True,
                    'content': {
                        'application/json': {
                            'schema': {
                                'type': 'object',
                                'properties': {'payload': {'type': 'string', 'description': 'See source controller for exact fields'}}
                            }
                        }
                    }
                }
            operations[method.lower()] = op

        if path not in spec['paths']:
            spec['paths'][path] = {}
        spec['paths'][path].update(operations)

    return spec

def build_postman_collection(routes):
    collection = {
        'info': {
            'name': 'Drivemond API Collection',
            'description': 'Driver, Customer, and Admin API endpoints',
            'schema': 'https://schema.getpostman.com/json/collection/v2.1.0/collection.json'
        },
        'item': []
    }

    # Group by category
    groups = {}
    for route in routes:
        cat = route['category']
        if cat not in groups:
            groups[cat] = []
        groups[cat].append(route)

    for cat in ['Customer', 'Driver', 'Admin', 'Shared']:
        if cat not in groups:
            continue
        items = []
        for route in groups[cat]:
            for method in route['methods']:
                req = {
                    'name': f"{method} {route['uri']}",
                    'request': {
                        'method': method,
                        'header': [
                            {'key': 'Content-Type', 'value': 'application/json'},
                            {'key': 'Accept', 'value': 'application/json'},
                            {'key': 'X-Localization', 'value': 'en'}
                        ],
                        'url': {
                            'raw': f"{{{{base_url}}}}{uri_to_path(route['uri'], route['category'])}",
                            'host': ['{{base_url}}'],
                            'path': uri_to_path(route['uri'], route['category']).lstrip('/').split('/')
                        },
                        'description': f"Action: {route['action']}\nMiddleware: {route['middleware']}"
                    }
                }
                if method in ['POST', 'PUT', 'PATCH'] and route['fields']:
                    body_fields = []
                    for f in route['fields']:
                        body_fields.append({
                            'key': f['field'],
                            'value': '',
                            'type': 'text'
                        })
                    req['request']['body'] = {
                        'mode': 'urlencoded',
                        'urlencoded': body_fields
                    }
                items.append(req)
        collection['item'].append({
            'name': cat,
            'item': items
        })

    collection['variable'] = [
        {'key': 'base_url', 'value': BASE_URL, 'type': 'string'},
        {'key': 'token', 'value': '', 'type': 'string'}
    ]
    return collection

def build_swagger_ui_html():
    html = '''<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Drivemond API Docs - Swagger UI</title>
  <link rel="stylesheet" href="https://unpkg.com/swagger-ui-dist@5.9.0/swagger-ui.css" />
  <style>body{margin:0;padding:0;}</style>
</head>
<body>
  <div id="swagger-ui"></div>
  <script src="https://unpkg.com/swagger-ui-dist@5.9.0/swagger-ui-bundle.js"></script>
  <script src="https://unpkg.com/swagger-ui-dist@5.9.0/swagger-ui-standalone-preset.js"></script>
  <script>
    window.onload = function() {
      const ui = SwaggerUIBundle({
        url: 'openapi.json',
        dom_id: '#swagger-ui',
        presets: [SwaggerUIBundle.presets.apis, SwaggerUIStandalonePreset],
        layout: 'StandaloneLayout'
      });
    };
  </script>
</body>
</html>'''
    return html

def main():
    api_routes = parse_readme_api_routes()
    admin_routes = parse_admin_routes()
    all_routes = api_routes + admin_routes

    # Generate OpenAPI spec
    spec = build_openapi_spec(all_routes)
    openapi_path = OUT_DIR / 'openapi.json'
    openapi_path.write_text(json.dumps(spec, indent=2, ensure_ascii=False), encoding='utf-8')

    # Generate Postman collection
    collection = build_postman_collection(all_routes)
    postman_path = OUT_DIR / 'postman_collection.json'
    postman_path.write_text(json.dumps(collection, indent=2, ensure_ascii=False), encoding='utf-8')

    # Generate Swagger UI HTML
    html = build_swagger_ui_html()
    swagger_path = OUT_DIR / 'swagger-ui.html'
    swagger_path.write_text(html, encoding='utf-8')

    # Summary README
    summary = f"""# Drivemond API Documentation Files

Generated files:
- `openapi.json` - OpenAPI 3.0 spec for Driver, Customer, and Admin APIs
- `swagger-ui.html` - Swagger UI (open in browser)
- `postman_collection.json` - Import into Postman

Counts:
- Customer/Driver APIs: {len(api_routes)}
- Admin APIs: {len(admin_routes)}
- Total: {len(all_routes)}

Base URL: {BASE_URL}
"""
    (OUT_DIR / 'README.md').write_text(summary, encoding='utf-8')

    print(f'Generated {openapi_path} ({len(api_routes)} customer/driver + {len(admin_routes)} admin routes)')
    print(f'Generated {postman_path}')
    print(f'Generated {swagger_path}')

if __name__ == '__main__':
    main()
