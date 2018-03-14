<?php

namespace App\Controllers;


use App\Controller;
use App\Models\Course;

class CoursesController extends Controller
{
    public function index($request, $response, $args){
        return $this->view->render($response, 'dashboard/CoursesDashboard.twig');
    }

    public function addCourses($request, $response, $args){

        $data = $request->getParsedBody();

        $this->v->validate([
            'Name' => [$data['name'], 'required'],
            'credits' =>[$data['credits'], 'required'],
            'sem' =>[$data['sem'], 'required'],
            'year' =>[$data['year'], 'required'],
            'section' =>[$data['section'], 'required'],
        ]);

        if(!$this->v->passes()){
            $this->flash->addMessage('error', $this->v->errors()->first());
            return $this->redirect('getCoursesDashboard');
        }

        $courses = new Course();
        $courses->create([
            'name' => $data['name'],
            'credits' => $data['credits'],
            'sem' => $data['sem'],
            'year' => $data['year'],
            'sid' => $data['section']
        ]);

        $this->flash->addMessage('error', 'Cursul a fost adaugat!');
        return $this->redirect('getCoursesDashboard');
    }

    public function delete($request, $response, $args){

        $data = $request->getParsedBody();
        $this->db->table('grades')->where('course', '=', $data['id'])->delete();
        $this->db->table('courses')->where('id', '=', $data['id'])->delete();

        $this->flash->addMessage('error', 'Cursul a fost sters!');
        return $this->redirect('getCoursesDashboard');
    }
}