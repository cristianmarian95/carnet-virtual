<?php

namespace App\Controllers;


use App\Controller;

class AuthController extends Controller
{
    public function postLogin($request, $response, $args)
    {
        $data = $request->getParsedBody();

        $this->v->addFieldMessage('nrmatricol', 'required', 'Trebuie sa introduci numarul matricol.');
        $this->v->addFieldMessage('password', 'required', 'Trebuie sa introduci parola.');

        $this->v->validate([
            'nrmatricol' => [$data['nrmatricol'], 'required'],
            'password' =>[$data['password'], 'required']
        ]);

        if(!$this->v->passes()){
            $this->flash->addMessage('error', $this->v->errors()->first());
            return $this->redirect('getPortal');
        }

        $nrMatricol = filter_var($data['nrmatricol'], FILTER_SANITIZE_STRING);

        $user = $this->db->table('users')->where('username', '=', $nrMatricol)->first();

        if($user){
            if(password_verify($data['password'], $user->password)) {
                $this->session->set('uid', $user->id);
                $this->session->set('perms', $user->permission);
                return $this->redirect('getIndexDashboard');
            }else{
                $this->flash->addMessage('error', 'Parola introdusa nu corespunde cu utilizatorul resprectiv.');
                return $this->redirect('getPortal');
            }
        }else{
            $this->flash->addMessage('error', 'Utilizatorul nu a fost gasit in baza de date.');
            return $this->redirect('getPortal');
        }
    }

    public function logout(){
        $this->session->delete();
        return $this->redirect('getPortal');
    }
}
