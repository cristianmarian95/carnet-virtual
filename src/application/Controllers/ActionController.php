<?php

namespace App\Controllers;


use App\Controller;
use App\Models\Allocation;
use App\Models\College;
use App\Models\Section;

class ActionController extends Controller
{
    /*
     * Facultati
     */
    public function addFacultate($request, $response, $args){

        $data = $request->getParsedBody();
        $this->v->addFieldMessage('facultate', 'required', 'Trebuie sa introduci numele facultatii.');
        $this->v->validate(['facultate' => [$data['facultate'], 'required']]);

        if(!$this->v->passes()){
            $this->flash->addMessage('error', $this->v->errors()->first());
            return $this->redirect('getFacultatiDashboard');
        }

        $college = new College();
        $college->create(['name' => $data['facultate']]);
        $this->flash->addMessage('error', 'Facultatea ' . $data['facultate'] . ' a fost adaugata!');
        return $this->redirect('getFacultatiDashboard');

    }


    public function deleteFacultate($request, $response, $args){

        $data = $request->getParsedBody();
        $this->v->addFieldMessage('facultate', 'required', 'Unknow error.');

        $this->v->validate(['college' => [$data['college'], 'required']]);

        if(!$this->v->passes()){
            $this->flash->addMessage('error', $this->v->errors()->first());
            return $this->redirect('getFacultatiDashboard');
        }

        $results = $this->db->table('allocations')->where('college', '=', $data['college'])->get();

        foreach ($results as $result){
            $this->db->table('users')->where('allocation', '=', $result->id)->delete();
        }

        foreach ($results as $result)
        {
            $courses = $this->db->table('courses')->where('sid', '=', $result->id)->get();
            foreach ($courses as $course)
            {
                $this->db->table('grades')->where('course', '=', $course->id)->delete();
            }
            $this->db->table('courses')->where('sid', '=', $result->id)->delete();
        }

        $this->db->table('allocations')->where('college', '=', $data['college'])->delete();
        $this->db->table('colleges')->where('id', '=', $data['college'])->delete();

        $this->flash->addMessage('error', 'Facultatea a fost stearsa!');
        return $this->redirect('getFacultatiDashboard');
    }


    /*
     * Sectii
     */
    public function addSectiune($request, $response, $args) {
        $data = $request->getParsedBody();
        $this->v->addFieldMessage('sectiune', 'required', 'Trebuie sa introduci numele sectiunii.');
        $this->v->validate(['sectiune' => [$data['sectiune'], 'required']]);

        if(!$this->v->passes()){
            $this->flash->addMessage('error', $this->v->errors()->first());
            return $this->redirect('getFacultatiDashboard');
        }

        $section = new Section();
        $section->create(['name' => $data['sectiune']]);
        $this->flash->addMessage('error', 'Sectiunea ' . $data['sectiune'] . ' a fost adaugata!');
        return $this->redirect('getFacultatiDashboard');
    }


    public function deleteSectiune($request, $response, $args) {

        $data = $request->getParsedBody();
        $this->v->addFieldMessage('facultate', 'required', 'Unknow error.');

        $this->v->validate(['section' => [$data['section'], 'required']]);

        if(!$this->v->passes()){
            $this->flash->addMessage('error', $this->v->errors()->first());
            return $this->redirect('getFacultatiDashboard');
        }

        $results = $this->db->table('allocations')->where('section', '=', $data['section'])->get();

        foreach ($results as $result){
            $this->db->table('users')->where('allocation', '=', $result->id)->delete();
        }

        foreach ($results as $result)
        {
            $courses = $this->db->table('courses')->where('sid', '=', $result->id)->get();
            foreach ($courses as $course)
            {
                $this->db->table('grades')->where('course', '=', $course->id)->delete();
            }
            $this->db->table('courses')->where('sid', '=', $result->id)->delete();
        }

        $this->db->table('allocations')->where('section', '=', $data['section'])->delete();
        $this->db->table('sections')->where('id', '=', $data['section'])->delete();

        $this->flash->addMessage('error', 'Sectia a fost stearsa!');
        return $this->redirect('getFacultatiDashboard');
    }

