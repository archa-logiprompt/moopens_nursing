<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Exam extends Admin_Controller {

    function __construct() {
        parent::__construct();
    }

    public function examclasses($id) {
        if (!$this->rbac->hasPrivilege('exam', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Examinations');
        $this->session->set_userdata('sub_menu', 'exam/index');
        $data['title'] = 'list of  Alloted';
        $exam = $this->exam_model->get($id);
        $data['exam'] = $exam;
        $classsectionList = $this->examschedule_model->getclassandsectionbyexam($id);
        $array = array();
        foreach ($classsectionList as $key => $value) {
            $s = array();
            $exam_id = $value['exam_id'];
            $class_id = $value['class_id'];
            $section_id = $value['section_id'];
            $result_prepare = $this->examresult_model->checkexamresultpreparebyexam($exam_id, $class_id, $section_id);
            $s['exam_id'] = $exam_id;
            $s['class_id'] = $class_id;
            $s['section_id'] = $section_id;
            $s['class'] = $value['class'];
            $s['section'] = $value['section'];
            if ($result_prepare) {
                $s['result_prepare'] = "yes";
            } else {
                $s['result_prepare'] = "no";
            }
            $array[] = $s;
        }
        $data['classsectionList'] = $array;
        $this->load->view('layout/header');
        $this->load->view('admin/exam/examClasses', $data);
        $this->load->view('layout/footer');
    }

    function index() {
        if (!$this->rbac->hasPrivilege('exam', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Examinations');
        $this->session->set_userdata('sub_menu', 'exam/index');
        $data['title'] = 'Add Exam';
        $data['title_list'] = 'Exam List';
		$class = $this->class_model->get();
        $data['classlist'] = $class;
        $this->form_validation->set_rules('exam_type', 'Exam type', 'trim|required|xss_clean');
        // $this->form_validation->set_rules('name','Name','is_unique[exams.name]');
        $this->form_validation->set_rules('name','Name');
		$this->form_validation->set_rules('class_id', 'Course', 'trim|required|xss_clean');
		$this->form_validation->set_rules('section_id', 'Section', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            
        } else {

        	$admin=$this->session->userdata('admin');
            $centre_id=$admin['centre_id'];
            $data = array(
            	'centre_id'=>$centre_id,
                'name' => $this->input->post('name'),
                'note' => $this->input->post('note'),
				'exam_type'=>$this->input->post('exam_type'),
				'class_id'=>$this->input->post('class_id'),
				'section_id'=>$this->input->post('section_id'),
				'sesion_id'=>$this->setting_model->getCurrentSession()
            );
            $this->exam_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Exam added successfully</div>');
            redirect('admin/exam/index');
        }
        $exam_result = $this->exam_model->get();
        $data['examlist'] = $exam_result;
        $this->load->view('layout/header', $data);
        $this->load->view('admin/exam/examList', $data);
        $this->load->view('layout/footer', $data);
    }

    function view($id) {
        if (!$this->rbac->hasPrivilege('exam', 'can_view')) {
            access_denied();
        }
        $data['title'] = 'Exam List';
        $exam = $this->exam_model->get($id);
        $data['exam'] = $exam;
        $this->load->view('layout/header', $data);
        $this->load->view('exam/examShow', $data);
        $this->load->view('layout/footer', $data);
    }

    function getByFeecategory() {
        $feecategory_id = $this->input->get('feecategory_id');
        $data = $this->feetype_model->getTypeByFeecategory($feecategory_id);
        echo json_encode($data);
    }

    function getStudentCategoryFee() {
        $type = $this->input->post('type');
        $class_id = $this->input->post('class_id');
        $data = $this->exam_model->getTypeByFeecategory($type, $class_id);
        if (empty($data)) {
            $status = 'fail';
        } else {
            $status = 'success';
        }
        $array = array('status' => $status, 'data' => $data);
        echo json_encode($array);
    }

    function delete($id) {
        if (!$this->rbac->hasPrivilege('exam', 'can_delete')) {
            access_denied();
        }
        $data['title'] = 'Exam List';
        $this->exam_model->remove($id);
        redirect('admin/exam/index');
    }

    function create() {
        if (!$this->rbac->hasPrivilege('exam', 'can_add')) {
            access_denied();
        }
        $data['title'] = 'Add Exam';
        $this->form_validation->set_rules('exam', 'Exam', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('exam/examCreate', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'exam' => $this->input->post('exam'),
                'note' => $this->input->post('note'),
            );
            $this->exam_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Exam added successfully</div>');
            redirect('exam/index');
        }
    }

    function edit($id) {
        if (!$this->rbac->hasPrivilege('exam', 'can_edit')) {
            access_denied();
        }
        $data['title'] = 'Edit Exam';
        $data['id'] = $id;
        $exam = $this->exam_model->get($id);
        $data['exam'] = $exam;
        $data['title_list'] = 'Exam List';
        $exam_result = $this->exam_model->get();
        $data['examlist'] = $exam_result;
		$class = $this->class_model->get();
        $data['classlist'] = $class;
        $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/exam/examEdit', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'id' => $id,
                'name' => $this->input->post('name'),
                'note' => $this->input->post('note'),
				'exam_type'=>$this->input->post('exam_type'),
				'class_id'=>$this->input->post('class_id'),
				'section_id'=>$this->input->post('section_id')
            );
            $this->exam_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Exam update successfully</div>');
            redirect('admin/exam/index');
        }
    }

    function examSearch() {
        $data['title'] = 'Search exam';
        if ($this->input->server('REQUEST_METHOD') == "POST") {
            $search = $this->input->post('search');
            if ($search == "search_filter") {
                $data['exp_title'] = 'exam Result From ' . $this->input->post('date_from') . " To " . $this->input->post('date_to');
                $date_from = date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date_from')));
                $date_to = date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date_to')));
                $resultList = $this->exam_model->search("", $date_from, $date_to);
                $data['resultList'] = $resultList;
            } else {
                $data['exp_title'] = 'exam Result';
                $search_text = $this->input->post('search_text');
                $resultList = $this->exam_model->search($search_text, "", "");
                $data['resultList'] = $resultList;
            }
            $this->load->view('layout/header', $data);
            $this->load->view('admin/exam/examSearch', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/exam/examSearch', $data);
            $this->load->view('layout/footer', $data);
        }
    }
	
	function get_examtype()
	{
		
		$class_id=$this->input->post('class_id');
		$section_id=$this->input->post('section_id');
		$exam_result = $this->exam_model->get_exam($class_id,$section_id);
        echo json_encode($exam_result);
		
	}
	
	
	
	
	

}

?>