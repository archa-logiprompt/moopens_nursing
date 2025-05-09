<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Hostelroom extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->library('Customlib');
        $this->load->model("classteacher_model");
    }

    public function index()
    {
        if (!$this->rbac->hasPrivilege('hostel_rooms', 'can_view')) {
            access_denied();
        }
        $roomtypelist = $this->roomtype_model->get();
        $data['roomtypelist'] = $roomtypelist;
        $hostellist = $this->hostel_model->get();
        $data['hostellist'] = $hostellist;
        $this->session->set_userdata('top_menu', 'Hostel');
        $this->session->set_userdata('sub_menu', 'hostelroom/index');

        $hostelroomlist = $this->hostelroom_model->lists();
        $data['hostelroomlist'] = $hostelroomlist;
        $this->load->view('layout/header');
        $this->load->view('admin/hostelroom/create', $data);
        $this->load->view('layout/footer');
    }

    function create()
    {
        if (!$this->rbac->hasPrivilege('hostel_rooms', 'can_add')) {
            access_denied();
        }
        $roomtypelist = $this->roomtype_model->get();
        $data['roomtypelist'] = $roomtypelist;
        $hostellist = $this->hostel_model->get();
        $data['hostellist'] = $hostellist;
        $data['title'] = 'Add Library';
        $hostelroomlist = $this->hostelroom_model->lists();
        $data['hostelroomlist'] = $hostelroomlist;
        $this->form_validation->set_rules('hostel_id', 'Hostel', 'trim|required|xss_clean');
        $this->form_validation->set_rules('room_type_id', 'Room Type', 'trim|required|xss_clean');

        $this->form_validation->set_rules('room_no', 'Room No', 'trim|required|xss_clean');
        $this->form_validation->set_rules('no_of_bed', 'No of Bed', 'trim|required|xss_clean');
        $this->form_validation->set_rules('cost_per_bed', 'Cost Per Bed', 'trim|required|xss_clean');

        $room_no = $this->input->post('room_no');
        $hostel_id = $this->input->post('hostel_id');
        $exist = $this->db->select('*')->join('hostel', 'hostel.id=hostel_rooms.hostel_id')->where('hostel.id', $hostel_id)->where('room_no', $room_no)->get('hostel_rooms')->row();



        $hostellist = $this->hostel_model->get();
        $data['hostellist'] = $hostellist;
        $roomtypelist = $this->roomtype_model->get();
        $data['roomtypelist'] = $roomtypelist;
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header');
            $this->load->view('admin/hostelroom/create', $data);
            $this->load->view('layout/footer');
        } else {

            if ($exist) {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger text-left">Hostel Room already Exists</div>');
                redirect('admin/hostelroom/index');
            }
            $admin = $this->session->userdata('admin');

            $data = array(
                'centre_id' => $admin['centre_id'],
                'hostel_id' => $this->input->post('hostel_id'),
                'room_type_id' => $this->input->post('room_type_id'),
                'room_no' => $this->input->post('room_no'),
                'no_of_bed' => $this->input->post('no_of_bed'),
                'cost_per_bed' => $this->input->post('cost_per_bed'),
                'description' => $this->input->post('description'),
            );
            $this->hostelroom_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Hostel Room added successfully</div>');
            redirect('admin/hostelroom/index');
        }
    }

    function getRoom()
    {
        $hosel_id = $this->input->get('hostel_id');
        $data = $this->hostelroom_model->getRoomByHoselID($hosel_id);
        echo json_encode($data);
    }

    function edit($id)
    {
        if (!$this->rbac->hasPrivilege('hostel_rooms', 'can_edit')) {
            access_denied();
        }
        $data['title'] = 'Add Hostel';
        $data['id'] = $id;
        $hostellist = $this->hostel_model->get();
        $data['hostellist'] = $hostellist;
        $roomtypelist = $this->roomtype_model->get();
        $data['roomtypelist'] = $roomtypelist;
        $hostelroom = $this->hostelroom_model->get($id);
        $data['hostelroom'] = $hostelroom;
        $hostelroomlist = $this->hostelroom_model->lists();
        $data['hostelroomlist'] = $hostelroomlist;
        $this->form_validation->set_rules('hostel_id', 'Hostel', 'trim|required|xss_clean');
        $this->form_validation->set_rules('room_type_id', 'Room Type', 'trim|required|xss_clean');
        $this->form_validation->set_rules('room_no', 'Room No', 'trim|required|xss_clean');
        $this->form_validation->set_rules('no_of_bed', 'No of Bed', 'trim|required|xss_clean');
        $this->form_validation->set_rules('cost_per_bed', 'Cost Per Bed', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header');
            $this->load->view('admin/hostelroom/edit', $data);
            $this->load->view('layout/footer');
        } else {
            $data = array(
                'id' => $this->input->post('id'),
                'hostel_id' => $this->input->post('hostel_id'),
                'room_type_id' => $this->input->post('room_type_id'),
                'room_no' => $this->input->post('room_no'),
                'no_of_bed' => $this->input->post('no_of_bed'),
                'cost_per_bed' => $this->input->post('cost_per_bed'),
                'description' => $this->input->post('description'),
            );
            $this->hostelroom_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Hostel Room updated successfully</div>');
            redirect('admin/hostelroom/index');
        }
    }

    function delete($id)
    {
        if (!$this->rbac->hasPrivilege('hostel_rooms', 'can_delete')) {
            access_denied();
        }
        $data['title'] = 'Fees Master List';
        $this->hostelroom_model->remove($id);
        redirect('admin/hostelroom/index');
    }

    function studenthosteldetails()
    {

        $this->session->set_userdata('top_menu', 'Hostel');
        $this->session->set_userdata('sub_menu', 'admin/hostelroom/studenthosteldetails');
        $data['title'] = 'Student Hostel Details';
        $class = $this->class_model->get();
        $data['classlist'] = $class;
        $userdata = $this->customlib->getUserData();
        $carray = array();
        //    if(($userdata["role_id"] == 2) && ($userdata["class_teacher"] == "yes")){
        // $data["classlist"] =   $this->customlib->getClassbyteacher($userdata["id"]);
        if (!empty($data["classlist"])) {
            foreach ($data["classlist"] as $ckey => $cvalue) {

                $carray[] = $cvalue["id"];
            }
        }

        // }
        $section_id = $this->input->post("section_id");
        $class_id = $this->input->post("class_id");
        $hostel_name = $this->input->post("hostel_name");

        $this->form_validation->set_rules('class_id', 'Class', 'trim|required|xss_clean');
        $this->form_validation->set_rules('section_id', 'Section', 'trim|required|xss_clean');

        $hostellist = $this->hostel_model->get();
        $data['hostellist'] = $hostellist;
        if ($this->form_validation->run() == FALSE) {

            // $details = $this->hostelroom_model->studentHostelDetails($carray);
            // $data["resultlist"] = $details;
        } else {

            $details = $this->hostelroom_model->searchHostelDetails($section_id, $class_id, $hostel_name);
            $data["resultlist"] = $details;
        }

        $this->load->view("layout/header", $data);
        $this->load->view("admin/hostelroom/studenthosteldetails", $data);
        $this->load->view("layout/footer", $data);
    }

}

?>