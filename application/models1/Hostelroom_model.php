<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Hostelroom_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
    }

    /**
     * This funtion takes id as a parameter and will fetch the record.
     * If id is not provided, then it will fetch all the records form the table.
     * @param int $id
     * @return mixed
     */
    public function get($id = null) {

        $admin=$this->session->userdata('admin');
        $this->db->select()->from('hostel_rooms');
        $this->db->where('centre_id',$admin['centre_id']);
        if ($id != null) {
            $this->db->where('id', $id);
        } else {
            $this->db->order_by('id');
        }
        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }

    /**
     * This function will delete the record based on the id
     * @param $id
     */
    public function remove($id) {
        $this->db->where('id', $id);
        $this->db->delete('hostel_rooms');
    }

    public function getRoomByHoselID($hostel_id) {
        $this->db->select('hostel_rooms.*,room_types.room_type');
        $this->db->from('hostel_rooms');
        $this->db->join('room_types', 'hostel_rooms.room_type_id = room_types.id');
        $this->db->where('hostel_rooms.hostel_id', $hostel_id);
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * This function will take the post data passed from the controller
     * If id is present, then it will do an update
     * else an insert. One function doing both add and edit.
     * @param $data
     */
    public function add($data) {
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('hostel_rooms', $data);
        } else {
            $this->db->insert('hostel_rooms', $data);
            return $this->db->insert_id();
        }
    }

    public function lists() {
        $admin=$this->session->userdata('admin');
        $this->db->select('hostel_rooms.*,b.hostel_name,c.room_type');
        $this->db->from('hostel_rooms');
        $this->db->join('hostel b', 'b.id=hostel_rooms.hostel_id');
        $this->db->join('room_types c', 'c.id=hostel_rooms.room_type_id');
        $this->db->where('hostel_rooms.centre_id',$admin['centre_id']);
        $listroomtype = $this->db->get();
        return $listroomtype->result_array();
    }

    public function studentHostelDetails($carray = null) {
        
        $admin=$this->session->userdata('admin');
        $userdata = $this->customlib->getUserData();

        if (($userdata["role_id"] == 2) && ($userdata["class_teacher"] == "yes")) {
            if (!empty($carray)) {

                $this->db->where_in("student_session.class_id", $carray);
            } else {
                $this->db->where_in("student_session.class_id", "");
            }
        }
        $query = $this->db->select('students.firstname,students.id as sid,students.guardian_phone,students.admission_no,classes.class,sections.section,students.lastname,students.mobileno,hostel_rooms.*,hostel.hostel_name,room_types.room_type')->join('student_session', 'students.id = student_session.student_id')->join('sections', 'sections.id = student_session.section_id')->join('classes', 'classes.id = student_session.class_id')->join('hostel_rooms', 'hostel_rooms.id = students.hostel_room_id')->join('hostel', 'hostel.id = hostel_rooms.hostel_id')->join('room_types', 'room_types.id = hostel_rooms.room_type_id')->where('students.is_active', 'yes')->where('students.centre_id',$admin['centre_id'])->get("students");

        return $query->result_array();
    }

    public function searchHostelDetails($section_id, $class_id, $hostel_name = "") {
       
       $admin=$this->session->userdata('admin');
        if (!empty($hostel_name)) {

            $condition = array('student_session.section_id' => $section_id, 'student_session.class_id' => $class_id, 'hostel.hostel_name' => $hostel_name, 'students.is_active' => 'yes');
        } else {
            $condition = array('student_session.section_id' => $section_id, 'student_session.class_id' => $class_id, 'students.is_active' => 'yes');
        }
        $query = $this->db->select('students.firstname,students.id as sid, students.admission_no,,students.guardian_phone,classes.class,sections.section,students.lastname,students.mobileno,hostel_rooms.*,hostel.hostel_name,room_types.room_type')->join('student_session', 'students.id = student_session.student_id')->join('sections', 'sections.id = student_session.section_id')->join('classes', 'classes.id = student_session.class_id')->join('hostel_rooms', 'hostel_rooms.id = students.hostel_room_id')->join('hostel', 'hostel.id = hostel_rooms.hostel_id')->join('room_types', 'room_types.id = hostel_rooms.room_type_id')->where('students.centre_id',$admin['centre_id'])->where($condition)->get("students");

        return $query->result_array();
    }

}
