<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Stdtransfer extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("classteacher_model");
    }

    function index() {
        if (!$this->rbac->hasPrivilege('promote_student', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Academics');
        $this->session->set_userdata('sub_menu', 'stdtransfer/index');
        $data['title'] = 'Exam Schedule';
        $class = $this->class_model->get('', $classteacher = 'yes');
        $data['classlist'] = $class;
        $userdata = $this->customlib->getUserData();

        //    if(($userdata["role_id"] == 2) && ($userdata["class_teacher"] == "yes")){
        //  $data["classlist"] =   $this->customlib->getclassteacher($userdata["id"]);
        // }

        $feecategory = $this->feecategory_model->get();
        $data['feecategorylist'] = $feecategory;
        $this->form_validation->set_rules('class_id', 'Class', 'trim|required|xss_clean');
        $this->form_validation->set_rules('section_id', 'Section', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/stdtransfer/stdtransfer', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $class = $this->input->post('class_id');
            $section = $this->input->post('section_id');
            $session_result = $this->session_model->get();
            $data['sessionlist'] = $session_result;
            $data['class_post'] = $class;
            $data['section_post'] = $section;
            $resultlist = $this->student_model->searchByClassSection($class, $section);
            $data['resultlist'] = $resultlist;
            $this->load->view('layout/header', $data);
            $this->load->view('admin/stdtransfer/stdtransfer', $data);
            $this->load->view('layout/footer', $data);
        }
    }

    public function promote() {
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('session_id', 'Session', 'required|trim|xss_clean');
        $this->form_validation->set_rules('class_promote_id', 'Class', 'required|trim|xss_clean');
        $this->form_validation->set_rules('section_promote_id', 'Section', 'required|trim|xss_clean');
        if ($this->form_validation->run() == false) {
            $errors = array(
                'session_id' => form_error('session_id'),
                'class_promote_id' => form_error('class_promote_id'),
                'section_promote_id' => form_error('section_promote_id')
            );
            echo json_encode(array('status' => 'fail', 'msg' => $errors));
        } else {
            $student_list = $this->input->post('student_list');
			$feeyear=$this->input->post('feeyear');
            foreach ($student_list as $key => $value) {
                $student_id = $value;
                $result = $this->input->post('result_' . $value);
                $session_status = $this->input->post('next_working_' . $value);
                if ($result == "pass" && $session_status == "countinue") {
                    $promoted_class = $this->input->post('class_promote_id');
                    $promoted_section = $this->input->post('section_promote_id');
                    $promoted_session = $this->input->post('session_id');
                    $data_new = array(
                        'student_id' => $student_id,
                        'class_id' => $promoted_class,
                        'section_id' => $promoted_section,
                        'session_id' => $promoted_session,
                        'transport_fees' => 0,
                        'fees_discount' => 0
                    );
                    $insert_id=$this->student_model->add_student_session($data_new);
					$class_post = $this->input->post('class_post');
					$section_post = $this->input->post('section_post');
					$remark=$this->input->post('remarks_'.$value);
					
					$remarks=array(
					'student_id'=>$student_id,
					'class_id'=>$class_post ,
					'section_id'=> $section_post,
					'remarks'=>$remark
					);
					
					$this->student_model->add_remarks($remarks);
					
					
						
					/*$promote_fee=$this->studentfeemaster_model->promote_fee($feeyear,$promoted_class,$promoted_section);
					
					$data_promote=array(
					'student_session_id'=>$insert_id,
					'fee_session_group_id'=>$promote_fee['fee_session_group_id'],
					'student_id'=>$student_id
					
					);*/
					
					//$this->studentfeemaster_model->add_promote($data_promote);
					
                } elseif ($result == "fail" && $session_status == "countinue") {
                    $promoted_session = $this->input->post('session_id');
                    //$class_post = $this->input->post('class_post');
					 $promoted_class = $this->input->post('class_promote_id');
                    $promoted_section = $this->input->post('section_promote_id');
                    //$section_post = $this->input->post('section_post');
					
                    $data_new = array(
                        'student_id' => $student_id,
                        'class_id' => $promoted_class,
                        'section_id' => $promoted_section,
                        'session_id' => $promoted_session,
                        'transport_fees' => 0,
                        'fees_discount' => 0
                    );
                    // var_dump( $data_new);exit;
                    $this->student_model->add_student_session($data_new);
                }
            }
            echo json_encode(array('status' => 'success', 'msg' => ""));
        }
    }

}

?>