<?php







if (!defined('BASEPATH'))



    exit('No direct script access allowed');







class User_model extends CI_Model
{







    private $table_name = 'erp_user';



    private $master_user_role = 'master_user_role';



    private $erp_user_roles = 'erp_user_roles';



    var $joinTable1 = 'erp_manage_firms f';



    var $joinTable2 = 'erp_user_roles r';



    var $joinTable3 = 'erp_user_firms uf';



    var $primaryTable = 'erp_user u';



    var $selectColumn = 'u.id,u.username,u.mobile_no,u.email_id,u.name,r.user_role';



    var $column_order = array(null, 'u.name', 'u.username', 'u.mobile_no', 'u.email_id', 'r.user_role', '', null); //set column field database for datatable orderable



    var $column_search = array('u.name', 'u.user_name', 'u.mobile_no', 'u.email_id', 'r.user_role', ''); //set column field database for datatable searchable



    var $order = array('u.id' => 'DESC'); // default order







    function __construct()
    {



        parent::__construct();
    }







    public function insert_user($data)
    {







        if ($this->db->insert($this->table_name, $data)) {



            $insert_id = $this->db->insert_id();



            return $insert_id;



            $this->load->database();
        }



        return false;
    }







    public function state()
    {



        $this->db->select('*');



        $this->db->where('status', 1);



        $query = $this->db->get($this->table_name);



        if ($query->num_rows() > 0) {



            return $query->result_array();
        }



        return false;
    }







    public function get_user1($id)
    {



        $this->db->select($this->table_name . '.*');



        $this->db->where($this->table_name . '.id', $id);



        $this->db->where($this->table_name . '.status', 1);



        $query = $this->db->get($this->table_name)->result_array();



        $i = 0;



        foreach ($query as $val) {



            $this->db->select('*');



            $this->db->where('user_id', $id);



            $query[$i]['firm'] = $this->db->get('erp_user_firms')->result_array();
        }



        return $query;
    }







    public function get_user()
    {



        $this->db->select($this->table_name . '.*');



        $this->db->select($this->erp_user_roles . '.user_role');



        $this->db->join('erp_user_roles', $this->table_name . '.role=erp_user_roles.id', 'left');

        //$this->db->join('erp_user_firms','erp_user_firms.user_id=erp_user_roles.id', 'left');



        $this->db->where($this->table_name . '.status', 1);







        $query = $this->db->get($this->table_name)->result_array();



        $i = 0;



        foreach ($query as $val) {



            $this->db->select('erp_user_firms.firm_id');



            $this->db->where('erp_user_firms.user_id', $val['id']);



            $result = $this->db->get('erp_user_firms')->result_array();







            foreach ($result as $res) {



                $this->db->select('erp_manage_firms.firm_name as name');



                $this->db->where('erp_manage_firms.firm_id', $res['firm_id']);



                $list = $this->db->get('erp_manage_firms')->result_array();



                $list1 = call_user_func_array('array_merge', $list);



                $query[$i]['firm_name'][] = call_user_func_array('array_merge', $list);
            }



            $i++;
        }



        return $query;
    }







    function get_insert_users_from_biousers()
    {



        $this->db->select('erp_user.*');



        $query = $this->db->get('erp_user')->result_array();



        $result_data = "";



        if ($query) {



            foreach ($query as $val) {



                $this->db->select('users.*');



                $this->db->where('users.email', $val['email_id']);



                $result = $this->db->get('users');



                if ($result->num_rows() == 0) {



                    $insert_data = array();



                    $insert_data['username'] = $val['username'];



                    $insert_data['password'] = $val['password'];



                    $insert_data['first_name'] = $val['name'];



                    $insert_data['email'] = $val['email_id'];



                    $insert_data['status'] = $val['status'];



                    $insert_data['image'] = $val['admin_image'];







                    $this->db->insert('users', $insert_data);



                    $insert_id = $this->db->insert_id();







                    $list['insert_id'] = $insert_id;



                    $update_data = array();



                    $update_data['access_id'] = $insert_id;



                    $update_data['employee_id'] = "EMP-" . $insert_id;







                    $this->db->where('users.id', $insert_id);



                    $this->db->update('users', $update_data);



                    $result_data[] = $list;
                }
            }
        }







        return $result_data;
    }







