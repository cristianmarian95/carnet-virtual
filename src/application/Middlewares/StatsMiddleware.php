<?php

namespace App\Middlewares;


use App\Middleware;

class StatsMiddleware extends Middleware
{
    public function __invoke($request, $response, $next)
    {
        $args = $request->getAttribute('routeInfo')[2];
        if(isset($args['id'])){
            return $next($request, $response);
        }
        return $response->withRedirect($this->router->pathFor('getStatisticiDashdoard'));
    }
}