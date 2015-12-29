<?php
namespace Old\Milantex\Core;
/**
 * A class that creates a Route object used to handle routing
 */
class Route {
    private $pattern;
    private $methods;
    private $callable;

    private function __construct(string $pattern, array $methods, $callable) {
        $this->pattern  = '#^' . str_replace('#', '\\#', $pattern) . '/*$#';
        $this->methods  = $methods;
        $this->callable = $callable;
    }

    public static function get(string $pattern, $callable): Route {
        return new Route($pattern, ['GET'], $callable);
    }

    public static function post(string $pattern, $callable): Route {
        return new Route($pattern, ['POST'], $callable);
    }

    public static function getOrPost(string $pattern, $callable): Route {
        return new Route($pattern, ['GET', 'POST'], $callable);
    }

    public function matches(string $method, string $url) {
        if (!in_array($method, $this->methods)) {
            return false;
        }

        return boolval(preg_match($this->pattern, $url));
    }

    public function execute(Context &$context) {
        call_user_func_array($this->callable, [ &$context ]);
    }
}
