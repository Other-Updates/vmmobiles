<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cron extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->database();
        $this->load->model('cron/cron_model');
        $this->load->model('quotation/gen_model');
        $this->load->library('form_validation');
        $this->load->model('purchase_order/purchase_order_model');
        $this->load->model('stock/stock_model');
        $this->load->model('master_category/master_category_model');
        $this->load->model('product/product_model');
        $this->load->model('master_brand/master_brand_model');
        $this->load->model('customer/agent_model');
        $this->load->model('project_cost/project_cost_model');
        $this->load->model('admin/admin_model');
        $this->load->model('report/report_model');
        $this->load->model('agent/agent_model');
        header('Content-type: application/json');
    }

    public function requestMethod() {
        if ($_SERVER['REQUEST_METHOD'] != 'GET')
            $this->setResponse(array('status' => 'failure', 'response_code' => '405', 'message' => 'Invalid request method'));
    }

    function daily_report() {
        $firms = $this->user_auth->get_user_firms();
        $data['po'] = $this->cron_model->get_all_po();
        $data['pc'] = $this->cron_model->get_all_invoice();
        $data['stock'] = $this->cron_model->get_all_stock();

        $data["profit"] = $quotation = $this->cron_model->get_all_profit_report();
        $data["sku"] = $this->cron_model->get_all_sku_report();

        $this->load->library('Excel');

        $objPHPExcel = new PHPExcel();

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'S.No');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'PR Number');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'PO Number');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', 'Supplier Name');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', 'Total Quantity');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', 'Delivery Quantity');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', 'Total Amount');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', 'Created date');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', 'PR Status');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', 'Delivery Status');

        $objPHPExcel->getActiveSheet(0)->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('K')->setWidth(20);

        $objPHPExcel->getActiveSheet(0)->getStyle('A1:J1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet(0)->getStyle('A1:J1')->getFill()->getStartColor()->setARGB('3399ff');
        if (isset($data['po']) && !empty($data['po'])) {
            $i = 2;
            $j = 1;
            foreach ($data['po'] as $stu) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $i, $j);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $i, $stu["pr_no"]);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $i, ($stu['pr_status'] == 'approved') ? $stu['po_no'] : '-');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $i, $stu["store_name"]);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $i, $stu["total_qty"]);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $i, $stu["delivery_qty"]);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $i, $stu["net_total"]);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $i, date('d-M-Y', strtotime($stu['created_date'])));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $i, ucfirst($stu["pr_status"]));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $i, ucfirst($stu["delivery_status"]));

                $i++;
                $j++;

                $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, '=SUM(E2:E' . ($i - 1) . ')');
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, '=SUM(F2:F' . ($i - 1) . ')');
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, '=SUM(G2:G' . ($i - 1) . ')');
            }
        }
        if (count($firms) > 1) {
            $objPHPExcel->getActiveSheet()->setTitle('TT Purchase invoice Report');
        } else {
            $objPHPExcel->getActiveSheet()->setTitle($firms[0]['prefix'] . ' Purchase invoice Report');
        }

        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(1);
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A1', 'S.No');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('B1', 'Quotation Number');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('C1', 'Customer Name');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('D1', 'Quotation Amount');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('E1', 'Invoice No');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('F1', 'Invoice Amount');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('G1', 'Paid Amount');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('H1', 'Invoice Date');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('I1', 'Invoice Status');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('J1', 'Payment Status');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('K1', 'Delivery Status');

        $objPHPExcel->getActiveSheet(1)->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('K')->setWidth(20);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('L')->setWidth(20);

        $objPHPExcel->getActiveSheet(1)->getStyle('A1:K1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet(1)->getStyle('A1:K1')->getFill()->getStartColor()->setARGB('3399ff');

        if (isset($data['pc']) && !empty($data['pc'])) {
            $is = 2;
            $js = 1;
            foreach ($data['pc'] as $stu) {
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A' . $is, $js);
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('B' . $is, $stu["q_no"]);
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('C' . $is, $stu["store_name"]);
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('D' . $is, $stu["q_total"]);
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('E' . $is, $stu["inv_id"]);
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('F' . $is, $stu["net_total"]);
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('G' . $is, $stu["receipt_bill"][0]['receipt_paid']);
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('H' . $is, date('d-M-Y', strtotime($stu['created_date'])));
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('I' . $is, ucfirst($stu["invoice_status"]));
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('J' . $is, ucfirst($stu["payment_status"]));
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('K' . $is, ucfirst($stu["delivery_status"]));
                $is++;
                $js++;
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $is, '=SUM(D2:D' . ($is - 1) . ')');
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $is, '=SUM(F2:F' . ($is - 1) . ')');
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $is, '=SUM(G2:G' . ($is - 1) . ')');
            }
        }

        if (count($firms) > 1) {
            $objPHPExcel->getActiveSheet()->setTitle('TT Sales invoice Report');
        } else {
            $objPHPExcel->getActiveSheet()->setTitle($firms[0]['prefix'] . ' Sales invoice Report');
        }

        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(2);
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('A1', 'S.No');
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('B1', 'Firm Name');
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('C1', 'Product Name');
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('D1', 'Category');
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('E1', 'Brand');
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('F1', 'Quantity');
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('G1', 'Min Quantity');

        $objPHPExcel->getActiveSheet(2)->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet(2)->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet(2)->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet(2)->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet(2)->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet(2)->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet(2)->getColumnDimension('H')->setWidth(20);

        $objPHPExcel->getActiveSheet(2)->getStyle('A1:G1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet(2)->getStyle('A1:G1')->getFill()->getStartColor()->setARGB('3399ff');
        if (isset($data['stock']) && !empty($data['stock'])) {
            $k = 2;
            $l = 1;
            foreach ($data['stock'] as $stu) {
                $objPHPExcel->setActiveSheetIndex(2)->setCellValue('A' . $k, $l);
                $objPHPExcel->setActiveSheetIndex(2)->setCellValue('B' . $k, $stu["firm_name"]);
                $objPHPExcel->setActiveSheetIndex(2)->setCellValue('C' . $k, $stu["product_name"]);
                $objPHPExcel->setActiveSheetIndex(2)->setCellValue('D' . $k, $stu["categoryName"]);
                $objPHPExcel->setActiveSheetIndex(2)->setCellValue('E' . $k, $stu["brands"]);
                $objPHPExcel->setActiveSheetIndex(2)->setCellValue('F' . $k, $stu["quantity"]);
                $objPHPExcel->setActiveSheetIndex(2)->setCellValue('G' . $k, $stu["min_qty"]);
                $k++;
                $l++;

                $objPHPExcel->getActiveSheet()->setCellValue('F' . $k, '=SUM(F2:F' . ($k - 1) . ')');
            }
        }

        if (count($firms) > 1) {
            $objPHPExcel->getActiveSheet()->setTitle('TT Stock Report');
        } else {
            $objPHPExcel->getActiveSheet()->setTitle($firms[0]['prefix'] . ' Stock Report');
        }

        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(3);
        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('A1', 'S.No');
        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('B1', 'Quotation No');
        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('C1', 'Customer Name');
        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('D1', 'Quotation Amount');
        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('E1', 'Invoice NO');
        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('F1', 'Invoice Date');
        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('G1', 'Invoice Amount');
        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('H1', 'Commission Amount');
        //$objPHPExcel->setActiveSheetIndex(3)->setCellValue('I1', 'Sales ID');
        // $objPHPExcel->setActiveSheetIndex(3)->setCellValue('J1', 'Sales Cost');
        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('I1', 'Profit %');
        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('J1', 'Profit Amount');

        $objPHPExcel->getActiveSheet(3)->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet(3)->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet(3)->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet(3)->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet(3)->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet(3)->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet(3)->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet(3)->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet(3)->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet(3)->getColumnDimension('K')->setWidth(20);
        // $objPHPExcel->getActiveSheet(3)->getColumnDimension('L')->setWidth(20);

        $objPHPExcel->getActiveSheet(3)->getStyle('A1:J1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet(3)->getStyle('A1:J1')->getFill()->getStartColor()->setARGB('3399ff');
        if (isset($data['profit']) && !empty($data['profit'])) {
            $m = 2;
            $n = 1;
            foreach ($data['profit'] as $val) {
                $objPHPExcel->setActiveSheetIndex(3)->setCellValue('A' . $m, $n);
                $objPHPExcel->setActiveSheetIndex(3)->setCellValue('B' . $m, $val["q_no"]);
                $objPHPExcel->setActiveSheetIndex(3)->setCellValue('C' . $m, $val["store_name"]);
                $objPHPExcel->setActiveSheetIndex(3)->setCellValue('D' . $m, $val["net_total"]);
                if (isset($val['pc_amount']) && !empty($val['pc_amount'])) {
                    if (isset($val['inv_amount']) && !empty($val['inv_amount'])) {
                        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('E' . $m, $val['inv_amount'][0]['inv_id']);
                        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('F' . $m, date('d-M-y', strtotime($val['inv_amount'][0]['created_date'])));
                        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('G' . $m, number_format($val['inv_amount'][0]['net_total'], 2));
                        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('H' . $m, $val['inv_amount'][0]['commission_rate']);
                    } else {
                        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('E' . $m, '');
                        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('F' . $m, '');
                        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('G' . $m, '');
                        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('H' . $m, '');
                    }
                } else {
                    $objPHPExcel->setActiveSheetIndex(3)->setCellValue('A' . $m, '');
                    $objPHPExcel->setActiveSheetIndex(3)->setCellValue('B' . $m, '');
                    $objPHPExcel->setActiveSheetIndex(3)->setCellValue('C' . $m, '');
                    $objPHPExcel->setActiveSheetIndex(3)->setCellValue('D' . $m, '');
                }
                if (isset($val['pc_amount']) && !empty($val['pc_amount'])) {
                    // $objPHPExcel->setActiveSheetIndex(3)->setCellValue('I' . $m, $val['pc_amount'][0]['job_id']);
                    // $objPHPExcel->setActiveSheetIndex(3)->setCellValue('J' . $m, number_format($val['pc_amount'][0]['net_total'], 2));
                    if ($val['inv_amount'][0]['net_total'] != '')
                        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('I' . $m, number_format((((float) (($val['inv_amount'][0]['net_total'] - $val['inv_amount'][0]['commission_rate']) - (float) $val['pc_amount'][0]['total_cost_price']) * 100) / (float) $val['pc_amount'][0]['total_cost_price']), 2, '.', ',') . '%');
                    if ($val['inv_amount'][0]['net_total'] != '')
                        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('J' . $m, number_format((($val['inv_amount'][0]['net_total'] - $val['inv_amount'][0]['commission_rate']) - $val['pc_amount'][0]['total_cost_price']), 2, '.', ','));
                } else {
                    // $objPHPExcel->setActiveSheetIndex(3)->setCellValue('I' . $m, '');
                    // $objPHPExcel->setActiveSheetIndex(3)->setCellValue('J' . $m, '');
                    $objPHPExcel->setActiveSheetIndex(3)->setCellValue('I' . $m, '');
                    $objPHPExcel->setActiveSheetIndex(3)->setCellValue('J' . $m, '');
                }
                $m++;
                $n++;

                $objPHPExcel->getActiveSheet()->setCellValue('D' . $m, '=SUM(D2:D' . ($m - 1) . ')');
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $m, '=SUM(G2:G' . ($m - 1) . ')');
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $m, '=SUM(H2:H' . ($m - 1) . ')');
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $m, '=SUM(J2:J' . ($m - 1) . ')');
                // $objPHPExcel->getActiveSheet()->setCellValue('K' . $m, '=SUM(K2:K' . ($m - 1) . ')');
                // $objPHPExcel->getActiveSheet()->setCellValue('L' . $m, '=SUM(L2:L' . ($m - 1) . ')');
            }
        }

        if (count($firms) > 1) {
            $objPHPExcel->getActiveSheet()->setTitle('TT Profit and Loss Report');
        } else {
            $objPHPExcel->getActiveSheet()->setTitle($firms[0]['prefix'] . ' Profit and Loss Report');
        }

        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(4);
        $objPHPExcel->setActiveSheetIndex(4)->setCellValue('A1', 'S.No');
        $objPHPExcel->setActiveSheetIndex(4)->setCellValue('B1', 'Firm Name');
        $objPHPExcel->setActiveSheetIndex(4)->setCellValue('C1', 'SKU N0');
        $objPHPExcel->setActiveSheetIndex(4)->setCellValue('D1', 'SKU Date');
        $objPHPExcel->setActiveSheetIndex(4)->setCellValue('E1', 'Product Name');
        $objPHPExcel->setActiveSheetIndex(4)->setCellValue('F1', 'Category name');
        $objPHPExcel->setActiveSheetIndex(4)->setCellValue('G1', 'Brand');
        $objPHPExcel->setActiveSheetIndex(4)->setCellValue('H1', 'Type');
        $objPHPExcel->setActiveSheetIndex(4)->setCellValue('I1', 'Stock');
        $objPHPExcel->setActiveSheetIndex(4)->setCellValue('J1', 'Qty');

        $objPHPExcel->getActiveSheet(4)->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet(4)->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet(4)->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet(4)->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet(4)->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet(4)->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet(4)->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet(4)->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet(4)->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet(4)->getColumnDimension('K')->setWidth(20);


        $objPHPExcel->getActiveSheet(4)->getStyle('A1:J1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet(4)->getStyle('A1:J1')->getFill()->getStartColor()->setARGB('3399ff');
        if (isset($data['sku']) && !empty($data['sku'])) {
            $u = 2;
            $v = 1;
            foreach ($data['sku'] as $stu11) {
                $objPHPExcel->setActiveSheetIndex(4)->setCellValue('A' . $u, $v);
                $objPHPExcel->setActiveSheetIndex(4)->setCellValue('B' . $u, $stu11["firm_name"]);
                $objPHPExcel->setActiveSheetIndex(4)->setCellValue('C' . $u, $stu11["sku_no"]);
                $objPHPExcel->setActiveSheetIndex(4)->setCellValue('D' . $u, date('d-M-y', strtotime($stu11['created_date'])));
                $objPHPExcel->setActiveSheetIndex(4)->setCellValue('E' . $u, $stu11["product_name"]);
                $objPHPExcel->setActiveSheetIndex(4)->setCellValue('F' . $u, $stu11["categoryName"]);
                $objPHPExcel->setActiveSheetIndex(4)->setCellValue('G' . $u, $stu11["brands"]);
                $objPHPExcel->setActiveSheetIndex(4)->setCellValue('H' . $u, $stu11["sku_type"]);
                $objPHPExcel->setActiveSheetIndex(4)->setCellValue('I' . $u, ($stu11['stock']));
                $objPHPExcel->setActiveSheetIndex(4)->setCellValue('J' . $u, ($stu11['qty']));
                $u++;
                $v++;
            }
        }

        if (count($firms) > 1) {
            $objPHPExcel->getActiveSheet()->setTitle('TT Manage SKU Report');
        } else {
            $objPHPExcel->getActiveSheet()->setTitle($firms[0]['prefix'] . ' Manage SKU Report');
        }

        if (count($firms) > 1) {
            $file_name = 'TT Daily report ' . Date('d-M-Y-H-i-s');
            $title = 'TT Daily report ' . Date('d-M-Y');
        } else {
            $file_name = $firms[0]['prefix'] . ' Daily report ' . Date('d-M-Y-H-i-s');
            $title = $firms[0]['prefix'] . ' Daily report ' . Date('d-M-Y');
        }

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save($this->config->item('theme_path') . 'attachement/daily_report/' . $file_name . '.xls');
        $data["email_details"] = $email_details = $this->cron_model->get_all_email_details();

        $this->load->library('email');

        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.googlemail.com';
        $config['smtp_port'] = 465;
        $config['smtp_user'] = $data['email_details'][0]['value'];
        $config['smtp_pass'] = 'MotivationS';
        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";
        $this->email->attach($this->config->item('theme_path') . 'attachement/daily_report/' . $file_name . '.xls');
        $this->email->from($data['email_details'][0]['value']);
        $this->email->to($data['email_details'][1]['value']);
        $this->email->subject($title);
        $this->email->message('Dear sir,<br>Kindly find the attachment for <b>' . $title . '</b><br><br><br>Thanks<br><br> TT Support Team<br>');
        if ($this->email->send()) {
            $this->setResponse(array('status' => 'success', 'response_code' => '200', 'message' => 'Daily Report Send Successfully'));
        } else {
            $this->setResponse(array('status' => 'failure', 'response_code' => '500', 'message' => 'Due to no request data - action terminated'));
        }
    }

    function weekly_report() {
        $firms = $this->user_auth->get_user_firms();
        $data['po'] = $this->cron_model->get_all_po_weekly();
        $data['pc'] = $this->cron_model->get_all_invoice_weekly();


        $data['stock'] = $this->cron_model->get_all_stock();
        $data["profit"] = $quotation = $this->cron_model->get_all_profit_report_weekly();
        $data["sku"] = $this->cron_model->get_all_sku_report_weekly();

        $this->load->library('Excel');

        $objPHPExcel = new PHPExcel();

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'S.No');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'PR Number');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'PO Number');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', 'Supplier Name');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', 'Total Quantity');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', 'Delivery Quantity');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', 'Total Amount');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', 'Created date');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', 'PR Status');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', 'Delivery Status');

        $objPHPExcel->getActiveSheet(0)->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('K')->setWidth(20);

        $objPHPExcel->getActiveSheet(0)->getStyle('A1:J1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet(0)->getStyle('A1:J1')->getFill()->getStartColor()->setARGB('3399ff');

        if (isset($data['po']) && !empty($data['po'])) {
            $i = 2;
            $j = 1;
            foreach ($data['po'] as $stu) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $i, $j);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $i, $stu["pr_no"]);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $i, ($stu['pr_status'] == 'approved') ? $stu['po_no'] : '-');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $i, $stu["store_name"]);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $i, $stu["total_qty"]);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $i, $stu["delivery_qty"]);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $i, $stu["net_total"]);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $i, date('d-M-Y', strtotime($stu['created_date'])));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $i, ucfirst($stu["pr_status"]));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $i, ucfirst($stu["delivery_status"]));

                $i++;
                $j++;

                $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, '=SUM(E2:E' . ($i - 1) . ')');
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, '=SUM(F2:F' . ($i - 1) . ')');
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, '=SUM(G2:G' . ($i - 1) . ')');
            }
        }
        if (count($firms) > 1) {
            $objPHPExcel->getActiveSheet()->setTitle('TT Purchase invoice Report');
        } else {
            $objPHPExcel->getActiveSheet()->setTitle($firms[0]['prefix'] . ' Purchase invoice Report');
        }

        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(1);
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A1', 'S.No');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('B1', 'Quotation Number');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('C1', 'Customer Name');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('D1', 'Quotation Amount');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('E1', 'Invoice No');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('F1', 'Invoice Amount');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('G1', 'Paid Amount');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('H1', 'Invoice Date');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('I1', 'Invoice Status');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('J1', 'Payment Status');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('K1', 'Delivery Status');

        $objPHPExcel->getActiveSheet(1)->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('K')->setWidth(20);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('L')->setWidth(20);

        $objPHPExcel->getActiveSheet(1)->getStyle('A1:K1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet(1)->getStyle('A1:K1')->getFill()->getStartColor()->setARGB('3399ff');

        if (isset($data['pc']) && !empty($data['pc'])) {
            $is = 2;
            $js = 1;
            foreach ($data['pc'] as $stu) {
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A' . $is, $js);
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('B' . $is, $stu["q_no"]);
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('C' . $is, $stu["store_name"]);
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('D' . $is, $stu["q_total"]);
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('E' . $is, $stu["inv_id"]);
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('F' . $is, $stu["net_total"]);
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('G' . $is, $stu["receipt_bill"][0]['receipt_paid']);
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('H' . $is, date('d-M-Y', strtotime($stu['created_date'])));
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('I' . $is, ucfirst($stu["invoice_status"]));
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('J' . $is, ucfirst($stu["payment_status"]));
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('K' . $is, ucfirst($stu["delivery_status"]));
                $is++;
                $js++;
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $is, '=SUM(D2:D' . ($is - 1) . ')');
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $is, '=SUM(F2:F' . ($is - 1) . ')');
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $is, '=SUM(G2:G' . ($is - 1) . ')');
            }
        }

        if (count($firms) > 1) {
            $objPHPExcel->getActiveSheet()->setTitle('TT Sales invoice Report');
        } else {
            $objPHPExcel->getActiveSheet()->setTitle($firms[0]['prefix'] . ' Sales invoice Report');
        }

        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(2);
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('A1', 'S.No');
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('B1', 'Firm Name');
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('C1', 'Product Name');
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('D1', 'Category');
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('E1', 'Brand');
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('F1', 'Quantity');

        $objPHPExcel->getActiveSheet(2)->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet(2)->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet(2)->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet(2)->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet(2)->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet(2)->getColumnDimension('G')->setWidth(20);

        $objPHPExcel->getActiveSheet(2)->getStyle('A1:F1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet(2)->getStyle('A1:F1')->getFill()->getStartColor()->setARGB('3399ff');
        if (isset($data['stock']) && !empty($data['stock'])) {
            $k = 2;
            $l = 1;
            foreach ($data['stock'] as $stu) {
                $objPHPExcel->setActiveSheetIndex(2)->setCellValue('A' . $k, $l);
                $objPHPExcel->setActiveSheetIndex(2)->setCellValue('B' . $k, $stu["firm_name"]);
                $objPHPExcel->setActiveSheetIndex(2)->setCellValue('C' . $k, $stu["product_name"]);
                $objPHPExcel->setActiveSheetIndex(2)->setCellValue('D' . $k, $stu["categoryName"]);
                $objPHPExcel->setActiveSheetIndex(2)->setCellValue('E' . $k, $stu["brands"]);
                $objPHPExcel->setActiveSheetIndex(2)->setCellValue('F' . $k, $stu["quantity"]);
                $k++;
                $l++;
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $k, '=SUM(F2:F' . ($k - 1) . ')');
            }
        }

        if (count($firms) > 1) {
            $objPHPExcel->getActiveSheet()->setTitle('TT Stock Report');
        } else {
            $objPHPExcel->getActiveSheet()->setTitle($firms[0]['prefix'] . ' Stock Report');
        }

        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(3);
        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('A1', 'S.No');
        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('B1', 'Quotation No');
        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('C1', 'Customer Name');
        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('D1', 'Quotation Amount');
        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('E1', 'Invoice NO');
        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('F1', 'Invoice Date');
        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('G1', 'Invoice Amount');
        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('H1', 'Commission Amount');
        //$objPHPExcel->setActiveSheetIndex(3)->setCellValue('I1', 'Sales ID');
        // $objPHPExcel->setActiveSheetIndex(3)->setCellValue('J1', 'Sales Cost');
        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('I1', 'Profit %');
        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('J1', 'Profit Amount');

        $objPHPExcel->getActiveSheet(3)->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet(3)->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet(3)->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet(3)->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet(3)->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet(3)->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet(3)->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet(3)->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet(3)->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet(3)->getColumnDimension('K')->setWidth(20);
        // $objPHPExcel->getActiveSheet(3)->getColumnDimension('L')->setWidth(20);

        $objPHPExcel->getActiveSheet(3)->getStyle('A1:J1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet(3)->getStyle('A1:J1')->getFill()->getStartColor()->setARGB('3399ff');
        if (isset($data['profit']) && !empty($data['profit'])) {
            $m = 2;
            $n = 1;
            foreach ($data['profit'] as $val) {
                $objPHPExcel->setActiveSheetIndex(3)->setCellValue('A' . $m, $n);
                $objPHPExcel->setActiveSheetIndex(3)->setCellValue('B' . $m, $val["q_no"]);
                $objPHPExcel->setActiveSheetIndex(3)->setCellValue('C' . $m, $val["store_name"]);
                $objPHPExcel->setActiveSheetIndex(3)->setCellValue('D' . $m, $val["net_total"]);
                if (isset($val['pc_amount']) && !empty($val['pc_amount'])) {
                    if (isset($val['inv_amount']) && !empty($val['inv_amount'])) {
                        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('E' . $m, $val['inv_amount'][0]['inv_id']);
                        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('F' . $m, date('d-M-y', strtotime($val['inv_amount'][0]['created_date'])));
                        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('G' . $m, number_format($val['inv_amount'][0]['net_total'], 2));
                        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('H' . $m, $val['inv_amount'][0]['commission_rate']);
                    } else {
                        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('E' . $m, '');
                        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('F' . $m, '');
                        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('G' . $m, '');
                        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('H' . $m, '');
                    }
                } else {
                    $objPHPExcel->setActiveSheetIndex(3)->setCellValue('A' . $m, '');
                    $objPHPExcel->setActiveSheetIndex(3)->setCellValue('B' . $m, '');
                    $objPHPExcel->setActiveSheetIndex(3)->setCellValue('C' . $m, '');
                    $objPHPExcel->setActiveSheetIndex(3)->setCellValue('D' . $m, '');
                }
                if (isset($val['pc_amount']) && !empty($val['pc_amount'])) {
                    // $objPHPExcel->setActiveSheetIndex(3)->setCellValue('I' . $m, $val['pc_amount'][0]['job_id']);
                    // $objPHPExcel->setActiveSheetIndex(3)->setCellValue('J' . $m, number_format($val['pc_amount'][0]['net_total'], 2));
                    if ($val['inv_amount'][0]['net_total'] != '')
                        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('I' . $m, number_format((((float) (($val['inv_amount'][0]['net_total'] - $val['inv_amount'][0]['commission_rate']) - (float) $val['pc_amount'][0]['total_cost_price']) * 100) / (float) $val['pc_amount'][0]['total_cost_price']), 2, '.', ',') . '%');
                    if ($val['inv_amount'][0]['net_total'] != '')
                        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('J' . $m, number_format((($val['inv_amount'][0]['net_total'] - $val['inv_amount'][0]['commission_rate']) - $val['pc_amount'][0]['total_cost_price']), 2, '.', ','));
                } else {
                    // $objPHPExcel->setActiveSheetIndex(3)->setCellValue('I' . $m, '');
                    // $objPHPExcel->setActiveSheetIndex(3)->setCellValue('J' . $m, '');
                    $objPHPExcel->setActiveSheetIndex(3)->setCellValue('I' . $m, '');
                    $objPHPExcel->setActiveSheetIndex(3)->setCellValue('J' . $m, '');
                }
                $m++;
                $n++;

                $objPHPExcel->getActiveSheet()->setCellValue('D' . $m, '=SUM(D2:D' . ($m - 1) . ')');
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $m, '=SUM(G2:G' . ($m - 1) . ')');
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $m, '=SUM(H2:H' . ($m - 1) . ')');
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $m, '=SUM(J2:J' . ($m - 1) . ')');
                // $objPHPExcel->getActiveSheet()->setCellValue('K' . $m, '=SUM(K2:K' . ($m - 1) . ')');
                // $objPHPExcel->getActiveSheet()->setCellValue('L' . $m, '=SUM(L2:L' . ($m - 1) . ')');
            }
        }

        if (count($firms) > 1) {
            $objPHPExcel->getActiveSheet()->setTitle('TT Profit and Loss Report');
        } else {
            $objPHPExcel->getActiveSheet()->setTitle($firms[0]['prefix'] . ' Profit and Loss Report');
        }

        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(4);
        $objPHPExcel->setActiveSheetIndex(4)->setCellValue('A1', 'S.No');
        $objPHPExcel->setActiveSheetIndex(4)->setCellValue('B1', 'Firm Name');
        $objPHPExcel->setActiveSheetIndex(4)->setCellValue('C1', 'SKU N0');
        $objPHPExcel->setActiveSheetIndex(4)->setCellValue('D1', 'SKU Date');
        $objPHPExcel->setActiveSheetIndex(4)->setCellValue('E1', 'Product Name');
        $objPHPExcel->setActiveSheetIndex(4)->setCellValue('F1', 'Category name');
        $objPHPExcel->setActiveSheetIndex(4)->setCellValue('G1', 'Brand');
        $objPHPExcel->setActiveSheetIndex(4)->setCellValue('H1', 'Type');
        $objPHPExcel->setActiveSheetIndex(4)->setCellValue('I1', 'Stock');
        $objPHPExcel->setActiveSheetIndex(4)->setCellValue('J1', 'Qty');

        $objPHPExcel->getActiveSheet(4)->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet(4)->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet(4)->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet(4)->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet(4)->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet(4)->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet(4)->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet(4)->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet(4)->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet(4)->getColumnDimension('K')->setWidth(20);


        $objPHPExcel->getActiveSheet(4)->getStyle('A1:J1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet(4)->getStyle('A1:J1')->getFill()->getStartColor()->setARGB('3399ff');
        if (isset($data['sku']) && !empty($data['sku'])) {
            $u = 2;
            $v = 1;
            foreach ($data['sku'] as $stu11) {
                $objPHPExcel->setActiveSheetIndex(4)->setCellValue('A' . $u, $v);
                $objPHPExcel->setActiveSheetIndex(4)->setCellValue('B' . $u, $stu11["firm_name"]);
                $objPHPExcel->setActiveSheetIndex(4)->setCellValue('C' . $u, $stu11["sku_no"]);
                $objPHPExcel->setActiveSheetIndex(4)->setCellValue('D' . $u, date('d-M-y', strtotime($stu11['created_date'])));
                $objPHPExcel->setActiveSheetIndex(4)->setCellValue('E' . $u, $stu11["product_name"]);
                $objPHPExcel->setActiveSheetIndex(4)->setCellValue('F' . $u, $stu11["categoryName"]);
                $objPHPExcel->setActiveSheetIndex(4)->setCellValue('G' . $u, $stu11["brands"]);
                $objPHPExcel->setActiveSheetIndex(4)->setCellValue('H' . $u, $stu11["sku_type"]);
                $objPHPExcel->setActiveSheetIndex(4)->setCellValue('I' . $u, ($stu11['stock']));
                $objPHPExcel->setActiveSheetIndex(4)->setCellValue('J' . $u, ($stu11['qty']));
                $u++;
                $v++;
            }
        }

        if (count($firms) > 1) {
            $objPHPExcel->getActiveSheet()->setTitle('TT Manage SKU Report');
        } else {
            $objPHPExcel->getActiveSheet()->setTitle($firms[0]['prefix'] . ' Manage SKU Report');
        }

        if (count($firms) > 1) {
            $file_name = 'TT Weekly report ' . Date('d-M-Y-H-i-s');
            $title = 'TT Weekly report ' . Date('d-M-Y');
        } else {
            $file_name = $firms[0]['prefix'] . 'Weekly report ' . Date('d-M-Y-H-i-s');
            $title = $firms[0]['prefix'] . 'Weekly report ' . Date('d-M-Y');
        }


        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save($this->config->item('theme_path') . 'attachement/weekly_report/' . $file_name . '.xls');
        $data["email_details"] = $email_details = $this->cron_model->get_all_email_details();
        // echo '<pre>';
        // print_r($data["email_details"]);
        // exit;
//        $this->load->library('email');
//        $config['protocol'] = 'sendmail';
//        $config['mailpath'] = '/usr/sbin/sendmail';
//        $config['charset'] = 'iso-8859-1';
//        $config['wordwrap'] = TRUE;
        // Configure email library

        $this->load->library('email');

        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.googlemail.com';
        $config['smtp_port'] = 465;
        $config['smtp_user'] = $data['email_details'][0]['value'];
        $config['smtp_pass'] = 'MotivationS';
        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";

        $this->email->from($data['email_details'][0]['value'], 'TTBS');
        $this->email->to($data['email_details'][1]['value']);
        $this->email->subject($title);
        $this->email->message('Dear sir,<br>Kindly find the attachment for <b>' . $title . '</b><br><br><br>Thanks<br><br> TT Support Team<br>');
        $this->email->attach($this->config->item('theme_path') . 'attachement/weekly_report/' . $file_name . '.xls');

        if ($this->email->send()) {
            $this->setResponse(array('status' => 'success', 'response_code' => '200', 'message' => 'Weekly Report Send Successfully'));
        } else {
            $this->setResponse(array('status' => 'failure', 'response_code' => '500', 'message' => 'Due to no request data - action terminated'));
        }
    }

    function monthly_report() {
        $firms = $this->user_auth->get_user_firms();
        $data['po'] = $this->cron_model->get_all_po_monthly();
        $data['pc'] = $this->cron_model->get_all_invoice_monthly();
        $data['stock'] = $this->cron_model->get_all_stock();
        $data["profit"] = $quotation = $this->cron_model->get_all_profit_report_monthly();
        $data["sku"] = $this->cron_model->get_all_sku_report_monthly();
        $this->load->library('Excel');

        $objPHPExcel = new PHPExcel();

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'S.No');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'PR Number');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'PO Number');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', 'Supplier Name');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', 'Total Quantity');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', 'Delivery Quantity');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', 'Total Amount');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', 'Created date');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', 'PR Status');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', 'Delivery Status');

        $objPHPExcel->getActiveSheet(0)->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet(0)->getColumnDimension('K')->setWidth(20);

        $objPHPExcel->getActiveSheet(0)->getStyle('A1:J1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet(0)->getStyle('A1:J1')->getFill()->getStartColor()->setARGB('3399ff');

        if (isset($data['po']) && !empty($data['po'])) {
            $i = 2;
            $j = 1;
            foreach ($data['po'] as $stu) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $i, $j);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $i, $stu["pr_no"]);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $i, ($stu['pr_status'] == 'approved') ? $stu['po_no'] : '-');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $i, $stu["store_name"]);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $i, $stu["total_qty"]);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $i, $stu["delivery_qty"]);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $i, $stu["net_total"]);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $i, date('d-M-Y', strtotime($stu['created_date'])));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $i, ucfirst($stu["pr_status"]));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $i, ucfirst($stu["delivery_status"]));

                $i++;
                $j++;

                $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, '=SUM(E2:E' . ($i - 1) . ')');
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, '=SUM(F2:F' . ($i - 1) . ')');
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, '=SUM(G2:G' . ($i - 1) . ')');
            }
        }
        if (count($firms) > 1) {
            $objPHPExcel->getActiveSheet()->setTitle('TT Purchase invoice Report');
        } else {
            $objPHPExcel->getActiveSheet()->setTitle($firms[0]['prefix'] . ' Purchase invoice Report');
        }

        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(1);
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A1', 'S.No');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('B1', 'Quotation Number');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('C1', 'Customer Name');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('D1', 'Quotation Amount');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('E1', 'Invoice No');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('F1', 'Invoice Amount');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('G1', 'Paid Amount');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('H1', 'Invoice Date');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('I1', 'Invoice Status');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('J1', 'Payment Status');
        $objPHPExcel->setActiveSheetIndex(1)->setCellValue('K1', 'Delivery Status');

        $objPHPExcel->getActiveSheet(1)->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('K')->setWidth(20);
        $objPHPExcel->getActiveSheet(1)->getColumnDimension('L')->setWidth(20);

        $objPHPExcel->getActiveSheet(1)->getStyle('A1:K1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet(1)->getStyle('A1:K1')->getFill()->getStartColor()->setARGB('3399ff');

        if (isset($data['pc']) && !empty($data['pc'])) {
            $is = 2;
            $js = 1;
            foreach ($data['pc'] as $stu) {
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('A' . $is, $js);
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('B' . $is, $stu["q_no"]);
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('C' . $is, $stu["store_name"]);
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('D' . $is, $stu["q_total"]);
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('E' . $is, $stu["inv_id"]);
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('F' . $is, $stu["net_total"]);
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('G' . $is, $stu["receipt_bill"][0]['receipt_paid']);
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('H' . $is, date('d-M-Y', strtotime($stu['created_date'])));
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('I' . $is, ucfirst($stu["invoice_status"]));
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('J' . $is, ucfirst($stu["payment_status"]));
                $objPHPExcel->setActiveSheetIndex(1)->setCellValue('K' . $is, ucfirst($stu["delivery_status"]));
                $is++;
                $js++;
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $is, '=SUM(D2:D' . ($is - 1) . ')');
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $is, '=SUM(F2:F' . ($is - 1) . ')');
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $is, '=SUM(G2:G' . ($is - 1) . ')');
            }
        }

        if (count($firms) > 1) {
            $objPHPExcel->getActiveSheet()->setTitle('TT Sales invoice Report');
        } else {
            $objPHPExcel->getActiveSheet()->setTitle($firms[0]['prefix'] . ' Sales invoice Report');
        }

        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(2);
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('A1', 'S.No');
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('B1', 'Firm Name');
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('C1', 'Product Name');
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('D1', 'Category');
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('E1', 'Brand');
        $objPHPExcel->setActiveSheetIndex(2)->setCellValue('F1', 'Quantity');

        $objPHPExcel->getActiveSheet(2)->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet(2)->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet(2)->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet(2)->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet(2)->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet(2)->getColumnDimension('G')->setWidth(20);

        $objPHPExcel->getActiveSheet(2)->getStyle('A1:F1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet(2)->getStyle('A1:F1')->getFill()->getStartColor()->setARGB('3399ff');
        if (isset($data['stock']) && !empty($data['stock'])) {
            $k = 2;
            $l = 1;
            foreach ($data['stock'] as $stu) {
                $objPHPExcel->setActiveSheetIndex(2)->setCellValue('A' . $k, $l);
                $objPHPExcel->setActiveSheetIndex(2)->setCellValue('B' . $k, $stu["firm_name"]);
                $objPHPExcel->setActiveSheetIndex(2)->setCellValue('C' . $k, $stu["product_name"]);
                $objPHPExcel->setActiveSheetIndex(2)->setCellValue('D' . $k, $stu["categoryName"]);
                $objPHPExcel->setActiveSheetIndex(2)->setCellValue('E' . $k, $stu["brands"]);
                $objPHPExcel->setActiveSheetIndex(2)->setCellValue('F' . $k, $stu["quantity"]);
                $k++;
                $l++;
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $k, '=SUM(F2:F' . ($k - 1) . ')');
            }
        }

        if (count($firms) > 1) {
            $objPHPExcel->getActiveSheet()->setTitle('TT Stock Report');
        } else {
            $objPHPExcel->getActiveSheet()->setTitle($firms[0]['prefix'] . ' Stock Report');
        }

        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(3);
        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('A1', 'S.No');
        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('B1', 'Quotation No');
        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('C1', 'Customer Name');
        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('D1', 'Quotation Amount');
        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('E1', 'Invoice NO');
        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('F1', 'Invoice Date');
        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('G1', 'Invoice Amount');
        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('H1', 'Commission Amount');
        //$objPHPExcel->setActiveSheetIndex(3)->setCellValue('I1', 'Sales ID');
        // $objPHPExcel->setActiveSheetIndex(3)->setCellValue('J1', 'Sales Cost');
        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('I1', 'Profit %');
        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('J1', 'Profit Amount');

        $objPHPExcel->getActiveSheet(3)->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet(3)->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet(3)->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet(3)->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet(3)->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet(3)->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet(3)->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet(3)->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet(3)->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet(3)->getColumnDimension('K')->setWidth(20);
        // $objPHPExcel->getActiveSheet(3)->getColumnDimension('L')->setWidth(20);

        $objPHPExcel->getActiveSheet(3)->getStyle('A1:J1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet(3)->getStyle('A1:J1')->getFill()->getStartColor()->setARGB('3399ff');
        if (isset($data['profit']) && !empty($data['profit'])) {
            $m = 2;
            $n = 1;
            foreach ($data['profit'] as $val) {
                $objPHPExcel->setActiveSheetIndex(3)->setCellValue('A' . $m, $n);
                $objPHPExcel->setActiveSheetIndex(3)->setCellValue('B' . $m, $val["q_no"]);
                $objPHPExcel->setActiveSheetIndex(3)->setCellValue('C' . $m, $val["store_name"]);
                $objPHPExcel->setActiveSheetIndex(3)->setCellValue('D' . $m, $val["net_total"]);
                if (isset($val['pc_amount']) && !empty($val['pc_amount'])) {
                    if (isset($val['inv_amount']) && !empty($val['inv_amount'])) {
                        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('E' . $m, $val['inv_amount'][0]['inv_id']);
                        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('F' . $m, date('d-M-y', strtotime($val['inv_amount'][0]['created_date'])));
                        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('G' . $m, number_format($val['inv_amount'][0]['net_total'], 2));
                        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('H' . $m, $val['inv_amount'][0]['commission_rate']);
                    } else {
                        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('E' . $m, '');
                        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('F' . $m, '');
                        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('G' . $m, '');
                        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('H' . $m, '');
                    }
                } else {
                    $objPHPExcel->setActiveSheetIndex(3)->setCellValue('A' . $m, '');
                    $objPHPExcel->setActiveSheetIndex(3)->setCellValue('B' . $m, '');
                    $objPHPExcel->setActiveSheetIndex(3)->setCellValue('C' . $m, '');
                    $objPHPExcel->setActiveSheetIndex(3)->setCellValue('D' . $m, '');
                }
                if (isset($val['pc_amount']) && !empty($val['pc_amount'])) {
                    // $objPHPExcel->setActiveSheetIndex(3)->setCellValue('I' . $m, $val['pc_amount'][0]['job_id']);
                    // $objPHPExcel->setActiveSheetIndex(3)->setCellValue('J' . $m, number_format($val['pc_amount'][0]['net_total'], 2));
                    if ($val['inv_amount'][0]['net_total'] != '')
                        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('I' . $m, number_format((((float) (($val['inv_amount'][0]['net_total'] - $val['inv_amount'][0]['commission_rate']) - (float) $val['pc_amount'][0]['total_cost_price']) * 100) / (float) $val['pc_amount'][0]['total_cost_price']), 2, '.', ',') . '%');
                    if ($val['inv_amount'][0]['net_total'] != '')
                        $objPHPExcel->setActiveSheetIndex(3)->setCellValue('J' . $m, number_format((($val['inv_amount'][0]['net_total'] - $val['inv_amount'][0]['commission_rate']) - $val['pc_amount'][0]['total_cost_price']), 2, '.', ','));
                } else {
                    // $objPHPExcel->setActiveSheetIndex(3)->setCellValue('I' . $m, '');
                    // $objPHPExcel->setActiveSheetIndex(3)->setCellValue('J' . $m, '');
                    $objPHPExcel->setActiveSheetIndex(3)->setCellValue('I' . $m, '');
                    $objPHPExcel->setActiveSheetIndex(3)->setCellValue('J' . $m, '');
                }
                $m++;
                $n++;

                $objPHPExcel->getActiveSheet()->setCellValue('D' . $m, '=SUM(D2:D' . ($m - 1) . ')');
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $m, '=SUM(G2:G' . ($m - 1) . ')');
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $m, '=SUM(H2:H' . ($m - 1) . ')');
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $m, '=SUM(J2:J' . ($m - 1) . ')');
                // $objPHPExcel->getActiveSheet()->setCellValue('K' . $m, '=SUM(K2:K' . ($m - 1) . ')');
                // $objPHPExcel->getActiveSheet()->setCellValue('L' . $m, '=SUM(L2:L' . ($m - 1) . ')');
            }
        }

        if (count($firms) > 1) {
            $objPHPExcel->getActiveSheet()->setTitle('TT Profit and Loss Report');
        } else {
            $objPHPExcel->getActiveSheet()->setTitle($firms[0]['prefix'] . ' Profit and Loss Report');
        }

        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(4);
        $objPHPExcel->setActiveSheetIndex(4)->setCellValue('A1', 'S.No');
        $objPHPExcel->setActiveSheetIndex(4)->setCellValue('B1', 'Firm Name');
        $objPHPExcel->setActiveSheetIndex(4)->setCellValue('C1', 'SKU N0');
        $objPHPExcel->setActiveSheetIndex(4)->setCellValue('D1', 'SKU Date');
        $objPHPExcel->setActiveSheetIndex(4)->setCellValue('E1', 'Product Name');
        $objPHPExcel->setActiveSheetIndex(4)->setCellValue('F1', 'Category name');
        $objPHPExcel->setActiveSheetIndex(4)->setCellValue('G1', 'Brand');
        $objPHPExcel->setActiveSheetIndex(4)->setCellValue('H1', 'Type');
        $objPHPExcel->setActiveSheetIndex(4)->setCellValue('I1', 'Stock');
        $objPHPExcel->setActiveSheetIndex(4)->setCellValue('J1', 'Qty');

        $objPHPExcel->getActiveSheet(4)->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet(4)->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet(4)->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet(4)->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet(4)->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet(4)->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet(4)->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet(4)->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet(4)->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet(4)->getColumnDimension('K')->setWidth(20);


        $objPHPExcel->getActiveSheet(4)->getStyle('A1:J1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet(4)->getStyle('A1:J1')->getFill()->getStartColor()->setARGB('3399ff');
        if (isset($data['sku']) && !empty($data['sku'])) {
            $u = 2;
            $v = 1;
            foreach ($data['sku'] as $stu11) {
                $objPHPExcel->setActiveSheetIndex(4)->setCellValue('A' . $u, $v);
                $objPHPExcel->setActiveSheetIndex(4)->setCellValue('B' . $u, $stu11["firm_name"]);
                $objPHPExcel->setActiveSheetIndex(4)->setCellValue('C' . $u, $stu11["sku_no"]);
                $objPHPExcel->setActiveSheetIndex(4)->setCellValue('D' . $u, date('d-M-y', strtotime($stu11['created_date'])));
                $objPHPExcel->setActiveSheetIndex(4)->setCellValue('E' . $u, $stu11["product_name"]);
                $objPHPExcel->setActiveSheetIndex(4)->setCellValue('F' . $u, $stu11["categoryName"]);
                $objPHPExcel->setActiveSheetIndex(4)->setCellValue('G' . $u, $stu11["brands"]);
                $objPHPExcel->setActiveSheetIndex(4)->setCellValue('H' . $u, $stu11["sku_type"]);
                $objPHPExcel->setActiveSheetIndex(4)->setCellValue('I' . $u, ($stu11['stock']));
                $objPHPExcel->setActiveSheetIndex(4)->setCellValue('J' . $u, ($stu11['qty']));
                $u++;
                $v++;
            }
        }

        if (count($firms) > 1) {
            $objPHPExcel->getActiveSheet()->setTitle('TT Manage SKU Report');
        } else {
            $objPHPExcel->getActiveSheet()->setTitle($firms[0]['prefix'] . ' Manage SKU Report');
        }

        if (count($firms) > 1) {
            $file_name = 'TT Monthly report ' . Date('d-M-Y-H-i-s');
            $title = 'TT Monthly report ' . Date('d-M-Y');
        } else {
            $file_name = $firms[0]['prefix'] . ' Monthly report ' . Date('d-M-Y-H-i-s');
            $title = $firms[0]['prefix'] . ' Monthly report ' . Date('d-M-Y');
        }


        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save($this->config->item('theme_path') . 'attachement/monthly_report/' . $file_name . '.xls');
        $data["email_details"] = $email_details = $this->cron_model->get_all_email_details();

        $this->load->library('email');

        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.googlemail.com';
        $config['smtp_port'] = 465;
        $config['smtp_user'] = $data['email_details'][0]['value'];
        $config['smtp_pass'] = 'MotivationS';
        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";

        $this->email->attach($this->config->item('theme_path') . 'attachement/monthly_report/' . $file_name . '.xls');
        $this->email->from($data['email_details'][0]['value']);
        $this->email->to($data['email_details'][1]['value']);
        $this->email->subject($title);
        $this->email->message('Dear sir,<br>Kindly find the attachment for <b>' . $title . '</b><br><br><br>Thanks<br><br> TT Support Team<br>');
        if ($this->email->send()) {
            $this->setResponse(array('status' => 'success', 'response_code' => '200', 'message' => 'Monthly Report Send Successfully'));
        } else {
            $this->setResponse(array('status' => 'failure', 'response_code' => '500', 'message' => 'Due to no request data - action terminated'));
        }
    }

    public function setResponse($output) {
        echo json_encode($output);
        exit;
    }

    public function monthly_shrinkage() {
        $this->load->model('stock/physical_report_model');
        $stocks = $this->cron_model->get_all_stock_for_stockreport();
        $curr_date = date('d');
        $is_success = 0;
        $skip_rows = 1;
        $flag = true;
        // if ($curr_date == 25) {
        $this->load->library('Excel');

        $objPHPExcel = new PHPExcel();

        $objPHPExcel->createSheet();

        $objPHPExcel->setActiveSheetIndex();
        $objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'Firm Name');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'Category');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'Product Name');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Brand');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'System Quantity');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'Physical Quantity');

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);

        $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFill()->getStartColor()->setARGB('3399ff');

        if (isset($stocks) && !empty($stocks)) {
            $u = 2;
            $v = 1;
            foreach ($stocks as $val) {
                $objPHPExcel->setActiveSheetIndex()->setCellValue('A' . $u, $val['firm_name']);
                $objPHPExcel->setActiveSheetIndex()->setCellValue('B' . $u, $val['categoryName']);
                $objPHPExcel->setActiveSheetIndex()->setCellValue('C' . $u, $val['product_name']);
                $objPHPExcel->setActiveSheetIndex()->setCellValue('D' . $u, $val['brands']);
                $objPHPExcel->setActiveSheetIndex()->setCellValue('E' . $u, $val['quantity']);
                $objPHPExcel->setActiveSheetIndex()->setCellValue('F' . $u, '');

                $u++;
                $v++;
            }
        }
        $objPHPExcel->getActiveSheet()->setTitle('Monthly Stock Report');
        $file_name = 'Monthly Stock Report (' . Date('M-Y') . ')';
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
        $objWriter->save($this->config->item('theme_path') . 'attachement/physical_stock/monthly_shrinkage/' . $file_name . '.csv');
        $file = $this->config->item('theme_path') . 'attachement/physical_stock/monthly_shrinkage/' . $file_name . '.csv';
        $shrinkage = array();
        $shrinkage['document_name'] = $file_name . '.csv';
        $shrinkage['entry_date'] = date('Y-m-d');
        $shrinkage['created_date'] = date('Y-m-d h:i:s');
        $insert_id = $this->physical_report_model->insert_shrinkage($shrinkage);
        $handle = fopen($file, 'r');
        $row_data = fgetcsv($handle);

        $count = 0;
        $row = 1;
        while (($row_data = fgetcsv($handle, 0, ",")) !== FALSE) {
            if ($flag == true) {
                $flag = false;
                continue;
            }
            $firm_name = $row_data[0];
            $category = $row_data[1];
            $product_name = $row_data[2];
            $brand = $row_data[3];
            $sys_qty = $row_data[4];
            $physical_qty = $row_data[5];
            $firm_id = $this->physical_report_model->is_firm_name_exist($firm_name);
            $cat_id = $this->physical_report_model->is_category_name_exist($category);
            $product_id = $this->physical_report_model->is_product_name_exist($product_name);
            $brand_id = $this->physical_report_model->is_brand_name_exist($brand);
            $physical_stock = array();
            $physical_stock['shrinkage_id'] = $insert_id;
            $physical_stock['firm_id'] = $firm_id;
            $physical_stock['category'] = $cat_id;
            $physical_stock['brand'] = $brand_id;
            $physical_stock['product_id'] = $product_id;
            $physical_stock['system_quantity'] = $sys_qty;
            $physical_stock['physical_quantity'] = $physical_qty;
            $physical_stock['entry_date'] = date('Y-m-d');
            $this->physical_report_model->insert_physical_stock($physical_stock);
            $is_success = 1;
        }
        if ($is_success) {
            $this->setResponse(array('status' => 'success', 'response_code' => '200', 'message' => 'Monthly Shrinkage Updated Successfully'));
        } else {
            $this->setResponse(array('status' => 'failure', 'response_code' => '500', 'message' => 'Due to no request data - action terminated'));
        }
