<?php
	
	function HrdMenu($type)
 	{
 		$sql = "SELECT file_name FROM tbl_upload_hrd WHERE type = ".$type." AND published = 0 ORDER BY file_name DESC LIMIT 1";
			$que = $this->db->query($sql);
			$hsl = $que->row_array();

			return $hsl;
 	}


?>