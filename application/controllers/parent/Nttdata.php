<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Nttdata extends Parent_Controller
{

    public $setting = "";

    function __construct()
    {
        parent::__construct();

        $this->load->library('stripe_payment');

        $this->setting = $this->setting_model->get();
    }

    public function index()
    {
        $this->session->set_userdata('top_menu', 'Library');
        $this->session->set_userdata('sub_menu', 'book/index');
        $data = array();
        $data['params'] = $this->session->userdata('params');
        $data['setting'] = $this->setting;

        $this->load->view('parent/nttdata', $data);
    }
    public function nttdatapayment()
    {
        $this->session->set_userdata('top_menu', 'Library');
        $this->session->set_userdata('sub_menu', 'book/index');
        $data = array();
        $data['params'] = $this->session->userdata('params');
        $data['setting'] = $this->setting;

        $this->load->view('parent/nttdatapayment', $data);
    }



    // public function paymentTest(){
    //     var_dump("HEra");exit;
    //     $val = $_POST;

    //     $student_fees_master_id = $this->input->post('student_fees_master_id');
    //     $fee_groups_feetype_id = $this->input->post('fee_groups_feetype_id');
    //     $student_id = $this->input->post('student_id');

    //     $student_details = $this->db->select('centre_id,firstname,lastname')->where('id', $student_id)->get('students')->row();

    //     if ($val['fine']) {
    //         $finalAmount = $val['amount'] + $val['fine'];
    //     } else {
    //         $finalAmount = $val['amount'];
    //     }
    //     $json_array = array(
    //         'amount' => $val['amount'],
    //         'date' => date('Y-m-d'),
    //         'amount_discount' => 0,
    //         'amount_fine' => $val['fine'],
    //         'description' => "Online fees deposit through NTTData TXN ID: " . $val['txn_id'],
    //         'payment_mode' => 'NTTdata',
    //     );

    //     $data = array(
    //         'student_fees_master_id' => $student_fees_master_id,
    //         'fee_groups_feetype_id' => $fee_groups_feetype_id,
    //         'amount_detail' => $json_array
    //     );
    //     $details = array(
    //         "centre_id" => $student_details->centre_id,
    //         "amount" => $val['amount'],
    //         "incomename" => $this->input->post('incomename'),
    //         "incometype" => $this->input->post('incometype'),
    //         "student_name" => $student_details->firstname . " " . $student_details->lastname,
    //     );
    //     $this->session->set_userdata('fee_data', $data);
    //     $this->session->set_userdata('details', $details);

    //     $send = array(
    //         'fee_data' => json_encode($data),
    //         'details' => json_encode($details),
    //         'transaction_id' => $val['txn_id']
    //     );

    //     $this->db->insert('payment_session', $send);


    //     /////////////////////////////////

    //     $merchTxnId = $val['txn_id'];


    //     //echo $decData;      

    //     $payUrl = "https://payment1.atomtech.in/ots/aipay/auth"; 

    //     $this->load->library("AtompayRequest",array(
    //               "Login" => "491481",
    //               "Password" => "Dmerf159@10",
    //               "ProductId" => "EDUC",
    //               "Amount" => "50.00", 
    //               "TransactionCurrency" => "INR",
    //               "TransactionAmount" => "50.00",
    //               "ReturnUrl" => base_url("parent/nttdata/payment"),
    //               "ClientCode" => "007",
    //               "TransactionId" => $merchTxnId,
    //               "CustomerName" => "Atom Dev", // udf1
    //               "CustomerEmailId" => "atomdev@gmail.com", // udf2
    //               "CustomerMobile" => "8888888888", // udf3
    //               "CustomerBillingAddress" => "Andheri Mumbai", // udf4
    //               "CustomerAccount" => "1235687", 
    //               "url" => $payUrl,
    //               "mode" => 'prod',  // set prod for production
    //               "RequestEncypritonKey" => "F73D216148A10A88C2534121AA7CB3D9",
    //               "Salt" => "F73D216148A10A88C2534121AA7CB3D9",
    //               "ResponseDecryptionKey" => "21E782AA0193A6B27123A4D64ACAD3F5",
    //               "ResponseSalt" => "21E782AA0193A6B27123A4D64ACAD3F5",
    //       )); 

    // //     $this->load->library("AtompayRequest",array(
    // //         "Login" => "340834",
    // //         "Password" => "b7f6b39c",
    // //         "ProductId" => "TUITIONFEES",
    // //         "Amount" => $amount_balance,
    // //         "TransactionCurrency" => "INR",
    // //         "TransactionAmount" => $amount_balance,
    // //         "ReturnUrl" => "https://sjcpsr.nursingadmission.net.in/parent/atom/success",
    // //         "ClientCode" => "007",
    // //         "TransactionId" => $transactionId,
    // //         "CustomerEmailId" => $customer_email ,
    // //         "CustomerMobile" => $customer_mobile,
    // //         "udf1" => $customer_name, // optional udf1
    // //         "udf2" => $customer_mobile, // optional udf2
    // //         "udf3" => $feedetails, // optional udf3
    // //         "udf4" => "udf4", // optional udf4
    // //         "udf5" => "udf5", // optional udf5
    // //         "CustomerAccount" => "639827",
    // //         "url" => $payUrl,
    // //         "RequestEncypritonKey" => "6B298B232D8661469A9E82309C4AD49A",
    // //         "ResponseDecryptionKey" => "2EF4903E59748FBFA97F77711CE21543",
    // // ));

    //       echo $this->atompayrequest->payNow();



    //     /////////////////////////////////

    //     // echo json_encode($data);
    // }

    public function payment()
    {
        $val = $_POST;
        $student_fees_master_id = $this->input->post('student_fees_master_id');
        $fee_groups_feetype_id = $this->input->post('fee_groups_feetype_id');
        $student_id = $this->input->post('student_id');
        $student_details = $this->db->select('centre_id,firstname,lastname,guardian_phone,email,father_phone,mobileno')->where('id', $student_id)->get('students')->row();
        if($student_details->guardian_phone){
            $phone_number=$student_details->guardian_phone;
        }
        else if($student_details->father_phone){
            $phone_number=$student_details->father_phone;
        }
        else if($student_details->mobileno){
            $phone_number=$student_details->mobileno;
        }
        if ($val['fine']) {
            $finalAmount = $val['amount'] + $val['fine'];
        } else {
            $finalAmount = $val['amount'];
        }
        $phone_number = preg_replace('/^\+91|\D/', '', $phone_number);
        $json_array = array(
            'amount' => $val['amount'],
            'date' => date('Y-m-d'),
            'amount_discount' => 0,
            'amount_fine' => $val['fine'],
            'description' => "Online fees deposit through YesBank TXN ID: " . $val['txn_id'],
            'payment_mode' => 'Online Payment',
        );

        $data = array(
            'student_fees_master_id' => $student_fees_master_id,
            'fee_groups_feetype_id' => $fee_groups_feetype_id,
            'amount_detail' => $json_array
        );
        $details = array(
            "centre_id" => $student_details->centre_id,
            "amount" => $val['amount'],
            "incomename" => $this->input->post('incomename'),
            "incometype" => $this->input->post('incometype'),
            "student_name" => $student_details->firstname . " " . $student_details->lastname,
        );
        $this->session->set_userdata('fee_data', $data);
        $this->session->set_userdata('details', $details);

        $send = array(
            'fee_data' => json_encode($data),
            'details' => json_encode($details),
            'transaction_id' => $val['txn_id'],
            'student_id'=>$student_id,
            'student_name'=>$student_details->firstname . " " . $student_details->lastname,
            'role'=>'parent',
        );

        $this->db->insert('payment_session', $send);


        /////////////////////////////////

        $merchTxnId = $val['txn_id'];

        $datenow = date("Y-m-d H:m:s");
        // $jsondata = '{
        // "merchant_code": ' . $merchTxnId . ', 
        // "request": { 
        //     "request_id": "123", 
        //     "template_id": "10407", 
        //     "return_url": "http://localhost/wims-medical/site/success", 
        //     "mobile": "9022045665", 
        //     "email": "tejas@gmail.com", 
        //     "name": "tejas", 
        //     "due_date": "10-12-2024", 
        //     "amount": "100.00", 
        //     "remakrs": "Payment from XYZ" 
        //     } 
        // }';

        // $mandatory_collectionData = array( 
        //     "mobile" => "9022045665", 
        //     "email" => "tejas@gmail.com", 
        //     "amount" => $finalAmount, 
        //     "name" => "testname", 
        //     "template_id" => "10407", 
        //     "request_id" => $merchTxnId, 
        //     "return_url" =>  base_url("site/success"), 
        // ); 
        
        $mandatory_collectionData = array( 
            "mobile" => $phone_number, 
            "email" => "medicalcollege@drmoopensmc.ac.in", 
            "amount" => $finalAmount, 
            "name" => $student_details->firstname, 
            "template_id" => "10407", 
            "request_id" => $merchTxnId, 
            "return_url" =>  base_url("site/success"), 
        );
        
        
        
        // $merchant_code = "drmo_8999_4PZxU"; 
        // $secret = "8a0HyBU1ZCrxV7kKn967WES9CtqmQR8W";
        $merchant_code = "dmed_101_tjuhX"; 
        $secret = "IPoR2mo7dDJ5CB54EAy3OUuLXMJjVGiX";
        $additional_info_arr = array();
        $collection_data = json_encode(array_merge($mandatory_collectionData, 
        $additional_info_arr)); 
        $data = $this->gcmEncrypt($collection_data, $secret); 

        /////////////////////////////////
        echo json_encode($data);
    }




    public function paymentBulk()
    {


        $val = $_POST;

        $student_fees_master_id = explode("-", $this->input->post('student_fees_master_id'));
        $fee_groups_feetype_id = explode("-", $this->input->post('fee_groups_feetype_id'));
        $bulk_amount = explode("-", $this->input->post('bulk_amount'));
        $bulk_fine = explode("-", $this->input->post('fine_bulk'));
        $student_id = $this->input->post('student_id');

        $student_details = $this->db->select('centre_id,firstname,lastname,guardian_phone,email,father_phone,mobileno')->where('id', $student_id)->get('students')->row();
        if($student_details->guardian_phone){
            $phone_number=$student_details->guardian_phone;
        }
        else if($student_details->father_phone){
            $phone_number=$student_details->father_phone;
        }
        else if($student_details->mobileno){
            $phone_number=$student_details->mobileno;
        }
        if ($val['fine']) {
            $finalAmount = $val['amount'] + $val['fine'];
        } else {
            $finalAmount = $val['amount'];
        }
        $phone_number = preg_replace('/^\+91|\D/', '', $phone_number);
        foreach ($student_fees_master_id as $key => $row) {
            $json_array = array(
                'amount' => $bulk_amount[$key],
                'date' => date('Y-m-d'),
                'amount_discount' => 0,
                'amount_fine' => $bulk_fine[$key],
                'description' => "Online fees deposit through YesBank TXN ID: " . $val['txn_id'],
                'payment_mode' => 'Online Payment',
            );

            $data = array(
                'student_fees_master_id' => $row,
                'fee_groups_feetype_id' => $fee_groups_feetype_id[$key],
                'amount_detail' => $json_array
            );
            $details = array(
                "centre_id" => $student_details->centre_id,
                "amount" => $val['amount'],
                "incomename" => $this->input->post('incomename'),
                "incometype" => $this->input->post('incometype'),
                "student_name" => $student_details->firstname . " " . $student_details->lastname,
            );
            $this->session->set_userdata('fee_data', $data);
            $this->session->set_userdata('details', $details);

             $send = array(
                'fee_data' => json_encode($data),
                'details' => json_encode($details),
                'transaction_id' => $val['txn_id'],'student_id'=>$student_id,
            'student_name'=>$student_details->firstname . " " . $student_details->lastname,
            'role'=>'parent',
            );

            $this->db->insert('payment_session', $send);
        }

        $merchTxnId = $val['txn_id'];

        $mandatory_collectionData = array( 
            "mobile" => $phone_number, 
            "email" => "medicalcollege@drmoopensmc.ac.in", 
            "amount" => $finalAmount, 
            "name" => $student_details->firstname, 
            "template_id" => "10407", 
            "request_id" => $merchTxnId, 
            "return_url" =>  base_url("site/successpayment"), 
        );
        
        
        // $merchant_code = "drmo_8999_4PZxU"; 
        // $secret = "8a0HyBU1ZCrxV7kKn967WES9CtqmQR8W";
        $merchant_code = "dmed_101_tjuhX"; 
        $secret = "IPoR2mo7dDJ5CB54EAy3OUuLXMJjVGiX";
        $additional_info_arr = array();
        $collection_data = json_encode(array_merge($mandatory_collectionData, 
        $additional_info_arr)); 
        $data = $this->gcmEncrypt($collection_data, $secret); 

        echo json_encode($data);
    }



    function gcmEncrypt($data, $secret){
        $method = 'aes-256-gcm';
        //generating hash key
        $key = substr(hash('sha256', $secret, true), 0, 32);
        //generating random IV
        $iv = openssl_random_pseudo_bytes( openssl_cipher_iv_length( $method ) );
        //encrypting using AES-256-GCM, generated IV and generated Key
        $result = openssl_encrypt($data , $method , $key , OPENSSL_RAW_DATA , $iv ,
        $tag);
        //Concatenating string to get resultant string
        $encrypted_data = $iv.'::'.$tag.'::'.$result;
        //returning final string by applying base64 Encoding on above string.
        return base64_encode($encrypted_data);
        }


    // function ssl_encrypt_aes($data, $secret)
    // {
    //     $method = 'aes-256-cbc';

    //     // Must be exact 32 chars (256 bit) 
    //     // You must store this secret random key in a safe place of your system. 
    //     $key = substr(hash('sha256', $secret, true), 0, 32);

    //     // IV must be exact 16 chars (128 bit) 
    //     $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0)
    //         . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) .
    //         chr(0x0) . chr(0x0);

    //     return base64_encode(openssl_encrypt(
    //         $data,
    //         $method,
    //         $key,
    //         OPENSSL_RAW_DATA,
    //         $iv
    //     ));
    // }




    public function success()
    {
        // 0300 live

        $postData = explode('|', $this->input->post('msg'));

        if ($postData[0] == "0300") {
            $fee_data = $this->session->userdata('fee_data');
            $details = $this->session->userdata('details');

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
                    'mode' => "WorldLine",
                    'date' => date('Y-m-d'),
                );
                $this->income_model->add($amount);
                redirect(base_url("parent/payment/successinvoice/" . $inv_no . "/" . $invoice_detail->sub_invoice_id));
            } else {
                echo "Payment failed";
            }
            redirect(site_url('parent/parents/dashboard'));
        } else {
            echo "failed";
        }
    }

    // public function success()
    // {
    //     $postData = explode('|', $this->input->post('msg'));
    //     if ($postData[0] == "0300") {
    //         $fee_data = $this->session->userdata('fee_data');
    //         $details = $this->session->userdata('details');

    //         $admin = $this->db->select('centre_id,value')->where('is_active', "yes")->get('financial_year')->row_array();
    //         $res = $this->db->select('invoice.*')->where('centre_id', $admin['centre_id'])->where('year', $admin['value'])->get('invoice');
    //         if ($res->num_rows() >= 0) {

    //             $result = max($res->result_array());
    //             $max_no = $result['number'] + 1;
    //             $inv_no = $max_no;
    //             $inv = array(
    //                 'number' => $max_no,
    //                 'centre_id' => $admin['centre_id'],
    //                 'year' => $admin['value'],
    //                 'invoice_no' => $inv_no
    //             );

    //             $this->db->insert('invoice', $inv);
    //             $inserted_invoice_id = $this->db->insert_id();
    //         }
    //         $invoice = $this->db->select_max('number')
    //             ->get('invoice')
    //             ->row()
    //             ->number;
    //         $inserted_id = $this->studentfeemaster_model->fee_deposit($fee_data,null,null,$invoice);

    //         if ($inserted_id) {
    //             $invoice_detail = json_decode($inserted_id);
    //             $amount = array(
    //                 'invoice_no' => $inv_no . "/" . substr($admin['value'], 0, 2),
    //                 'person_name' => $details['student_name'],
    //                 'amount' => $details['amount'],
    //                 'centre_id' => $admin['centre_id'],
    //                 'note' => $details['incomename'] . ': ' . $details['incometype'],
    //                 'name' => $details['incomename'],
    //                 'mode' => "WorldLine",
    //                 'date' => date('Y-m-d'),
    //             );
    //             $this->income_model->add($amount);
    //             redirect(base_url("parent/payment/successinvoice/" . $inv_no . "/" . $invoice_detail->sub_invoice_id));
    //         } else {
    //             echo "Payment failed";
    //         }
    //         redirect(site_url('parent/parents/dashboard'));
    //     } else {

    //     }
    // }
}
