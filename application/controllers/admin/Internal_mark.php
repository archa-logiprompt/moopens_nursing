<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Internal_mark extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('InternalMark_model');
    }

    function index()
    {
        if (!$this->rbac->hasPrivilege('internal_mark_type', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'internal_marks');
        $this->session->set_userdata('sub_menu', 'internal_marks/internal_mark_types');
        $class = $this->class_model->get();
        $data['classlist'] = $class;
        $internalGroup = $this->InternalMark_model->get();
        $data['internalGroup'] = $internalGroup;

        $this->form_validation->set_rules('type', 'Type', 'trim|required|xss_clean');
        $this->form_validation->set_rules('mark_type', 'Mark Type', 'trim|required|xss_clean');
        $this->form_validation->set_rules('sub_type', 'Sub Type', 'trim|required|xss_clean');
        $this->form_validation->set_rules('class_id', 'Class', 'trim|required|xss_clean');
        $this->form_validation->set_rules('section_id', 'Section', 'trim|required|xss_clean');
        $this->form_validation->set_rules('max_mark', 'Max Mark', 'trim|required|xss_clean');
        $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/internal_mark/internal_mark_type', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $session = $this->setting_model->getCurrentSession();

            // Check if the combination already exists
            $exists = $this->InternalMark_model->checkExisting(
                $this->input->post('name'),
                $this->input->post('class_id'),
                $this->input->post('section_id'),
                $session
            );

            if ($exists) {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">This combination of Name, Class, Section, and Session already exists.</div>');
                redirect('admin/internal_mark/index');
            } else {
                // Insert the new record
                $insert_array = array(
                    'type' => $this->input->post('type'),
                    'mark_type' => $this->input->post('mark_type'),
                    'sub_type' => $this->input->post('sub_type'),
                    'class_id' => $this->input->post('class_id'),
                    'section_id' => $this->input->post('section_id'),
                    'max_mark' => $this->input->post('max_mark'),
                    'name' => $this->input->post('name'),
                    'subject_id' => $this->input->post('subject_id'),

                    'session_id' => $session,
                );
                $this->InternalMark_model->add($insert_array);

                $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Type added</div>');
                redirect('admin/internal_mark/index');
            }
        }
    }

    public function delete($id)
    {
        $this->InternalMark_model->delete($id);
        $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Type Deleted</div>');
        redirect('admin/internal_mark/index');
    }


    public function edit($id)
    {
        if (!$this->rbac->hasPrivilege('internal_mark_types', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'internal_marks');
        $this->session->set_userdata('sub_menu', 'internal_marks/internal_mark_types');
        $class = $this->class_model->get();
        $data['classlist'] = $class;
        $data['type'] = $this->InternalMark_model->get($id);
        $internalGroup = $this->InternalMark_model->get();
        $data['internalGroup'] = $internalGroup;


        $this->form_validation->set_rules('type', 'Type', 'trim|required|xss_clean');
        $this->form_validation->set_rules('mark_type', 'Mark Type', 'trim|required|xss_clean');
        $this->form_validation->set_rules('sub_type', 'Sub Type', 'trim|required|xss_clean');
        $this->form_validation->set_rules('class_id', 'Class', 'trim|required|xss_clean');
        $this->form_validation->set_rules('section_id', 'Section', 'trim|required|xss_clean');
        $this->form_validation->set_rules('max_mark', 'Max Mark', 'trim|required|xss_clean');
        $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');


        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/internal_mark/internal_mark_type_edit', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $insert_array = array(
                'id' => $id,
                'type' => $this->input->post('type'),
                'mark_type' => $this->input->post('mark_type'),
                'sub_type' => $this->input->post('sub_type'),
                'class_id' => $this->input->post('class_id'),
                'section_id' => $this->input->post('section_id'),
                'max_mark' => $this->input->post('max_mark'),
                'name' => $this->input->post('name'),
            );
            $this->InternalMark_model->add($insert_array);

            $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Type Edited</div>');
            redirect('admin/internal_mark/index');
        }
    }

    public function internal_report()
    {
        if (!$this->rbac->hasPrivilege('internal_report', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'internal_marks');
        $this->session->set_userdata('sub_menu', 'internal_marks/internal_report');
        $class = $this->class_model->get();
        $data['classlist'] = $class;



        $this->form_validation->set_rules('class_id', 'Class', 'trim|required|xss_clean');
        $this->form_validation->set_rules('section_id', 'Section', 'trim|required|xss_clean');
        $this->form_validation->set_rules('type', 'Type', 'trim|required|xss_clean');


        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/internal_mark/internal_report', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $session = $this->setting_model->getCurrentSession();

            // $array = array(
            //     'type' => $this->input->post('type'),
            //     'class_id' => $this->input->post('class_id'),
            //     'section_id' => $this->input->post('section_id'),
            //     'section_id' => $session

            // );
            $type = $this->input->post('type');
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');
            $subject_id = $this->input->post('subject_id');
            $session_id = $session;

            $data['sub_type'] = $type;

            if ($type == "practical") {


                $data['attendance'] = $this->InternalMark_model->getClinicalAttendance($class_id, $section_id, $session_id, $subject_id);
                $data['marks'] = $this->InternalMark_model->getInternalMarks($class_id, $section_id, $session_id, $subject_id);
                $data['clinical'] = $this->InternalMark_model->getClinicalMarks($class_id, $section_id, $session_id, $subject_id);
                $data['eo5'] = $this->InternalMark_model->getEO5Marks($class_id, $section_id, $session_id, $subject_id);
                $data['pc'] = $this->InternalMark_model->getPcMarks($class_id, $section_id, $session_id, $subject_id);
                $data['os'] = $this->InternalMark_model->getOsMarks($class_id, $section_id, $session_id, $subject_id);
                $data['dop'] = $this->InternalMark_model->getDopMarks($class_id, $section_id, $session_id, $subject_id);
            }

            if ($type == "theory") {
                $data['attendance'] = $this->InternalMark_model->getTheoryAttendance($class_id, $section_id, $session_id, $subject_id);
                $data['marks'] = $this->InternalMark_model->getTheoryMarks($class_id, $section_id, $session_id, $subject_id);
                $data['sm'] = $this->InternalMark_model->getSMMarks($class_id, $section_id, $session_id, $subject_id);
                $data['mt1'] = $this->InternalMark_model->getmt1Marks($class_id, $section_id, $session_id, $subject_id);
                $data['mt2'] = $this->InternalMark_model->getmt2Marks($class_id, $section_id, $session_id, $subject_id);
                $data['pj'] = $this->InternalMark_model->getpjMarks($class_id, $section_id, $session_id, $subject_id);
                $data['mm'] = $this->InternalMark_model->getmmMarks($class_id, $section_id, $session_id, $subject_id);
                $data['unit_test'] = $this->InternalMark_model->getunittestMarks($class_id, $section_id, $session_id, $subject_id);
                $data['sessional'] = $this->InternalMark_model->getsessionalMarks($class_id, $section_id, $session_id, $subject_id);

            }

            $data['result'] = true;
            $this->load->view('layout/header', $data);
            $this->load->view('admin/internal_mark/internal_report', $data);
            $this->load->view('layout/footer', $data);
        }
    }

    function add_internal_mark()
    {

        if (!$this->rbac->hasPrivilege('add_internal_mark', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'internal_marks');
        $this->session->set_userdata('sub_menu', 'internal_marks/add_internal_mark');
        $class = $this->class_model->get();
        $data['classlist'] = $class;
        $data['type'] = "";




        $this->form_validation->set_rules('class_id', 'Class', 'trim|required|xss_clean');
        $this->form_validation->set_rules('section_id', 'Section', 'trim|required|xss_clean');
        $this->form_validation->set_rules('type', 'Type', 'trim|required|xss_clean');


        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/internal_mark/add_internal_mark', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $session = $this->setting_model->getCurrentSession();

            // $array = array(
            //     'type' => $this->input->post('type'),
            //     'class_id' => $this->input->post('class_id'),
            //     'section_id' => $this->input->post('section_id'),
            //     'section_id' => $session

            // );
            $type = $this->input->post('type');
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');
            $session_id = $session;

            $data['type'] = $type;
            $data['class_id'] = $class_id;
            $data['section_id'] = $section_id;
            $type_details = $this->InternalMark_model->get($type);
            $data['type_name'] = $type_details->name;
            $data['max_mark'] = $type_details->max_mark;
            $data['students'] = $this->InternalMark_model->getStudents($class_id, $section_id, $session_id, $type);
            
            $data['result'] = true;
            $this->load->view('layout/header', $data);
            $this->load->view('admin/internal_mark/add_internal_mark', $data);
            $this->load->view('layout/footer', $data);
        }
    }

    function getTypebyClassSection()
    {
        $class_id = $this->input->post('class_id');
        $section_id = $this->input->post('section_id');
        $subject_id = $this->input->post('subject_id');
        $session_id = $this->setting_model->getCurrentSession();

        $result = $this->InternalMark_model->getTypebyClassSection($class_id, $section_id, $session_id, $subject_id);
        echo json_encode($result);
    }

    function add_mark()
    {
        $session_id = $this->setting_model->getCurrentSession();
        $student_id = $this->input->post('student_id');
        $exist_id = $this->input->post('exist_id');
        $class_id = $this->input->post('class_id');
        $section_id = $this->input->post('section_id');
        $type_id = $this->input->post('type_id');
        $mark = $this->input->post('mark');
        foreach ($student_id as $key => $id) {
            $arr = array(
                'session_id' => $session_id,
                'class_id' => $class_id,
                'section_id' => $section_id,
                'student_id' => $id,
                'type_id' => $type_id,
                'marks' => $mark[$key],

            );

            $this->InternalMark_model->addMark($arr, $exist_id[$key]);
        }
        $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Internal Mark Added</div>');
        redirect('admin/internal_mark/add_internal_mark');
    }
}
