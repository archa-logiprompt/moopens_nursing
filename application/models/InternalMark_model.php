<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class InternalMark_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function checkExisting($name, $class_id, $section_id, $session_id)
    {
        $this->db->where('name', $name);
        $this->db->where('class_id', $class_id);
        $this->db->where('section_id', $section_id);
        $this->db->where('session_id', $session_id);
        $query = $this->db->get('internal_mark_group'); // Adjust table name if needed

        return $query->num_rows() > 0; // Return true if record exists
    }

    public function add($data)
    {
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('internal_mark_group', $data);
        } else {

            $this->db->insert('internal_mark_group', $data);
            return $this->db->insert_id();
        }
    }

    public function get($id = null)
    {
        $session = $this->setting_model->getCurrentSession();

        $this->db->select("internal_mark_group.*,sections.section,classes.class,sessions.session,subjects.id as sub_id,subjects.name as sub_name")->join('classes', 'classes.id=internal_mark_group.class_id')->join('teacher_subjects', 'teacher_subjects.id=internal_mark_group.subject_id')->join('subjects', 'subjects.id=teacher_subjects.subject_id')->join('sections', 'sections.id=internal_mark_group.section_id')->join('sessions', 'sessions.id=internal_mark_group.session_id');
        if ($id) {
            $result = $this->db->where('internal_mark_group.id', $id)->where('internal_mark_group.session_id', $session)->get('internal_mark_group')->row();
        } else {
            $result = $this->db->where('internal_mark_group.session_id', $session)->get('internal_mark_group')->result_array();
        }

        return $result;
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('internal_mark_group');
    }

    public function getClinicalAttendance($class_id, $section_id, $session_id, $subject_id)
    {
        $result = $this->db
            ->select('students.id, students.firstname, COUNT(clinical_attendance.id) as total, COUNT(CASE WHEN clinical_attendance.attendence_type_id = 1 THEN 1 END) as present_count')
            ->from('students')
            ->join('student_session', 'student_session.student_id = students.id')
            ->join('clinical_attendance', 'clinical_attendance.student_session_id = student_session.id')
            ->where([
                'class_id' => $class_id,
                'section_id' => $section_id,
                'student_session.session_id' => $session_id,
                'clinical_attendance.subject_id' => $subject_id,
            ])
            ->order_by('students.firstname')
            ->group_by('student_session.id')
            ->get()
            ->result_array();

        return ($result);
    }
    public function getTheoryAttendance($class_id, $section_id, $session_id, $subject_id)
    {
        $result = $this->db
            ->select('students.id, students.firstname, COUNT(student_period_attendance.id) as total, SUM(student_period_attendance.attendencetype = 0) as present_count')
            ->from('students')
            ->join('student_session', 'student_session.student_id = students.id')
            ->join('student_period_attendance', 'student_period_attendance.student_id = student_session.id')
            ->where([
                'student_period_attendance.class_id' => $class_id,
                'student_period_attendance.section_id' => $section_id,
                // 'student_session.session_id' => $session_id,
                'student_period_attendance.subject_id' => $subject_id,
            ])
            ->group_by('student_session.id')->order_by('students.firstname')
            ->get()
            ->result_array();
// echo $this->db->last_query();exit;
        return ($result);
    }


    public function getInternalMarks($class_id, $section_id, $session_id, $subject_id)
    {
        $exams = $this->db
            ->select('internalmarks.type_id,name,max_mark')->from('internalmarks')
            ->join('students', 'students.id = internalmarks.student_id')
            ->join('internal_mark_group', 'internal_mark_group.id = internalmarks.type_id')
            ->join('student_session', 'student_session.student_id = students.id')
            ->where([
                'student_session.class_id' => $class_id,
                'student_session.section_id' => $section_id,
                'student_session.session_id' => $session_id,
                'internal_mark_group.sub_type' => 'assignment',
                'internal_mark_group.type' => 'practical',
                'internal_mark_group.subject_id' => $subject_id,
            ])->group_by('type_id')
            ->get()
            ->result_array();

        $data = array();
        foreach ($exams as $key => $exam) {
            $result = $this->db
                ->select('marks')
                ->from('internalmarks')
                ->join('students', 'students.id = internalmarks.student_id')
                ->join('student_session', 'student_session.student_id = students.id')
                ->where([
                    'student_session.class_id' => $class_id,
                    'student_session.section_id' => $section_id,
                    'student_session.session_id' => $session_id,
                    'type_id' => $exam['type_id'],
                ])->order_by('students.firstname')
                ->get()
                ->result_array();
            $data[$key]['name'] = $exams[$key]['name'];
            $data[$key]['max'] = $exams[$key]['max_mark'];
            $data[$key]['marks'] = $result;
        }
        return ($data);
    }
    public function getTheoryMarks($class_id, $section_id, $session_id, $subject_id)
    {
        $exams = $this->db
            ->select('internalmarks.type_id,name,max_mark')->from('internalmarks')
            ->join('students', 'students.id = internalmarks.student_id')
            ->join('internal_mark_group', 'internal_mark_group.id = internalmarks.type_id')
            ->join('student_session', 'student_session.student_id = students.id')
            ->where([
                'student_session.class_id' => $class_id,
                'student_session.section_id' => $section_id,
                'student_session.session_id' => $session_id,
                'internal_mark_group.sub_type' => 'assignment',
                'internal_mark_group.type' => 'theory',
                'internal_mark_group.subject_id' => $subject_id,
            ])->group_by('type_id')
            ->get()
            ->result_array();

        $data = array();
        foreach ($exams as $key => $exam) {
            $result = $this->db
                ->select('marks')
                ->from('internalmarks')
                ->join('students', 'students.id = internalmarks.student_id')
                ->join('student_session', 'student_session.student_id = students.id')
                ->where([
                    'student_session.class_id' => $class_id,
                    'student_session.section_id' => $section_id,
                    'student_session.session_id' => $session_id,
                    'type_id' => $exam['type_id'],
                ])->order_by('students.firstname')
                ->get()
                ->result_array();
            $data[$key]['name'] = $exams[$key]['name'];
            $data[$key]['max'] = $exams[$key]['max_mark'];
            $data[$key]['marks'] = $result;
        }
        return ($data);
    }
    public function getClinicalMarks($class_id, $section_id, $session_id, $subject_id)
    {
        $exams = $this->db
            ->select('internalmarks.type_id,name,max_mark')->from('internalmarks')
            ->join('students', 'students.id = internalmarks.student_id')
            ->join('internal_mark_group', 'internal_mark_group.id = internalmarks.type_id')
            ->join('student_session', 'student_session.student_id = students.id')
            ->where([
                'internalmarks.class_id' => $class_id,
                'internalmarks.section_id' => $section_id,
                'internalmarks.session_id' => $session_id,
                'internal_mark_group.subject_id' => $subject_id,
                'internal_mark_group.sub_type' => 'clinical_evaluation'
            ])->group_by('type_id')
            ->get()
            ->result_array();

        $data = array();
        foreach ($exams as $key => $exam) {
            $result = $this->db
                ->select('marks')
                ->from('internalmarks')
                ->join('students', 'students.id = internalmarks.student_id')
                ->join('student_session', 'student_session.student_id = students.id')
                ->where([
                    'student_session.class_id' => $class_id,
                    'student_session.section_id' => $section_id,
                    'student_session.session_id' => $session_id,
                    'type_id' => $exam['type_id'],
                ])->order_by('students.firstname')
                ->get()
                ->result_array();
            $data[$key]['name'] = $exams[$key]['name'];
            $data[$key]['max'] = $exams[$key]['max_mark'];
            $data[$key]['marks'] = $result;
        }
        return ($data);
    }

    public function getEO5Marks($class_id, $section_id, $session_id, $subject_id)
    {
        $exams = $this->db
            ->select('internalmarks.type_id,name,max_mark')->from('internalmarks')
            ->join('students', 'students.id = internalmarks.student_id')
            ->join('internal_mark_group', 'internal_mark_group.id = internalmarks.type_id')
            ->join('student_session', 'student_session.student_id = students.id')
            ->where([
                'internalmarks.class_id' => $class_id,
                'internalmarks.section_id' => $section_id,
                'internal_mark_group.subject_id' => $subject_id,
                'internalmarks.session_id' => $session_id,
                'internal_mark_group.sub_type' => 'EO5'
            ])->group_by('type_id')
            ->get()
            ->row();

        $data = new stdClass();

        $result = $this->db
            ->select('marks')
            ->from('internalmarks')
            ->join('students', 'students.id = internalmarks.student_id')
            ->join('student_session', 'student_session.student_id = students.id')
            ->where([
                'student_session.class_id' => $class_id,
                'student_session.section_id' => $section_id,
                'student_session.session_id' => $session_id,
                'type_id' => $exams->type_id,
            ])->order_by('students.firstname')
            ->get()
            ->result_array();
        $data->name = $exams->name;
        $data->max = $exams->max_mark;
        $data->marks = $result;

        return ($data);
    }
    public function getSMMarks($class_id, $section_id, $session_id, $subject_id)
    {
        $exams = $this->db
            ->select('internalmarks.type_id,name,max_mark')->from('internalmarks')
            ->join('students', 'students.id = internalmarks.student_id')
            ->join('internal_mark_group', 'internal_mark_group.id = internalmarks.type_id')
            ->join('student_session', 'student_session.student_id = students.id')
            ->where([
                'internalmarks.class_id' => $class_id,
                'internalmarks.section_id' => $section_id,
                'internal_mark_group.subject_id' => $subject_id,
                'internalmarks.session_id' => $session_id,
                'internal_mark_group.type' => 'theory',
                'internal_mark_group.sub_type' => 'sm'
            ])->group_by('type_id')
            ->get()
            ->row();

        $data = new stdClass();

        $result = $this->db
            ->select('marks')
            ->from('internalmarks')
            ->join('students', 'students.id = internalmarks.student_id')
            ->join('student_session', 'student_session.student_id = students.id')
            ->where([
                'student_session.class_id' => $class_id,
                'student_session.section_id' => $section_id,
                'student_session.session_id' => $session_id,
                'type_id' => $exams->type_id,
            ])->order_by('students.firstname')
            ->get()
            ->result_array();
        $data->name = $exams->name;
        $data->max = $exams->max_mark;
        $data->marks = $result;
        return ($data);
    }
    public function getmt1Marks($class_id, $section_id, $session_id, $subject_id)
    {
        $exams = $this->db
            ->select('internalmarks.type_id,name,max_mark')->from('internalmarks')
            ->join('students', 'students.id = internalmarks.student_id')
            ->join('internal_mark_group', 'internal_mark_group.id = internalmarks.type_id')
            ->join('student_session', 'student_session.student_id = students.id')
            ->where([
                'internalmarks.class_id' => $class_id,
                'internalmarks.section_id' => $section_id,
                'internal_mark_group.subject_id' => $subject_id,
                'internalmarks.session_id' => $session_id,
                'internal_mark_group.type' => 'theory',
                'internal_mark_group.sub_type' => 'mt1'
            ])->group_by('type_id')
            ->get()
            ->row();

        $data = new stdClass();

        $result = $this->db
            ->select('marks')
            ->from('internalmarks')
            ->join('students', 'students.id = internalmarks.student_id')
            ->join('student_session', 'student_session.student_id = students.id')
            ->where([
                'student_session.class_id' => $class_id,
                'student_session.section_id' => $section_id,
                'student_session.session_id' => $session_id,
                'type_id' => $exams->type_id,
            ])->order_by('students.firstname')
            ->get()
            ->result_array();
        $data->name = $exams->name;
        $data->max = $exams->max_mark;
        $data->marks = $result;
        return ($data);
    }
    public function getmt2Marks($class_id, $section_id, $session_id, $subject_id)
    {
        $exams = $this->db
            ->select('internalmarks.type_id,name,max_mark')->from('internalmarks')
            ->join('students', 'students.id = internalmarks.student_id')
            ->join('internal_mark_group', 'internal_mark_group.id = internalmarks.type_id')
            ->join('student_session', 'student_session.student_id = students.id')
            ->where([
                'internalmarks.class_id' => $class_id,
                'internalmarks.section_id' => $section_id,
                'internal_mark_group.subject_id' => $subject_id,
                'internalmarks.session_id' => $session_id,
                'internal_mark_group.type' => 'theory',
                'internal_mark_group.sub_type' => 'mt2'
            ])->group_by('type_id')
            ->get()
            ->row();

        $data = new stdClass();

        $result = $this->db
            ->select('marks')
            ->from('internalmarks')
            ->join('students', 'students.id = internalmarks.student_id')
            ->join('student_session', 'student_session.student_id = students.id')
            ->where([
                'student_session.class_id' => $class_id,
                'student_session.section_id' => $section_id,
                'student_session.session_id' => $session_id,
                'type_id' => $exams->type_id,
            ])->order_by('students.firstname')
            ->get()
            ->result_array();
        $data->name = $exams->name;
        $data->max = $exams->max_mark;
        $data->marks = $result;
        return ($data);
    }
    public function getpjMarks($class_id, $section_id, $session_id, $subject_id)
    {
        $exams = $this->db
            ->select('internalmarks.type_id,name,max_mark')->from('internalmarks')
            ->join('students', 'students.id = internalmarks.student_id')
            ->join('internal_mark_group', 'internal_mark_group.id = internalmarks.type_id')
            ->join('student_session', 'student_session.student_id = students.id')
            ->where([
                'internalmarks.class_id' => $class_id,
                'internalmarks.section_id' => $section_id,
                'internal_mark_group.subject_id' => $subject_id,
                'internalmarks.session_id' => $session_id,
                'internal_mark_group.type' => 'theory',
                'internal_mark_group.sub_type' => 'pj'
            ])->group_by('type_id')
            ->get()
            ->row();

        $data = new stdClass();

        $result = $this->db
            ->select('marks')
            ->from('internalmarks')
            ->join('students', 'students.id = internalmarks.student_id')
            ->join('student_session', 'student_session.student_id = students.id')
            ->where([
                'student_session.class_id' => $class_id,
                'student_session.section_id' => $section_id,
                'student_session.session_id' => $session_id,
                'type_id' => $exams->type_id,
            ])->order_by('students.firstname')
            ->get()
            ->result_array();
        $data->name = $exams->name;
        $data->max = $exams->max_mark;
        $data->marks = $result;
        return ($data);
    }
    public function getmmMarks($class_id, $section_id, $session_id, $subject_id)
    {
        $exams = $this->db
            ->select('internalmarks.type_id,name,max_mark')->from('internalmarks')
            ->join('students', 'students.id = internalmarks.student_id')
            ->join('internal_mark_group', 'internal_mark_group.id = internalmarks.type_id')
            ->join('student_session', 'student_session.student_id = students.id')
            ->where([
                'internalmarks.class_id' => $class_id,
                'internalmarks.section_id' => $section_id,
                'internal_mark_group.subject_id' => $subject_id,
                'internalmarks.session_id' => $session_id,
                'internal_mark_group.type' => 'theory',
                'internal_mark_group.sub_type' => 'mm'
            ])->group_by('type_id')
            ->get()
            ->row();

        $data = new stdClass();

        $result = $this->db
            ->select('marks')
            ->from('internalmarks')
            ->join('students', 'students.id = internalmarks.student_id')
            ->join('student_session', 'student_session.student_id = students.id')
            ->where([
                'student_session.class_id' => $class_id,
                'student_session.section_id' => $section_id,
                'student_session.session_id' => $session_id,
                'type_id' => $exams->type_id,
            ])->order_by('students.firstname')
            ->get()
            ->result_array();
        $data->name = $exams->name;
        $data->max = $exams->max_mark;
        $data->marks = $result;
        return ($data);
    }
    public function getPcMarks($class_id, $section_id, $session_id, $subject_id)
    {
        $exams = $this->db
            ->select('internalmarks.type_id,name,max_mark')->from('internalmarks')
            ->join('students', 'students.id = internalmarks.student_id')
            ->join('internal_mark_group', 'internal_mark_group.id = internalmarks.type_id')
            ->join('student_session', 'student_session.student_id = students.id')
            ->where([
                'internalmarks.class_id' => $class_id,
                'internalmarks.section_id' => $section_id,
                'internalmarks.session_id' => $session_id,
                'internal_mark_group.subject_id' => $subject_id,
                'internal_mark_group.sub_type' => 'PC'
            ])->group_by('type_id')
            ->get()
            ->row();

        $data = new stdClass();

        $result = $this->db
            ->select('marks')
            ->from('internalmarks')
            ->join('students', 'students.id = internalmarks.student_id')
            ->join('student_session', 'student_session.student_id = students.id')
            ->where([
                'student_session.class_id' => $class_id,
                'student_session.section_id' => $section_id,
                'student_session.session_id' => $session_id,
                'type_id' => $exams->type_id,
            ])->order_by('students.firstname')
            ->get()
            ->result_array();
        $data->name = $exams->name;
        $data->max = $exams->max_mark;
        $data->marks = $result;

        return ($data);
    }

    public function getunittestMarks($class_id, $section_id, $session_id, $subject_id)
    {
        $exams = $this->db
            ->select('internalmarks.type_id,name,max_mark')->from('internalmarks')
            ->join('students', 'students.id = internalmarks.student_id')
            ->join('internal_mark_group', 'internal_mark_group.id = internalmarks.type_id')
            ->join('student_session', 'student_session.student_id = students.id')
            ->where([
                'student_session.class_id' => $class_id,
                'student_session.section_id' => $section_id,
                'student_session.session_id' => $session_id,
                'internal_mark_group.sub_type' => 'unit_test',
                'internal_mark_group.type' => 'theory',
                'internal_mark_group.subject_id' => $subject_id,
            ])->group_by('type_id')
            ->get()
            ->result_array();

        $data = array();
        foreach ($exams as $key => $exam) {
            $result = $this->db
                ->select('marks')
                ->from('internalmarks')
                ->join('students', 'students.id = internalmarks.student_id')
                ->join('student_session', 'student_session.student_id = students.id')
                ->where([
                    'student_session.class_id' => $class_id,
                    'student_session.section_id' => $section_id,
                    'student_session.session_id' => $session_id,
                    'type_id' => $exam['type_id'],
                ])->order_by('students.firstname')
                ->get()
                ->result_array();
            $data[$key]['name'] = $exams[$key]['name'];
            $data[$key]['max'] = $exams[$key]['max_mark'];
            $data[$key]['marks'] = $result;
        }
        return ($data);
    }
    public function getsessionalMarks($class_id, $section_id, $session_id, $subject_id)
    {
        $exams = $this->db
            ->select('internalmarks.type_id,name,max_mark')->from('internalmarks')
            ->join('students', 'students.id = internalmarks.student_id')
            ->join('internal_mark_group', 'internal_mark_group.id = internalmarks.type_id')
            ->join('student_session', 'student_session.student_id = students.id')
            ->where([
                'student_session.class_id' => $class_id,
                'student_session.section_id' => $section_id,
                'student_session.session_id' => $session_id,
                'internal_mark_group.sub_type' => 'sessional',
                'internal_mark_group.type' => 'theory',
                'internal_mark_group.subject_id' => $subject_id,
            ])->group_by('type_id')
            ->get()
            ->result_array();

        $data = array();
        foreach ($exams as $key => $exam) {
            $result = $this->db
                ->select('marks')
                ->from('internalmarks')
                ->join('students', 'students.id = internalmarks.student_id')
                ->join('student_session', 'student_session.student_id = students.id')
                ->where([
                    'student_session.class_id' => $class_id,
                    'student_session.section_id' => $section_id,
                    'student_session.session_id' => $session_id,
                    'type_id' => $exam['type_id'],
                ])->order_by('students.firstname')
                ->get()
                ->result_array();
            $data[$key]['name'] = $exams[$key]['name'];
            $data[$key]['max'] = $exams[$key]['max_mark'];
            $data[$key]['marks'] = $result;
        }
        return ($data);
    }

    public function getOsMarks($class_id, $section_id, $session_id, $subject_id)
    {
        $exams = $this->db
            ->select('internalmarks.type_id,name,max_mark')->from('internalmarks')
            ->join('students', 'students.id = internalmarks.student_id')
            ->join('internal_mark_group', 'internal_mark_group.id = internalmarks.type_id')
            ->join('student_session', 'student_session.student_id = students.id')
            ->where([
                'internalmarks.class_id' => $class_id,
                'internalmarks.section_id' => $section_id,
                'internalmarks.session_id' => $session_id,
                'internal_mark_group.subject_id' => $subject_id,
                'internal_mark_group.sub_type' => 'OS'
            ])->group_by('type_id')
            ->get()
            ->row();

        $data = new stdClass();

        $result = $this->db
            ->select('marks')
            ->from('internalmarks')
            ->join('students', 'students.id = internalmarks.student_id')
            ->join('student_session', 'student_session.student_id = students.id')
            ->where([
                'student_session.class_id' => $class_id,
                'student_session.section_id' => $section_id,
                'student_session.session_id' => $session_id,
                'type_id' => $exams->type_id,
            ])->order_by('students.firstname')
            ->get()
            ->result_array();
        $data->name = $exams->name;
        $data->max = $exams->max_mark;
        $data->marks = $result;

        return ($data);
    }
    public function getDopMarks($class_id, $section_id, $session_id, $subject_id)
    {
        $exams = $this->db
            ->select('internalmarks.type_id,name,max_mark')->from('internalmarks')
            ->join('students', 'students.id = internalmarks.student_id')
            ->join('internal_mark_group', 'internal_mark_group.id = internalmarks.type_id')
            ->join('student_session', 'student_session.student_id = students.id')
            ->where([
                'internalmarks.class_id' => $class_id,
                'internalmarks.section_id' => $section_id,
                'internalmarks.session_id' => $session_id,
                'internal_mark_group.subject_id' => $subject_id,
                'internal_mark_group.sub_type' => 'DOP'
            ])->group_by('type_id')
            ->get()
            ->row();

        $data = new stdClass();

        $result = $this->db
            ->select('marks')
            ->from('internalmarks')
            ->join('students', 'students.id = internalmarks.student_id')
            ->join('student_session', 'student_session.student_id = students.id')
            ->where([
                'student_session.class_id' => $class_id,
                'student_session.section_id' => $section_id,
                'student_session.session_id' => $session_id,
                'type_id' => $exams->type_id,
            ])->order_by('students.firstname')
            ->get()
            ->result_array();
        $data->name = $exams->name;
        $data->max = $exams->max_mark;
        $data->marks = $result;

        return ($data);
    }



    public function getStudents($class_id, $section_id, $session_id, $type_id)
    {

        $is_exist = $this->db->select('type_id')->where('type_id', $type_id)->get('internalmarks')->row();

        if ($is_exist) {

            $this->db->select('students.id, students.firstname,internalmarks.marks,internalmarks.id as exist_id')->join('internalmarks', 'internalmarks.student_id = students.id', 'left')->where('type_id', $type_id);
        } else {
            $this->db->select('students.id, students.firstname')->join('student_session', 'student_session.student_id = students.id')->join('internalmarks', 'internalmarks.student_id = students.id', 'left')->where([
                'student_session.class_id' => $class_id,
                'student_session.section_id' => $section_id,
                'student_session.session_id' => $session_id
            ])->group_by('students.id');
        }


        $result = $this->db->get('students')
            ->result_array();
            
        return ($result);
    }


    public function getTypebyClassSection($class_id, $section_id, $session_id, $subject_id)
    {
        $result = $this->db->select('id,name')->where(['class_id' => $class_id, 'section_id' => $section_id, 'session_id' => $session_id, 'subject_id' => $subject_id])->get('internal_mark_group')->result_array();


        return ($result);
    }
    function addMark($arr, $exist_id)
    {
        if ($exist_id) {
            $this->db->where('id', $exist_id)->update('internalmarks', $arr);
        } else {
            $this->db->insert('internalmarks', $arr);
        }
    }
}
