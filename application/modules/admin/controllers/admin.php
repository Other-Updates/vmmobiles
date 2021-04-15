<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Admin extends MX_Controller {



    function __construct() {

        parent::__construct();

        // $this->clear_cache();

    }



    public function index($status = NULL) {

        $this->load->model('admin/admin_model');

        $user_info = $this->user_info = $this->user_auth->get_from_session('user_info');



        $data['admin'] = $this->admin_model->get_admin($user_info[0]['role'], $user_info[0]['id']);

        //echo $this->config->item('base_url');exit;

        if ($this->input->post()) {

            $username = $this->input->post('username');

            $password = $this->input->post('password');

            if ($this->user_auth->login($username, $password)) {

                $login_data = $this->admin_model->login($this->input->post());

                $session_array = array('user_info' => $login_data);

                $this->user_auth->store_in_session($session_array);

                redirect($this->config->item('base_url') . 'admin/dashboard');

            } else

                redirect($this->config->item('base_url') . 'admin?login=fail');

        }



        $data['login_status'] = 'success';

        if (isset($status) && $status != NULL) {

            $data['status'] = $status;

        }

        if (isset($_REQUEST['index']) && $_REQUEST['index'] == 'fail') {

            $data['login_status'] = 'fail';

        }



        $this->template->set_master_template('../../themes/' . $this->config->item("active_template") . '/template_login.php');

        $this->template->write_view('content', 'admin/index');

        $this->template->render();



//	print_r($this->session->userdata($this->config->item('application_name')));

//	die;

//        if (empty($this->user_auth->get_user_id())) {

//            $this->template->set_master_template('../../themes/' . $this->config->item("active_template") . '/template_login.php');

//            $this->template->write_view('content', 'admin/index');

//            $this->template->render();

//        } else {

//            $data['report'] = $this->admin_model->get_dashboard_report();

//            $this->template->write_view('content', 'admin/dashboard', $data);

//            $this->template->render();

//        }

    }



    public function dashboard() {

        $this->load->model('admin/admin_model');

        $date = '';

        if (date('m') > 3) {

            $from_date = date('Y') . '-04-01';

            $to_date = (date('Y') + 1) . '-03-31';

        } else {

            $from_date = (date('Y') - 1) . '-04-01';

            $to_date = date('Y') . '-03-31';

        }

        $data['report'] = $this->admin_model->get_dashboard_report();

        $data['cash_credit'] = $this->admin_model->get_agent_cash($this->user_auth->get_from_session('user_id'));

        $data['cash_debit'] = $this->admin_model->get_agent_debit($this->user_auth->get_from_session('user_id'));

        $data['amount'] = $data['cash_credit'][0]['credit'] - $data['cash_debit'][0]['debit'];

        $data['today_purchase']=$this->admin_model->get_today_purchase();

         $data['today_sales']=$this->admin_model->get_today_sales();

      //  echo "<pre>";print_r($data['today_purchase']);exit;

        $this->template->write_view('content', 'admin/dashboard', $data);

        $this->template->render();

    }



    function logout($status = NULL) {

        $data = array();

        $this->user_auth->logout();



        if (isset($status) && $status != NULL) {

            redirect($this->config->item('base_url') . 'admin?inactive=true');

        }

        redirect($this->config->item('base_url') . 'admin');

    }



    public function update_profile() {

        $this->load->model('admin/admin_model');

        if ($this->input->post()) {

            $conpany_details = $this->input->post('company');

            $this->admin_model->insert_company_details($conpany_details);

            $user_info = $this->user_info = $this->user_auth->get_from_session('user_info');

            $data["admin"] = $this->admin_model->get_admin($user_info[0]['role'], $user_info[0]['id']);



            $this->load->helper('text');



            $config['upload_path'] = './admin_image/original';



            $config['allowed_types'] = '*';



            $config['max_size'] = '2000';



            $this->load->library('upload', $config);



            $upload_data['file_name'] = $_FILES;

            if (isset($_FILES) && !empty($_FILES)) {

                $upload_files = $_FILES;

                if ($upload_files['admin_image'] != '') {

                    $_FILES['admin_image'] = array(

                        'name' => $upload_files['admin_image']['name'],

                        'type' => $upload_files['admin_image']['type'],

                        'tmp_name' => $upload_files['admin_image']['tmp_name'],

                        'error' => $upload_files['admin_image']['error'],

                        'size' => '2000'

                    );

                    $this->upload->do_upload('admin_image');



                    $upload_data = $this->upload->data();



                    $dest = getcwd() . "/admin_image/original/" . $upload_data['file_name'];



                    $src = $this->config->item("base_url") . 'admin_image/original/' . $upload_data['file_name'];

                }

            }

            $user_info = $this->user_info = $this->user_auth->get_from_session('user_info');

            $id = $user_info[0]['id'];

            $role = $user_info[0]['role'];

            $password = $this->input->post('password');

            $input_data['admin']['admin_image'] = $upload_data['file_name'];

            $input = array();

            $input['username'] = $this->input->post('admin_name');

            if (isset($password) && !empty($password)) {

                $pass = md5($password);

                $input['password'] = $pass;

            }

            if (isset($upload_data['file_name']) && !empty($upload_data['file_name'])) {

                $input['admin_image'] = $upload_data['file_name'];

            }

            if (isset($input) && !empty($input))

                $this->admin_model->update_profile($input, $role, $id);

            redirect($this->config->item('base_url') . 'admin/dashboard');

        }

        $user_info = $this->user_info = $this->user_auth->get_from_session('user_info');

        $data["admin"] = $this->admin_model->get_admin($user_info[0]['role'], $user_info[0]['id']);

        $data['company_details'] = $this->admin_model->get_company_details();

        $this->template->write_view('content', 'admin/update_profile', $data);

        $this->template->render();

    }



    public function back_up() {

        $this->load->view('admin/back_up');

        exit;

    }



    function get_customer_by_invoice($cust_id) {

        $data['pending'] = $this->admin_model->get_customer_by_invoice($cust_id);

        $this->load->view('admin/pending_invoice', $data);

    }



    function clear_cache() {

        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");

        $this->output->set_header("Pragma: no-cache");

    }



    function remove_unwanted_records() {



        $parent_table = 'erp_quotation';

        $child_table = 'erp_quotation_details';

        // $parent_table = 'erp_invoice';

        // $child_table = 'erp_invoice_details';

        //$parent_table = 'customer';

        //$child_table = 'erp_invoice';

        // $parent_table = 'erp_product';

        // $child_table = 'erp_invoice_details';

        //$parent_table = 'erp_invoice';

        // $child_table = 'receipt_bill';

        //$parent_table = 'erp_quotation';

        // $child_table = 'erp_invoice_details';

        //$parent_table = 'customer';

        //$child_table = 'erp_quotation';



        $delete_result = $this->admin_model->delete_unwanted_records($parent_table, $child_table);

    }



    function remove_duplicate_invoice() {

        $invoice = $this->admin_model->remove_duplicate_invoice();

        echo 'Test  <pre>';

        print_r($invoice);

        die;

    }



    function invoice_amount() {

        $invoice = $this->admin_model->invoice_amount();

        echo 'Test  <pre>';

        print_r($invoice);

        die;

    }



    public function get_insert_ttbs_users() {

        $this->load->model('masters/user_model');

        $data = $this->user_model->get_insert_users_from_biousers();

        echo "<pre>";

        print_r($data);

        exit;

    }



    public function remove_unwanted_products() {

        $invoice_details_products = $this->admin_model->loopallproducts();

        echo '<pre>';

        print_r($invoice_details_products);

        die;

    }



    public function removeemptyproducts() {

        $empty_product_details = $this->admin_model->removeemptyproductdetails();

    }



    public function updatestock_as_per_invoice_live() {

        //$result = $this->admin_model->updatestock_as_per_invoice_live();

        $result1 = $this->admin_model->updatestockreturn_as_per_invoice_live();

    }



    public function getrecordsfromepushserver() {

        $result = $this->admin_model->getrecordsfromepushserver();

        echo json_encode($result);

    }



    public function insertepushrecordsto_ttbsdb() {

        $result = $this->admin_model->insertepushrecordsto_ttbsdb();

        echo json_encode($result);

    }



}

