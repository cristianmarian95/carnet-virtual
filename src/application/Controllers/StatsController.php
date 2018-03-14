<?php

namespace App\Controllers;


use App\Controller;

class StatsController extends Controller
{
    public function index($request, $response, $args){
        return $this->view->render($response, 'dashboard/collageList.twig');
    }

    public function collegeSections($request, $response, $args){
        $sections = $this->db->table('allocations')->where('college', $args['id'])->get();
        return $this->view->render($response, 'dashboard/stats/sectionsList.twig', ['collegeSections' => $sections, 'college' => $args['id']]);
    }

    public function sectionStudents($request, $response, $args){
        return $this->view->render($response, 'dashboard/stats/selectStudentsYear.twig', ['college' => $args['id'], 'section' => $args['section']]);
    }

    public function postSectionStudents($request, $response, $args){

        $data = $request->getParsedBody();

        $this->v->validate(['year' => [$data['year'], 'required|int|min(1, number)|max(4, number)']]);

        if(!$this->v->passes()){
            $this->flash->addMessage('error', $this->v->errors()->first());
            return $response->withRedirect($this->router->pathFor('getStatsStudents', ['id' => $data['college'], 'section' => $data['section']]));
        }
        $allocation = $this->db->table('allocations')->where('college',$data['college'])->where('section',$data['section'])->first();
        $students = $this->db->table('users')->where('year',$data['year'])->where('allocation',$allocation->id)->get();

        return $this->view->render($response, 'dashboard/stats/studentsList.twig', ['students' => $students]);

    }

    public function sectionCourses($request, $response, $args){
        return $this->view->render($response, 'dashboard/stats/selectCoursesType.twig', ['college' => $args['id'], 'section' => $args['section']]);
    }

    public function postSectionCourses($request, $response, $args){

        $data = $request->getParsedBody();

        $this->v->validate(['year' => [$data['year'], 'required|int|min(1, number)|max(4, number)']]);

        if(!$this->v->passes()){
            $this->flash->addMessage('error', $this->v->errors()->first());
            return $response->withRedirect($this->router->pathFor('getStatsCourses', ['id' => $data['college'], 'section' => $data['section']]));
        }

        $allocation = $this->db->table('allocations')->where('college',$data['college'])->where('section',$data['section'])->first();
        $courses = $this->db->table('courses')->where('sid', $allocation->id)->where('year', $data['year'])->get();

        return $this->view->render($response, 'dashboard/stats/coursesList.twig', ['courses' => $courses]);
    }

    public function getStudentInfo($request, $response, $args){
        $student = $this->db->table('users')->where('username',$args['id'])->first();
        if($student) {
            return $this->view->render($response, 'dashboard/stats/studentInfo.twig', ['student' => $student]);
        }

    }

}