//        } else {
//            $this->setResponse(array('status' => 'failure', 'response_code' => '500', 'message' => 'Monthly Shrinkage will be run out on 25th only'));
//        }
    }

    /* public function test_sms() {
      $mobile_numbers = array('9043477007');
      $msg = 'Dear Aisha laatha, Your Payment is pending for the invoice   INV-TTH-17-11-002  , and your bill amount is Rs.165, Kindly pay it for continous services.';
      foreach ($mobile_numbers as $val) {
      $service_url = 'http://bulk.sysmechsolutions.in/api/sendmsg.php?user=eetotal&pass=EeTotal@123&sender=ttbill&phone=' . $val . '&text=' . urlencode($msg) . '&priority=sdnd&stype=normal';
      $jobs1 = curl_init();
      curl_setopt($jobs1, CURLOPT_URL, $service_url);
      curl_setopt($jobs1, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($jobs1, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($jobs1, CURLOPT_SSL_VERIFYHOST, false);
      echo curl_exec($jobs1);
      }
      } */

    /* public function test_email() {
      $data["email_details"] = $email_details = $this->gen_model->get_all_email_details();
      $this->load->library('email');
      $config['protocol'] = 'sendmail';
      $config['mailpath'] = '/usr/sbin/sendmail';
      $config['charset'] = 'iso-8859-1';
      $config['wordwrap'] = TRUE;
      $this->email->initialize($config);
      $this->email->set_newline("\r\n");
      //$this->email->attach($this->config->item('theme_path') . 'attachement/monthly_report/' . $file_name . '.xls');
      $this->email->from($data['email_details'][1]['value']);
      $this->email->to('divyabui2k17@gmail.com');
      $this->email->subject('Invoice');
      $this->email->message('Dear sir,<br>Kindly find the attachment for <b> Invoice </b><br><br><br>Thanks<br><br> TT Support Team<br>');
      if ($this->email->send()) {
      $this->setResponse(array('status' => 'success', 'response_code' => '200', 'message' => 'Monthly Report Send Successfully'));
      } else {
      $this->setResponse(array('status' => 'failure', 'response_code' => '500', 'message' => 'Due to no request data - action terminated'));
      }
      } */

    public function pending_payment() {
        $this->load->model('sales_receipt/sales_receipt_model');
        $payment_info = $this->sales_receipt_model->get_all_receipt();
        $today = date('l');
        $i = -1;
        if ($today == 'Monday') {
            if (isset($payment_info) && !empty($payment_info)) {
                foreach ($payment_info as $val) {
                    $i++;
                    $bill_amount = $val['net_total'] - $val['receipt_bill'][0]['receipt_paid'];
                    if ($bill_amount > 0) {
                        $sms_message = 'Dear ' . $val['name'] . ', Your Payment is pending for the invoice ' . $val['inv_id'] . ', and your bill amount is Rs.' . $bill_amount . ', Kindly pay it for continous services.';
                        $mobile = $val['mobil_number'];
                        $service_url = 'http://bulk.sysmechsolutions.in/api/sendmsg.php?user=eetotal&pass=EeTotal@123&sender=ttbill&phone=' . $mobile . '&text=' . urlencode($sms_message) . '&priority=dnd&stype=normal';
                        $jobs1 = curl_init();
                        curl_setopt($jobs1, CURLOPT_URL, $service_url);
                        curl_setopt($jobs1, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($jobs1, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($jobs1, CURLOPT_SSL_VERIFYHOST, false);
                        curl_exec($jobs1);
                        $email = $this->send_email($val['email_id'], $sms_message);
                        if ($email) {
                            $this->setResponse(array('status' => 'success', 'response_code' => '200', 'message' => 'Monthly Report Send Successfully'));
                        } else {
                            $this->setResponse(array('status' => 'failure', 'response_code' => '500', 'message' => 'Due to no request data - action terminated'));
                        }
                    }
                }
            }
        }
    }

    public function pending_payment_by_id($id) {
        $this->load->model('sales_receipt/sales_receipt_model');
//$payment_info = $this->sales_receipt_model->get_receipt_by_id($id);
        $payment_info = $this->admin_model->get_customer_by_invoice($id);

        $i = 0;
        if (isset($payment_info) && !empty($payment_info)) {
            foreach ($payment_info as $val) {
                $i++;
                $bill_amount = $val['net_total'] - $val['receipt_bill'][0]['receipt_paid'];

                if ($bill_amount > 0) {
                    $sms_message = 'Dear ' . $val['name'] . ', Your Payment is pending for the invoice ' . $val['inv_id'] . ', and your bill amount is Rs.' . $bill_amount . ', Kindly pay it for continous services.';
                    $mobile = $val['mobil_number'];


                    $this->send_email($val['email_id'], $sms_message);
                    $service_url = 'https://bulk.sysmechsolutions.in/api/sendmsg.php?user=eetotal&pass=EeTotal@123&sender=ttbill&phone=9500851999&text=' . urlencode($sms_message) . '&priority=sdnd&stype=normal';

                    $jobs2 = curl_init();
                    curl_setopt($jobs2, CURLOPT_URL, $service_url);
                    curl_setopt($jobs2, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($jobs2, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($jobs2, CURLOPT_SSL_VERIFYHOST, false);
                    curl_exec($jobs2);

                    redirect($this->config->item('base_url'));
                }
            }
        } else {
            redirect($this->config->item('base_url'));
        }
    }

    public function birthday_notification() {
        $this->load->model('masters/customer_model');
        $this->load->model('masters/supplier_model');
        $today = date('M-d');
        $customers = $this->customer_model->get_customer();
        $suppliers = $this->supplier_model->get_vendor();
        $mobile_numbers = '';
        $mbl_numbers = '';
        if (isset($customers) && !empty($customers)) {
            $i = 0;
            foreach ($customers as $val) {
                if (date('M-d', strtotime($val['dob'])) == $today) {
                    $i++;
                    if ($i != 1) {
                        $mobile_numbers .= ',' . $val['mobil_number'];
                    } else {
                        $mobile_numbers .= $val['mobil_number'];
                    }

                    $message = 'TTBS Wishing you a very Happy Birthday! We appreciate all the business that you brought our way, and we hope you will achieve all the goals you have set for yourself in the coming year.';
                    $service_url = 'http://bulk.sysmechsolutions.in/api/sendmsg.php?user=eetotal&pass=EeTotal@123&sender=ttbill&phone=' . $val['mobil_number'] . '&text=' . urlencode($message) . '&priority=dnd&stype=normal';
                    $jobs1 = curl_init();
                    curl_setopt($jobs1, CURLOPT_URL, $service_url);
                    curl_setopt($jobs1, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($jobs1, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($jobs1, CURLOPT_SSL_VERIFYHOST, false);
                    curl_exec($jobs1);
                    $email = $this->send_email($val['email_id'], $message);
                    if ($email) {
                        $this->setResponse(array('status' => 'success', 'response_code' => '200', 'message' => 'Monthly Report Send Successfully'));
                    } else {
                        $this->setResponse(array('status' => 'failure', 'response_code' => '500', 'message' => 'Due to no request data - action terminated'));
                    }
                }
            }
        }


        if (isset($suppliers) && !empty($suppliers)) {
            $j = 0;
            foreach ($suppliers as $val1) {
                if (date('M-d', strtotime($val1['dob'])) == $today) {
                    $j++;
                    if ($j != 1) {
                        $mbl_numbers .= ',' . $val1['mobil_number'];
                    } else {
                        $mbl_numbers .= $val1['mobil_number'];
                    }

                    $msg = 'TTBS Wishing you a very Happy Birthday! We appreciate all the business that you brought our way, and we hope you will achieve all the goals you have set for yourself in the coming year.';
                    $service_url1 = 'http://bulk.sysmechsolutions.in/api/sendmsg.php?user=eetotal&pass=EeTotal@123&sender=ttbill&phone=' . $val1['mobil_number'] . '&text=' . urlencode($msg) . '&priority=dnd&stype=normal';
                    $jobs2 = curl_init();
                    curl_setopt($jobs2, CURLOPT_URL, $service_url1);
                    curl_setopt($jobs2, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($jobs2, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($jobs2, CURLOPT_SSL_VERIFYHOST, false);
                    curl_exec($jobs2);
                    $email = $this->send_email($val['email_id'], $msg);
                    if ($email) {
                        $this->setResponse(array('status' => 'success', 'response_code' => '200', 'message' => 'Monthly Report Send Successfully'));
                    } else {
                        $this->setResponse(array('status' => 'failure', 'response_code' => '500', 'message' => 'Due to no request data - action terminated'));
                    }
                }
            }
        }
    }

    public function anniversary_notification() {
        $this->load->model('masters/customer_model');
        $this->load->model('masters/supplier_model');
        $today = date('M-d');
        $customers = $this->customer_model->get_customer();
        $suppliers = $this->supplier_model->get_vendor();
        $mobile_numbers = '';
        $mbl_numbers = '';
        if (isset($customers) && !empty($customers)) {
            $i = 0;
            foreach ($customers as $val) {
                if (date('M-d', strtotime($val['anniversary'])) == $today) {
                    $i++;
                    if ($i != 1) {
                        $mobile_numbers .= ',' . $val['mobil_number'];
                    } else {
                        $mobile_numbers .= $val['mobil_number'];
                    }
                }
            }

            $message = 'Thanks for Being a customer, In honour of you membership anniverssary we would like to greet you for successful life.';
            $service_url = 'http://bulk.sysmechsolutions.in/api/sendmsg.php?user=eetotal&pass=EeTotal@123&sender=ttbill&phone=' . $mobile_numbers . '&text=' . urlencode($message) . '&priority=dnd&stype=normal';
            $jobs1 = curl_init();
            curl_setopt($jobs1, CURLOPT_URL, $service_url);
            curl_setopt($jobs1, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($jobs1, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($jobs1, CURLOPT_SSL_VERIFYHOST, false);
            curl_exec($jobs1);
            $email = $this->send_email($val['email_id'], $message);
            if ($email) {
                $this->setResponse(array('status' => 'success', 'response_code' => '200', 'message' => 'Monthly Report Send Successfully'));
            } else {
                $this->setResponse(array('status' => 'failure', 'response_code' => '500', 'message' => 'Due to no request data - action terminated'));
            }
        }

        if (isset($suppliers) && !empty($suppliers)) {
            $j = 0;
            foreach ($suppliers as $val1) {
                if (date('M-d', strtotime($val1['anniversary_date'])) == $today) {
                    $j++;
                    if ($j != 1) {
                        $mbl_numbers .= ',' . $val1['mobil_number'];
                    } else {
                        $mbl_numbers .= $val1['mobil_number'];
                    }
                }
            }
            $msg = 'Thanks for Being a customer, In honour of you membership anniverssary we would like to greet you for successful life.';
            $service_url1 = 'http://bulk.sysmechsolutions.in/api/sendmsg.php?user=eetotal&pass=EeTotal@123&sender=ttbill&phone=' . $mbl_numbers . '&text=' . urlencode($msg) . '&priority=dnd&stype=normal';
            $jobs2 = curl_init();
            curl_setopt($jobs2, CURLOPT_URL, $service_url1);
            curl_setopt($jobs2, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($jobs2, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($jobs2, CURLOPT_SSL_VERIFYHOST, false);
            curl_exec($jobs2);

            $email = $this->send_email($val['email_id'], $msg);
            if ($email) {
                $this->setResponse(array('status' => 'success', 'response_code' => '200', 'message' => 'Monthly Report Send Successfully'));
            } else {
                $this->setResponse(array('status' => 'failure', 'response_code' => '500', 'message' => 'Due to no request data - action terminated'));
            }
        }
    }

    public function send_email1($to, $msg) {
        $email_details = $this->gen_model->get_all_email_details();
//	$this->load->library('email');
//	$config['protocol'] = 'sendmail';
//	$config['mailpath'] = '/usr/sbin/sendmail';
//	$config['charset'] = 'iso-8859-1';
//	$config['wordwrap'] = TRUE;
//	$this->email->initialize($config);
        $this->load->helper(array('email'));
        send_email($email_details[1]['value'], $to, $email_details[2]['value'], $msg);
//        $config['protocol'] = 'sendmail';
//        $config['mailpath'] = '/usr/sbin/sendmail';
//        $config['charset'] = 'iso-8859-1';
//        $config['wordwrap'] = TRUE;
//        $this->email->initialize($config);
//  $this->email->set_newline("\r\n");
        $this->email->set_mailtype("html");
        $this->email->from($email_details[1]['value'], $email_details[0]['value']);
        $this->email->to('mohaseenbui2016@gmail.com');
        $this->email->subject($email_details[2]['value']);
        $this->email->message($msg);
        $this->email->send();
    }

    public function send_email($to, $msg) {
        $email_details = $this->gen_model->get_all_email_details();
        $this->load->model('cron/cron_model');
        $emails = $this->cron_model->get_all_email_details();
        $this->load->library('email');
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.googlemail.com';
        $config['smtp_port'] = 465;
        $config['smtp_user'] = $emails[0]['value'];
        $config['smtp_pass'] = 'MotivationS';
        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";
        $this->email->from($email_details[1]['value'], $email_details[0]['value']);
        $this->email->to($to);
        $this->email->subject($email_details[2]['value']);
        $this->email->message($msg);
        $this->email->send();
    }

}
