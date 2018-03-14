<?php
/* =============== Redirect route ================== */
$app->get('/', 'Portal:portal');

/* =============== Portal  Routes ================== */
$app->group('/portal', function() {
    $this->get('/', 'Portal:index')->setName('getPortal');
    $this->post('/postlogin', 'Auth:postLogin')->setName('postLogin');
})->add(new \App\Middlewares\LogedMiddleware($app->getContainer()));

/* =============== User Routes ================== */
$app->group('/user', function () {
    $this->get('/', 'Dashboard:index')->setName('getIndexDashboard');
    $this->get('/grades', 'Dashboard:note')->setName('getNoteDashboard');
    $this->get('/logout', 'Auth:logout')->setName('logout');
})->add(new App\Middlewares\LoginMiddleware($app->getContainer()));

/* =============== Admin Routes ================= */
$app->group('/admin', function() {
    $this->get('/colleges', 'Dashboard:facultati')->setName('getFacultatiDashboard');
    $this->get('/members', 'Student:index')->setName('getUserDashboard');
    $this->get('/courses', 'Courses:index')->setName('getCoursesDashboard');
    $this->get('/search', 'Grades:index')->setName('getGradesIndexDashboard');
    $this->get('/search/user[/{id}]', 'Grades:getUser')->setName('getGradesUserDashboard');
    $this->get('/stats', 'Statistici:index')->setName('getStatisticiDashdoard');

    $this->group('/stats', function () {
        $this->get('/sections[/{id}]', 'Statistici:collegeSections')->setName('getStatsSections');
        $this->get('/courses[/{id}/{section}]', 'Statistici:sectionCourses')->setName('getStatsCourses');
        $this->get('/students[/{id}/{section}]', 'Statistici:sectionStudents')->setName('getStatsStudents');
        $this->get('/student[/{id}]', 'Statistici:getStudentInfo')->setName('getStatsStudent');
    })->add(new App\Middlewares\StatsMiddleware($this->getContainer()));

    $this->post('/stats/list/students', 'Statistici:postSectionStudents')->setName('postStatsStudents');
    $this->post('/stats/list/courses', 'Statistici:postSectionCourses')->setName('postStatsCourses');

    $this->group('/actions', function (){
        $this->post('/add/college', 'Actions:addFacultate')->setName('postAddFacultate');
        $this->post('/delete/college', 'Actions:deleteFacultate')->setName('postDeleteFacultate');
        $this->post('/add/section', 'Actions:addSectiune')->setName('postAddSectiune');
        $this->post('/delete/section', 'Actions:deleteSectiune')->setName('postDeleteSectiune');
        $this->post('/add/allocation', 'Actions:addAtribuire')->setName('postAddAtribuire');
        $this->post('/delete/allocation', 'Actions:deleteAtribuire')->setName('postDeleteAtribuire');
        $this->post('/add/user', 'Student:addUser')->setName('postAddUser');
        $this->post('/add/courses', 'Courses:addCourses')->setName('postAddCourses');
        $this->post('/delete/courses', 'Courses:delete')->setName('postDeleteCourses');
        $this->post('/update/grades', 'Grades:updateUser')->setName('postUpdateGrades');
        $this->post('/update/user', 'Actions:postUpdateStudent')->setName('postUpdateStudent');
    });

})->add(new \App\Middlewares\AdminMiddleware($app->getContainer()));

/*=================== SetUP routes ==================*/
$app->get('/setup/database', 'Install:index');