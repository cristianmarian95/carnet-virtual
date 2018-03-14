<?php

namespace App\Controllers;

use App\Controller;

class DashboardController extends Controller
{
    public function index($request, $response, $args){
        return $this->view->render($response, 'dashboard/indexDashboard.twig');
    }

    public function note($request, $response, $args) {
        return $this->view->render($response, 'dashboard/noteDashboard.twig');
    }

    public function facultati($request, $response, $args) {
        return $this->view->render($response, 'dashboard/facultatiDashboard.twig');
    }
}