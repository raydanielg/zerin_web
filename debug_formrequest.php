<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle($request = Illuminate\Http\Request::capture());

$class = 'Modules\\AuthManagement\\Http\\Requests\\AuthApiRequest';
$base = app('request');
echo "Base request class: " . get_class($base) . "\n";
$instance = new $class();
echo "Instance class: " . get_class($instance) . "\n";

$route = null;
foreach (app('router')->getRoutes() as $r) {
    if ($r->uri() === 'customer/auth/login') {
        $route = $r;
        break;
    }
}
if ($route) {
    echo "Route found: " . $route->uri() . "\n";
    $instance->setRouteResolver(function () use ($route) {
        return $route;
    });
} else {
    echo "Route not found\n";
}

try {
    $rules = $instance->rules();
    echo "Rules:\n";
    print_r($rules);
} catch (Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
