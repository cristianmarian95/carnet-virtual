<?php

namespace App\Middlewares;


use App\Middleware;

class LogedMiddleware extends Middleware
{

    public function __invoke($request, $response, $next)
    {
        if(isset($_SESSION['uid'])){
            return $response->withRedirect($this->router->pathFor('getIndexDashboard'));
        }
        return $next($request, $response);
    }
}