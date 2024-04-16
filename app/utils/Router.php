<?php

namespace App\utils;


use http\Exception\InvalidArgumentException;

final class Router
{
    private static array $routes = [];

    public  static function loadRoutes()
    {
        $uri = $_SERVER["REQUEST_METHOD"].' /'.$_GET["q"];
        $methodExist = key_exists($uri,self::$routes) && method_exists(
                self::$routes[$uri]["controller"],
                self::$routes[$uri]["action"]
            );
        ($methodExist)?
            $response = self::loadRoute($uri):
            $response = Response::notFoundErr();
        echo $response;
    }

    public static function delete(string $uri, string $controller, string $action)
    {
        $params = array_slice($_GET,1);
        self::$routes["DELETE ".$uri] = [
            "controller" => $controller,
            "action" => $action,
            "params" => $params
        ];
    }

    public static function patch(string $uri, string $controller, string $action)
    {
        $params = array_slice($_GET,1);
        self::$routes["PATCH ".$uri] = [
            "controller" => $controller,
            "action" => $action,
            "params" => $params
        ];
    }

    public static function get(string $uri, string $controller, string $action)
    {
        $params = array_slice($_GET,1);
        self::$routes["GET ".$uri] = [
            "controller" => $controller,
            "action" => $action,
            "params" => $params
        ];
    }

    public static function post(string $uri, string $controller, string $action)
    {
        $params = array_slice($_GET,1);
        self::$routes["POST ".$uri] = [
            "controller" => $controller,
            "action" => $action,
            "params" => $params
        ];
    }

    private static function loadRoute(string $uri):bool|string
    {
        $controller = self::$routes[$uri]["controller"];
        $action = self::$routes[$uri]["action"];
        $params = self::$routes[$uri]["params"];
        $data = match ($_SERVER["REQUEST_METHOD"]) {
            "DELETE" => self::requestHandler($controller,"delete",$params),
            "PATCH" => self::requestHandler($controller,"update",$params),
            default => self::requestHandler($controller,$action,$params)
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