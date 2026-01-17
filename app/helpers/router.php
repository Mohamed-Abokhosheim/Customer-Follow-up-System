<?php
class Router
{
    private static $routes = [];

    public static function add($route, $callback)
    {
        self::$routes[$route] = $callback;
    }

    public static function run()
    {
        $route = $_GET['route'] ?? 'dashboard';

        if ($route === 'login') {
            return self::call('AuthController@login');
        }

        Auth::check();

        if (array_key_exists($route, self::$routes)) {
            return self::call(self::$routes[$route]);
        } else {
            return self::call('DashboardController@index');
        }
    }

    private static function call($callback)
    {
        if (is_string($callback)) {
            list($controller, $method) = explode('@', $callback);
            require_once __DIR__ . "/../controllers/$controller.php";
            $instance = new $controller();
            return $instance->$method();
        }
        return call_user_func($callback);
    }
}
