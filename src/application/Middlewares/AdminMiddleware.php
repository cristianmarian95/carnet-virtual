<?php

namespace App\Middlewares;

use App\Middleware;

class AdminMiddleware extends Middleware
{
    public function __invoke($request, $response, $next)
    {
        if(isset($_SESSION['uid']) && isset($_SESSION['perms']) && $_SESSION['perms'] == 1) {
            return $next($request, $response);
        }
        return $response->withRedirect($this->router->pathFor('getIndexDashboard'));
    }
}