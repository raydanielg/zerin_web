<?php
/**
 * Script to generate README.md with all API routes and their payloads.
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle($request = Illuminate\Http\Request::capture());

$router = $app->make('router');
$routes = $router->getRoutes();

$apiRoutes = [];
foreach ($routes as $route) {
    $middleware = $route->gatherMiddleware();
    $middlewareFlat = [];
    foreach ($middleware as $m) {
        if (is_array($m)) {
            $middlewareFlat = array_merge($middlewareFlat, $m);
        } else {
            $middlewareFlat[] = $m;
        }
    }
    // Include routes that have 'api' middleware or api guard/auth
    $isApi = false;
    foreach ($middlewareFlat as $m) {
        $mStr = is_string($m) ? $m : '';
        if (strpos($mStr, 'api') !== false) {
            $isApi = true;
            break;
        }
    }
    // Exclude pure web routes and install/update routes
    if (!$isApi) {
        continue;
    }
    $uri = $route->uri();
    if (str_starts_with($uri, 'step') || str_starts_with($uri, 'install') || str_starts_with($uri, 'update')) {
        continue;
    }
    $methods = array_diff($route->methods(), ['HEAD']);
    $action = $route->getActionName();
    if ($action === 'Closure' || $action === 'Illuminate\\Routing\\ViewController') {
        continue;
    }
    $apiRoutes[] = [
        'methods' => $methods,
        'uri' => $uri,
        'name' => $route->getName(),
        'action' => $action,
        'middleware' => $middlewareFlat,
    ];
}

// Group by controller (module)
$grouped = [];
foreach ($apiRoutes as $route) {
    $action = $route['action'];
    $controller = $action;
    $method = '';
    if (str_contains($action, '@')) {
        [$controller, $method] = explode('@', $action, 2);
    }
    $module = 'Other';
    if (preg_match('/Modules\\\\([A-Za-z]+)\\\\/', $controller, $matches)) {
        $module = $matches[1];
    } elseif (str_contains($controller, 'App\\\Http\\\Controllers')) {
        $module = 'App';
    }
    if (!isset($grouped[$module])) {
        $grouped[$module] = [];
    }
    $route['controller'] = $controller;
    $route['method'] = $method;
    $grouped[$module][] = $route;
}

ksort($grouped);
foreach ($grouped as $module => $routes) {
    usort($routes, function ($a, $b) {
        return strcmp($a['uri'], $b['uri']);
    });
    $grouped[$module] = $routes;
}

function getPayloadRules($controller, $method) {
    if (!class_exists($controller)) {
        return null;
    }
    try {
        $ref = new ReflectionMethod($controller, $method);
    } catch (Throwable $e) {
        return null;
    }
    $params = $ref->getParameters();
    foreach ($params as $param) {
        $type = $param->getType();
        if ($type instanceof ReflectionNamedType && !$type->isBuiltin()) {
            $className = $type->getName();
            if (is_subclass_of($className, Illuminate\Foundation\Http\FormRequest::class)) {
                try {
                    $instance = new $className();
                    if (method_exists($instance, 'rules')) {
                        $rules = $instance->rules();
                        if (is_array($rules)) {
                            return ['form_request' => $className, 'rules' => $rules];
                        }
                    }
                } catch (Throwable $e) {
                    return ['form_request' => $className, 'error' => 'Dynamic rules could not be resolved: ' . $e->getMessage()];
                }
            }
        }
    }
    return null;
}

function rulesToMarkdown($rules) {
    if (!is_array($rules) || empty($rules)) {
        return 'No payload documented.';
    }
    $md = "| Field | Rules |\n|-------|-------|\n";
    foreach ($rules as $field => $rule) {
        $ruleStr = is_array($rule) ? implode(', ', $rule) : (string) $rule;
        $md .= "| `{$field}` | {$ruleStr} |\n";
    }
    return $md;
}

$total = 0;
foreach ($grouped as $routes) {
    $total += count($routes);
}

$date = date('Y-m-d H:i:s');
$md = <<<MD
# API Documentation

> Auto-generated from the Laravel route list on **{$date}**.  
> Total API endpoints documented: **{$total}**.  
> Base URL: append the `URI` to your application domain. Routes below are registered under the `api` middleware group (no `/api/` prefix is required unless your `RouteServiceProvider` adds it).

## Table of Contents

MD;

foreach (array_keys($grouped) as $module) {
    $md .= "- [{$module}](#" . strtolower($module) . ")\n";
}

$md .= "\n";

foreach ($grouped as $module => $routes) {
    $md .= "## {$module}\n\n";
    foreach ($routes as $route) {
        $methods = implode(' | ', $route['methods']);
        $name = $route['name'] ?: '—';
        $action = $route['action'];
        $middleware = array_map(function ($m) {
            return is_string($m) ? "`{$m}`" : json_encode($m);
        }, $route['middleware']);
        $middlewareStr = implode(', ', $middleware);
        $md .= "### `{$methods}` `{$route['uri']}`\n\n";
        $md .= "- **Route name:** {$name}\n";
        $md .= "- **Controller:** `{$action}`\n";
        $md .= "- **Middleware:** {$middlewareStr}\n\n";

        $payload = getPayloadRules($route['controller'], $route['method']);
        if ($payload) {
            if (isset($payload['error'])) {
                $md .= "**Validation (FormRequest):** `{$payload['form_request']}` — {$payload['error']}\n\n";
            } else {
                $md .= "**Validation (FormRequest):** `{$payload['form_request']}`\n\n";
                $md .= rulesToMarkdown($payload['rules']) . "\n";
            }
        } else {
            $md .= "**Payload:** No FormRequest validation found. Check the controller method for request parameters.\n\n";
        }
    }
}

$path = __DIR__ . '/README.md';
file_put_contents($path, $md);
echo "Generated README.md with {$total} API routes at {$path}\n";
