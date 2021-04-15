<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Categories extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->clear_cache();
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url') . 'admin');
        }
        $main_module = 'masters';
        $access_arr = array(
            'categories/index' => array('add', 'edit', 'delete', 'view'),
            'categories/insert_master_category' => array('add'),
            'categories/save_defect' => array('add'),
            'categories/update_category' => array('edit'),
            'categories/update_categories' => array('edit'),
            'categories/delete_master_category' => array('delete'),
            'categories/add_duplicate_category' => array('add', 'edit'),
            'categories/update_duplicate_category' => array('add', 'edit'),
        );

        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }
        $this->load->model('masters/categories_model');
    }

    function redirect_function($url) {
        ?>
        <script>
            window.location.href = "<?php echo $url; ?>";
        </script>
        <?php
    }

    public function index() {
        $data['corrective_action'] = $corrective_action = $this->categories_model->get_all_corrective_action();
        $data['firms'] = $firms = $this->user_auth->get_user_firms();
        //   echo"<pre>"; print_r($data); exit;
        $data["detail"] = $details = $this->categories_model->get_all_category();
        $this->template->write_view('content', 'masters/categories', $data);
        $this->template->render();
    }

    public function insert_master_category() {

        $input = array('category' => $this->input->post('category'));
        if ($input['category'] != '') {
            $this->categories_model->insert_master_category($input);
            $data["detail"] = $this->categories_model->get_all_category();
            redirect($this->config->item('base_url') . 'masters');
        } else {
            $data["detail"] = $this->categories_model->get_all_category();
            $this->template->write_view('content', 'masters/categories', $data);
            $this->template->render();
        }
    }

    public function update_category() {

        $data = $this->input->post();
        $data['created_by'] = $this->user_auth->get_user_id();
        $action_ids = $data['actionId'];
        unset($data["actionId"]);
        unset($data["sub_categoryName"]);
        // echo"<pre>"; print_r($data); exit;
        $this->categories_model->update_defect($data);
        $insert_id = $data['cat_id'];
        if (isset($insert_id) && !empty($insert_id)) {
            if (isset($action_ids) && !empty($action_ids)) {
                foreach ($action_ids as $key) {
                    $datas[] = array('cat_id' => $insert_id, 'actionId' => $key);
                }
                $defect_type_id = $this->categories_model->insert_defect_type_corrective_action($datas, $insert_id);
            }
        }
        $url = $this->config->item('base_url') . "masters/categories";
        $this->redirect_function($url);
    }

    public function delete_master_category() {

        $id = $this->input->get('value1');
        $this->categories_model->delete_master_category($id);
        $data["detail"] = $this->categories_model->get_all_category();
        redirect($this->config->item('base_url') . 'masters/categories', $data);
    }

    public function add_duplicate_category() {
        $input = $this->input->post();
        $validation = $this->categories_model->add_duplicate_category($input);
        $i = 0;
        if ($validation) {
            $i = 1;
        }if ($i == 1) {
            echo "Category Name already Exist";
        }
    }

    public function update_duplicate_category() {

        $input = $this->input->post('value1');
        $id = $this->input->post('value2');
        $validation = $this->categories_model->update_duplicate_category($input, $id);
        //echo $input; echo $id; exit;
        $i = 0;
        if ($validation) {
            $i = 1;
        }if ($i == 1) {
            echo "Category Name already Exist";
        }
    }

    function save_defect() {

        $data = $this->input->post();
        $data['created_by'] = $this->user_auth->get_user_id();
        $action_ids = $data['actionId'];
        unset($data["actionId"]);
        unset($data["sub_categoryName"]);

        $insert_id = $this->categories_model->insert_defect($data);
        if (isset($insert_id) && !empty($insert_id)) {
            if (isset($action_ids) && !empty($action_ids)) {
                foreach ($action_ids as $key) {
                    $datas[] = array('cat_id' => $insert_id, 'actionId' => $key);
                }
                $defect_type_id = $this->categories_model->insert_defect_type_corrective_action($datas, $insert_id);
            }
        }
        $url = $this->config->item('base_url') . "masters/categories";
        $this->redirect_function($url);
    }

    function update_categories($id) {
        $data['defect_type'] = $defect_type = $this->categories_model->get_all_defect_type_data($id);
        $data['firms'] = $firms = $this->user_auth->get_user_firms();
        //echo"<pre>";print_r($defect_type);exit;
        $this->template->write_view('content', 'masters/edit_category', $data);
        $this->template->render();
    }

    function save_action() {
        $datas = $this->input->post();
        $data = $datas['sub_categoryName'];

        if (isset($datas) && !empty($datas)) {
            //echo"<pre>"; print_r($datas); exit;
            $insert_id = $this->categories_model->insert_action($datas);
            echo "<tbody><tr><td><input type='checkbox' name='actionId[]' value='$insert_id'></td>
            <td class='edit_name hide_edit'><input type='text' id='$insert_id' value='$data' disabled /></td>
            <td class='text-right'><a href='javascript:void(0);' class='edit_corrective_action' maze='$data' id='$insert_id' hijacked='yes'><i class='fa fa-edit'></i></a> &nbsp; <a id='$insert_id' class='delete_corrective_action' data-original-title='Delete' hijacked='yes'><i class='fa fa-close'></i></a></td>
        </tr><tbody>";
            $this->skip_template_view();
        }
    }

    function delete_action_by_id($id) {

        $datas = $this->input->post();
        //$user_id= $this->session->userdata('iUserId');
        echo $this->categories_model->delete_action_by_ids($datas['del_id']);
        $this->skip_template_view();
    }

    function edit_action_by_id($id) {

        $datas = $this->input->post();
        $id = $datas['actionId'];
        //echo"<pre>"; print_r($datas); exit;
        unset($datas['actionId']);
        echo $this->categories_model->update_action_by_ids($id, $datas);
        $this->skip_template_view();
    }

    function clear_cache() {
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }

}
