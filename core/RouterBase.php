<?php
namespace core;

use \src\Config;

class RouterBase {

    public function run($routes) {
        $method = Request::getMethod();
        $url = Request::getUrl();

        $controller = Config::ERROR_CONTROLLER;
        $action = Config::DEFAULT_ACTION;
        $args = [];

        if(isset($routes[$method])) {
            foreach($routes[$method] as $route => $callback) {
                $pattern = preg_replace('(\{[a-z0-9]{1,}\})', '([a-z0-9-]{1,})', $route);

                if(preg_match('#^('.$pattern.')*$#i', $url, $matches) === 1) {
                    array_shift($matches);
                    array_shift($matches);

                    $itens = array();
                    if(preg_match_all('(\{[a-z0-9]{1,}\})', $route, $m)) {
                        $itens = preg_replace('(\{|\})', '', $m[0]);
                    }

                    $args = array();
                    foreach($matches as $key => $match) {
                        $args[$itens[$key]] = $match;
                    }

                    $callbackSplit = explode('@', $callback);
                    $controller = $callbackSplit[0];
                    if(isset($callbackSplit[1])) {
                        $action = $callbackSplit[1];
                    }

                    break;
                }
            }
        }

        $controller = "\src\controllers\\$controller";
        $definedController = new $controller();

        $definedController->$action($args);
    }
    
}