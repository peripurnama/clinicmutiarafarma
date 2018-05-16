<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->helper(array('url', 'language'));

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
    }

    public function index()
    {
        if (!$this->ion_auth->logged_in())
		{
			$this->load->view('login');
		} else {
            $data['user'] = $user = $this->ion_auth->user()->row();
            $group = 3;
            $group2 = 4;
            $group3 = 5;
            if ($this->ion_auth->is_admin()) {
                $this->load->view("admin/index", $data);
            } else if ($this->ion_auth->in_group($group)) {
                $this->load->view("doctors/index", $data);
            } else if ($this->ion_auth->in_group($group2)) {
                $this->load->view("patients/index", $data);
            } else if ($this->ion_auth->in_group($group3)) {
                $this->load->view("receptionists/index", $data);
            } else {
                $data['msg'] = "Username/email dan password salah";
                $this->load->view("login", $data);
            }
        }
    }

    public function tes()
    {
        echo "tes";
    }

    public function login()
    {
        $identity = $this->input->post('identity');
		$password = $this->input->post('password');
        $remember = TRUE; // remember the user
        $check = $this->ion_auth->login($identity, $password, $remember);
        if($check) {
            // echo 'hasil:' . $check;

            $group = 3;
            $group2 = 4;
            $group3 = 5;
            $group4 = 1;
            if ($this->ion_auth->in_group($group4)) {
                redirect('admin/index','refresh');
            } else if ($this->ion_auth->in_group($group)) {
                redirect('doctor/index','refresh');
            } else if ($this->ion_auth->in_group($group2)) {
                redirect('patient/index','refresh');
            } else if ($this->ion_auth->in_group($group3)) {
                redirect('receptionist/index','refresh');
            } else {
                $this->session->set_flashdata('message', 'You must be an admin to view this page');
                redirect('home');
            }

        } else {
            echo 'Email/username atau password salah';
        }
        
    }

    public function logout()
    {
        $this->ion_auth->logout();
        redirect('home','refresh');
    }

    // public function register()
    // {
    //     // $username = 'peripurnama';
	// 	// $password = '12345678';
    //     // $email = 'cisvapery@gmail.com';
    //     $username = 'admin';
	// 	$password = 'password';
	// 	$email = 'admin@admin.com';
	// 	$additional_data = array(
	// 							'first_name' => 'admin',
	// 							'last_name' => '',
	// 							);
	// 	$group = array('1'); // Sets user to admin.

	// 	$this->ion_auth->register($username, $password, $email, $additional_data, $group);
    // }

}

/* End of file Home.php */