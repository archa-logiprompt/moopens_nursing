<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Weeklycalendarnew extends Admin_Controller
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
        $this->session->set_userdata('sub_menu', 'weeklycalendarnew/index');
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

        $this->form_validation->set_rules('class_id', 'Course', 'trim|required|xss_clean');
        $this->form_validation->set_rules('section_id', 'Section', 'trim|required|xss_clean');
        $this->form_validation->set_rules('date', 'Date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('week', 'Week', 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/weeklycalendarnew/weeklycalendar', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');
            $daterange = explode('-', $this->input->post('date'));
            $week_number = $this->input->post('week');

            $data['week_number'] = $week_number;

            $data['is_search'] = true;

            $month = $daterange[0];
            $year = $daterange[1];

            $weeks = $this->getweeks($month, $year);

            $weekcalendar = $weeks[$week_number];
            $array_count = (count($weekcalendar)) - 1;

            $data['weekcalendar'] = $weekcalendar;

            $start = $this->getDayFormat($weekcalendar[0]);
            $end = $this->getDayFormat($weekcalendar[$array_count]);

            $data['class_id'] = $class_id;
            $data['section_id'] = $section_id;

            $data['class_name'] = $this->db->select('class')->where('id', $class_id)->get('classes')->row()->class;
            $data['section_name'] = $this->db->select('section')->where('id', $section_id)->get('sections')->row()->section;

            $wherearray = [
                'class_id' => $class_id,
                'section_id' => $section_id,
            ];

            // 'date >=' => $start,
            // 'date <=' => $end,

            $data['weekcalendar'] = $this->db
                ->where($wherearray)
                // ->where("date >= DATE_FORMAT(STR_TO_DATE('$start', '%d/%m/%Y'), '%Y-%m-%d')")
                // ->where("date <= DATE_FORMAT(STR_TO_DATE('$end', '%d/%m/%Y'), '%Y-%m-%d')")
                ->where("STR_TO_DATE(date, '%d/%m/%Y') BETWEEN STR_TO_DATE('$start', '%d/%m/%Y') AND STR_TO_DATE('$end', '%d/%m/%Y')")
                ->order_by('date')
                ->get('weekly_calendar')
                ->result_array();


            // print_r($this->db->last_query());exit;
            $this->load->view('layout/header', $data);
            $this->load->view('admin/weeklycalendarnew/weeklycalendar', $data);
            $this->load->view('layout/footer', $data);
        }
    }

    public function search()
    {
        if (!$this->rbac->hasPrivilege('class_timetable', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Academics');
        $this->session->set_userdata('sub_menu', 'weeklycalendarnew/index');
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


        $test = $this->input->post('week');
        // var_dump();exit;

        //weekly
        if (!empty($test)) {
            $data['is_weekly'] = true;


            // var_dump($data);exit;
            $this->form_validation->set_rules('class_id', 'Course', 'trim|required|xss_clean');
            $this->form_validation->set_rules('section_id', 'Section', 'trim|required|xss_clean');
            $this->form_validation->set_rules('date', 'Date', 'trim|required|xss_clean');
            $this->form_validation->set_rules('week', 'Week', 'trim|required|xss_clean');
            if ($this->form_validation->run() == false) {
                $this->load->view('layout/header', $data);
                $this->load->view('admin/weeklycalendarnew/weeklycalendar', $data);
                $this->load->view('layout/footer', $data);
            } else {
                $class_id = $this->input->post('class_id');
                $section_id = $this->input->post('section_id');
                $daterange = explode('-', $this->input->post('date'));
                $week_number = $this->input->post('week');
                $data['week_number'] = $week_number;

                $data['is_search'] = true;

                $month = $daterange[0];
                $year = $daterange[1];
                
    

                $weeks = $this->getweeks($month, $year);
                $data['test'] = $weeks;

                $weekcalendar = $weeks[$week_number];
                // var_dump($weekcalendar);exit;

                $array_count = (count($weekcalendar)) - 1;
                // var_dump($array_count);exit;

                $data['weekcalendar'] = $weekcalendar;
                // count(($weekcalendar))-1;
                // var_dump($weekcalendar);exit;

                $start = $this->getDayFormat($weekcalendar[0]);
                // var_dump($start);exit;
                $end = $this->getDayFormat($weekcalendar[$array_count]);
                // var_dump($end);exit;

                $data['class_id'] = $class_id;
                $data['section_id'] = $section_id;


                $data['class_name'] = $this->db->select('class')->where('id', $class_id)->get('classes')->row()->class;
                $data['section_name'] = $this->db->select('section')->where('id', $section_id)->get('sections')->row()->section;

                $wherearray = [
                    'class_id' => $class_id,
                    'section_id' => $section_id,
                ];
                $start_date = $start;
                $end_date = $end;

                $start_date_converted = DateTime::createFromFormat('d/m/Y', $start_date)->format('Y-m-d');
                $end_date_converted = DateTime::createFromFormat('d/m/Y', $end_date)->format('Y-m-d');

                $sql = "SELECT * FROM `weekly_calendar` WHERE STR_TO_DATE(date, '%d/%m/%Y') BETWEEN ? AND ? AND class_id = ? AND section_id = ?";
                $query = $this->db->query($sql, array($start_date_converted, $end_date_converted, $class_id, $section_id));
                $data['weekcalendar'] = $query->result_array();

                // print_r($this->db->last_query()); exit;
                $this->load->view('layout/header', $data);
                $this->load->view('admin/weeklycalendarnew/weeklycalendar', $data);
                $this->load->view('layout/footer', $data);

            }

        } else {

            //monthly 
            $data['table'] = 1;
            $data['is_weekly'] = false;
            $this->form_validation->set_rules('class_id', 'Course', 'trim|required|xss_clean');
            $this->form_validation->set_rules('section_id', 'Section', 'trim|required|xss_clean');
            $this->form_validation->set_rules('date', 'Date', 'trim|required|xss_clean');
            // $this->form_validation->set_rules('week', 'Week', 'trim|required|xss_clean');
            if ($this->form_validation->run() == false) {
                $this->load->view('layout/header', $data);
                $this->load->view('admin/weeklycalendarnew/weeklycalendar', $data);
                $this->load->view('layout/footer', $data);
            } else {

                $class_id = $this->input->post('class_id');
                $section_id = $this->input->post('section_id');
                $daterange = explode('-', $this->input->post('date'));
                $week_number = $this->input->post('week');

                $data['week_number'] = $week_number;

                $data['is_search'] = true;


                
                $month = $daterange[0];
                $year = $daterange[1];

                $data['month_name'] = date('F', mktime(0, 0, 0, $month, 1));
                // var_dump($data['month_name']);exit;
                $data['month'] = $month;
                $data['year'] = $year;

                $startDate = new DateTime("$year-$month-01");

                // Get the last day of the month
                $endDate = new DateTime("$year-$month-" . $startDate->format('t'));

                // Loop through the days of the month
                $currentDate = clone $startDate;
                while ($currentDate <= $endDate) {
                    // echo $currentDate->format('d-m-Y') . '<br>';
                    $currentDate->modify('+1 day');
                }
                // exit;


                $weeks = $this->getweeks($month, $year);

                $data['test'] = $weeks;

                $daysInMonths = $this->getDatesForMonth($month, $year);


                $chunks = $this->array_chunk_fixed($daysInMonths, 5);
                // Print the array
                $separatedArray = [];
                foreach ($chunks as $key => $chunk) {
                    $separatedArray[$key] = $chunk;
                }

                // Print the separated array
                // dd/mm/Y
                // var_dump($separatedArray);exit;
                $data['daysarr'] = $separatedArray;
                $days_in_week = $weeks[$week_number];



                $data['weekcalendar'] = $this->db->select('*')->from('weekly_calendar')->where('section_id', $section_id)->where('class_id', $class_id)->like('date', '__%' . $month . '%___', '!', false)->order_by('date')->get()->result_array();

                foreach ($daysInMonths as $date) {
                    // Check if the date exists in the original array
                    $found = false;
                    foreach ($data['weekcalendar'] as $entry) {
                        if ($entry['date'] === $date) {
                            $found = true;
                            $modifiedArray[] = $entry; // Add the existing entry to the modified array
                            break;
                        }
                    }

                    // If the date was not found in the original array, add it with default values
                    if (!$found) {
                        $modifiedArray[] = [
                            'id' => '',
                            // You can set other fields to default values here
                            'class_id' => '',
                            'section_id' => '',
                            'date' => $date,
                            // Add other fields with default values
                        ];
                    }
                }

                // var_dump($modifiedArray);
                // exit;
                $data['weekcalendar'] = $modifiedArray;
                // print_r($this->db->last_query($data));exit;
                // echo $this->db->get()->result_array();
                $data['dummy'] = 1;

                $this->load->view('layout/header', $data);
                $this->load->view('admin/weeklycalendarnew/weeklycalendar', $data);
                $this->load->view('layout/footer', $data);
            }
            // var_dump($data['dummy']);exit;

        }

    }


    function getDatesForMonth($month, $year)
    {
        $numDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $dates = [];

        for ($day = 1; $day <= $numDays; $day++) {
            $date = date("d/m/Y", mktime(0, 0, 0, $month, $day, $year));
            $dates[] = $date;
        }

        return $dates;
    }

    function array_chunk_fixed($array, $chunk_size)
    {
        $chunks = [];
        for ($i = 0; $i < count($array); $i += $chunk_size) {
            $chunks[] = array_slice($array, $i, $chunk_size);
        }
        return $chunks;
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

    public function create()
    {
        if (!$this->rbac->hasPrivilege('class_timetable', 'can_add')) {

            access_denied();
        }

        $session = $this->setting_model->getCurrentSession();
        $data['title'] = 'Exam Schedule';
        $data['subject_id'] = "";
        $data['class_id'] = $this->input->post('class_id');
        $data['section_id'] = $this->input->post('section_id');
        $data['department_id'] = "";
        $exam = $this->exam_model->get();
        $class = $this->class_model->get('', $classteacher = 'yes');
        $data['classlist'] = $class;
        $userdata = $this->customlib->getUserData();
        $data['isupdate'] = false;
        $data['issearch'] = false;

        $event_colors = array("#03a9f4", "#c53da9", "#757575", "#8e24aa", "#d81b60", "#7cb342", "#fb8c00", "#fb3b3b");
        $data["event_colors"] = $event_colors;
        if ($this->input->server('REQUEST_METHOD') == "POST") {

            if ($this->input->post('search') == 'Search') {

                $this->form_validation->set_rules('class_id', 'Course', 'trim|required|xss_clean');
                $this->form_validation->set_rules('section_id', 'Section', 'trim|required|xss_clean');
                if ($this->form_validation->run() == false) {
                    $this->load->view('layout/header', $data);
                    $this->load->view('admin/weeklycalendarnew/createcalendar', $data);
                    $this->load->view('layout/footer', $data);
                } else {

                    $data['class_id'] = $this->input->post('class_id');
                    $data['section_id'] = $this->input->post('section_id');
                    $data['issearch'] = true;

                    $wherearray = [
                        'course_id' => $data['class_id'],
                        'batch_id' => $data['section_id'],
                    ];
                    $data['weekcalendar'] = $this->db->where($wherearray)->get('week_calendar')->result_array();
                    // echo $this->db->last_query();exit;
                    $data['isupdate'] = !empty($data['weekcalendar']);

                    $this->load->view('layout/header', $data);
                    $this->load->view('admin/weeklycalendarnew/createcalendar', $data);
                    $this->load->view('layout/footer', $data);

                }

            }

        } else {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/weeklycalendarnew/createcalendar', $data);
            $this->load->view('layout/footer', $data);
        }

    }

    public function savecalendar()
    {
        $subjects = $this->input->post('subject_id');
        $teachers = $this->input->post('teacher_id');
        $date = $this->input->post('event_dates');
        $class = $this->input->post('hidden_class');
        $section = $this->input->post('hidden_section');
        $activity = $this->input->post('activity_id');

        // Check if any of the fields contain 'holiday'
        $isHoliday = in_array('holiday', $activity);

        // Define an array to hold the values for insertion
        $insert_array = [
            'class_id' => $class,
            'section_id' => $section,
            'date' => $date,
            'eight_to_nine_subject' => $isHoliday ? 'holiday' : $subjects[0],
            'eight_to_nine_teacher' => $isHoliday ? 'holiday' : $teachers[0],
            'nine_to_ten_subject' => $isHoliday ? 'holiday' : $subjects[1],
            'nine_to_ten_teacher' => $isHoliday ? 'holiday' : $teachers[1],
            'ten_to_eleven_subject' => $isHoliday ? 'holiday' : $subjects[2],
            'ten_to_eleven_teacher' => $isHoliday ? 'holiday' : $teachers[2],
            'eleven_to_twelve_subject' => $isHoliday ? 'holiday' : $subjects[3],
            'eleven_to_twelve_teacher' => $isHoliday ? 'holiday' : $teachers[3],
            'twelve_to_one_subject' => $isHoliday ? 'holiday' : $subjects[4],
            'twelve_to_one_teacher' => $isHoliday ? 'holiday' : $teachers[4],
            'two_to_three_subject' => $isHoliday ? 'holiday' : $subjects[5],
            'two_to_three_teacher' => $isHoliday ? 'holiday' : $teachers[5],
            'three_to_four_subject' => $isHoliday ? 'holiday' : $subjects[6],
            'three_to_four_teacher' => $isHoliday ? 'holiday' : $teachers[6],
            'four_to_five_subject' => $isHoliday ? 'holiday' : $subjects[7],
            'four_to_five_teacher' => $isHoliday ? 'holiday' : $teachers[7],
            'eight_to_nine_activity' => $isHoliday ? 'holiday' : $activity[0],
            'nine_to_ten_activity' => $isHoliday ? 'holiday' : $activity[1],
            'ten_to_eleven_activity' => $isHoliday ? 'holiday' : $activity[2],
            'eleven_to_twelve_activity' => $isHoliday ? 'holiday' : $activity[3],
            'twelve_to_one_activity' => $isHoliday ? 'holiday' : $activity[4],
            'two_to_three_activity' => $isHoliday ? 'holiday' : $activity[5],
            'three_to_four_activity' => $isHoliday ? 'holiday' : $activity[6],
            'four_to_five_activity' => $isHoliday ? 'holiday' : $activity[7],
        ];

        // Insert data into the 'weekly_calendar' table
        $this->db->insert('weekly_calendar', $insert_array);

        echo json_encode('success');
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

            // echo $this->getDayFormatYDM($value['date']);
            // echo '<br/>';

            $eventdata[] = array(
                'id' => $value['id'],
                'title' => $name,
                'start' => (date("Y-m-d", strtotime($this->getDayFormatYDM($value['date'])))),
                'end' => (date("Y-m-d", strtotime($this->getDayFormatYDM($value['date'])))),

            );
            $name = '';

        }
        // exit;
        echo json_encode($eventdata);

    }

    public function getDayFormatYDM($date)
    {
        $date_string = $date;
        $date_format = 'd/m/Y';
        $dateformat = DateTime::createFromFormat($date_format, $date_string);
        return $dateformat->format('Y-m-d');
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