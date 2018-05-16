<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

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
        if (!$this->ion_auth->is_admin())
        {
            $this->session->set_flashdata('message', 'You must be an admin to view this page');
            redirect('home');
        } else {
            $data['user'] = $user = $this->ion_auth->user()->row();
            $this->load->view("admin/index", $data);
        }
        
    }

}

/* End of file Admin.php */