    public function get_all_device_log_attenance_details()
    {



        $this->db->select('users.id', 'users.username');



        $user_details = $this->db->get('users');



        if ($user_details->num_rows() > 0) {



            $user_details = $user_details->result_array();



            foreach ($user_details as $key => $user_data) {



                $this->db->where('device_log.status', 0);



                $this->db->where('device_log.user_id', $user_data['id']);



                $device_log = $this->db->get('device_log');







                if ($device_log->num_rows() > 0) {



                    $device_log = $device_log->result_array();



                    $total_device_log = count($device_log);







                    foreach ($device_log as $keys => $log_data) {







                        $user_atten_date = $log_data['log_date'];



                        $atten_user_id = $log_data['user_id'];



                        if ($keys == 0) {



                            $insert_atten_data = [



                                "user_id" => $log_data['user_id'],



                                "in" => $log_data['time'],



                                "created" => $log_data['log_date'] . " 00:00:00",



                                "updated" => $log_data['log_date'] . " 00:00:00",



                            ];



                            $this->db->insert('attendance', $insert_atten_data);



                            $insert_attenance_id = $this->db->insert_id();
                        }



                        if (!($keys == ($total_device_log - 1))) {



                            if ($total_device_log > 2) {



                                if ($keys % 2 != 0) {



                                    $insert_break_data = [



                                        "attendance_id" => $insert_attenance_id,



                                        "out_time" => $log_data['time'],



                                        "type" => "break",



                                    ];



                                    $this->db->insert('break_table', $insert_break_data);



                                    $insert_break_id = $this->db->insert_id();
                                } elseif ($keys % 2 == 0) {



                                    $this->db->where('break_table.id', $insert_break_id);



                                    $this->db->where('break_table.attendance_id', $insert_attenance_id);



                                    $update_break_data = [



                                        "in_time" => $log_data['time'],



                                    ];



                                    $update_break = $this->db->update('break_table', $update_break_data);
                                }
                            }
                        }







                        if ($keys == ($total_device_log - 1)) {



                            $this->db->where('attendance.id', $insert_attenance_id);



                            $update_atten_data = [



                                "out" => $log_data['time'],



                                "updated" => $log_data['log_date'] . " 00:00:00",



                            ];



                            $update_atten = $this->db->update('attendance', $update_atten_data);
                        }
                    }







                    $this->db->where('device_log.log_date', $user_atten_date);



                    $this->db->where('device_log.user_id', $atten_user_id);



                    $this->db->update('device_log', ["status" => 1]);



                    $result[$user_data['username']][$key] = 1;
                } else {



                    $result[$user_data['username']][$key] = 0;
                }
            }



            return $result;
        } else {



            return false;
        }
    }







