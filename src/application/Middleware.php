<?php

namespace App;

class Middleware {

    //Private value
    private $container;

    public function __construct($container)
    {
        //Set container
        $this->container = $container;
    }

    public function __get($property)
    {
        //Check if the property is set
        if (isset($this->container->{$property})){
            //Return property
            return $this->container->{$property};
        }
        return null;
    }

    public function redirect($routeName = '')
    {
        return $this->response->withRedirect($this->router->pathFor($routeName));
    }
}