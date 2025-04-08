<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Site extends Public_Controller {

    public function __construct() {
        parent::__construct();
        $this->check_installation();
        if ($this->config->item('installed') == true) {
            $this->db->reconnect();
        }

        $this->load->model("staff_model");
        $this->load->library('Auth');
        $this->load->library('Enc_lib');
        $this->load->library('mailer');
        $this->load->config('ci-blog');
        $this->mailer;
		
    }

    private function check_installation() {
        if ($this->uri->segment(1) !== 'install') {
            $this->load->config('migration');
            if ($this->config->item('installed') == false && $this->config->item('migration_enabled') == false) {
                redirect(base_url() . 'install/start');
            } else {
                if (is_dir(APPPATH . 'controllers/install')) {
                    echo '<h3>Delete the install folder from application/controllers/install</h3>';
                    die;
                }
            }
        }
    }

    function login() {
      
        if ($this->auth->logged_in()) {
            $this->auth->is_logged_in(true);
        }

        $data = array();
        $data['title'] = 'Login';
        $school = $this->setting_model->get();
        $notice_content = $this->config->item('ci_front_notice_content');
        $notices = $this->cms_program_model->getByCategory($notice_content, array('start' => 0, 'limit' => 5));
        $data['notice'] = $notices;
        $data['school'] = $school[0];
        $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/login', $data);
        } else {
            $login_post = array(
                'email' => $this->input->post('username'),
                'password' => $this->input->post('password')
            );
            $setting_result = $this->setting_model->get();
            $result = $this->staff_model->checkLogin($login_post);
           $f_year=$this->setting_model->get_financial_year($result->centre_id);
              
            if ($result) {
                if($result->is_active){
                     $setting_result = $this->setting_model->loginget($result->centre_id);
					
                $session_data = array(
                    'id' => $result->id,
                    'username' => $result->name,
                    'centre_id'=>$result->centre_id,
                    'email' => $result->email,
                    'roles' => $result->roles,
					'financial_year'=>$f_year['value'],
                    'date_format' => $setting_result['date_format'],
                    'currency_symbol' => $setting_result['currency_symbol'],
                    'start_month' => $setting_result['start_month'],
                    'school_name' => $setting_result['name'],
                    'timezone' => $setting_result['timezone'],
                    'sch_name' => $setting_result['name'],
                    'language' => array('lang_id' => $setting_result['lang_id'], 'language' => $setting_result['language']),
                    'is_rtl' => $setting_result['is_rtl'],
                    'theme' => $setting_result['theme'],
                );
                $this->session->set_userdata('admin', $session_data);
                $role = $this->customlib->getStaffRole();
                $role_name = json_decode($role)->name;
                $this->customlib->setUserLog($this->input->post('username'), $role_name);
            
                if (isset($_SESSION['redirect_to']))
                    redirect($_SESSION['redirect_to']);
                else
                    redirect('admin/admin/dashboard');
            }else{
                 $data['error_message'] = 'Your account is disabled please contact to administrator';
                    
                  $this->load->view('admin/login', $data);
            }
               
            } else {
                $data['error_message'] = 'Invalid Username or Password';
                $this->load->view('admin/login', $data);
            }
        }
    }

    function logout() {
        $admin_session = $this->session->userdata('admin');
        $student_session = $this->session->userdata('student');
        $this->auth->logout();
        if ($admin_session) {
            redirect('site/login');
        } else if ($student_session) {
            redirect('site/userlogin');
        } else {
            redirect('site/userlogin');
        }
    }

    function forgotpassword() {


        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/forgotpassword');
        } else {
            $email = $this->input->post('email');

            $result = $this->staff_model->getByEmail($email);

            if ($result && $result->email != "") {

                $verification_code = $this->enc_lib->encrypt(uniqid(mt_rand()));
                $update_record = array('id' => $result->id, 'verification_code' => $verification_code);
                $this->staff_model->add($update_record);
                $name = $result->name;

                $resetPassLink = site_url('admin/resetpassword') . "/" . $verification_code;

                $body = $this->forgotPasswordBody($name, $resetPassLink);
                $body_array = json_decode($body);

                if (!empty($this->mail_config)) {
                    $result = $this->mailer->send_mail($result->email, $body_array->subject, $body_array->body);
                }

                $this->session->set_flashdata('message', "Please check your email to recover your password");

                redirect('site/login', 'refresh');
            } else {
                $data = array(
                    'error_message' => 'Invalid Email'
                );
            }
            $this->load->view('admin/forgotpassword', $data);
        }
    }

    //reset password - final step for forgotten password
    public function admin_resetpassword($verification_code = null) {
        if (!$verification_code) {
            show_404();
        }

        $user = $this->staff_model->getByVerificationCode($verification_code);

        if ($user) {
            //if the code is valid then display the password reset form
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
            if ($this->form_validation->run() == false) {


                $data['verification_code'] = $verification_code;
                //render
                $this->load->view('admin/admin_resetpassword', $data);
            } else {

                // finally change the password
                $password = $this->input->post('password');
                $update_record = array(
                    'id' => $user->id,
                    'password' => $this->enc_lib->passHashEnc($password),
                    'verification_code' => ""
                );

                $change = $this->staff_model->update($update_record);
                if ($change) {
                    //if the password was successfully changed
                    $this->session->set_flashdata('message', "Password Reset successfully");
                    redirect('site/login', 'refresh');
                } else {
                    $this->session->set_flashdata('message', "Something went wrong");
                    redirect('admin_resetpassword/' . $verification_code, 'refresh');
                }
            }
        } else {
            //if the code is invalid then send them back to the forgot password page
            $this->session->set_flashdata('message', 'Invalid Link');
            redirect("site/forgotpassword", 'refresh');
        }
    }

    //reset password - final step for forgotten password
    public function resetpassword($role = null, $verification_code = null) {
        if (!$role || !$verification_code) {
            show_404();
        }

        $user = $this->user_model->getUserByCodeUsertype($role, $verification_code);

        if ($user) {
            //if the code is valid then display the password reset form
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
            if ($this->form_validation->run() == false) {

                $data['role'] = $role;
                $data['verification_code'] = $verification_code;
                //render
                $this->load->view('resetpassword', $data);
            } else {

                // finally change the password

                $update_record = array(
                    'id' => $user->user_tbl_id,
                    'password' => $this->input->post('password'),
                    'verification_code' => ""
                );

                $change = $this->user_model->saveNewPass($update_record);
                if ($change) {
                    //if the password was successfully changed
                    $this->session->set_flashdata('message', "Password Reset successfully");
                    redirect('site/userlogin', 'refresh');
                } else {
                    $this->session->set_flashdata('message', "Something went wrong");
                    redirect('user/resetpassword/' . $role . '/' . $verification_code, 'refresh');
                }
            }
        } else {
            //if the code is invalid then send them back to the forgot password page
            $this->session->set_flashdata('message', 'Invalid Link');
            redirect("site/ufpassword", 'refresh');
        }
    }

    function ufpassword() {
        $this->form_validation->set_rules('username', 'Email', 'trim|required|xss_clean');
        $this->form_validation->set_rules('user[]', 'User Type', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('ufpassword');
        } else {
            $email = $this->input->post('username');
            $usertype = $this->input->post('user[]');

            $result = $this->user_model->forgotPassword($usertype[0], $email);

            if ($result && $result->email != "") {

                $verification_code = $this->enc_lib->encrypt(uniqid(mt_rand()));
                $update_record = array('id' => $result->user_tbl_id, 'verification_code' => $verification_code);
                $this->user_model->updateVerCode($update_record);
                if ($usertype[0] == "student") {
                    $name = $result->firstname . " " . $result->lastname;
                } else {
                    $name = $result->name;
                }
                $resetPassLink = site_url('user/resetpassword') . '/' . $usertype[0] . "/" . $verification_code;

                $body = $this->forgotPasswordBody($name, $resetPassLink);
                $body_array = json_decode($body);

                if (!empty($this->mail_config)) {
                    $result = $this->mailer->send_mail($result->email, $body_array->subject, $body_array->body);
                }

                $this->session->set_flashdata('message', "Please check your email to recover your password");
                redirect('site/userlogin', 'refresh');
            } else {
                $data = array(
                    'error_message' => 'Invalid Email or User Type'
                );
            }
            $this->load->view('ufpassword', $data);
        }
    }

    function forgotPasswordBody($name, $resetPassLink) {
        //===============
        $subject = "Password Update Request";
        $body = 'Dear ' . $name . ', 
                <br/>Recently a request was submitted to reset password for your account. If you didn\'t make the request, just ignore this email. Otherwise you can reset your password using this link <a href="' . $resetPassLink . '"><button>Click here to reset your password</button></a>';
        $body .= '<br/><hr/>if you\'re having trouble clicking the password reset button, copy and paste the URL below into your web browser';
        $body .= '<br/>' . $resetPassLink;
        $body .= '<br/><br/>Regards,
                <br/>' . $this->customlib->getSchoolName();

        //======================
        return json_encode(array('subject' => $subject, 'body' => $body));
    }

    function landingpage() {
        //redirect('site/userlogin');
        
        $this->load->view('landingpage');
    }
    function userlogin() {
		//redirect('site/userlogin');
        if ($this->auth->user_logged_in()) {
            $this->auth->user_redirect();
        }
        $data = array();
        $data['title'] = 'Login';
        $school = $this->setting_model->get();
        $notice_content = $this->config->item('ci_front_notice_content');
        $notices = $this->cms_program_model->getByCategory($notice_content, array('start' => 0, 'limit' => 5));
        $data['notice'] = $notices;
        $data['school'] = $school[0];
        $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('userlogin', $data);
        } else {
            $login_post = array(
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password')
            );
            $login_details = $this->user_model->checkLogin($login_post);

            if (isset($login_details) && !empty($login_details)) {
                $user = $login_details[0];

                if ($user->is_active == "yes") {

                    if ($user->role == "student") {

                        $result = $this->user_model->read_user_information($user->id);
                    } else if ($user->role == "parent") {
                        $result = $this->user_model->checkLoginParent($login_post);
                    }
                     
                      
                    if ($result != false) {
                        $setting_result = $this->setting_model->loginget(1);
						//var_dump($setting_result);
						
                        if ($result[0]->role == "student") {
                            $session_data = array(
                                'id' => $result[0]->id,
                                'student_id' => $result[0]->user_id,
								'centre_id'=>$result[0]->centre_id, 
                                'role' => $result[0]->role,
                                'username' => $result[0]->firstname . " " . $result[0]->lastname,
                                'date_format' => $setting_result['date_format'],
                                'currency_symbol' => $setting_result['currency_symbol'],
                                'timezone' => $setting_result['timezone'],
                                'sch_name' => $setting_result['name'],
                                'language' => array('lang_id' => $setting_result['lang_id'], 'language' => $setting_result['language']),
                                'is_rtl' => $setting_result['is_rtl'],
                                'theme' => $setting_result['theme'],
                                'image' => $result[0]->image,
                            );
                            $this->session->set_userdata('student', $session_data);
                            $this->customlib->setUserLog($result[0]->username, $result[0]->role);
                            redirect('user/user/dashboard');
                        } else if ($result[0]->role == "parent") {
                           
                            if ($result[0]->guardian_relation == "Father") {
                                $image = $result[0]->father_pic;
                            } else if ($result[0]->guardian_relation == "Mother") {
                                $image = $result[0]->mother_pic;
                            } else if ($result[0]->guardian_relation == "Other") {
                                $image = $result[0]->guardian_pic;
                            }

                            $session_data = array(
                                'id' => $result[0]->id,
                                'student_id' => $result[0]->user_id,
                                'role' => $result[0]->role,
                                'username' => $result[0]->guardian_name,
                                'date_format' => $setting_result['date_format'],
                                'timezone' => $setting_result['timezone'],
                                'sch_name' => $setting_result['name'],
                                'currency_symbol' => $setting_result['currency_symbol'],
                                'language' => array('lang_id' => $setting_result['lang_id'], 
                                'language' => $setting_result['language']),
                                'is_rtl' => $setting_result['is_rtl'],
                                'theme' => $setting_result['theme'],
                                'image' => $image,
                            );
                            
                            $this->session->set_userdata('student', $session_data);
                            $s = array();
                            $user_id = ($result[0]->id);
                            $students_array = $this->student_model->read_siblings_students($user_id);
                        
                            $child_student = array();
                            foreach ($students_array as $std_key => $std_val) {
                                $child = array(
                                    'student_id' => $std_val->id,
                                    'name' => $std_val->firstname . " " . $std_val->lastname
                                );
                                $child_student[] = $child;
                            }
                            $this->session->set_userdata('parent_childs', $child_student);
                            $this->customlib->setUserLog($result[0]->username, $result[0]->role);
                            redirect('parent/parents/dashboard');
                        }
                    } else {
                        $data['error_message'] = 'Account Suspended';
                        $this->load->view('userlogin', $data);
                    }
                } else {
                    $data['error_message'] =  'Your account is disabled please contact to administrator';
                    $this->load->view('userlogin', $data);
                }
            } else {
                $data['error_message'] = 'Invalid Username or Password';
                $this->load->view('userlogin', $data);
            }
        }
    }
    
    function gcmDecrypt($data, $secret) { 
    $method = 'aes-256-gcm'; 
 
    //generating hash key 
    $key = substr(hash('sha256', $secret, true), 0, 32); 
     
    //Decoding string 
    $data = base64_decode($data);
    //exploding string to get IV, TAG and encrypted data 
    $explode_data = explode('::', $data); 
    if(isset($explode_data[0]) && isset($explode_data[1]) && isset($explode_data[2])) 
    { 
            list($iv, $tag, $encrypted_data) = $explode_data; 
     
            //Getting decrypting Data using above IV, TAG and Encrypted String 
            $decrypt_data = openssl_decrypt($encrypted_data, $method, $key, 
    OPENSSL_RAW_DATA, $iv, $tag); 
             
        } else { 
            $decrypt_data = 'Unable To Decrypt. Kindly Check the Encryption 
    Configuration'; 
        } 
        return $decrypt_data; 
    } 
    
    public function manuallogin($username,$password){
        $login_post = array(
                'username' => $username,
                'password' => $password,
            );
            $login_details = $this->user_model->checkLogin($login_post);

            if (isset($login_details) && !empty($login_details)) {
                $user = $login_details[0];

                if ($user->is_active == "yes") {

                    if ($user->role == "student") {

                        $result = $this->user_model->read_user_information($user->id);
                    } else if ($user->role == "parent") {
                        $result = $this->user_model->checkLoginParent($login_post);
                    }


                    if ($result != false) {
                        $setting_result = $this->setting_model->loginget(1);
                        //var_dump($setting_result);

                        if ($result[0]->role == "student") {
                            $session_data = array(
                                'id' => $result[0]->id,
                                'student_id' => $result[0]->user_id,
                                'centre_id' => $result[0]->centre_id,
                                'role' => $result[0]->role,
                                'username' => $result[0]->firstname . " " . $result[0]->lastname,
                                'date_format' => $setting_result['date_format'],
                                'currency_symbol' => $setting_result['currency_symbol'],
                                'timezone' => $setting_result['timezone'],
                                'sch_name' => $setting_result['name'],
                                'language' => array('lang_id' => $setting_result['lang_id'], 'language' => $setting_result['language']),
                                'is_rtl' => $setting_result['is_rtl'],
                                'theme' => $setting_result['theme'],
                                'image' => $result[0]->image,
                            );
                            $this->session->set_userdata('student', $session_data);
                            $this->customlib->setUserLog($result[0]->username, $result[0]->role);
                            return true;
                        } else if ($result[0]->role == "parent") {
                            if ($result[0]->guardian_relation == "Father") {
                                $image = $result[0]->father_pic;
                            } else if ($result[0]->guardian_relation == "Mother") {
                                $image = $result[0]->mother_pic;
                            } else if ($result[0]->guardian_relation == "Other") {
                                $image = $result[0]->guardian_pic;
                            }

                            $session_data = array(
                                'id' => $result[0]->id,
                                'student_id' => $result[0]->user_id,
                                'role' => $result[0]->role,
                                'username' => $result[0]->guardian_name,
                                'date_format' => $setting_result['date_format'],
                                'timezone' => $setting_result['timezone'],
                                'sch_name' => $setting_result['name'],
                                'currency_symbol' => $setting_result['currency_symbol'],
                                'language' => array(
                                    'lang_id' => $setting_result['lang_id'],
                                    'language' => $setting_result['language']
                                ),
                                'is_rtl' => $setting_result['is_rtl'],
                                'theme' => $setting_result['theme'],
                                'image' => $image,
                            );

                            $this->session->set_userdata('student', $session_data);
                            $s = array();
                            $user_id = ($result[0]->id);
                            $students_array = $this->student_model->read_siblings_students($user_id);

                            $child_student = array();
                            foreach ($students_array as $std_key => $std_val) {
                                $child = array(
                                    'student_id' => $std_val->id,
                                    'name' => $std_val->firstname . " " . $std_val->lastname
                                );
                                $child_student[] = $child;
                            }
                            $this->session->set_userdata('parent_childs', $child_student);
                            $this->customlib->setUserLog($result[0]->username, $result[0]->role);
                            return true;
                        }
                    } else {
                        $data['error_message'] = 'Account Suspended';
                        $this->load->view('userlogin', $data);
                    }
                } else {
                    $data['error_message'] =  'Your account is disabled please contact to administrator';
                    $this->load->view('userlogin', $data);
                }
            }
    }
    
    
     public function success()
    {
      
    $encrypted = $_POST['response']; 
    $secret = "IPoR2mo7dDJ5CB54EAy3OUuLXMJjVGiX";
    $decrypted = $this->gcmDecrypt($encrypted, $secret); 
        $decrypted_data=json_decode($decrypted);
    
    
     
    
    
        $merchTxnId=$decrypted_data->request_id;
        
        $payment_data=array('transaction_id'=>$merchTxnId,
         'data'=>$decrypted);
        $this->db->insert('payment_data',$payment_data);
   if ($decrypted_data->validation == "success" && $decrypted_data->transaction_details->transaction_status=="Paid") {
            // $qq = $this->db->select('fee_data')->where('transaction_id', $postData[3])->get('payment_session')->row();
            // echo $postData[3];

            $fee_data = json_decode($this->db->select('fee_data')->where('transaction_id', $merchTxnId)->get('payment_session')->row()->fee_data, true);
            $details = json_decode($this->db->select('details')->where('transaction_id', $merchTxnId)->get('payment_session')->row()->details, true);
            $userdetails = $this->db->select('student_id,role')->where('transaction_id', $merchTxnId)->get('payment_session')->row();
            if($userdetails->role=='parent'){
                
            $logindetails=$this->db->select('username,password')->where('childs',$userdetails->student_id)->get('users')->row_array();
            
            }
            if($userdetails->role=='student'){
                
            $logindetails=$this->db->select('username,password')->where('user_id',$userdetails->student_id)->get('users')->row_array();
            
            }
            // $fee_data = $this->session->userdata('fee_data');
            // $details = $this->session->userdata('details');


            $admin = $this->db->select('centre_id,value')->where('is_active', "yes")->get('financial_year')->row_array();
            $res = $this->db->select('invoice.*')->where('centre_id', $admin['centre_id'])->where('year', $admin['value'])->get('invoice');
            if ($res->num_rows() >= 0) {

                $result = max($res->result_array());
                $max_no = $result['number'] + 1;
                $inv_no = $max_no;
                $inv = array(
                    'number' => $max_no,
                    'centre_id' => $admin['centre_id'],
                    'year' => $admin['value'],
                    'invoice_no' => $inv_no
                );

                $this->db->insert('invoice', $inv);
                $inserted_invoice_id = $this->db->insert_id();
            }
            $invoice = $this->db->select_max('number')
                ->get('invoice')
                ->row()
                ->number;

            $inserted_id = $this->studentfeemaster_model->fee_deposit($fee_data, null, null, $invoice);

            if ($inserted_id) {
                $invoice_detail = json_decode($inserted_id);
                $amount = array(
                    'invoice_no' => $inv_no . "/" . substr($admin['value'], 0, 2),
                    'person_name' => $details['student_name'],
                    'amount' => $details['amount'],
                    'centre_id' => $admin['centre_id'],
                    'note' => $details['incomename'] . ': ' . $details['incometype'],
                    'name' => $details['incomename'],
                    'mode' => "NTT Data",
                    'date' => date('Y-m-d'),
                );
                $this->income_model->add($amount);
                
                if($logindetails){
                    $this->manuallogin($logindetails['username'],$logindetails['password']);
                }
               if($logindetails){
                    $this->manuallogin($logindetails['username'],$logindetails['password']);
                }
                if($userdetails->role=='parent'){
                
           redirect(base_url("parent/payment/successinvoice/" . $inv_no . "/" . $invoice_detail->sub_invoice_id));
            
            }
             if($userdetails->role=='student'){
                
            redirect(base_url("user/user/getfees"));
            
            }
            } else {
                echo "Payment failed";
            }
            // redirect(site_url('parent/parents/dashboard'));
        } else {
            echo "failed";
        }
    
         
    }
    
    
    public function successpayment()
    {
                // $encrypted="RXKBmdDOWpC/ZRozOjrwpm+ZdL9BZxbjOuwQVSe8OjqdIqvCqKU296OHkiWxg0pbcv5iFgd3uO+0qykAC0iCt7ZJr1qx1EZ4sY43x71C7Pg/6Ym8UCnBm2DxDokpqQ+ddT+xEaCuSr6EpECFSrHL2GshF63+h3omO9yew9ifAvhCdcOF2nV7+i2frUFkv5U69UKTsk2w2iD6NvVFUcIMyO34rND12AaDGssWaNdNbV8AP7U66xX7zoQili8FLZIJtAJZXAFGpldSf8t/4fd+SU5rDi9s3GMs8UtYLmzPzOThD/nNY2qicA2ZQXa56UCmz+OWCZrrbHts/9MjSZ874zx5lcHDTJBD4AvP0auSqfSKkbBrGDRqe7EJnw19cb/BoHdp7MlBK9zOK71Glca98xMAcEYn6jNinOF1un5fwFhB5ej+uOncBa04/iYrZSommtwubLV7lRWX6SYizM1skQ9Pqzi5hXwcjFuXwg97G56MTWKWD/1O0jbxgqoMidkLfzF7Sdz0L9U0yx0chH9sWj3BmACp8/kyESEJKvGRELCsr6AerUIOfFSoVG23YdA7KNwuKr3l4CTldAMwbpJOiW8o20+ONYtBZMehWKfu42lWoRrTU1xOAYc5l1gV7gU0xblVpvGmiJBNjWmXTopLYCTmyzj5wWKI47U5IXbfNbfJsf0w6q/OmlXoB+pQsqLYI7MijykAOWZ1Zqe29IcfCriSgvpc+k3iSsWSkv2JiXr9zekPM2pUwTiU/PcJWe3IrEH9fCWGlXCxdDxTOQBINTErICTtgQat//IJC/2ZhKDY2GaaBEnMlkYD/+9KkU4dR7F4ZA3o2sScPGLp98wG20rVHi2S2YFqtNzl3bqD/9KtKyinCKsFrqWhWpQjPClVE7ZsDgRnT6bkrZiOuUsTqQ/J2v32OF8l6jhOnZZX";

        $encrypted = $_POST['response']; 
        $secret = "IPoR2mo7dDJ5CB54EAy3OUuLXMJjVGiX";
        $decrypted = $this->gcmDecrypt($encrypted, $secret);
       
        $decrypted_data=json_decode($decrypted);
        $merchTxnId=$decrypted_data->request_id;
        
        
         $payment_data=array('transaction_id'=>$merchTxnId,
         'data'=>$decrypted);
        $this->db->insert('payment_data',$payment_data);
        
        $amount_paid=$decrypted_data->transaction_details->amount;
       if ($decrypted_data->validation == "success" && $decrypted_data->transaction_details->transaction_status=="Paid") {

            $fee_data = $this->db->select('fee_data')->where('transaction_id', $merchTxnId)->get('payment_session')->result_array();
            $details = $this->db->select('details')->where('transaction_id', $merchTxnId)->get('payment_session')->result_array();
            $userdetails = $this->db->select('student_id,role')->where('transaction_id', $merchTxnId)->get('payment_session')->row();
             if($userdetails->role=='parent'){
                
            $logindetails=$this->db->select('username,password')->where('childs',$userdetails->student_id)->get('users')->row_array();
            
            }
             if($userdetails->role=='student'){
                
            $logindetails=$this->db->select('username,password')->where('user_id',$userdetails->student_id)->get('users')->row_array();
            
            }

            // $fee_data = $this->session->userdata('fee_data');
            // $details = $this->session->userdata('details');


            $admin = $this->db->select('centre_id,value')->where('is_active', "yes")->get('financial_year')->row_array();
            $res = $this->db->select('invoice.*')->where('centre_id', $admin['centre_id'])->where('year', $admin['value'])->get('invoice');

            foreach ($fee_data as $key => $row) {
              if($amount_paid>0){
                  
                $fee_data_array = json_decode($row['fee_data'], true);
                $details_array = json_decode($details[$key]['details'], true);
                // echo "before ". $fee_data_array['amount_detail']['amount'] . " $amount_paid";
              if($amount_paid<=$fee_data_array['amount_detail']['amount']){
                    $fee_data_array['amount_detail']['amount']=(int)$fee_data_array['amount_detail']['amount']-((int)$fee_data_array['amount_detail']['amount']-(int)$amount_paid);
                    $amount_paid=(int)$fee_data_array['amount_detail']['amount']-(int)$amount_paid;
                }
                else{
                    
                    $amount_paid=(int)$amount_paid - (int)$fee_data_array['amount_detail']['amount'];
                }
                // echo '<br/>';
                // echo "after ". $fee_data_array['amount_detail']['amount'] . " $amount_paid";
                // echo '<br/>';
                // var_dump($fee_data_array);
              
                
                if ($res->num_rows() >= 0) {

                    $result = max($res->result_array());
                    $max_no = $result['number'] + 1;
                    $inv_no = $max_no;
                    $inv = array(
                        'number' => $max_no,
                        'centre_id' => $admin['centre_id'],
                        'year' => $admin['value'],
                        'invoice_no' => $inv_no
                    );

                    $this->db->insert('invoice', $inv);
                    $inserted_invoice_id = $this->db->insert_id();
                }
                $invoice = $this->db->select_max('number')
                    ->get('invoice')
                    ->row()
                    ->number;
                $inserted_id = $this->studentfeemaster_model->fee_deposit($fee_data_array, null, null, $invoice);
                if ($inserted_id) {
                    $invoice_detail = json_decode($inserted_id);
                    $amount = array(
                        'invoice_no' => $inv_no . "/" . substr($admin['value'], 0, 2),
                        'person_name' => $details_array['student_name'],
                        'amount' => $details_array['amount'],
                        'centre_id' => $admin['centre_id'],
                        'note' => $details_array['incomename'] . ': ' . $details_array['incometype'],
                        'name' => $details_array['incomename'],
                        'mode' => "NTT Data",
                        'date' => date('Y-m-d'),
                    );
                    $this->income_model->add($amount);
                }
            }
            }
            if($logindetails){
                    $this->manuallogin($logindetails['username'],$logindetails['password']);
                }
                if($userdetails->role=='parent'){
                
           redirect(base_url("parent/payment/successinvoice/" . $inv_no . "/" . $invoice_detail->sub_invoice_id));
            
            }
             if($userdetails->role=='student'){
                
             redirect(base_url("user/user/getfees"));
            
            }
            
            // redirect(site_url('parent/parents/dashboard'));
        } else {
            echo "failed";
        }
       
       
       
    }
    
    public function update()
    {
        $cal = $this->db->where('update_status',0)->get('weekly_calendar')->row_array();

        
            $insert_array = array();
            $period_timing = $this->db->where([
                'id' => $cal['period_id']
            ])->get('period_timing')->row();
            
            if($period_timing){
                $periods = ['period_one', 'period_two', 'period_three', 'period_four', 'period_five', 'period_six', 'period_seven', 'period_eight'];
                $period_name= ['eight_to_nine', 'nine_to_ten', 'ten_to_eleven', 'eleven_to_twelve', 'twelve_to_one', 'two_to_three', 'three_to_four', 'four_to_five'];

                $period_key = ['eight_to_nine_hour', 'nine_to_ten_hour', 'ten_to_eleven_hour', 'eleven_to_twelve_hour', 'twelve_to_one_hour', 'two_to_three_hour', 'three_to_four_hour', 'four_to_five_hour'];
                foreach ($periods as $index => $period) {
                    $to = new DateTime($period_timing->{$period . "_to"});
                    $from = new DateTime($period_timing->{$period . "_from"});
                    $interval = $to->diff($from);
                    $minutes=($interval->h) * 60 + ($interval->i);
                    $insert_array[$period_key[$index]] = $minutes;
                    $students=$this->db->select('*,student_period_attendance.id as at_id')->where(['date'=>$cal['date'],'period'=>$period_name[$index]])->get('student_period_attendance')->result_array();
                    
                    foreach($students as $student){
                        if($student['attendencetype']==0){
                            $this->db->where('id',$student['at_id'])->update('student_period_attendance',['actual'=>$minutes,'minutes'=>$minutes]);   
                        }
                        else if($student['attendencetype']==1){
                            $this->db->where('id',$student['at_id'])->update('student_period_attendance',['actual'=>$minutes,'minutes'=>0]); 
                        }
                        
                    }
                }
                $this->db->where('id', $cal['id'])->update('weekly_calendar', $insert_array);
            }
            
        
         $this->db->where('id',$cal['id'])->update('weekly_calendar',['update_status'=>1]);
    }
    
    public function test(){
        echo "here";
    }
    

}

?>