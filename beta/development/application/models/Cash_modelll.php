<?php if(! defined('BASEPATH')) exit('No direct script access allowed');    
    
    class Cash_model extends CI_Model
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

        public function getKaryawan()
        {
            $sql = "SELECT kr.id, nama, position FROM tbl_karyawan kr
                    LEFT JOIN tbl_position ps ON kr.position_id = ps.id
                    WHERE published = 1 AND kr.id NOT IN ('101', '109', '123', '133') ORDER BY nama ASC";
            $res = $this->db->query($sql)->result_array();

            return $res;
        }

        public function getAdmin()
        {
            $sql = "SELECT kr.id, nama, position FROM tbl_karyawan kr
                    LEFT JOIN tbl_position ps ON kr.position_id = ps.id
                    WHERE ps.id IN ('5','18','60','62','75') AND published = 1 ORDER BY nama ASC";
            $res = $this->db->query($sql)->result_array();

            return $res;
        }

        public function getKendaraan()
        {
            $sql = "SELECT ken.id, jns.jenis, ken.plat_nomer from tbl_kar_kendaraan ken
                    LEFT JOIN tbl_kar_kendaraan_jenis jns ON jns.id = ken.merk";
            $res = $this->db->query($sql)->result_array();

            return $res;
        }

        public function getContributor($id)
        {
            $sql = "SELECT kr.id, nama, position FROM tbl_karyawan kr
                    LEFT JOIN tbl_position ps ON ps.id = kr.position_id
                    WHERE kr.id NOT IN (
                        SELECT contributor FROM tbl_cash_contributor 
                        WHERE cash_id = '$id' 
                        GROUP BY contributor) 
                    AND published = '1' AND kr.id NOT IN ('101', '123', '133','109') 
                    GROUP BY kr.id ORDER BY kr.nama ASC";
            $res = $this->db->query($sql)->result_array();

            return $res;
        }

        public function loadContributor($id)
        {
            $sql = "SELECT cc.id, cc.contributor, nickname FROM tbl_cash_contributor cc
                    LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = cc.contributor
                    WHERE cash_id = $id
                    GROUP BY cc.id ORDER BY lg.nickname ASC";
            return $this->db->query($sql)->result_array();        
        }

        private function getUser($pos_id)
        {
            $sql = "SELECT id FROM tbl_karyawan WHERE position_id = '$pos_id' AND published = '1' GROUP BY id DESC LIMIT 1";
            $arr = $this->db->query($sql)->row_array();
            $user = $arr['id'];
            
            return $user;
        }

        public function getFiles($cash_id, $log_id, $type)
        {
            $sql = "SELECT up.*, lg.nickname FROM tbl_upload_cash up
                    LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = up.uploader
                    WHERE cash_id = '$cash_id' AND sub_id = '$log_id' AND up.type= '$type'";
            $res = $this->db->query($sql)->result_array();

            return $res;
        }


        public function getusername($cash_id)
        {
            $sql = "SELECT kr.id, position, nickname FROM tbl_karyawan kr
                    LEFT JOIN tbl_position ps ON kr.position_id = ps.id
                    LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = kr.id
                    WHERE kr.published = 1 AND lg.role_id != 15 AND kr.id NOT IN ('101', '109', '123', '133') ORDER BY nickname ASC";
            $res = $this->db->query($sql)->result_array();

            return $res;
        }

        public function getCRM()
        {
            $q = $this->input->post('q');

            $sql = "SELECT cr.id, IF (cr.customer_type = 1, cs.perusahaan, ncs.perusahaan) AS perusahaan, IF (cr.customer_type = 1, cs.pic, ncs.pic) AS pic FROM tbl_crm cr
                    LEFT JOIN tbl_customer as cs ON (cr.customer_id = cs.id AND cr.customer_type = '1')
                    LEFT JOIN tbl_non_customer as ncs ON (cr.customer_id = ncs.id AND cr.customer_type = '0')
                    WHERE cr.id like '%".$q."%' OR cs.perusahaan like '%".$q."%' OR cs.pic like '%".$q."%' OR ncs.perusahaan like '%".$q."%' OR ncs.pic like '%".$q."%'
                    ORDER BY cr.id DESC ";
           
            return $this->db->query($sql)->result_array();        
        }

        public function Detailscash($id)
        {   
            $sql = "SELECT pr.*, lg.nickname, ps.position, kr.cabang,kr.nama,ovl.nickname, kr.position_id, stlg.nickname as ov_name, aplg.nickname as name_approved, IF(pr.type = 1, 'Advance', 'Expenses') as tipe FROM tbl_cash pr
                    LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = pr.sales_id
                    LEFT JOIN tbl_karyawan kr ON kr.id = pr.sales_id
                    LEFT JOIN tbl_position ps ON ps.id = kr.position_id
                    LEFT JOIN tbl_loginuser ovl ON ovl.karyawan_id = pr.nextto
                    LEFT JOIN tbl_loginuser stlg ON stlg.karyawan_id = pr.status
                    LEFT JOIN tbl_loginuser aplg ON aplg.karyawan_id = pr.user_approved 
                    WHERE pr.id = '$id' AND pr.published = '1'";

            $row = $this->db->query($sql)->row_array();
            // print_r($row);die;

            return $row;
        }

        public function getexpenses($id)
        {
            $sql = "SELECT ve.*, lg.nickname, ken.plat_nomer, lap.nickname as user_approved, uc.file_name, file_exp.file_name_exp
                    FROM tbl_cash_expenses ve 
                    LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = ve.user 
                    LEFT JOIN tbl_loginuser lap ON lap.karyawan_id = ve.user_approved
                    LEFT JOIN tbl_kar_kendaraan ken ON ken.id = ve.kendaraan
                    LEFT JOIN tbl_upload_cash uc ON (uc.sub_id = ve.id AND uc.cash_id = ve.cash_id) 
                    LEFT JOIN (
                        SELECT mpd.sub_id, mpd.id, mpd.cash_id,
                        GROUP_CONCAT(mpd.file_name SEPARATOR '@@') as file_name_exp
                        FROM tbl_upload_cash mpd
                        GROUP BY mpd.sub_id
                    ) file_exp ON (file_exp.sub_id = ve.id AND file_exp.cash_id = ve.cash_id)
                    WHERE ve.cash_id = '$id'
                    GROUP BY ve.id ASC ";
            $res = $this->db->query($sql)->result_array();
            
            return $res;        
        }

         public function getApproval($id)
        {
            $sql = "SELECT ap.*, lg.nickname FROM tbl_cash_approval ap
                    LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = ap.user_approval
                    WHERE ap.cash_id = '$id' GROUP BY ap.id ASC";
            $res = $this->db->query($sql)->result_array();

            
            return $res;
        }

        public function loadItems($id)
        {

            $sql = "SELECT ve.*, lg.nickname FROM tbl_cash_expenses ve 
                    LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = ve.user
                    WHERE cash_id = '$id'";
            $res = $this->db->query($sql)->result_array();

            return $res;        
        }

        public function total_time($cash_id)
        {
            $sql = "SELECT pr.date_closed, log.date_created, max(log.date_created) as end_date, min(log.date_created) as start_date 
                    FROM tbl_cash_log as log 
                    LEFT JOIN tbl_cash as pr ON pr.id = log.cash_id 
                    WHERE log.cash_id = '$cash_id'";
            $query = $this->db->query($sql);
            $respon = $query->row_array();

            return $respon;
        }

        public function load_pesan($cash_id, $log_pr)
        {
            $sql = "SELECT psn.cash_id, psn.pesan, psn.date_created, lg.nickname FROM tbl_cash_pesan as psn
                    LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = psn.sender
                    WHERE cash_id = '$cash_id' AND  GROUP BY psn.date_created ASC";
            $pesan = $this->db->query($sql)->result_array();

            return $pesan;
        }

         public function pesan($id)
        {
            $sql = "SELECT psn.cash_id, psn.pesan, psn.date_created, lg.nickname, ps.position 
                    FROM tbl_cash_pesan as psn
                    LEFT JOIN tbl_loginuser as lg ON lg.karyawan_id = psn.sender
                    LEFT JOIN tbl_karyawan as kr ON kr.id = psn.sender
                    LEFT JOIN tbl_position as ps ON ps.id = kr.position_id
                    WHERE cash_id = '$id' GROUP BY psn.id ASC";
            $pesan = $this->db->query($sql)->result_array();

            return $pesan;
        }

        public function timer($cash_id, $log_pr_id)
        {
            $sql = "SELECT id, time_idle, time_login, time_nextto, id_operator FROM tbl_cash_log 
                    WHERE cash_id = '$cash_id' AND id = '$log_pr_id'";
            $idle = $this->db->query($sql)->row_array();

            return $idle;
        }

        public function gettotalexpenses($id)
        {

            $sql = "SELECT SUM(amount_expense) AS total 
                    FROM `tbl_cash_expenses`
                    WHERE cash_id = '$id'";
            $res = $this->db->query($sql)->result_array();
            
            return $res;        
        }

        public function getData($term)
        {   
           
            $user = $_SESSION['myuser'];
            $pos_id = $user['position_id'];
            $kar_id = $user['karyawan_id'];
            $cbg = $user['cabang'];
            $div = $user['position'];
            $div = substr($div, -3);

            $sql = "SELECT ca.*, lg.nickname, stlg.nickname as ov_name, kr.cabang, kr.position_id, ps.position, IF(ca.type = 1, 'Advance', 'Expenses') as tipe FROM tbl_cash ca
                    LEFT JOIN tbl_loginuser lg ON lg.karyawan_id = ca.sales_id
                    LEFT JOIN tbl_karyawan kr ON kr.id = ca.sales_id
                    LEFT JOIN tbl_position ps ON ps.id = kr.position_id
                    LEFT JOIN tbl_loginuser as stlg ON stlg.karyawan_id = ca.status
                    LEFT JOIN tbl_cash_contributor as cr ON cr.cash_id = ca.id
                    WHERE ca.published='1'";
            
            if($term == "all") {
                $sql .= "";
            }elseif($term == '101') {
                $sql .= " AND ca.status = 101";
            }else {
               $sql .= " AND ca.status != 101";
            }        

            if($pos_id == '88')
            {
                $sql .= " AND (position_id IN ('65','88') OR ca.divisi = 'DHC' OR cr.contributor = '$kar_id')";
            }
            elseif($pos_id == '89')
            {
                $sql .= " AND (position_id IN ('66','89') OR ca.divisi = 'DRE' OR cr.contributor = '$kar_id')";
            }
            elseif($pos_id =='90')
            {
                $sql .= " AND (position_id IN ('68','90') OR ca.divisi = 'DCE' OR cr.contributor = '$kar_id')";
            }
            elseif($pos_id =='91')
            {
                $sql .= " AND (position_id IN ('71','91','100','103') OR ca.divisi IN ('DHE', 'DWT') OR cr.contributor = '$kar_id')";
            }
            elseif($pos_id =='93')
            {
                $sql .= " AND (position_id IN ('67','93') OR ca.divisi = 'DEE' OR cr.contributor = '$kar_id')";
            }
            elseif($pos_id =='100')
            {
                $sql .= " AND (position_id IN ('100', '103') OR ca.divisi = 'DWT' OR cr.contributor = '$kar_id')";
            }
            elseif($cbg != '' AND in_array($pos_id, array('55', '56', '57', '58', '18', '60', '62', '75'))) 
            {
                $sql .= " AND (kr.cabang = '$cbg' OR ca.status = '$kar_id' OR cr.contributor = '$kar_id')";
            }
            elseif(in_array($pos_id, array('1', '2', '14', '5'))) 
            {
                $sql .= "";
            }
            else 
            {
                $sql .= " AND (ca.sales_id = $kar_id OR cr.contributor = '$kar_id')";
            }

            $sql .= " GROUP BY ca.id ASC";
            
            $res = $this->db->query($sql)->result_array();

            return $res;
        }


        public function getKetentuan($id = '')
        {
            $sql =  "SELECT date_created, date_modified, ketentuan, tbl_loginuser.nickname FROM tbl_ketentuan
                LEFT JOIN tbl_loginuser ON tbl_ketentuan.user_id = tbl_loginuser.karyawan_id
                WHERE tbl_ketentuan.nama_modul = '10'
                ORDER BY tbl_ketentuan.id DESC LIMIT 1";
            return $this->db->query($sql)->row_array();
        }


        public function addCash()
        { 
            if($this->input->post())
            {
                
                $sess           = $_SESSION['myuser'];
                $salesID        = $_SESSION['myuser']['karyawan_id'];
                $sales          = substr($sess['position'], 0, 5);
                $alasan         = $this->input->post('keterangan');
                $deskripsi      = $this->input->post('deskripsi');           
                $amount_expense = $this->input->post('amount_expense');
                $amount_expense = str_replace(".", "", $amount_expense);
                $message        = $this->input->post('message');
                $amount         = $this->input->post('amount');
                $amount         = str_replace(".", "", $amount);
                $files          = $this->input->post('nota');
                $username       = $this->input->post('namasales');
                $divisi         = $this->input->post('divisi');
                $nextto         = $this->input->post('nextto');
                $type           = $this->input->post('type');

                    
                $cash = array(
                    'sales_id'          => $salesID,
                    'divisi'            => $divisi,                        
                    'alasan_pembelian'  => $alasan,
                    'message'           => $message,
                    'amount'            => $amount,                    
                    'date_created'      => date('Y-m-d H:i:s'),
                    'type'              => $type,
                    'published'         => '1',
                    'nextto'            => $nextto,
                );
                $this->db->insert('tbl_cash', $cash);
                $cash_id = $this->db->insert_id();

                //$logpr = $this->AddLogCash($cash_id, $salesID);
                $this->uploadfile($cash_id, '0', '0');

                 $insert = array(
                    'cash_id'       => $cash_id,
                    'user'          => $salesID,
                    'contributor'   => $salesID,
                    'date_created'  => date('Y-m-d H:i:s'),
                    );
                $this->db->insert('tbl_cash_contributor', $insert);

                $insert = array(
                    'cash_id'       => $cash_id,
                    'user'          => $salesID,
                    'contributor'   => $nextto,
                    'date_created'  => date('Y-m-d H:i:s'),
                    );
                $this->db->insert('tbl_cash_contributor', $insert);


                if($type=='1')
                {
                    $amnt = array( 
                        'amount'            => $amount,                    
                    );

                    $this->db->where('id', $cash_id);
                    $this->db->update('tbl_cash', $amnt); 

                    $this->sortNotification($cash_id, $cash_id, '13', $salesID); 

                    $this->add_pesan($cash_id, 'Membuat Cash Advance Baru', 'New');

                }elseif($type=='2') {

                    for($i=0; $i<sizeof($deskripsi); $i++)
                    {
                        $dataSet = array (
                            'cash_id'            => $cash_id,
                            'deskripsi'          => $deskripsi[$i],
                            'amount_expense'     => $amount_expense[$i],
                            'user'               => $salesID [$i],
                            'date_created'       => date('Y-m-d H:i:s'), 
                        ); 
                                            
                        $this->db->insert('tbl_cash_expenses', $dataSet);

                        $exp_id = $this->db->insert_id();

                        $file = $_FILES['nota']['name'][$i];
                        if($_FILES['nota']['type'] == 'image/jpeg')
                        {
                            $file = substr($file, 0, -5);
                        }else 
                        {
                            $file = substr($file, 0, -4);
                        }
                    
                        if($file) 
                        {
                            $sql = "UPDATE tbl_upload_cash SET sub_id = '$exp_id' WHERE cash_id = '$cash_id' AND file_name like '%$file%'";
                            $this->db->query($sql);
                        }

                    }

                        

                    $this->db->where('id', $cash_id);
                    $this->db->update('tbl_cash', array('total_amount' => '0')); 

                    $this->sortNotification($cash_id, $cash_id, '13', $salesID);

                    $this->add_pesan($cash_id, 'Membuat Cash Expenses Baru', 'New');
                } 
                
                return $cash_id;  
            }           
        }


        public function uploadfile($type_id, $type, $sub_id)
        {
            function compress_image($src, $dest , $quality) 
            { 
                $info = getimagesize($src);
              
                if ($info['mime'] == 'image/jpeg') 
                { //echo "jpeg zzz"; exit();
                   $image = imagecreatefromjpeg($src);
                   //compress and save file to jpg
                imagejpeg($image, $dest, $quality);
                }
                elseif ($info['mime'] == 'image/png') 
                { //echo "png cscscsc"; exit(); 
                    $image = imagecreatefrompng($src);
                imagepng($image, $dest, $quality);
                }
                //return $dest;
            }

            function thumb_image($src, $dest) {

                $info = getimagesize($src);
                $direktoriThumb     = "assets/images/upload_cash/thumb_cash/";

                $temp   = explode(".", $dest); 
                $jns    = end($temp);
                $cut     = substr($dest, 0, -4);
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

                //print_r($thumbHeight); exit();
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
                $uploaddir = 'assets/images/upload_cash/';

                foreach ($_FILES['nota']['name'] as $key => $value) 
                {  

                    $temp =  explode(".", $value); 
                    $jns = end($temp);
                    $fname = substr($value, 0, -4);
                    $fname = $fname.'_'.$type_id.'.'.$jns;

                    if(!$value) 
                    {
                        //$file_name = basename($fname);

                       // $uploadfile = $uploaddir . basename($fname);
                        //move_uploaded_file($_FILES['nota']['tmp_name'][$key], $uploadfile);
                    }else{
                        $file_name = basename($fname);

                        $uploadfile = "/htdocs/iios/".$uploaddir . basename($fname);
                        //$uploadfile = $uploaddir . basename($fname);
                        move_uploaded_file($_FILES['nota']['tmp_name'][$key], $file_name);

                        $conn_id = $this->mftp->conFtp();

                        if(getimagesize($file_name)['mime'] == 'image/png'){ //echo "png aaa"; 
                            compress_image($file_name, $file_name, 7); 
                            //thumb_image($uploadfile, $fname);
                        }elseif(getimagesize($file_name)['mime'] == 'image/jpeg'){ //echo "jpeg bbbb";
                            compress_image($file_name, $file_name, 40);
                            //thumb_image($uploadfile, $fname);
                        }

                        if (ftp_put($conn_id, $uploadfile, $file_name, FTP_BINARY)) {
                            $file_upload = array(
                            'cash_id'       => $type_id,
                            'sub_id'        => $sub_id,
                            'file_name'     => $file_name,
                            'uploader'      => $_SESSION['myuser']['karyawan_id'],
                            'date_created'  => date('Y-m-d H:i:s'),
                            'type'          => $type,
                            );
                            $this->db->insert('tbl_upload_cash', $file_upload);
                            $upl_id = $this->db->insert_id();

                            $this->notification($type_id, $upl_id, '3', '');

                            ftp_close($conn_id);

                            unlink($file_name);

                        } 
                    }
                }

            }

            
        }

        public function addCashExpense($cash_id)
        { 
            if($this->input->post())
            {
                $sess           = $_SESSION['myuser'];
                $salesID        = $_SESSION['myuser']['karyawan_id'];
                $sales          = substr($sess['position'], 0, 5);
                $cash_id        = $this->input->post('cash_id');
                $deskripsi      = $this->input->post('keterangan');          
                $amount_expense = $this->input->post('amount_expense');
                $amount_expense = str_replace(".", "", $amount_expense);
               
                $username        = $this->input->post('namasales');
                $deskripsi        = $this->input->post('deskripsi');
                $kilometer        = $this->input->post('kilometer');
                $kilometer        = str_replace(".", "", $kilometer);
                $kendaraan        = $this->input->post('kendaraan');
                $keperluan        = $this->input->post('keperluan');
                $tanggungan        = $this->input->post('tanggungan');
                $jenis_pembelian = $this->input->post('jenis_pembelian');
                $files           = $this->input->post('nota');

                // print_r($kendaraan);die;
               
                $cashExpenses = array(
                    'cash_id'            => $cash_id,
                    'deskripsi'          => $deskripsi,
                     'kilometer'         => $kilometer,
                     'kendaraan'        => $kendaraan,
                     'keperluan'       => $keperluan,
                    'amount_expense'     => $amount_expense,
                    'user'               => $salesID,
                    'tanggungan'        => $tanggungan,
                    'jenis_pembelian'   => $jenis_pembelian,
                    'date_created'       => date('Y-m-d H:i:s'), 
                );
              
                $this->db->insert('tbl_cash_expenses', $cashExpenses);
                $expenses_id = $this->db->insert_id();

                if($kendaraan != '') {
                    $km = array(
                        'cash_id'       => $cash_id,
                        'cash_exp_id'   => $expenses_id,
                        'user'          => $salesID,
                        'kendaraan_id'  => $kendaraan,
                        'last_km'       => $kilometer,
                        'date_created'  => date('Y-m-d H:i:s'),
                    );
                    $this->db->insert('tbl_kendaraan_km', $km);

                    $sql = "SELECT kilometer_awal FROM tbl_kar_kendaraan WHERE id = '$kendaraan'";
                    $arr = $this->db->query($sql)->row_array();

                    $km_awal = $arr['kilometer_awal'];

                    if($km_awal == '0') {
                        $this->db->where('id', $kendaraan);
                        $this->db->update('tbl_kar_kendaraan', array('kilometer_awal' => $kilometer));
                    }

                    $this->db->where('id', $kendaraan);
                    $this->db->update('tbl_kar_kendaraan', array('kilometer_akhir' => $kilometer));
                }

                $sql = "SELECT SUM(amount_expense) as amount_exp FROM tbl_cash_expenses WHERE cash_id = $cash_id";
                $amount = $this->db->query($sql)->row_array();

                $sql = "SELECT amount FROM tbl_cash WHERE id = '$cash_id'";
                $amount_adv = $this->db->query($sql)->row_array();

                $total = $amount_adv['amount']-$amount['amount_exp'];

                $this->db->where('id', $cash_id);
                $this->db->update('tbl_cash', array('total_amount' => $total));
            
                $this->uploadfile($cash_id, '1', $expenses_id);

                //$this->sortNotification($cash_id, $expenses_id, '14', $user = '');
            }

            return $cash_id;  
        }
        
        public function add_pesan($id, $pesan, $type)
        {   
            $kar_id = $_SESSION['myuser']['karyawan_id'];
            
            $addpsn = array(
                    'cash_id'   => $id,
                    'type'      => $type,
                    'sender'    => $kar_id,
                    'pesan'     => $pesan,
                    'date_created'  => date('Y-m-d H:i:s'), 
                    );
            $this->db->insert('tbl_cash_pesan', $addpsn);
            $pesan_id = $this->db->insert_id();

            if($type == 'Pesan') 
            {
                $sql = "SELECT id FROM tbl_cash_contributor WHERE cash_id = '$id' AND contributor = '$kar_id'";
                $hsl = $this->db->query($sql)->row_array();

                if(empty($hsl)) 
                {
                    $insert = array(
                        'cash_id'       => $id,
                        'user'          => $kar_id,
                        'contributor'   => $kar_id,
                        'date_created'  => date('Y-m-d H:i:s')
                    );
                    $this->db->insert('tbl_cash_contributor', $insert);
                }
            }

            $this->notification($id, $pesan_id, '2', '0');

            return $pesan_id;    
        }
        
        public function ApproveQty()
        {
            if($this->input->post())
            {
                $id = $this->input->post('id');
                $amount_approved1 = $this->input->post('amount_approved');
                $amount_approved = str_replace(".", "", $amount_approved1);   


                $arr = array(
                    'amount_approved'   => $amount_approved,
                    'date_approved'     => date('Y-m-d H:i:s'),
                    'user_approved'     => $_SESSION['myuser']['karyawan_id'],
                    'approval_status'   => '1',
                );
                $this->db->where('id', $id);
                $this->db->update('tbl_cash', $arr);
            }   
            return $id; 
        }

        public function PayCashAdvance()
        {

            $cash_id = $this->input->post('cash_id');
            $pay1 = $this->input->post('pay');
            $pay = str_replace(".", "", $pay1);
            // $amount_paid = $this->input->post('amount_paid');
            // $total_amount = $this->input->post('total_amount');
            $kar_id = $this->input->post('username');

            $sql = "SELECT nickname, position FROM tbl_loginuser lg
                    LEFT JOIN tbl_karyawan kr ON kr.id = lg.karyawan_id
                    LEFT JOIN tbl_position ps ON ps.id = kr.position_id
                    WHERE kr.id = '$kar_id'";
            $arr = $this->db->query($sql)->row_array();
            
            $nickname = $arr['nickname'];
            $position = $arr['position'];        

            $final_amount = $pay;

            $pesan = $nickname.' ('.$position.') telah menerima cash advance sebesar Rp. '.$pay1;

            $this->add_pesan($cash_id, $pesan, 'Advance');

            $args = array(
                    'status' => $kar_id,
                    'total_amount'  => $final_amount,
                    'amount_paid'   => $final_amount,
                );
              $this->db->where('id', $cash_id);
              $this->db->update('tbl_cash', $args);

            return $cash_id;
        }

        public function getNextTo($id)
        {
            $sql = "SELECT nextto FROM tbl_cash WHERE id = '$id'";
            $row = $this->db->query($sql)->row_array();

            return $row;
        }

        public function UpStatus($type, $id)
        { 
            $position   = $_SESSION['myuser']['position_id'];
            $apr        = $this->getNextTo($id);
            $getpr      = $this->Detailscash($id);
            
            $cash_id    = $this->input->post('cash_id');
            $crm_id     = $this->input->post('crm_add');
            
            $sales      = $getpr['sales_id'];
            $divisi     = $getpr['divisi'];
            $level      = $getpr['level_approval'];
            $cbg        = $getpr['cabang'];
            $pos_user   = $getpr['position_id'];
            $tipe_cash  = $getpr['type'];
            
            $ov         = $apr['nextto'];

            $sql = "SELECT id FROM tbl_cash_log WHERE cash_id = $id ORDER BY id DESC LIMIT 1";
            $que = $this->db->query($sql)->row_array();
            $log_pr = $que['id'];
            
            switch ($divisi) {
                case 'DCE':
                    $kadiv = '90';
                    break;
                case 'DEE':
                    $kadiv = '93'; 
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
                case 'DWT':
                    $kadiv = '91'; //100
                    break;                    
            }

            switch ($cbg) {
                case 'Bandung':
                    $kacab = '57';
                    $admin = '75';
                    break;
                case 'Medan':
                    $kacab = '56';
                    $admin = '60';
                    break;
                case 'Surabaya':
                    $kacab = '55';
                    $admin = '62';
                    break;        
                case 'Cikupa':
                    $kacab = '58';
                    $admin = '18';
                    break;
                default:
                    $kacab = '0';
                    $admin = '5';                    
                    break;
            }

            $sql = "SELECT link_id FROM tbl_cash WHERE modul_link = '8' AND id = '$cash_id'";
            $row = $this->db->query($sql)->row_array();

            if(!empty($row['link_id'])) {
                
            }elseif($crm_id != '') { 
                $this->db->where('id', $cash_id);
                $this->db->update('tbl_cash', array('link_id' => $crm_id, 'modul_link' => '8'));
            }

            
            if($tipe_cash == '1') {
                $appr = 'Dir';
            }elseif($tipe_cash == '2') {
                if($divisi AND empty($level) AND !empty($cbg) AND !in_array($pos_user, array('55','56', '57', '58', '95'))) { //appr staff cabang dan ada divisi 
                    //echo "aaaaaaaaa"; exit();
                    $this->notification($id, $id, '13', $kadiv);
                    $appr = 'Kacab';
                }elseif($divisi AND empty($level) AND !empty($cbg)) { // appr kacab dan ada divisi
                    //echo "bbbbb"; exit();
                    $this->notification($id, $id, '13', $kadiv);
                    $appr = 'Kacab';
                }elseif($divisi AND $level == 'Kacab') { //appr staff cabang ke kadiv.
                    //echo "ccccc"; exit();
                    $this->notification($id, $id, '13', '2');
                    $appr = 'Kadiv';
                }elseif(empty($level) AND !empty($cbg)) { //appr staff cabang dan tidak ada divisi.
                    //echo "dddddd"; exit();
                    $this->notification($id, $id, '13', $kadiv);
                    $appr = 'Kacab';
                }elseif(empty($level) AND empty($cbg) AND in_array($pos_user, array('65','66','67','68','71','103'))) { // appr sales jakarta.
                    //echo "eeeeee"; exit();
                    $this->notification($id, $id, '13', '2');
                    $appr = 'Kadiv';
                }elseif(empty($level) AND empty($cbg)) { //appr staff jkt. 
                    //echo "fffffff"; exit();
                    $appr = 'Dir';    
                }elseif($level == 'Kadiv' OR (empty($divisi) AND $level == 'Kacab')) {
                    $appr = 'Dir';
                }    
            }

            $this->db->where('id', $id);
            $this->db->update('tbl_cash', array('level_approval' => $appr));

            if($appr == 'Dir') {
                $this->db->where('id', $id);
                $this->db->update('tbl_cash', array('status' => $ov));

                $this->notification($id, $id, '14', $admin);
            }

            if(in_array($position, array('1','2','77'))) {
                $status_approval = '3';
            }elseif(in_array($position, array('55','56', '57', '58', '95','88','89', '90', '91', '93', '100'))) {
                $status_approval = '1';
            }

                $arr = array(
                    'cash_id'           => $id,
                    'date_created'      => date("Y-m-d H:i:s"),
                    'date_approval'     => date("Y-m-d H:i:s"),
                    'user_approval'     => $_SESSION['myuser']['karyawan_id'],
                    'status_approval'   => $status_approval,
                    );
                $this->db->insert('tbl_cash_approval', $arr);
                $newapr = $this->db->insert_id();

                $addpsn = array(
                    'cash_id'       => $id,
                    'sender'        => $_SESSION['myuser']['karyawan_id'],
                    'pesan'         => 'Cash ID '.$id.' telah Di Approve',
                    'type'          => 'Approval',
                    'date_created'  => date('Y-m-d H:i:s'), 
                    );
                $this->db->insert('tbl_cash_pesan', $addpsn);
                $pesan_id = $this->db->insert_id();

        }

         public function UpStatusNotAppr()
        {
            if($this->input->post())
            {
                $id = $this->input->post('cash_id');
                $apr = $this->getNextTo($id);
                $getpr = $this->Detailscash($id);
                $sales = $getpr['sales_id'];
                $divisi = $getpr['divisi'];
                $level = $getpr['level_approval'];
                $cbg = $getpr['cabang'];
                $tipe = $getpr['tipe'];
                $ov = $apr['nextto'];

                $type = $this->input->post('not');
                $notes = $this->input->post('notes');
                
                if($type == '4') {
                    $arr = array(
                    'cash_id' => $id,
                    'date_created'  => date("Y-m-d H:i:s"),
                    'date_approval' => date("Y-m-d H:i:s"),
                    'user_approval' => $_SESSION['myuser']['karyawan_id'],
                    'status_approval'   => $type,
                    'alasan'        => $this->input->post('notes'),
                    );
                $this->db->insert('tbl_cash_approval', $arr);
                $newapr = $this->db->insert_id();

                $sql = "SELECT id FROM tbl_cash_log WHERE cash_id = $id ORDER BY id DESC LIMIT 1";
                $que = $this->db->query($sql)->row_array();
                $log_pr = $que['id'];

                $addpsn = array(
                    'cash_id' => $id,
                    //'log_cash_id' => $log_pr,
                    'sender' => $_SESSION['myuser']['karyawan_id'],
                    'pesan' => 'Cash '.$tipe.' ini Tidak Di Approve  <br> <b>Ket : </b>'.$notes,
                    'type'  => 'Approval',
                    'date_created'  => date('Y-m-d H:i:s'), 
                    );
                $this->db->insert('tbl_cash_pesan', $addpsn);
                $pesan_id = $this->db->insert_id();

                $this->db->where('id', $id);
                $this->db->update('tbl_cash', array('status' => $sales, 'level_approval' => 'Dir'));

                //notification approved ke sales_id dan direktur
                //logAll
                $this->finished($id);   

                }elseif ($type == '2') {
                    $arr = array(
                    'cash_id' => $id,
                    'date_created'  => date("Y-m-d H:i:s"),
                    'date_approval' => date("Y-m-d H:i:s"),
                    'user_approval' => $_SESSION['myuser']['karyawan_id'],
                    'status_approval'   => '2',
                    'alasan'        => $this->input->post('notes'),
                    );
                $this->db->insert('tbl_cash_approval', $arr);
                $newapr = $this->db->insert_id();


                $addpsn = array(
                    'cash_id' => $id,
                    //'log_cash_id' => $log_pr,
                    'sender' => $_SESSION['myuser']['karyawan_id'],
                    'pesan' => 'Cash '.$tipe.' ini Tidak Di Approve <br> <b>Ket : </b>'.$notes,
                    'type'  => 'Approval',
                    'date_created'  => date('Y-m-d H:i:s'), 
                    );
                $this->db->insert('tbl_cash_pesan', $addpsn);
                $pesan_id = $this->db->insert_id();

                if($divisi AND empty($level) AND !empty($cbg)) {
                    $this->db->where('id', $id);
                    $this->db->update('tbl_cash', array('level_approval' => 'Kacab'));
                }elseif($divisi AND $level == 'Kacab') {
                    $this->db->where('id', $id);
                    $this->db->update('tbl_cash', array('level_approval' => 'Kadiv'));
                }elseif(empty($level) AND !empty($cbg)) {
                    $this->db->where('id', $id);
                    $this->db->update('tbl_cash', array('level_approval' => 'Kacab'));
                }elseif(empty($level) AND empty($cbg)) {
                    $this->db->where('id', $id);
                    $this->db->update('tbl_cash', array('level_approval' => 'Kadiv'));
                }

                //notification approved ke sales_id dan direktur
                //logAll

                $this->finished($id);   
                }

                return $id;
            }
        }


        public function finished($id)
        {
            $user = $_SESSION['myuser']['karyawan_id'];

            $args = array(
                    'status' =>'101',
                    'date_closed' => date('Y-m-d H:i:s'),
                );
              $this->db->where('id', $id);
              $this->db->update('tbl_cash', $args);

              $this->add_pesan($id, '<b style ="color : green;">***** FINISHED *****</b>' , 'Finished');  
        }



        public function sortNotification($cash_id, $rec_id, $notif, $user = '') 
        {

        /*
        RULES ADVANCE : 
        --Semua staff Cabang approval kacab saja walaupun pilih divisi.
        --kacab tidak perlu approval ke direksi.

        --Sales jkt approval kadiv saja.
        --Kadiv sementara approval ke direksi.
        --Staff jkt kecuali sales, langsung approval direksi. 

        RULES EXPENSES :
        --Semua approve direksi.
        */


            $user = $_SESSION['myuser']['karyawan_id'];
            $date = date('Y-m-d H:i:s');

            $sql = "SELECT position_id, cabang, amount, divisi, ca.type FROM tbl_karyawan kr
                    LEFT JOIN tbl_cash ca ON ca.sales_id = kr.id
                    WHERE ca.id = '$cash_id'";
            $arr = $this->db->query($sql)->row_array();
                    
            $cabang = $arr['cabang'];
            $position_id = $arr['position_id'];
            $amount = $arr['amount'];
            $divisi = $arr['divisi'];
            $tipe_cash = $arr['type'];

            if($divisi) {
                switch ($divisi) {
                    case 'DCE':
                        $kadiv = '90';
                        break;
                    case 'DEE':
                        $kadiv = '93'; 
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
                    case 'DWT':
                        $kadiv = '91'; 
                        break;                    
                }
            }elseif (in_array($position_id, array('65','66','67','68','71','103'))) { //sales jkt
                 switch ($position_id) {
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
                }
            }
            
            if(in_array($position_id, array('1', '2'))) { //direksi bikin cash

   
            }elseif(in_array($position_id, array('55', '56', '57', '58'))) { //kacab bikin cash
                if($tipe_cash == '2') {
                    if($divisi == '') {
                        $this->notification($cash_id, $rec_id, $notif, '2');
                    }elseif($divisi != '') {
                        $this->notification($cash_id, $rec_id, $notif, $kadiv);
                    }
                }
            }else {
                switch ($cabang) { //staff cabang bikin cash
                    case 'Bandung':
                        $this->notification($cash_id, $rec_id, $notif, '57');
                                      
                        break;
                    case 'Medan':
                        $this->notification($cash_id, $rec_id, $notif, '56');
                       
                        break;
                    case 'Surabaya':
                        $this->notification($cash_id, $rec_id, $notif, '55');
                       
                        break;        
                    case 'Cikupa':
                        $this->notification($cash_id, $rec_id, $notif, '58');
                      
                        break;
                    default:
                        
                        if(in_array($position_id, array('88','89','90','91','93','100'))) { //kadiv bikin cash
                            $this->notification($cash_id, $rec_id, $notif, '2');
                        }elseif(in_array($position_id, array('65','66','67','68','71','103'))) { //sales jkt bikin cash
                            $this->notification($cash_id, $rec_id, $notif, $kadiv);    
                        }elseif($divisi == '') { //staff jkt bikin cash (hrd, it, import, umum)
                            $this->notification($cash_id, $rec_id, $notif, '2');
                        }                    
                        break;
                }
            }
        }

        public function notification($cash_id, $rec_id, $notif, $position_cbg)
        {
            $date = date('Y-m-d H:i:s');
            $user = $_SESSION['myuser']['karyawan_id'];

            $sql = "INSERT INTO tbl_notification (user_id, record_id, record_type, modul_id, status, modul, date_created) 
                    ";

            if($notif != '13' AND $notif != '14') {
                
                $sql .= "SELECT contributor as user, '$rec_id', '$notif', '$cash_id', '0', '10', '$date' FROM tbl_cash_contributor 
                      WHERE cash_id = '$cash_id' AND contributor != '$user' GROUP by user";   
            }elseif($notif == '13' OR $notif == '14') {
                $sql .= "SELECT id as user, '$rec_id', '$notif', '$cash_id', '0', '10', '$date' FROM tbl_karyawan
                    WHERE position_id IN ('$position_cbg') AND published = '1'
                    GROUP BY user ";
            }    
              
            $this->db->query($sql);         
        }



        public function addContributor($cash_id, $user)
        {
            $date = date('Y-m-d H:i:s');
            $kar = $_SESSION['myuser']['karyawan_id'];
            
            foreach ($user as $key => $usr) { 
                $sql = "SELECT nickname FROM tbl_loginuser WHERE karyawan_id = $usr";
                $nick = $this->db->query($sql)->row_array();

                $insert = array(
                    'cash_id'       => $cash_id,
                    'user'          => $kar,
                    'contributor'   => $usr,
                    'date_created'  => $date
                    );
                $this->db->insert('tbl_cash_contributor', $insert);
                $cont_id = $this->db->insert_id();

                $this->add_pesan($cash_id, 'Menambahkan '.$nick['nickname'].' sebagai Contributor', 'Contributor');

                $this->notification($cash_id, $cont_id, '16', '0');
            }
        }

      public function ExpensesReceived()
        {

            $exp_id = $this->input->post('receive_id');
            $cash_id = $this->input->post('cash_id');
            $receive_amount = $this->input->post('receive_amount');
            $receive_amount = str_replace(".", "", $receive_amount);
            $date_approved = date('Y-m-d H:i:s');
            $user_approved = $_SESSION['myuser']['karyawan_id'];

                $data = array(
                        'status_approved'   => '1',
                        'user_approved'     => $user_approved,
                        'receive_amount'    => $receive_amount,
                        'date_approved'     => date('Y-m-d H:i:s'),
                );

                $this->db->where('id', $exp_id);
                $this->db->update('tbl_cash_expenses', $data);

                $sql = "SELECT SUM(amount_expense) AS Amount_Expenses, SUM(receive_amount) AS amount_receive FROM `tbl_cash_expenses`  
                    WHERE `cash_id` = '$cash_id'";
                $row = $this->db->query($sql)->row_array();
                $Result1 = $row['Amount_Expenses'];
                $Receive = $row['amount_receive'];

                //$sql = "UPDATE `tbl_cash` SET `amount_paid` = amount_approved - '$Receive' WHERE `id` = '$cash_id'";
                //$this->db->query($sql);   

                $sql = "UPDATE `tbl_cash` SET `total_amount` = amount_approved - '$Receive' WHERE `id` = '$cash_id'";
                $this->db->query($sql);

                //$sql = "SELECT total_amount, paid FROM tbl_cash WHERE id = '$cash_id'";
                //$row = $this->db->query($sql)->row_array();

                
               // return number_format($row['total_amount']); 

        }
        

        public function PayCash()
        {

            $cash_id = $this->input->post('cash_id');
            $pay1 = $this->input->post('pay');
            $pay = str_replace(".", "", $pay1);
            $amount_paid = $this->input->post('amount_paid');
            $total_amount = $this->input->post('total_amount');
            $kar_id = $this->input->post('username');

            $dtl = $this->Detailscash($cash_id);
            $type = $dtl['tipe'];

            $sql = "SELECT nickname, position FROM tbl_loginuser lg
                    LEFT JOIN tbl_karyawan kr ON kr.id = lg.karyawan_id
                    LEFT JOIN tbl_position ps ON ps.id = kr.position_id
                    WHERE kr.id = '$kar_id'";
            $arr = $this->db->query($sql)->row_array();
            
            $nickname = $arr['nickname'];
            $position = $arr['position'];        

            $min = substr($total_amount, 0,1);

            if($min == '-') {
                $final_amount = $total_amount+$pay;
            }elseif($min != '-') {
                 $final_amount = $total_amount-$pay;
            }

            $minus = substr($final_amount, 0,1);

            if($type == 'Expenses' OR ($type == 'Advance' AND $min == '-')) {
                $pesan = 'telah dibayarkan sebesar Rp. '.$pay1.' kepada '.$nickname.' ('.$position.')';
            }elseif($min != '-' AND $type == 'Advance') {
                $pesan = 'telah menerima sisa cash advance sebesar Rp. '.$pay1.' dari '.$nickname.' ('.$position.')';
            }

            $this->add_pesan($cash_id, $pesan, 'Paid');

            $args = array(
                    'status' =>'101',
                    'date_closed' => date('Y-m-d H:i:s'),
                    'paid'      => $pay,
                    'total_amount'  => $final_amount,
                );
              $this->db->where('id', $cash_id);
              $this->db->update('tbl_cash', $args);

              $this->add_pesan($cash_id, '<b style ="color : green;">***** FINISHED *****</b>', 'Finished');  

            return $cash_id;
        }


        public function AddLogCash($id, $emp)
        {
            $sql  = "SELECT * FROM tbl_cash_log WHERE cash_id = '$id' ORDER BY id DESC LIMIT 2";
            $query = $this->db->query($sql);
            $num_rows = $query->num_rows();
            $res = $query->result_array();
            $kar_id = $_SESSION['myuser']['karyawan_id'];
            

            if($num_rows == '0')
            {
                $log = array(
                    'cash_id' => $id,
                    'id_operator'   => $_SESSION['myuser']['karyawan_id'],
                    'date_created'  => date('Y-m-d H:i:s'),
                    );
                $this->db->insert('tbl_cash_log', $log);
                $newlog = $this->db->insert_id();

                return $newlog;

                //notification approve ke kadiv / kacab dan direktur
                //logAll
            }elseif($num_rows == '1') {
                $idlog0 = $res['0']['id'];

                $uplog = array(
                    'cash_id' => $id,
                    'overto'    => $emp,
                    'time_nextto'   => date('Y-m-d H:i:s'),
                    );
                $this->db->where('id', $idlog0);
                $this->db->update('tbl_cash_log', $uplog);

                $log = array(
                    'cash_id' => $id,
                    'id_operator'   => $emp,
                    'date_created'  => date('Y-m-d H:i:s'),
                    );
                $this->db->insert('tbl_cash_log', $log);
                $newlog = $this->db->insert_id();

                return $newlog;


                //notification approve ke kadiv / kacab dan direktur
                //logAll
            }elseif($num_rows >= '2') {
                $log0 = $res['0'];
                $log1 = $res['1'];

                if($log0['id_operator'] == $kar_id AND $log1['time_login'] == '0000-00-00 00:00:00' AND $log1['time_nextto'] != '0000-00-00 00:00:00') 
                { //print_r("if 1"); exit();
                    $uplog1 = array(
                        'time_login'    => date('Y-m-d H:i:s'),
                        'time_idle' => date('Y-m-d H:i:s'),
                        );
                    $this->db->where('id', $log1['id']);
                    $this->db->update('tbl_cash_log', $uplog1);

                    $uplog = array(
                        'overto'    => $emp,
                        'time_nextto'   => date('Y-m-d H:i:s'),
                        );
                    $this->db->where('id', $log0['id']);
                    $this->db->update('tbl_cash_log', $uplog);

                    $log = array(
                        'cash_id' => $id,
                        'id_operator'   => $emp,
                        'date_created'  => date('Y-m-d H:i:s'),
                        );
                    $this->db->insert('tbl_cash_log', $log);
                    $newlog = $this->db->insert_id();

                    return $newlog;
                    //notification approve ke id_operator newlog
                //logAll
                
                }elseif ($log0['id_operator'] == $kar_id AND $log1['time_login'] != '0000-00-00 00:00:00' AND $log1['time_nextto'] != '0000-00-00 00:00:00') { //print_r("if 2"); exit();
                    
                    $uplog = array(
                        'overto'    => $emp,
                        'time_nextto'   => date('Y-m-d H:i:s'),
                        );
                    $this->db->where('id', $log0['id']);
                    $this->db->update('tbl_cash_log', $uplog);

                    $log = array(
                        'cash_id' => $id,
                        'id_operator'   => $emp,
                        'date_created'  => date('Y-m-d H:i:s'),
                        );
                    $this->db->insert('tbl_cash_log', $log);
                    $newlog = $this->db->insert_id();

                    return $newlog;

                }elseif($log0['id_operator'] != $kar_id AND $log1['time_login'] == '0000-00-00 00:00:00' AND $log1['time_nextto'] != '0000-00-00 00:00:00') { //print_r("if 3"); exit();

                    $update = array(
                        'time_login'    => date('Y-m-d H:i:s'),
                        'time_idle'     => date('Y-m-d H:i:s'),
                    );
                    $this->db->where('id', $log1['id']);
                    $this->db->update('tbl_cash_log', $update);

                    $update = array(
                        'time_login'    => date('Y-m-d H:i:s'),
                        'time_idle'     => date('Y-m-d H:i:s'),
                        'overto'        => $kar_id,
                    );
                    $this->db->where('id', $log0['id']);
                    $this->db->update('tbl_cash_log', $update);

                    $arr = array(
                        'cash_id'     => $id,
                        'id_operator'   => $kar_id,
                        'date_created'  => date('Y-m-d H:i:s'),
                        'time_nextto'   => date('Y-m-d H:i:s'),
                        'overto'        => $emp,
                    );
                    $this->db->insert('tbl_cash_log', $arr);

                    $arr = array(
                        'cash_id'     => $id,
                        'id_operator'   => $emp,
                        'date_created'  => date('Y-m-d H:i:s'),
                    );
                    $this->db->insert('tbl_cash_log', $arr);
                    $newlog = $this->db->insert_id();

                    return $newlog;

                    //notification approve ke id_operator newlog
                    //logAll

                }elseif($log0['id_operator'] != $kar_id AND $log1['time_login'] != '0000-00-00 00:00:00' AND $log1['time_nextto'] != '0000-00-00 00:00:00') { //print_r("if 4"); exit();
                    
                    $update = array(
                        'time_login'    => date('Y-m-d H:i:s'),
                        'time_idle'     => date('Y-m-d H:i:s'),
                        'overto'        => $kar_id,
                    );
                    $this->db->where('id', $log0['id']);
                    $this->db->update('tbl_cash_log', $update);

                    $arr = array(
                        'cash_id'     => $id,
                        'id_operator'   => $kar_id,
                        'date_created'  => date('Y-m-d H:i:s'),
                        'time_nextto'   => date('Y-m-d H:i:s'),
                        'overto'        => $emp,
                        );
                    $this->db->insert('tbl_cash_log', $arr);

                    $arr = array(
                        'cash_id'     => $id,
                        'id_operator'   => $emp,
                        'date_created'  => date('Y-m-d H:i:s'),
                        );
                    $this->db->insert('tbl_cash_log', $arr);
                    $newlog = $this->db->insert_id();

                    return $newlog;

                    //notification approve ke id_operator newlog
                    //logAll
                }
            }   
        }
}