<?php if(! defined('BASEPATH')) exit('No direct script access allowed');
	/**
	*
	*/
	class M_purchasing extends CI_Model
	{
		var $order = array('pr.id' => 'DESC');
    	var $column_order = array('pr.id','pr.date_created','lg.nickname','pr_vr.items','age','pr_vr.mou','pr.status',NULL,'potong_saldo',NULL);
    	var $column_search = array('pr.id','pr.date_created','lg.nickname','pr_vr.items','pr_vr.qty','pr_vr.mou','pr.divisi','pr.alasan_pembelian', 'pr.status');

		public function __construct()
		{
			parent::__construct();
			$this->load->model('Ftp_model', 'mftp');
			$this->load->model('Notification_model', 'notif');
			$this->load->model('Data_model', 'mdata');
			$this->load->model('M_tools', 'mtools');
			$this->load->model('M_point', 'mpoint');
		}

		public function _get_datatables_query($cons = '')
	    {
   			$user   = $_SESSION['myuser'];
			$pos_id = $user['position_id'];
			$kar_id = $user['karyawan_id'];
			$cbg    = $user['cabang'];
			$div    = $user['position'];
      		$div    = substr($div, -3);

 			if($pos_id == '88')
            {
                $post_in = "('23', '24','25','26','28','65',73,'87','88','96')";
            }
            elseif($pos_id == '89')
            {
                $post_in = "('30','66','86','89')";
            }
            elseif($pos_id =='90')
            {
                $post_in ="('30','68','86','90')";
            }
            elseif($pos_id =='91')
            {
                $post_in ="('29','71','74','91', '100', '103')";
            }
            elseif($pos_id =='93')
            {
                $post_in ="('27','67','84','93')";
            }
            elseif($pos_id =='100')
            {
                $post_in ="('100')";
            }
            elseif($pos_id =='13')
            {
                $post_in ="('13','102','127')"; // baru pipit 13012020
            }
            elseif($pos_id =='153')
            {
                $post_in ="('102')"; // baru pipit 13012020
            }elseif($pos_id =='333')
            {
                $post_in ="('333')"; // baru pipit 13012020
            }

            if($cons == 'all')
      		{
      			$status = "";
      		}elseif($cons == 'FINISHED') {
      			$status = " AND (pr.status = 'FINISHED' OR pr.status = 'CANCELED') ";
      		}elseif($cons == '1') {
      			$status = " AND (pr.ptg_saldo = '1' AND pr.status = 'FINISHED') ";
      		}elseif($cons == '0') {
      			$status = " AND (pr.ptg_saldo = '0') ";
      		}else {
      			$status = " AND pr.status != 'FINISHED' AND pr.status !='CANCELED'";
      		}

      		/*if($cons == 'all')
      		{
      			$status = "";
      		}elseif($cons == '101') {
      			$status = " AND (pr.status = 101 OR pr.status = 119) ";
      		}else {
      			$status = " AND pr.status != 101 AND pr.status !=119";
      		}*/

      		$sql = "SELECT IF(pr.ptg_saldo='1', 'YES', 'NO') AS potong_saldo,pr.audit,DATEDIFF(NOW(),pr.date_created) as age ,pr.alasan_pembelian,pr.status_finish, pr.id, pr.date_created, pr.date_deadline, pr.date_closed, pr.status, pr.level_approval, pr.sales_id, 
					pr.divisi, lg.nickname, kr.cabang, kr.position_id, ps.position,
					pr_vr.vendors, pr_vr.items, pr_vr.qty, pr_vr.mou,pr.ptg_saldo
					FROM tbl_purchasing pr
					LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = pr.sales_id
					LEFT JOIN tbl_karyawan kr ON kr.id = pr.sales_id
					LEFT JOIN tbl_position ps ON ps.id = kr.position_id
					LEFT JOIN tbl_pr_overto ov ON ov.pr_id = pr.id
					LEFT JOIN tbl_karyawan ovkr ON ovkr.id = ov.overto
					LEFT JOIN tbl_pr_contributor co ON co.pr_id = pr.id
					LEFT JOIN (
						SELECT pr_id, GROUP_CONCAT(vendor SEPARATOR '@') as vendors,
						GROUP_CONCAT(items SEPARATOR '@') as items,
						GROUP_CONCAT(qty SEPARATOR '@') as qty,
						GROUP_CONCAT(mou SEPARATOR '@') as mou
						FROM tbl_pr_vendor
						GROUP BY pr_id
					) pr_vr ON pr_vr.pr_id = pr.id
					WHERE pr.published = '1' ".$status." ";

				/*$sql = "SELECT DATEDIFF(NOW(),pr.date_created) as age ,pr.alasan_pembelian,pr.status_finish, pr.id, pr.date_created, pr.date_deadline, pr.date_closed, pr.status, pr.level_approval, pr.sales_id, 
						pr.divisi, lg.nickname, ovl.nickname as ov_name, kr.cabang, kr.position_id, ps.position,
						pr_vr.vendors, pr_vr.items, pr_vr.qty, pr_vr.mou
						FROM tbl_purchasing pr
						LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = pr.sales_id
						LEFT JOIN tbl_karyawan kr ON kr.id = pr.sales_id
						LEFT JOIN tbl_position ps ON ps.id = kr.position_id
						LEFT JOIN tbl_pr_overto ov ON ov.pr_id = pr.id
						LEFT JOIN tbl_karyawan ovkr ON ovkr.id = ov.overto
						LEFT JOIN tbl_loginuser ovl ON ovl.karyawan_id = pr.status
						LEFT JOIN tbl_pr_contributor co ON co.pr_id = pr.id
						LEFT JOIN (
							SELECT pr_id, GROUP_CONCAT(vendor SEPARATOR '@') as vendors,
							GROUP_CONCAT(items SEPARATOR '@') as items,
							GROUP_CONCAT(qty SEPARATOR '@') as qty,
							GROUP_CONCAT(mou SEPARATOR '@') as mou
							FROM tbl_pr_vendor
							GROUP BY pr_id
						) pr_vr ON pr_vr.pr_id = pr.id
						WHERE pr.published = '1' ".$status." ";*/

		 			if(in_array($pos_id, array('1', '2', '77', '14', '3', '18', '5', '6', '8', '76','139','225','9','332','335'))) 
		 			{
						$sql .= " ";
					}
					elseif(in_array($pos_id, array('55', '56', '57', '58', '59', '95','60', '62', '75','134'))) // WL 42182
					{
						$sql .= " AND (kr.cabang = '$cbg' OR ov.overto = '$kar_id' OR ovkr.cabang = '$cbg' OR co.contributor = $kar_id) ";
					}
					elseif (in_array($pos_id, array('88', '93'))) {
						$sql .= " AND (kr.position_id IN ".$post_in." OR ov.overto = '$kar_id' OR pr.sales_id = '$kar_id' OR pr.divisi = '$div' OR co.contributor = $kar_id) ";
					}elseif (in_array($pos_id, array('89'))) 
					{
						$sql .= " AND (kr.position_id IN ".$post_in."  OR ov.overto = '$kar_id' OR pr.sales_id = '$kar_id' OR pr.divisi IN ('DIR','HORECA','DRE') OR co.contributor = $kar_id) ";
					}
					elseif (in_array($pos_id, array('90', '92'))) 
					{
						$sql .= " AND (kr.position_id IN ".$post_in." OR kr.position_id IN ('29', '90') OR ov.overto = '$kar_id' OR pr.sales_id = '$kar_id' OR pr.divisi IN ('DCE', 'DGC','DGM') OR co.contributor = $kar_id) ";
					}
					elseif (in_array($pos_id, array('91', '100'))) 
					{
						$sql .= " AND (kr.position_id IN ".$post_in." OR ov.overto = '$kar_id' OR pr.sales_id = '$kar_id' OR pr.divisi IN ('DHE', 'DWT','DPP') OR co.contributor = $kar_id) ";				
					}elseif (in_array($pos_id, array('333'))) 
					{
						$sql .= " AND (kr.position_id IN ".$post_in." OR ov.overto = '$kar_id' OR pr.sales_id = '$kar_id' OR pr.divisi IN ('DPE') OR co.contributor = $kar_id) ";				
					}elseif($pos_id == '4') 
					{
						$sql .= " AND (kr.position_id = '4' OR ovkr.position_id = '4' OR co.contributor = $kar_id OR pr.source_pengadaan ='1' ) ";
					}
					elseif($pos_id == '13') 
					{
						/*$sql .= " AND ((kr.position_id IN ('13', '102')) OR (ovkr.position_id IN ('13', '102')) OR co.contributor = $kar_id) ";*/
						$sql .= " AND ((kr.position_id IN ".$post_in.") OR (ovkr.position_id IN ('13', '102','127')) OR co.contributor = $kar_id OR pr.sales_id = '$kar_id') "; // baru pipit 13012020
					}elseif($pos_id == '153') 
					{
						/*$sql .= " AND ((kr.position_id IN ('13', '102')) OR (ovkr.position_id IN ('13', '102')) OR co.contributor = $kar_id) ";*/
						$sql .= " AND ((kr.position_id IN ".$post_in.") OR (ovkr.position_id IN ('102')) OR co.contributor = $kar_id OR pr.sales_id = '$kar_id') "; // baru pipit 13012020
					}
					else 
					{
						$sql .= " AND (pr.sales_id = '$kar_id' OR ov.overto = '$kar_id' OR co.contributor = $kar_id) ";
					}

					// print_R($sql);die;

	        $i = 0;
	     
	        foreach ($this->column_search as $item) // loop column
	        { 
	            if($_POST['search']['value']) // if datatable send POST for search
	            {
	                if($i===0) // first loop
	                {

	                    $sql .= " AND (".$item." LIKE '%".$_POST['search']['value']."%'";
	                }
	                else
	                {                   
	                    $sql .= " OR ".$item." LIKE '%".$_POST['search']['value']."%'";
	                }
	 
	                if(count($this->column_search) - 1 == $i) 
	                   
	                    $sql .= " ) ";
	            }
	            $i++;
	        }

	        $sql .= " GROUP BY pr.id";

	        if(isset($_POST['order'])) // here order processing
	        {
	           
	            // if($cons == 'Deal') {
	            //     $column_order = array(null,'cr.date_closed','cr.id','cr.date_created','cr.perusahaan', null, 'cr.progress', 'cr.deal_value', 'cr.last_followup', null);
	            // }
	            $sql .= " ORDER BY ".$this->column_order[$_POST['order']['0']['column']]." ".$_POST['order']['0']['dir']." ";
	        }
	        else if(isset($this->order))
	        {
	            $order = $this->order;

	            if($cons != '') {
	                $order = array('pr.id' => 'DESC');
	            }

	            $sql .= " ORDER BY ".key($order)." ".$order[key($order)]." ";
	        }

	        return $sql;
	        
	    }


		function get_datatables($cons)
	    {
		        $sql = $this->_get_datatables_query($cons);
		        if($_POST['length'] != -1)
		        $sql .= " LIMIT ".$_POST['start'].",".$_POST['length'];
		        $query = $this->db->query($sql);    
		        return $query->result_array();
	    }

	    	function count_filtered($cons)
	    {
	        $sql = $this->_get_datatables_query($cons);
	        $query = $this->db->query($sql);
	        return $query->num_rows();
	    }
	 
	    public function count_all($cons)
	    {
	        $sql = $this->_get_datatables_query($cons);
	        $query = $this->db->query($sql);
	        return $query->num_rows();
	    }


		public function loadReceived($id)
		{
			$sql = "SELECT r.*,lg.nickname FROM tbl_pr_received r
					LEFT JOIN tbl_pr_vendor v ON r.item_id = v.id 
					LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = r.user_received
					WHERE r.item_id='$id'";
			$res = $this->db->query($sql)->result_array();
			return $res;
		}

		public function total ($id)
		{
			$sql = "SELECT SUM(qty_received) as total FROM tbl_pr_received
                    WHERE item_id='$id'";
            $res = $this->db->query($sql)->row_array();

            return $res;
		}


		
        // Wishlist ID : 41729
        public function getkendaraan($value)
        {
        	$sql ="SELECT * FROM tbl_kar_kendaraan WHERE kepemilikan = '$value'";
        	$res= $this->db->query($sql)->result_array();

        	return $res;
        }

        // Wishlist ID : 41729
        public function getketerangantools($id)
        {
        	$sql ="SELECT * FROM tbl_kar_kendaraan knd
        		   LEFT JOIN tbl_kar_kendaraan_jenis jns ON jns.id = knd.merk
        		   LEFT JOIN tbl_tools tl ON tl.id = knd.tools_id 
        		   LEFT JOIN tbl_tools_holder hld ON hld.tool_id = tl.id
        		   LEFT JOIN tbl_loginuser lgn ON lgn.karyawan_id = hld.user_holder
        		   WHERE knd.id = '$id'";
        	$res= $this->db->query($sql)->row_array();

        	return $res;
        }


		public function loadItemNotes($item_id)
		{
			$sql = "SELECT no.*, lg.nickname FROM tbl_pr_notes no
					LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = no.user
					WHERE item_id = $item_id GROUP BY id ASC";
			return $this->db->query($sql)->result_array();			
		}

		public function getReceiver()
        {
            $sql = "SELECT nama,id FROM tbl_karyawan WHERE position_id='18' OR position_id='5' OR position_id='75' 
            		OR position_id='60' OR position_id='62' AND published='1' AND id !='101' ORDER BY nama ASC";
            $res = $this->db->query($sql)->result_array();

            return $res;
        }


		public function getGroupLink($id)
        {
            $sql = "SELECT li.*, lm.nama_modul FROM tbl_link li
                    LEFT JOIN tbl_log_modul lm ON lm.id = li.link_to_modul
                    WHERE li.link_from_modul = '5' AND li.link_from_id = '$id' GROUP BY li.link_to_modul ASC";
            $res = $this->db->query($sql)->result_array();

            return $res;    

        }

        public function getSPSJobID($spsid)
        {
        	$sql = "SELECT job_id FROM tbl_sps WHERE id = $spsid";
        	return $this->db->query($sql)->row_array();
        }

        public function getLink($id)
        {
            $sql = "SELECT IF(sps.id = 'NULL', '', sps.ship_to) as ship_to, li.link_to_id, li.link_to_modul as link_modul, sps.id FROM 
            		tbl_link li 
                	LEFT JOIN tbl_purchasing crm ON (crm.id = li.link_from_id AND li.link_from_modul = '5') 
                	LEFT JOIN tbl_import sps ON (sps.id = li.link_to_id AND li.link_to_modul = '6') 
                	WHERE li.link_from_id = $id";
            $res = $this->db->query($sql)->result_array();
            return $res;    
        }


		public function getMOU()
		{
			$sql = "SELECT id, mou FROM tbl_mou GROUP BY mou ASC";
			$res = $this->db->query($sql)->result_array();
			return $res;
		}

		public function getCRM()
		{
			$sql = "SELECT b.id, IF (b.customer_type = 1, cs.pic, ncs.pic) AS pic 
					FROM tbl_crm as b 
                    LEFT JOIN tbl_customer cs ON (b.customer_id = cs.id AND b.customer_type = '1')
                    LEFT JOIN tbl_non_customer ncs ON (b.customer_id = ncs.id AND b.customer_type = '0') 
                    GROUP BY b.id DESC";
            return $this->db->query($sql)->result_array();        
		}

		public function getKaryawan()
		{
			$sql = "SELECT nama, id FROM tbl_karyawan WHERE published = '1' AND id != '101'";

			if($this->input->post('data_id')) {
				$source_pengadaan = $this->input->post('data_id');
				$sql .= " AND position_id='4'";

			}

			$sql .= " ORDER BY nama ASC";
			
			$res = $this->db->query($sql)->result_array();

			return $res;
		}

		public function getOverTo()
		{
			if($this->input->post())
			{
				$id = $this->input->post('data_id');

				$sql = "SELECT position FROM tbl_karyawan kr
						LEFT JOIN tbl_position ps ON ps.id = kr.position_id
						WHERE kr.id = '$id'";

				$query 		= $this->db->query($sql);
				$getOverTo 	= $query->row_array();

				return $getOverTo;
			}

		}

		public function getPR()
		{
			$kar_id 	= $_SESSION['myuser']['karyawan_id'];
			$sql 		= "SELECT * FROM tbl_purchasing WHERE sales_id = '$kar_id' ORDER BY id DESC LIMIT 1";
			$row_array 	= $this->db->query($sql)->row_array();

			return $row_array;
		}

		// public function loadItems($id) 
		// {
		// 	$sql = "SELECT ve.*,lg.nickname as nama ,lgn.nickname, lg1.nickname as name_finish,lg2.nickname as user_received,lg3.nickname as 
		// 			user_verif,ve.user_verified,lg4.nickname as nama_approved,lg5.nickname as nama_holder,lg6.nickname as nama_user_transfer,lgn7.nickname as nama_user,kend.plat_nomer FROM tbl_pr_vendor ve
		// 			LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = ve.holder
		// 			LEFT JOIN tbl_loginuser lgn ON lgn.karyawan_id = ve.user_approved
		// 			LEFT JOIN tbl_loginuser lg1 On lg1.karyawan_id = ve.user_purchaser
		// 			LEFT JOIN tbl_loginuser lg2 ON lg2.karyawan_id = ve.user_receive
		// 			LEFT JOIN tbl_loginuser lg3 ON lg3.karyawan_id = ve.user_verified
		// 			LEFT JOIN tbl_loginuser lg4 ON lg4.karyawan_id = ve.approved_item
		// 			LEFT JOIN tbl_loginuser lg5 ON lg5.karyawan_id = ve.holder
		// 			LEFT JOIN tbl_loginuser lg6 ON lg6.karyawan_id = ve.user_transfer
		// 			LEFT JOIN tbl_record_kendaraan_perusahaan rec ON rec.vendor_id = ve.id
		// 			LEFT JOIN tbl_kar_kendaraan kend ON kend.id = rec.kendaraan_id
		// 			LEFT JOIN tbl_loginuser lgn7 ON lgn7.karyawan_id = rec.user
		// 			WHERE ve.published ='0' AND ve.pr_id = $id";
		// 	$res = $this->db->query($sql)->result_array();

		// 	// print_R($res);die;
		
		// 	return $res;
		// }

		public function loadItems($id) 
		{	


			$sql = "SELECT ve.id as vendor_id,rec.id as id_record,kend.id as id_kendaraan,ve.*,lg.nickname as nama ,lgn.nickname, lg1.nickname as name_finish,lg2.nickname as user_received,lg3.nickname as 
					user_verif,ve.user_verified,lg4.nickname as nama_approved,lg5.nickname as nama_holder,lg6.nickname as nama_user_transfer,lgn7.nickname as nama_user,kend.plat_nomer,lgg.nickname as nama_receiver FROM tbl_pr_vendor ve
					LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = ve.holder
					LEFT JOIN tbl_loginuser lgn ON lgn.karyawan_id = ve.user_approved
					LEFT JOIN tbl_loginuser lg1 On lg1.karyawan_id = ve.user_purchaser
					LEFT JOIN tbl_loginuser lg2 ON lg2.karyawan_id = ve.user_receive
					LEFT JOIN tbl_loginuser lg3 ON lg3.karyawan_id = ve.user_verified
					LEFT JOIN tbl_loginuser lg4 ON lg4.karyawan_id = ve.approved_item
					LEFT JOIN tbl_loginuser lg5 ON lg5.karyawan_id = ve.holder
					LEFT JOIN tbl_loginuser lg6 ON lg6.karyawan_id = ve.user_transfer
					LEFT JOIN tbl_record_kendaraan_perusahaan rec ON rec.vendor_id = ve.id
					LEFT JOIN tbl_kar_kendaraan kend ON kend.id = rec.kendaraan_id
					LEFT JOIN tbl_loginuser lgn7 ON lgn7.karyawan_id = rec.user
					LEFT JOIN tbl_loginuser lgg ON lgg.karyawan_id= ve.receiver
					WHERE ve.published ='0' AND ve.pr_id = 
					'$id' GROUP BY ve.id";
			$res = $this->db->query($sql)->result_array();

		
			return $res;
		}


		 public function getReportbensin($id)
	    {
	      $sql ="SELECT pr.*,lgn.nickname FROM tbl_record_kendaraan_perusahaan pr
	             LEFT JOIN tbl_kar_kendaraan kend ON kend.id = pr.kendaraan_id
	             LEFT JOIN tbl_loginuser lgn ON lgn.karyawan_id = pr.user
	             WHERE pr.kendaraan_id='$id' GROUP BY pr.id ORDER BY pr.date_created ASC ";
	      $res = $this->db->query($sql)->result_array();

	      return $res;
	    }


		public function getItem($id)
		{

			$sql = "SELECT ve.*, lg.nickname FROM tbl_pr_vendor ve
					LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = ve.user_approved
					WHERE ve.id = $id AND ve.published='0'";
			$res = $this->db->query($sql)->row_array();
			return $res;


		}

		public function getFiles($pr_id, $log_id, $type)
		{
			$sql = "SELECT up.*, lg.nickname FROM tbl_upload_pr up
					LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = up.uploader
					WHERE pr_id = '$pr_id' AND sub_id = '$log_id' AND up.type= '$type' GROUP BY up.id DESC";
			$res = $this->db->query($sql)->result_array();
			return $res;
		}


		
		public function DetailsPR($id)
		{
			$sql = "SELECT pr.modul_link,pr.link_id,pr.audit,pr.date_created,pr.id, pr.random_value, pr.sales_id, pr.divisi, pr.jenis,pr.alasan_pembelian, pr.biaya_piutang, 
					pr.ptg_omset, pr.date_created, pr.date_deadline, pr.date_closed,pr.status, 
					lg.nickname,lg.role_id,stl.nickname as name , lgn.nickname as nama, ps.position,pr.level_approval,pr.published,
					pr.reminder_three_days,pr.source_pengadaan,pr.last_update,pr.status_finish,pr.komoditi,
					pr.file_oem, pr.purchaser,
					kr.cabang, kr.position_id, cont.cont_name,stlgn.nickname as name_purchaser FROM tbl_purchasing pr
					LEFT JOIN tbl_loginuser lgn ON lgn.karyawan_id = pr.receiver
					LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = pr.sales_id
					LEFT JOIN tbl_karyawan kr ON kr.id = pr.sales_id
					LEFT JOIN tbl_position ps ON ps.id = kr.position_id
					LEFT JOIN tbl_loginuser stl ON stl.karyawan_id = pr.receiver
					LEFT JOIN tbl_loginuser stlgn ON stlgn.karyawan_id = pr.purchaser 
					LEFT JOIN (SELECT cr.pr_id, GROUP_CONCAT(lg.nickname SEPARATOR '; ') as cont_name
					FROM tbl_pr_contributor cr
					LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = cr.contributor
					GROUP BY cr.pr_id) cont ON cont.pr_id = pr.id
					WHERE pr.id = '$id' AND pr.published = '1'";

			/*$sql = "SELECT pr.*, lg.nickname,lg.role_id,stl.nickname as name , lgn.nickname as nama, ps.position, kr.cabang, kr.position_id, 
					stlg.nickname as ov_name, cont.cont_name,stlgn.nickname as name_purchaser FROM tbl_purchasing pr
					LEFT JOIN tbl_loginuser lgn ON lgn.karyawan_id = pr.receiver
					LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = pr.sales_id
					LEFT JOIN tbl_karyawan kr ON kr.id = pr.sales_id
					LEFT JOIN tbl_position ps ON ps.id = kr.position_id
					LEFT JOIN tbl_loginuser stl ON stl.karyawan_id = pr.receiver
					LEFT JOIN tbl_loginuser stlg ON stlg.karyawan_id = pr.status 
					LEFT JOIN tbl_loginuser stlgn ON stlgn.karyawan_id = pr.purchaser 
					LEFT JOIN (SELECT cr.pr_id, GROUP_CONCAT(lg.nickname SEPARATOR '; ') as cont_name
					FROM tbl_pr_contributor cr
					LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = cr.contributor
					GROUP BY cr.pr_id) cont ON cont.pr_id = pr.id
					WHERE pr.id = '$id' AND pr.published = '1'";*/

			$row = $this->db->query($sql)->row_array();

			// print_r($row);die;

			return $row;
		}




		
		public function getKaryawancon($id)
        {	

        	$position_id = $_SESSION['myuser']['position_id'];

        	if(in_array($position_id,array('332','335')))
        	{
        		$sql = "SELECT kr.id, nama, position FROM tbl_karyawan kr
					LEFT JOIN tbl_position ps ON kr.position_id = ps.id
					WHERE kr.position_id IN ('1','2') ORDER BY nama ASC";
				$res  = $this->db->query($sql)->result_array();

        	}elseif($position_id =='2')
        	{
        		$sql = "SELECT id, nama FROM tbl_karyawan 
                    WHERE published = '1' AND id NOT IN (SELECT contributor FROM tbl_pr_contributor WHERE pr_id = $id GROUP BY contributor) AND id != 101  ORDER BY nama ASC";
            	$res = $this->db->query($sql)->result_array();
        	}
        	else
        	{
        		$sql = "SELECT id, nama FROM tbl_karyawan 
                    WHERE published = '1' AND id NOT IN (SELECT contributor FROM tbl_pr_contributor WHERE pr_id = $id GROUP BY contributor) AND id != 101 AND position_id NOT IN ('332','335') ORDER BY nama ASC";
            	$res = $this->db->query($sql)->result_array();
        	}
           
            return $res;
        }

		/*public function __tablePR($cons)
		{

	      		$user = $_SESSION['myuser'];
				$pos_id = $user['position_id'];
				$kar_id = $user['karyawan_id'];
				$cbg = $user['cabang'];
				$div = $user['position'];
	      		$div = substr($div, -3);


	 			if($pos_id == '88')
	            {
	                $post_in = "('23', '24','25','26','28','65',73,'87','88','96')";
	            }
	            elseif($pos_id == '89')
	            {
	                $post_in = "('30','66','86','89')";
	            }
	            elseif($pos_id =='90')
	            {
	                $post_in ="('30','68','86','90')";
	            }
	            elseif($pos_id =='91')
	            {
	                $post_in ="('29','71','74','91', '100', '103')";
	            }
	            elseif($pos_id =='93')
	            {
	                $post_in ="('27','67','84','93')";
	            }
	            elseif($pos_id =='100')
	            {
	                $post_in ="('100')";
	            }
	            elseif($pos_id =='13')
	            {
	                $post_in ="('13','102')";
	            }

	      		if($cons == 'all')
	      		{
	      			$status = "";
	      		}elseif($cons == '101') {
	      			$status = " AND (pr.status = 101 OR pr.status = 119) ";
	      		}else {
	      			$status = " AND pr.status != 101 AND pr.status !=119";
	      		}

				$sql = "SELECT pr.status_finish, pr.id, pr.date_created, pr.date_deadline, pr.date_closed, pr.status, pr.level_approval, pr.sales_id, 
						pr.divisi, lg.nickname, ovl.nickname as ov_name, kr.cabang, kr.position_id, ps.position,
						pr_vr.vendors, pr_vr.items, pr_vr.qty, pr_vr.mou, kr.cabang
						FROM tbl_purchasing pr
						LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = pr.sales_id
						LEFT JOIN tbl_karyawan kr ON kr.id = pr.sales_id
						LEFT JOIN tbl_position ps ON ps.id = kr.position_id
						LEFT JOIN tbl_pr_overto ov ON ov.pr_id = pr.id
						LEFT JOIN tbl_karyawan ovkr ON ovkr.id = ov.overto
						LEFT JOIN tbl_loginuser ovl ON ovl.karyawan_id = pr.status
						LEFT JOIN tbl_pr_contributor co ON co.pr_id = pr.id
						LEFT JOIN (
							SELECT pr_id, GROUP_CONCAT(vendor SEPARATOR '@') as vendors,
							GROUP_CONCAT(items SEPARATOR '@') as items,
							GROUP_CONCAT(qty SEPARATOR '@') as qty,
							GROUP_CONCAT(mou SEPARATOR '@') as mou
							FROM tbl_pr_vendor
							GROUP BY pr_id
						) pr_vr ON pr_vr.pr_id = pr.id
						WHERE pr.published = '1' ".$status." ";

	 			if(in_array($pos_id, array('1', '2', '77', '12', '14', '3', '18', '5', '8', '76'))) 
	 			{
					$sql .= " ";
				}
				elseif(in_array($pos_id, array('55', '56', '57', '58', '59', '95','60', '62', '75'))) 
				{
					$sql .= " AND (kr.cabang = '$cbg' OR ov.overto = '$kar_id' OR ovkr.cabang = '$cbg' OR co.contributor = $kar_id) ";
				}
				elseif (in_array($pos_id, array('88', '89', '93'))) {
					$sql .= " AND (kr.position_id IN ".$post_in." OR ov.overto = '$kar_id' OR pr.sales_id = '$kar_id' OR pr.divisi = '$div' OR co.contributor = $kar_id) ";
				}elseif (in_array($pos_id, array('90', '92'))) 
				{
					$sql .= " AND (kr.position_id IN ".$post_in." OR kr.position_id IN ('29', '90') OR ov.overto = '$kar_id' OR pr.sales_id = '$kar_id' OR pr.divisi IN ('DCE', 'DGC') OR co.contributor = $kar_id) ";
				}
				elseif (in_array($pos_id, array('91', '100'))) 
				{
					$sql .= " AND (kr.position_id IN ".$post_in." OR ov.overto = '$kar_id' OR pr.sales_id = '$kar_id' OR pr.divisi IN ('DHE', 'DWT') OR co.contributor = $kar_id) ";				
				}elseif($pos_id == '4') 
				{
					$sql .= " AND (kr.position_id = '4' OR ovkr.position_id = '4' OR co.contributor = $kar_id OR pr.source_pengadaan ='1' ) ";
				}
				elseif($pos_id == '13') 
				{
					/*$sql .= " AND ((kr.position_id IN ('13', '102')) OR (ovkr.position_id IN ('13', '102')) OR co.contributor = $kar_id) ";*/
					/*$sql .= " AND ((kr.position_id IN ".$post_in.") OR (ovkr.position_id IN ('13', '102')) OR co.contributor = $kar_id OR pr.sales_id = '$kar_id') ";
				}
				else 
				{
					$sql .= " AND (pr.sales_id = '$kar_id' OR ov.overto = '$kar_id' OR co.contributor = $kar_id) ";
				}

				$sql .=" GROUP BY pr.id DESC";

				$res = $this->db->query($sql)->result_array();

				return $res;

		}*/

		/*public function getStatusPR($status, $row)
		{
				$appr = $this->getApproval($row['id']);
				$co = count($appr);
				if(!empty($co)) {
					$arr = $appr['0'];
				}

				$str = '';

				switch ($status) {
					case '0':
						if(empty($appr))
						{
								$str = '<span style="color:#f76935;">Waiting for Leader Approval</span>';
						}
						else
						{
							 if($arr['status_approval'] == '1')
							 {
								 $str = '<span style="color:#428BCA">Waiting for Director Approval</span>';
							 }
						}
						break;
					case '101':
						$str = '<span style="color: #428BCA; background-color: #58f404; border-radius:5px;""><b>&nbsp;FINISHED&nbsp;</b></span>';
					break;
					default:
						$str = '<span style="color: #428BCA"><b>'.$row['ov_name'].'</b></span>';
						break;
				}

				return $str;
		}*/

		/*public function tablePR()
		{
			$user = $_SESSION['myuser'];
			$pos_id = $user['position_id'];
			$kar_id = $user['karyawan_id'];
			$cbg = $user['cabang'];
			$div = $user['position'];
      		$div = substr($div, -3);


 			if($pos_id == '88')
            {
                $post_in = "('23', '24','25','26','28','65',73,'87','88','96')";
            }
            elseif($pos_id == '89')
            {
                $post_in = "('30','66','86','89')";
            }
            elseif($pos_id =='90')
            {
                $post_in ="('30','68','86','90')";
            }
            elseif($pos_id =='91')
            {
                $post_in ="('29','71','74','91', '100', '103')";
            }
            elseif($pos_id =='93')
            {
                $post_in ="('27','67','84','93')";
            }
            elseif($pos_id =='100')
            {
                $post_in ="('100')";
            }
            elseif($pos_id =='13')
            {
                $post_in ="('13','102')";
            }

            $sql = "SELECT pr.*, lg.nickname, ovl.nickname as ov_name, kr.cabang, kr.position_id, ps.position FROM tbl_purchasing pr
					LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = pr.sales_id
					LEFT JOIN tbl_karyawan kr ON kr.id = pr.sales_id
					LEFT JOIN tbl_position ps ON ps.id = kr.position_id
					LEFT JOIN tbl_pr_overto ov ON ov.pr_id = pr.id
					LEFT JOIN tbl_karyawan ovkr ON ovkr.id = ov.overto
					LEFT JOIN tbl_loginuser ovl ON ovl.karyawan_id = pr.status
					LEFT JOIN tbl_pr_contributor co ON co.pr_id = pr.id
					WHERE pr.published = '1'";


 			if(in_array($pos_id, array('1', '2', '77', '12', '14', '3', '18', '5', '8', '76')) AND $kar_id != '236') {
				$sql .= " GROUP BY pr.id DESC";

			}elseif(in_array($pos_id, array('55', '56', '57', '58', '59', '95','60', '62', '75'))) {
				$sql .= " AND (kr.cabang = '$cbg' OR ov.overto = '$kar_id' OR ovkr.cabang = '$cbg' OR co.contributor = $kar_id)
					GROUP BY pr.id DESC";
			}elseif (in_array($pos_id, array('88', '89', '93'))) {
				$sql .= " AND (kr.position_id IN ".$post_in." OR ov.overto = '$kar_id' OR pr.sales_id = '$kar_id' OR pr.divisi = '$div' OR co.contributor = $kar_id) 
					GROUP BY pr.id DESC";
			}elseif (in_array($pos_id, array('90', '92'))) {
				$sql .= " AND (kr.position_id IN ".$post_in." OR kr.position_id IN ('29', '90') OR ov.overto = '$kar_id' OR pr.sales_id = '$kar_id' OR pr.divisi IN ('DCE', 'DGC') OR co.contributor = $kar_id) 
					GROUP BY pr.id DESC";
			}elseif (in_array($pos_id, array('91', '100'))) {
				$sql .= " AND (kr.position_id IN ".$post_in." OR ov.overto = '$kar_id' OR pr.sales_id = '$kar_id' OR pr.divisi IN ('DHE', 'DWT') OR co.contributor = $kar_id) 
					GROUP BY pr.id DESC";				
			}elseif($pos_id == '4') {
				$sql .= " AND (kr.position_id = '4' OR ovkr.position_id = '4' OR co.contributor = $kar_id) 
					GROUP BY pr.id DESC";
			}elseif ($pos_id == '13') {
				$sql .= " AND (kr.position_id IN ".$post_in." OR kr.position_id IN ('13', '102') OR ov.overto = '$kar_id' OR pr.sales_id = '$kar_id' OR co.contributor = $kar_id) 
					GROUP BY pr.id DESC";
			}else {
				$sql .= " AND (pr.sales_id = '$kar_id' OR ov.overto = '$kar_id' OR co.contributor = $kar_id)
					GROUP BY pr.id DESC";
			}

			$res = $this->db->query($sql)->result_array();

			return $res;
		}*/

		public function get_recomendation($id)
		{
			$sql = "SELECT rp.recomend_point FROM tbl_my_point_recomendation rp 
				WHERE rp.modul_id='$id' AND rp.modul = '5'";
			$rec = $this->db->query($sql)->row_array();

			return $rec;
		}

		public function getApproval($id)
		{
			$sql = "SELECT ap.*, lg.nickname FROM tbl_pr_approval ap
					LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = ap.user_approval
					WHERE ap.pr_id = '$id' GROUP BY ap.id ASC";
			$res = $this->db->query($sql)->result_array();

			return $res;
		}

		/*public function getApprovalItem($id)
		{ // baru 20 19
			$sql = "SELECT ap.*, lg.nickname FROM tbl_pr_item_approval ap
					LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = ap.user_approval
					WHERE ap.vendor_id = '$id' GROUP BY ap.id ASC";
			$res = $this->db->query($sql)->result_array();

			return $res;
		}*/

		public function getNextTo($id)
		{
			$sql = "SELECT * FROM tbl_pr_overto WHERE pr_id = '$id'";
			$row = $this->db->query($sql)->row_array();

			return $row;
		}

		public function getLogPR($id)
		{
			$sql = "SELECT lg.*, us.nickname, pos.position, pu.status, pu.sales_id,pu.source_pengadaan,pu.status,pu.status_point, pu.point_pr FROM tbl_pr_log lg
					LEFT JOIN tbl_loginuser us ON us.karyawan_id = lg.id_operator
					LEFT JOIN tbl_karyawan as kr ON kr.id = lg.id_operator
					LEFT JOIN tbl_position pos ON pos.id = kr.position_id
					LEFT JOIN tbl_purchasing pu ON pu.id = lg.pr_id
					WHERE lg.pr_id = '$id' GROUP BY lg.id DESC";
			$res = $this->db->query($sql)->result_array();
			$numrows = $this->db->query($sql)->num_rows();

			$arr = array(
				'res' => $res,
				'numrows'	=> $numrows,
				);

			return $arr;
		}

		public function getLogPRcetak($id)
		{
			$sql = "SELECT lg.*, us.nickname, pos.position, pu.status, pu.sales_id,pu.source_pengadaan FROM tbl_pr_log lg
					LEFT JOIN tbl_loginuser us ON us.karyawan_id = lg.id_operator
					LEFT JOIN tbl_karyawan as kr ON kr.id = lg.id_operator
					LEFT JOIN tbl_position pos ON pos.id = kr.position_id
					LEFT JOIN tbl_purchasing pu ON pu.id = lg.pr_id
					WHERE lg.pr_id = '$id' GROUP BY lg.id DESC";
			$res = $this->db->query($sql)->result_array();
			$numrows = $this->db->query($sql)->num_rows();

			$arr = array(
				'res' => $res,
				'numrows'	=> $numrows,
				);

			return $arr;
		}
	

		public function load_pesan($pr, $log_pr)
		{
			$sql = "SELECT psn.pr_id, psn.log_pr_id, psn.pesan, psn.date_created, lg.nickname, psn.psn_type FROM tbl_pr_pesan as psn
            		LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = psn.sender
            		WHERE pr_id = '$pr' AND log_pr_id = '$log_pr' GROUP BY psn.id ORDER BY psn.date_created DESC";
   			$pesan = $this->db->query($sql)->result_array();

    		return $pesan;
		}

	
		public function savetime($id){
		    $karyawanID = $_SESSION['myuser']['karyawan_id'];
		    $time = date('Y-m-d H:i:s');

		    $sql = "SELECT id FROM tbl_pr_log WHERE pr_id = '$id' AND overto = '$karyawanID' AND time_login = '0000-00-00 00:00:00' ORDER BY id DESC LIMIT 1";
		    $query = $this->db->query($sql)->row_array();
		    $child = $query['id'];

		    if($query){
		      $sql2 = "UPDATE tbl_pr_log SET time_login = '$time', time_idle = '$time' WHERE id = '$child'";
		      $que = $this->db->query($sql2);
		    }
  		}

		public function timer($pr_id, $log_pr_id)
		{
			$sql = "SELECT id, time_idle, time_login, time_nextto, id_operator FROM tbl_pr_log
			        WHERE pr_id = '$pr_id' AND id = '$log_pr_id'";
			$idle = $this->db->query($sql)->row_array();

			return $idle;
		}

		public function total_time($pr_id)
		{
			$sql = "SELECT pr.date_closed, log.date_created, max(log.date_created) as end_date, min(log.date_created) as start_date
			        FROM tbl_pr_log as log
			        LEFT JOIN tbl_purchasing as pr ON pr.id = log.pr_id
			        WHERE log.pr_id = '$pr_id'";
			$query = $this->db->query($sql);
			$respon = $query->row_array();

			return $respon;
		}

		public function getKetentuan($id = '')
		{
			$sql =  "SELECT date_created, date_modified, ketentuan, tbl_loginuser.nickname FROM tbl_ketentuan
			    LEFT JOIN tbl_loginuser ON tbl_ketentuan.user_id = tbl_loginuser.karyawan_id
			    WHERE tbl_ketentuan.nama_modul = '5'
			    ORDER BY tbl_ketentuan.id DESC LIMIT 1";
		  	return $this->db->query($sql)->row_array();
		}


		public function link_modul_Project($id) 
		{
			$sql = "SELECT li.link_to_id, lm.nama_modul,li.link_from_id FROM tbl_link li
					LEFT JOIN tbl_project_dhc sps ON sps.id= li.link_from_id
					LEFT JOIN tbl_log_modul lm ON lm.id = li.link_to_modul
					WHERE li.link_from_modul = '5' AND li.link_from_id = '$id' AND li.link_to_modul = '9' GROUP BY li.id ASC";
			$res = $this->db->query($sql)->result_array();
			
			return $res;	
		}

		public function link_modul_Project_dee($id) 
		{
			$sql = "SELECT li.link_to_id, lm.nama_modul,li.link_from_id FROM tbl_link li
					LEFT JOIN tbl_project_dee sps ON sps.id= li.link_from_id
					LEFT JOIN tbl_log_modul lm ON lm.id = li.link_from_modul
					WHERE li.link_from_modul = '19' AND li.link_to_id = '$id' AND li.link_to_modul = '5' GROUP BY li.id ASC";
			$res = $this->db->query($sql)->result_array();
			
			return $res;	
		}

		public function link_modul_SPS($id) 
		{
			$sql = "SELECT sps.job_id,li.link_to_id, lm.nama_modul,li.link_from_id FROM tbl_link li
					LEFT JOIN tbl_sps sps ON sps.id= li.link_from_id
					LEFT JOIN tbl_log_modul lm ON lm.id = li.link_to_modul
					WHERE li.link_to_modul = '5' AND li.link_to_id = '$id' AND li.link_from_modul = '3' GROUP BY li.id ASC";
			$res = $this->db->query($sql)->result_array();
			
			return $res;	
		}

		public function link_modul_Delivery($id) 
		{
			$sql = "SELECT li.link_to_id, lm.nama_modul,li.link_from_id FROM tbl_link li
					LEFT JOIN tbl_do do ON do.id= li.link_from_id
					LEFT JOIN tbl_log_modul lm ON lm.id = li.link_to_modul
					WHERE li.link_to_modul = '5' AND li.link_to_id = '$id' AND li.link_from_modul = '2' GROUP BY li.id ASC";
			$res = $this->db->query($sql)->result_array();
			
			return $res;	
		}

		public function link_modul_Import($id) 
		{
			$sql = "SELECT li.link_to_id, lm.nama_modul,li.link_from_id FROM tbl_link li
					LEFT JOIN tbl_do sps ON sps.id= li.link_to_id
					LEFT JOIN tbl_log_modul lm ON lm.id = li.link_to_modul
					WHERE li.link_from_modul = '5' AND li.link_from_id = '$id' AND li.link_to_modul = '6' GROUP BY li.id ASC";
			$res = $this->db->query($sql)->result_array();

			return $res;	
		}

		public function idTool() 
   		{
	    	$query = "SELECT id FROM tbl_tools";
	  		$rowcount = $this->db->query($query)->num_rows();

	  		return $rowcount;
  		}

  		public function getSaldo()
  		{
  			$kar_id = $_SESSION['myuser']['karyawan_id'];
  			$sql = "SELECT balance FROM tbl_kasbon_cash WHERE karyawan_id ='$kar_id'";
  			$res = $this->db->query($sql)->row_array();

  			return $res;
  		}

  		public function cekpay($id)
        {
          
            $sql = "SELECT id FROM tbl_pr_vendor sm
                    WHERE status_approved_item = 0 AND sm.pr_id = '$id'";
            $res = $this->db->query($sql)->num_rows();
            return $res;
          
        }

		public function addVendor()
		{
			if($this->input->post())
			{

				$nama 		= $this->input->post('vendor');
				$alamat 	= $this->input->post('alamat');
				$telepon	= $this->input->post('telepon');
				$pic 		= $this->input->post('pic');
				$email		= $this->input->post('email');
				$produk		= $this->input->post('produk');
				$mou 		= $this->input->post('mou');
				// $holder 	= $this->input->post('holder');

				$add = array(
					'vendor'		=> $nama,
					'alamat'		=> $alamat,
					'telepon'		=> $telepon,
					'pic'			=> $pic,
					'email'			=> $email,
					// 'holder'		=> $holder,
					'date_created'	=> date('Y-m-d H:i:s'),
					'receiver'		=> $receiver_item,
					);
				$this->db->insert('tbl_supplier', $add);
				$v_id = $this->db->insert_id();

				for($i=0; $i<sizeof($produk); $i++)
			   	{
			    	$dataSet[$i] = array (	'vendor_id' => $v_id,
			    							'date_created'	=> date('Y-m-d H:i:s'),
			    							'nama_barang' => $produk[$i],
			    							'satuan' => $mou[$i],
			    						);
			   	}
			   	$this->db->insert_batch('tbl_pr_daftarbrg', $dataSet);
			}
		}

		public function addPR()
		{
			if($this->input->post())
			{
				$sess 				= $_SESSION['myuser'];
				$id_kar				= $_SESSION['myuser']['karyawan_id'];
				$position_id 		= $_SESSION['myuser']['position_id'];
				$cabang				= $_SESSION['myuser']['cabang'];
				$sales 				= substr($sess['position'], 0, 5);
				$ket 				= $this->input->post('ket_pembelian');
				$overto 			= $this->input->post('overto');
				$overto_type 		= $this->input->post('overtotype');
				$message			= $this->input->post('message');
				$deadline 			= $this->input->post('deadline');
				$deadline 			= preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $deadline);
				$divisi 			= $this->input->post('divisi');
				$biaya_piutang 		= $this->input->post('biaya_piutang');
				$source_pengadaan 	= $this->input->post('source_pengadaan');
				$ptg_omset 			= $this->input->post('potong_omset');
				$crm_link 			= $this->input->post('crm_link');
				$sps_id 			= $this->input->post('sps_id');
				$job_id 			= $this->input->post('job_id');
				$project_id 		= $this->input->post('project_id');
				$delv_id 			= $this->input->post('delv_id');
				$receiver 			= $this->input->post('receiver');
				$purchaser 			= $this->input->post('purchaser');
				$ptg_saldo 			= $this->input->post('potong_saldo');
				$project_dee_id 	= $this->input->post('project_dee_id');
				$random_value 		= rand(0,100);


				$qty1 		= $this->input->post('qty');
				$stock1		= $this->input->post('stock');
				$vendor		= $this->input->post('vendor');
				$items1 		= $this->input->post('items');
				$mou1 		= $this->input->post('mou');
				$priority1	= $this->input->post('priority');
				// $deadline 	= $this->input->post('deadline');
				// $deadline1 	= preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $deadline);
				$jns1 		= $this->input->post('jns_pembelian');
				$holder1 		= $this->input->post('holder');
				$name_item1 = $this->input->post('name_item');
				$kendaraan1 = $this->input->post('kendaraan');
				$no_kendaraan1 = $this->input->post('no_kendaraan');
				$kilometer_awal1 = $this->input->post('km_awal');
				$kilometer_akhir1 = $this->input->post('km_akhir');
				// $price1 = $this->input->post('price');
				// $total_beli1 = $this->input->post('total_beli');
				$no_kendaraan1 = $this->input->post('no_kendaraan');

				$harga_estimasi 	= $this->input->post('harga_estimasi');

				$receiver_item		= $this->input->post('receiver_item');


				
				$sql = "SELECT id FROM tbl_purchasing ORDER BY id DESC LIMIT 1";
                $count= $this->db->query($sql)->row_array();
                $ar = $count['id'];
                $htng = $ar + 1;
                $id = $htng; // pipit 24022020

				$pr = array(
						'id'				=> $id,
						'sales_id'			=> $id_kar,
						'alasan_pembelian'	=> $ket,
						'date_created'		=> date('Y-m-d H:i:s'),
						'date_deadline'		=> $deadline,
						'published'			=> '1',
						'divisi'			=> $divisi,
						'biaya_piutang'		=> $biaya_piutang,
						'ptg_omset'			=> $ptg_omset,
						'source_pengadaan'	=> $source_pengadaan,	
						'receiver'			=> $receiver,
						'purchaser'			=> $purchaser,
						'ptg_saldo'			=> $ptg_saldo,
						'random_value'		=> $random_value,
					);

				$this->db->insert('tbl_purchasing', $pr);
				$pr_id = $this->db->insert_id();

				$logpr = $this->AddLogPR($pr_id, $id_kar);

				$args = array(
	                    'pr_id'         => $pr_id,
	                    'contributor'   => $receiver,
	                    'user_id'       => $_SESSION['myuser']['karyawan_id'],
	                    'date_created'  => date('Y-m-d H:i:s'),
	                    );
	            $this->db->insert('tbl_pr_contributor', $args);
	            $contrib = $this->db->insert_id();

	           	$isinotif = "You have been add as Contributor on PR ID ".$pr_id; 
	            $this->notification($pr_id, $contrib, '16', $receiver,$isinotif);

				if($source_pengadaan=='1')
				{
					$komoditi = $this->input->post('komoditi');
					$file_oem = $this->input->post('file_oem');
					
					$this->db->where('id',$pr_id);
					$this->db->update('tbl_purchasing', array('komoditi' => $komoditi,'file_oem' => $file_oem));
					
					$sql = "SELECT nickname FROM tbl_loginuser WHERE karyawan_id = '4'";
                	$row = $this->db->query($sql)->row_array();

					$args = array(
	                    'pr_id'         => $pr_id,
	                    'contributor'   => '4',
	                    'user_id'       => $_SESSION['myuser']['karyawan_id'],
	                    'date_created'  => date('Y-m-d H:i:s'),
	                    );
	                $this->db->insert('tbl_pr_contributor', $args);
	                $con_id = $this->db->insert_id();

					$sql = "SELECT id FROM tbl_pr_log WHERE pr_id = $pr_id ORDER BY id DESC LIMIT 1";
					$que = $this->db->query($sql)->row_array();
					$log_pr = $que['id'];

					$addpsn = array(
						'pr_id' => $pr_id,
						'log_pr_id'	=> $log_pr,
						'sender' => $_SESSION['myuser']['karyawan_id'],
						'pesan'	=> $_SESSION['myuser']['nickname']." Add ".$row['nickname']." as Contributor",
						'date_created'	=> date('Y-m-d H:i:s'), 
						);
					$this->db->insert('tbl_pr_pesan', $addpsn);
					$pesan_id = $this->db->insert_id();

					$isinotif   = "<b>PR ID ".$pr_id."</b> [".$ket."] : ".$row['nickname']." Add you as Contributor.";
					$url 		="purchasing/details/".$pr_id;

					$this->notification($pr_id, $con_id, '16', '4',$isinotif,$url);

				}

				if($crm_link) 
				{

					$this->db->where('id',$pr_id);
					$this->db->update('tbl_purchasing', array('modul_link' => '8', 'link_id' => $crm_link));
				}

				if($sps_id) 
				{

					$inslink = array
					(
			            'link_from_modul' => '3',
			            'link_from_id'    => $sps_id,
			            'link_to_modul'   => '5',
			            'link_to_id'      => $pr_id,
			            'user'            => $_SESSION['myuser']['karyawan_id'],
			            'date_created'    => date('Y-m-d H:i:s'),
	        		);
	        		 $this->db->insert('tbl_link', $inslink);

					$sql = "SELECT id FROM tbl_sps_log WHERE id_sps = '$sps_id' ORDER BY id DESC LIMIT 1";
					$que = $this->db->query($sql)->row_array();
					$log_id = implode(" ", $que);

					$args = array(
	                    'sps_id'       =>  $sps_id,
	                    'log_sps_id'   =>  $log_id,
	                    'sender_id'    =>  $_SESSION['myuser']['karyawan_id'],
	                    'pesan'        =>  "Membuat PR ID ".$pr_id,
	                    'date_created' =>  date('Y-m-d H:i:s'),
	                    );
	                $this->db->insert('tbl_pesan', $args);
	                $con_id = $this->db->insert_id();

	                $addpsn = array(
						'pr_id' 		=> $pr_id,
						'log_pr_id'		=> $logpr,
						'sender' 		=> $id_kar,
						'pesan'			=> 'Membuat PR dari SPS ID '.$job_id,
						'date_created'	=> date('Y-m-d H:i:s'), 
						);
					$this->db->insert('tbl_pr_pesan', $addpsn);

				}

				if($project_id) 
				{

					$inslink = array
					(
			            'link_from_modul' => '9',
			            'link_from_id'    => $project_id,
			            'link_to_modul'   => '5',
			            'link_to_id'      => $pr_id,
			            'user'            => $_SESSION['myuser']['karyawan_id'],
			            'date_created'    => date('Y-m-d H:i:s'),
	        		);
	        		 $this->db->insert('tbl_link', $inslink);

	        		$log = array(
							'project_id' 	=> $project_id,
							'user'			=> $_SESSION['myuser']['karyawan_id'],
							'type'			=> 'pesan',
							'type_id'		=> $project_id,
							'date_created' 	=> date('Y-m-d H:i:s'),
						);
					$this->db->insert('tbl_project_log', $log);
					$log_id = $this->db->insert_id();

	                $args = array(
						'project_id' 	=> $project_id,
						'log_id'		=> $log_id,
						'sender'		=> $_SESSION['myuser']['karyawan_id'],
						'pesan'			=> "Membuat PR ID ".$pr_id,
						'date_created'	=> date('Y-m-d H:i:s'),
					);
					$this->db->insert('tbl_project_pesan', $args);
					$pesan_id = $this->db->insert_id();

	                $addpsn = array(
						'pr_id' 		=> $pr_id,
						'log_pr_id'		=> $logpr,
						'sender' 		=> $id_kar,
						'pesan'			=> 'Membuat PR dari Project ID '. $project_id,
						'date_created'	=> date('Y-m-d H:i:s'), 
						);
					$this->db->insert('tbl_pr_pesan', $addpsn);

				}

				if($project_dee_id) 
				{

					$inslink = array
					(
			            'link_from_modul' => '19',
			            'link_from_id'    => $project_dee_id,
			            'link_to_modul'   => '5',
			            'link_to_id'      => $pr_id,
			            'user'            => $_SESSION['myuser']['karyawan_id'],
			            'date_created'    => date('Y-m-d H:i:s'),
	        		);
	        		$this->db->insert('tbl_link', $inslink);

	        		 $log = array(
							'project_id' 	=> $project_dee_id,
							'user'			=> $_SESSION['myuser']['karyawan_id'],
							'type'			=> 'pesan',
							'type_id'		=> $project_dee_id,
							'date_created' 	=> date('Y-m-d H:i:s'),
						);
					$this->db->insert('tbl_project_dee_log', $log);
					$log_id = $this->db->insert_id();

	                $args = array(
						'project_id' 	=> $project_dee_id,
						'log_id'		=> $log_id,
						'sender'		=> $_SESSION['myuser']['karyawan_id'],
						'pesan'			=> "Membuat PR ID ".$pr_id,
						'date_created'	=> date('Y-m-d H:i:s'),
					);
					$this->db->insert('tbl_project_dee_pesan', $args);
					$pesan_id = $this->db->insert_id();

	                $addpsn = array(
						'pr_id' 		=> $pr_id,
						'log_pr_id'		=> $logpr,
						'sender' 		=> $id_kar,
						'pesan'			=> 'Membuat PR dari Project DEE ID '. $project_dee_id,
						'date_created'	=> date('Y-m-d H:i:s'), 
						);
					$this->db->insert('tbl_pr_pesan', $addpsn);

				}


				if($delv_id) 
				{

					$inslink = array
					(
			            'link_from_modul' => '2',
			            'link_from_id'    => $delv_id,
			            'link_to_modul'   => '5',
			            'link_to_id'      => $pr_id,
			            'user'            => $_SESSION['myuser']['karyawan_id'],
			            'date_created'    => date('Y-m-d H:i:s'),
	        		);
	        		 $this->db->insert('tbl_link', $inslink);

					$sql = "SELECT * FROM tbl_do_log WHERE do_id = '$delv_id' ORDER BY id DESC LIMIT 2";
    				$res = $this->db->query($sql)->result_array();
    				$iddown = $res[0]['id'];


	                $pesan = array(
					        'type'        => '2',
					        'type_id'     => $delv_id,
					        'log_type_id' => $iddown,
					        'sender_id'   => $id_kar,
					        'pesan'       => "Membuat PR ID".$pr_id,
					        'date_created'  => date('Y-m-d H:i:s'),
					        );
				    $this->db->insert('tbl_multi_pesan', $pesan);
				    $id_pesan = $this->db->insert_id();


	                $addpsn = array(
						'pr_id' 		=> $pr_id,
						'log_pr_id'		=> $logpr,
						'sender' 		=> $id_kar,
						'pesan'			=> 'Membuat PR dari Delivery ID '.$delv_id,
						'date_created'	=> date('Y-m-d H:i:s'), 
						);
					$this->db->insert('tbl_pr_pesan', $addpsn);

				}


				$ovto = array(
					'pr_id'		=> $pr_id,
					'user_id'	=> $id_kar,
					'overto'	=> $overto,
					'overto_type'	=> $overto_type,
					'date_created'	=> date('Y-m-d H:i:s'), 
				);
				$this->db->insert('tbl_pr_overto', $ovto);

				$addpsn = array(
					'pr_id' 		=> $pr_id,
					'log_pr_id'		=> $logpr,
					'sender' 		=> $id_kar,
					'pesan'			=> $message,
					'date_created'	=> date('Y-m-d H:i:s'), 
					);
				$this->db->insert('tbl_pr_pesan', $addpsn);



				if(!empty($divisi)) 
				{
	                switch ($divisi) 
	                {
	                    case 'DCE':
	                        $kadiv = '90';
	                        break;
	                    case 'DGM':
	                        $kadiv = '90';
	                        break;
	                    case 'DEE':
	                        $kadiv = '93'; 
	                        break;
	                    case 'DGC':
	                        $kadiv = '90';
	                        break;    
	                    case 'DHC':
	                        $kadiv = '88'; 
	                        break;
	                    case 'DHE':
	                        $kadiv = '91'; 
	                        break;
	                    case 'DRE':
	                        $kadiv = '89'; 
	                        break;
	                    case 'HORECA':
	                        $kadiv = '89'; 
	                        break;
	                    case 'DIR':
	                        $kadiv = '89'; 
	                        break;
	                    case 'DWT':
	                        $kadiv = '91'; 
	                    break;
	                    case 'DPP':
	                        $kadiv = '91'; 
	                    break;

	                    case 'DMS':
	                        $kadiv = '149'; 
	                    break;

	                }

	            }elseif (in_array($position_id, array('65','66','67','68','71','103','33','176','190'))) 
	            { //sales jkt
	                switch ($position_id) 
	                {
	                    case '68':
	                        $kadiv = '90';
	                        break;
	                    case '67':
	                        $kadiv = '93'; 
	                        break;
	                    case '65':
	                        $kadiv = '88'; 
	                        break;
	                    case '71':
	                        $kadiv = '91'; 
	                        break;
	                    case '66':
	                        $kadiv = '89'; 
	                        break;
	                    case '103':
	                        $kadiv = '91'; //100
	                        break;  

	                     case '33':
	                        $kadiv = '90'; //100
	                        break;  

	                     case '33':
	                        $kadiv = '90'; //100
	                        break; 


	                     case '176':
	                        $kadiv = '90'; //100
	                        break; 

	                     case '190':
	                        $kadiv = '89'; //100
	                        break;                   
	                }
	            }

	            $notif = '13';
	            $rec_id = '';
	            $isinotif 	= "<b>PR ID ".$pr_id."</b> [".$ket."] need to be Approved";
	            
	            if(in_array($position_id, array('1','2','14','106','313','102'))) 
	            { //direksi bikin pr

	            	$status = "Waiting for Director Approval";
	            	$this->newNotification($pr_id, $rec_id, $notif, '2',$isinotif);
	   	
	            }elseif(in_array($position_id, array('55', '56', '57', '58','134'))) // WL 42182 
	            { //kacab bikin pr
	                    if($divisi == '') 
	                    {
	                    	$status = "Waiting for Director Approval";

	                        $this->newNotification($pr_id, $rec_id, $notif, '2',$isinotif);

	                        $this->db->where('id',$pr_id);
	                        $this->db->update('tbl_purchasing', array('level_approval' => 'Kadiv'));
	                    }elseif($divisi != '') {
	                    	$status = "Waiting for Kadiv Approval";
	                        $this->newNotification($pr_id, $rec_id, $notif, $kadiv,$isinotif);
	                    }
	            }else 
	            {
	                switch ($cabang) 
	                { //staff cabang bikin pr


	                    case 'Medan':
	                        $status = "Waiting for Kacab Approval";
	                        $this->newNotification($pr_id, $rec_id, $notif, '56',$isinotif);
	                       
	                        break;
	                    case 'Surabaya':
	                    
	                    	if($divisi)
	                    	{
		                        switch ($divisi) 
				                {
				                    case 'DCE':
				                        $kadiv = '90';
				                        break;
				                    case 'DEE':
				                        $kadiv = '93'; 
				                        break;
				                    case 'DGC':
				                        $kadiv = '90';
				                        break;    
				                    case 'DHC':
				                        $kadiv = '88'; 
				                        break;
				                    case 'DHE':
				                        $kadiv = '91'; 
				                        break;
				                    case 'DRE':
				                        $kadiv = '89'; 
				                        break;
				                    case 'HORECA':
				                        $kadiv = '89'; 
				                        break;
				                    case 'DIR':
				                        $kadiv = '89'; 
				                        break;
				                    case 'DWT':
				                        $kadiv = '91'; 
				                    break;
				                    case 'DMS':
				                        $kadiv = '149'; 
				                    break;
				                }
		                    	$this->newNotification($pr_id, $rec_id, $notif,$kadiv,$isinotif);
		                    }else
		                    {
		                    	$status = "Waiting for Director Approval";
	                            $this->newNotification($pr_id, $rec_id, $notif, '2',$isinotif);
		                    }
	                       
	                        break;        
	                    case 'Cikupa':
	                        $status = "Waiting for Warehouse Manager Approval";
	                        $this->newNotification($pr_id, $rec_id, $notif, '58',$isinotif);
	                      
	                        break;
	                    case 'Semarang': // WL 42182
	                        $status = "Waiting for Kacab Approval";
	                        $this->newNotification($pr_id, $rec_id, $notif, '134',$isinotif);
	                      
	                        break;    
	                    default:
	                        
	                        if(in_array($position_id, array('88','89','90','91','92','93','100'))) 
	                        { //kadiv bikin pr
	                            $status = "Waiting for Director Approval";
	                            $this->newNotification($pr_id, $rec_id, $notif, '2',$isinotif);

	                        }elseif(in_array($position_id, array('65','66','67','68','71','103'))) { //sales jkt bikin pr
	                            $status = "Waiting for Kadiv Approval";
	                            $this->newNotification($pr_id, $rec_id, $notif, $kadiv,$isinotif);    

	                        }elseif($position_id == '102' OR $position_id == '127'  OR $position_id == '165') { //staff IT bikin pr // baru pipit 13012020
	                           //echo "aaaaaa"; exit();
	                            $status = "Waiting for Leader Approval";
	                            $this->newNotification($pr_id, $rec_id, $notif, '13',$isinotif);

	                        }elseif($divisi == '' OR $divisi =='DMS') { //staff jkt bikin pr (hrd, it, import, umum)
	                           //echo "aaaaaa"; exit();
	                            $status = "Waiting for Director Approval";
	                            $this->newNotification($pr_id, $rec_id, $notif, '2',$isinotif);
	                            
	                        }elseif (!empty($divisi) AND $divisi !='DMS') {
	                        	//echo "bbbbbbb"; exit();
	                        	$status = "Waiting for Kadiv Approval";
	                        	$this->newNotification($pr_id, $rec_id, $notif, $kadiv,$isinotif);
	                        }                    
	                        break;
	                }
	            }

		        $this->db->where('id',$pr_id);
		        $this->db->update('tbl_purchasing', array('status' => $status));

		        foreach ($vendor as $key => $vend) 
		        {
		       		$qty 			= $qty1[$key];
					$stock			= $stock1[$key];
					$items 			= $items1[$key];
					$mou 			= $mou1[$key];
					$priority		= $priority1[$key];
					$jns 			= $jns1[$key];
					$holder 		= $holder1[$key];
					$name_item 		= $name_item1[$key];
					$kendaraan 		= $kendaraan1[$key];
					$no_kendaraan 	= $no_kendaraan1[$key];
					$kilometer_awal = $kilometer_awal1[$key];
					$kilometer_akhir 	= $kilometer_akhir1[$key];
					// $price 				= $price1[$key];
					// $total_beli 		= $total_beli1[$key];
					$no_kendaraan 		= $no_kendaraan1[$key];
					$receiver_items 	= $receiver_item[$key];
			

			       	if($items =='bbm')
					{
						$name_item = $items;
					}
					elseif ($items =='lainnya') 
					{
						$name_item = $name_item;
					}
					$pr_id = $id;

					$additems = array(
						'pr_id'	=> $pr_id,
						'vendor'	=> $vend,
						'items'	=> $name_item,
						'qty'	=> $qty,
						'stock'	=> $stock,
						'mou'	=> $mou,
						'deadline' => $deadline,
						'priority' =>$priority,
						'date_created'	=> date('Y-m-d H:i:s'),
						'jenis'		=> $jns,
						'holder'	=>$holder,
						'published'	=>'0',
						'ptg_saldo' =>'2',
						'receiver'  => $receiver_items,
						);
					$this->db->insert('tbl_pr_vendor', $additems);
					$vendor_id = $this->db->insert_id();

					$sql ="SELECT * FROM tbl_purchasing WHERE id='pr_id'";
					$res = $this->db->query($sql)->row_array();
					$divisi = $res['divisi'];
					$cabang		= $_SESSION['myuser']['cabang'];
					$position_id = $_SESSION['myuser']['position_id'];

					if($items =='bbm')
					{
						$total_kilometer = $kilometer_akhir - $kilometer_awal;

						$rasio = $total_kilometer/($total_beli/$price);

						$ken = array
						(
							'vendor_id' => $vendor_id,
							'pr_id' => $pr_id,
							'kepemilikan' => $kendaraan,
							'kilometer_akhir' => $kilometer_akhir,
							'kilometer_awal'	=> $kilometer_awal,
							'price'=> $price,
							'total_beli' => $total_beli,
							'total_kilometer' => $total_kilometer,
							'rasio' => $rasio,
							'kendaraan_id' => $no_kendaraan,
							'user' => $_SESSION['myuser']['karyawan_id'],
							'date_created' => date('Y-m-d H:i:s'),

						);
						$this->db->insert('tbl_record_kendaraan_perusahaan', $ken);
						$record_id = $this->db->insert_id();

						$this->db->where('id',$vendor_id);
		            	$this->db->update('tbl_pr_vendor', array('level_approval' => 'Kadiv'));

						$sql="SELECT tl.id as id_tools,kend.id as kendaraan_id, tl.code,tl.name,tl.type,hld.user_holder,kend.kepemilikan,krw.nama as nama_holder,krw.position_id,
						 	  kend.kendaraan,kend.plat_nomer,lgn.nickname,kend.km_service FROM tbl_kar_kendaraan kend
					          LEFT JOIN tbl_tools tl ON tl.id = kend.tools_id
					          LEFT JOIN tbl_tools_holder hld ON hld.tool_id = tl.id
					          LEFT JOIN tbl_karyawan krw ON krw.id = hld.user_holder
	                          LEFT JOIN tbl_loginuser lgn ON lgn.karyawan_id = hld.user_holder
					        	  WHERE kend.id='$no_kendaraan'";

					    $res= $this->db->query($sql)->row_array();
					    $holder = $res['user_holder'];
					    $jenis_kendaraan = $res['kendaraan'];
					    $kepemilikan = $res['kepemilikan'];
					    $tools_id = $res['id_tools'];
					    $type 	  = $res['type'];
					    $plat_nomer = $res['plat_nomer'];
					    $kendaraan_id = $res['kendaraan_id'];
					    $km_serv = $res['km_service'];
						$nama_holder = $res['nama_holder'];
					    $position_id= $res['position_id'];
					
					    if($kepemilikan =='0')
					    {

					    	if($jenis_kendaraan == 'Mobil')
						    {

						    	$if = $this->if_mobil($kilometer_akhir,$km_serv);

						    	$description = $if['description'];
						    	$km_service	 = $if['km_service'];
						    	$putaran_km  = $if['ptrs_km'];
						    }
						    
						    if($jenis_kendaraan == 'Motor')
						    {
						    	$if = $this->if_motor($kilometer_akhir,$km_serv);
						    	$description = $if['description'];
						    	$km_service  = $if['km_service'];
						    	$putaran_km  = $if['ptrs_km'];
						    }

						    $this->db->where('id',$kendaraan_id);
		            		$this->db->update('tbl_kar_kendaraan', array('kilometer_akhir' => $kilometer_akhir,'km_service'=>$km_service,'putaran_km'=>$putaran_km));

		            		if(!empty($description))
		            		{ 
							    $sql = "SELECT id FROM tbl_wishlist ORDER BY id DESC LIMIT 1"; 
									        $count= $this->db->query($sql)->row_array();
									        $ar = $count['id'];
											$htng = $ar + 1;
									        $wid = $htng;
									        $date_reminder 	= date("Y-m-d", strtotime("+7 days"));

								$title 	= 'Service Kendaraan '.$plat_nomer;

								if(!empty($holder))
								{
									$holder = $holder;
								}else
								{
									$holder='2';
								}

								$sql ="SELECT hstr.*,lgn.nickname FROM tbl_history_service_kendaraan hstr
										LEFT JOIN tbl_loginuser lgn ON lgn.karyawan_id = hstr.user_service
										WHERE hstr.kendaraan_id='$kendaraan_id' ORDER BY id DESC LIMIT 1";
								$ser= $this->db->query($sql)->row_array();
								$desc1 = $ser['description'];

								if($desc1)
								{
									$des = $description."<br> history :<br>".$desc1."<br>".
										  "oleh user ".$ser['nickname']."<br> pada KM "
										  .$ser['kilometer_akhir'];
								}else
								{
									$des = $description;
								}
				       
								$add = array
								(
										'id'				=> $wid,
										'user'	 			=> '133',
										'date_created'		=> date('Y-m-d H:i:s'),
										'descriptions' 		=> $des,
										'wish_to'			=> $holder,
										'title'				=> $title,
										'date_reminder'		=> $date_reminder,
										'type_wishlist' 	=> '1',
										'interval_reminder' => '7',
										'kendaraan_id'		=> $kendaraan_id, // new
								);
								$this->db->insert('tbl_wishlist', $add);

								$ex = array(
									'wish_id' => $wid,
									'executor' => $holder,
									'date_created' => date('Y-m-d H:i:s'),
								);
								$this->db->insert('tbl_wish_executor',$ex);
								$ex_id = $this->db->insert_id();

								$isinotif = "You have New <b> Wishlist ID " .$wid."</b>[Service Kendaraan] from IIOS";
											
								$notif = array(
						            'modul' 		=> '7',
						            'modul_id' 		=> $wid,
						            'record_id' 	=> $holder,
						            'record_type' 	=> '1',
						            'user_id' 		=> $holder,
						            'date_created' 	=> date('Y-m-d H:i:s'),
						            'notes'			=> $isinotif,
						            'url'			=> 'wishlist/details/'.$wid,
					        	);
					    		$this->db->insert('tbl_notification', $notif);


								$isinotif = "IIOS Add you as Executor In Wishlist ID ".$wid;
								$notif = array(
						            'modul' 		=> '7',
						            'modul_id' 		=> $wid,
						            'record_id' 	=> $ex_id,
						            'record_type' 	=> '4',
						            'user_id' 		=> $holder,
						            'date_created' 	=> date('Y-m-d H:i:s'),
						            'notes'			=> $isinotif,
						            'url'			=> 'wishlist/details/'.$wid,
					        	);
					    		$this->db->insert('tbl_notification', $notif);

					    		$sql="SELECT krw.*,krw1.nama,krw.id as leader_id  FROM tbl_karyawan krw 
					    			  LEFT JOIN tbl_karyawan krw1 ON krw.head_division = krw1.position_id
					    			  WHERE krw.id='$holder'";
					    		$lead = $this->db->query($sql)->row_array();
					    		$leader= $lead['leader_id'];

					    		$args = array(
				                    'wish_id'       => $wid,
				                    'contributor'   => $leader,
				                    'user_id'       => '133',
				                    'date_created'  => date('Y-m-d H:i:s'),
				                    );
				                $this->db->insert('tbl_wish_contributor', $args);
				                $con_id = $this->db->insert_id();
							}


					    }else
					    {
					    	$this->db->where('id',$kendaraan_id);
		            		$this->db->update('tbl_kar_kendaraan', array('kilometer_akhir' => $kilometer_akhir));
					    }


					    if($rasio < '7')
					    {

					    	$sql = "SELECT id FROM tbl_wishlist ORDER BY id DESC LIMIT 1"; //baru ditambahkan
							$count= $this->db->query($sql)->row_array();
							$ar = $count['id'];
							$htng = $ar + 1;
							$wid = $htng;
							$date_reminder 	= date("Y-m-d", strtotime("+7 days"));

							$title 	= 'Tindakan Cek Kendaraan '.$plat_nomer;
							$desc   = "Rasio Kendaraan ".$plat_nomer." sangat Rendah 1:".$rasio." Mohon segera melakukan pengecekan kendaraan tersebut";


							$sql="SELECT cabang FROM tbl_karyawan WHERE id='$holder'";
							$cb = $this->db->query($sql)->row_array();
							$cabang = $cb['cabang'];

							switch ($cabang) 
							{
								case 'Cikupa':
									 $leader='58';
								break;
								case 'Medan':
									 $leader ='56';
								break;
								case 'Surabaya':
									 $leader ='55';
								break;
								case 'Semarang':
									 $leader ='134';
								break;
								case 'Bandung':
									 $leader ='57';
								break;
								case 'Jakarta':
									 $leader ='2';
								break;	
							}
			       	
			       			$sql ="SELECT id FROM tbl_karyawan WHERE position_id='$leader'";
			       			$res= $this->db->query($sql)->row_array();
			       			$id_lead = $res['id'];

							$add = array
							(
								'id'				=> $wid,
								'user'	 			=> '133',
								'date_created'		=> date('Y-m-d H:i:s'),
								'descriptions' 		=> $desc,
								'wish_to'			=> $id_lead,
								'title'				=> $title,
								'date_reminder'		=> $date_reminder,
								'type_wishlist' 	=> '1',
								'interval_reminder' => '7',
							);
							$this->db->insert('tbl_wishlist', $add);

							$ex = array(
											'wish_id' => $wid,
											'executor' => $id_lead,
											'date_created' => date('Y-m-d H:i:s'),
							);
							$this->db->insert('tbl_wish_executor',$ex);
							$ex_id = $this->db->insert_id();

							$isinotif1 = "You have New <b> Wishlist ID " .$wid."</b>[Cek Kendaraan] from IIOS";

							$notif = array(
								        'modul' 		=> '7',
								        'modul_id' 		=> $wid,
								        'record_id' 	=> $wid,
								        'record_type' 	=> '1',
								        'user_id' 		=> $holder,
								        'date_created' 	=> date('Y-m-d H:i:s'),
								       	'notes'			=> $isinotif,
								        'url'			=> 'wishlist/details/'.$wid,
							);
							$this->db->insert('tbl_notification', $notif);

							$isinotif = "IIOS Add you as Executor In Wishlist ID ".$wid;
							$notif = array(
								        'modul' 		=> '7',
								        'modul_id' 		=> $wid,
								        'record_id' 	=> $ex_id,
								        'record_type' 	=> '4',
								        'user_id' 		=> $id_lead,
								        'date_created' 	=> date('Y-m-d H:i:s'),
								       	'notes'			=> $isinotif,
								        'url'			=> 'wishlist/details/'.$wid,
							);
							$this->db->insert('tbl_notification', $notif);
					    }
					}
		       	}

				$this->session->unset_userdata('sess_sps_id');   
				$this->session->unset_userdata('sess_crm_id');
				$this->session->unset_userdata('sess_proj_id');
				$this->session->unset_userdata('sess_delv_id');

				return $pr_id;	
			}   		
		}


		
		// Wishlist ID : 41729
		
		public function addPRItems($pr_id)
		{
			if($this->input->post())
			{
				$pr_id 		= $this->input->post('pr_id');
				$qty 		= $this->input->post('qty');
				$stock		= $this->input->post('stock');
				$vendor		= $this->input->post('vendor');
				$items 		= $this->input->post('items');
				$mou 		= $this->input->post('mou');
				$priority	= $this->input->post('priority');
				$deadline 	= $this->input->post('deadline');
				$deadline 	= preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $deadline);
				$jns 		= $this->input->post('jns_pembelian');
				$holder 		= $this->input->post('holder');
				$name_item = $this->input->post('name_item');
				$kendaraan = $this->input->post('kendaraan');
				$no_kendaraan = $this->input->post('no_kendaraan');
				$kilometer_awal = $this->input->post('km_awal');
				$kilometer_akhir = $this->input->post('km_akhir');
				$price = $this->input->post('price');
				$total_beli = $this->input->post('total_beli');
				$no_kendaraan = $this->input->post('no_kendaraan');
				$receiver_item = $this->input->post('receiver_item');
				$harga_estimasi 	= $this->input->post('harga_estimasi');
				$harga_estimasi 	= str_replace(",","",$harga_estimasi);
				$harga_estimasi 	= str_replace(".","",$harga_estimasi);

				if($items =='bbm')
				{
					$name_item = $items;
				}
				elseif ($items =='lainnya') 
				{
					$name_item = $name_item;
				}


				$additems = array(
					'pr_id'	=> $pr_id,
					'vendor'	=> $vendor,
					'items'	=> $name_item,
					'qty'	=> $qty,
					'stock'	=> $stock,
					'mou'	=> $mou,
					'deadline' => $deadline,
					'priority' =>$priority,
					'date_created'	=> date('Y-m-d H:i:s'),
					'jenis'		=> $jns,
					'holder'	=>$holder,
					'published'	=>'0',
					'ptg_saldo' =>'2',
					'receiver' => $receiver_item,
					'harga_estimasi' => $harga_estimasi,
					);
				$this->db->insert('tbl_pr_vendor', $additems);
				$vendor_id = $this->db->insert_id();

				$this->uploadfile($pr_id, '3', $vendor_id,'','');  

				$sql ="SELECT * FROM tbl_purchasing WHERE id='pr_id'";
				$res = $this->db->query($sql)->row_array();
				$divisi = $res['divisi'];
				$cabang		= $_SESSION['myuser']['cabang'];
				$position_id = $_SESSION['myuser']['position_id'];


				if($items =='bbm')
				{
					$total_kilometer = $kilometer_akhir - $kilometer_awal;
					$rasio = $total_kilometer/($total_beli/$price);


					$ken = array
					(
						'vendor_id' => $vendor_id,
						'pr_id' => $pr_id,
						'kepemilikan' => $kendaraan,
						'kilometer_akhir' => $kilometer_akhir,
						'kilometer_awal'	=> $kilometer_awal,
						'price'=> $price,
						'total_beli' => $total_beli,
						'total_kilometer' => $total_kilometer,
						'rasio' => $rasio,
						'kendaraan_id' => $no_kendaraan,
						'user' => $_SESSION['myuser']['karyawan_id'],
						'date_created' => date('Y-m-d H:i:s'),

					);
					$this->db->insert('tbl_record_kendaraan_perusahaan', $ken);
					$record_id = $this->db->insert_id();

					$this->db->where('id',$vendor_id);
	            	$this->db->update('tbl_pr_vendor', array('level_approval' => 'Kadiv'));

					$sql="SELECT tl.id as id_tools,kend.id as kendaraan_id, tl.code,tl.name,tl.type,hld.user_holder,kend.kepemilikan,krw.nama as nama_holder,krw.position_id,
					 	  kend.kendaraan,kend.plat_nomer,lgn.nickname,kend.km_service FROM tbl_kar_kendaraan kend
				          LEFT JOIN tbl_tools tl ON tl.id = kend.tools_id
				          LEFT JOIN tbl_tools_holder hld ON hld.tool_id = tl.id
                          LEFT JOIN tbl_loginuser lgn ON lgn.karyawan_id = hld.user_holder
				        	  WHERE kend.id='$no_kendaraan'";
				    $res= $this->db->query($sql)->row_array();
				    $holder = $res['user_holder'];
				    $jenis_kendaraan = $res['kendaraan'];
				    $kepemilikan = $res['kepemilikan'];
				    $tools_id = $res['id_tools'];
				    $type 	  = $res['type'];
				    $plat_nomer = $res['plat_nomer'];
				    $kendaraan_id = $res['kendaraan_id'];
				    $km_serv = $res['km_service'];
					$nama_holder = $res['nama_holder'];
				    $position_id= $res['position_id'];
				

				    if($kepemilikan =='0')
				    {

				    	if($jenis_kendaraan == 'Mobil')
					    {

					    	$if = $this->if_mobil($kilometer_akhir,$km_serv);

					    	$description = $if['description'];
					    	$km_service	 = $if['km_service'];
					    	$putaran_km  = $if['ptrs_km'];
					    }
					    

					    if($jenis_kendaraan == 'Motor')
					    {
					    	$if = $this->if_motor($kilometer_akhir,$km_serv);

					    	$description = $if['description'];
					    	$km_service  = $if['km_service'];
					    	$putaran_km  = $if['ptrs_km'];

					    }

					    $this->db->where('id',$kendaraan_id);
	            		$this->db->update('tbl_kar_kendaraan', array('kilometer_akhir' => $kilometer_akhir,'km_service'=>$km_service,'putaran_km'=>$putaran_km));



	            		if(!empty($description))
	            		{ 

						    $sql = "SELECT id FROM tbl_wishlist ORDER BY id DESC LIMIT 1"; //baru ditambahkan
								        $count= $this->db->query($sql)->row_array();
								        $ar = $count['id'];
										$htng = $ar + 1;
								        $wid = $htng;
								        $date_reminder 	= date("Y-m-d", strtotime("+7 days"));

							$title 	= 'Service Kendaraan '.$plat_nomer;

							if(!empty($holder))
							{
								$holder = $holder;
							}else
							{
								$holder='2';
							}

							$sql ="SELECT hstr.*,lgn.nickname FROM tbl_history_service_kendaraan hstr
									LEFT JOIN tbl_loginuser lgn ON lgn.karyawan_id = hstr.user_service
									WHERE hstr.kendaraan_id='$kendaraan_id' ORDER BY id DESC LIMIT 1";
							$ser= $this->db->query($sql)->row_array();
							$desc1 = $ser['description'];

							if($desc1)
							{
								$des = $description."<br>
										history :<br>".
										$desc1."<br>".
										"oleh user ".$ser['nickname']."<br> pada KM ".$ser['kilometer_akhir'];
							}else
							{
								$des = $description;
							}
			       
										$add = array
										(
												'id'				=> $wid,
												'user'	 			=> '133',
												'date_created'		=> date('Y-m-d H:i:s'),
												'descriptions' 		=> $des,
												'wish_to'			=> $holder,
												'title'				=> $title,
												'date_reminder'		=> $date_reminder,
												'type_wishlist' 	=> '1',
												'interval_reminder' => '7',
												'kendaraan_id'		=> $kendaraan_id, // new
										);
										$this->db->insert('tbl_wishlist', $add);

										$ex = array(
											'wish_id' => $wid,
											'executor' => $holder,
											'date_created' => date('Y-m-d H:i:s'),
										);
										$this->db->insert('tbl_wish_executor',$ex);
										$ex_id = $this->db->insert_id();

										$isinotif = "You have New <b> Wishlist ID " .$wid."</b>[Service Kendaraan] from IIOS";
										
										$notif = array(
								            'modul' 		=> '7',
								            'modul_id' 		=> $wid,
								            'record_id' 	=> $holder,
								            'record_type' 	=> '1',
								            'user_id' 		=> $holder,
								            'date_created' 	=> date('Y-m-d H:i:s'),
								            'notes'			=> $isinotif,
								            'url'			=> 'wishlist/details/'.$wid,
							        	);
							    		$this->db->insert('tbl_notification', $notif);

										// $this->notification($wid, $wid,'1', $holder,$isinotif);

										$isinotif = "IIOS Add you as Executor In Wishlist ID ".$wid;
										$notif = array(
								            'modul' 		=> '7',
								            'modul_id' 		=> $wid,
								            'record_id' 	=> $ex_id,
								            'record_type' 	=> '4',
								            'user_id' 		=> $holder,
								            'date_created' 	=> date('Y-m-d H:i:s'),
								            'notes'			=> $isinotif,
								            'url'			=> 'wishlist/details/'.$wid,
							        	);
							    		$this->db->insert('tbl_notification', $notif);

							    		$sql="SELECT krw.*,krw1.nama,krw.id as leader_id  FROM tbl_karyawan krw 
							    			  LEFT JOIN tbl_karyawan krw1 ON krw.head_division = krw1.position_id
							    			  WHERE krw.id='$holder'";
							    		$lead = $this->db->query($sql)->row_array();
							    		$leader= $lead['leader_id'];

							    		$args = array(
						                    'wish_id'       => $wid,
						                    'contributor'   => $leader,
						                    'user_id'       => '133',
						                    'date_created'  => date('Y-m-d H:i:s'),
						                    );
						                $this->db->insert('tbl_wish_contributor', $args);
						                $con_id = $this->db->insert_id();
						}


				    }else
				    {
				    	$this->db->where('id',$kendaraan_id);
	            		$this->db->update('tbl_kar_kendaraan', array('kilometer_akhir' => $kilometer_akhir));
				    }


				    if($rasio < '7')
				    {

				    	$sql = "SELECT id FROM tbl_wishlist ORDER BY id DESC LIMIT 1"; //baru ditambahkan
						$count= $this->db->query($sql)->row_array();
						$ar = $count['id'];
						$htng = $ar + 1;
						$wid = $htng;
						$date_reminder 	= date("Y-m-d", strtotime("+7 days"));

						$title 	= 'Tindakan Cek Kendaraan '.$plat_nomer;
						$desc   = "Rasio Kendaraan ".$plat_nomer." sangat Rendah 1:".$rasio." Mohon segera melakukan pengecekan kendaraan tersebut";


						$sql="SELECT cabang FROM tbl_karyawan WHERE id='$holder'";
						$cb = $this->db->query($sql)->row_array();
						$cabang = $cb['cabang'];

						switch ($cabang) 
						{
							case 'Cikupa':
								 $leader='58';
							break;
							case 'Medan':
								 $leader ='56';
							break;
							case 'Surabaya':
								 $leader ='55';
							break;
							case 'Semarang':
								 $leader ='134';
							break;
							case 'Bandung':
								 $leader ='57';
							break;
							case 'Jakarta':
								 $leader ='2';
							break;	
						}
		       	
		       			$sql ="SELECT id FROM tbl_karyawan WHERE position_id='$leader'";
		       			$res= $this->db->query($sql)->row_array();
		       			$id_lead = $res['id'];

						$add = array
						(
							'id'				=> $wid,
							'user'	 			=> '133',
							'date_created'		=> date('Y-m-d H:i:s'),
							'descriptions' 		=> $desc,
							'wish_to'			=> $id_lead,
							'title'				=> $title,
							'date_reminder'		=> $date_reminder,
							'type_wishlist' 	=> '1',
							'interval_reminder' => '7',
						);
						$this->db->insert('tbl_wishlist', $add);

						$ex = array(
										'wish_id' => $wid,
										'executor' => $id_lead,
										'date_created' => date('Y-m-d H:i:s'),
						);
						$this->db->insert('tbl_wish_executor',$ex);
						$ex_id = $this->db->insert_id();

						$isinotif1 = "You have New <b> Wishlist ID " .$wid."</b>[Cek Kendaraan] from IIOS";

						$notif = array(
							        'modul' 		=> '7',
							        'modul_id' 		=> $wid,
							        'record_id' 	=> $wid,
							        'record_type' 	=> '1',
							        'user_id' 		=> $holder,
							        'date_created' 	=> date('Y-m-d H:i:s'),
							       	'notes'			=> $isinotif,
							        'url'			=> 'wishlist/details/'.$wid,
						);
						$this->db->insert('tbl_notification', $notif);

						$isinotif = "IIOS Add you as Executor In Wishlist ID ".$wid;
						$notif = array(
							        'modul' 		=> '7',
							        'modul_id' 		=> $wid,
							        'record_id' 	=> $ex_id,
							        'record_type' 	=> '4',
							        'user_id' 		=> $id_lead,
							        'date_created' 	=> date('Y-m-d H:i:s'),
							       	'notes'			=> $isinotif,
							        'url'			=> 'wishlist/details/'.$wid,
						);
						$this->db->insert('tbl_notification', $notif);
				    }

				   


				}

	            // if(in_array($position_id, array('55', '56', '57', '58'))) //kacab bikin pr
	            // { //dilocal pipit tidak dicomment. disini kenapa di comment ya ?
	            //     if($divisi != '') 
	            //     {
	            //         $this->db->where('id',$vendor_id);
	            //         $this->db->update('tbl_pr_vendor', array('level_approval' => 'Kadiv'));
	            //     }elseif($divisi =='')
	            //     {	
	            //     	$this->db->where('id',$vendor_id);
	            //         $this->db->update('tbl_pr_vendor', array('level_approval' => 'Dir'));
	            //     }
	            // }
	           
			}
		}

		

		// public function addPRItems($pr_id)
		// {
		// 	if($this->input->post())
		// 	{
		// 		$pr_id 		= $this->input->post('pr_id');
		// 		$qty 		= $this->input->post('qty');
		// 		$stock		= $this->input->post('stock');
		// 		$vendor		= $this->input->post('vendor');
		// 		$items 		= $this->input->post('items');
		// 		$mou 		= $this->input->post('mou');
		// 		$priority	= $this->input->post('priority');
		// 		$deadline 	= $this->input->post('deadline');
		// 		$deadline 	= preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $deadline);
		// 		$jns 		= $this->input->post('jns_pembelian');
		// 		$holder 		= $this->input->post('holder');


		// 		$additems = array(
		// 			'pr_id'	=> $pr_id,
		// 			'vendor'	=> $vendor,
		// 			'items'	=> $items,
		// 			'qty'	=> $qty,
		// 			'stock'	=> $stock,
		// 			'mou'	=> $mou,
		// 			'deadline' => $deadline,
		// 			'priority' =>$priority,
		// 			'date_created'	=> date('Y-m-d H:i:s'),
		// 			'jenis'		=> $jns,
		// 			'holder'	=>$holder,
		// 			'published'	=>'0',
		// 			);
		// 		$this->db->insert('tbl_pr_vendor', $additems);
		// 		$vendor_id = $this->db->insert_id();

		// 		$this->uploadfile($pr_id, '3', $vendor_id,'','');   
				
		// 	}
		// }

		/*public function SavePR()
		{
			if($this->input->post('overto'))
			{
				$overto = $this->input->post('overto');
				$overto_type = $this->input->post('overtotype');
				$pesan = $this->input->post('message');
				$pr_id = $this->input->post('pr_id');
				$sess = $_SESSION['myuser'];
				$kar_id = $_SESSION['myuser']['karyawan_id'];
				$cabang = $_SESSION['myuser']['cabang'];
				$pos_id = $_SESSION['myuser']['position_id'];

				$ov = array(
					'pr_id'			=> $pr_id,
					'user_id'		=> $kar_id,
					'overto'		=> $overto,
					'overto_type'	=> $overto_type,
					'date_created'	=> date('Y-m-d H:i:s'),
				);
				$this->db->insert('tbl_pr_overto', $ov);

				$logpr = $this->AddLogPR($pr_id, $kar_id);

				$addpsn = array(
					'pr_id' => $pr_id,
					'log_pr_id'	=> $logpr,
					'sender' => $kar_id,
					'pesan'	=> $pesan,
					'date_created'	=> date('Y-m-d H:i:s'),
					);
				$this->db->insert('tbl_pr_pesan', $addpsn);

				if(in_array($sess['position_id'], array('1','2','77'))) {
          			// no need approval
          		}elseif(in_array($sess['position_id'], array('55', '56', '57', '58', '59', '88', '89', '90', '91', '92', '93', '100','83'))) { //need approval director
		         // $this->notification($pr_id, '', '13', '1');
		          $this->notification($pr_id, '', '13', '2');
		          $this->notification($pr_id, '', '13', '3');

				}else {

					if($sess['cabang'] == 'Medan') {
		              $pos = '56';
		            }elseif($sess['cabang'] == 'Surabaya') {
		              $pos = '95';
		            }elseif ($sess['cabang'] == 'Bandung') {
		              $pos = '57';
		            }elseif ($sess['cabang'] == 'Cikupa') {
		              $pos = '58';
		            }elseif (in_array($sess['position_id'], array('5','7','8','9','11','12','76'))) {
		              $pos = '77';
		            }elseif ($sales == 'Sales' AND $sess['cabang'] == '') {
		              $leader = 'Leader Sales '.$div;
		              $sql = "SELECT id FROM tbl_position WHERE position like '%$leader%'";
		              $pos = $this->db->query($sql)->row_array();
		              $pos = $pos['id'];
		            }else {
		              $pos = '2';
		            }
		              $sql = "SELECT lg.karyawan_id FROM tbl_loginuser lg LEFT JOIN tbl_karyawan kr ON kr.id = lg.karyawan_id WHERE kr.position_id = '$pos' AND lg.published = 1 AND kr.published = 1";
		              $kar = $this->db->query($sql)->row_array();
		              $kar = $kar['karyawan_id'];

		              //$sql = "INSERT INTO tbl_tools_approval (tool_id, user_create, user_approval, date_created)
		              //        VALUES ('$id_tool', '$holder', '$kar', '$date')";
		              //$appr = $this->db->query($sql);
		              //$id_appr = $this->db->insert_id();
		            if($pos == 2) {
		            	$this->notification($pr_id, '', '13', '3');
		            	$this->notification($pr_id, '', '13', $kar);
		            }elseif($pos == 77) {
		            	$this->notification($pr_id, '', '13', '2');
		            	$this->notification($pr_id, '', '13', $kar);
		            }else {
		            	$this->notification($pr_id, '', '13', '2');
		            	$this->notification($pr_id, '', '13', '3');
              			$this->notification($pr_id, '', '13', $kar);
		            }
		            //$this->notification($pr_id, '', '13', '1');
				}
			}
		}*/

		public function UpStatus($type,$id)
		{
			$position = $_SESSION['myuser']['position_id'];
			$apr = $this->getNextTo($id);
			$getpr = $this->DetailsPR($id);
			$sales = $getpr['sales_id'];
			$divisi = $getpr['divisi'];
			$level = $getpr['level_approval'];
			$cbg = $getpr['cabang'];
			$pos_user = $getpr['position_id'];
			$ov = $apr['overto'];
			$url        = $this->mdata->getUrl();

			$sql = "SELECT nickname FROM tbl_loginuser WHERE karyawan_id = $ov";
			$que = $this->db->query($sql)->row_array();
			$ov_nick = $que['nickname'];

			switch ($divisi) 
			{
                case 'DCE':
                    $kadiv = '90';
                    break;
                case 'DGM':
                    $kadiv = '90';
                    break;
                case 'DEE':
                    $kadiv = '93'; 
                    break;
                case 'DGC':
                    $kadiv = '90';
                    break;        
                case 'DHC':
                    $kadiv = '88'; 
                    break;
                case 'DHE':
                    $kadiv = '91'; 
                    break;
                case 'DRE':
                    $kadiv = '89'; 
                    break;
                case 'HORECA':
                    $kadiv = '89'; 
                    break;
                case 'DIR':
                    $kadiv = '89'; 
                    break;
                case 'DWT':
                    $kadiv = '91'; //100
                    break;

                 case 'DPP':
                    $kadiv = '91'; //100
                    break;

                case 'DMS':
                    $kadiv = '149'; //100
                    break;                     
            }

            switch ($cbg) 
            {
                case 'Bandung':
                    $kacab = '57';
                    break;
                case 'Medan':
                    $kacab = '56';
                    break;
                case 'Surabaya':
                    $kacab = '55';
                    break;        
                case 'Cikupa':
                    $kacab = '58';
                    break;
                case 'Semarang': // WL 41282
                    $kacab = '134';
                    break;    
                default:
                    $kacab = '0';                   
                    break;
            }

           switch ($pos_user) 
           {
           	case '102':
           		$leader = '13';
           		break;
           	case '127':
           		$leader = '13';
           		break; // baru pipit 13012020
           }


			if(in_array($position, array('1','2','77','106')))
			{
				
				$arr = array(
					'pr_id'	=> $id,
					'date_created'	=> date("Y-m-d H:i:s"),
					'date_approval'	=> date("Y-m-d H:i:s"),
					'user_approval'	=> $_SESSION['myuser']['karyawan_id'],
					'status_approval'	=> '3',
					);
				$this->db->insert('tbl_pr_approval', $arr);

				$this->db->where('id', $id);
				$this->db->update('tbl_purchasing', array('status' => $ov_nick, 'level_approval' => 'Dir'));

				$this->AddLogPR($id, $ov);

				$isinotif 	= "<b>PR ID ".$id."</b> over to you";

				$this->notification($id, $apr['id'], '1', $ov,$isinotif);

				$sql = "UPDATE tbl_notification SET status = '1' WHERE modul = '5' AND modul_id = '$id'AND status = '0'";
				$this->db->query($sql);

					//logAll
			}elseif($type == '1') 
			{	
				$isinotif 	= " <b> PR ID ".$id."</b> Need to be Approved";

				if($divisi AND empty($level) AND $cbg != 'Jakarta' AND !in_array($pos_user, array('55','56', '57', '58', '95','134'))) { //staff cabang pilih divisi // WL 42182
					

					if($cbg =='Surabaya')
					{
						$this->db->where('id', $id);
						$this->db->update('tbl_purchasing', array('level_approval' => 'Kadiv', 'status' => 'Waiting for Director Approval'));

						$this->auto_acc($id);
						
						$this->newNotification($id, $id, '13', '2',$isinotif);

					}else
					{
						
						$this->db->where('id', $id);
						$this->db->update('tbl_purchasing', array('level_approval' => 'Kacab', 'status' => 'Waiting for Kadiv Approval'));
						
						$this->newNotification($id, $id, '13', $kadiv,$isinotif);
					}
					
				}elseif($divisi AND empty($level) AND $cbg != 'Jakarta') { // kacab pilih divisi // new 251119
				
					$this->db->where('id', $id);
					$this->db->update('tbl_purchasing', array('level_approval' => 'Kadiv', 'status' => 'Waiting for Director Approval'));

					$this->auto_acc($id);
					
					$this->newNotification($id, $id, '13', '2',$isinotif);

				}elseif($divisi AND $level == 'Kacab') { //staff cabang pilih divisi dan sudah appr kacab
					
					$this->db->where('id', $id);
					$this->db->update('tbl_purchasing', array('level_approval' => 'Kadiv', 'status' => 'Waiting for Director Approval'));

					$this->auto_acc($id);
					
					$this->newNotification($id, $id, '13', '2',$isinotif);

				}elseif(empty($level) AND $cbg != 'Jakarta') { //staff cabang tidak pilih divisi // new 251119
					
					$this->db->where('id', $id);
					$this->db->update('tbl_purchasing', array('level_approval' => 'Kacab', 'status' => 'Waiting for Director Approval'));

					$this->auto_acc($id);
					
					$this->newNotification($id, $id, '13', '2',$isinotif);

				}elseif(empty($level) AND $cbg == 'Jakarta' AND in_array($pos_user, array('65','66','67','68','71','103','102','127'))) { //sales jakarta // baru pipit 13012020
					// new 251119
					$this->db->where('id', $id);
					$this->db->update('tbl_purchasing', array('level_approval' => 'Kadiv', 'status' => 'Waiting for Director Approval'));

					$this->auto_acc($id);
					
					$this->newNotification($id, $id, '13', '2',$isinotif);

				}elseif(empty($level) AND $cbg == 'Jakarta' AND $divisi) { //staff jakarta pilih divisi // new 251119
                    
                    $this->db->where('id', $id);
					$this->db->update('tbl_purchasing', array('level_approval' => 'Kadiv', 'status' => 'Waiting for Director Approval'));

					$this->newNotification($id, $id, '13', '2', $isinotif);

				}elseif(empty($level) AND $cbg == 'Jakarta') { //appr staff jkt. 
                  
                    $this->db->where('id', $id);
					$this->db->update('tbl_purchasing', array('level_approval' => 'Dir', 'status' => $ov_nick));	
					
                }elseif($level == 'Kadiv' OR (empty($divisi) AND $level == 'Kacab')) {
                   
                    $this->db->where('id', $id);
					$this->db->update('tbl_purchasing', array('level_approval' => 'Dir', 'status' => $ov_nick));
                }    

				$arr = array(
					'pr_id'	=> $id,
					'date_created'	=> date("Y-m-d H:i:s"),
					'date_approval'	=> date("Y-m-d H:i:s"),
					'user_approval'	=> $_SESSION['myuser']['karyawan_id'],
					'status_approval'	=> '1',
					);
				$this->db->insert('tbl_pr_approval', $arr);
				$newapr = $this->db->insert_id();
					//notification approved ke sales_id dan direktur

					//logAll
			}

			$sql = "SELECT id FROM tbl_pr_log WHERE pr_id = $id ORDER BY id DESC LIMIT 1";
			$que = $this->db->query($sql)->row_array();
			$log_pr = $que['id'];

			$addpsn = array(
				'pr_id' => $id,
				'log_pr_id'	=> $log_pr,
				'sender' => $_SESSION['myuser']['karyawan_id'],
				'pesan'	=> '<b>PR </b><b style="color:green;">Approved</b>',
				'date_created'	=> date('Y-m-d H:i:s'), 
				);
			$this->db->insert('tbl_pr_pesan', $addpsn);

			$this->notif_ilang($id,'13');
		}

		public function auto_acc($id)
		{
			$sql ="SELECT * FROM tbl_purchasing WHERE id='$id'";
			$value =$this->db->query($sql)->row_array();

			$pr_id 			= $value['id'];
			$random_value 	= $value['random_value'];

			$sql = "SELECT SUM(harga_beli) as total_harga  FROM tbl_pr_vendor WHERE pr_id='$pr_id'";
			$res      = $this->db->query($sql)->row_array();

			if(!empty($res['total_harga']))
			{
				$total = $res['total_harga']-'1';
				$total1 = $res['total_harga'];

				$sql = "SELECT tr.* FROM tbl_auto_acc acc 
							LEFT JOIN tbl_auto_acc_term tr ON tr.auto_acc_id = acc.id 
							WHERE acc.acc_type='5' AND '$total' BETWEEN coalesce(`dari`,'$total') 
							AND coalesce(`sampai`,'$total') AND published='0'";
				$res1      = $this->db->query($sql)->row_array();
				$acc_rate = $res1['acc_rate'];
				$auto_acc_id = $res1['auto_acc_id'];

				if($random_value >= $acc_rate)
				{
					
					$sql 	= "SELECT ov.*,lgn.nickname FROM tbl_pr_overto ov
												LEFT JOIN tbl_loginuser lgn ON lgn.karyawan_id = ov.overto
												WHERE ov.pr_id = '$pr_id'";
					$apr      	= $this->db->query($sql)->row_array();
					$ov 		= $apr['user_id'];
					$ov_nick 	= $apr['nickname'];

					$arr = array(
								'pr_id'=> $pr_id,
								'date_created'=> date('Y-m-d H:i:s'),
								'date_approval'=> date('Y-m-d H:i:s'),
			                    'user_approval'=>'2',
			                    'status_approval'=>'3'
			        );
					$this->db->insert('tbl_pr_approval',$arr);

					$this->db->where('id', $pr_id);
				    $this->db->update('tbl_purchasing', array('status' => $ov_nick, 'level_approval' => 'Dir'))
				    ;

				    $arry = array(
				    	'auto_acc_id'=>$auto_acc_id,
				    	'doc_id'=>$pr_id,
				    	'value'=>$total1,
				    	'random_value'=>$random_value,
				    	'date_created'=>date('Y-m-d H:i:s'),
				    	'status_generate'=>'Auto'
				    );
				    $this->db->insert('tbl_auto_acc_generate', $arry);

				    $sql = "SELECT id FROM tbl_pr_log WHERE pr_id = $id ORDER BY id DESC LIMIT 1";
					$que = $this->db->query($sql)->row_array();
					$log_pr = $que['id'];

				    $addpsn = array(
						'pr_id' => $pr_id,
						'log_pr_id'	=> $log_pr,
						'sender' => '2',
						'pesan'	=> '<b>PR </b><b style="color:green;">Approved</b>',
						'date_created'	=> date('Y-m-d H:i:s'), 
						);
					$this->db->insert('tbl_pr_pesan', $addpsn);

					// $this->notif_ilang($pr_id,'13');

					
				}
				else
				{
					$arry = array('auto_acc_id'=>$auto_acc_id,
				    	'doc_id'=>$pr_id,
				    	'value'=>$total1,
				    	'random_value'=>$random_value,
				    	'date_created'=>date('Y-m-d H:i:s'),
				    	'status_generate'=>'Manual'
				    );
				    $this->db->insert('tbl_auto_acc_generate', $arry);
					
				}
			}


		}

		public function UpStatusNotAppr()
		{
			if($this->input->post())
			{
				$id 	= $this->input->post('pr_id');
				$apr 	= $this->getNextTo($id);
				$getpr 	= $this->DetailsPR($id);
				$sales 	= $getpr['sales_id'];
				$divisi = $getpr['divisi'];
				$level 	= $getpr['level_approval'];
				$cbg 	= $getpr['cabang'];
				$nick 	= $grtpr['nickname'];
				$type 	= $this->input->post('not');
				
				$arr = array(
					'pr_id'	=> $id,
					'date_created'	=> date("Y-m-d H:i:s"),
					'date_approval'	=> date("Y-m-d H:i:s"),
					'user_approval'	=> $_SESSION['myuser']['karyawan_id'],
					'status_approval'	=> $type,
					'alasan'		=> $this->input->post('notes'),
					);
				$this->db->insert('tbl_pr_approval', $arr);
				$newapr = $this->db->insert_id();
				
				if($type == '4') {
					

				$this->db->where('id', $id);
				$this->db->update('tbl_purchasing', array('status' => $nick, 'level_approval' => 'Dir'));

				//notification approved ke sales_id dan direktur
				//logAll
					

				}elseif ($type == '2') {

				if($divisi AND empty($level) AND $cbg != 'Jakarta') { // new 251119
					$this->db->where('id', $id);
					$this->db->update('tbl_purchasing', array('level_approval' => 'Kacab'));
				}elseif($divisi AND $level == 'Kacab') {
					$this->db->where('id', $id);
					$this->db->update('tbl_purchasing', array('level_approval' => 'Kadiv'));
				}elseif(empty($level) AND $cbg != 'Jakarta') { // new 251119
					$this->db->where('id', $id);
					$this->db->update('tbl_purchasing', array('level_approval' => 'Kacab'));
				}elseif(empty($level) AND $cbg == 'Jakarta') { // new 251119
					$this->db->where('id', $id);
					$this->db->update('tbl_purchasing', array('level_approval' => 'Kadiv'));
				}

				//notification approved ke sales_id dan direktur
				//logAll
				}

				$sql = "SELECT id FROM tbl_pr_log WHERE pr_id = $id ORDER BY id DESC LIMIT 1";
				$que = $this->db->query($sql)->row_array();
				$log_pr = $que['id'];

				$addpsn = array(
					'pr_id' => $id,
					'log_pr_id'	=> $log_pr,
					'sender' => $_SESSION['myuser']['karyawan_id'],
					'pesan'	=> '<b>PR</b> <b style="color:red;">Not Approved.</b><br><b>Alasan : </b>'.$this->input->post('notes'),
					'date_created'	=> date('Y-m-d H:i:s'), 
					);
				$this->db->insert('tbl_pr_pesan', $addpsn);
				$pesan_id = $this->db->insert_id();

				$sql = "SELECT ptg_saldo, user_receive, level_approval, SUM(harga_beli) as harga_beli FROM tbl_pr_vendor WHERE pr_id = $id AND ptg_saldo = '1' GROUP BY user_receive";
				$res = $this->db->query($sql)->result_array();

            	foreach ($res as $key => $val) {
            		$ptg_saldo 		= $val['ptg_saldo'];
					$level 			= $val['level_approval'];
	            	$user_receive 	= $val['user_receive'];
	            	$harga_beli 	= $val['harga_beli'];

	            if($harga_beli > 0)
				{
						$sql = " SELECT id, interval_reminder, balance FROM tbl_kasbon_cash WHERE karyawan_id ='$user_receive'";
					    $row = $this->db->query($sql)->row_array();

					    $kasbon_id 			= $row['id'];
					    $interval_reminder  = $row['interval_reminder'];
					    $balance 			= $row['balance'];

			           
			            $selisih = str_replace("-", "", $harga_beli);
			            $balance = $balance + $harga_beli;
			            $arr = "credit";

				        $this->db->where('id', $kasbon_id);
			            $this->db->update('tbl_kasbon_cash', array('last_update'=> date('Y-m-d H:i:s'),'balance'=>$balance));

			            $ket = "Saldo pada PR ID ".$id." dikembalikan, karena PR ditolak.";
			            $this->selisih($user_receive,$kasbon_id,$selisih,$balance,$id,$arr,$ket);
					}
            	}
				
				$this->finished($id);

				$this->notif_ilang($id,'13');
				
				return $id;
			}
		}


		/*public function UpStatusss($type, $id)
		{
			$position = $_SESSION['myuser']['position_id'];
			$apr = $this->getNextTo($id);
			$sales = $this->getPR();
			$sales = $sales['sales_id'];
			$ov = $apr['overto'];
			
			if (in_array($position, array('1','2','77')))
			{
				$arr = array(
					'pr_id'	=> $id,
					'date_created'	=> date("Y-m-d H:i:s"),
					'date_approval'	=> date("Y-m-d H:i:s"),
					'user_approval'	=> $_SESSION['myuser']['karyawan_id'],
					'status_approval'	=> '3',
					);
				$this->db->insert('tbl_pr_approval', $arr);

				$this->db->where('id', $id);
				$this->db->update('tbl_purchasing', array('status' => $ov));

				$this->AddLogPR($id, $ov);

				$this->notification($id, $apr['id'], '1', $ov);

					//logAll
			}elseif($type == '1') {
				$arr = array(
					'pr_id'	=> $id,
					'date_created'	=> date("Y-m-d H:i:s"),
					'date_approval'	=> date("Y-m-d H:i:s"),
					'user_approval'	=> $_SESSION['myuser']['karyawan_id'],
					'status_approval'	=> '1',
					);
				$this->db->insert('tbl_pr_approval', $arr);
				$newapr = $this->db->insert_id();
					//notification approved ke sales_id dan direktur

					//logAll
			}
		}

		public function UpStatusNotApprrrr()
		{
			if($this->input->post())
			{
				$id = $this->input->post('pr_id');
				$apr = $this->getNextTo($id);

				$sales = $this->getPR();
				$sales = $sales['sales_id'];
				$ov = $apr['0']['overto'];
				$type = $this->input->post('not');

				if($type == '4') {
					$arr = array(
					'pr_id'	=> $id,
					'date_created'	=> date("Y-m-d H:i:s"),
					'date_approval'	=> date("Y-m-d H:i:s"),
					'user_approval'	=> $_SESSION['myuser']['karyawan_id'],
					'status_approval'	=> $type,
					'alasan'		=> $this->input->post('notes'),
					);
				$this->db->insert('tbl_pr_approval', $arr);
				$newapr = $this->db->insert_id();

				$this->db->where('id', $id);
				$this->db->update('tbl_purchasing', array('status' => $sales));

				//notification approved ke sales_id dan direktur
				//logAll
				}elseif ($type == '2') {
					$arr = array(
					'pr_id'	=> $id,
					'date_created'	=> date("Y-m-d H:i:s"),
					'date_approval'	=> date("Y-m-d H:i:s"),
					'user_approval'	=> $_SESSION['myuser']['karyawan_id'],
					'status_approval'	=> $type,
					'alasan'		=> $this->input->post('notes'),
					);
				$this->db->insert('tbl_pr_approval', $arr);
				$newapr = $this->db->insert_id();

				//notification approved ke sales_id dan direktur
				//logAll
				}

			}
		}*/

		public function overTo()
		{
			if($this->input->post())
	    	{
				$karyawanID   = $this->input->post('karyawan');
				$message      = $this->input->post('message');
				$pr_id        = $this->input->post('pr_id');
				$overto_type  = $this->input->post('overto_type');
				$user_id      = $_SESSION['myuser']['karyawan_id'];

				$sql = "SELECT nickname FROM tbl_loginuser WHERE karyawan_id = '$karyawanID'";
				$result = $this->db->query($sql)->row_array();
				$nickname = $result['nickname'];

			    $updatepr = array(
			    	'status'  => $nickname,
			    );
				$this->db->where('id', $pr_id);
				$this->db->update('tbl_purchasing', $updatepr);

				$simpan_overto = array(
					'pr_id'			=> $pr_id,
					'user_id' 		=> $user_id,
					'overto' 		=> $karyawanID,
					'overto_type' 	=> $overto_type,
					'date_created'  => date('Y-m-d H:i:s'),
				);
				$this->db->insert('tbl_pr_overto', $simpan_overto);
				$overto_id = $this->db->insert_id();

				$url 		= $this->mdata->getUrl();
				$isinotif 	= "<b> PR ID ".$pr_id."</b> over to you";

				$this->notification($pr_id, $overto_id, '1', $karyawanID,$isinotif);

				//$this->logAll($do_id, $desc='1', $overto_id, $ket='tbl_multi_overto');

	      		$this->uploadfile($pr_id, '1', '0','','');

	      		$newlog = $this->AddLogPR($pr_id, $karyawanID);
				
				//$this->logAll($do_id, $desc='1', $logid, $ket='tbl_do_log');

				

				if($message == '') {
					$pesan = array(
					  'pr_id'      	 => $pr_id,
					  'log_pr_id'	 => $newlog,
					  'sender'    => $user_id,
					  'pesan'        =>'Next To '.$nickname.', harap segera ditanggapi untuk proses selanjutnya agar cepat selesai.',
					  'date_created' => date('Y-m-d H:i:s'),
					  );
				}else {
					$pesan = array(
					  'pr_id'       => $pr_id,
					  'log_pr_id'   => $newlog,
					  'sender'     => $user_id,
					  'pesan'         => $message,
					  'date_created'  => date('Y-m-d H:i:s'),
					  );
					}
				$this->db->insert('tbl_pr_pesan', $pesan);
				$pesanid = $this->db->insert_id();

				$isinotif 	= "<b>PR ID ".$pr_id."</b> : ".$_SESSION['myuser']['nickname']." Add New Message";
				$this->notification($pr_id, $pesanid, '2', '',$isinotif);
				//$this->logAll($do_id, $desc='1', $pesanid, $ket='tbl_multi_pesan');
	    	}
		}

		public function add_pesan($id)
		{
			$pesan = $this->input->post('msg');

			$sql 	= "SELECT id FROM tbl_pr_log WHERE pr_id = $id ORDER BY id DESC LIMIT 1";
			$que 	= $this->db->query($sql)->row_array();
			$log_pr = $que['id'];
			$url 	= $this->mdata->getUrl();

			$addpsn = array(
					'pr_id' => $id,
					'log_pr_id'	=> $log_pr,
					'sender' => $_SESSION['myuser']['karyawan_id'],
					'pesan'	=> $pesan,
					'date_created'	=> date('Y-m-d H:i:s'),
					);
				$this->db->insert('tbl_pr_pesan', $addpsn);
				$pesan_id = $this->db->insert_id();

			$this->last_update($id);

			$sql="SELECT date_deadline FROM tbl_purchasing
				  WHERE id='$id'";
			$res = $this->db->query($sql)->row_array();

			$deadline= $res['date_deadline'];
			$today= date('Y-m-d');

			if($deadline <= $today)
			{
				$this->three_days($id);
			}

			$isinotif 	= "<b>PR ID ".$id." </b> : ".$_SESSION['myuser']['nickname']." Add New Message.";

			$this->notification($id, $pesan_id, '2', '',$isinotif);

		}

		public function AddLogPR($id, $emp)
		{
			$sql  = "SELECT * FROM tbl_pr_log WHERE pr_id = '$id' ORDER BY id DESC LIMIT 2";
			$query = $this->db->query($sql);
			$num_rows = $query->num_rows();
			$res = $query->result_array();
			$kar_id = $_SESSION['myuser']['karyawan_id'];

			if($num_rows == '0')
			{
				$log = array(
					'pr_id' => $id,
					'id_operator'	=> $_SESSION['myuser']['karyawan_id'],
					'date_created'	=> date('Y-m-d H:i:s'),
					);
				$this->db->insert('tbl_pr_log', $log);
				$newlog = $this->db->insert_id();

				return $newlog;

				
			}elseif($num_rows == '1') {
				$idlog0 = $res['0']['id'];

				$uplog = array(
					'pr_id' => $id,
					'overto'	=> $emp,
					'time_nextto'	=> date('Y-m-d H:i:s'),
					);
				$this->db->where('id', $idlog0);
				$this->db->update('tbl_pr_log', $uplog);

				$log = array(
					'pr_id' => $id,
					'id_operator'	=> $emp,
					'date_created'	=> date('Y-m-d H:i:s'),
					);
				$this->db->insert('tbl_pr_log', $log);
				$newlog = $this->db->insert_id();

				return $newlog;


				//notification approve ke kadiv / kacab dan direktur
				//logAll
			}elseif($num_rows >= '2') 
			{
				$log0 = $res['0'];
				$log1 = $res['1'];

				if($log0['id_operator'] == $kar_id AND $log1['time_login'] == '0000-00-00 00:00:00' AND $log1['time_nextto'] != '0000-00-00 00:00:00')
				{
					$uplog1 = array(
						'time_login'	=> date('Y-m-d H:i:s'),
						'time_idle'	=> date('Y-m-d H:i:s'),
						);
					$this->db->where('id', $log1['id']);
					$this->db->update('tbl_pr_log', $uplog1);

					$uplog = array(
						'overto'	=> $emp,
						'time_nextto'	=> date('Y-m-d H:i:s'),
						);
					$this->db->where('id', $log0['id']);
					$this->db->update('tbl_pr_log', $uplog);

					$log = array(
						'pr_id' => $id,
						'id_operator'	=> $emp,
						'date_created'	=> date('Y-m-d H:i:s'),
						);
					$this->db->insert('tbl_pr_log', $log);
					$newlog = $this->db->insert_id();

					return $newlog;
					//notification approve ke id_operator newlog
				//logAll

				}elseif ($log0['id_operator'] == $kar_id AND $log1['time_login'] != '0000-00-00 00:00:00' AND $log1['time_nextto'] != '0000-00-00 00:00:00') {

					$uplog = array(
						'overto'	=> $emp,
						'time_nextto'	=> date('Y-m-d H:i:s'),
						);
					$this->db->where('id', $log0['id']);
					$this->db->update('tbl_pr_log', $uplog);

					$log = array(
						'pr_id' => $id,
						'id_operator'	=> $emp,
						'date_created'	=> date('Y-m-d H:i:s'),
						);
					$this->db->insert('tbl_pr_log', $log);
					$newlog = $this->db->insert_id();

					return $newlog;

				}elseif($log0['id_operator'] != $kar_id AND $log1['time_login'] == '0000-00-00 00:00:00' AND $log1['time_nextto'] != '0000-00-00 00:00:00') { 

					$update = array(
						'time_login'	=> date('Y-m-d H:i:s'),
						'time_idle'		=> date('Y-m-d H:i:s'),
					);
					$this->db->where('id', $log1['id']);
					$this->db->update('tbl_pr_log', $update);

					$update = array(
						'time_login'	=> date('Y-m-d H:i:s'),
						'time_idle'		=> date('Y-m-d H:i:s'),
						'overto'		=> $kar_id,
					);
					$this->db->where('id', $log0['id']);
					$this->db->update('tbl_pr_log', $update);

					$arr = array(
						'pr_id'		=> $id,
						'id_operator'	=> $kar_id,
						'date_created'	=> date('Y-m-d H:i:s'),
						'time_nextto'	=> date('Y-m-d H:i:s'),
						'overto'		=> $emp,
					);
					$this->db->insert('tbl_pr_log', $arr);

					$arr = array(
						'pr_id'		=> $id,
						'id_operator'	=> $emp,
						'date_created'	=> date('Y-m-d H:i:s'),
					);
					$this->db->insert('tbl_pr_log', $arr);
					$newlog = $this->db->insert_id();

					return $newlog;

					//notification approve ke id_operator newlog
					//logAll

				}elseif($log0['id_operator'] != $kar_id AND $log1['time_login'] != '0000-00-00 00:00:00' AND $log1['time_nextto'] != '0000-00-00 00:00:00') { 

					$update = array(
						'time_login'	=> date('Y-m-d H:i:s'),
						'time_idle'		=> date('Y-m-d H:i:s'),
						'overto'		=> $kar_id,
					);
					$this->db->where('id', $log0['id']);
					$this->db->update('tbl_pr_log', $update);

					$arr = array(
						'pr_id'		=> $id,
						'id_operator'	=> $kar_id,
						'date_created'	=> date('Y-m-d H:i:s'),
						'time_nextto'	=> date('Y-m-d H:i:s'),
						'overto'		=> $emp,
						);
					$this->db->insert('tbl_pr_log', $arr);

					$arr = array(
						'pr_id'		=> $id,
						'id_operator'	=> $emp,
						'date_created'	=> date('Y-m-d H:i:s'),
						);
					$this->db->insert('tbl_pr_log', $arr);
					$newlog = $this->db->insert_id();

					return $newlog;

					//notification approve ke id_operator newlog
					//logAll
				}
			}
		}

		// $this->uploadfile($pr_id, '3', $vendor_id,'','');  
		public function uploadfile($type_id, $type, $sub_id, $isinotif, $url)
  		{

  			if($isinotif =='' AND $url=='')
  			{

  				$url = $this->mdata->getUrl();
  				$isinotif = $_SESSION['myuser']['nickname']." Add New File in <b>PR ID ". $type_id."</b>";
  			}

		    if($_FILES)
		    {

				$uploaddir = 'assets/images/upload_pr';

				foreach ($_FILES['filepr']['name'] as $key => $value)
				{
					$temp_file_location = $_FILES['filepr']['tmp_name'][$key];
					
					$upload = $this->fileupload->filehandling($uploaddir,$temp_file_location,$value);

					if ($upload[0] == 'Success')
					{
						$file_name = $upload[1];

						$file_upload = array(
							'pr_id'         => $type_id,
							'sub_id'		=> $sub_id,
							'file_name'     => $file_name,
							'uploader'      => $_SESSION['myuser']['karyawan_id'],
							'date_created'  => date('Y-m-d H:i:s'),
							'type'			=> $type,
						);
						$this->db->insert('tbl_upload_pr', $file_upload);
						$upl_id = $this->db->insert_id();

						$refunds = $this->getRefund($type_id);

						if($refunds)
						{	
							foreach($refunds as $ref)
							{	
								$refund_id = $ref['refund_id'];

								$file_link = '<a href="'.$file_url.$uploaddir.'/'.$file_name.'" target="_blank">'.$file_name.'</a>';

								$message = "Mengupload file ".$file_link;
								//INSERT LOG ACTIVITY
		                        $insert_log = array(
		                               'refund_id'          => $refund_id,
		                                'log_type'          => 'Upload File',
		                                'user'              => $_SESSION['myuser']['karyawan_id'],
		                                'message'           => $message,
		                                'need_approval'     => 'no',
		                                'created'           => date('Y-m-d H:i:s'),
		                        );
		                        $this->db->insert('tbl_refund_log',$insert_log); 

		                    }
						}


						$sql = "SELECT id FROM tbl_pr_log WHERE pr_id = $type_id ORDER BY id DESC LIMIT 1";
						$que = $this->db->query($sql)->row_array();
						$log_pr = $que['id'];

						if($type!='2')
						{

							$addpsn = array(
								'pr_id' => $type_id,
								'log_pr_id'	=> $log_pr,
								'sender' => $_SESSION['myuser']['karyawan_id'],
								'pesan'	=> $file_name,
								'psn_type'	=> '1',
								'date_created'	=> date('Y-m-d H:i:s'),
								);
							$this->db->insert('tbl_pr_pesan', $addpsn);
						}

						$this->last_update($type_id);

						$sql="SELECT date_deadline FROM tbl_purchasing
							  WHERE id='$type_id'";
						$res = $this->db->query($sql)->row_array();

						$deadline= $res['date_deadline'];
						$today = date('Y-m-d');

						if($deadline <= $today)
						{
							$this->three_days($type_id);
						}

						$this->notification($type_id, $upl_id, '3', '',$isinotif);
					}	
				}
			}

			return $upl_id;
  		}

  		public function ApproveQty()
  		{
  			if($this->input->post())
  			{
  				$id = $this->input->post('item_id');
  				$pr_id = $this->input->post('pr_id');
  				$qty = $this->input->post('qty_appr');

  				$arr = array(
  					'qty_approved' 		=> $qty,
  					'date_approved'		=> date('Y-m-d H:i:s'),
  					'user_approved'		=> $_SESSION['myuser']['karyawan_id'],
  					'status_approved'	=> '1',
  					);
  				$this->db->where('id', $id);
  				$this->db->update('tbl_pr_vendor', $arr);
  			}
  		}

  		public function addContributor($contributor = '', $pr_id = '')
        {
            
            if($contributor == '' AND $pr_id == '') {
                $contributor = $this->input->post('contributor');
                $pr_id = $this->input->post('pr_id');
               // $id = $this->input->post('pr_id');
            }
            
            foreach ($contributor as $con) {
                $sql = "SELECT nickname FROM tbl_loginuser WHERE karyawan_id = '$con'";
                $row = $this->db->query($sql)->row_array();

                $args = array(
                    'pr_id'         => $pr_id,
                    'contributor'   => $con,
                    'user_id'       => $_SESSION['myuser']['karyawan_id'],
                    'date_created'  => date('Y-m-d H:i:s'),
                    );
                $this->db->insert('tbl_pr_contributor', $args);
                $con_id = $this->db->insert_id();

           
			$sql = "SELECT id FROM tbl_pr_log WHERE pr_id = $pr_id ORDER BY id DESC LIMIT 1";
				$que = $this->db->query($sql)->row_array();
				$log_pr = $que['id'];

				$addpsn = array(
					'pr_id' => $pr_id,
					'log_pr_id'	=> $log_pr,
					'sender' => $_SESSION['myuser']['karyawan_id'],
					'pesan'	=> $_SESSION['myuser']['nickname']." Add ".$row['nickname']." as Contributor",
					'date_created'	=> date('Y-m-d H:i:s'), 
					);
				$this->db->insert('tbl_pr_pesan', $addpsn);
				$pesan_id = $this->db->insert_id();

				$url 		= $this->mdata->getUrl();
  				$isinotif 	=$_SESSION['myuser']['nickname']." Add you as <b>Contributor</b> in <b>PR ID ". $pr_id."</b>";

				$this->notification($pr_id, $con_id, '16', $con,$isinotif,$url);

       } 
    }

  		public function finished($id)
  		{
  			$ptg_saldo = $this->input->post('ptg_saldo');
  			$harga_validasi = $this->input->post('harga_validasi');

  			$sql = "SELECT id, id_operator, time_login FROM tbl_pr_log WHERE pr_id = '$id' ORDER BY id DESC LIMIT 2";
		    $res = $this->db->query($sql)->result_array();

		    $iddown = $res[0]['id'];
		    
		    if(count($res) > 1 ) {
		    	$idup = $res[1]['id'];
		    }

		    $user = $_SESSION['myuser']['karyawan_id'];

		    if($_SESSION['myuser']['karyawan_id'] == $res[0]['id_operator'] OR count($res) == 1) {
		      //update overto karyawan_id time login, idle, nextto.
		      $uplog = array(
		        'overto'      => '101',
		        'time_login'  => date('Y-m-d H:i:s'),
		        'time_nextto' => date('Y-m-d H:i:s'),
		        'time_idle'   => date('Y-m-d H:i:s'),
		        );
		      $this->db->where('id', $iddown);
		      $this->db->update('tbl_pr_log', $uplog);

		    }elseif ($_SESSION['myuser']['karyawan_id'] != $res[0]['id_operator']) {

		      if($res[1]['time_login'] != '0000-00-00 00:00:00') {
		        $upnext = array(
		          'overto'      => $user,
		          'time_nextto' => date('Y-m-d H:i:s'),
		          );
		        $this->db->where('id', $iddown);
		        $this->db->update('tbl_pr_log', $upnext);

		        $insert = array(
		          'pr_id'         => $id,
		          'id_operator'   => $user,
		          'overto'		  => '101',
		          'date_created'  => date('Y-m-d H:i:s'),
		          'time_login'    => date('Y-m-d H:i:s'),
		          'time_nextto'   => date('Y-m-d H:i:s'),
		          'time_idle'     => date('Y-m-d H:i:s'),
		          );
		        $this->db->insert('tbl_pr_log', $insert);
		        $iddown = $this->db->insert_id();

		      }elseif ($res[1]['time_login'] == '0000-00-00 00:00:00') {

		        $uplogin = array(
		          'time_login'  => date('Y-m-d H:i:s'),
		          'time_idle'   => date('Y-m-d H:i:s'),
		          );
		        $this->db->where('id', $idup);
		        $this->db->update('tbl_pr_log', $uplogin);

		        $upnext2 = array(
		          'overto'      => $user,
		          'time_nextto' => date('Y-m-d H:i:s'),
		          );
		        $this->db->where('id', $iddown);
		        $this->db->update('tbl_pr_log', $upnext2);

		        $newrow = array(
		          'pr_id'         => $id,
		          'id_operator'   => $user,
		          'overto'		  => '101',
		          'date_created'  => date('Y-m-d H:i:s'),
		          'time_login'    => date('Y-m-d H:i:s'),
		          'time_nextto'   => date('Y-m-d H:i:s'),
		          'time_idle'     => date('Y-m-d H:i:s'),
		          );
		        $this->db->insert('tbl_pr_log', $newrow);
		        $iddown = $this->db->insert_id();
		      }
		    }

	    	$args = array(
		        'status' =>'FINISHED',
		        'date_closed' => date('Y-m-d H:i:s'),
		        'status_finish' => '1',
	       	);
	      	$this->db->where('id', $id);
	      	$this->db->update('tbl_purchasing', $args);

	    	$pesan = array(
		        'pr_id'     => $id,
		        'log_pr_id' => $iddown,
		        'sender'   => $user,
		        'pesan'       => '***** FINISHED *****',
		        'date_created'  => date('Y-m-d H:i:s'),
	        );
	      	$this->db->insert('tbl_pr_pesan', $pesan);
	      	$id_pesan = $this->db->insert_id();


		    // if($ptg_saldo =='1')
		    // {

		    // 	$sql = "SELECT ks.interval_reminder, pr.sales_id,ks.id,ks.balance FROM tbl_purchasing pr 
		    // 			LEFT JOIN tbl_kasbon_cash ks ON ks.karyawan_id = pr.sales_id
		    // 			WHERE pr.id='$id'";
		    // 	$res = $this->db->query($sql)->row_array();
		    // 	$kasbon_id = $res['id'];
		    // 	$karyawan = $res['sales_id'];
		    // 	$interval_reminder = $res['interval_reminder'];
		    // 	$balance = $res['balance'];
		    // 	$balance = $balance - $harga_validasi;
		    // 	$reminder_date = Date('Y-m-d', strtotime("+".$interval_reminder." days"));

		    
			   //  $insert = array(
	     //                        'karyawan_id'   =>  $karyawan, 
	     //                        'kasbon_id'     =>  $kasbon_id,
	     //                        'debit'        =>   $harga_validasi,
	     //                        'balance'       =>  $balance,
	     //                        'date_created'  =>  date('Y-m-d H:i:s'),
	     //                        'user'          =>  $_SESSION['myuser']['karyawan_id'],
	     //                        'description'   =>  "Pengurangan Saldo pada PR ID ". $id,
	     //                        'pr_id'			=> $id,
	     //                        );
	     //        $this->db->insert('tbl_kasbon_rekening_koran', $insert);


	     //        $this->db->where('id', $kasbon_id);
      //           $this->db->update('tbl_kasbon_cash', array('last_update'=> date('Y-m-d H:i:s'),'balance'=>$balance,'reminder_date'=> $reminder_date));

      //           $pesan = array(
      //                               'kasbon_id'       => $kasbon_id,
      //                               'user'            => '133',
      //                               'pesan'           => "Mengurangi Saldo pada PR ID ". $id,
      //                               'date_created'    => date('Y-m-d H:i:s'),
      //                           );
      //           $this->db->insert('tbl_kasbon_pesan', $pesan);
      //           $psn_id = $this->db->insert_id();

      //       }

		    $url 		= $this->mdata->getUrl();
			$isinotif 	= '<b>PR ID '. $id.'</b> has been <b style="color:green;">Finish</b> by '.$_SESSION['myuser']['nickname'];

		    $this->notification($id, $id_pesan, '2', '',$isinotif,$url);

		    if($_SESSION['myuser']['position_id'] == 5)
		    {
		    	$this->finish_job($id);
		    }

		 //    if($_FILES)
		 //    {
		 //    	$file_url = $this->config->item('file_url');

		 //    	// MASUK FILE PR
			// 	$uploaddir = 'assets/images/upload_pr';

			// 	foreach ($_FILES['filepr']['name'] as $key => $value)
			// 	{
			// 		$temp_file_location = $_FILES['filepr']['tmp_name'][$key];
					
			// 		$upload = $this->fileupload->filehandling($uploaddir,$temp_file_location,$value);

			// 		if ($upload[0] == 'Success')
			// 		{
			// 			$file_name = $upload[1];

			// 			$file_link = '<a href="'.$file_url.$uploaddir.'/'.$file_name.'" target="_blank">'.$file_name.'</a>';
					
			// 			$message = "Mengupload file Bukti Transfer ".$file_link;


			// 			$file_upload = array(
			// 				'pr_id'         => $id,
			// 				'sub_id'		=> '0',
			// 				'file_name'     => $file_name,
			// 				'uploader'      => $_SESSION['myuser']['karyawan_id'],
			// 				'date_created'  => date('Y-m-d H:i:s'),
			// 				'type'			=> '4',
			// 			);
			// 			$this->db->insert('tbl_upload_pr', $file_upload);
			// 			$upl_id = $this->db->insert_id();

			// 			$sql = "SELECT id FROM tbl_pr_log WHERE pr_id = '$id' ORDER BY id DESC LIMIT 1";
			// 			$que = $this->db->query($sql)->row_array();
			// 			$log_pr = $que['id'];

			// 			$addpsn = array(
			// 				'pr_id' => $id,
			// 				'log_pr_id'	=> $log_pr,
			// 				'sender' => $_SESSION['myuser']['karyawan_id'],
			// 				'pesan'	=> $file_name,
			// 				'psn_type'	=> '1',
			// 				'date_created'	=> date('Y-m-d H:i:s'),
			// 				);
			// 			$this->db->insert('tbl_pr_pesan', $addpsn);

					

			// 			$refunds = $this->getRefund($id);

			// 			if($refunds)
			// 			{
			// 				foreach ($refunds as $key => $rfn) 
			// 				{	

			// 					$refund_id = $rfn['refund_id'];
								

			// 					$this->db->set('status', 'Completed');
			// 		            $this->db->where('id', $refund_id);
			// 		            $this->db->update('tbl_refund'); 


			// 		            $sql   ="SELECT * FROM tbl_refund WHERE id='$refund_id'";
			// 		            $reff  = $this->db->query($sql)->row_array();
			// 		            $so_id = $reff['so_id'];
			// 		            $nominal_refund = $reff['nominal_refund'];
			// 		            $mutasi_id 		= $reff['mutasi_id'];



			// 		            $sql ="SELECT * FROM tbl_sales_order WHERE id='$so_id'";
			// 		            $detail_so = $this->db->query($sql)->row_array();

			// 		            $total_bayar = $detail_so['total_bayar'];

			// 		            $sisa = $total_bayar-$nominal_refund;

			// 		            $this->db->set('total_bayar',$sisa);
			// 		            $this->db->where('id', $so_id);
			// 		            $this->db->update('tbl_sales_order'); 

					           

			// 					//INSERT LOG ACTIVITY
		 //                        $insert_log = array(
		 //                               'refund_id'          => $refund_id,
		 //                                'log_type'          => 'Uplad File',
		 //                                'user'              => $_SESSION['myuser']['karyawan_id'],
		 //                                'message'           => $message,
		 //                                'need_approval'     => 'no',
		 //                                'created'           => date('Y-m-d H:i:s'),
		 //                        );
		 //                        $this->db->insert('tbl_refund_log',$insert_log); 

			// 		            $insert_log = array(
			//                            'refund_id'          => $refund_id,
			//                             'log_type'          => 'Activity',
			//                             'user'              => $_SESSION['myuser']['karyawan_id'],
			//                             'message'           => "**COMPLETED**",
			//                             'need_approval'     => 'no',
			//                             'created'           => date('Y-m-d H:i:s'),
			//                     );
			//                     $this->db->insert('tbl_refund_log',$insert_log); 


			//                     // LOG DIMUTASI
			//                     $exp = explode(",",$mutasi_id);
			//                     foreach ($exp as $key => $mut) 
			//                     {  
			//                         $mutasi_id= $mut;
			//                         $message = "Finish Refund ID ".$refund_id.", nominal refund Rp.".number_format($nominal_refund);
			//                         $add_inf = array(
			// 				                'mutasi_id'    => $mutasi_id,
			// 				                'information'  => $message,
			// 				                'uploader'     => "133",
			// 				                'date_created' => date('Y-m-d H:i:s')
			// 				                );
			// 				        $this->db->insert('tbl_indotara_mutasi_bca_information', $add_inf);  
			//                     }
			// 				}
			// 			}
			// 		}	
			// 	}
				
			// }

		    //$this->logAll($id, $desc = '1', $id_pesan, $ket = 'tbl_multi_pesan');
		}

		public function takeOver($id)
		{
			$sql = "SELECT id, time_login, time_nextto, time_idle, date_created FROM tbl_pr_log WHERE pr_id = '$id' ORDER BY id DESC LIMIT 2";
		    $res = $this->db->query($sql)->result_array();

		    $iddown = $res[0]['id'];
		    $idup = $res[1]['id'];
		    $user = $_SESSION['myuser']['karyawan_id'];
		    $nick = $_SESSION['myuser']['nickname'];

		    if($res[1]['time_login'] != '0000-00-00 00:00:00') {
		     //update time_nextto iddown kemudian insert
			$upnext = array(
				'overto'      	=> $user,
				'time_nextto'	=> date('Y-m-d H:i:s'),
			);
			$this->db->where('id', $iddown);
			$this->db->update('tbl_pr_log', $upnext);

			$insert = array(
				'pr_id'         => $id,
				'id_operator'   => $user,
				'date_created'  => date('Y-m-d H:i:s'),
			);
			$this->db->insert('tbl_pr_log', $insert);

		    }elseif ($res[1]['time_login'] == '0000-00-00 00:00:00') {
		     // update time_login dan idle idup kemudian update timelogin, time nextto, idle iddown kemudian insert
				$uplogin = array(
					'time_login'  => date('Y-m-d H:i:s'),
					'time_idle'   => date('Y-m-d H:i:s'),
				);
				$this->db->where('id', $idup);
				$this->db->update('tbl_pr_log', $uplogin);

				$upnext2 = array(
					'overto'      => $user,
					'time_nextto' => date('Y-m-d H:i:s'),
				);
				$this->db->where('id', $iddown);
				$this->db->update('tbl_pr_log', $upnext2);

				$newrow = array(
					'pr_id'         => $id,
					'id_operator'   => $user,
					'date_created'  => date('Y-m-d H:i:s'),
				);
				$this->db->insert('tbl_pr_log', $newrow);
		    }

		    $up_pr = array(
		      'status' => $user,
		      );
		    $this->db->where('id', $id);
		    $this->db->update('tbl_purchasing', $up_pr);

		    $pesan = array(
		        'pr_id'     => $id,
		        'log_pr_id' => $iddown,
		        'sender'   => $user,
		        'pesan'       => '*** TAKE OVER ***',
		        'date_created'  => date('Y-m-d H:i:s'),
		        );
		      $this->db->insert('tbl_pr_pesan', $pesan);
		      $id_pesan = $this->db->insert_id();

		    $url 		= $this->mdata->getUrl();
  			$isinotif 	= "<b>PR ID ". $id."</b> has been take over by ".$_SESSION['myuser']['nickname'];

		     $this->notification($id, $id_pesan, '2', '',$isinotif);

		      //$this->logAll($id, $desc = '1', $id_pesan, $ket = 'tbl_multi_pesan');
		}

		public function newNotification($pr_id, $rec_id, $notif, $position_cbg, $isinotif)
		{

			$url = "purchasing/details/".$pr_id;
			$date = date('Y-m-d H:i:s');
			$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul, date_created,notes,url) 
					SELECT id as user, '$rec_id', '$notif', '$pr_id', '0', '5', '$date','$isinotif','$url' FROM tbl_karyawan
                    WHERE position_id IN ('$position_cbg') AND published = '1'
                    GROUP BY user ";
            $this->db->query($sql);        
		}

		public function notification($id, $rec_id, $notif, $user,$isinotif)
      	{
      		$url = "purchasing/details/".$id;
      		$pos_id = $_SESSION['myuser']['position_id'];
      		$karyawan_id = $_SESSION['myuser']['karyawan_id'];

	        if($user != '') 
	        {
	        	$add = array(
		            'modul' => '5',
		            'modul_id'  => $id,
		            'record_id' => $rec_id,
		            'record_type' => $notif,
		            'user_id' => $user,
		            'notes'			=> $isinotif,
		            'url'			=> $url,
		            'date_created'	=> date('Y-m-d H:i:s'), // pipit 13022020
	        	);
        		$this->db->insert('tbl_notification', $add);
	        }
	        elseif($user == '') {
	        	$kar = $_SESSION['myuser']['karyawan_id'];
	        	$sql = "SELECT kar.cabang, kar.nama, ps.position, pr.status FROM tbl_purchasing as pr
                LEFT JOIN tbl_karyawan as kar ON kar.id = pr.sales_id
                LEFT JOIN tbl_position as ps ON ps.id = kar.position_id
                WHERE pr.id = '$id'";
        		$query = $this->db->query($sql)->row_array();

		        $a = $query['cabang'];
		        $finished = $query['status'];
		        $div = substr($query['position'], -3);
		        $date = date('Y-m-d H:i:s');

		       if(in_array($pos_id, array('55', '56', '57', '58','134')))
		       {
			       if($a == 'Bandung') {
			          $position_cbg = '57';
			        }elseif ($a == 'Surabaya') {
			          $position_cbg = '55';
			        }elseif ($a == 'Medan') {
			          $position_cbg = '56';
			        }elseif ($a == 'Cikupa') {
			        	$position_cbg = '58';
			        }elseif ($a == 'Semarang') { // WL 42182
			        	$position_cbg = '134';	
			        }else{
			          $position_cbg = '';
			        }
			    }else
			    {
			    	 $position_cbg = '';
			    }

		        if($div == 'DHC') {
		          $div = '88';
		        }elseif ($div == 'DRE') {
		          $div = '89';
		        }elseif ($div == 'HORECA') {
		          $div = '89';
		        }elseif ($div == 'DCE') {
		          $div = '90';
		        }elseif ($div == 'DGM') {
		          $div = '90';
		        }elseif ($div == 'DHE') {
		          $div = '91';
		        }elseif ($div == 'DGC') {
		          $div = '92,90';
		        }elseif ($div == 'DEE') {
		          $div = '93';
		        }elseif ($div == 'DWT') {
		          $div = '100,91';  
		        }elseif ($div == 'DPP') {
		          $div = '91';  
		        }elseif ($div == 'DMS') {
		          $div = '149';  
		        }else{
		        	$div = '';
		        }

		        if($finished == 'FINISHED') 
		        {
		        	$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul, date_created,notes,url)
	                  SELECT uploader, '$rec_id', '$notif', '$id', '0', '5', '$date','$isinotif','$url' FROM tbl_upload_pr
	                  WHERE pr_id = '$id' AND uploader NOT IN ('$kar', '2') AND type = '1' GROUP BY uploader
	                  UNION SELECT overto, '$rec_id', '$notif', '$id', '0', '5', '$date','$isinotif','$url' FROM tbl_pr_log
	                  WHERE pr_id = '$id' AND overto NOT IN ('0', '$kar') GROUP BY overto
	                  UNION SELECT contributor, '$rec_id', '$notif', '$id', '0', '5', '$date','$isinotif','$url' FROM tbl_pr_contributor 
	                  WHERE pr_id = '$id' AND contributor != $kar GROUP BY contributor
	                  UNION SELECT sender, '$rec_id', '$notif', '$id', '0', '5', '$date','$isinotif','$url' FROM tbl_pr_pesan
	                  WHERE pr_id = '$id' AND sender NOT IN ('$kar', '2') GROUP BY sender";
	            }else 
	            {
	              	$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul, date_created,notes,url)
	                  SELECT uploader, '$rec_id', '$notif', '$id', '0', '5', '$date','$isinotif','$url' FROM tbl_upload_pr
	                  WHERE pr_id = '$id' AND uploader != '$kar' AND type = '1' GROUP BY uploader
	                  UNION SELECT overto, '$rec_id', '$notif', '$id', '0', '5', '$date','$isinotif','$url' FROM tbl_pr_log
	                  WHERE pr_id = '$id' AND overto NOT IN ('0', '$kar') GROUP BY overto
	                  UNION SELECT contributor, '$rec_id', '$notif', '$id', '0', '5', '$date','$isinotif','$url' FROM tbl_pr_contributor 
	                  WHERE pr_id = '$id' AND contributor != $kar GROUP BY contributor
	                  UNION SELECT sender, '$rec_id', '$notif', '$id', '0', '5', '$date','$isinotif','$url' FROM tbl_pr_pesan
	                  WHERE pr_id = '$id' AND sender != '$kar' GROUP BY sender";
	            }
			        // pipit 06022020
			        if(!empty($position_cbg) AND !empty($div)) {
			          $sql .= " UNION SELECT id, '$rec_id', '$notif', '$id', '0', '5', '$date', '$isinotif', '$url' FROM tbl_karyawan WHERE published = '1' AND position_id IN ('$position_cbg', '$div')";

			        } elseif(!empty($position_cbg) AND empty($div)) {
			          $sql .= " UNION SELECT id, '$rec_id', '$notif', '$id', '0', '5', '$date', '$isinotif', '$url' FROM tbl_karyawan WHERE published = '1' AND position_id IN ('$position_cbg')";
			        }elseif(empty($position_cbg) AND !empty($div)) {
			        	$sql .= " UNION SELECT id, '$rec_id', '$notif', '$id', '0', '5', '$date', '$isinotif', '$url' FROM tbl_karyawan WHERE published = '1' AND position_id IN ('$div')";
			        }elseif(empty($position_cbg) AND empty($div)) {
			        	$sql .= "";
			        }
		        	$this->db->query($sql);
		        }
	    }


	    public function last_update($id)
	    {

	    	$last = array(
					'last_update'	=> date('Y:m:d'),
					);
			$this->db->where('id', $id);
			$this->db->update('tbl_purchasing', $last);


	    }

	    public function three_days($id)
	    {

	    	$reminder= date('Y-m-d', strtotime("+3 days"));

	    	$last = array(
					'reminder_three_days'	=> $reminder,
					);
			$this->db->where('id', $id);
			$this->db->update('tbl_purchasing', $last);	
	    }
     	

	    public function getImport()
	    {

	    	$sql="SELECT id, shipment FROM tbl_import WHERE status !='8' ORDER BY shipment ASC";
	    	$res = $this->db->query($sql)->result_array();

	    	return $res;
	    }

	    public function linkToimport($import_id, $pr_id, $sales_id)
	    {
	    	$inslink = array(
				'link_from_modul' => '5',
				'link_from_id'    => $pr_id,
				'link_to_modul'   => '6',
				'link_to_id'      => $import_id,
				'user'            => $_SESSION['myuser']['karyawan_id'],
				'date_created'    => date('Y-m-d H:i:s'),
            );
            $this->db->insert('tbl_link', $inslink);
           
            $insert = array(
                'import_id'     => $import_id,
                'discuss'       => 'Menambahkan PR ID '.$pr_id,
                'date_created'  => date('Y-m-d H:i:s'),
                'user'          => $_SESSION['myuser']['karyawan_id'],
            );
            $this->db->insert('tbl_import_discussion', $insert);
            $disc_id = $this->db->insert_id();

            $sql = "SELECT shipment FROM tbl_import WHERE id = $import_id";
            $row = $this->db->query($sql)->row_array();

            $ship = $row['shipment'];

			$sql = "SELECT id FROM tbl_pr_log WHERE pr_id = $pr_id ORDER BY id DESC LIMIT 1";
			$que = $this->db->query($sql)->row_array();
			$log_pr = $que['id'];

			$addpsn = array(
			    'pr_id'       => $pr_id,
			    'log_pr_id'   => $log_pr,
			    'sender'      => $_SESSION['myuser']['karyawan_id'],
			    'pesan'       => 'Menambahkan Import ID '.$import_id." - (".$ship.")",
			    'date_created'=> date('Y-m-d H:i:s'), 
			    );
			$this->db->insert('tbl_pr_pesan', $addpsn);

			$sql = "SELECT id FROM tbl_import_contributor
			      WHERE contributor ='$sales_id' AND import_id='$import_id'";
			$res = $this->db->query($sql)->row_array();

	        if(empty($res))
	        {
	            $args = array(
                    'import_id'     => $import_id,
                    'contributor'   => $sales_id,
                    'user_id'       => $_SESSION['myuser']['karyawan_id'],
                    'date_created'  => date('Y-m-d H:i:s'),
                );
	            $this->db->insert('tbl_import_contributor', $args);
	            $con_id = $this->db->insert_id();
	        }
		}


		public function editItem($id)
	    {
	    	if($this->input->post()) 
	    	{
         
               	$id 		=$this->input->post('id');
               	$pr_id 		=$this->input->post('pr_id');
				$qty 		= $this->input->post('qty');
				$stock		= $this->input->post('stock');
				$vendor		= $this->input->post('vendor');
				$items 		= $this->input->post('items');
				$mou 		= $this->input->post('mou');
				$priority	= $this->input->post('priority');
				$priority	= $this->input->post('priority');
				$deadline 	= $this->input->post('deadline');
				$deadline 	= preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $deadline);
				$jns 		= $this->input->post('jns_pembelian');
				$holder     = $this->input->post('holder');

				$edititem = array(
					
					'vendor'=> $vendor,
					'items'	=> $items,
					'qty'	=> $qty,
					'stock'	=> $stock,
					'mou'	=> $mou,
					'deadline' => $deadline,
					'priority' =>$priority,
					'date_created'	=> date('Y-m-d H:i:s'),
					'jenis'		=> $jns,
					'holder'		=> $holder,
					);
        		$this->db->where('id', $id);
        		$this->db->update('tbl_pr_vendor', $edititem);

				$kar_id 	=$_SESSION['myuser']['karyawan_id'];
       	 		$logpr = $this->AddLogPR($pr_id, $kar_id);
	    

	    		$addpsn = array(
					'pr_id' => $pr_id,
					'log_pr_id'	=> $logpr,
					'sender' => $_SESSION['myuser']['karyawan_id'],
					'pesan'	=> 'Edit Item ID <b style="color:green;">'.$id.'</b>',
					'date_created'	=> date('Y-m-d H:i:s'),
					);
				$this->db->insert('tbl_pr_pesan', $addpsn);
				$pesan_id = $this->db->insert_id();
	    	}

		}

		public function deleteitem($pr_id,$id)
	    {
	    	
	    	$this->db->where('id',$id);
			$this->db->update('tbl_pr_vendor', array('published' => '1'));

	    	$kar_id = $_SESSION['myuser']['karyawan_id'];
	    	$logpr = $this->AddLogPR($pr_id, $kar_id);
	    
	    		$addpsn = array(
					'pr_id' => $pr_id,
					'log_pr_id'	=> $logpr,
					'sender' => $_SESSION['myuser']['karyawan_id'],
					'pesan'	=> 'Delete Item ID <b style="color:green;">'.$id.'</b>',
					'date_created'	=> date('Y-m-d H:i:s'),
					);
				$this->db->insert('tbl_pr_pesan', $addpsn);

				$pesan_id = $this->db->insert_id();

				$sql = "SELECT * FROM tbl_pr_vendor WHERE id='$id'";
				$res = $this->db->query($sql)->row_array();
				$level = $res['level_approval'];
				$ptg_saldo = $res['ptg_saldo'];
	            $user_receive = $res['user_receive'];
	            $harga_beli = $res['harga_beli'];

	            if($ptg_saldo =='1')
		            {
			            $sql = " SELECT * FROM tbl_kasbon_cash WHERE karyawan_id ='$user_receive'";
					    $res = $this->db->query($sql)->row_array();

					    $kasbon_id 			= $res['id'];
					    $interval_reminder  = $res['interval_reminder'];
					    $balance 			= $res['balance'];

			           
			            $selisih = str_replace("-", "", $harga_beli);
			            $balance = $balance + $harga_beli;
			            $arr = "credit";

				        $this->db->where('id', $kasbon_id);
			            $this->db->update('tbl_kasbon_cash', array('last_update'=> date('Y-m-d H:i:s'),'balance'=>$balance));

			            $ket = "Saldo pada PR ID ".$pr_id." untuk Item ID ".$id." dikembalikan, karena item telah dihapus";
			            $this->selisih($user_receive,$kasbon_id,$selisih,$balance,$pr_id,$arr,$ket);
			            		
			            
		        	}
	    }

	    public function add_notes()
	    {
	    	$notes = $this->input->post('notes');
	    	$id = $this->input->post('vendor_id');
	    	$pr_id = $this->input->post('pr_id');

			$args = array(
			   	'notes' 	    => $notes,
			   	'user'			=> $_SESSION['myuser']['karyawan_id'],
			   	'pr_id'			=> $pr_id,
			   	'item_id'		=> $id,
			   	'date_created'	=> date('Y-m-d H:i:s'),

			);
			$this->db->insert('tbl_pr_notes', $args);
		}


		public function cancel($id)
  		{
  			$sql = "SELECT id, id_operator, time_login FROM tbl_pr_log WHERE pr_id = '$id' ORDER BY id DESC LIMIT 2";
		    $res = $this->db->query($sql)->result_array();

		    $iddown = $res[0]['id'];
		    $idup   = $res[1]['id'];
		    $user   = $_SESSION['myuser']['karyawan_id'];

		    if($_SESSION['myuser']['karyawan_id'] == $res[0]['id_operator']) {
		      //update overto karyawan_id time login, idle, nextto.
		      $uplog = array(
		        'overto'      => '100',
		        'time_login'  => date('Y-m-d H:i:s'),
		        'time_nextto' => date('Y-m-d H:i:s'),
		        'time_idle'   => date('Y-m-d H:i:s'),
		        );
		      $this->db->where('id', $iddown);
		      $this->db->update('tbl_pr_log', $uplog);

		    }elseif ($_SESSION['myuser']['karyawan_id'] != $res[0]['id_operator']) {

		      if($res[1]['time_login'] != '0000-00-00 00:00:00') {
		        $upnext = array(
		          'overto'      => $user,
		          'time_nextto' => date('Y-m-d H:i:s'),
		          );
		        $this->db->where('id', $iddown);
		        $this->db->update('tbl_pr_log', $upnext);

		        $insert = array(
		          'pr_id'         => $id,
		          'id_operator'   => $user,
		          'overto'		  => '100',
		          'date_created'  => date('Y-m-d H:i:s'),
		          'time_login'    => date('Y-m-d H:i:s'),
		          'time_nextto'   => date('Y-m-d H:i:s'),
		          'time_idle'     => date('Y-m-d H:i:s'),
		          );
		        $this->db->insert('tbl_pr_log', $insert);
		        $iddown = $this->db->insert_id();

		      }elseif ($res[1]['time_login'] == '0000-00-00 00:00:00') {

		        $uplogin = array(
		          'time_login'  => date('Y-m-d H:i:s'),
		          'time_idle'   => date('Y-m-d H:i:s'),
		          );
		        $this->db->where('id', $idup);
		        $this->db->update('tbl_pr_log', $uplogin);

		        $upnext2 = array(
		          'overto'      => $user,
		          'time_nextto' => date('Y-m-d H:i:s'),
		          );
		        $this->db->where('id', $iddown);
		        $this->db->update('tbl_pr_log', $upnext2);

		        $newrow = array(
		          'pr_id'         => $id,
		          'id_operator'   => $user,
		          'overto'		  => '119',
		          'date_created'  => date('Y-m-d H:i:s'),
		          'time_login'    => date('Y-m-d H:i:s'),
		          'time_nextto'   => date('Y-m-d H:i:s'),
		          'time_idle'     => date('Y-m-d H:i:s'),
		          );
		        $this->db->insert('tbl_pr_log', $newrow);
		        $iddown = $this->db->insert_id();
		      }
		    }

		    $keterangan = $this->input->post('keterangan');

		    	$args = array(
			        'status' =>'CANCELED',
			        'date_closed' => date('Y-m-d H:i:s'),
			        'keterangan' => $keterangan,
			        'status_finish' => '2',
		       	);
		      $this->db->where('id', $id);
		      $this->db->update('tbl_purchasing', $args);

		    	$pesan = array(
			        'pr_id'     => $id,
			        'log_pr_id' => $iddown,
			        'sender'   => $user,
			        'pesan'       => '***** CANCELED *****',
			        'date_created'  => date('Y-m-d H:i:s'),
		        );
		      $this->db->insert('tbl_pr_pesan', $pesan);
		      $id_pesan = $this->db->insert_id();

		      	$isinotif 	= '<b>PR ID '. $id.'</b> has been <b style="color:red;">Cancel</b> by '.$_SESSION['myuser']['nickname'];


			$sql ="SELECT harga_beli,pr_id,id as vendor_id,user_receive,ptg_saldo,status_receiver,level_approval FROM
		   		 tbl_pr_vendor WHERE pr_id='$id' 
				 AND published='0' AND ptg_saldo='1' AND status_receiver='1'";
			$result = $this->db->query($sql)->result_array();

			foreach($result as $res)
			{
				$level = $res['level_approval'];
				$ptg_saldo = $res['ptg_saldo'];
	            $user_receive = $res['user_receive'];
	            $harga_beli = $res['harga_beli'];
	            $vendor_id = $res['vendor_id'];

	            if($ptg_saldo =='1')
		        {
			            $sql = " SELECT * FROM tbl_kasbon_cash WHERE karyawan_id ='$user_receive'";
					    $res = $this->db->query($sql)->row_array();

					    $kasbon_id 			= $res['id'];
					    $interval_reminder  = $res['interval_reminder'];
					    $balance 			= $res['balance'];

			           
			            $selisih = str_replace("-", "", $harga_beli);
			            $balance = $balance + $harga_beli;
			            $arr = "credit";

				        $this->db->where('id', $kasbon_id);
			            $this->db->update('tbl_kasbon_cash', array('last_update'=> date('Y-m-d H:i:s'),'balance'=>$balance));

			            $ket = "Saldo pada PR ID ".$id." untuk Item ID ".$vendor_id." dikembalikan, PR telah dicancel";
			            $this->selisih($user_receive,$kasbon_id,$selisih,$balance,$id,$arr,$ket);
			            		 
		        }
				
			}

		    $this->notification($id, $id_pesan, '2', '',$isinotif);
		}

		 public function FinishReceived()
	    {
	    	$qty_received = $this->input->post('qty_received');
	    	$id = $this->input->post('id');
	    	$pr_id = $this->input->post('pr_id');
	    	$kar_id = $_SESSION['myuser']['karyawan_id'];

				  $args = array(
	                   	'qty_received' 	    =>$qty_received,
	                );
	              $this->db->where('id', $id);
	              $this->db->update('tbl_pr_vendor', $args);


	              	$ins=array(
	              		'qty_received' =>$qty_received,
	              		'pr_id'		   =>$pr_id,
	              		'item_id'      =>$id,
	              		'user_received'=>$kar_id,
	              		'date_created'=>date('Y-m-d H:i:s'),
	              		'published'=>'1',
	              		);
	              	$this->db->insert('tbl_pr_received', $ins);
					$item_id = $this->db->insert_id();

					$sql = "SELECT id FROM tbl_pr_log WHERE pr_id = $pr_id ORDER BY id DESC LIMIT 1";
					$que = $this->db->query($sql)->row_array();
					$log_pr = $que['id'];

					$pesan = "Telah Receive Barang Sebanyak ".$qty_received;

					$pesan = array(
			        	'pr_id'     	=> $pr_id,
			        	'log_pr_id' 	=> $log_pr,
			        	'sender'   		=> $kar_id,
			        	'pesan'       	=> $pesan,
			        	'date_created'  => date('Y-m-d H:i:s'),
		        	);
		      		$this->db->insert('tbl_pr_pesan', $pesan);
		      		$id_pesan = $this->db->insert_id();

				    $isinotif 	= "<b>PR ID ".$pr_id."</b> : ".$_SESSION['myuser']['nickname']." Add New Message";
					$this->notification($pr_id, $id_pesan, '2', '',$isinotif); // pipit 07022020
	    }


	     public function update_item()
	    {
               	$id 		=$this->input->post('id');
               	$pr_id 		=$this->input->post('pr_id');
				$qty 		= $this->input->post('qty');
				$stock		= $this->input->post('stock');
				$vendor		= $this->input->post('vendor');
				$items 		= $this->input->post('items');
				$mou 		= $this->input->post('mou');
				$priority	= $this->input->post('priority');
				$priority	= $this->input->post('priority');
				$deadline 	= $this->input->post('deadline');
				$deadline 	= preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $deadline);
				$jns 		= $this->input->post('jns_pembelian');
				$holder1    = $this->input->post('holder');

				$edititem = array(
					'vendor'		=> $vendor,
					'items'			=> $items,
					'qty'			=> $qty,
					'stock'			=> $stock,
					'mou'			=> $mou,
					'deadline' 		=> $deadline,
					'priority' 		=>$priority,
					'date_created'	=> date('Y-m-d H:i:s'),
					'jenis'			=> $jns,
					'holder'		=> $holder1,
					);
       			$this->db->where('id', $id);
        		$this->db->update('tbl_pr_vendor', $edititem);

				$kar_id 	=$_SESSION['myuser']['karyawan_id'];
	        	$logpr = $this->AddLogPR($pr_id, $kar_id);
		    

		    		$addpsn = array(
						'pr_id' => $pr_id,
						'log_pr_id'	=> $logpr,
						'sender' => $_SESSION['myuser']['karyawan_id'],
						'pesan'	=> 'Edit Item ID <b style="color:green;">'.$id.'</b>',
						'date_created'	=> date('Y-m-d H:i:s'),
						);
					$this->db->insert('tbl_pr_pesan', $addpsn);
					$pesan_id = $this->db->insert_id();	


		}

		public function FinishPurchase($pr_id, $id)
	    {
	    	$kar_id = $_SESSION['myuser']['karyawan_id'];

	    	$args = array(
	                   	'status_purchaser' 	    =>'1',
	                   	'user_purchaser'		=> $kar_id,
	                   	'date_purchase'			=> date('Y-m-d H:i:s'),
	                );
	        $this->db->where('id', $id);
	        $this->db->update('tbl_pr_vendor', $args);

	    	$logpr = $this->AddLogPR($pr_id, $kar_id);
	    
	    	$addpsn = array(
					'pr_id' => $pr_id,
					'log_pr_id'	=> $logpr,
					'sender' => $_SESSION['myuser']['karyawan_id'],
					'pesan'	=> 'Finish Purchase Item ID <b style="color:green;">'.$id.'</b>',
					'date_created'	=> date('Y-m-d H:i:s'),
					);
			$this->db->insert('tbl_pr_pesan', $addpsn);
			$pesan_id = $this->db->insert_id();

			$isinotif 	= "<b>PR ID ".$pr_id."</b> : ".$_SESSION['myuser']['nickname']." Add New Message";
			$this->notification($pr_id, $pesan_id, '2', '',$isinotif);
	    }


	    public function Receive()
	    {
	    	$harga_beli1 	= $this->input->post('harga_beli');
	    	$harga_beli 	= str_replace(".", "", $harga_beli1);
	    	$id 			= $this->input->post('id');
	    	$pr_id 			= $this->input->post('pr_id');
	    	$kar_id 		= $_SESSION['myuser']['karyawan_id'];
	    	$position_id 	= $_SESSION['myuser']['position_id'];
	    	$cabang 		= $_SESSION['myuser']['cabang'];
	    	$divisi			= $_SESSION['myuser']['divisi'];
	    	$user_bayar 	= $_SESSION['myuser']['karyawan_id'];
	    	$ptg_saldo 		= $this->input->post('ptg_saldo');

	    

			$args = array
					(
	                'harga_beli' 	    => $harga_beli,
	                'status_receiver'	=> '1',
	                'date_harga'	    => date('Y-m-d H:i:s'),
	                'user_receive'		=> $_SESSION['myuser']['karyawan_id'],
	                'ptg_saldo' 		=> $ptg_saldo,
	                );
	        $this->db->where('id', $id);
	        $this->db->update('tbl_pr_vendor', $args);

		    $sql = "SELECT id FROM tbl_pr_log WHERE pr_id = $pr_id ORDER BY id desc limit 1";
		    $row = $this->db->query($sql)->row_array();
		    $logpr = $row['id'];
	   
	    	$addpsn = array(
				'pr_id' => $pr_id,
				'log_pr_id'	=> $logpr,
				'sender' => $_SESSION['myuser']['karyawan_id'],
				'pesan'	=> 'Receive Item ID <b style="color:green;">'.$id.'</b>, Harga beli : Rp. <b style="color:green;">'.$harga_beli1	.'</b>',
				'date_created'	=> date('Y-m-d H:i:s'),
				);
			$this->db->insert('tbl_pr_pesan', $addpsn);
			$pesan_id = $this->db->insert_id();

			$isinotif 	= "<b>PR ID ".$pr_id."</b> : ".$_SESSION['myuser']['nickname']." Add New Message";
			$this->notification($pr_id, $pesan_id, '2', '',$isinotif);

			$sql =" SELECT * FROM tbl_pr_vendor WHERE id='$id'";
			$res = $this->db->query($sql)->row_array();

        
		}


  		public function uploadfiletool($id_tool, $type_tool,$type_id,$type,$sub_id)
  		{
  			

		    if($_FILES)
		    {

				$uploaddir  = 'assets/images/upload_tools';
				$uploaddirc = 'assets/images/upload_pr';

				foreach ($_FILES['filepr']['name'] as $key => $value)
				{

					$temp_file_location = $_FILES['filepr']['tmp_name'][$key];
					
					$upload = $this->fileupload->filehandling($uploaddir,$temp_file_location,$value);
					print_r($upload);
					if ($upload[0] == 'Success')
					{	
						$file_name = $upload[1];

						$file_upload = array(
		                  'tool_id'       => $id_tool,
		                  'file_name'     => $file_name,
		                  'type'          => $type_tool,
		                  'uploader'      => $_SESSION['myuser']['karyawan_id'],
		                  'date_created'  => date('Y-m-d H:i:s'),
		                  'log_tool_id'   => '0',
		                );
		              $this->db->insert('tbl_upload_tools', $file_upload);
		              $pht_tool = $this->db->insert_id();	
					}


					$upload1 = $this->fileupload->filehandling($uploaddirc,$temp_file_location,$value);
				
					if ($upload1[0] == 'Success')
					{
						$file_name = $upload1[1];

						$file_upload = array(
							'pr_id'         => $type_id,
							'sub_id'		=> $sub_id,
							'file_name'     => $file_name,
							'uploader'      => $_SESSION['myuser']['karyawan_id'],
							'date_created'  => date('Y-m-d H:i:s'),
							'type'			=> $type,
						);
						$this->db->insert('tbl_upload_pr', $file_upload);
						$upl_id = $this->db->insert_id();
					}


				}

  			}

		}


    	public function finish_job($id)
    	{
    		$sql ="SELECT id FROM tbl_karyawan WHERE position_id='5'";
    		$res = $this->db->query($sql)->row_array();
    		$kar_id = $res['id'];

    		$this->mpoint->addPoint2('0.1','5', $id,'',$kar_id);

    		$this->db->where('id',$id);
			$this->db->update('tbl_purchasing', array('status_point' => '1'));

    	}


    	public function AddrecomendPoint()
		{
		    if($this->input->post()) 
		    {
		    	
				$recomend_point 		 = $this->input->post("recomend_point");
				$keterangan 			 = $this->input->post("keterangan");
				$pr_id 				 = $this->input->post("pr_id");
				$datetime				 = date('Y-m-d h:i:s');

				$recomend_id = $this->mpoint->AddRecomendPoint('5', $pr_id, $recomend_point, $keterangan);

				$pesan = 'Menambahkan <b>Rekomendasi Point</b><br> <b>Alasan : </b>'. $keterangan;

				$sql = "SELECT id FROM tbl_pr_log WHERE pr_id = $pr_id ORDER BY id DESC LIMIT 1";
				$que = $this->db->query($sql)->row_array();
				$log_pr = $que['id'];

				$addpsn = array(
					'pr_id' => $pr_id,
					'log_pr_id'	=> $log_pr,
					'sender' => $_SESSION['myuser']['karyawan_id'],
					'pesan'	=> $pesan,
					'date_created'	=> date('Y-m-d H:i:s'), 
					);
				$this->db->insert('tbl_pr_pesan', $addpsn);
				$pesan_id = $this->db->insert_id();

				$isinotif  = 'Add Recommendation Point to PR ID '. $pr_id;
				$url   = 'purchasing/details/'.$pr_id;

				$notif = array(
			            'modul' 		=> '5',
			            'modul_id' 		=> $pr_id,
			            'record_id' 	=> $pesan_id,
			            'record_type' 	=> '28',
			            'user_id' 		=> '2',
			            'date_created' 	=> date('Y-m-d H:i:s'),
			            'url'			=> $url,
			            'notes'			=> $isinotif,
	        	);
	    		$this->db->insert('tbl_notification', $notif);
				
		    }   
		}


		public function AddPoint()
        {
        	$point 			  = $this->input->post('point');
        	$point 			  = str_replace(',', '.', $point);
        	$pr_id 		  	  = $this->input->post('pr_id');
        	$penjelasan_final = $this->input->post("penjelasan_final");
        	$img_coin 		  = site_url('assets/images/dollar.png');
        	$calculate		  = $this->input->post('calculate');
        	$karyawan 		  = $this->input->post('karyawan');

        	$sql ="SELECT id FROM tbl_karyawan WHERE position_id='12'";
        	$res = $this->db->query($sql)->row_array();
        	$executor		  = $res['id'];

        	$this->db->where('id', $pr_id);
        	$this->db->update('tbl_purchasing', array('point_pr' => $point));


        	if($calculate=='add')
        	{

	        	$this->mpoint->addPoint2($point,'5', $pr_id,$karyawan,$executor);
	        	
		   
				$sql = "SELECT id FROM tbl_pr_log WHERE pr_id = $pr_id ORDER BY id DESC LIMIT 1";
				$que = $this->db->query($sql)->row_array();
				$log_pr = $que['id'];

				$addpsn = array(
					'pr_id' => $pr_id,
					'log_pr_id'	=> $log_pr,
					'sender' => $_SESSION['myuser']['karyawan_id'],
					'pesan'	=> "Menambahkan point <img src='".$img_coin ."' /><img src='".$img_coin ."' />
											<br> Alasan : ".$penjelasan_final,
					'date_created'	=> date('Y-m-d H:i:s'), 
					);
				$this->db->insert('tbl_pr_pesan', $addpsn);
				$pesan_id = $this->db->insert_id();


				$isinotif = $_SESSION['myuser']['nickname'] ." Add Point At <b>PR ID ".$pr_id. "</b>";
				$url = 'purchasing/details/'.$pr_id;

				$this->notification($pr_id, $pesan_id, '35', $executor,$isinotif,$url);  
        	}
        	elseif($calculate=='pindah')
        	{

	        	$this->mpoint->addPoint2($point,'5',$pr_id, $karyawan,$executor);
	        	$this->mpoint->minPoint($point,'5',$pr_id, $karyawan,$executor);
	        

				$sql = "SELECT id FROM tbl_pr_log WHERE pr_id = $pr_id ORDER BY id DESC LIMIT 1";
				$que = $this->db->query($sql)->row_array();
				$log_pr = $que['id'];

				$addpsn = array(
					'pr_id' => $pr_id,
					'log_pr_id'	=> $log_pr,
					'sender' => $_SESSION['myuser']['karyawan_id'],
					'pesan'	=> "memindahkan pointdari ".$karyawan." ke ".$executor." <br> Alasan : ".$penjelasan_final,
					'date_created'	=> date('Y-m-d H:i:s'), 
					);
				$this->db->insert('tbl_pr_pesan', $addpsn);
				$pesan_id = $this->db->insert_id();


				$isinotif = $_SESSION['myuser']['nickname'] ." reduce your points At <b>PR ID ".$pr_id. "</b>";
				$url = 'purchasing/details/'.$import_id;

				$this->notification($pr_id, $pesan_id, '35', $karyawan,$isinotif,$url);  
        	}
        	elseif($calculate=='min')
        	{
	
		        	$this->mpoint->minPoint($point,'5',$pr_id, $karyawan,$executor);

					$sql = "SELECT id FROM tbl_pr_log WHERE pr_id = $pr_id ORDER BY id DESC LIMIT 1";
					$que = $this->db->query($sql)->row_array();
					$log_pr = $que['id'];

					$addpsn = array(
						'pr_id' => $pr_id,
						'log_pr_id'	=> $log_pr,
						'sender' => $_SESSION['myuser']['karyawan_id'],
						'pesan'	=> "Mengurangi point <img src='".$img_coin ." ' /><img src='".$img_coin ."' /> dari "
											.$karyawan."<br> Alasan : ".$penjelasan_final,
						'date_created'	=> date('Y-m-d H:i:s'), 
						);
					$this->db->insert('tbl_pr_pesan', $addpsn);
					$pesan_id = $this->db->insert_id();

					$isinotif = $_SESSION['myuser']['nickname'] ." reduce your points At <b>Import ID ".$pr_id. "</b>";
					$url = 'purchasing/details/'.$pr_id;

					$this->notification($import_id, $psn_id, '35', $karyawan,$isinotif,$url);
        	}

        	return $pr_id;
        }


        public function ValidationReceiveold()
        {
        	$ptg_saldo = $this->input->post('ptg_saldo');
            $vendor_id = $this->input->post('vendor_id');
            $pr_id = $this->input->post('pr_id');
            $receive_amount1 = $this->input->post('receive_amount');
            $receive_amount = str_replace(".", "", $receive_amount1);
            $harga_beli1 = $this->input->post('harga_beli');
            $harga_beli = str_replace(".", "", $harga_beli1);
            $kar_id = $this->input->post('user_receive');
            $selisih = $receive_amount - $harga_beli;

        	$sql = " SELECT * FROM tbl_kasbon_cash WHERE karyawan_id ='$kar_id'";
	    	$res = $this->db->query($sql)->row_array();

	    	$kasbon_id = $res['id'];
	    	// $karyawan = $res['sales_id'];
	    	$interval_reminder = $res['interval_reminder'];
	    	$balance = $res['balance'];
	    	// $balance = $balance - $harga_beli;
	    	// $reminder_date = Date('Y-m-d', strtotime("+".$interval_reminder." days"))

            if($ptg_saldo =='1')
            {
	            $sql = " SELECT * FROM tbl_kasbon_cash WHERE karyawan_id ='$kar_id'";
			    $res = $this->db->query($sql)->row_array();

			    $kasbon_id 			= $res['id'];
			    $interval_reminder  = $res['interval_reminder'];
			    $balance 			= $res['balance'];

			    $descrip = "Selisih Saldo pada PR ID ". $pr_id." Untuk Item ID ".$vendor_id;

	            // 11 maret 2020
	            if($selisih >= '0' )
	            {
	                if($selisih > '0')
	                {     
		            	$balance = $balance - $selisih;

		            	$arr = "debit";

			            $this->db->where('id', $kasbon_id);
		                $this->db->update('tbl_kasbon_cash', array('last_update'=> date('Y-m-d H:i:s'),'balance'=>$balance));

		                $this->selisih($kar_id,$kasbon_id,$selisih,$balance,$pr_id,$arr,$descrip);
	            	}

	            }
	            elseif($selisih < '0')
	            {
	            	$selisih = str_replace("-", "", $selisih);
	            	$balance = $balance + $selisih;
	            	$arr = "credit";

		            $this->db->where('id', $kasbon_id);
	                $this->db->update('tbl_kasbon_cash', array('last_update'=> date('Y-m-d H:i:s'),'balance'=>$balance));

	                $this->selisih($kar_id,$kasbon_id,$selisih,$balance,$pr_id,$arr,$descrip);
	            }
        	}

            $args = array
					(
	                'amount_verified' 	    => $receive_amount,
	                'user_verified'			=> $_SESSION['myuser']['karyawan_id'],
	                'date_verified'			=> date('Y-m-d H:i:s'),
	                );
	        $this->db->where('id', $vendor_id);
	        $this->db->update('tbl_pr_vendor', $args);

		    $sql = "SELECT id FROM tbl_pr_log WHERE pr_id = $pr_id ORDER BY id DESC LIMIT 1";
			$que = $this->db->query($sql)->row_array();
			$log_pr = $que['id'];
			
	    	$addpsn = array(
					'pr_id' => $pr_id,
					'log_pr_id'	=> $log_pr,
					'sender' => $_SESSION['myuser']['karyawan_id'],
					'pesan'	=> 'Receive Item ID <b style="color:green;">'.$vendor_id.'</b>, harga verified Rp. <b style="color:green;">'.$receive_amount1.'</b>',
					'date_created'	=> date('Y-m-d H:i:s'),
					);
			$this->db->insert('tbl_pr_pesan', $addpsn);
			$pesan_id = $this->db->insert_id();

			/*$sql ="SELECT total_receive FROm tbl_purchasing WHERE id='$pr_id'";
			$res =$this->db->query($sql)->row_array();
			$total = $res['total_receive'];*/

			$sql ="SELECT SUM(amount_verified) as total FROM tbl_pr_vendor WHERE pr_id='$pr_id'";
			$res  = $this->db->query($sql)->row_array();
			$total = $res['total'];

			//$total_receive = $total + $receive_amount;

			$this->db->where('id',$pr_id);
			$this->db->update('tbl_purchasing', array('total_receive' => $total));

			//$total = $harga_beli - $receive_ammount;
        }

        public function ValidationReceive()
        {
        	$ptg_saldo = $this->input->post('ptg_saldo');
            $vendor_id = $this->input->post('vendor_id');
            $pr_id = $this->input->post('pr_id');
            $receive_amount1 = $this->input->post('receive_amount');
            $receive_amount = str_replace(".", "", $receive_amount1);
            $harga_beli1 = $this->input->post('harga_beli');
            $harga_beli = str_replace(".", "", $harga_beli1);
            $kar_id = $this->input->post('user_receive');
            $selisih = $receive_amount - $harga_beli;

            $sql_sts = "SELECT status FROM tbl_purchasing WHERE id ='$pr_id'";
            $res_sts = $this->db->query($sql_sts)->row_array();
            $status  = $res_sts['status'];


             $args = array(
		                'amount_verified' 	    => $receive_amount,
		                'user_verified'			=> $_SESSION['myuser']['karyawan_id'],
		                'date_verified'			=> date('Y-m-d H:i:s'),
		                );
		     $this->db->where('id', $vendor_id);
		     $this->db->update('tbl_pr_vendor', $args);


            if($status != 'CANCELED')
            {

	        	$sql = " SELECT * FROM tbl_kasbon_cash WHERE karyawan_id ='$kar_id'";
		    	$res = $this->db->query($sql)->row_array();

		    	$kasbon_id = $res['id'];
		    	$interval_reminder = $res['interval_reminder'];
		    	$balance = $res['balance'];

	            if($ptg_saldo =='1')
	            {
		            $sql = " SELECT * FROM tbl_kasbon_cash WHERE karyawan_id ='$kar_id'";
				    $res = $this->db->query($sql)->row_array();

				    $kasbon_id 			= $res['id'];
				    $interval_reminder  = $res['interval_reminder'];
				    $balance 			= $res['balance'];

				    $descrip = "Selisih Saldo pada PR ID ". $pr_id." Untuk Item ID ".$vendor_id;

				    $this->potong_cashtopup($pr_id,$vendor_id);
					$this->tf_to_tools($pr_id,$vendor_id);
	        	}


			    $sql = "SELECT id FROM tbl_pr_log WHERE pr_id = '$pr_id' ORDER BY id DESC LIMIT 1";
				$que = $this->db->query($sql)->row_array();
				$log_pr = $que['id'];
				
		    	$addpsn = array(
						'pr_id' => $pr_id,
						'log_pr_id'	=> $log_pr,
						'sender' => $_SESSION['myuser']['karyawan_id'],
						'pesan'	=> 'Receive Item ID <b style="color:green;">'.$vendor_id.'</b>, harga verified Rp. <b style="color:green;">'.$receive_amount1.'</b>',
						'date_created'	=> date('Y-m-d H:i:s'),
						);
				$this->db->insert('tbl_pr_pesan', $addpsn);
				$pesan_id = $this->db->insert_id();

				// $this->finish_otomatis($pr_id);

				$sql ="SELECT SUM(amount_verified) as total FROM tbl_pr_vendor WHERE pr_id='$pr_id'";
				$res  = $this->db->query($sql)->row_array();
				$total = $res['total'];

				//$total_receive = $total + $receive_amount;

				$this->db->where('id',$pr_id);
				$this->db->update('tbl_purchasing', array('total_receive' => $total));

				//$total = $harga_beli - $receive_ammount;

				
			}
        }


        public function selisih($kar_id,$kasbon_id,$selisih,$balance,$pr_id,$arr,$descrip)
        {

        	$insert = array(
	                            'karyawan_id'   =>  $kar_id, 
	                            'kasbon_id'     =>  $kasbon_id,
	                            $arr            =>  $selisih,
	                            'balance'       =>  $balance,
	                            'date_created'  =>  date('Y-m-d H:i:s'),
	                            'user'          =>  $_SESSION['myuser']['karyawan_id'],
	                            'description'   =>  $descrip,
	                            'pr_id'			=>  $pr_id,
	                            );
	        $this->db->insert('tbl_kasbon_rekening_koran', $insert);

	        $pesan = array(
                                    'kasbon_id'       => $kasbon_id,
                                    'user'            => '133',
                                    'pesan'           => $descrip,
                                    'date_created'    => date('Y-m-d H:i:s'),
                                );
            $this->db->insert('tbl_kasbon_pesan', $pesan);
            $psn_id = $this->db->insert_id();
        }


		
		// Wishlist ID : 43486
		public function update_pr($pr_id)
		{
			if($this->input->post())
			{

				$jenis_pembelian 	= $this->input->post('jenis_pembelian');
				$biaya_piutang 		= $this->input->post('biaya_piutang');
				$deadline1 			= $this->input->post('deadline');
				$deadline 			= preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $deadline1);
				$divisi 			= $this->input->post('divisi');
				$source_pengadaan 	= $this->input->post('source_pengadaan');
				$purchaser 			= $this->input->post('purchaser');
				$receiver 			= $this->input->post('receiver');
				$ptg_omset 			= $this->input->post('ptg_omset');
				$nextto 			= $this->input->post('nextto');
				$id_nextto 			= $this->input->post('id_overto');
				$pr_id 				= $this->input->post('pr_id'); 
				$psn 				= '';

				$sql="SELECT nickname FROM tbl_loginuser WHERE karyawan_id='$purchaser'";
				$prc = $this->db->query($sql)->row_array();
				$nama_purchaser = $prc['nickname'];


				$sql="SELECT nickname FROM tbl_loginuser WHERE karyawan_id='$receiver'";
				$recv = $this->db->query($sql)->row_array();
				$nama_receiver = $recv['nickname'];

				$sql="SELECT nickname FROM tbl_loginuser WHERE karyawan_id='$nextto'";
				$nxt = $this->db->query($sql)->row_array();
				$name_overto = $nxt['nickname'];


				if($biaya_piutang =='1')
				{
					$biaya ='Biaya';
				}else
				{
					$biaya ='Piutang';
				}

				if($source_pengadaan =='0')
				{
					$source ='Lokal';
				}else
				{
					$source ='Import';
				}

				if($ptg_omset =='0')
				{
					$ptg ='Tidak';
				}else
				{
					$ptg ='Ya';
				}

				$sql ="SELECT pr.*, lgn.nickname as nama_purchaser, lgn1.nickname as nama_receiver FROM tbl_purchasing pr
					   LEFT JOIN tbl_loginuser lgn ON lgn.karyawan_id = pr.purchaser
					   LEFT JOIN tbl_loginuser lgn1 ON lgn1.karyawan_id = pr.receiver
					   where pr.id ='$pr_id'";
				$res = $this->db->query($sql)->row_array();
				$jenis_pembelian_old 	= $res['alasan_pembelian'];
				$nama_purchaser_old 	= $res['nama_purchaser'];
				$nama_receiver_old 		= $res['nama_receiver'];


				if($res['biaya_piutang'] =='1')
				{
					$biaya_old ='Biaya';
				}else
				{
					$biaya_old ='Piutang';
				}

				if($res['source_pengadaan'] =='0')
				{
					$source_old ='Lokal';
				}else
				{
					$source_old ='Import';
				}

				if($res['ptg_omset'] =='0')
				{
					$ptg_old ='Tidak';
				}else
				{
					$ptg_old ='Ya';
				}


				$sql ="SELECT * FROM tbl_pr_overto WHERE id='$id_nextto'";
				$re = $this->db->query($sql)->row_array();
		

				if($biaya_piutang != $res['biaya_piutang'])
				{
					$psn .='From '.$biaya_old.' To '.$biaya.'.<br>';
				}

				if($jenis_pembelian != $jenis_pembelian_old)
				{
					$psn .='Jenis Pembelian From '.$res['alasan_pembelian'].' To '.$jenis_pembelian.'.<br>';
				}
				
				if($source_pengadaan != $res['source_pengadaan'])
				{
					$psn .='Source Pengadaan From '.$source_old.' To '.$source.'.<br>';
				}


				if($ptg_omset != $res['ptg_omset'])
				{
					$psn .='Potong Omset From '.$ptg_old.' To '.$ptg.'.<br>';
				}

				if($deadline != $res['date_deadline'])
				{
					$psn .='Deadline From '.date('d-m-Y',strtotime($res['deadline'])).' To '.$deadline1.'.<br>';
				}

				if($divisi != $res['divisi'])
				{
					$psn .='Divisi From '.$res['divisi'].' To '.$divisi.'.<br>';
				}


				if($nama_purchaser != $nama_purchaser_old)
				{	
					$psn .='Purchaser From '.$nama_purchaser_old.' To '.$nama_purchaser.'.<br>';
				}
		
				if($nama_receiver != $nama_receiver_old)
				{
					$psn .='Receiver From '.$nama_receiver_old.' To '.$nama_receiver.'.<br>';
				}


				$sql ="SELECT ov.*,lgn.nickname FROM tbl_pr_overto ov
					   LEFT JOIN tbl_loginuser lgn ON lgn.karyawan_id = ov.overto
					   WHERE ov.id='$id_nextto'";
				$re = $this->db->query($sql)->row_array();
				$name_overto_old = $re['nickname'];

				if($name_overto != $name_overto_old)
				{
					$psn .='Overto From '.$name_overto_old.' To '.$name_overto.'.<br>';
				}


				$rr = array(
					'alasan_pembelian' 	=> $jenis_pembelian,
					'biaya_piutang'	   	=> $biaya_piutang,
					'date_deadline'		=> $deadline,
					'divisi'		  	=> $divisi,
					'source_pengadaan'	=> $source_pengadaan,
					'purchaser'		  	=> $purchaser,
					'receiver'		  	=> $receiver,
					'ptg_omset'		  	=> $ptg_omset,
				);
	            $this->db->where('id',$pr_id);
	            $this->db->update('tbl_purchasing',$rr);



				$arr = array(
					'overto' 	=> $nextto,
				);
	            $this->db->where('id',$id_nextto);
	            $this->db->update('tbl_pr_overto',$arr);


	            if($psn!='')
	            {
		            $sql = "SELECT id FROM tbl_pr_log WHERE pr_id = $pr_id ORDER BY id DESC LIMIT 1";
					$que = $this->db->query($sql)->row_array();
					$log_pr = $que['id'];

					$addpsn = array(
							'pr_id' => $pr_id,
							'log_pr_id'	=> $log_pr,
							'sender' => $_SESSION['myuser']['karyawan_id'],
							'pesan'	=> 'Update <br> '.$psn,
							'date_created'	=> date('Y-m-d H:i:s'), 
							);
					$this->db->insert('tbl_pr_pesan', $addpsn);
					$pesan_id = $this->db->insert_id();
				}

			}
		}


		
	public function if_mobil($kilometer_akhir,$km_serv)
	{
		// print_r($kilometer_akhir);
		// print_r("<br>");
		// print_r($km_serv);
		// die;

		$service1 = 'Ganti Oli Mesin setiap 5000km + Cek kampas Rem';
		$service2 = 'Ganti Oli Filter  Setiap 10000km';
		$service3 = 'Ganti Air Filter 30000km';
		$service4 = 'Ganti Oli Transmisi Setiap 60000km';
		$service5 = 'Ganti Oli GardanSetiap  60000km';
		$service6 = 'Tune Up Setiap 30000km';
		$service7 = 'Pemeriksaan sistem anti karat elektrik setiap 30000Km';




			if($kilometer_akhir >= 5000 AND $kilometer_akhir < 10000 AND $km_serv !='5000')
			{
				$description 	= $service1;
				$km_service     = '5000';
				$ptrs_km 		 ='0';
			}
			elseif($kilometer_akhir >= 10000 AND $kilometer_akhir < 30000)
			{
				if($kilometer_akhir >= 10000 AND $kilometer_akhir < 15000 AND $km_serv !='10000')
				{
					$description 	 = $service1."<br>";
					$description 	.= $service2."<br>";
					$km_service      = '10000';
					$ptrs_km 		 ='0';
				}
				elseif($kilometer_akhir >= 15000 AND $kilometer_akhir < 20000 AND $km_serv !='15000')
				{
					$description 	= $service1;
					$km_service      = '15000';
					$ptrs_km 		 ='0';
				}
				elseif($kilometer_akhir >= 20000 AND $kilometer_akhir < 25000 AND $km_serv !='20000')
				{
					$description 	 = $service1."<br>";
					$description 	.= $service2."<br>";
					$km_service      = '20000';
					$ptrs_km 		 ='0';
				}
				elseif($kilometer_akhir >= 25000 AND $kilometer_akhir < 30000 AND $km_serv !='25000')
				{
					$description 	 = $service1;
					$km_service      = '25000';
					$ptrs_km 		 ='0';
				}
				
			}
			elseif($kilometer_akhir >= 30000 AND $kilometer_akhir < 60000)
			{

				if($kilometer_akhir >= 30000 AND $kilometer_akhir < 35000 AND $km_serv !='30000')
				{
					$description 	 = $service1."<br>";
					$description 	.= $service2."<br>";
					$description 	.= $service3."<br>";
					$description 	.= $service6."<br>";
					$description 	.= $service7."<br>";
					$km_service      = '30000';
					$ptrs_km 		 ='0';
				}
				elseif($kilometer_akhir >= 35000 AND $kilometer_akhir < 40000 AND $km_serv !='35000')
				{
					
					$description 	 = $service1."<br>";
					$description 	.= $service2."<br>";
					$km_service      = '35000';
					$ptrs_km 		 ='0';
				}
				elseif($kilometer_akhir >= 40000 AND $kilometer_akhir < 45000 AND $km_serv !='40000')
				{
					
					$description 	 = $service1."<br>";
					$km_service      = '40000';
					$ptrs_km 		 ='0';
				}
				elseif($kilometer_akhir >= 45000 AND $kilometer_akhir < 50000 AND $km_serv !='45000')
				{
					
					$description 	 = $service1."<br>";
					$description 	.= $service2."<br>";
					$km_service      = '45000';
					$ptrs_km 		 ='0';
				}
				elseif($kilometer_akhir >= 50000 AND $kilometer_akhir < 55000 AND $km_serv !='50000')
				{
					
					$description 	 = $service1."<br>";
					$km_service      = '50000';
					$ptrs_km 		 ='0';
				}
				elseif($kilometer_akhir >= 55000 AND $kilometer_akhir < 60000 AND $km_serv !='55000')
				{
					
					$description 	 = $service1."<br>";
					$description 	.= $service2."<br>";
					$description 	.= $service3."<br>";
					$km_service      = '55000';
					$ptrs_km 		 ='0';
				}
			}elseif($kilometer_akhir >= 60000 AND $kilometer_akhir <  100000)
			{
				if($kilometer_akhir >= 60000 AND $kilometer_akhir < 65000 AND $km_serv !='60000')
				{
					
					$description 	 = $service1."<br>";
					$description 	.= $service2."<br>";
					$description 	.= $service3."<br>";
					$description 	.= $service4."<br>";
					$description 	.= $service5."<br>";
					$description 	.= $service6."<br>";
					$description 	.= $service7."<br>";
					$km_service      = '60000';
					$ptrs_km 		 ='0';
				}
				elseif($kilometer_akhir >= 65000 AND $kilometer_akhir < 70000 AND $km_serv !='65000')
				{
					
					$description 	 = $service1."<br>";
					$km_service      = '65000';
					$ptrs_km 		 ='0';
				}
				elseif($kilometer_akhir >= 70000 AND $kilometer_akhir < 75000 AND $km_serv !='70000')
				{
					$description 	 = $service1."<br>";
					$description 	.= $service2."<br>";
					$km_service      = '70000';
					$ptrs_km 		 ='0';
				}
				elseif($kilometer_akhir >= 75000 AND $kilometer_akhir < 80000 AND $km_serv !='75000')
				{
					
					$description 	 = $service1."<br>";
					$km_service      = '75000';
					$ptrs_km 		 ='0';
				}
				elseif($kilometer_akhir >= 80000 AND $kilometer_akhir < 85000 AND $km_serv !='80000')
				{
					
					$description 	 = $service1."<br>";
					$description 	.= $service2."<br>";
					$km_service      = '80000';
					$ptrs_km 		 ='0';
				}
				elseif($kilometer_akhir >= 85000 AND $kilometer_akhir < 90000 AND $km_serv !='85000')
				{
					
					$description 	 = $service1."<br>";
					$km_service      = '85000';
					$ptrs_km 		 ='0';
				}
				elseif($kilometer_akhir >= 90000 AND $kilometer_akhir <= 100000 AND $km_serv !='90000')
				{
					
					$description 	 = $service1."<br>";
					$description 	.= $service2."<br>";
					$description 	.= $service3."<br>";
					$description 	.= $service6."<br>";
					$description 	.= $service7."<br>";
					$km_service      = '90000';
					$ptrs_km 		 ='1';
				
				}
				
			}else
			{
				$description='';
				$km_service='';
				$ptrs_km='';
			}

			$arr=array(
				 'description' => $description,
				 'km_service'  => $km_service,
				 'ptrs_km'	   => $ptrs_km,
			);
			return $arr;
		}

		public function if_motor($kilometer_akhir,$km_serv)
		{

			$service1 = 'Ganti Oli setiap 2500KM + cek kampas Rem';
			$service2 = 'Servis setiap 10000KM';


						if($kilometer_akhir >= 2500 AND $kilometer_akhir < 10000)
						{
						
							if($kilometer_akhir >= 2500 AND $kilometer_akhir < 5000 AND $km_serv !='2500')
							{
								$description =$service1."<br>";
								$km_service  = 2500;
								$ptrs_km   = '0';
							}
							elseif($kilometer_akhir >= 5000 AND $kilometer_akhir < 7500 AND $km_serv !='5000')
							{
								$description =$service1."<br>";
								$km_service   = 5000;
								$ptrs_km   = '0';
							
							}elseif($kilometer_akhir >= 7500 AND $kilometer_akhir < 10000 AND $km_serv !='7500')
							{
								$description =$service1."<br>";
								$km_service   = 7500;
								$ptrs_km   = '0';
							}
										    		
						}
						elseif($kilometer_akhir >= 10000  AND $kilometer_akhir < 100000)
						{
							if($kilometer_akhir >= 10000 AND $kilometer_akhir < 12500 AND $km_serv !='10000')
							{
								$description = $servis1."<br>";
								$description .=$service2."<br>";
								$km_service   = 10000;
								$ptrs_km   = '0';
							}
							elseif($kilometer_akhir >= 12500 AND $kilometer_akhir < 15000 AND $km_serv !='12500')
							{
								$description = $servis1."<br>";
								$km_service   = 12500;
								$ptrs_km   = '0';
							}
							elseif($kilometer_akhir >= 15000 AND $kilometer_akhir < 17500 AND $km_serv !='15000')
							{
								$description = $servis1."<br>";
								$km_service   = 15000;
								$ptrs_km   = '0';
							}
							elseif($kilometer_akhir >= 17500 AND $kilometer_akhir < 20000 AND $km_serv !='17500')
							{
								$description = $servis1."<br>";
								$km_service   = 17500;
								$ptrs_km   = '0';
							}
							elseif($kilometer_akhir >= 20000 AND $kilometer_akhir < 22500 AND $km_serv !='20000')
							{
								$description = $servis1."<br>";
								$description .= $servis2."<br>";
								$km_service   = 20000;
								$ptrs_km   = '0';
							}
							elseif($kilometer_akhir >= 22500 AND $kilometer_akhir < 25000 AND $km_serv !='22500')
							{
								$description = $servis1."<br>";
								$km_service   = 22500;
								$ptrs_km   = '0';
							}
							elseif($kilometer_akhir >= 25000 AND $kilometer_akhir < 27500 AND $km_serv !='25000')
							{
								$description = $servis1."<br>";
								$km_service   = 25000;
								$ptrs_km   = '0';
							}
							elseif($kilometer_akhir >= 27500 AND $kilometer_akhir < 30000 AND $km_serv !='27500')
							{
								$description = $servis1."<br>";
								$km_service   = 27500;
								$ptrs_km   = '0';
							}
							elseif($kilometer_akhir >= 30000 AND $kilometer_akhir < 32500 AND $km_serv !='30000')
							{
								$description = $servis1."<br>";
								$description .= $servis2."<br>";
								$km_service   = 30000;
								$ptrs_km   = '0';
							}
							elseif($kilometer_akhir >= 32500 AND $kilometer_akhir < 35000 AND $km_serv !='32500')
							{
								$description = $servis1."<br>";
								$km_service   = 32500;
								$ptrs_km   = '0';
							}
							elseif($kilometer_akhir >= 35000 AND $kilometer_akhir < 37500 AND $km_serv !='35000')
							{
								$description = $servis1."<br>";
								$km_service   = 35000;
								$ptrs_km   = '0';
							}
							elseif($kilometer_akhir >= 37500 AND $kilometer_akhir < 40000 AND $km_serv !='30000')
							{
								$description = $servis1."<br>";
								$km_service   = 37500;
								$ptrs_km   = '0';
							}
							elseif($kilometer_akhir >= 40000 AND $kilometer_akhir < 42500 AND $km_serv !='30000')
							{
								$description = $servis1."<br>";
								$description .= $servis2."<br>";
								$km_service   = 40000;
								$ptrs_km   = '0';
							}
							elseif($kilometer_akhir >= 42500 AND $kilometer_akhir < 45000 AND $km_serv !='42500')
							{
								$description = $servis1."<br>";
								$km_service   = 42500;
								$ptrs_km   = '0';
							}
							elseif($kilometer_akhir >= 45000 AND $kilometer_akhir < 47500 AND $km_serv !='45000')
							{
								$description = $servis1."<br>";
								$km_service   = 45000;
								$ptrs_km   = '0';
							}
							elseif($kilometer_akhir >= 47500 AND $kilometer_akhir < 50000 AND $km_serv !='47500')
							{
								$description = $servis1."<br>";
								$km_service   = 47500;
								$ptrs_km   = '0';
							}elseif($kilometer_akhir >= 50000 AND $kilometer_akhir < 52500 AND $km_serv !='50000')
							{
								$description = $servis1."<br>";
								$description .= $servis2."<br>";
								$km_service   = 50000;
								$ptrs_km   = '0';
							}elseif($kilometer_akhir >= 52500 AND $kilometer_akhir < 55000 AND $km_serv !='52500')
							{
								$description = $servis1."<br>";
								$km_service   = 52500;
								$ptrs_km   = '0';
							}
							elseif($kilometer_akhir >= 55000 AND $kilometer_akhir < 57500 AND $km_serv !='55000')
							{
								$description = $servis1."<br>";
								$km_service   = 55000;
								$ptrs_km   = '0';
							}elseif($kilometer_akhir >= 57500 AND $kilometer_akhir < 60000 AND $km_serv !='57500')
							{
								$description = $servis1."<br>";
								$km_service   = 57500;
								$ptrs_km   = '0';
							}elseif($kilometer_akhir >= 60000 AND $kilometer_akhir < 62500 AND $km_serv !='60000')
							{
								$description = $servis1."<br>";
								$description .= $servis2."<br>";
								$km_service   = 60000;
								$ptrs_km   = '0';
							}elseif($kilometer_akhir >= 62500 AND $kilometer_akhir < 65000 AND $km_serv !='62500')
							{
								$description = $servis1."<br>";
								$km_service   = 62500;
								$ptrs_km   = '0';
							}elseif($kilometer_akhir >= 65000 AND $kilometer_akhir < 67500 AND $km_serv !='65000')
							{
								$description = $servis1."<br>";
								$km_service   = 65000;
								$ptrs_km   = '0';
							}elseif($kilometer_akhir >= 67500 AND $kilometer_akhir < 70000 AND $km_serv !='67500')
							{
								$description = $servis1."<br>";
								$km_service   = 67500;
								$ptrs_km   = '0';
							}elseif($kilometer_akhir >= 70000 AND $kilometer_akhir < 72500 AND $km_serv !='70000')
							{
								$description = $servis1."<br>";
								$description .= $servis2."<br>";
								$km_service   = 70000;
								$ptrs_km   = '0';
							}
							elseif($kilometer_akhir >= 72500 AND $kilometer_akhir < 75000 AND $km_serv !='72500')
							{
								$description = $servis1."<br>";
								$km_service   = 72500;
								$ptrs_km   = '0';
							}
							elseif($kilometer_akhir >= 75000 AND $kilometer_akhir < 77500 AND $km_serv !='75000')
							{
								$description = $servis1."<br>";
								$km_service   = 75000;
								$ptrs_km   = '0';
							}elseif($kilometer_akhir >= 77500 AND $kilometer_akhir < 80000 AND $km_serv !='77500')
							{
								$description = $servis1."<br>";
								$km_service   = 77500;
								$ptrs_km   = '0';
							}elseif($kilometer_akhir >= 80000 AND $kilometer_akhir < 82500 AND $km_serv !='80000')
							{
								$description = $servis1."<br>";
								$description .= $servis2."<br>";
								$km_service   = 80000;
								$ptrs_km   = '0';
							}elseif($kilometer_akhir >= 82500 AND $kilometer_akhir < 85000 AND $km_serv !='82500')
							{
								$description = $servis1."<br>";
								$km_service   = 82500;
								$ptrs_km   = '0';
							}
							elseif($kilometer_akhir >= 85000 AND $kilometer_akhir < 87500 AND $km_serv !='85000')
							{
								$description = $servis1."<br>";
								$km_service   = 85000;
								$ptrs_km   = '0';
							}
							elseif($kilometer_akhir >= 87500 AND $kilometer_akhir < 90000 AND $km_serv !='87500')
							{
								$description = $servis1."<br>";
								$km_service   = 87500;
							}
							elseif($kilometer_akhir >= 90000 AND $kilometer_akhir < 92500 AND $km_serv !='90000')
							{
								$description = $servis1."<br>";
								$description .= $servis2."<br>";
								$km_service   = 90000;
								$ptrs_km   = '0';
							}
							elseif($kilometer_akhir >= 92500 AND $kilometer_akhir < 95000 AND $km_serv !='92500')
							{
								$description = $servis1."<br>";
								$km_service   = 92500;
								$ptrs_km   = '0';
							}
							elseif($kilometer_akhir >= 95000 AND $kilometer_akhir < 97500 AND $km_serv !='95000')
							{
								$description = $servis1."<br>";
								$km_service   = 95000;
								$ptrs_km   = '0';
							}
							elseif($kilometer_akhir >= 95000 AND $kilometer_akhir < 97500 AND $km_serv !='95000')
							{
								$description = $servis1."<br>";
								$km_service   = 95000;
								$ptrs_km   = '0';
							}
							elseif($kilometer_akhir >= 97500 AND $kilometer_akhir < 100000 AND $km_serv !='97500')
							{
								$description = $servis1."<br>";
								$km_service   = 97500;
								$ptrs_km   = '1';
							}
						}else
						{
							$description='';
							$km_service='';
							$ptrs_km='';
						}
							
						$arr=array(
							 'description' => $description,
							 'km_service'  => $km_service,
							 'ptrs_km'	   => $ptrs_km,
						);
						return $arr;

		}

		public function notif_ilang($id,$record_type)
    	{
                $user = $_SESSION['myuser']['karyawan_id'];
                $datetime = date('Y-m-d H:i:s');

                $query3 = "UPDATE tbl_notification SET status='1',date_open='$datetime' WHERE modul_id = '$id' AND modul ='5' AND user_id ='$user'";
                $this->db->query($query3);
    	}


    	public function AuditPR($pr_id)
    	{
    		$sql2 = "UPDATE tbl_purchasing SET audit = 'selesai' WHERE id = '$pr_id'";
		    $que = $this->db->query($sql2);

		    $sql 	= "SELECT id FROM tbl_pr_log WHERE pr_id = $pr_id ORDER BY id DESC LIMIT 1";
			$que 	= $this->db->query($sql)->row_array();
			$log_pr = $que['id'];

			$pesan =" PR ini Sudah selesai di Audit";

			$addpsn = array(
				'pr_id' => $pr_id,
				'log_pr_id'	=> $log_pr,
				'sender' => $_SESSION['myuser']['karyawan_id'],
				'pesan'	=> $pesan,
				'date_created'	=> date('Y-m-d H:i:s'),
				);
			$this->db->insert('tbl_pr_pesan', $addpsn);
			$pesan_id = $this->db->insert_id();
    	}


    	public function getRefund($id)
    	{
    		$sql ="SELECT * FROM tbl_refund_link WHERE link_to_id='$id' AND modul='5'";
	        $data_link = $this->db->query($sql)->result_array();

	        // print_r($sql);die;
	        return $data_link;
    	}


    	public function cek_upload_refund($id)
    	{
    		$ref = $this->getRefund($id);

    		if($ref)
    		{	
    			$refund_id = $ref['refund_id'];
    			$sql ="SELECT * FROM tbl_refund_upload WHERE type='Bukti Customer'";
    			$data = $this->db->query($sql)->row_array();
    		}else
    		{
    			$data='';
    		}

    		return $data;
    	}

    	public function file_refund($id)
    	{
    		$ref = $this->getRefund($id);

    		if($ref)
    		{	
    			$refund_id = $ref['refund_id'];
    			$sql ="SELECT * FROM tbl_refund_upload ";
    			$data = $this->db->query($sql)->result_array();
    		}else
    		{
    			$data='';
    		}

    		return $data;

    }

    public function Accept_receive($id,$item_id)
    {
    	$vendor_id = $item_id;
    	$pr_id 	   = $id;
    	$sql ="SELECT * FROM tbl_purchasing WHERE id ='$id'";
    	$data_pr = $this->db->query($sql)->row_array();


    	$sql ="SELECT * FROM tbl_pr_vendor WHERE id='$item_id'";
    	$data_item = $this->db->query($sql)->row_array();

    	$harga_beli 	= $data_item['harga_beli'];
    	$user_receive 	= $data_item['user_receive'];

        $status  = $data_pr['status'];
        $ptg_saldo = $data_item['ptg_saldo'];



    	if($ptg_saldo =='1')
        {
            $sql = " SELECT * FROM tbl_kasbon_cash WHERE karyawan_id ='$kar_id'";
		    $res = $this->db->query($sql)->row_array();

		    $kasbon_id 			= $res['id'];
		    $interval_reminder  = $res['interval_reminder'];
		    $balance 			= $res['balance'];

		    $args = array
					(
	                'amount_verified' 	    => $harga_beli,
	                'user_verified'			=> $_SESSION['myuser']['karyawan_id'],
	                'date_verified'			=> date('Y-m-d H:i:s'),
	                );
	        $this->db->where('id', $vendor_id);
	        $this->db->update('tbl_pr_vendor', $args);

		    $sql = "SELECT id FROM tbl_pr_log WHERE pr_id = '$id' ORDER BY id DESC LIMIT 1";
			$que = $this->db->query($sql)->row_array();
			$log_pr = $que['id'];
			
	    	$addpsn = array(
					'pr_id' => $pr_id,
					'log_pr_id'	=> $log_pr,
					'sender' => $_SESSION['myuser']['karyawan_id'],
					'pesan'	=> 'Receive Item ID <b style="color:green;">'.$vendor_id.'</b>, harga verified Rp. <b style="color:green;">'.number_format($harga_beli).'</b>',
					'date_created'	=> date('Y-m-d H:i:s'),
					);
			$this->db->insert('tbl_pr_pesan', $addpsn);
			$pesan_id = $this->db->insert_id();

			$sql ="SELECT SUM(amount_verified) as total FROM tbl_pr_vendor WHERE pr_id='$pr_id'";
			$res  = $this->db->query($sql)->row_array();
			$total = $res['total'];


			$this->db->where('id',$pr_id);
			$this->db->update('tbl_purchasing', array('total_receive' => $total));

			$this->potong_cashtopup($pr_id,$item_id);
			$this->tf_to_tools($pr_id,$item_id);
        }    
    }


    public function reject_receive($id,$item_id)
    {
    	$vendor_id = $item_id;
    	$pr_id 	   = $id;
    	$sql ="SELECT * FROM tbl_purchasing WHERE id ='$id'";
    	$data_pr = $this->db->query($sql)->row_array();


    	$sql ="SELECT * FROM tbl_pr_vendor WHERE id='$item_id'";
    	$data_item = $this->db->query($sql)->row_array();

    	$harga_beli 	= $data_item['harga_beli'];
    	$user_receive 	= $data_item['user_receive'];
    	$kar_id 		= $data_item['user_receive'];

        $status  = $data_pr['status'];
        $ptg_saldo = $data_item['ptg_saldo'];

        $receive_amount ='0';

    	if($ptg_saldo =='1')
        {
            $sql = " SELECT * FROM tbl_kasbon_cash WHERE karyawan_id ='$kar_id'";
		    $res = $this->db->query($sql)->row_array();

		    $kasbon_id 			= $res['id'];
		    $interval_reminder  = $res['interval_reminder'];
		    $balance 			= $res['balance'];

		    $selisih = $receive_amount-$harga_beli;

		   
		    $descrip = "Reject Potong Saldo pada PR ID ". $pr_id." Untuk Item ID ".$vendor_id;

            // if($selisih >= '0' )
            // {
            //     if($selisih > '0')
            //     {     
	           //  	$balance = $balance - $selisih;

	           //  	$arr = "debit";

		          //   $this->db->where('id', $kasbon_id);
	           //      $this->db->update('tbl_kasbon_cash', array('last_update'=> date('Y-m-d H:i:s'),'balance'=>$balance));

	           //      $this->selisih($kar_id,$kasbon_id,$selisih,$balance,$pr_id,$arr,$descrip);
            // 	}

            // }
            // elseif($selisih < '0')
            // {
            // 	$selisih = str_replace("-", "", $selisih);
            // 	$balance = $balance + $selisih;
            // 	$arr = "credit";

	           //  $this->db->where('id', $kasbon_id);
            //     $this->db->update('tbl_kasbon_cash', array('last_update'=> date('Y-m-d H:i:s'),'balance'=>$balance));

            //     $this->selisih($kar_id,$kasbon_id,$selisih,$balance,$pr_id,$arr,$descrip);
            // }



		    $args = array
					(
	                'amount_verified' 	    => $receive_amount,
	                'user_verified'			=> $_SESSION['myuser']['karyawan_id'],
	                'date_verified'			=> date('Y-m-d H:i:s'),
	                );
	        $this->db->where('id', $vendor_id);
	        $this->db->update('tbl_pr_vendor', $args);

		    $sql = "SELECT id FROM tbl_pr_log WHERE pr_id = '$id' ORDER BY id DESC LIMIT 1";
			$que = $this->db->query($sql)->row_array();
			$log_pr = $que['id'];
			
	    	$addpsn = array(
					'pr_id' => $pr_id,
					'log_pr_id'	=> $log_pr,
					'sender' => $_SESSION['myuser']['karyawan_id'],
					'pesan'	=> 'Reject Item ID <b style="color:red;">'.$vendor_id.'</b>, Rp. <b style="color:green;">'.number_format($receive_amount).'</b>',
					'date_created'	=> date('Y-m-d H:i:s'),
					);
			$this->db->insert('tbl_pr_pesan', $addpsn);
			$pesan_id = $this->db->insert_id();

			$sql ="SELECT SUM(amount_verified) as total FROM tbl_pr_vendor WHERE pr_id='$pr_id'";
			$res  = $this->db->query($sql)->row_array();
			$total = $res['total'];


			$this->db->where('id',$pr_id);
			$this->db->update('tbl_purchasing', array('total_receive' => $total));

			// $this->finish_otomatis($pr_id);

        }    

    }


    public function finish_otomatis($id)
    {
    	$sql ="SELECT count(id) as total_item FROM tbl_pr_vendor WHERE pr_id='$id' AND published='0'";
    	$data_item_pr = $this->db->query($sql)->row_array();

    	$total_item = $data_item_pr['total_item'];

    	$sql ="SELECT count(id) as total_receive FROM tbl_pr_vendor WHERE pr_id='$id' AND published='0' AND user_verified !='0'";
    	$cek_verif = $this->db->query($sql)->row_array();

    	$total_receive = $cek_verif['total_receive'];


    	if($total_receive == $total_item)
    	{

    		$sql = "SELECT id, id_operator, time_login FROM tbl_pr_log WHERE pr_id = '$id' ORDER BY id DESC LIMIT 2";
		    $res = $this->db->query($sql)->result_array();

		    $iddown = $res[0]['id'];
		    
		    if(count($res) > 1 ) 
		    {
		    	$idup = $res[1]['id'];
		    }

		    $user = $_SESSION['myuser']['karyawan_id'];

		    if($_SESSION['myuser']['karyawan_id'] == $res[0]['id_operator'] OR count($res) == 1) {
		      //update overto karyawan_id time login, idle, nextto.
		      $uplog = array(
		        'overto'      => '101',
		        'time_login'  => date('Y-m-d H:i:s'),
		        'time_nextto' => date('Y-m-d H:i:s'),
		        'time_idle'   => date('Y-m-d H:i:s'),
		        );
		      $this->db->where('id', $iddown);
		      $this->db->update('tbl_pr_log', $uplog);

		    }elseif ($_SESSION['myuser']['karyawan_id'] != $res[0]['id_operator']) {

		      if($res[1]['time_login'] != '0000-00-00 00:00:00') {
		        $upnext = array(
		          'overto'      => $user,
		          'time_nextto' => date('Y-m-d H:i:s'),
		          );
		        $this->db->where('id', $iddown);
		        $this->db->update('tbl_pr_log', $upnext);

		        $insert = array(
		          'pr_id'         => $id,
		          'id_operator'   => $user,
		          'overto'		  => '101',
		          'date_created'  => date('Y-m-d H:i:s'),
		          'time_login'    => date('Y-m-d H:i:s'),
		          'time_nextto'   => date('Y-m-d H:i:s'),
		          'time_idle'     => date('Y-m-d H:i:s'),
		          );
		        $this->db->insert('tbl_pr_log', $insert);
		        $iddown = $this->db->insert_id();

		      }elseif ($res[1]['time_login'] == '0000-00-00 00:00:00') {

		        $uplogin = array(
		          'time_login'  => date('Y-m-d H:i:s'),
		          'time_idle'   => date('Y-m-d H:i:s'),
		          );
		        $this->db->where('id', $idup);
		        $this->db->update('tbl_pr_log', $uplogin);

		        $upnext2 = array(
		          'overto'      => $user,
		          'time_nextto' => date('Y-m-d H:i:s'),
		          );
		        $this->db->where('id', $iddown);
		        $this->db->update('tbl_pr_log', $upnext2);

		        $newrow = array(
		          'pr_id'         => $id,
		          'id_operator'   => $user,
		          'overto'		  => '101',
		          'date_created'  => date('Y-m-d H:i:s'),
		          'time_login'    => date('Y-m-d H:i:s'),
		          'time_nextto'   => date('Y-m-d H:i:s'),
		          'time_idle'     => date('Y-m-d H:i:s'),
		          );
		        $this->db->insert('tbl_pr_log', $newrow);
		        $iddown = $this->db->insert_id();
		      }
		    }

	    	$args = array(
		        'status' =>'FINISHED',
		        'date_closed' => date('Y-m-d H:i:s'),
		        'status_finish' => '1',
	       	);
	      	$this->db->where('id', $id);
	      	$this->db->update('tbl_purchasing', $args);

	    	$pesan = array(
		        'pr_id'     => $id,
		        'log_pr_id' => $iddown,
		        'sender'   => $user,
		        'pesan'       => '***** FINISHED *****',
		        'date_created'  => date('Y-m-d H:i:s'),
	        );
	      	$this->db->insert('tbl_pr_pesan', $pesan);
	      	$id_pesan = $this->db->insert_id();

	      	$url 		= $this->mdata->getUrl();
			$isinotif 	= '<b>PR ID '. $id.'</b> has been <b style="color:green;">Finish</b> by '.$_SESSION['myuser']['nickname'];

		    $this->notification($id, $id_pesan, '2', '',$isinotif,$url);

		    if($_SESSION['myuser']['position_id'] == 5)
		    {
		    	$this->finish_job($id);
		    }

    	}

    }


    public function set_potong_saldo($pr_id)
    {	
    	$id 		= $pr_id;
    	$item_id 	= $this->input->post('id');
    	$alasan 	= $this->input->post('alasan');
    	$ptg_saldo 	= $this->input->post('ptg_saldo');


    	$update = array('ptg_saldo' => $ptg_saldo);
    	$this->db->where('id',$item_id);
		$this->db->update('tbl_pr_vendor',$update);


		$sql ="SELECT * FROM tbl_pr_vendor WHERE id='$item_id'";
		$data_item = $this->db->query($sql)->row_array();


		$sql 	= "SELECT id FROM tbl_pr_log WHERE pr_id = '$id 'ORDER BY id DESC LIMIT 1";
		$que 	= $this->db->query($sql)->row_array();
		$log_pr = $que['id'];
		$url 	= $this->mdata->getUrl();


		if($ptg_saldo =='1')
		{
			$pesan ="Set item ".$data_item['items']." Potong Saldo <br>Alasan : ".$alasan;
		}else
		{
			$pesan ="Set item ".$data_item['items']." Tidak Potong Saldo <br>Alasan : ".$alasan;
		}

		$addpsn = array(
				'pr_id' => $id,
				'log_pr_id'	=> $log_pr,
				'sender' => $_SESSION['myuser']['karyawan_id'],
				'pesan'	=> $pesan,
				'date_created'	=> date('Y-m-d H:i:s'),
				);
		$this->db->insert('tbl_pr_pesan', $addpsn);
		$pesan_id = $this->db->insert_id();
    }


    public function TransferTools($item_id,$pr_id)
    {	
    	$sql ="SELECT * FROM tbl_pr_vendor WHERE id='$item_id'";
    	$res = $this->db->query($sql)->row_array();


    	$kar_id = $_SESSION['myuser']['karyawan_id'];

    	if($res['jenis']=='Tool')
		{		

				$query  = "SELECT id FROM tbl_tools";
				$count  = $this->db->query($query)->num_rows();
				$cou 	= $count + 1;
			    $co 	= sprintf("%06s", $cou);
			    $code 	= "A".$co;

				$addtool = array
				(	
					'code' 				    => $code,
		  			'name'				  	=> $res['items'],
		  			'vendor'			 	=> $res['vendor'],
		  			'price'				  	=> $res['harga_beli'],
		  			'date_purchased' 		=> date('Y-m-d H:i:s'),
		  			'date_created'  		=> date('Y-m-d H:i:s'),
		          	'quantity'    			=> $res['qty_approved'],
	  			);
	  			$this->db->insert('tbl_tools', $addtool);
	  			$id_tool = $this->db->insert_id();

				$upd = array(
	                'tool_id' => $id_tool,
	                'date_tf_holder' =>date('Y-m-d H:i:s'),
	                'status_receiver'	=>'0',
			         );
			    $this->db->where('id', $item_id);
			    $this->db->update('tbl_pr_vendor', $upd);

			    $addholder = array(
	          		'tool_id'       => $id_tool,
	          		'user_holder'   => $res['holder'],
	          		'date_created'  => date('Y-m-d H:i:s'),
	          		);
	        	$this->db->insert('tbl_tools_holder', $addholder);

		        if($kar_id != $res['holder']) 
		        {
		            $args = array
		            (
						'tool_id'       => $id_tool,
						'user_pemberi'  => $kar_id,
						'user_penerima' => $res['holder'],
						'date_created'  => date('Y-m-d H:i:s'),
			        );
			        $this->db->insert('tbl_tools_handover', $args);
			        $id_handover = $this->db->insert_id();

		            $approve = array
		            (
			            'tool_id' 		=> $id_tool,
			            'user_create' 	=> $kar_id,
			            'user_approval' => $res['holder'],
			            'date_created'  => date('Y-m-d H:i:s'),
			            'action'		=> 'handover',
			            'action_id'		=> $id_handover,
			            'lvl_approval'	=> 'kar',
			        );
		         	$this->db->insert('tbl_tools_approval', $approve);
		         	$id_appr = $this->db->insert_id();

		         	$urltool = "/tools/details/".$id_tool;
		         	$notiftool 	= "<b>TOOL ID ".$id_tool." </b> Need to Handover Approval.";
					$notif = array(
				            'modul' 		=> '4',
				            'modul_id' 		=> $id_tool,
				            'record_id' 	=> $id_handover,
				            'record_type' 	=> '13',
				            'user_id' 		=> $res['holder'],
				            'date_created' 	=> date('Y-m-d H:i:s'),
				            'url'			=> $urltool,
				            'notes'			=> $notiftool,
		        	);
		    		$this->db->insert('tbl_notification', $notif);
		        }

		        $args = array
		        		(
				          'tool_id'   => $id_tool,
				          'user_report' => $res['holder'],
				          'date_created'  => date('Y-m-d H:i:s'),
		        		);
		        $this->db->insert('tbl_tools_report', $args);
		        $id_rep = $this->db->insert_id();


		        $this->uploadfiletool($id_tool,'0',$pr_id,'3',$id);
	    	}
    }


	public function getFilesItem($pr_id, $log_id)
	{
		$sql = "SELECT up.*, lg.nickname FROM tbl_upload_pr up
				LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = up.uploader
				WHERE pr_id = '$pr_id' AND sub_id = '$log_id' AND up.type IN ('3','7') GROUP BY up.id DESC";
		$res = $this->db->query($sql)->result_array();
		return $res;
	}

	public function cekPenerimaan($pr_id,$log_id)
	{
		$sql ="SELECT * FROM tbl_upload_pr WHERE type ='7' AND sub_id='$log_id' 
			  AND pr_id ='$pr_id'";
		$penerimaan = $this->db->query($sql)->result_array();


		return $penerimaan;
	}


	public function potong_cashtopup($pr_id,$item_id)
	{	
		$sql ="SELECT * FROM tbl_pr_vendor WHERE pr_id='$pr_id' AND id='$item_id'";
		$res = $this->db->query($sql)->row_array();

		$kar_id 	= $res['user_receive'];
		$harga_beli = $res['amount_verified'];


    	$sql = " SELECT * FROM tbl_kasbon_cash WHERE karyawan_id ='$kar_id'";
    	$res = $this->db->query($sql)->row_array();

    	$kasbon_id = $res['id'];
    	$interval_reminder = $res['interval_reminder'];
    	$balance = $res['balance'];
    	$balance = $balance - $harga_beli;
    	$reminder_date = Date('Y-m-d', strtotime("+".$interval_reminder." days"));


	    $insert = array(
                        'karyawan_id'   =>  $kar_id, 
                        'kasbon_id'     =>  $kasbon_id,
                        'debit'        =>   $harga_beli,
                        'balance'       =>  $balance,
                        'date_created'  =>  date('Y-m-d H:i:s'),
                        'user'          =>  $_SESSION['myuser']['karyawan_id'],
                        'description'   =>  "Pengurangan Saldo pada PR ID ". $pr_id." Untuk Item ID ".$id,
                        'pr_id'			=>  $pr_id,
                        );
        $this->db->insert('tbl_kasbon_rekening_koran', $insert);


        $this->db->where('id', $kasbon_id);
        $this->db->update('tbl_kasbon_cash', array('last_update'=> date('Y-m-d H:i:s'),'balance'=>$balance,'reminder_date'=> $reminder_date));

        $pesan = array(
                            'kasbon_id'       => $kasbon_id,
                            'user'            => '133',
                            'pesan'           => "Mengurangi Saldo pada PR ID ". $pr_id. "Untuk Item ID ".$id,
                            'date_created'    => date('Y-m-d H:i:s'),
                        );
        $this->db->insert('tbl_kasbon_pesan', $pesan);
        $psn_id = $this->db->insert_id();
         

	}


	public function tf_to_tools($pr_id,$item_id)
	{	
		$sql ="SELECT * FROM tbl_pr_vendor WHERE pr_id='$pr_id' AND id='$item_id'";
		$res= $this->db->query($sql)->row_array();

		$kar_id = $res['user_receive'];

		if($res['jenis']=='Tool')
		{		

			$query  = "SELECT id FROM tbl_tools";
			$count  = $this->db->query($query)->num_rows();
			$cou 	= $count + 1;
		    $co 	= sprintf("%06s", $cou);
		    $code 	= "A".$co;

			$addtool = array
			(	
				'code' 				    => $code,
	  			'name'				  	=> $res['items'],
	  			'vendor'			 	=> $res['vendor'],
	  			'price'				  	=> $res['harga_beli'],
	  			'date_purchased' 		=> date('Y-m-d H:i:s'),
	  			'date_created'  		=> date('Y-m-d H:i:s'),
	          	'quantity'    			=> $res['qty_approved'],
  			);
  			$this->db->insert('tbl_tools', $addtool);
  			$id_tool = $this->db->insert_id();

			$upd = array(
                'tool_id' => $id_tool,
                'date_tf_holder' =>date('Y-m-d H:i:s'),
		              );
		    $this->db->where('id', $id);
		    $this->db->update('tbl_pr_vendor', $upd);

		    $addholder = array(
          		'tool_id'       => $id_tool,
          		'user_holder'   => $res['holder'],
          		'date_created'  => date('Y-m-d H:i:s'),
          		);
        	$this->db->insert('tbl_tools_holder', $addholder);

	        if($kar_id != $res['holder']) 
	        {
	            $args = array
	            (
					'tool_id'       => $id_tool,
					'user_pemberi'  => $kar_id,
					'user_penerima' => $res['holder'],
					'date_created'  => date('Y-m-d H:i:s'),
		        );
		        $this->db->insert('tbl_tools_handover', $args);
		        $id_handover = $this->db->insert_id();

	            $approve = array
	            (
		            'tool_id' 		=> $id_tool,
		            'user_create' 	=> $kar_id,
		            'user_approval' => $res['holder'],
		            'date_created'  => date('Y-m-d H:i:s'),
		            'action'		=> 'handover',
		            'action_id'		=> $id_handover,
		            'lvl_approval'	=> 'kar',
		        );
	         	$this->db->insert('tbl_tools_approval', $approve);
	         	$id_appr = $this->db->insert_id();

	         	$urltool = "/tools/details/".$id_tool;
	         	$notiftool 	= "<b>TOOL ID ".$id_tool." </b> Need to Handover Approval.";
				$notif = array(
			            'modul' 		=> '4',
			            'modul_id' 		=> $id_tool,
			            'record_id' 	=> $id_handover,
			            'record_type' 	=> '13',
			            'user_id' 		=> $res['holder'],
			            'date_created' 	=> date('Y-m-d H:i:s'),
			            'url'			=> $urltool,
			            'notes'			=> $notiftool,
	        	);
	    		$this->db->insert('tbl_notification', $notif);
	        }

	        $args = array
	        		(
			          'tool_id'   => $id_tool,
			          'user_report' => $res['holder'],
			          'date_created'  => date('Y-m-d H:i:s'),
	        		);
	        $this->db->insert('tbl_tools_report', $args);
	        $id_rep = $this->db->insert_id();


	        $this->uploadfiletool($id_tool,'0',$pr_id,'3',$id);
    	}

	}

}
?>

