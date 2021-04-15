<?php
	echo $this->config->item('base_url').'/db_back_up';
	$this->load->dbutil();
	$this->load->database();
	$prefs = array(     
		'format'      => 'zip',             
		'filename'    => 'my_db_backup.zip'
	  );
	
	$backup =& $this->dbutil->backup($prefs); 
	
	$db_name = 'backup-on-'. date("Y-m-d-H-i-s") .'.zip';
	$save = './db_back_up/'.$db_name;
	
	$this->load->helper('file');
	write_file($save, $backup); 
	
	$this->load->helper('download');
	force_download($db_name, $backup); 
?>