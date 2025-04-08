<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Masterrotation extends Admin_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->load->model("classteacher_model");
        $this->load->model('Timetablenew_model');
        $this->load->helper('lang');

    }

    public function index()
    {
        if (!$this->rbac->hasPrivilege('class_timetable', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Academics');
        $this->session->set_userdata('sub_menu', 'masterrotation/index');
        $session = $this->setting_model->getCurrentSession();
        $data['title'] = 'Exam Marks';
        $data['exam_id'] = "";
        $data['class_id'] = "";
        $data['section_id'] = "";
        $exam = $this->exam_model->get();
        $class = $this->class_model->get();
        $data['examlist'] = $exam;
        $data['classlist'] = $class;
        $userdata = $this->customlib->getUserData();

        $data['week_days'] = $this->getweeks(3, 2023);
        // var_dump($week['week 4']);
        // exit;
        $data['is_search'] = false;
        $data['date'] = date('Y');

        $this->form_validation->set_rules('class_id', 'Course', 'trim|required|xss_clean');
        $this->form_validation->set_rules('section_id', 'Section', 'trim|required|xss_clean');
        $this->form_validation->set_rules('date', 'Date', 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/masterrotationplan/masterrotation', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');
            $year = $this->input->post('date');

            $data['is_search'] = true;

            $data['year'] = $year;
            $data['date'] = $year;

            

            $data['class_id'] = $class_id;
            $data['section_id'] = $section_id;

            $data['class_name'] = $this->db->select('class')->where('id', $class_id)->get('classes')->row()->class;
            $data['section_name'] = $this->db->select('section')->where('id', $section_id)->get('sections')->row()->section;
  
            $weeks = array();

            $year =$year;
            // Create a new DateTime object for the start of the year
            $start_date = new DateTime("$year-01-01");

            // Loop through 52 weeks, adding each week's start and end dates to the array
            for ($i = 1; $i <= 52; $i++) {
            // Calculate the start and end dates for the current week
            $start_week = clone $start_date;
            $start_week->modify('+' . ($i - 1) . ' weeks');
            $end_week = clone $start_date;
            $end_week->modify('+' . $i . ' weeks -1 day');

            // Check if the end week is in a different month than the start week
            if ($end_week->format('m') != $start_week->format('m')) {
                // Get the last day of the month for the end week's month
                $last_day = cal_days_in_month(CAL_GREGORIAN, $end_week->format('m'), $end_week->format('Y'));
                
                // If the end week is in December, set the end date to December 31st
                if ($end_week->format('m') == '12') {
                $end_week->setDate($end_week->format('Y'), $end_week->format('m'), '31');
                } else {
                // Otherwise, set the end date to the last day of the month
                $end_week->modify("-" . ($end_week->format('d') - $last_day) . " days");
                }
            }
            
            // Add the start and end dates to the weeks array
            $weeks[] = array(
                'start_date' => $start_week->format('Y-m-d'),
                'end_date' => $end_week->format('Y-m-d')
            );
            }

            $weeks[51]=[
                'start_date' => '2023-12-24',
                'end_date' => '2023-12-31' 
            ];

            $data['weeks'] = $weeks;


            $where_array = [
                 
                'section_id' => $section_id,
                'class_id' => $class_id,
            ];


            $data['plan_items'] = $this->db->get('masterrotation_items')->result_array();
            $event_colors = array("#ffadad", "#ffd6a5", "#fdffb6", "#caffbf", "#9bf6ff", "#a0c4ff",
            "#bdb2ff", "#ffc6ff","#ffadad", "#ffd6a5", "#fdffb6", "#caffbf", "#9bf6ff", "#a0c4ff",
            "#bdb2ff", "#ffc6ff","#ffadad", "#ffd6a5", "#fdffb6", "#caffbf", "#9bf6ff", "#a0c4ff",
            "#bdb2ff", "#ffc6ff","#ffadad", "#ffd6a5", "#fdffb6", "#caffbf", "#9bf6ff", "#a0c4ff",
            "#bdb2ff", "#ffc6ff","#ffadad", "#ffd6a5", "#fdffb6", "#caffbf", "#9bf6ff", "#a0c4ff",
            "#bdb2ff", "#ffc6ff");


            foreach ($data['plan_items'] as $key => $value) {
                $data['plan_items'][$key]['color'] = $event_colors[$key];
            }



            $getcalendar = [
                'year'=>$year,
                'section_id' => $section_id,
                'class_id' => $class_id,
            ];


            $calendarupdate = $this->db->where($getcalendar)->get('masterrotation')->row();

            // $calendarupdate = json_decode(json_encode($calendarupdate), true);

            $data['calendar'] = $calendarupdate; 

            $this->load->view('layout/header', $data);
            $this->load->view('admin/masterrotationplan/masterrotation', $data);
            $this->load->view('layout/footer', $data);
        }
    }
    public function create()
    {
        if (!$this->rbac->hasPrivilege('class_timetable', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Academics');
        $this->session->set_userdata('sub_menu', 'masterrotation/index');
        $session = $this->setting_model->getCurrentSession();
        $data['title'] = 'Exam Marks';
        $data['exam_id'] = "";
        $data['class_id'] = "";
        $data['section_id'] = "";
        $exam = $this->exam_model->get();
        $class = $this->class_model->get();
        $data['examlist'] = $exam;
        $data['classlist'] = $class;
        $userdata = $this->customlib->getUserData();

        $data['week_days'] = $this->getweeks(3, 2023);
        // var_dump($week['week 4']);
        // exit;
        $data['is_search'] = false;
        $data['date'] = date('Y');

        $this->form_validation->set_rules('class_id', 'Course', 'trim|required|xss_clean');
        $this->form_validation->set_rules('section_id', 'Section', 'trim|required|xss_clean'); 
        if ($this->form_validation->run() == false) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/masterrotationplan/masterrotationcreate', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');
            $year = $this->input->post('date');

            $data['is_search'] = true;

            $data['year'] = $year;
            $data['date'] = $year;

            

            $data['class_id'] = $class_id;
            $data['section_id'] = $section_id;

            $data['class_name'] = $this->db->select('class')->where('id', $class_id)->get('classes')->row()->class;
            $data['section_name'] = $this->db->select('section')->where('id', $section_id)->get('sections')->row()->section;
  
            $weeks = array();

            $year =$year;
            // Create a new DateTime object for the start of the year
            $start_date = new DateTime("$year-01-01");

            // Loop through 52 weeks, adding each week's start and end dates to the array
            for ($i = 1; $i <= 52; $i++) {
            // Calculate the start and end dates for the current week
            $start_week = clone $start_date;
            $start_week->modify('+' . ($i - 1) . ' weeks');
            $end_week = clone $start_date;
            $end_week->modify('+' . $i . ' weeks -1 day');

            // Check if the end week is in a different month than the start week
            if ($end_week->format('m') != $start_week->format('m')) {
                // Get the last day of the month for the end week's month
                $last_day = cal_days_in_month(CAL_GREGORIAN, $end_week->format('m'), $end_week->format('Y'));
                
                // If the end week is in December, set the end date to December 31st
                if ($end_week->format('m') == '12') {
                $end_week->setDate($end_week->format('Y'), $end_week->format('m'), '31');
                } else {
                // Otherwise, set the end date to the last day of the month
                $end_week->modify("-" . ($end_week->format('d') - $last_day) . " days");
                }
            }
            
            // Add the start and end dates to the weeks array
            $weeks[] = array(
                'start_date' => $start_week->format('Y-m-d'),
                'end_date' => $end_week->format('Y-m-d')
            );
            }

            $weeks[51]=[
                'start_date' => '2023-12-24',
                'end_date' => '2023-12-31' 
            ];

            $data['weeks'] = $weeks;

            $where_array = [
                 
                'section_id' => $section_id,
                'class_id' => $class_id,
            ];






            $data['plan_items'] = $this->db->get('masterrotation_items')->result_array();
            $event_colors = array("#ffadad", "#ffd6a5", "#fdffb6", "#caffbf", "#9bf6ff", "#a0c4ff",
            "#bdb2ff", "#ffc6ff","#ffadad", "#ffd6a5", "#fdffb6", "#caffbf", "#9bf6ff", "#a0c4ff",
            "#bdb2ff", "#ffc6ff","#ffadad", "#ffd6a5", "#fdffb6", "#caffbf", "#9bf6ff", "#a0c4ff",
            "#bdb2ff", "#ffc6ff","#ffadad", "#ffd6a5", "#fdffb6", "#caffbf", "#9bf6ff", "#a0c4ff",
            "#bdb2ff", "#ffc6ff","#ffadad", "#ffd6a5", "#fdffb6", "#caffbf", "#9bf6ff", "#a0c4ff",
            "#bdb2ff", "#ffc6ff");


            foreach ($data['plan_items'] as $key => $value) {
                $data['plan_items'][$key]['color'] = $event_colors[$key];
            }



            $getcalendar = [
                'year'=>$year,
                'section_id' => $section_id,
                'class_id' => $class_id,
            ];


            $calendarupdate = $this->db->where($getcalendar)->get('masterrotation')->row();


            
            $this->db->select('*');
            $this->db->from('academic_date');
            $this->db->where("SUBSTRING_INDEX(SUBSTRING_INDEX(`from`, '-', -1), '-', 1) =", $year);
             $this->db->where([
                'class_id' => $class_id,
                'section_id' => $section_id,
            ]);
            $query = $this->db->get();
            $result = $query->row();

            $weekdata = [];
            if($result){

            $datefrom =  $result->from;
            $dateto =  $result->to;
            $from = DateTime::createFromFormat('d-m-Y', $datefrom)->format('Y-m-d');
            $end = DateTime::createFromFormat('d-m-Y', $dateto)->format('Y-m-d');
            
            $weekdata = array();
            $current_week = array('start_date' => $from);
            
            while (strtotime($current_week['start_date']) <= strtotime($end)) {
              $current_week['end_date'] = date('Y-m-d', strtotime($current_week['start_date'] . ' + 6 days'));
              $weekdata[] = $current_week;
              $current_week = array('start_date' => date('Y-m-d', strtotime($current_week['end_date'] . ' + 1 days')));
            }
           }            
            $data['weekdata'] = $weekdata;
            $data['weekcount'] = count($weekdata);

            $data['calendar'] = $calendarupdate;

            $this->load->view('layout/header', $data);
            $this->load->view('admin/masterrotationplan/masterrotationcreate', $data);
            $this->load->view('layout/footer', $data);
        }
    }

    public function  savemasterrotation(){
       
        $insert_array=[
            'class_id'=>$this->input->post('class_id'),
            'section_id'=>$this->input->post('section_id'),
            'year'=>$this->input->post('year'),
            'calendar'=>json_encode($this->input->post('calendar'))
        ];

        $this->db->insert('masterrotation',$insert_array);;

        echo json_encode('Success');
        


    }

    public function  updatemasterrotation(){
       
        $insert_array=[
            'class_id'=>$this->input->post('class_id'),
            'section_id'=>$this->input->post('section_id'),
            'year'=>$this->input->post('year'),
            'calendar'=>json_encode($this->input->post('calendar'))
        ];

        $this->db->where('id',$this->input->post('id'))->update('masterrotation',$insert_array);;

        echo json_encode('Success');
        


    }

    public function itemindex()
    {
        if (!$this->rbac->hasPrivilege('class_timetable', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Academics');
        $this->session->set_userdata('sub_menu', 'master_rotation_plan/itemindex');
        $session = $this->setting_model->getCurrentSession();
        $data['title'] = 'Exam Marks';
        $data['exam_id'] = "";
        $data['class_id'] = "";
        $data['section_id'] = "";
        $exam = $this->exam_model->get();
        $class = $this->class_model->get();
        $data['examlist'] = $exam;
        $data['classlist'] = $class;
        $userdata = $this->customlib->getUserData();

         
        $data['week_days'] = $this->getweeks(3, 2023);
        // var_dump($week['week 4']);
        // exit;
        $data['is_search'] = false;
        $data['items'] = $this->db
            ->from('masterrotation_items')
            ->select('*,masterrotation_items.id as itemid')
            ->join('sections', 'sections.id=masterrotation_items.section_id')
            ->join('classes', 'classes.id=masterrotation_items.class_id')
            ->get()
            ->result_array();

        $this->load->view('layout/header', $data);
        $this->load->view('admin/masterrotationplan/masterrotation_items', $data);
        $this->load->view('layout/footer', $data);
    }

    public function createitem()
    {
        $data['items'] = $this->db
            ->from('masterrotation_items')
            ->select('*,masterrotation_items.id as itemid')
            ->join('sections', 'sections.id=masterrotation_items.section_id')
            ->join('classes', 'classes.id=masterrotation_items.class_id')
            ->get()
            ->result_array();
        $class = $this->class_model->get();
        $data['examlist'] = $exam;
        $data['classlist'] = $class;

        $this->form_validation->set_rules('class_id', 'Course', 'trim|required|xss_clean');
        $this->form_validation->set_rules('section_id', 'Section', 'trim|required|xss_clean');
        $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/masterrotationplan/masterrotation_items', $data);
            $this->load->view('layout/footer', $data);
        } else {

            $insert_array = [
                'name' => $this->input->post('name'),
                'section_id' => $this->input->post('section_id'),
                'class_id' => $this->input->post('class_id'),
            ];

            $this->db->insert('masterrotation_items', $insert_array);

            redirect('admin/masterrotation/itemindex');
        }
    }

    public function itemedit($id)
    {
        if (!$this->rbac->hasPrivilege('class_timetable', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Academics');
        $this->session->set_userdata('sub_menu', 'master_rotation_plan/index');
        $session = $this->setting_model->getCurrentSession();
        $data['title'] = 'Exam Marks';

        $exam = $this->exam_model->get();
        $class = $this->class_model->get();
        $data['examlist'] = $exam;
        $data['classlist'] = $class;
        $userdata = $this->customlib->getUserData();

        // var_dump($week['week 4']);
        // exit;
        $data['is_search'] = false;
        $data['items'] = $this->db
            ->from('masterrotation_items')
            ->select('*,masterrotation_items.id as itemid')
            ->join('sections', 'sections.id=masterrotation_items.section_id')
            ->join('classes', 'classes.id=masterrotation_items.class_id')
            ->get()
            ->result_array();

        $data['edititem'] = $this->db
            ->from('masterrotation_items')
            ->where('id', $id)
            ->get()
            ->row();

        $data['class_id'] = $data['edititem']->class_id;
        $data['section_id'] = $data['edititem']->section_id;
        $data['item_id'] = $id;

        $this->load->view('layout/header', $data);
        $this->load->view('admin/masterrotationplan/masterrotation_items_edit', $data);
        $this->load->view('layout/footer', $data);

    }

    public function updateitem($id)
    {
        $insert_array = [
            'name' => $this->input->post('name'),
            'section_id' => $this->input->post('section_id'),
            'class_id' => $this->input->post('class_id'),
        ];

        $this->db->where('id', $id)->update('masterrotation_items', $insert_array);

        redirect('admin/masterrotation/itemindex');
    }

    public function deleteitem($id)
    {
        $this->db->where('id', $id)->delete('masterrotation_items');
        print_r($this->db->last_query());
        redirect('admin/masterrotation/index');
    }



    public function clinicalrotation()
    {
        if (!$this->rbac->hasPrivilege('class_timetable', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Academics');
        $this->session->set_userdata('sub_menu', 'masterrotation/clinicalrotation');
        $session = $this->setting_model->getCurrentSession();
        $data['title'] = 'Exam Marks';
        $data['exam_id'] = "";
        $data['class_id'] = "";
        $data['section_id'] = "";
        $exam = $this->exam_model->get();
        $class = $this->class_model->get();
        $data['examlist'] = $exam;
        $data['classlist'] = $class;
        $userdata = $this->customlib->getUserData();

        $data['week_days'] = $this->getweeks(3, 2023);
        // var_dump($week['week 4']);
        // exit;
        $data['is_search'] = false;
        $data['date'] = date('Y');

        $this->form_validation->set_rules('class_id', 'Course', 'trim|required|xss_clean');
        $this->form_validation->set_rules('section_id', 'Section', 'trim|required|xss_clean');
        $this->form_validation->set_rules('date', 'Date', 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/masterrotationplan/clinicalrotation', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');
            $year = $this->input->post('date');

            $data['is_search'] = true;

            $data['year'] = $year;
            $data['date'] = $year;

            

            $data['class_id'] = $class_id;
            $data['section_id'] = $section_id;

            $data['class_name'] = $this->db->select('class')->where('id', $class_id)->get('classes')->row()->class;
            $data['section_name'] = $this->db->select('section')->where('id', $section_id)->get('sections')->row()->section;

            $where_array=[
                'clinical_group.class_id'=>$class_id,
                'clinical_group.section_id'=>$section_id,
                'assign_ward.datefrom>='=>"01-01-$year",
                'assign_ward.dateto<='=>"31-12-$year",
            ];

            $data['groups'] = $this->db->from('clinical_group')
            ->join('clinical_groupname','clinical_groupname.id=clinical_group.group_id')
            ->join('assign_ward','clinical_groupname.id=assign_ward.group_id')
            ->join('warddetail','warddetail.id=assign_ward.ward_id')
            ->where($where_array)
            ->order_by('assign_ward.datefrom')
            ->group_by('assign_ward.id')
            ->get()
            ->result_array(); 

            // print_r($this->db->last_query());
            // echo '<br/>';  
            // echo '<br/>';  
            // echo '<br/>';  
            // print_r($data['groups']);exit;  

            $data['wardlist'] = $this->db->select('*,clinical_department.id as wardid,warddetail.id as detailid')->join('clinical_department','warddetail.deptnames=clinical_department.id')->get('warddetail')->result_array();


           
            $weeks = array();

            $year =$year;
            // Create a new DateTime object for the start of the year
            $start_date = new DateTime("$year-01-01");

            // Loop through 52 weeks, adding each week's start and end dates to the array
            for ($i = 1; $i <= 52; $i++) {
            // Calculate the start and end dates for the current week
            $start_week = clone $start_date;
            $start_week->modify('+' . ($i - 1) . ' weeks');
            $end_week = clone $start_date;
            $end_week->modify('+' . $i . ' weeks -1 day');

            // Check if the end week is in a different month than the start week
            if ($end_week->format('m') != $start_week->format('m')) {
                // Get the last day of the month for the end week's month
                $last_day = cal_days_in_month(CAL_GREGORIAN, $end_week->format('m'), $end_week->format('Y'));
                
                // If the end week is in December, set the end date to December 31st
                if ($end_week->format('m') == '12') {
                $end_week->setDate($end_week->format('Y'), $end_week->format('m'), '31');
                } else {
                // Otherwise, set the end date to the last day of the month
                $end_week->modify("-" . ($end_week->format('d') - $last_day) . " days");
                }
            }
            
            // Add the start and end dates to the weeks array
            $weeks[] = array(
                'start_date' => $start_week->format('Y-m-d'),
                'end_date' => $end_week->format('Y-m-d')
            );
            }

            $weeks[51]=[
                'start_date' => '2023-12-24',
                'end_date' => '2023-12-31' 
            ];

            $data['weeks'] = $weeks;

 

            $this->load->view('layout/header', $data);
            $this->load->view('admin/masterrotationplan/clinicalrotation', $data);
            $this->load->view('layout/footer', $data);
        }
    }



    public function getDayFormat($date)
    {
        $date_string = $date;
        $date_format = 'd/m/Y';
        $dateformat = DateTime::createFromFormat($date_format, $date_string);
        return $dateformat->format('d/m/Y');
    }

    public function getweeks($month, $year)
    {

        // Define the year and month for which to generate the array
        $year = $year;
        $month = $month; // March

        $numDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        // Initialize the array to hold the weeks of the month
        $weeksOfMonth = array();

        // Set the starting date to the first day of the month
        $currentDate = new DateTime("$year-$month-01");

        // Add the dates from the first day of the month to the next Saturday to the first week of the array
        $weekIndex = 1;
        while ($currentDate->format('w') != 6) {
            if ($currentDate->format('w') != 0) {
                $weeksOfMonth['week ' . $weekIndex][] = $currentDate->format('d') . '/' . $currentDate->format('m') . '/' . $currentDate->format('Y');
            }
            $currentDate->add(new DateInterval('P1D'));
        }
        if ($currentDate->format('w') != 0) {
            $weeksOfMonth['week ' . $weekIndex][] = $currentDate->format('d') . '/' . $currentDate->format('m') . '/' . $currentDate->format('Y');
        }
        $currentDate->add(new DateInterval('P1D'));
        $weekIndex++;

        // Add the remaining dates to the remaining weeks of the array
        while ($currentDate->format('n') == $month) {
            if ($currentDate->format('w') != 0) {
                $weeksOfMonth['week ' . $weekIndex][] = $currentDate->format('d') . '/' . $currentDate->format('m') . '/' . $currentDate->format('Y');
            }
            if ($currentDate->format('w') == 6 || $currentDate->format('d') == $numDays) {
                // If it's Saturday or the last day of the month, move to the next index
                $weekIndex++;
            }
            $currentDate->add(new DateInterval('P1D'));
        }
        return ($weeksOfMonth);
    }

    public function view($id)
    {
        if (!$this->rbac->hasPrivilege('class_timetable', 'can_view')) {
            access_denied();
        }
        $data['title'] = 'Mark List';
        $mark = $this->mark_model->get($id);
        $data['mark'] = $mark;
        $this->load->view('layout/header', $data);
        $this->load->view('admin/weeklycalendarnew/timetableShow', $data);
        $this->load->view('layout/footer', $data);
    }

    public function delete($id)
    {

        $this->db->where('id', $id)->delete('week_calendar');
        redirect('admin/weeklycalendarnew/index');
    }

     

    public function edit($id)
    {
        if (!$this->rbac->hasPrivilege('class_timetable', 'can_edit')) {
            access_denied();
        }
        $data['title'] = 'Edit Mark';
        $data['id'] = $id;
        $mark = $this->mark_model->get($id);
        $data['mark'] = $mark;
        $this->form_validation->set_rules('name', 'Mark', 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/weeklycalendarnew/timetableEditnew', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'id' => $id,
                'name' => $this->input->post('name'),
                'note' => $this->input->post('note'),
            );
            $this->mark_model->add($data);
            $this->session->set_flashdata('msg', '<div mark="alert alert-success text-center">Employee added successfully</div>');
            redirect('admin/weeklycalendarnew/index');
        }
    }

    public function check_exists()
    {

        $this->Timetablenew_model->valid_check_exists();

    }
    public function getcalendar()
    {

        $section = $this->input->post('section_id');
        $class = $this->input->post('class_id');

        $calendar =
        $this->db
            ->where([
                'section_id' => $section,
                'class_id' => $class,
            ])
            ->get('weekly_calendar')->result_array();

        $eventdata = [];

        $name = '';
        foreach ($calendar as $key => $value) {

            if ($value['eight_to_nine_teacher'] != 0) {
                $name .= "08 - 09 AM : " . $this->getStaffName($value['eight_to_nine_teacher']) . "" . $this->getSubjectName($value['eight_to_nine_subject']) . "\n";
            } else if ($value['eight_to_nine_activity'] != '') {
                $name .= "08 - 09 AM : $value[eight_to_nine_activity]\n";
            }

            if ($value['nine_to_ten_teacher'] != 0) {
                $name .= "09 - 10 AM : " . $this->getStaffName($value['nine_to_ten_teacher']) . "" . $this->getSubjectName($value['nine_to_ten_subject']) . "\n";
            } else if ($value['nine_to_ten_activity'] != '') {
                $name .= "09 - 10 AM : $value[nine_to_ten_activity]\n";
            }

            if ($value['ten_to_eleven_teacher'] != 0) {
                $name .= "10 - 11 AM : " . $this->getStaffName($value['ten_to_eleven_teacher']) . "" . $this->getSubjectName($value['ten_to_eleven_subject']) . "\n";
            } else if ($value['ten_to_eleven_activity'] != '') {
                $name .= "10 - 11 AM : $value[ten_to_eleven_activity]\n";
            }

            if ($value['eleven_to_twelve_teacher'] != 0) {
                $name .= "11 - 12 PM : " . $this->getStaffName($value['eleven_to_twelve_teacher']) . "" . $this->getSubjectName($value['eleven_to_twelve_subject']) . "\n";
            } else if ($value['eleven_to_twelve_activity'] != '') {
                $name .= "11 - 12 PM : $value[eleven_to_twelve_activity]\n";
            }

            if ($value['twelve_to_one_teacher'] != 0) {
                $name .= "12 - 01 PM : " . $this->getStaffName($value['twelve_to_one_teacher']) . "" . $this->getSubjectName($value['twelve_to_one_subject']) . "\n";
            } else if ($value['twelve_to_one_activity'] != '') {
                $name .= "12 - 01 PM : $value[twelve_to_one_activity]\n";
            }

            if ($value['two_to_three_teacher'] != 0) {
                $name .= "02 - 03 PM : " . $this->getStaffName($value['two_to_three_teacher']) . "" . $this->getSubjectName($value['two_to_three_subject']) . "\n";
            } else if ($value['two_to_three_activity'] != '') {
                $name .= "02 - 03 PM : $value[two_to_three_activity]\n";
            }

            if ($value['three_to_four_teacher'] != 0) {
                $name .= "03 - 04 PM : " . $this->getStaffName($value['three_to_four_teacher']) . "" . $this->getSubjectName($value['three_to_four_subject']) . "\n";
            } else if ($value['three_to_four_activity'] != '') {
                $name .= "03 - 04 PM : $value[three_to_four_activity]\n";
            }

            if ($value['four_to_five_teacher'] != 0) {
                $name .= "04 - 05 PM : " . $this->getStaffName($value['four_to_five_teacher']) . "" . $this->getSubjectName($value['four_to_five_subject']) . "\n";
            } else if ($value['four_to_five_activity'] != '') {
                $name .= "04 - 05 PM : $value[four_to_five_activity]\n";
            }

            $eventdata[] = array(
                'id' => $value['id'],
                'title' => $name,
                'start' => (date("Y-d-m", strtotime($value['date']))),
                'end' => (date("Y-d-m", strtotime($value['date']))),

            );
            $name = '';

        }

        echo json_encode($eventdata);

    }

    public function updatecalendar()
    {

        $subjects = $this->input->post('subject_id');
        $teachers = $this->input->post('teacher_id');
        $id = $this->input->post('hidden_id');
        $activity = $this->input->post('activity_id');

        $insert_array = [

            'eight_to_nine_subject' => $subjects[0],
            'eight_to_nine_teacher' => $teachers[0],
            'nine_to_ten_subject' => $subjects[1],
            'nine_to_ten_teacher' => $teachers[1],
            'ten_to_eleven_subject' => $subjects[2],
            'ten_to_eleven_teacher' => $teachers[2],
            'eleven_to_twelve_subject' => $subjects[3],
            'eleven_to_twelve_teacher' => $teachers[3],
            'twelve_to_one_subject' => $subjects[4],
            'twelve_to_one_teacher' => $teachers[4],
            'two_to_three_subject' => $subjects[5],
            'two_to_three_teacher' => $teachers[5],
            'three_to_four_subject' => $subjects[6],
            'three_to_four_teacher' => $teachers[6],
            'four_to_five_subject' => $subjects[7],
            'four_to_five_teacher' => $teachers[7],
            'eight_to_nine_activity' => $activity[0],
            'nine_to_ten_activity' => $activity[1],
            'ten_to_eleven_activity' => $activity[2],
            'eleven_to_twelve_activity' => $activity[3],
            'twelve_to_one_activity' => $activity[4],
            'two_to_three_activity' => $activity[5],
            'three_to_four_activity' => $activity[6],
            'four_to_five_activity' => $activity[7],
        ];

        $this->db->where('id', $id)->update('weekly_calendar', $insert_array);

        echo json_encode('success');
    }

    public function view_event($id)
    {

        $timetable = $this->db->where('id', $id)->get('weekly_calendar')->row();
        echo json_encode($timetable);
    }

    public function getStaffName($id)
    {

        $name = $this->db->select('staff.name')->where('staff.id', $id)->get('staff')->row();

        return $name->name;

    }
    public function getSubjectName($id)
    {

        $name = $this->db->select('subjects.name')->from('subjects')->join('teacher_subjects', 'teacher_subjects.subject_id=subjects.id')->where('teacher_subjects.id', $id)->get()->row();

        return " (" . substr($name->name, 0, 4) . ")";

    }

}
