<?php

namespace App\Controllers;


use App\Controller;
use App\Models\Users;

class InstallController extends Controller
{
    public function index(){

        if($this->db->schema()->hasTable('users')){
            return $this->redirect('getPortal');
        }

        $this->db->schema()->create('users', function($table){
            $table->increments('id');
            $table->string('name');
            $table->string('lastname');
            $table->string('username', 256);
            $table->string('password', 256);
            $table->integer('year');
            $table->integer('allocation');
            $table->integer('permission');
            $table->timestamps();
        });

        if($this->db->schema()->hasTable('courses')){
            return $this->redirect('getPortal');
        }

        $this->db->schema()->create('courses', function($table){
            $table->increments('id');
            $table->integer('sid');
            $table->string('name', 256);
            $table->integer('credits');
            $table->integer('year');
            $table->integer('sem');
            $table->timestamps();
        });


        if($this->db->schema()->hasTable('grades')){
            return $this->redirect('getPortal');
        }

        $this->db->schema()->create('grades', function($table){
            $table->increments('id');
            $table->integer('user');
            $table->integer('course');
            $table->decimal('grade');
            $table->timestamps();
        });


        if($this->db->schema()->hasTable('sections')){
            return $this->redirect('getPortal');
        }

        $this->db->schema()->create('sections', function($table){
            $table->increments('id');
            $table->string('name', 256);
            $table->timestamps();
        });


        if($this->db->schema()->hasTable('colleges')){
            return $this->redirect('getPortal');
        }

        $this->db->schema()->create('colleges', function($table){
            $table->increments('id');
            $table->string('name', 256);
            $table->timestamps();
        });


        if($this->db->schema()->hasTable('allocations')){
            return $this->redirect('getPortal');
        }

        $this->db->schema()->create('allocations', function ($table) {
            $table->increments('id');
            $table->integer('college');
            $table->integer('section');
            $table->timestamps();
        });

        $admin = new Users();
        $admin->create([
            'username' => 'admin',
            'name' => 'Administrator',
            'lastname' => 'Administrator',
            'year' => '',
            'allocation' => '',
            'permission' => 1,
            'password' => password_hash('1234', PASSWORD_DEFAULT)
        ]);

        $this->flash->addMessage('error', 'Aplicatia a fost instalata cu succes!');
        return $this->redirect('getPortal');

    }
}