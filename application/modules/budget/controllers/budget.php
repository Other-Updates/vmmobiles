<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Budget extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->clear_cache();
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url') . 'admin');
        }
        $main_module = 'budget';
        $access_arr = array(
            'budget/budget_list' => array('add', 'edit', 'delete', 'view'),
            'budget/index' => array('add', 'edit', 'delete', 'view'),
            'budget/search_result' => array('add', 'edit', 'delete', 'view'),
            'budget/budget_view' => array('add', 'edit', 'delete', 'view'),
            'budget/budget_delete' => array('delete'),
            'budget/budget_edit' => array('add', 'edit'),
            'budget/update_budget' => array('edit'),
            'budget/change_status' => 'no_restriction',
            'budget/get_customer' => 'no_restriction',
            'budget/get_customer_by_id' => 'no_restriction',
            'budget/get_product' => 'no_restriction',
            'budget/get_product_by_id' => 'no_restriction',
            'budget/get_service' => 'no_restriction',
            'budget/delete_id' => 'no_restriction',
            'budget/clear_cache' => 'no_restriction',
            'budget/stock_details' => 'no_restriction'
        );
        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }
        $this->load->model('masters/categories_model');
        $this->load->model('master_style/master_model');
        $this->load->model('masters/brand_model');
        $this->load->model('quotation/Gen_model');
        $this->load->model('masters/customer_model');
        $this->load->model('enquiry/enquiry_model');
        $this->load->model('admin/admin_model');
        $this->load->model('purchase_order/purchase_order_model');
        $this->load->model('delivery_challan/delivery_challan_model');
        $this->load->model('api/increment_model');
        $this->load->model('budget/budget_model');
    }

    public function index() {

        if ($this->input->post()) {
            $input = $this->input->post();
            $user_info = $this->user_auth->get_from_session('user_info');
            $data['company_details'] = $this->admin_model->get_company_details();
            $input['po']['created_by'] = $user_info[0]['id'];
            $input['po']['created_date'] = date('Y-m-d');
            $input['po']['from_date'] = date('Y-m-d', strtotime($input['po']['from_date']));
            $input['po']['to_date'] = date('Y-m-d', strtotime($input['po']['to_date']));
            $insert_id = $this->budget_model->insert_budget($input['po']);
            $q_no = $input['po']['vc_no'];
            $split = explode("-", $q_no);
            $code = 'VC';
            $this->increment_model->update_increment_id($split[1], $code);
            if (isset($insert_id) && !empty($insert_id)) {
                $input = $this->input->post();
                if (isset($input['customer']) && !empty($input['customer'])) {
                    $insert_arr = array();
                    foreach ($input['customer'] as $key => $val) {
                        $insert['bd_id'] = $insert_id;
                        $insert['customer'] = $val;
                        $insert['customer_id'] = $input['customer_id'][$key];
                        $insert['amount'] = $input['amount'][$key];
                        $insert['created_date'] = date('Y-m-d H:i:s');
                        $insert_arr[] = $insert;
                    }

                    $this->budget_model->insert_budget_details($insert_arr);
                }
            }
            if ($input['print'] == 'yes') {
                $file_name = base_url() . 'budget/budget_view/' . $insert_id;
                echo "<script>window.location.href = '$file_name';</script>";
                exit;
            } else {
                $redirect_url = base_url() . 'budget/budget_list';
                echo "<script>window.location.href = '$redirect_url';</script>";
                exit;
            }

            // redirect($this->config->item('base_url') . 'budget/budget_list');
        }

        $data['firms'] = $firms = $this->user_auth->get_user_firms();
        $this->template->write_view('content', 'budget/index', $data);
        $this->template->render();
    }

    public function budget_view($id) {
        $datas["po"] = $po = $this->budget_model->get_all_budget_by_id($id);
        $datas["po_details"] = $po_details = $this->budget_model->get_all_budget_details_by_id($id);
        $this->template->write_view('content', 'budget_view', $datas);
        $this->template->render();
    }

    public function budget_list() {
        $datas["po"] = $po = $this->budget_model->get_all_budget();
        $datas['company_details'] = $this->admin_model->get_company_details();
        $this->template->write_view('content', 'budget/budget_list', $datas);
        $this->template->render();
    }

    public function get_customer($id) {
        $atten_inputs = $this->input->get();
        $data = $this->budget_model->get_customer($atten_inputs, $id);
        echo '<ul id="country-list">';
        if (isset($data) && !empty($data)) {
            foreach ($data as $st_rlno) {
                if ($st_rlno['store_name'] != '')
                    echo '<li class="cust_class" cust_name="' . $st_rlno['store_name'] . '" cust_id="' . $st_rlno['id'] . '" cust_no="' . $st_rlno['mobil_number'] . '" cust_email="' . $st_rlno['email_id'] . '" cust_address="' . $st_rlno['address1'] . '" cust_tin="' . $st_rlno['tin'] . '">' . $st_rlno['store_name'] . '</li>';
            }
        }
        else {
            echo '<li style="color:red;">No Data Found</li>';
        }
        echo '</ul>';
    }

    public function get_customer_by_id() {
        $input = $this->input->post();
        $data_customer["customer_details"] = $this->budget_model->get_customer_by_id($input['id']);
        echo json_encode($data_customer);
        exit;
    }

    public function get_product($id) {
        $atten_inputs = $this->input->get();
        $product_data = $this->budget_model->get_product($atten_inputs, $id);
        echo '<ul id="product-list">';
        if (isset($product_data) && !empty($product_data)) {
            foreach ($product_data as $st_rlno) {
                if ($st_rlno['product_name'] != '')
                    echo '<li class="pro_class" pro_cost="' . $st_rlno['cost_price'] . '" pro_type="' . $st_rlno['type'] . '" pro_id="' . $st_rlno['id'] . '" mod_no="' . $st_rlno['model_no'] . '" pro_name="' . $st_rlno['product_name'] . '" pro_description="' . $st_rlno['product_description'] . '" pro_image="' . $st_rlno['product_image'] . $cust_image . '" pro_cgst="' . $st_rlno['cgst'] . '"pro_sgst ="' . $st_rlno['sgst'] . '">' . $st_rlno['product_name'] . '</li>';
            }
        }
        else {
            echo '<li style="color:red;">No Data Found</li>';
        }
        echo '</ul>';
    }

    public function get_product_by_id() {
        $input = $this->input->post();
        $data_customer["product_details"] = $this->budget_model->get_product_by_id($input['id']);
        echo json_encode($data_customer);
        exit;
    }

    public function budget_edit($id) {
        $datas["po"] = $po = $this->budget_model->get_all_budget_by_id($id);
        $datas["po_details"] = $po_details = $this->budget_model->get_all_budget_details_by_id($id);
        $datas['firms'] = $firms = $this->user_auth->get_user_firms();
        $this->template->write_view('content', 'budget_edit', $datas);
        $this->template->render();
    }

    public function update_budget($id) {
        $user_info = $this->user_auth->get_from_session('user_info');
        $input = $this->input->post();
        $input['po']['created_by'] = $user_info[0]['id'];
        $input['po']['from_date'] = date('Y-m-d', strtotime($input['po']['from_date']));
        $input['po']['to_date'] = date('Y-m-d', strtotime($input['po']['to_date']));
        $this->budget_model->update_budget($input['po'], $id);
        $this->budget_model->delete_budget_deteils_by_id($id);
        $input = $this->input->post();
        if (isset($input['customer']) && !empty($input['customer'])) {
            $insert_arr = array();
            foreach ($input['customer'] as $key => $val) {
                $insert['bd_id'] = $id;
                $insert['customer'] = $val;
                $insert['customer_id'] = $input['customer_id'][$key];
                $insert['amount'] = $input['amount'][$key];
                $insert['created_date'] = date('Y-m-d H:i:s');
                $insert_arr[] = $insert;
            }

            $this->budget_model->insert_budget_details($insert_arr);
        }
        redirect($this->config->item('base_url') . 'budget/budget_list');
    }

    public function budget_delete() {
        $id = $this->input->POST('value1');
        $this->budget_model->budget_delete($id);
        $this->budget_model->delete_budget_deteils_by_id($id);
        redirect($this->config->item('base_url') . 'budget/budget_list');
    }

    public function delete_id() {
        $input = $this->input->get();
        $del = $this->budget_model->delete_id($input['id']);
        echo 'success';
    }

    function clear_cache() {
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }

}
