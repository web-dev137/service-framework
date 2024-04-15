<?php

namespace App\utils;


use http\Exception\InvalidArgumentException;

final class Router
{
    private static array $routes = [];
    public static function route(string $uri, string $controller, string $action)
    {
        $params = array_slice($_GET,1);
        self::$routes[$uri] = [
            "controller" => $controller,
            "action" => $action,
            "params" => $params
        ];
    }

    public  static function loadRoutes()
    {
        $uri = $_SERVER["REQUEST_METHOD"].' /'.$_GET["q"];
        $methodExist = key_exists($uri,self::$routes) && method_exists(
                self::$routes[$uri]["controller"],
                self::$routes[$uri]["action"]
            );
        ($methodExist)?
            $response = self::callAction($uri):
            $response = Response::notFoundErr();
        echo $response;
    }

    private static function callAction(string $uri): bool|string
    {
        $route = self::$routes[$uri];
        $c = $route["controller"];
        $a = $route["action"];

        $data = match ($_SERVER["REQUEST_METHOD"]) {
            "DELETE" => self::requestHandler($c,"delete",$route["params"]),
            "PATCH" => self::requestHandler($c,"update",$route["params"]),
            default => self::requestHandler($c,$a,$route["params"])
        };
        return json_encode($data);
    }

    /**
     * @throws \Exception
     */
    private static function requestHandler($class, $method, $params)
    {
        $err = false;
        $res = '';
        try {
            $res = ($params) ? call_user_func_array([(new $class), $method], $params)
                : call_user_func([(new $class), $method]);
        } catch (\TypeError $e) {
            $err = Response::badRequest($e->getMessage());
        }
        return ($err)?:$res;
    }

}