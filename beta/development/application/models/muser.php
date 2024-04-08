<?php 

/**
* 
*/
class Muser extends CI_model
{
	
	function __construct()
	{
		# code...
	}

	function getUser(){
		$this->db->select('*');
		$this->db->from('tbl_loginuser');
		$this->db->join('tbl_role', 'tbl_loginuser.role_id = tbl_role.id');

		$query = $this->db->get();
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $data) {
					# code...
					$hasilUser[] = $data;
				}
				# code...
				return $hasilUser;
			}
	}

	function delUser($id_user){
		$this->db->where('tbl_loginuser.id', $id_user);
		$this->db->delete(tbl_loginuser);
	}
}