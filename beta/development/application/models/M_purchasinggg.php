<?php if(! defined('BASEPATH')) exit('No direct script access allowed');
	/**
	*
	*/
	class M_purchasing extends CI_Model
	{
		public function __construct()
		{
			parent::__construct();
			$user = $this->session->userdata('myuser');
			$this->load->model('Ftp_model', 'mftp');

			if(!isset($user) or empty($user))
			{
					redirect('c_loginuser');
			}
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

		/* public function getItems()
		{
			$sql = "SELECT df.id, sp.vendor, df.nama_barang, df.satuan FROM tbl_pr_daftarbrg df
					LEFT JOIN tbl_supplier sp ON sp.id = df.vendor_id";
			$res = $this->db->query($sql)->result_array();

			return $res;
		} */

		public function getKaryawan()
		{
			$sql = "SELECT nama, id FROM tbl_karyawan WHERE published = '1' AND id != '101' ORDER BY nama ASC";
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

				$query = $this->db->query($sql);
				$getOverTo = $query->row_array();

				return $getOverTo;
			}

		}

		public function getPR()
		{
			$kar_id = $_SESSION['myuser']['karyawan_id'];

			$sql = "SELECT * FROM tbl_purchasing WHERE sales_id = '$kar_id' ORDER BY id DESC LIMIT 1";
			$row_array = $this->db->query($sql)->row_array();

			return $row_array;
		}

		public function loadItems($id)
		{
			$sql = "SELECT ve.*, lg.nickname FROM tbl_pr_vendor ve
					LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = ve.user_approved
					WHERE pr_id = $id";
			$res = $this->db->query($sql)->result_array();

			return $res;
		}

		public function getFiles($pr_id, $log_id, $type)
		{
			$sql = "SELECT up.*, lg.nickname FROM tbl_upload_pr up
					LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = up.uploader
					WHERE pr_id = '$pr_id' AND sub_id = '$log_id' AND up.type= '$type'";
			$res = $this->db->query($sql)->result_array();

			return $res;
		}

		public function DetailsPR($id)
		{
			$sql = "SELECT pr.*, lg.nickname, ps.position, kr.cabang, kr.position_id, stlg.nickname as ov_name, cont.cont_name FROM tbl_purchasing pr
					LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = pr.sales_id
					LEFT JOIN tbl_karyawan kr ON kr.id = pr.sales_id
					LEFT JOIN tbl_position ps ON ps.id = kr.position_id
					LEFT JOIN tbl_loginuser stlg ON stlg.karyawan_id = pr.status 
					LEFT JOIN (SELECT cr.pr_id, GROUP_CONCAT(lg.nickname SEPARATOR '; ') as cont_name
						FROM tbl_pr_contributor cr
						LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = cr.contributor
						GROUP BY cr.pr_id) cont ON cont.pr_id = pr.id
					WHERE pr.id = '$id' AND pr.published = '1'";

			$row = $this->db->query($sql)->row_array();

			return $row;
		}

		
		public function getKaryawancon($id)
        {
            $sql = "SELECT id, nama FROM tbl_karyawan 
                    WHERE published = '1' AND id NOT IN (SELECT contributor FROM tbl_pr_contributor WHERE pr_id = $id GROUP BY contributor) AND id != 101 ORDER BY nama ASC";
            $res = $this->db->query($sql)->result_array();

            return $res;
        }

		public function __tablePR()
		{
				$user = $_SESSION['myuser'];
				$pos_id = $user['position_id'];
				$kar_id = $user['karyawan_id'];
				$cbg = $user['cabang'];
				$div = $user['position'];
	      $div = substr($div, -3);

				$sql = "SELECT pr.*, lg.nickname, ovl.nickname as ov_name, kr.cabang, kr.position_id, ps.position,
					pr_vr.vendors, pr_vr.items, pr_vr.qty, pr_vr.mou
					FROM tbl_purchasing pr
						LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = pr.sales_id
						LEFT JOIN tbl_karyawan kr ON kr.id = pr.sales_id
						LEFT JOIN tbl_position ps ON ps.id = kr.position_id
						LEFT JOIN tbl_pr_overto ov ON ov.pr_id = pr.id
						LEFT JOIN tbl_loginuser ovl ON ovl.karyawan_id = pr.status
						LEFT JOIN (
							SELECT pr_id, GROUP_CONCAT(vendor SEPARATOR '@') as vendors,
							GROUP_CONCAT(items SEPARATOR '@') as items,
							GROUP_CONCAT(qty SEPARATOR '@') as qty,
							GROUP_CONCAT(mou SEPARATOR '@') as mou
							FROM tbl_pr_vendor
							GROUP BY pr_id
						) pr_vr ON pr_vr.pr_id = pr.id";

	 			if(in_array($pos_id, array('1', '2', '77', '12', '14', '3', '60', '62', '75', '18', '5')) OR $_SESSION['myuser']['role_id'] == '15') {

					$sql .= " WHERE pr.published = '1'";

				}elseif(in_array($pos_id, array('55', '56', '57', '58', '59', '95'))) {

					$sql .= " WHERE pr.published = '1' AND (kr.cabang = '$cbg' OR ov.overto = '$kar_id')";

				}elseif (in_array($pos_id, array('88', '89', '90', '91', '92', '93', '100'))) {

					$sql .= " WHERE pr.published = '1' AND (ps.position = 'Sales $div' OR ov.overto = '$kar_id' OR pr.sales_id = '$kar_id')";

				}else {

					$sql .= " WHERE pr.published = '1' AND (pr.sales_id = '$kar_id' OR ov.overto = '$kar_id')";

				}

				$sql .=" GROUP BY pr.id DESC";

				$res = $this->db->query($sql)->result_array();

				return $res;
		}

		public function getStatusPR($status, $row)
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
		}

		public function tablePR()
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
				$sql .= " AND (kr.position_id IN ".$post_in." OR kr.position_id IN ('29', '90') OR ov.overto = '$kar_id' OR pr.sales_id = '$kar_id' OR pr.divisi = '$div' OR co.contributor = $kar_id) 
					GROUP BY pr.id DESC";
			}elseif (in_array($pos_id, array('91', '100'))) {
				$sql .= " AND (kr.position_id IN ".$post_in." OR ov.overto = '$kar_id' OR pr.sales_id = '$kar_id' OR pr.divisi = '$div' OR co.contributor = $kar_id) 
					GROUP BY pr.id DESC";				
			}elseif($pos_id == '4') {
				$sql .= " AND (kr.position_id = '4' OR ovkr.position_id = '4' OR co.contributor = $kar_id) 
					GROUP BY pr.id DESC";

			}else {
				$sql .= " AND (pr.sales_id = '$kar_id' OR ov.overto = '$kar_id' OR co.contributor = $kar_id)
					GROUP BY pr.id DESC";
			}

			$res = $this->db->query($sql)->result_array();

			return $res;
		}

		public function getApproval($id)
		{
			$sql = "SELECT ap.*, lg.nickname FROM tbl_pr_approval ap
					LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = ap.user_approval
					WHERE ap.pr_id = '$id' GROUP BY ap.id ASC";
			$res = $this->db->query($sql)->result_array();

			return $res;
		}

		public function getNextTo($id)
		{
			$sql = "SELECT * FROM tbl_pr_overto WHERE pr_id = '$id'";
			$row = $this->db->query($sql)->row_array();

			return $row;
		}

		public function getLogPR($id)
		{
			$sql = "SELECT lg.*, us.nickname, pos.position, pu.status, pu.sales_id FROM tbl_pr_log lg
					LEFT JOIN tbl_loginuser us ON us.karyawan_id = lg.id_operator
					LEFT JOIN tbl_karyawan as kr ON kr.id = lg.id_operator
					LEFT JOIN tbl_position pos ON pos.id = kr.position_id
					LEFT JOIN tbl_purchasing pu ON pu.id = lg.pr_id
					WHERE lg.pr_id = '$id' GROUP BY lg.id ASC";
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
			$sql = "SELECT psn.pr_id, psn.log_pr_id, psn.pesan, psn.date_created, lg.nickname FROM tbl_pr_pesan as psn
            		LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = psn.sender
            		WHERE pr_id = '$pr' AND log_pr_id = '$log_pr' GROUP BY psn.id ORDER BY psn.date_created ASC";
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

				$add = array(
					'vendor'		=> $nama,
					'alamat'		=> $alamat,
					'telepon'		=> $telepon,
					'pic'			=> $pic,
					'email'			=> $email,
					'date_created'	=> date('Y-m-d H:i:s'),
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
				$sess 		= $_SESSION['myuser'];
				$id_kar		= $_SESSION['myuser']['karyawan_id'];
				$sales 		= substr($sess['position'], 0, 5);
				$ket 		= $this->input->post('ket_pembelian');
				$overto 	= $this->input->post('overto');
				$overto_type = $this->input->post('overtotype');
				$message	= $this->input->post('message');
				$vendor 	= $this->input->post('vendor');
				$items 		= $this->input->post('items');
				$qty 		= $this->input->post('qty');
				$stock		= $this->input->post('stock');
				$mou 		= $this->input->post('mou');
				$files 		= $this->input->post('filepr');
				$jns 		= $this->input->post('jns_pembelian');
				$deadline 	= $this->input->post('deadline');
				$deadline 	= preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $deadline);
				$divisi 	= $this->input->post('divisi');
				$biaya_piutang = $this->input->post('biaya_piutang');
				$ptg_omset 	= $this->input->post('potong_omset');
				$crm_link = $this->input->post('crm_link');
		
				$pr = array(
						'sales_id'			=> $id_kar,
						'alasan_pembelian'	=> $ket,
						'date_created'		=> date('Y-m-d H:i:s'),
						'date_deadline'		=> $deadline,
						'published'			=> '1',
						'divisi'			=> $divisi,
						'biaya_piutang'		=> $biaya_piutang,
						'ptg_omset'			=> $ptg_omset,	
						//'status'			=> $overto,
					);

				$this->db->insert('tbl_purchasing', $pr);
				$pr_id = $this->db->insert_id();

				if($crm_link) {
					$this->db->where('id',$pr_id);
					$this->db->update('tbl_purchasing', array('modul_link' => '8', 'link_id' => $crm_link));
				}

				$logpr = $this->AddLogPR($pr_id, $id_kar);

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

				$this->uploadfile($pr_id, '0', '0');
				
				for($i=0; $i<sizeof($items); $i++)
			   	{
			    	$dataSet = array (	'pr_id' => $pr_id,
			    							'vendor'	=> $vendor[$i],
			    							'items'		=> $items[$i],
			    							'qty'		=> $qty[$i],
			    							'stock'		=> $stock[$i],
			    							'mou'		=> $mou[$i],
			    							'jenis'		=> $jns[$i],
			    							'date_created'	=> date('Y-m-d H:i:s'), 
			    						);
			    	$this->db->insert('tbl_pr_vendor', $dataSet);
			    	$vendor_id = $this->db->insert_id();

			    	$file = $_FILES['filepr']['name'][$i];
			    	if($_FILES['filepr']['type'] == 'image/jpeg') {
			    		$file = substr($file, 0, -5);
			    	}else {
			    		$file = substr($file, 0, -4);
			    	}
			    	
			    	if($file) {
			    		$sql = "UPDATE tbl_upload_pr SET sub_id = '$vendor_id' WHERE pr_id = '$pr_id' AND file_name like '%$file%'";
			    		$this->db->query($sql);
			    	}
			   	}
                 
                if((!in_array($sess['position_id'], array('1','2','77','88','89','90','91','93','100')) AND !empty($divisi)) OR (in_array($sess['position_id'], array('65','66','67','68','71','72')) AND $sess['cabang'] == '')) 
                {
                	if($divisi == 'DHC' OR $sess['position_id'] == '65') {
                		$kadiv = '88';
                	}elseif($divisi == 'DRE' OR $sess['position_id'] == '66') {
                		$kadiv = '89';
                	}elseif($divisi == 'DCE' OR $sess['position_id'] == '68') {
                		$kadiv = '90';
                	}elseif($divisi == 'DHE' OR $sess['position_id'] == '71') {
                		$kadiv = '91';
                	}elseif($divisi == 'DEE' OR $sess['position_id'] == '67') {
                		$kadiv = '93';
                	}elseif($divisi == 'DWT' OR $sess['position_id'] == '67') {
                		$kadiv = '91';
                	}

                	$sql = "SELECT id FROM tbl_karyawan WHERE position_id = $kadiv AND published = '1'";
                	$que = $this->db->query($sql)->row_array();
                	$kdiv = $que['id'];

                	$this->notification($pr_id, '', '13', $kdiv);
                }

                if(!in_array($sess['position_id'], array('1','2','77','55','56','57','95','58')) AND !empty($sess['cabang']))
                {
                	if($sess['cabang'] == 'Medan') {
                      $pos = '56';
                    }elseif($sess['cabang'] == 'Surabaya') {
                      $pos = '55';
                    }elseif ($sess['cabang'] == 'Bandung') {
                      $pos = '57';
                    }elseif ($sess['cabang'] == 'Cikupa') {
                      $pos = '58';
                    }
                    
                    $sql = "SELECT id FROM tbl_karyawan WHERE position_id = $pos AND published = '1'";
                	$que = $this->db->query($sql)->row_array();
                	$cab = $que['id'];

                	$this->notification($pr_id, '', '13', $cab);  
                }	

                if(in_array($sess['position_id'], array('1','2','77'))) {
                 //direksi no need approval -> tidak insert
                	$this->notification($pr_id, '', '13', '2');
                	//$this->notification($pr_id, '', '13', '3');
                }
                elseif(in_array($sess['position_id'], array('88','89','90','91','93','100','55','56','57','95','58'))) { //kadiv appr ke direksi = lvl 3
                  	$this->notification($pr_id, '', '13', '2');
                  	//$this->notification($pr_id, '', '13', '3');
                }
                elseif (in_array($sess['position_id'], array('5','7','8','9','11','12','76'))) {
		        	$this->notification($pr_id, '', '13', '2');
		        	//$this->notification($pr_id, '', '13', '3');        
                }
                else {
                    $this->notification($pr_id, '', '13', '2');
                    //$this->notification($pr_id, '', '13', '3');
				}

			   	return $pr_id;	
			}   		
		}


		public function addPRRRRRR()
		{
			if($this->input->post())
			{
				$id_kar		= $_SESSION['myuser']['karyawan_id'];
				$ket 		= $this->input->post('ket_pembelian');
				//$overto 	= $this->input->post('overto');
				//$message	= $this->input->post('message');
				//$produk 	= $this->input->post('produk');
				//$produk_id 	= $this->input->post('prd_id');
				//$qty 		= $this->input->post('qty');
				//$stock		= $this->input->post('stock');
				$deadline 	= $this->input->post('deadline');
				$deadline 	= preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $deadline);

				$pr = array(
						'sales_id'			=> $id_kar,
						'alasan_pembelian'	=> $ket,
						'date_created'		=> date('Y-m-d H:i:s'),
						'date_deadline'		=> $deadline,
						//'status'			=> $overto,
					);

				$this->db->insert('tbl_purchasing', $pr);
			}
		}

		public function addPRItems()
		{
			if($this->input->post())
			{
				$pr_id 		= $this->input->post('pr_id');
				$qty 		= $this->input->post('qty');
				$stock		= $this->input->post('stock');
				$vendor		= $this->input->post('vendor');
				$item 		= $this->input->post('item');
				$mou 		= $this->input->post('mou');

				$additems = array(
					'pr_id'	=> $pr_id,
					'vendor'	=> $vendor,
					'items'	=> $item,
					'qty'	=> $qty,
					'stock'	=> $stock,
					'mou'	=> $mou,
					'date_created'	=> date('Y-m-d H:i:s'),
				);
				$this->db->insert('tbl_pr_vendor', $additems);
				$item_id = $this->db->insert_id();

				$published = array(
					'published'	=> '1',
					);
				$this->db->where('id', $pr_id);
				$this->db->update('tbl_purchasing', $published);

				$this->uploadfile($pr_id, '0', $item_id);
			}
		}

		public function SavePR()
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

          		/* if($sess['karyawan_id'] == $holder && in_array($sess['position_id'], array('1','2','77', '55', '56', '57', '58', '59', '95'))) {

          		}elseif($sess['karyawan_id'] == $holder) {
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
		            }elseif ($sess['cabang'] == $sales) {
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

		              $sql = "INSERT INTO tbl_tools_approval (tool_id, user_create, user_approval, date_created)
		                      VALUES ('$id_tool', '$holder', '$kar', '$date')";
		              $appr = $this->db->query($sql);
		              $id_appr = $this->db->insert_id();

              			$this->notification($id_tool, $id_appr, '13', $kar);
				}	*/
			}
		}

		public function UpStatus($type, $id)
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
				$this->db->update('tbl_purchasing', array('status' => $ov, 'level_approval' => 'Dir'));

				$this->AddLogPR($id, $ov);

				$this->notification($id, $apr['id'], '1', $ov);

				$sql = "UPDATE tbl_notification SET status = '1' WHERE modul = '5' AND modul_id = '$id' AND record_type = '13' AND status = '0'";
				$this->db->query($sql);

					//logAll
			}elseif($type == '1') {
				if($divisi AND empty($level) AND !empty($cbg) AND !in_array($pos_user, array('55','56', '57', '58', '95'))) {
					$this->db->where('id', $id);
					$this->db->update('tbl_purchasing', array('level_approval' => 'Kacab'));
				}elseif($divisi AND empty($level) AND !empty($cbg)) {
					$this->db->where('id', $id);
					$this->db->update('tbl_purchasing', array('level_approval' => 'Kadiv'));
				}elseif($divisi AND $level == 'Kacab') {
					$this->db->where('id', $id);
					$this->db->update('tbl_purchasing', array('level_approval' => 'Kadiv'));
				}elseif(empty($level) AND !empty($cbg)) {
					$this->db->where('id', $id);
					$this->db->update('tbl_purchasing', array('level_approval' => 'Kacab'));
				}elseif(empty($level) AND empty($cbg)) {
					$this->db->where('id', $id);
					$this->db->update('tbl_purchasing', array('level_approval' => 'Kadiv'));
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
		}

		public function UpStatusNotAppr()
		{
			if($this->input->post())
			{
				$id = $this->input->post('pr_id');
				$apr = $this->getNextTo($id);
				$getpr = $this->DetailsPR($id);
				$sales = $getpr['sales_id'];
				$divisi = $getpr['divisi'];
				$level = $getpr['level_approval'];
				$cbg = $getpr['cabang'];
				//$ov = $apr['0']['overto'];
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
				$this->db->update('tbl_purchasing', array('status' => $sales, 'level_approval' => 'Dir'));

				//notification approved ke sales_id dan direktur
				//logAll
				$this->finished($id);	

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

				if($divisi AND empty($level) AND !empty($cbg)) {
					$this->db->where('id', $id);
					$this->db->update('tbl_purchasing', array('level_approval' => 'Kacab'));
				}elseif($divisi AND $level == 'Kacab') {
					$this->db->where('id', $id);
					$this->db->update('tbl_purchasing', array('level_approval' => 'Kadiv'));
				}elseif(empty($level) AND !empty($cbg)) {
					$this->db->where('id', $id);
					$this->db->update('tbl_purchasing', array('level_approval' => 'Kacab'));
				}elseif(empty($level) AND empty($cbg)) {
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

				return $id;
			}
		}


		public function UpStatusss($type, $id)
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
		}

		public function overTo()
		{
			if($this->input->post())
	    	{
				$karyawanID   = $this->input->post('karyawan');
				$message      = $this->input->post('message');
				$pr_id        = $this->input->post('pr_id');
				$overto_type  = $this->input->post('overto_type');
				$user_id      = $_SESSION['myuser']['karyawan_id'];

			    $updatepr = array(
			    	'status'  => $karyawanID,
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

				$this->notification($pr_id, $overto_id, '1', $karyawanID);

				//$this->logAll($do_id, $desc='1', $overto_id, $ket='tbl_multi_overto');

	      		$this->uploadfile($pr_id, '1', '0');

	      		$newlog = $this->AddLogPR($pr_id, $karyawanID);
				
				//$this->logAll($do_id, $desc='1', $logid, $ket='tbl_do_log');

				$sql = "SELECT nickname FROM tbl_loginuser WHERE karyawan_id = '$karyawanID'";
				$result = $this->db->query($sql)->row_array();
				$nickname = $result['nickname'];

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

				$this->notification($pr_id, $pesanid, '2', '');
				//$this->logAll($do_id, $desc='1', $pesanid, $ket='tbl_multi_pesan');
	    	}
		}

		public function add_pesan($id)
		{
			$pesan = $this->input->post('msg');

			$sql = "SELECT id FROM tbl_pr_log WHERE pr_id = $id ORDER BY id DESC LIMIT 1";
			$que = $this->db->query($sql)->row_array();
			$log_pr = $que['id'];

			$addpsn = array(
					'pr_id' => $id,
					'log_pr_id'	=> $log_pr,
					'sender' => $_SESSION['myuser']['karyawan_id'],
					'pesan'	=> $pesan,
					'date_created'	=> date('Y-m-d H:i:s'),
					);
				$this->db->insert('tbl_pr_pesan', $addpsn);
				$pesan_id = $this->db->insert_id();

				$this->notification($id, $pesan_id, '2', '');

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

				//notification approve ke kadiv / kacab dan direktur
				//logAll
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
			}elseif($num_rows >= '2') {
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

		public function uploadfile($type_id, $type, $sub_id)
  		{
		    function compress_image($src, $dest , $quality)
		    {
		        $info = getimagesize($src);

		        if ($info['mime'] == 'image/jpeg')
		        { 
		           $image = imagecreatefromjpeg($src);
		           //compress and save file to jpg
		        imagejpeg($image, $dest, $quality);
		        }
		        elseif ($info['mime'] == 'image/png')
		        { 
		            $image = imagecreatefrompng($src);
		        imagepng($image, $dest, $quality);
		        }

		         return $dest;
		    }

		    function thumb_image($src, $dest) {

		    	$info = getimagesize($src);
		        $direktoriThumb     = "assets/images/upload_pr/thumb_pr/";

		        $temp	= explode(".", $dest);
				$jns 	= end($temp);
				$cut	 = substr($dest, 0, -4);
				$dest = $cut.'_thumb.'.$jns;


		         if ($info['mime'] == 'image/jpeg')
		        {
		           $image = imagecreatefromjpeg($src);
		        }
		        elseif ($info['mime'] == 'image/png')
		        {
		            $image = imagecreatefrompng($src);
		        }

		        $width  = imageSX($image);
    			$height = imageSY($image);


				$thumbWidth     = 150;
    			$thumbHeight    = ($thumbWidth / $width) * $height;

    			
    			$thumbImage = imagecreatetruecolor($thumbWidth, $thumbHeight);
    			imagecopyresampled($thumbImage, $image, 0,0,0,0, $thumbWidth, $thumbHeight, $width, $height);

    			if ($info['mime'] == 'image/jpeg')
		        {
		        	imagejpeg($thumbImage,$direktoriThumb.$dest);
		        }
		        elseif ($info['mime'] == 'image/png')
		        {
		            imagepng($thumbImage,$direktoriThumb.$dest);
		        }

		        //return destination file
		        //return $dest;
		    }

		    if($_FILES)
		    {
				$uploaddir = 'assets/images/upload_pr/';

				foreach ($_FILES['filepr']['name'] as $key => $value)
				{

					$temp =  explode(".", $value);
					$jns = end($temp);
					$fname = substr($value, 0, -4);
					$fname = $fname.'_'.$type_id.'.'.$jns;

					if(!$value)
					{
						//$file_name = basename($fname);

						//$uploadfile = $uploaddir . basename($fname);
						//move_uploaded_file($_FILES['filepr']['tmp_name'][$key], $uploadfile);
					}else{
						$file_name = basename($fname);

						$uploadfile = "/htdocs/iios/".$uploaddir . basename($fname);
						move_uploaded_file($_FILES['filepr']['tmp_name'][$key], $file_name);

						$conn_id = $this->mftp->conFtp();

						if(getimagesize($file_name)['mime'] == 'image/png'){
							$compress = compress_image($file_name, $file_name, 7);
							//$thumb = thumb_image($uploadfile, $fname);
						}elseif(getimagesize($file_name)['mime'] == 'image/jpeg'){
							$compress = compress_image($file_name, $file_name, 40);
							//$thumb = thumb_image($uploadfile, $fname);
						}

						if(ftp_put($conn_id, $uploadfile, $file_name, FTP_BINARY)) {
						
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

						$this->notification($type_id, $upl_id, '3', '');

						//$this->logAll($type_id, $desc = '4', $upl_id, $ket = 'tbl_upload_do');

						ftp_close($conn_id);

						unlink($file_name);
						} else {
						 $this->session->set_flashdata('message', 'There was a problem while uploading $file_name');
						}
						
					}
				}
			}
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

				$this->notification($pr_id, $con_id, '16', $con);

       } 
    }

  		public function finished($id)
  		{
  			$sql = "SELECT id, id_operator, time_login FROM tbl_pr_log WHERE pr_id = '$id' ORDER BY id DESC LIMIT 2";
		    $res = $this->db->query($sql)->result_array();

		    $iddown = $res[0]['id'];
		    $idup = $res[1]['id'];
		    $user = $_SESSION['myuser']['karyawan_id'];

		    if($_SESSION['myuser']['karyawan_id'] == $res[0]['id_operator']) {
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
			        'status' =>'101',
			        'date_closed' => date('Y-m-d H:i:s'),
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

		      $this->notification($id, $id_pesan, '2', '');

		      //$this->logAll($id, $desc = '1', $id_pesan, $ket = 'tbl_multi_pesan');
		}

		public function takeOver($id)
		{
			$sql = "SELECT id, time_login, time_nextto, time_idle, date_created FROM tbl_pr_log WHERE pr_id = '$id' ORDER BY id DESC LIMIT 2";
		    $res = $this->db->query($sql)->result_array();

		    $iddown = $res[0]['id'];
		    $idup = $res[1]['id'];
		    $user = $_SESSION['myuser']['karyawan_id'];

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

		      $this->notification($id, $id_pesan, '2', '');

		      //$this->logAll($id, $desc = '1', $id_pesan, $ket = 'tbl_multi_pesan');
		}

		public function notification($id, $rec_id, $notif, $user)
      	{
	        if($user != '') {
	        	$add = array(
		            'modul' => '5',
		            'modul_id'  => $id,
		            'record_id' => $rec_id,
		            'record_type' => $notif,
		            'user_id' => $user,
	        	);
        		$this->db->insert('tbl_notification', $add);
	        }elseif($user == '') {
	        	$kar = $_SESSION['myuser']['karyawan_id'];
	        	$sql = "SELECT kar.cabang, kar.nama, ps.position, pr.status FROM tbl_purchasing as pr
                LEFT JOIN tbl_karyawan as kar ON kar.id = pr.sales_id
                LEFT JOIN tbl_position as ps ON ps.id = kar.position_id
                WHERE pr.id = '$id'";
        		$query = $this->db->query($sql)->row_array();

		        $a = $query['cabang'];
		        $finished = $query['status'];
		        //$div = $query['divisi'];
		        $div = substr($query['position'], -3);
		        $date = date('Y-m-d H:i:s');

		       if($a == 'Bandung') {
		          $position_cbg = '57';
		        }elseif ($a == 'Surabaya') {
		          $position_cbg = '55';
		        }elseif ($a == 'Medan') {
		          $position_cbg = '56';
		        }elseif ($a == 'Cikupa') {
		        	$position_cbg = '58';
		        }else{
		          $position_cbg = '';
		        }

		        if($div == 'DHC') {
		          $div = '88';
		        }elseif ($div == 'DRE') {
		          $div = '89';
		        }elseif ($div == 'DCE') {
		          $div = '90';
		        }elseif ($div == 'DHE') {
		          $div = '91';
		        }elseif ($div == 'DGC') {
		          $div = '92';
		        }elseif ($div == 'DEE') {
		          $div = '93';
		        }elseif ($div == 'DWT') {
		          $div = '100';  
		        }else{
		        	$div = '';
		        }

		        if($finished == '101') {
		        	$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul, date_created)
	                  SELECT uploader, '$rec_id', '$notif', '$id', '0', '5', '$date' FROM tbl_upload_pr
	                  WHERE pr_id = '$id' AND uploader NOT IN ('$kar', '2') AND type = '1' GROUP BY uploader
	                  UNION SELECT overto, '$rec_id', '$notif', '$id', '0', '5', '$date' FROM tbl_pr_log
	                  WHERE pr_id = '$id' AND overto NOT IN ('0', '$kar') GROUP BY overto
	                  UNION SELECT contributor, '$rec_id', '$notif', '$id', '0', '5', '$date' FROM tbl_pr_contributor 
	                  WHERE pr_id = '$id' GROUP BY contributor
	                  UNION SELECT sender, '$rec_id', '$notif', '$id', '0', '5', '$date' FROM tbl_pr_pesan
	                  WHERE pr_id = '$id' AND sender NOT IN ('$kar', '2') GROUP BY sender";
	            }else {
	              	$sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul, date_created)
	                  SELECT uploader, '$rec_id', '$notif', '$id', '0', '5', '$date' FROM tbl_upload_pr
	                  WHERE pr_id = '$id' AND uploader != '$kar' AND type = '1' GROUP BY uploader
	                  UNION SELECT overto, '$rec_id', '$notif', '$id', '0', '5', '$date' FROM tbl_pr_log
	                  WHERE pr_id = '$id' AND overto NOT IN ('0', '$kar') GROUP BY overto
	                  UNION SELECT contributor, '$rec_id', '$notif', '$id', '0', '5', '$date' FROM tbl_pr_contributor 
	                  WHERE pr_id = '$id' GROUP BY contributor
	                  UNION SELECT sender, '$rec_id', '$notif', '$id', '0', '5', '$date' FROM tbl_pr_pesan
	                  WHERE pr_id = '$id' AND sender != '$kar' GROUP BY sender";
	            }
			        
			        if(!empty($position_cbg) AND !empty($div)) {
			          $sql .= " UNION SELECT id, '$rec_id', '$notif', '$id', '0', '5', '$date' FROM tbl_karyawan WHERE published = '1' AND position_id IN ('$position_cbg', '$div')";

			        } elseif(!empty($position_cbg) AND empty($div)) {
			          $sql .= " UNION SELECT id, '$rec_id', '$notif', '$id', '0', '5', '$date' FROM tbl_karyawan WHERE published = '1' AND position_id IN ('$position_cbg')";
			        }elseif(empty($position_cbg) AND !empty($div)) {
			        	$sql .= " UNION SELECT id, '$rec_id', '$notif', '$id', '0', '5', '$date' FROM tbl_karyawan WHERE published = '1' AND position_id IN ('$div')";
			        }elseif(empty($position_cbg) AND empty($div)) {
			        	$sql .= "";
			        }
		        	$this->db->query($sql);
		        }
	    }

     	/* public function logAll($id, $desc, $desc_id, $ket, $isi)
	    {
	        $user = $_SESSION['myuser']['karyawan_id'];
	        $logAll = array(
	          'descrip'       => $desc,
	          'descrip_id'    => $desc_id,
	          'user_id'       => $user,
	          'modul'         => '5',
	          'modul_id'      => $id,
	          'ket'           => $ket,
	          'isi'			  => $isi,
	          'date_created'  => date('Y-m-d H:i:s'),
	          );
	        $this->db->insert('tbl_log', $logAll);
	    } */

	}

?>
