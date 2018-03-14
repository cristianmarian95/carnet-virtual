<?php

namespace App\Controllers;

use \App\Controller;

class PortalController extends Controller
{
    public function index($request, $response, $args)
    {
        return $this->view->render($response, 'portal/index.twig');
    }

    public function portal(){
        return $this->redirect('getPortal');
    }
}