<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route as RouteFacade;
use Illuminate\Validation\Rules\In;
use Illuminate\Validation\Rules\RequiredIf;
use ReflectionMethod;
use ReflectionNamedType;

class GenerateOpenApiSpec extends Command
{
    protected $signature = 'openapi:generate {--output= : Output file path}';
    protected $description = 'Generate OpenAPI 3.0 spec from routes and FormRequest validation rules';

    private array $tagOrder = ['Customer', 'Driver', 'Partner', 'Admin', 'Shared'];

    public function handle(): int
    {
        $routes = RouteFacade::getRoutes();
        $paths = [];
        $stats = ['total' => 0, 'with_schema' => 0, 'generic' => 0];

        foreach ($routes as $route) {
            $uri = '/' . $route->uri();

            $category = $this->categorizeRoute($uri, $route->getActionName());
            if ($category === null) {
                continue;
            }

            $methods = array_filter($route->methods(), fn($m) => $m !== 'HEAD');
            if (empty($methods)) {
                continue;
            }

            $action = $route->getActionName();
            if (!str_contains($action, '@')) {
                continue;
            }

            [$controllerClass, $methodName] = explode('@', $action);
            if (!class_exists($controllerClass)) {
                continue;
            }

            $requestSchema = $this->getRequestSchema($controllerClass, $methodName, $route);
            $pathParams = $this->extractPathParams($uri);
            $middleware = $route->gatherMiddleware();

            foreach ($methods as $method) {
                $stats['total']++;
                if ($requestSchema) {
                    $stats['with_schema']++;
                } else {
                    $stats['generic']++;
                }

                $operation = $this->buildOperation(
                    $method, $category, $methodName, $controllerClass,
                    $pathParams, $requestSchema, $uri, $middleware
                );

                if (!isset($paths[$uri])) {
                    $paths[$uri] = [];
                }
                $paths[$uri][strtolower($method)] = $operation;
            }
        }

        $spec = $this->buildSpec($paths);

        $outputPath = $this->option('output') ?: public_path('api-docs/openapi.json');
        $dir = dirname($outputPath);
        if (!is_dir($dir)) {
            File::makeDirectory($dir, 0755, true);
        }
        File::put($outputPath, json_encode($spec, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

        $this->info("OpenAPI spec generated at: {$outputPath}");
        $this->info("Total endpoints: {$stats['total']} | With real schema: {$stats['with_schema']} | Generic: {$stats['generic']}");

        return 0;
    }

    private function categorizeRoute(string $uri, string $action): ?string
    {
        $uri = strtolower($uri);
        $action = strtolower($action);

        if (str_contains($uri, '/api/partner')) {
            return 'Partner';
        }
        if (str_contains($uri, '/api/customer') || str_contains($uri, '/api/user')) {
            return 'Customer';
        }
        if (str_contains($uri, '/api/driver')) {
            return 'Driver';
        }
        if (str_starts_with($uri, '/admin/')) {
            return 'Admin';
        }
        if (str_starts_with($uri, '/api/')) {
            return 'Shared';
        }

        return null;
    }

    private function getRequestSchema(string $controllerClass, string $methodName, Route $route): ?array
    {
        try {
            $reflection = new ReflectionMethod($controllerClass, $methodName);
            foreach ($reflection->getParameters() as $param) {
                $type = $param->getType();
                if ($type instanceof ReflectionNamedType) {
                    $className = $type->getName();
                    if (class_exists($className) && is_subclass_of($className, FormRequest::class)) {
                        return $this->extractRulesFromFormRequest($className, $route);
                    }
                }
            }

            // No FormRequest found - try to extract inline validation from source
            return $this->extractInlineValidation($reflection);
        } catch (\Throwable $e) {
            // Ignore reflection errors
        }
        return null;
    }

    private function extractInlineValidation(ReflectionMethod $reflection): ?array
    {
        $filename = $reflection->getFileName();
        if (!$filename || !file_exists($filename)) {
            return null;
        }

        $startLine = $reflection->getStartLine();
        $endLine = $reflection->getEndLine();
        $lines = file($filename, FILE_IGNORE_NEW_LINES);
        $methodSource = implode("\n", array_slice($lines, $startLine - 1, $endLine - $startLine + 1));

        // Pattern 1: $request->validate([...])
        if (preg_match('/\$request\s*->\s*validate\s*\(\s*(\[[\s\S]+\])\s*\)/', $methodSource, $m)) {
            $rulesArray = $this->parseInlineRulesArray($this->extractBalancedArray($m[1]));
            if ($rulesArray) {
                return $this->convertRulesToSchema($rulesArray);
            }
        }

        // Pattern 2: Validator::make($request->all(), [...])
        if (preg_match('/Validator::make\s*\(\s*\$request->all\s*\(\s*\)\s*,\s*(\[[\s\S]+\])\s*\)/', $methodSource, $m)) {
            $rulesArray = $this->parseInlineRulesArray($this->extractBalancedArray($m[1]));
            if ($rulesArray) {
                return $this->convertRulesToSchema($rulesArray);
            }
        }

        // Pattern 3: $this->validate($request, [...])
        if (preg_match('/\$this\s*->\s*validate\s*\(\s*\$request\s*,\s*(\[[\s\S]+\])\s*\)/', $methodSource, $m)) {
            $rulesArray = $this->parseInlineRulesArray($this->extractBalancedArray($m[1]));
            if ($rulesArray) {
                return $this->convertRulesToSchema($rulesArray);
            }
        }

        return null;
    }

    private function extractBalancedArray(string $text): string
    {
        // Find the first '[' and extract balanced content
        $start = strpos($text, '[');
        if ($start === false) {
            return $text;
        }

        $depth = 0;
        $result = '';
        $len = strlen($text);
        for ($i = $start; $i < $len; $i++) {
            $char = $text[$i];
            if ($char === '[') {
                $depth++;
            } elseif ($char === ']') {
                $depth--;
            }
            $result .= $char;
            if ($depth === 0) {
                break;
            }
        }
        // Strip outer brackets
        return substr($result, 1, -1);
    }

    private function parseInlineRulesArray(string $arrayContent): ?array
    {
        // Try to eval the array content as PHP code
        // This works for simple rule arrays with string keys and string values
        $code = '<?php return [' . $arrayContent . '];';
        $value = @eval('?>' . $code);
        if (is_array($value)) {
            // Filter out non-string rule values (some may use Rule::in() etc which can't be eval'd)
            $cleanRules = [];
            foreach ($value as $field => $rules) {
                if (is_string($rules)) {
                    $cleanRules[$field] = $rules;
                } elseif (is_array($rules)) {
                    $cleanRules[$field] = $rules;
                }
            }
            return $cleanRules;
        }

        // Fallback: manually parse key => 'rules' pairs
        $rules = [];
        $pattern = "/['\"]([^'\"]+)['\"]\s*=>\s*['\"]([^'\"]+)['\"]/";
        if (preg_match_all($pattern, $arrayContent, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $m) {
                $rules[$m[1]] = $m[2];
            }
        }
        return !empty($rules) ? $rules : null;
    }

    private function extractRulesFromFormRequest(string $formRequestClass, Route $route): ?array
    {
        try {
            /** @var FormRequest $instance */
            $instance = new $formRequestClass();
            $instance->setRouteResolver(function () use ($route) {
                return $route;
            });
            $rules = $instance->rules();
            return $this->convertRulesToSchema($rules);
        } catch (\Throwable $e) {
            return null;
        }
    }

    private function convertRulesToSchema(array $rules): array
    {
        $properties = [];
        $required = [];

        foreach ($rules as $field => $fieldRules) {
            if (str_contains($field, '.*')) {
                continue;
            }

            if (is_object($fieldRules) && !($fieldRules instanceof \Illuminate\Contracts\Validation\ValidationRule)) {
                $fieldRules = [$fieldRules];
            }
            $fieldRules = is_array($fieldRules) ? $fieldRules : explode('|', $fieldRules);
            $schema = $this->rulesToOpenApiProperty($fieldRules);

            $properties[$field] = $schema;

            if ($this->isRequired($fieldRules)) {
                $required[] = $field;
            }
        }

        $schema = [
            'type' => 'object',
            'properties' => $properties,
        ];

        if (!empty($required)) {
            $schema['required'] = $required;
        }

        return $schema;
    }

    private function rulesToOpenApiProperty(array $rules): array
    {
        $schema = [];
        $isNullable = false;

        foreach ($rules as $rule) {
            if ($rule instanceof RequiredIf) {
                if (!isset($schema['type'])) {
                    $schema['type'] = 'string';
                }
                continue;
            }

            if ($rule instanceof In) {
                $values = $this->extractInRuleValues($rule);
                if ($values !== null) {
                    $schema['enum'] = $values;
                }
                if (!isset($schema['type'])) {
                    $schema['type'] = 'string';
                }
                continue;
            }

            if (is_object($rule)) {
                if (!isset($schema['type'])) {
                    $schema['type'] = 'string';
                }
                continue;
            }

            $rule = (string) $rule;

            if ($rule === 'required') {
                continue;
            }
            if ($rule === 'nullable' || $rule === 'sometimes') {
                $isNullable = true;
                continue;
            }
            if ($rule === 'string') {
                $schema['type'] = 'string';
                continue;
            }
            if ($rule === 'integer') {
                $schema['type'] = 'integer';
                continue;
            }
            if ($rule === 'numeric') {
                $schema['type'] = 'number';
                continue;
            }
            if ($rule === 'boolean') {
                $schema['type'] = 'boolean';
                continue;
            }
            if ($rule === 'array') {
                $schema['type'] = 'array';
                if (!isset($schema['items'])) {
                    $schema['items'] = ['type' => 'string'];
                }
                continue;
            }
            if ($rule === 'email') {
                $schema['type'] = 'string';
                $schema['format'] = 'email';
                continue;
            }
            if ($rule === 'uuid') {
                $schema['type'] = 'string';
                $schema['format'] = 'uuid';
                continue;
            }
            if ($rule === 'url') {
                $schema['type'] = 'string';
                $schema['format'] = 'uri';
                continue;
            }
            if ($rule === 'date') {
                $schema['type'] = 'string';
                $schema['format'] = 'date';
                continue;
            }
            if (str_starts_with($rule, 'date_format:')) {
                $schema['type'] = 'string';
                $schema['format'] = 'date-time';
                continue;
            }
            if (str_starts_with($rule, 'in:')) {
                $values = explode(',', substr($rule, 3));
                $schema['enum'] = $values;
                if (!isset($schema['type'])) {
                    $schema['type'] = 'string';
                }
                continue;
            }
            if (str_starts_with($rule, 'min:')) {
                $value = (float) substr($rule, 4);
                if (isset($schema['type']) && in_array($schema['type'], ['integer', 'number'])) {
                    $schema['minimum'] = $value;
                } else {
                    $schema['minLength'] = (int) $value;
                }
                continue;
            }
            if (str_starts_with($rule, 'max:')) {
                $value = (float) substr($rule, 4);
                if (isset($schema['type']) && in_array($schema['type'], ['integer', 'number'])) {
                    $schema['maximum'] = $value;
                } else {
                    $schema['maxLength'] = (int) $value;
                }
                continue;
            }
            if (str_starts_with($rule, 'size:')) {
                $value = (int) substr($rule, 5);
                if (isset($schema['type']) && $schema['type'] === 'array') {
                    $schema['minItems'] = $value;
                    $schema['maxItems'] = $value;
                } else {
                    $schema['minLength'] = $value;
                    $schema['maxLength'] = $value;
                }
                continue;
            }
            if (str_starts_with($rule, 'regex:')) {
                $pattern = substr($rule, 6);
                $schema['pattern'] = $pattern;
                if (!isset($schema['type'])) {
                    $schema['type'] = 'string';
                }
                continue;
            }
            if (in_array($rule, ['image', 'file']) || str_starts_with($rule, 'mimes:')) {
                $schema['type'] = 'string';
                $schema['format'] = 'binary';
                continue;
            }
            if (str_starts_with($rule, 'exists:') || str_starts_with($rule, 'unique:')) {
                if (!isset($schema['type'])) {
                    $schema['type'] = 'string';
                }
                continue;
            }
            if ($rule === 'json') {
                $schema['type'] = 'string';
                $schema['format'] = 'json';
                continue;
            }
            if ($rule === 'phone') {
                $schema['type'] = 'string';
                continue;
            }
        }

        if ($isNullable) {
            $schema['nullable'] = true;
        }

        if (!isset($schema['type'])) {
            $schema['type'] = 'string';
        }

        return $schema;
    }

    private function extractInRuleValues(In $rule): ?array
    {
        try {
            $ref = new \ReflectionClass($rule);
            $prop = $ref->getProperty('values');
            $prop->setAccessible(true);
            $values = $prop->getValue($rule);
            return array_map(fn($v) => trim((string) $v, '"\''), $values);
        } catch (\Throwable $e) {
            return null;
        }
    }

    private function isRequired(array $rules): bool
    {
        foreach ($rules as $rule) {
            if ($rule === 'required') {
                return true;
            }
            if ($rule instanceof RequiredIf) {
                return true;
            }
        }
        return false;
    }

    private function extractPathParams(string $uri): array
    {
        $params = [];
        preg_match_all('/\{([^}]+)\}/', $uri, $matches);
        foreach ($matches[1] as $param) {
            $param = rtrim($param, '?');
            $params[] = [
                'name' => $param,
                'in' => 'path',
                'required' => true,
                'schema' => ['type' => 'string'],
            ];
        }
        return $params;
    }

    private function buildOperation(
        string $method,
        string $category,
        string $methodName,
        string $controllerClass,
        array $pathParams,
        ?array $requestSchema,
        string $uri,
        array $middleware
    ): array {
        $summary = $this->humanizeMethodName($methodName);

        $op = [
            'tags' => [$category],
            'summary' => $summary,
            'operationId' => $category . '_' . $methodName . '_' . $method,
            'parameters' => $pathParams,
            'responses' => [
                '200' => ['description' => 'Successful response'],
                '401' => [
                    'description' => 'Unauthorized',
                    'content' => ['application/json' => ['schema' => ['$ref' => '#/components/schemas/Error']]],
                ],
                '404' => [
                    'description' => 'Not found',
                    'content' => ['application/json' => ['schema' => ['$ref' => '#/components/schemas/Error']]],
                ],
                '422' => [
                    'description' => 'Validation error',
                    'content' => ['application/json' => ['schema' => ['$ref' => '#/components/schemas/Error']]],
                ],
            ],
        ];

        if ($category === 'Partner') {
            $op['security'] = [['PartnerAuth' => [], 'PartnerSecret' => []]];
        } elseif (in_array('auth:api', $middleware) || in_array('auth:api-customer', $middleware) || in_array('auth:api-driver', $middleware)) {
            $op['security'] = [['BearerAuth' => []]];
        }

        if ($method === 'GET' && $requestSchema && !empty($requestSchema['properties'])) {
            foreach ($requestSchema['properties'] as $propName => $propSchema) {
                $op['parameters'][] = [
                    'name' => $propName,
                    'in' => 'query',
                    'required' => in_array($propName, $requestSchema['required'] ?? []),
                    'schema' => $propSchema,
                ];
            }
        }

        if (in_array($method, ['POST', 'PUT', 'PATCH'])) {
            if ($requestSchema) {
                $op['requestBody'] = [
                    'required' => true,
                    'content' => [
                        'application/json' => [
                            'schema' => $requestSchema,
                        ],
                    ],
                ];
            } else {
                $op['requestBody'] = [
                    'required' => true,
                    'content' => [
                        'application/json' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'payload' => [
                                        'type' => 'string',
                                        'description' => 'See source controller for exact fields',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ];
            }
        }

        return $op;
    }

    private function humanizeMethodName(string $method): string
    {
        $words = preg_replace('/(?<!^)[A-Z]/', ' $0', $method);
        return ucwords(trim($words));
    }

    private function buildSpec(array $paths): array
    {
        return [
            'openapi' => '3.0.3',
            'info' => [
                'title' => 'Xerin API Documentation',
                'description' => "API documentation for Driver, Customer, Partner, and Admin endpoints.\n\n- Customer and Driver paths are prefixed with `/api/` (Laravel API routes).\n- Partner paths are under `/api/partner/v1/`.\n- Admin paths are web routes served directly under the domain.",
                'version' => '1.0.0',
                'contact' => ['name' => 'Xerin Support'],
            ],
            'servers' => [
                ['url' => 'https://zerinexpress.com', 'description' => 'Production server'],
            ],
            'tags' => [
                ['name' => 'Customer', 'description' => 'Customer / User mobile app APIs'],
                ['name' => 'Driver', 'description' => 'Driver mobile app APIs'],
                ['name' => 'Partner', 'description' => 'Partner Delivery API - external systems create delivery orders, get quotes, track status, and receive webhooks'],
                ['name' => 'Admin', 'description' => 'Admin panel APIs'],
                ['name' => 'Shared', 'description' => 'Shared or common APIs'],
            ],
            'paths' => $paths,
            'components' => [
                'securitySchemes' => [
                    'BearerAuth' => [
                        'type' => 'http',
                        'scheme' => 'bearer',
                    ],
                    'PartnerAuth' => [
                        'type' => 'apiKey',
                        'in' => 'header',
                        'name' => 'X-API-KEY',
                        'description' => 'Partner API key',
                    ],
                    'PartnerSecret' => [
                        'type' => 'apiKey',
                        'in' => 'header',
                        'name' => 'X-API-SECRET',
                        'description' => 'Partner API secret',
                    ],
                ],
                'schemas' => [
                    'Error' => [
                        'type' => 'object',
                        'properties' => [
                            'message' => ['type' => 'string'],
                            'errors' => ['type' => 'object'],
                        ],
                    ],
                ],
            ],
        ];
    }
}
