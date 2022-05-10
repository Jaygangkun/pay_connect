<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PageController extends CI_Controller {

	public function __construct(){
		
        parent::__construct();

		$this->load->model("BatchFiles");
		$this->load->model("Users");
		$this->load->model("UserActivities");

		$this->load->library('mailer');
	}

	public function index(){
		if(!isset($_SESSION['user_id'])){
			redirect('/login');
		}
		else{
			redirect('/dashboard');
		}
	}

	public function login(){
		// $_SESSION['user_id'] = 1;
		// $_SESSION['role'] = 1;
		// redirect(base_url('/dashboard'), 'refresh');
		// return;
		if($this->input->post('submit')){

			if($this->input->post('user_name') == '' || $this->input->post('password') == '') {
				$this->session->set_flashdata('warning', 'Please input both user name and password!');
				redirect(base_url('/login'));
			}

			if(!$this->Users->checkLogin($this->input->post('user_name'), $this->input->post('password'))) {
				$this->session->set_flashdata('warning', 'User not exist!');
				redirect(base_url('/login'), 'refresh');
			}

			if(!$this->Users->isResetPassword($this->input->post('user_name'))) {
				redirect(base_url('/recovery-password'), 'refresh');
			}
			
			$result = $this->Users->getByUsername($this->input->post('user_name'));
			if($result == null) {
				$this->session->set_flashdata('warning', 'User not find!');
				redirect(base_url('/login'), 'refresh');
			}

			if($result['login_status'] == 1) {
				$this->session->set_flashdata('warning', 'User already login now!');
				redirect(base_url('/login'), 'refresh');
			}

			$this->Users->updateLoginStatus($result['id'], 1);

			$this->UserActivities->add(array(
				'user_id' => $result['id'],
				'ip' => getIP(),
				'activity' => 'login'
			));

			$_SESSION['user_id'] = $result['id'];
			$_SESSION['role'] = $result['role'];
			$_SESSION['full_name'] = $result['full_name'];

			redirect(base_url('/dashboard'), 'refresh');

		    // for google recaptcha
    		// $this->form_validation->set_rules('email', 'Email', 'trim|required');
			// $this->form_validation->set_rules('password', 'Password', 'trim|required');

			// if ($this->form_validation->run() == FALSE) {
			// 	$this->load->view('auth/login');
			// }
			// else {

				

			// 	$results = $this->Users->exist($this->input->post('email'), $this->input->post('password'));
			// 	if(count($results)){
			// 		$result = $results[0];
			// 		if($result['is_verify'] == 0){
			//     		$this->session->set_flashdata('warning', 'Please verify your email address!');
			// 			redirect(base_url('/login'));
			// 			exit;
			//     	}
			// 		if($result['is_active'] == 0){
			//     		$this->session->set_flashdata('warning', 'Your account has been deactivated!');
			// 			redirect(base_url('/login'));
			// 			exit;
			//     	}
				
			// 		$_SESSION['user_id'] = $result['id'];
			// 		$_SESSION['role'] = $result['role'];

			// 		redirect(base_url('/dashboard'), 'refresh');
				
			// 	}
			// 	else{
			// 		$data['msg'] = 'Invalid Email or Password!';
			// 		$this->load->view('auth/login', $data);
			// 	}
			// }
		}
		else{
			unset($_SESSION['user_id']);
			$this->load->view('auth/login');
		}
	}

	public function logout() {
		$this->UserActivities->add(array(
			'user_id' => $_SESSION['user_id'],
			'ip' => getIP(),
			'activity' => 'logout'
		));

		$this->Users->updateLoginStatus($_SESSION['user_id'], 0);

		unset($_SESSION['user_id']);
		$this->load->view('auth/login');
	}

	public function recoveryPassword(){
		
		if($this->input->post('submit')){
		                
			if($this->input->post('email') == '') {
				$this->session->set_flashdata('warning', 'Please input your email address!');
				redirect(base_url('/recovery-password'));
			}

			if(!$this->Users->existEmail($this->input->post('email'))) {
				$this->session->set_flashdata('warning', 'email doesn\'t exist!');
				redirect(base_url('/recovery-password'));
			}

			$reset_token = bin2hex(openssl_random_pseudo_bytes(16));
			$this->Users->updateResetToken($this->input->post('email'), $reset_token);
			
			$reset_page_link = base_url('/reset-password')."/".$reset_token;

			sendMail($this->input->post('email'), 'Reset password', 'this is reset link<br><a href="'.$reset_page_link.'">'.$reset_page_link."</a>");
			$this->session->set_flashdata('success', 'reset password link sent');
			redirect(base_url('/recovery-password'));

			return;

			//checking server side validation
			// $this->form_validation->set_rules('email', 'Email', 'valid_email|trim|required');
			// if ($this->form_validation->run() === FALSE) {
			// 	$this->load->view('auth/forgot-password');
			// 	return;
			// }
			// $email = $this->input->post('email');
			// $response = $this->Users->check_user_mail($email);
			// if($response){
			// 	$rand_no = rand(0,1000);
			// 	$pwd_reset_code = md5($rand_no.$response['id']);
			// 	$this->Users->update_reset_code($pwd_reset_code, $response['id']);

			// 	$result = $this->mailer->sendResetPasswordMail(array(
			// 		'username' => strtoupper($response['first_name'].' '.$response['last_name']),
			// 		'reset_link' => base_url('/reset-password/').$pwd_reset_code,
			// 		'to' => $response['email']
			// 	));

			// 	if($result['success']){
			// 		$this->session->set_flashdata('success', 'We have sent instructions for resetting your password to your email');
			// 		redirect(base_url('/forgot-password'));
			// 	}
			// 	else{
			// 		$this->session->set_flashdata('error', 'There is the problem on your email');
			// 		redirect(base_url('/forgot-password'));
			// 	}
			// }
			// else{
			// 	$this->session->set_flashdata('error', 'The Email that you provided are invalid');
			// 	redirect(base_url('/forgot-password'));
			// }
		}
		else{
			$this->load->view('auth/recovery-password');	
		}
	}

	public function resetPassword($reset_token){
		if($this->input->post('submit')){
			// $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
			// $this->form_validation->set_rules('re_password', 'Password Confirmation', 'trim|required|matches[password]');

			// if ($this->form_validation->run() == FALSE) {
			// 	$data['reset_token'] = $reset_token;
			// 	$this->session->set_flashdata('waring','Please use same pas');
			// 	$this->load->view('auth/reset-password',$data);
			// }   
			if($this->input->post('password') == '' || $this->input->post('re_password') == '') {
				$this->session->set_flashdata('warning','Please input 2 fields');
				redirect(base_url('/reset-password').'/'.$reset_token);
				// $data['reset_token'] = $reset_token;
				// $this->load->view('auth/reset-password',$data);
			}
			if($this->input->post('password') != $this->input->post('re_password')) {
				$this->session->set_flashdata('warning','Please use same fields');
				redirect(base_url('/reset-password').'/'.$reset_token);
				// $data['reset_token'] = $reset_token;
				// $this->load->view('auth/reset-password',$data);
			}

			$this->Users->resetPassword($reset_token, $this->input->post('password'));
			$this->session->set_flashdata('success','New password has been Updated successfully');
			redirect(base_url('/login'));
		}
		else{
			
			if($this->Users->existResetToken($reset_token)){
				$data['reset_token'] = $reset_token;
				$this->load->view('auth/reset-password',$data);
			}
			else{
				$this->session->set_flashdata('error','Password Reset Code is either invalid or expired.');
				redirect(base_url('/forgot-password'));
			}
		}
	}

	public function dashboard(){
		if(!isset($_SESSION['user_id']) || !isset($_SESSION['role'])){
			redirect(base_url('/login'));
		}

		$data = array();

		$data['title'] = 'Dashboard';
		$data['sub_page'] = 'dashboard';

		if($_SESSION['role'] == 1) {
			// Admin
			$data['batch_files'] = array(
				'processed' => count($this->BatchFiles->allByStatus('processed')),
				'pending' => count($this->BatchFiles->allByStatus('pending')),
				'total' => count($this->BatchFiles->all()),
			);
		}
		else {
			$data['batch_files'] = array(
				'processed' => count($this->BatchFiles->allByStatus('processed')),
				'pending' => count($this->BatchFiles->allByStatus('pending')),
				'acked' => count($this->BatchFiles->allByStatus('acked')),
			);
		}
		

		$this->load->view('dashboard/basic', $data);
	}

	public function verify($token){
		$result = $this->Users->email_verification($token);
		if($result){
			$this->session->set_flashdata('success', 'Your email has been verified, you can now login.');	
			redirect(base_url('/login'));
		}
		else{
			$this->session->set_flashdata('error', 'The url is either invalid or you already have activated your account.');	
			redirect(base_url('/login'));
		}	
	}

	public function profile(){
		if($this->input->post('submit')){
		                
			$this->form_validation->set_rules('username', 'Username', 'trim|required');
			$this->form_validation->set_rules('first_name', 'Firstname', 'trim|required');
			$this->form_validation->set_rules('last_name', 'Lastname', 'trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]');
			$this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'trim|required|matches[password]');

			if ($this->form_validation->run() == FALSE) {
				$this->load->view('admin/profile', array(
					'username' => $this->input->post('username'),
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'email' => $this->input->post('email')
				));
			}
			else{
				$update_result = $this->Users->updateProfile(
					isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '', array(
					'username' => $this->input->post('username'), 
					'email' => $this->input->post('email'), 
					'password' => $this->input->post('password'),
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name')
				));

				if($update_result){
					$this->session->set_flashdata('success', 'Profile updated successfully.');	
					redirect(base_url('/profile'));
				}
				else{
					$this->session->set_flashdata('error', 'Profile updating failed.');	
					redirect(base_url('/profile'));
				}
			}
		}
		else{
			
			$users = $this->Users->getByID(isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '');

			if(count($users) > 0){
				$user = $users[0];
				$this->load->view('admin/profile', array(
					'username' => $user['username'],
					'first_name' => $user['first_name'],
					'last_name' => $user['last_name'],
					'email' => $user['email']
				));
			}
			else{
				redirect(base_url('/login'));
			}
		}
	}

	public function userEdit($user_id){
		if(isset($_SESSION['role']) && $_SESSION['role'] != 'admin'){
			redirect(base_url('/'));
		}

		if($this->input->post('submit')){
			$this->form_validation->set_rules('username', 'Username', 'trim|required');
			$this->form_validation->set_rules('first_name', 'Firstname', 'trim|required');
			$this->form_validation->set_rules('last_name', 'Lastname', 'trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');

			if ($this->form_validation->run() == FALSE) {
				$this->load->view('admin/user-edit', array(
					'user_id' => $user_id,
					'username' => $this->input->post('username'),
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'email' => $this->input->post('email'),
					'is_verify' => $this->input->post('is_verify') ? '1' : '',
					'is_active' => $this->input->post('is_active') ? '1' : ''
				));
			}
			else{
				$update_result = $this->Users->updateUser(
					$user_id, array(
					'username' => $this->input->post('username'), 
					'email' => $this->input->post('email'), 
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'is_verify' => $this->input->post('is_verify') ? '1' : '',
					'is_active' => $this->input->post('is_active') ? '1' : ''
				));

				if($update_result){
					$this->session->set_flashdata('success', 'Updated successfully.');	
					redirect(base_url('/user-edit/'.$user_id));
				}
				else{
					$this->session->set_flashdata('error', 'Updated failed.');	
					redirect(base_url('/user-edit/'.$user_id));
				}
			}
		}
		else{
			$users = $this->Users->getByID($user_id);

			if(count($users) > 0){
				$user = $users[0];
				$this->load->view('admin/user-edit', array(
					'user_id' => $user_id,
					'username' => $user['username'],
					'first_name' => $user['first_name'],
					'last_name' => $user['last_name'],
					'email' => $user['email'],
					'is_verify' => $user['is_verify'],
					'is_active' => $user['is_active']
				));
			}
		}
	}

	public function userNew(){
		if($this->input->post('submit')){
			$this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[users.username]');
			$this->form_validation->set_rules('first_name', 'Firstname', 'trim|required');
			$this->form_validation->set_rules('last_name', 'Lastname', 'trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|is_unique[users.email]|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]');
			$this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'trim|required|matches[password]');

			if ($this->form_validation->run() == FALSE) {
				$this->load->view('admin/user-new', array(
					'username' => $this->input->post('username'),
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'email' => $this->input->post('email'),
					'is_verify' => $this->input->post('is_verify') ? '1' : '',
					'is_active' => $this->input->post('is_active') ? '1' : ''
				));
			}
			else{
				
				$added_user_id = $this->Users->addNew(array(
					'username' => $this->input->post('username'), 
					'email' => $this->input->post('email'), 
					'password' => $this->input->post('password'),
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'is_verify' => $this->input->post('is_verify') ? '1' : '',
					'is_active' => $this->input->post('is_active') ? '1' : ''
				));

				if($added_user_id){
					$this->session->set_flashdata('success', 'Your Account has been made, please verify it by clicking the activation link that has been send to your email.');	
					redirect(base_url('/user-new'));
				}
			}
		}
		else{
			$this->load->view('admin/user-new');
		}
	}
}
