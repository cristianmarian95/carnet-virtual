<?php

namespace App\Controllers;

use App\Controller;
use App\Models\Grade;

class GradesController extends Controller
{
    public function index($request, $response, $args){
        return $this->view->render($response, 'dashboard/GradesIndexDashboard.twig');
    }

    public function getUser($request, $response, $args){
        if(isset($_GET['id'])){
            $id = $_GET['id'];
        }else if(isset($args['id'])){
            $id = $args['id'];
        }else{
            return $this->redirect('getGradesIndexDashboard');
        }

        return $this->view->render($response, 'dashboard/getUserGrades.twig', ['user' => $this->getUserInfo($id)]);
    }

    public function updateUser($request, $response, $args){

        $data = $request->getParsedBody();

        $this->v->validate([
            'grade' => [$data['grade'], 'required|int|min(1, number)|max(10, number)'],
            'user' =>[$data['uid'], 'required']
        ]);

        $user = $this->db->table('users')->where('id','=',$data['uid'])->first();

        if(!$this->v->passes()){
            $this->flash->addMessage('error', $this->v->errors()->first());
            return $response->withRedirect($this->router->pathFor('getGradesUserDashboard', ['id' => $user->username]));
        }

        $getGrades = $this->db->table('grades')->where('user', $user->id)->get();

        if($getGrades){
           foreach ($getGrades as $grade){
               if($grade->course == $data['course']){
                   $result = $this->db->table('grades')->where('user',$user->id)->where('course',$data['course'])->update(['grade' => $data['grade']]);
                   if($result) {
                       $this->flash->addMessage('error', 'Nota a fost actualizata.');
                       return $response->withRedirect($this->router->pathFor('getGradesUserDashboard', ['id' => $user->username]));
                   }else{
                       return var_dump($result);
                   }
               }
           }
        }

        $grades = new Grade();
        $grades->create([
            'user' => $user->id,
            'course' => $data['course'], //id curs
            'grade' => $data['grade']
        ]);

        $this->flash->addMessage('error', 'Nota a fost actualizata.');
        return $response->withRedirect($this->router->pathFor('getGradesUserDashboard', ['id' => $user->username]));


    }

    public function getUserInfo($key){
        return $this->db->table('users')->where('username','=',$key)->first();
    }
}