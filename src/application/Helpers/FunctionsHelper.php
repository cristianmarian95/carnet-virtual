<?php

namespace App\Helpers;

use App\Helpers;

class FunctionsHelper extends Helpers
{
    /**
     * Function for get number of students
     * @param $allocationID
     * @return mixed
     */
    public function getStudentsNr($allocationID){
        return $this->db->table('users')->where('allocation', $allocationID)->count();
    }

    /**
     * Function to get total number of students
     * @param $collegeID
     * @return int|mixed
     */

    public function getStudentsTotalNr($collegeID){
        $allocations = $this->db->table('allocations')->where('college',$collegeID)->get();
        $count = 0;

        foreach ($allocations as $allocation){
            $users = $this->getStudentsNr($allocation->id);
            $count = $count + $users;
        }

        return $count;
    }

    /**
     * Function to get collage name
     * @param $collegeID
     * @return mixed
     */
    public function getCollege($collegeID)
    {
        $result = $this->db->table('colleges')->where('id', $collegeID)->first();
        return $result->name;
    }

    /**
     * Function to get section name
     * @param $sectionID
     * @return mixed
     */
    public function getSection($sectionID)
    {
        $result = $this->db->table('sections')->where('id', $sectionID)->first();
        return $result->name;
    }

    /**
     * Function to get collage id
     * @param $allocationID
     * @return mixed
     */
    public function getCollegeID($allocationID){
        $result = $this->db->table('allocations')->where('id', $allocationID)->first();
        return $result->college;
    }

    /**
     * Function to get section id
     * @param $allocationID
     * @return mixed
     */
    public function getSectionID($allocationID){
        $result = $this->db->table('allocations')->where('id', $allocationID)->first();
        return $result->section;
    }

    /**
     * Function to get courses list
     * @param $allocationID
     * @return mixed
     */
    public function getCourses($allocationID){
        return $this->db->table('courses')->where('sid', $allocationID)->get();
    }

    /**
     * Function to get the grade
     * @param $courseID
     * @param $userID
     * @return mixed
     */
    public function getGrades($courseID, $userID) {
        $result = $this->db->table('grades')->where('user', $userID)->where('course', $courseID)->first();
        if($result){
            return $result->grade;
        }

    }
}