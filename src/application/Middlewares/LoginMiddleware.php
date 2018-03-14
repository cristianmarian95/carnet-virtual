<?php

namespace App\Middlewares;

use App\Middleware;

class LoginMiddleware extends Middleware
{
    public function __invoke($request, $response, $next)
    {
        if(isset($_SESSION['uid'])){
            return $next($request, $response);
        }
        return $response->withRedirect($this->router->pathFor('getPortal'));
    }
}