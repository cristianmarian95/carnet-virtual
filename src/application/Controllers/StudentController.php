<?php

namespace App\Controllers;


use \App\Controller;
use App\Models\Users;

class StudentController extends Controller
{
    public function index($request, $response, $args){
        return $this->view->render($response, 'dashboard/usersDashboard.twig');
    }

    public function addUser($request, $response, $args){
        $data = $request->getParsedBody();

        $this->v->addFieldMessage('name', 'required', 'Numele studentului este necesar.');
        $this->v->addFieldMessage('lastname', 'required', 'Prenumele studentului este necesar.');
        $this->v->addFieldMessage('username', 'required', 'Numarul matricol al studentului este necesar.');
        $this->v->addFieldMessage('year', 'required', 'Anul studentului este necesar.');
        $this->v->addFieldMessage('section', 'required', 'Sectia de repartizare studentului este necesara.');


        $this->v->validate([
            'name' => [$data['name'], 'required'],
            'lastname' =>[$data['lastname'], 'required'],
            'username' =>[$data['username'], 'required'],
            'year' =>[$data['year'], 'required'],
            'section' =>[$data['section'], 'required'],
        ]);

        if(!$this->v->passes()){
            $this->flash->addMessage('error', $this->v->errors()->first());
            return $this->redirect('getUserDashboard');
        }

        $result = $this->db->table('users')->where('username','=', $data['username'])->first();

        if($result){
            $this->flash->addMessage('error', 'Studentul cu numarul matricol ' . $data['username'] . ' exista deja');
            return $this->redirect('getUserDashboard');
        }

        $password = password_hash('1234', PASSWORD_DEFAULT);

        $user = new Users();
        $user->create([
            'username' => $data['username'],
            'password' => $password,
            'name' => $data['name'],
            'lastname' => $data['lastname'],
            'year' => $data['year'],
            'allocation' => $data['section'],
            'permission' => 0
        ]);

        $this->flash->addMessage('error', 'Studentul a fost adaugat.');
        return $this->redirect('getUserDashboard');
    }
}