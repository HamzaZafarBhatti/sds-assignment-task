<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ProviderController extends CI_Controller
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
		$this->load->model('provider');
		$this->prov_id = $this->session->userdata('id');
	}

	public function register()
	{
		if ($this->prov_id) {
			redirect('provider/dashboard');
		}
		$this->load->view('provider/register');
	}
	public function do_register()
	{
		try {
			//code...
			$name = $this->input->post('name');
			$email = $this->input->post('email');
			$prev_user = $this->provider->get_provider_by_email($email);
			if ($prev_user) {
				$this->session->set_flashdata('error', 'Another Provider is registered with this Email!');
				redirect('provider/register');
			}
			$password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
			$data = [
				'name' => $name,
				'email' => $email,
				'password' => $password,
			];
			// echo json_encode($data);
			$res = $this->provider->create_provider($data);
			if ($res) {
				redirect('provider/login');
			} else {
				$this->session->set_flashdata('error', 'Provider registration failed!');
				redirect('provider/register');
			}
		} catch (\Throwable $th) {
			$this->session->set_flashdata('error', 'Error: ' . $th->getMessage());
			redirect('provider/register');
		}
	}
	public function login()
	{
		if ($this->prov_id) {
			redirect('provider/dashboard');
		}
		$this->load->view('provider/login');
	}
	public function do_login()
	{
		try {
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			$provider = $this->provider->get_provider_by_email($email);
			if (password_verify($password, $provider->password)) {
				$sess_data = [
					'logged_in' => TRUE,
					'id' => $provider->id,
					'name' => $provider->name,
					'email' => $provider->email
				];
				$this->session->set_userdata($sess_data);
				redirect('provider/dashboard');
			} else {
				$this->session->set_flashdata('error', 'Email or password incorrect');
				redirect('provider/login');
			}
		} catch (\Throwable $th) {
			$this->session->set_flashdata('error', 'Error: ' . $th->getMessage());
			redirect('provider/login');
		}
	}
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('provider/login');
	}
	public function profile()
	{
		$data['provider'] = $this->provider->get_provider_by_id($this->prov_id);
		$this->load->view('provider/profile', $data);
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
			$res = $this->provider->update_provider($id, $data);
			if ($res) {
				$this->session->set_flashdata('success', 'Profile updated!');
			} else {
				$this->session->set_flashdata('error', 'Profile updating failed!');
			}
			redirect('provider/profile');
		} catch (\Throwable $th) {
			$this->session->set_flashdata('error', 'Error: ' . $th->getMessage());
			redirect('provider/profile');
		}
	}
	public function dashboard()
	{
		if (!$this->prov_id) {
			redirect('provider/login');
		}
		$data = array();
		$data['services_count'] = $this->provider->get_services_count_by_provider_id($this->prov_id);
		$data['orders_count'] = $this->provider->get_orders_count_by_provider_id($this->prov_id);
		$data['provider'] = $this->provider->get_provider_by_id($this->prov_id);
		$this->load->view('provider/dashboard', $data);
	}
	public function services()
	{
		if (!$this->prov_id) {
			redirect('provider/login');
		}
		$data['services'] = $this->provider->get_services_by_provider_id($this->prov_id);
		$this->load->view('provider/services', $data);
	}
	public function add_service()
	{
		if (!$this->prov_id) {
			redirect('provider/login');
		}
		$this->load->view('provider/add_service');
	}
	public function store_service()
	{
		try {
			$name = $this->input->post('name');
			$description = $this->input->post('description');
			$price = $this->input->post('price');
			$data = [
				'name' => $name,
				'description' => $description,
				'price' => $price,
				'status' => 1,
				'provider_id' => $this->prov_id
			];
			$res = $this->provider->create_service($data);
			if ($res) {
				$this->session->set_flashdata('success', 'Service Added!');
			} else {
				$this->session->set_flashdata('error', 'Fail to add service!');
			}
			redirect('provider/services');
		} catch (\Throwable $th) {
			$this->session->set_flashdata('error', 'Error: ' . $th->getMessage());
			redirect('provider/register');
		}
	}
	public function edit_service($service_id)
	{
		$data['service'] = $this->provider->get_service_by_id($service_id);
		$this->load->view('provider/edit_service', $data);
	}
	public function update_service($service_id)
	{
		try {
			$name = $this->input->post('name');
			$description = $this->input->post('description');
			$price = $this->input->post('price');
			$status = $this->input->post('status');
			$data = [
				'name' => $name,
				'description' => $description,
				'price' => $price,
				'status' => $status,
			];
			$res = $this->provider->update_service($service_id, $data);
			if ($res) {
				$this->session->set_flashdata('success', 'Service Updated!');
			} else {
				$this->session->set_flashdata('error', 'Fail to update service!');
			}
			redirect('provider/services');
		} catch (\Throwable $th) {
			$this->session->set_flashdata('error', 'Error: ' . $th->getMessage());
			redirect('provider/services');
		}
	}
	public function delete_service($service_id)
	{
		// echo $service_id;
		$res = $this->provider->delete_service($service_id);
		if ($res) {
			$this->session->set_flashdata('success', 'Service deleted!');
		} else {
			$this->session->set_flashdata('error', 'Fail to delete service!');
		}
		redirect('provider/services');
	}
	public function orders()
	{
		if (!$this->prov_id) {
			redirect('provider/login');
		}
		$data['orders'] = $this->provider->get_orders_by_provider_id($this->prov_id);
		$this->load->view('provider/orders', $data);
	}
	public function accept_order($id)
	{
		try {
			$res = $this->charge($id);
			if ($res) {
				$this->session->set_flashdata('success', 'Order approved!');
			} else {
				$this->session->set_flashdata('error', 'Fail to approve order!');
			}
			redirect('provider/orders');
		} catch (\Throwable $th) {
			$this->session->set_flashdata('error', 'Error: ' . $th->getMessage());
			redirect('provider/orders');
		}
		$res = $this->provider->get_orders_by_provider_id($this->prov_id);
	}
	public function reject_order($id)
	{
		try {
			$data = [
				'status' => 2,
			];
			$res = $this->provider->update_order($id, $data);
			if ($res) {
				$this->session->set_flashdata('success', 'Order rejected!');
			} else {
				$this->session->set_flashdata('error', 'Fail to reject order!');
			}
			redirect('provider/orders');
		} catch (\Throwable $th) {
			$this->session->set_flashdata('error', 'Error: ' . $th->getMessage());
			redirect('provider/orders');
		}
		$res = $this->provider->get_orders_by_provider_id($this->prov_id);
	}
	public function charge($order_id)
	{
		$this->load->config('stripe');
		require_once('application/libraries/stripe-php/init.php');
		$stripe_secret = $this->config->item('stripe_api_key');
		\Stripe\Stripe::setApiKey($stripe_secret);
		$currency = $this->config->item('stripe_currency');
		$order = $this->provider->get_order_by_id($order_id);
		$provider = $this->provider->get_provider_by_id($order->provider_id);
		// echo json_encode($order);
		// die();
		$total_charged = $order->price;
		$charge = \Stripe\Charge::create([
			"amount" => $total_charged * 100,
			"currency" => $currency,
			"customer" => $order->customer_token,
			"description" => "Thank you for service purchase!",
			'metadata' => array(
				'order_id' => $order->id
			)
		]);

		$chargeJson = $charge->jsonSerialize();
		if ($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1) {
			//order details
			$this->provider->update_order($order_id, array('status' => 1));
			$balance = $provider->balance + $order->price;
			$this->provider->update_provider($provider->id, array('balance' => $balance));
			return true;
		}
		return false;

	}
}