    /*
    * Atribuire
    */
    public function addAtribuire($request, $response, $args) {
        $data = $request->getParsedBody();
        $this->v->addFieldMessage('college', 'required', 'Trebuie sa selectezi o facultate.');
        $this->v->addFieldMessage('section', 'required', 'Trebuie sa selectezi o sectiune.');
        $this->v->validate([
            'college' => [$data['college'], 'required'],
            'section' => [$data['section'], 'required']
        ]);

        if(!$this->v->passes()){
            $this->flash->addMessage('error', $this->v->errors()->first());
            return $this->redirect('getFacultatiDashboard');
        }

        $results = $this->db->table('allocations')->where('college', '=', $data['college'])->get();
        if($results){
            foreach ($results as $result) {
                if ($result->section == $data['section']) {
                    $this->flash->addMessage('error', 'Sectiunea ' . $this->functions->getSection($data['section']) . ' este deja alocata facultatii ' . $this->functions->getCollege($data['college']) . ' !');
                    return $this->redirect('getFacultatiDashboard');
                }
            }
        }

        $allocation = new Allocation();
        $allocation->create([
            'college' => $data['college'],
            'section' => $data['section']
        ]);
        $this->flash->addMessage('error', 'Sectiunea ' . $this->functions->getSection($data['section']) . ' a fost alocata facultatii ' . $this->functions->getCollege($data['college']) . ' !');
        return $this->redirect('getFacultatiDashboard');
    }

    public function deleteatribuire($request, $response, $args) {

        $data = $request->getParsedBody();
        $this->v->addFieldMessage('allocation', 'required', 'Unknow error.');

        $this->v->validate(['allocation' => [$data['allocation'], 'required']]);

        if(!$this->v->passes()){
            $this->flash->addMessage('error', $this->v->errors()->first());
            return $this->redirect('getFacultatiDashboard');
        }

        $results = $this->db->table('allocations')->where('id', '=', $data['allocation'])->get();

        foreach ($results as $result){
            $this->db->table('users')->where('allocation', '=', $result->id)->delete();
        }

        foreach ($results as $result)
        {
            $courses = $this->db->table('courses')->where('sid', '=', $result->id)->get();
            foreach ($courses as $course)
            {
                $this->db->table('grades')->where('course', '=', $course->id)->delete();
            }
            $this->db->table('courses')->where('sid', '=', $result->id)->delete();
        }

        $this->db->table('allocations')->where('id', '=', $data['allocation'])->delete();

        $this->flash->addMessage('error', 'Sectia a fost stearsa!');
        return $this->redirect('getFacultatiDashboard');

    }

    /*
     * Update user info
     */

    public function postUpdateStudent($request, $response, $args){

        $data = $request->getParsedBody();

        $this->v->addFieldMessage('name', 'required', 'Numele studentului este necesar.');
        $this->v->addFieldMessage('lastname', 'required', 'Prenumele studentului este necesar.');
        $this->v->addFieldMessage('year', 'required', 'Anul studentului este necesar.');
        $this->v->addFieldMessage('section', 'required', 'Sectia de repartizare studentului este necesara.');


        $this->v->validate([
            'name' => [$data['name'], 'required'],
            'lastname' =>[$data['lastname'], 'required'],
            'year' =>[$data['year'], 'required'],
            'section' =>[$data['section'], 'required']
        ]);


        if(!$this->v->passes()){
            $this->flash->addMessage('error', $this->v->errors()->first());
            $response->withRedirect($this->router->pathFor('getStatsStudent', ['id' => $data['username']]));
        }
        $this->db->table('users')->where('username',$data['username'])
            ->update([
                'name' => $data['name'],
                'lastname' => $data['lastname'],
                'year' => $data['year'],
                'allocation' => $data['section'],
            ]);

        $this->flash->addMessage('error', $this->v->errors()->first());
        return $response->withRedirect($this->router->pathFor('getStatsStudent', ['id' => $data['username']]));
    }
}