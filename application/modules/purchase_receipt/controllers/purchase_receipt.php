<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Purchase_receipt extends MX_Controller {



    function __construct() {

        parent::__construct();

        $this->clear_cache();

        if (!$this->user_auth->is_logged_in()) {

            redirect($this->config->item('base_url') . 'admin');

        }

        $main_module = 'purchase';

        $access_arr = array(

            'purchase_receipt/receipt_list' => array('add', 'edit', 'delete', 'view'),

            'purchase_receipt/index' => array('add', 'edit', 'delete', 'view'),

            'purchase_receipt/search_result' => array('add', 'edit', 'delete', 'view'),

            'purchase_receipt/view_receipt' => array('add', 'edit', 'delete', 'view'),

            'purchase_receipt/manage_receipt' => array('add', 'edit'),

            'purchase_receipt/download_receipt' => 'no_restriction',

            'purchase_receipt/print_receipt' => 'no_restriction',

            'purchase_receipt/total_purchase_amount' => 'no_restriction',

            'purchase_receipt/clear_cache' => 'no_restriction',

        );

        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {

            redirect($this->config->item('base_url'));

        }



        $this->load->model('api/notification_model');

        $this->load->model('customer/agent_model');

        $this->load->model('api/notification_model');

        $this->load->model('admin/admin_model');

        $this->load->model('sales_receipt/sales_receipt_model');

        if (isset($_GET['notification']))

            $this->notification_model->update_notification(array('status' => 1), $_GET['notification']);

    }



    public function index() {

        $this->load->model('purchase_receipt/receipt_model');

        $this->load->model('masters/customer_model');

        $this->load->model('customer/agent_model');

        $this->load->model('master_style/master_model');

        $data["last_id"] = $this->master_model->get_last_id('rp_code');

        $no[1] = substr($data["last_id"][0]['value'], 3);

        if (date('m') > 3) {

            $check_no = 'RP' . date('y') . (date('y') + 1) . '0001';

            $check_res = $this->receipt_model->check_so_no($check_no);

            if (empty($check_res)) {

                $data['last_no'] = 'RP' . date('y') . (date('y') + 1) . '0001';

            } else

                $data['last_no'] = 'RP' . date('y') . (date('y') + 1) . str_pad(substr($no[1], 4, 8) + 1, 4, '0', STR_PAD_LEFT);

        }else {

            $check_no = 'RP' . (date('y') - 1) . date('y') . '0001';

            $check_res = $this->receipt_model->check_so_no($check_no);

            if (empty($check_res)) {

                $data['last_no'] = 'RP' . (date('y') - 1) . date('y') . '0001';

            } else

                $data['last_no'] = 'RP' . (date('y') - 1) . date('y') . str_pad(substr($no[1], 4, 8) + 1, 4, '0', STR_PAD_LEFT);

        }

        if ($this->input->post()) {

            $input = $this->input->post();

            $this->receipt_model->update_invoice_status($input['inv_no']);

            if ($input['balance'] == 0)

                $input['receipt']['complete_status'] = 1;

            else

                $input['receipt']['complete_status'] = 0;

            if(!empty($input['receipt']['due_date']))
                         $input['receipt']['due_date'] = date('Y-m-d', strtotime($input['receipt']['due_date']));





            $data["last_id"] = $this->master_model->get_last_id('rp_code');

            $no[1] = substr($data["last_id"][0]['value'], 3);

            if (date('m') > 3) {

                $check_no = 'RP' . date('y') . (date('y') + 1) . '0001';

                $check_res = $this->receipt_model->check_so_no($check_no);

                if (empty($check_res)) {

                    $data['last_no'] = 'RP' . date('y') . (date('y') + 1) . '0001';

                } else

                    $data['last_no'] = 'RP' . date('y') . (date('y') + 1) . str_pad(substr($no[1], 4, 8) + 1, 4, '0', STR_PAD_LEFT);

            }else {

                $check_no = 'RP' . (date('y') - 1) . date('y') . '0001';

                $check_res = $this->receipt_model->check_so_no($check_no);

                if (empty($check_res)) {

                    $data['last_no'] = 'RP' . (date('y') - 1) . date('y') . '0001';

                } else

                    $data['last_no'] = 'RP ' . (date('y') - 1) . date('y') . str_pad(substr($no[1], 4, 8) + 1, 4, '0', STR_PAD_LEFT);

            }

            $this->receipt_model->update_receipt_id($data['last_no']);

            $input['receipt']['receipt_no'] = $data['last_no'];

            if (isset($input['inv_no']) && !empty($input['inv_no'])) {

                $i = 0;

                $order_list = '';

                foreach ($input['inv_no'] as $key => $val) {



                    if ($i == 0) {

                        $order_list = $order_list . $val;

                        $i = 1;

                    } else

                        $order_list = $order_list . '-' . $val;

                }

            }

            $input['receipt']['inv_list'] = $order_list;

            //echo "<pre>";



            $insert_id = $this->receipt_model->insert_receipt($input['receipt']);

            $input['receipt_bill']['receipt_id'] = $insert_id;

            //print_r($insert_id);

            //print_r($input);

            $insert_id = $this->receipt_model->insert_receipt_bill($input['receipt_bill']);



            redirect($this->config->item('base_url') . 'sales_receipt/receipt_list');

        }





        $data['all_customer'] = $this->customer_model->get_customer();

        $data['all_agent'] = $this->agent_model->get_agent();

        $this->template->write_view('content', 'sales_receipt/index', $data);

        $this->template->render();

    }



    public function receipt_list() {

        $this->load->model('purchase_receipt/receipt_model');

        // $data['all_receipt'] = $this->receipt_model->get_all_receipt();

        $data['all_receipt'] = $this->receipt_model->get_all_receipt_based_pr_details();

//        echo '<pre>';

//        print_r($data);

//        exit;

        $this->template->write_view('content', 'receipt_list', $data);

        $this->template->render();

    }



    public function total_purchase_amount() {

        $values = $this->input->post();

        $paid = $bal = $inv = 0;

        $user_info = $this->user_auth->get_from_session('user_info');

        $this->load->model('purchase_receipt/receipt_model');

        if ($user_info[0]['role'] == 1) {

            $all_receipt = $this->receipt_model->get_receipt_total_amount($values);

        } else {

            $all_receipt = $this->receipt_model->get_receipt_total_amount_by_user_id($user_info[0]['id'], $values);

        }

        //all_receipt = $this->receipt_model->get_receipt_total_amount($values);

        //print_r($all_receipt);

        if (isset($all_receipt) && !empty($all_receipt)) {

            $i = 1;

            foreach ($all_receipt as $val) {

                //$inv = $inv + $val['net_total'];

                if ($val['receipt_bill'][0]['receipt_paid'] != '') {

                    $paid = $paid + round($val['receipt_bill'][0]['receipt_paid']);

                    $bal = $bal + round($val['net_total'] - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount']));

                }

            }

        }

        echo $bal;

        exit;

    }



    public function manage_receipt($r_id) {

        $this->load->model('purchase_receipt/receipt_model');



        if ($this->input->post()) {

            $input = $this->input->post();

            //  if ($input['balance'] == 0 || $input['balance'] == 0.00 || $input['balance'] == '0.00')

            if ($input['balance'] == 0 || $input['balance'] == 0.00 || $input['balance'] == '0.00')

                $receipt_status = 'Completed';

            else

                $receipt_status = 'Pending';


            if(!empty($input['receipt']['due_date']))
                 $input['receipt_bill']['due_date'] = date('Y-m-d', strtotime($input['receipt_bill']['due_date']));
             else
                 $input['receipt_bill']['due_date'] ="";

            

            $input['receipt_bill']['created_date'] = date('Y-m-d', strtotime($input['receipt_bill']['created_date']));

            $this->receipt_model->update_invoice(array('payment_status' => $receipt_status), $input['receipt_bill']['receipt_id']);

            $this->receipt_model->update_pr_invoice(array('payment_status' => $receipt_status), $input['receipt_bill']['receipt_id']);


//echo "<pre>";print_r($input['receipt_bill']);exit;
            $this->receipt_model->insert_receipt_bill($input['receipt_bill']);

    
            $input_comp = $this->input->post();

            if (!empty($input_comp['receipt_bill'])) {

                unset($input_comp['receipt_bill']['receipt_no']);

                unset($input_comp['receipt_bill']['terms']);

                unset($input_comp['receipt_bill']['ac_no']);

                unset($input_comp['receipt_bill']['branch']);

                unset($input_comp['receipt_bill']['dd_no']);

                unset($input_comp['receipt_bill']['due_date']);

                unset($input_comp['receipt_bill']['discount_per']);

                unset($input_comp['receipt_bill']['discount']);

                unset($input_comp['balance']);

                unset($input_comp['receipt_bill']['remarks']);

                $input_comp['receipt_bill']['receiver_type'] = "Purchase Cost";

                $input_comp['receipt_bill']['type'] = "debit";

                //echo"<pre>"; print_r($input_comp); exit;



                $insert_agent_cash = $this->receipt_model->insert_agent_amount($input_comp['receipt_bill']);

                $company_amount = $this->admin_model->get_company_amount();

                $purchase_cost = $this->admin_model->get_purchase_cost();

                $amount = $company_amount[0]['value'] - ($purchase_cost[0]['purchase_cost']);

                $this->admin_model->update_company_amount($amount);

            }

            redirect($this->config->item('base_url') . 'purchase_receipt/receipt_list');

        }



        $data['all_agent'] = $this->agent_model->get_agent();

        //  $data['receipt_details'] = $this->receipt_model->get_receipt_by_id($r_id);

        $data['receipt_details'] = $this->receipt_model->get_receipt_based_on_pr_by_id($r_id);



        $this->template->write_view('content', 'update_receipt', $data);

        $this->template->render();

    }



    public function view_receipt($r_id) {

        $this->load->model('purchase_receipt/receipt_model');

        $this->load->model('purchase_order/purchase_order_model');

        if ($this->input->post()) {

            $input = $this->input->post();



            if ($input['balance'] == 0 || $input['balance'] == 0.00 || $input['balance'] == '0.00')

                $receipt_status = 'Completed';

            else

                $receipt_status = 'Pending';



            $this->receipt_model->update_invoice(array('payment_status' => $receipt_status), $input['receipt_bill']['receipt_id']);

            $this->receipt_model->insert_receipt_bill($input['receipt_bill']);

            redirect($this->config->item('base_url') . 'sales_receipt/receipt_list');

        }

        $data['all_agent'] = $this->agent_model->get_agent();

        $data['receipt_details'] = $this->receipt_model->get_receipt_based_on_pr_by_id($r_id);

        $data['company_details'] = $this->purchase_order_model->get_company_details_by_firm($r_id);



        $this->template->write_view('content', 'view_receipt', $data);

        $this->template->render();

    }



    public function download_receipt($r_id, $rec_id) {

        $this->load->model('purchase_receipt/receipt_model');

        $data['all_agent'] = $this->agent_model->get_agent();

        //$data['receipt_details'] = $this->receipt_model->get_receipt_download_by_id($r_id, $rec_id);

        $data['receipt_details'] = $this->receipt_model->get_pr_receipt_download_by_id($r_id, $rec_id);

        $this->load->library("Pdf");

        $header = $this->load->view('quotation/pdf_header_view', $data, TRUE);

        $msg = $this->load->view('purchase_receipt/receipt_pdf', $data, TRUE);

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->AddPage();

        $pdf->Header($header);

        $pdf->SetTitle('Purchase Receipt');

        $pdf->writeHTMLCell(0, 0, '', '', $msg, 0, 1, 0, true, '', true);

        $filename = 'Receipt-' . date('d-M-Y-H-i-s') . '.pdf';

        $newFile = $this->config->item('theme_path') . 'attachement/' . $filename;

        $pdf->Output($newFile, 'D');

    }



    public function print_receipt($r_id, $rec_id) {

        $this->load->model('purchase_receipt/receipt_model');

        $data['all_agent'] = $this->agent_model->get_agent();

        //$data['receipt_details'] = $this->receipt_model->get_receipt_download_by_id($r_id, $rec_id);

        $data['receipt_details'] = $this->receipt_model->get_pr_receipt_download_by_id($r_id, $rec_id);

        $this->load->library("Pdf");

        $header = $this->load->view('quotation/pdf_header_view', $data, TRUE);

        $msg = $this->load->view('purchase_receipt/receipt_pdf', $data, TRUE);

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->AddPage();

        $pdf->SetTitle('Purchase Receipt');

        $pdf->Header($header);

        $pdf->writeHTMLCell(0, 0, '', '', $msg, 0, 1, 0, true, '', true);

        $filename = 'Receipt-' . date('d-M-Y-H-i-s') . '.pdf';

        $newFile = $this->config->item('theme_path') . 'attachement/' . $filename;

        $pdf->Output($newFile);

    }



    function clear_cache() {

        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");

        $this->output->set_header("Pragma: no-cache");

    }



}

