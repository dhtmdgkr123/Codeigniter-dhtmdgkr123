<?php
if(! class_exists('Login')) {
	defined('BASEPATH') or exit('No direct script access allowed');
	class Login extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
		}
		public function index() : void 
		{
			if ($this->file->checkView('Login/head', 'Login/body', 'Login/footer')) {
				$this->load->view('Login/head');
				$this->load->view('Login/body');
				$this->load->view('Login/footer');
			} else {
				show_404();
			}
		}
	}
}