    public function get_all_device_log_attenance_direction()
    {



        $this->db->select('users.id', 'users.username');



        $user_details = $this->db->get('users');



        if ($user_details->num_rows() > 0) {



            $user_details = $user_details->result_array();



            foreach ($user_details as $key => $user_data) {



                $this->db->where('device_log.status', 0);



                $this->db->where('device_log.user_id', $user_data['id']);



                $device_log = $this->db->get('device_log');







                if ($device_log->num_rows() > 0) {



                    $device_log = $device_log->result_array();



                    $total_device_log = count($device_log);







                    foreach ($device_log as $keys => $log_data) {



                        $user_atten_date = $log_data['log_date'];



                        $atten_user_id = $log_data['user_id'];



                        if ($keys == 0) {



                            if ($log_data['direction'] == 1) {



                                $insert_atten_data = [



                                    "user_id" => $log_data['user_id'],



                                    "in" => $log_data['time'],



                                    "created" => $log_data['log_date'] . " 00:00:00",



                                    "updated" => $log_data['log_date'] . " 00:00:00",



                                ];



                                $this->db->insert('attendance', $insert_atten_data);



                                $insert_attenance_id = $this->db->insert_id();
                            }
                        }



                        if (!($keys == ($total_device_log - 1))) {



                            if ($total_device_log > 2) {



                                if ($log_data['direction'] == 0) {



                                    $insert_break_data = [



                                        "attendance_id" => $insert_attenance_id,



                                        "out_time" => $log_data['time'],



                                        "type" => "break",



                                    ];



                                    $this->db->insert('break_table', $insert_break_data);



                                    $insert_break_id = $this->db->insert_id();
                                } else if ($log_data['direction'] == 1) {



                                    $this->db->where('break_table.id', $insert_break_id);



                                    $this->db->where('break_table.attendance_id', $insert_attenance_id);



                                    $update_break_data = [



                                        "in_time" => $log_data['time'],



                                    ];



                                    $update_break = $this->db->update('break_table', $update_break_data);
                                }
                            }
                        }



                        if ($keys == ($total_device_log - 1)) {



                            if ($log_data['direction'] == 0) {



                                $this->db->where('attendance.id', $insert_attenance_id);



                                $update_atten_data = [



                                    "out" => $log_data['time'],



                                    "updated" => $log_data['log_date'] . " 00:00:00",



                                ];



                                $update_atten = $this->db->update('attendance', $update_atten_data);
                            }
                        }
                    }



                    $this->db->where('device_log.log_date', $user_atten_date);



                    $this->db->where('device_log.user_id', $atten_user_id);



                    $this->db->update('device_log', ["status" => 1]);



                    $result[$user_data['username']][$key] = 1;
                } else {



                    $result[$user_data['username']][$key] = 0;
                }
            }



            return $result;
        } else {



            return false;
        }
    }







    public function get_user_name()
    {



        $this->db->select($this->table_name . '.id,name');



        $this->db->where($this->table_name . '.status', 1);



        $query = $this->db->get($this->table_name);



        if ($query->num_rows() > 0) {



            return $query->result_array();
        }



        return NULL;
    }







    public function get_user_name_by_id($id)
    {



        $this->db->select($this->table_name . '.id,name');



        $this->db->where($this->table_name . '.status', 1);



        $this->db->where($this->table_name . '.id', $id);



        $query = $this->db->get($this->table_name);



        if ($query->num_rows() > 0) {



            return $query->result_array();
        }



        return NULL;
    }







    public function update_user($data, $id)
    {







        $this->db->where('id', $id);



        if ($this->db->update($this->table_name, $data)) {



            return true;
        }



        return false;
    }







    public function delete_user($id)
    {



        $this->db->where('id', $id);



        if ($this->db->update($this->table_name, $data = array('status' => 0))) {



            return true;
        }



        return false;
    }







    public function add_duplicate_email($input)
    {



        $this->db->select('*');



        $this->db->where('status', 1);



        $this->db->where('email_id', $input);



        $query = $this->db->get('erp_user');



        if ($query->num_rows() >= 1) {



            return $query->result_array();
        }
    }







    public function update_duplicate_email($input, $id)
    {



        $this->db->select('*');



        $this->db->where('status', 1);



        $this->db->where('email_id', $input);



        $this->db->where('id !=', $id);



        $query = $this->db->get('erp_user')->result_array();



        return $query;
    }







    public function get_user_role()
    {



        $this->db->select('*');



        $this->db->where('status', 1);



        $query = $this->db->get('erp_user_roles')->result_array();



        return $query;
    }




