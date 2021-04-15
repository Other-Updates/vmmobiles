<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



/**

 * Users_model

 *

 * This model represents Shift. It operates the following tables:

 * - shift,

 *

 * @package	Payroll

 * @author	Vathsala

 */ 

 

class Shift_model extends CI_Model{



    private $table_name	= 'shift';

	

	private $associate = 'shift_split'	;



	function __construct()

	{

		parent::__construct();

 		

		$ci =& get_instance();

	} 

	

	/**

	 * Get all Shifts

	 *

	 * @return	array

	 */ 

	function get_all_shifts()

	{

		

		$this->db->select($this->associate.'.*');

		$this->db->select($this->table_name.'.*');

		$this->db->where($this->associate.'.type', 'regular');

		$this->db->join($this->associate,$this->associate.'.shift_id='.$this->table_name.'.id','left');

		$this->db->order_by("name", "asc");

		$query = $this->db->get($this->table_name);

		if ($query->num_rows() >= 1) {

		

			return $query->result_array();

			

		}

		return false;

	}

	/**

	 * Get all Shifts except id

	 *

	 * @return	array

	 */ 

	function get_all_shifts_except($id)

	{

		

		$this->db->select($this->associate.'.*');

		$this->db->select($this->table_name.'.*');

		$this->db->where($this->associate.'.type', 'regular');

		$this->db->where($this->table_name.'.id !=',$id);

		$this->db->join($this->associate,$this->associate.'.shift_id='.$this->table_name.'.id','left');

		$query = $this->db->get($this->table_name);

		if ($query->num_rows() >= 1) {

		

			return $query->result_array();

			

		}

		return false;

	}

	/**

	 * Get all Shifts

	 *

	 * @return	array

	 */ 

	function get_all_shifts_by_limit($limit,$start,$filter=null)

	{

		$this->db->limit($limit, $start);

		//$this->db->distinct($this->table_name.'.id');

		$this->db->select($this->associate.'.*');

		$this->db->select($this->table_name.'.*');

		$this->db->where($this->associate.'.type', 'regular');

		if(isset($filter["sort"])&& !empty($filter["sort"]))

		{

			if($filter["sort"]=="id" || $filter["sort"]=="name")

				$this->db->order_by('shift.'.$filter["sort"], $filter["order"]);

			else

				$this->db->order_by('shift_split.'.$filter["sort"], $filter["order"]);

		}

		$this->db->join($this->associate,$this->associate.'.shift_id='.$this->table_name.'.id','left');

		$query = $this->db->get($this->table_name);

		if ($query->num_rows() >= 1) {

		

			return $query->result_array();

			

		}

		return false;

	}

	

	/**

	 * Get Shift by id 

	 *

	 * @param	int

	 * @return	array

	 */

	function get_shift_by_id($shift_id)

	{

		$this->db->select($this->associate.'.*');

		$this->db->select($this->table_name.'.*');

		

		$this->db->join($this->associate,$this->associate.'.shift_id='.$this->table_name.'.id','left');

		$this->db->where($this->table_name.'.id', $shift_id);

		$query = $this->db->get($this->table_name);

		

		if ($query->num_rows() >= 1) {

			return $query->result_array();

		}

		return false;

	}



	

	/**

	 * Insert new Shift

	 *

	 * @param	array

	 * @param	bool

	 * @return	id

	 */

	function insert_shift($data)

	{

		if ($this->db->insert($this->table_name, $data)) {

		

			$shift_id = $this->db->insert_id();

			

			return $shift_id;

		}

		return false;

	}

	

	/**

	 * Update  designation

	 *

	 * @param	array

	 * @param	int

	 * @return	bool

	 */

	function update_shift($shift_id, $data)

	{

		$this->db->where('id', $shift_id);

		

		if ($this->db->update($this->table_name, $data)) {

			

			return true;

		}

		return false;

	}

	

	/**

	 * Delete shift

	 *

	 * @param	int

	 * @return	bool

	 */

	function delete_shift($shift_id)

	{

		$this->db->where('id', $shift_id);

		

		$this->db->delete($this->table_name);

		

		if ($this->db->affected_rows() > 0) {

		

			return true;

			

		}

		return false;

	}

		/**

	 * Delete shift details from shift_split table

	 *

	 * @param	int

	 * @return	bool

	 */

	function delete_shift_details_by_shift_id($shift_id)

	{

		$this->db->where($this->associate.'.shift_id', $shift_id);

		

		$this->db->delete($this->associate);

		

		if ($this->db->affected_rows() > 0) {

		

			return true;

			

		}

		return false;

	}

	

	/**

	 * Insert  Shift details to shift_split table

	 *

	 * @param	array

	 * @param	bool

	 * @return	id

	 */

	function insert_shift_details($data)

	{
		$this->db->order_by('id','desc');
		$shift_data=$this->db->get('shift_split')->result_array();
		if(count($shift_data)>0)
		{
			$id=$shift_data[0]['id']+1;
		}
		else
		{
			$id=1;
		}
		$data['id']=$id;

		if ($this->db->insert($this->associate, $data)) {

		

			$shift_id = $this->db->insert_id();

			

			return $shift_id;

		}

		return false;

	}

	/**

		*Get shift count*/

	function get_shift_count()

	{

		//$this->db->distinct($this->table_name.'.id');

		$this->db->select('count(DISTINCT '.$this->table_name.'.id) as count');

		$this->db->where($this->associate.'.type', 'regular');

		$this->db->join($this->associate,$this->associate.'.shift_id='.$this->table_name.'.id','left');

		

		$query = $this->db->get($this->table_name);

		

		if ($query->num_rows() >= 1) {

			return $query->result_array();

		}

		return false;

	}

	/*get shift details by shift id*/

	function get_shift_details_by_shift_id($shift_id)

	{

		$this->db->where('shift_id',$shift_id);

		

		$query = $this->db->get($this->associate);

		

		if ($query->num_rows() >= 1) {

			return $query->result_array();

		}

		return false;

	}

	/*get shift details regular time by shift id*/

	function get_regular_and_lunch_by_shift_id($shift_id)

	{

		$this->db->where('shift_id',$shift_id);

		

		$this->db->where('type !=','overtimestart');

		

		$this->db->where('type !=','break');

		

		$query = $this->db->get($this->associate);

		

		if ($query->num_rows() >= 1) {

			return $query->result_array();

		}

		return false;

	}

	function check_shift_exist($shift_name,$shift_id=NULL)

	{

		$this->db->select('id');

		

		$this->db->where('LOWER(name)',trim(strtolower($shift_name)));

		

		if(isset($shift_id)&& $shift_id!=NULL)

		

			$this->db->where('id !=',$shift_id);

		

		$query = $this->db->get($this->table_name);

		

		if ($query->num_rows() >= 1) {

		

			return $query->result_array();

			

		}

		return false;

	

	}

	/*get shift regular time by shift id*/

	function get_shift_regular_time_by_shift_id($shift_id)

	{

		$this->db->where('shift_id',$shift_id);

		

		$this->db->where('type','regular');

		

		$query = $this->db->get($this->associate);

		

		if ($query->num_rows() >= 1) {

			return $query->result_array();

		}

		return false;

	}

	

}