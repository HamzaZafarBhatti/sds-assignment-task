<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CustomerController extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */

	function __construct()
	{
		parent::__construct();
		$this->load->model('customer');
		$this->cust_id = $this->session->userdata('id');
		$this->cust_email = $this->session->userdata('email');
		$this->cust_name = $this->session->userdata('name');
	}

	public function register()
	{
		if ($this->cust_id) {
			redirect('/dashboard');
		}
		$this->load->view('customer/register');
	}
	public function do_register()
	{
		try {
			//code...
			$name = $this->input->post('name');
			$email = $this->input->post('email');
			$prev_user = $this->customer->get_customer_by_email($email);
			if ($prev_user) {
				$this->session->set_flashdata('error', 'Another Customer is registered with this Email!');
				redirect('/register');
			}
			$password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
			$data = [
				'name' => $name,
				'email' => $email,
				'password' => $password,
			];
			// echo json_encode($data);
			$res = $this->customer->create_customer($data);
			if ($res) {
				redirect('/login');
			} else {
				$this->session->set_flashdata('error', 'Customer registration failed!');
				redirect('/register');
			}
		} catch (\Throwable $th) {
			$this->session->set_flashdata('error', 'Error: ' . $th->getMessage());
			redirect('/register');
		}
	}
	public function login()
	{
		if ($this->cust_id) {
			redirect('/dashboard');
		}
		$this->load->view('customer/login');
	}
	public function do_login()
	{
		try {
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			$customer = $this->customer->get_customer_by_email($email);
			if (password_verify($password, $customer->password)) {
				$sess_data = [
					'logged_in' => TRUE,
					'id' => $customer->id,
					'name' => $customer->name,
					'email' => $customer->email
				];
				$this->session->set_userdata($sess_data);
				redirect('dashboard');
			} else {
				$this->session->set_flashdata('error', 'Email or password incorrect');
				redirect('/login');
			}
		} catch (\Throwable $th) {
			$this->session->set_flashdata('error', 'Error: ' . $th->getMessage());
			redirect('/login');
		}
	}
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('login');
	}
	public function profile()
	{
		$data['customer'] = $this->customer->get_customer_by_id($this->cust_id);
		$this->load->view('customer/profile', $data);
	}
	public function update_profile()
	{
		try {
			$id = $this->input->post('id');
			$name = $this->input->post('name');
			$phone = $this->input->post('phone');
			$address = $this->input->post('address');
			$data = [
				'name' => $name,
				'phone' => $phone,
				'address' => $address,
			];
			if ($this->input->post('password')) {
				$password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
				$data['password'] = $password;
			}
			// echo json_encode($data);
			$res = $this->customer->update_customer($id, $data);
			if ($res) {
				$this->session->set_flashdata('success', 'Profile updated!');
			} else {
				$this->session->set_flashdata('error', 'Profile updating failed!');
			}
			redirect('/profile');
		} catch (\Throwable $th) {
			$this->session->set_flashdata('error', 'Error: ' . $th->getMessage());
			redirect('/profile');
		}
	}
	public function dashboard()
	{
		if (!$this->cust_id) {
			redirect('/login');
		}
		$data['services'] = $this->customer->get_services();
		// $data['categories'] = $this->admin->get_categories();
		// $data['products'] = $this->admin->get_products();
		// $data['product_variations'] = $this->admin->get_product_variations();
		// $data['product_reviews'] = $this->admin->get_product_reviews();
		// $data['users'] = $this->admin->get_users();
		$this->load->view('customer/dashboard', $data);
	}
	public function buy_service($service_id)
	{
		$data['service'] = $this->customer->get_service_by_id_with_provider_name($service_id);
		$this->load->view('customer/buy_service', $data);
	}
	public function checkout()
	{
		try {
			$service = $this->customer->get_service_by_id($this->input->post('service_id'));
			$data['customer_id'] = $this->cust_id;
			$data['customer_token'] = '';
			$data['service_id'] = $service->id;
			$data['provider_id'] = $service->provider_id;
			$data['price'] = $service->price;
			$data['status'] = 0;
			$res = $this->customer->create_order($data);
			if ($res) {
				$this->create_customer($this->input->post('stripe-token'), $this->cust_email, $this->cust_name, $res);
				$this->session->set_flashdata('success', 'Order done!');
			} else {
				$this->session->set_flashdata('error', 'Fail to complete order!');
			}
			redirect('orders');
		} catch (\Throwable $th) {
			$this->session->set_flashdata('error', 'Error: ' . $th->getMessage());
			redirect('buy_service/' . $this->input->post('service_id'));
		}
	}
	public function orders()
	{
		$data['orders'] = $this->customer->get_orders_by_customer_id($this->cust_id);
		// echo json_encode($data);
		// die();
		$this->load->view('customer/orders', $data);
	}

	function create_customer($token, $email, $name, $order_id)
	{
		$this->load->config('stripe');
		require_once('application/libraries/stripe-php/init.php');
		// $stripe_config = $this->configurations_model->get_configuration_by_key_label('stripe', 'stripe_secret');
		$stripe_secret = $this->config->item('stripe_api_key');
		\Stripe\Stripe::setApiKey($stripe_secret);
		$customer = \Stripe\Customer::create(array(
			'email' => $email,
			'name' => $name,
			'source'  => $token,
			'description' => 'SDS Customer'
		));
		$this->customer->update_order($order_id, array('customer_token' => $customer->id));
	}
}
