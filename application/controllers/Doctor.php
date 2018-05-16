<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Doctor extends CI_Controller {

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

        $group = 3;
		if ($this->ion_auth->in_group($group))
		{
            $this->session->set_flashdata('message', 'You must be part of the group 1 to view this page');
            $data['user'] = $user = $this->ion_auth->user()->row();
			$this->load->view('doctors/index', $data);
		} else {
            
            redirect('home','refresh');
            
        }
    }

}

/* End of file Doctor.php */