    public function get_active_firms()
    {


        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];
        }
        if ($this->user_auth->get_user_role_id != '1')
            $this->db->where_in('erp_manage_firms.firm_id', $frim_id);

        $this->db->select('*');

        $this->db->where('status', 1);

        $query = $this->db->get('erp_manage_firms')->result_array();

        return $query;
    }


    public function get_all_firms()
    {





        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];
        }

        $this->db->where_in('erp_manage_firms.firm_id', $frim_id);









        $this->db->select('*');



        $this->db->where('status', 1);



        $query = $this->db->get('erp_manage_firms')->result_array();



        return $query;
    }







    public function get_all_firms_by_user_id($user_id)
    {











        $this->db->select('erp_manage_firms.firm_id,firm_name,prefix');



        $this->db->join('erp_user_firms', 'erp_user_firms.firm_id=erp_manage_firms.firm_id');



        $this->db->where('erp_user_firms.user_id', $user_id);



        $query = $this->db->get('erp_manage_firms')->result_array();



        return $query;
    }







    public function insert_firm($data)
    {



        if ($this->db->insert('erp_user_firms', $data)) {



            $insert_id = $this->db->insert_id();



            return $insert_id;
        }



        return false;
    }







    public function get_user_firms($id)
    {



        $this->db->select('*');



        $this->db->where('user_id', $id);



        $query = $this->db->get('erp_user_firms')->result_array();



        return $query;
    }







    public function delete_user_firm($id)
    {



        $this->db->where('user_id', $id);



        if ($this->db->delete('erp_user_firms')) {



            return true;
        }



        return false;
    }







    public function add_duplicate_user($input)
    {



        $this->db->select('*');



        $this->db->where('status', 1);



        $this->db->where('username', $input);



        $query = $this->db->get('erp_user');



        if ($query->num_rows() >= 1) {



            return $query->result_array();
        }
    }







    public function update_duplicate_user($input, $id)
    {



        $this->db->select('*');



        $this->db->where('status', 1);



        $this->db->where('username', $input);



        $this->db->where('id !=', $id);



        $query = $this->db->get('erp_user')->result_array();



        return $query;
    }



    function _get_datatables_query()
    {

        //Join Table

        $this->db->join($this->joinTable3, 'f.firm_id=uf.firm_id');

        $this->db->join($this->joinTable2, 'r.id=u.role', 'left');

        $this->db->where('u.status', 1);

        $firms = $this->user_auth->get_user_firms();

        $frim_id = array();

        foreach ($firms as $value) {

            $frim_id[] = $value['firm_id'];
        }

        $new = implode(" , ", $frim_id);

        $this->db->where_in('f.firm_id', $frim_id);

        $this->db->from($this->primaryTable);

        $i = 0;

        foreach ($this->column_search as $item) { // loop column

            if ($_POST['search']['value']) { // if datatable send POST for search

                if ($i === 0) { // first loop

                    $like = "" . $item . " LIKE '%" . $_POST['search']['value'] . "%'";

                    // $this->db->like($item, $_POST['search']['value']);

                } else {

                    //   $query = $this->db->or_like($item, $_POST['search']['value']);

                    $like .= " OR " . $item . " LIKE '%" . $_POST['search']['value'] . "%'";
                }
            }

            $i++;
        }

        if ($like) {

            $where = "f.firm_id IN (" . $new . ") AND (" . $like . ")";

            $this->db->where($where);
        }

        if (isset($_POST['order'])) { // here order processing

            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {

            $order = $this->order;

            $this->db->order_by(key($order), $order[key($order)]);
        }
    }



    function get_datatables()
    {

        $this->db->select($this->selectColumn);

        $this->_get_datatables_query();

        $firms = $this->user_auth->get_user_firms();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();
    }











    /*function _get_datatables_query() {







        //Join Table



//        $this->db->join($this->joinTable3, 'f.firm_id=uf.firm_id');







        $this->db->join($this->joinTable2, 'r.id=u.role', 'left');







        $this->db->where('u.status', 1);







//        $firms = $this->user_auth->get_user_firms();



//



//        $frim_id = array();



//



//        foreach ($firms as $value) {



//



//            $frim_id[] = $value['firm_id'];



//        }



//



//        $this->db->where_in('f.firm_id', $frim_id);







        $this->db->from($this->primaryTable);



        $i = 0;



        foreach ($this->column_search as $item) { // loop column



            if ($_POST['search']['value']) { // if datatable send POST for search



                if ($i === 0) { // first loop



                    $this->db->like($item, $_POST['search']['value']);



                } else {







                    $this->db->or_like($item, $_POST['search']['value']);



                }



            }







            $i++;



        }







        if (isset($_POST['order'])) { // here order processing



            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);



        } else if (isset($this->order)) {







            $order = $this->order;







            $this->db->order_by(key($order), $order[key($order)]);



        }



    }*/







    public function count_all()
    {



        $this->db->from($this->primaryTable);







        return $this->db->count_all_results();
    }







    public function count_filtered()
    {



        $this->_get_datatables_query();







        $query = $this->db->get();







        return $query->num_rows();
    }
}
