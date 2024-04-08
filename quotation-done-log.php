<?php if(! defined('BASEPATH')) exit('No direct script access allowed');    
    /**
    * 
    */
class Quotation_model extends CI_Model { 
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();

        $this->load->model('Crm_model','crm');
        $this->load->model('Quotation_divisi_model','divisi');  
        $this->load->model('Shipment_model','shipment');
        $this->load->model('Quotation_upload','qupload');
        $this->load->model('Masterproduk_model','masterproduk');
    }
    
    // DEVEL
    public function newQuotation($crm_id,$quotation_type)
    {
        $crm   = $this->crm->getDetail($crm_id);
        $email = $crm['email'];
        
        $user = $this->session->userdata('myuser');
        $sales_id = $user['karyawan_id'];
        
        $divisi = $this->input->post('divisi_select');
        
        $setting_divisi = $this->divisi->getDivisiManager($divisi);
        
        $payment_terms = $setting_divisi['quotation_terms'];
        $warranty_terms = $setting_divisi['warranty_terms'];

        $sql ="SELECT * FROM tbl_tariff_ppn";
        $ress = $this->db->query($sql)->row_array();

        $tariff_ppn = $ress['ppn'];

        $insert = array(
            'quotation_version' => 'new',
            'crm_id'            => $crm_id,
            'sales_id'          => $sales_id,
            'divisi'            => $divisi,
            'quotation_type'    => $quotation_type,
            'ppn'               => 'excluded',
            'status'            => 'draft',
            'payment_terms'     => $payment_terms,
            'warranty_terms'    => $warranty_terms,
            'customer_email'    => $email,
            'tariff_ppn'        => $tariff_ppn,
        );
        
        $this->db->insert('tbl_quotation', $insert);
        $quotation_id = $this->db->insert_id();


        return $quotation_id;
    }
    
    public function getQuotation($id)
    {
        $sql = "SELECT * FROM tbl_quotation WHERE id = '$id'";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        $quote = $query->row_array();
        
        return $quote;
    }
    
    public function getHeader($type,$id)
    {
        /*
        $array_divisi = array('DHC','DRE','DCE', 'DGC', 'DHE', 'DEE', 'DWT');
        
        $user           = $this->session->userdata('myuser');
        $user_position  = $user['position'];
        $divisi         = $user['divisi'];
        */
        
        if ($type == 'by_id')
        {       
            $sql = "SELECT * FROM tbl_quotation_header WHERE id = '$id'";
            $query = $this->db->query($sql);
            $header = $query->row_array();
        }
        elseif ($type == 'by_divisi')
        {       
            $sql = "SELECT * FROM tbl_quotation_header WHERE divisi  = '$id' ORDER BY main_image DESC, namafile ASC";
            
            $query = $this->db->query($sql);
            $header = $query->result_array();
        }       

        return $header;
    }
    
    public function getListItem($quotation_id)
    {
        $sql = "SELECT a.tipe_produk,b.discount,b.id as id_item,c.insurance,krw.email,c.created,b.ket_stock,a.id as sku,b.status_logistic,b.delivery_cost_item,b.courier_name,b.quotation_id,a.nama_produk, a.keterangan, a.gambar, a.jenis_satuan, a.publish, a.satuan, 
        b.id, b.product_id, b.type_produk, b.rupiah_price, b.length, b.quantity_per_length, b.quantity, b.total_price, b.discount_amount, b.best_price, b.stock_status, b.stock_time, b.stock_time_scale, b.display_order, c.ppn,b.berat,b.panjang,b.lebar,b.tinggi,c.delivery_type,c.delivery_cost,b.packing_cost,b.packing_type,pc.harga as harga_packing
        FROM tbl_quotation_product a 
        JOIN tbl_quotation_item b ON b.product_id = a.id 
        JOIN tbl_quotation c ON c.id = b.quotation_id
        LEFT JOIN tbl_packing_type pc ON pc.packing_type = b.packing_type
        LEFT JOIN tbl_karyawan krw ON krw.id = c.sales_id
        WHERE c.id = '$quotation_id'
        ORDER BY b.display_order, b.id";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        $getproduct = $query->result_array();
    
        return $getproduct;
    }   
    
    public function getTotalPrimary($quotation_id)
    {
        $sql = "SELECT SUM(a.best_price) AS total_primary FROM tbl_quotation_item a 
        WHERE a.quotation_id = '$quotation_id' AND type_produk = 'Primary'";
        $query = $this->db->query($sql);
        $getproduct = $query->row_array();
    
        $total_primary = $getproduct['total_primary'];
    
        return $total_primary;
    }   
    
    public function getProductDetail($product_id,$quotation_id,$ppn=NULL)
    {
        $file_url = $this->config->item('file_url');
    
        $sql = "SELECT * FROM tbl_quotation_product WHERE id = '$product_id' AND publish = '0'";
        $query = $this->db->query($sql);
        $detailproduct = $query->row_array();
        
        $detailproduct['imglink'] = $file_url."assets/images/quotation/product/".$detailproduct['gambar'];
        
        $breaks = array("<br />","<br>","<br/>");  
        $detailproduct['new_item_desc'] = str_ireplace($breaks, "", $detailproduct['keterangan']);

        $currency_produk = $detailproduct['currency'];
        
        if ($currency_produk != 'IDR')
        {
            // $sql2 = "SELECT * FROM tbl_kurs WHERE currency  = '$currency_produk' ORDER BY id DESC";
            // $query2 = $this->db->query($sql2);
            // $infokurs = $query2->row_array();
            // $nilai_tukar =  $infokurs['kurs'];

            $cek_setting ="SELECT * FROM tbl_history_kurs_setting WHERE kurs ='$currency_produk' ORDER BY id DESC LIMIT 1";
            $setting = $this->db->query($cek_setting);
            $info_setting = $setting->row_array();

            if(empty($info_setting) OR $info_setting['type_currency'] =='floating')
            {
                $sql2 = "SELECT * FROM tbl_kurs WHERE currency  = '$currency_produk' ORDER BY id DESC";
                $query2 = $this->db->query($sql2);
                $infokurs = $query2->row_array();

                $sqls ="SELECT * FROM tbl_kurs_multiply_floating WHERE currency ='$currency_produk' ORDER BY id DESC LIMIT 1";
                $res = $this->db->query($sqls)->row_array();
                $multiply = $res['multiply'];

                if($multiply)
                {
                    $nilai_tukar =  $infokurs['kurs']*$multiply/100;
                }else
                {
                    $nilai_tukar =  $infokurs['kurs'];
                }

            }else
            {
                $sql2 = "SELECT * FROM tbl_kurs_fixed WHERE kurs ='$currency_produk' ORDER BY id DESC LIMIT 1";
                $query2 = $this->db->query($sql2);
                $infokurs = $query2->row_array();
                $nilai_tukar =  $infokurs['currency'];
            }


            $detailproduct['nilai_tukar'] = $nilai_tukar;
            $detailproduct['harga_produk'] = $detailproduct['harga'] * $nilai_tukar;
        }   
        else
        {
            $nilai_tukar = 1;
            $detailproduct['nilai_tukar'] = $nilai_tukar;
            $detailproduct['harga_produk'] = $detailproduct['harga'];
        }

        $sql ="SELECT * FROM tbl_tariff_ppn";
        $ress = $this->db->query($sql)->row_array();

        $ppn = $ress['ppn'];
        $ppn = $ppn/100+1;

        if ($ppn =='excluded')
        $detailproduct['harga_produk'] = $detailproduct['harga_produk']/$ppn;


        $stock  = $this->masterproduk->getProdukStock($product_id);
        $import = $this->masterproduk->getImport($product_id);

        if (isset($stock[$product_id]['all']['total']))
        $total = $stock[$product_id]['all']['total'];
        else
        $total = 0;
    
        if (isset($stock[$product_id]['all']['ready_booked']))
        $ready_booked = $stock[$product_id]['all']['ready_booked'];
        else
        $ready_booked = 0;
    
        if (isset($stock[$product_id]['all']['not_ready']))
        $not_ready = $stock[$product_id]['all']['not_ready'];
        else
        $not_ready = 0;
    
        if (isset($stock[$product_id]['all']['booked']))
        $bookeds = $stock[$product_id]['all']['booked'];
        else
        $bookeds = 0;
    
        if (isset($stock[$product_id]['all']['ordered']))
        $ordered = $stock[$product_id]['all']['ordered'];
        else
        $ordered = 0;
    
        $ready = $ready_booked - $bookeds;
        if ($ready < 0)
        $ready = 0;


        $sts_stock ='';
        $quo ='1';
        $stcks = $ordered-$bookeds;



        // get IMPORT
        foreach ($import as $key => $imp) 
        {
            $import_sblm = $import[0];
            $jumlah_sblm = $import_sblm['ship_qty'];
            
            if($key =='0')
            {
                $arrv = date('d-m-Y',strtotime($imp['arrival']));
            }
        } 

        // READY
        $sts_ready="";

        if($ready <='0')
        {
            $sts_ready ="";

            if($ready >= $quo)
            {
                $sts_ready ="";
            }else
            {
                $sts_ready ="Ready ".$ready;
            }

            if($ready=='0' AND $ordered=='0' AND $bookeds=='0')
            {
                $sts_ready ="Not Ready Stock";
            }else
            {   

                $sts_ready="";
            }
     
        }else
        {
            if($ready >= $quo)
            {
                $sts_ready ="Ready Stock";
            }else
            {
                $sts_ready ="Ready ".$ready;
            }
        }



        if($sts_ready !='Not Ready Stock')
        {
            // Arrival
            $sts_arrival ="";

            if($sts_ready == "Ready Stock")
            {
                $sts_arrival ="";
            }else
            {
                if($stcks >'0' AND $sts_ready !="")
                {
                    $sts_arrival=" + Arr ".$stcks;
                }

                if($stcks > '0' AND $sts_ready =='')
                {
                    $sts_arrival =" Arrival ".$arrv ." ".$stcks;
                }

                if($stcks < $quo AND $stcks <'0')
                {
                    $sts_arrival="";
                
                }
            }



            // hitung indent
            $htg =$quo-$ready-$ordered+$bookeds;

            if($htg<='0')
            {
                $indent ="0";
            }else
            {
                $indent = " ".$htg;
            }


            // indent
            if($indent <="0")
            {
                $sts_indent="";
            }else
            {   
                
                if(empty($sts_ready) AND empty($sts_arrival))
                {
                    $sts_indent ="Not Ready Stock";
                }else
                {   
                    $sts_indent =" + Indent ".$indent;

                }
            }

        }else
        {
            $sts_arrival="";
            $sts_indent="";
        }
        

        $sts_stock =$sts_ready."".$sts_arrival."".$sts_indent;

        $keterangan_stock = $sts_stock;

        $keterangan_stock = $keterangan_stock;

        
        $detailproduct['jenis_satuan'] = $detailproduct['jenis_satuan'];
        $detailproduct['type_produk'] = "Primary";
        $detailproduct['quantity'] = 1;
        $detailproduct['discount_type'] = "value";
        $detailproduct['discount'] = 0;
        $detailproduct['discount_amount'] = 0;
            
        $detailproduct['stock_status'] = "Ready Stock";
        $detailproduct['stock_time'] = "";
        $detailproduct['stock_time_scale'] = "days";
        $detailproduct['type_produk'] = 'Primary';
        $detailproduct['real_stock'] = $ready;
        $detailproduct['keterangan_stock'] = $keterangan_stock;

        
        return $detailproduct;
    }
    
    
    public function getItemDetail($record_id,$quotation_id,$ppn=NULL)
    {
        $file_url = $this->config->item('file_url');
    
        $sql = "
        SELECT b.ket_stock,a.nama_produk, a.keterangan, a.gambar, a.jenis_satuan, a.publish, a.satuan, a.currency, a.harga, a.max_discount,
        b.id, b.product_id, b.type_produk, b.rupiah_price, b.length, b.quantity_per_length, b.quantity, b.total_price, b.discount_type, b.discount, b.discount_amount, b.best_price, b.stock_status, b.stock_time, 
        b.stock_time_scale, b.display_order,b.berat,b.tinggi,b.panjang,b.lebar
        FROM tbl_quotation_item b  
        JOIN tbl_quotation_product a ON b.product_id = a.id 
        WHERE b.id = '$record_id' AND b.quotation_id = '$quotation_id'";
        $query = $this->db->query($sql);
        $detailitem = $query->row_array();
        
        $detailitem['imglink'] = $file_url."assets/images/quotation/product/".$detailitem['gambar'];
        
        $breaks = array("<br />","<br>","<br/>");  
        $detailitem['new_item_desc'] = str_ireplace($breaks, "", $detailitem['keterangan']);

        $currency_produk = $detailitem['currency'];
        
        if ($currency_produk != 'IDR')
        {
            // $sql2 = "SELECT * FROM tbl_kurs WHERE currency  = '$currency_produk' ORDER BY id DESC";
            // $query2 = $this->db->query($sql2);
            // $infokurs = $query2->row_array();
            // $nilai_tukar =  $infokurs['kurs'];

            $cek_setting ="SELECT * FROM tbl_history_kurs_setting WHERE kurs ='$currency_produk' ORDER BY id DESC LIMIT 1";
            $setting = $this->db->query($cek_setting);
            $info_setting = $setting->row_array();

            if(empty($info_setting) OR $info_setting['type_currency'] =='floating')
            {
                $sql2 = "SELECT * FROM tbl_kurs WHERE currency  = '$currency_produk' ORDER BY id DESC";
                $query2 = $this->db->query($sql2);
                $infokurs = $query2->row_array();

                $sqls ="SELECT * FROM tbl_kurs_multiply_floating WHERE currency ='$currency_produk' ORDER BY id DESC LIMIT 1";
                $res = $this->db->query($sqls)->row_array();
                $multiply = $res['multiply'];

                if($multiply)
                {
                    $nilai_tukar =  $infokurs['kurs']*$multiply/100;
                }else
                {
                    $nilai_tukar =  $infokurs['kurs'];
                }

                
            }else
            {
                $sql2 = "SELECT * FROM tbl_kurs_fixed WHERE kurs ='$currency_produk' ORDER BY id DESC LIMIT 1";
                $query2 = $this->db->query($sql2);
                $infokurs = $query2->row_array();
                $nilai_tukar =  $infokurs['currency'];
            }


            $detailitem['nilai_tukar'] = $nilai_tukar;
            $detailitem['harga_produk'] = $detailitem['harga'] * $nilai_tukar;
        }   
        else
        {
            $nilai_tukar = 1;
            $detailitem['nilai_tukar'] = $nilai_tukar;
            $detailitem['harga_produk'] = $detailitem['harga'];
        }

        $sql ="SELECT * FROM tbl_tariff_ppn";
        $ress = $this->db->query($sql)->row_array();

        $ppn = $ress['ppn'];
        $ppn = $ppn/100+1;

        if ($ppn =='excluded')
        $detailitem['harga_produk'] = $detailitem['harga_produk']/$ppn;

        //DISCOUNT
        if (($ppn =='excluded') AND ($detailitem['discount_type']=='value'))
        {
            $detailitem['discount_amount'] = $detailitem['discount_amount']/$ppn;
            $detailitem['discount'] = $detailitem['discount']/$ppn;         
        }   
        
        $detailitem['jenis_satuan'] = $detailitem['jenis_satuan'];

        $product_id = $detailitem['product_id'];
        $stock  = $this->masterproduk->getProdukStock($product_id);
        $import = $this->masterproduk->getImport($product_id);

        if (isset($stock[$product_id]['all']['total']))
        $total = $stock[$product_id]['all']['total'];
        else
        $total = 0;
    
        if (isset($stock[$product_id]['all']['ready_booked']))
        $ready_booked = $stock[$product_id]['all']['ready_booked'];
        else
        $ready_booked = 0;
    
        if (isset($stock[$product_id]['all']['not_ready']))
        $not_ready = $stock[$product_id]['all']['not_ready'];
        else
        $not_ready = 0;
    
        if (isset($stock[$product_id]['all']['booked']))
        $bookeds = $stock[$product_id]['all']['booked'];
        else
        $bookeds = 0;
    
        if (isset($stock[$product_id]['all']['ordered']))
        $ordered = $stock[$product_id]['all']['ordered'];
        else
        $ordered = 0;
    
        $ready = $ready_booked - $bookeds;
        if ($ready < 0)
        $ready = 0;

        $sts_stock ='';
        $quo =$detailitem['quantity'];
        $stcks = $ordered-$bookeds;



        // get IMPORT
        foreach ($import as $key => $imp) 
        {
            $import_sblm = $import[0];
            $jumlah_sblm = $import_sblm['ship_qty'];
            
            if($key =='0')
            {
                $arrv = date('d-m-Y',strtotime($imp['arrival']));
            }
        } 

      


        // READY
        $sts_ready="";

        if($ready <='0')
        {
            $sts_ready ="";

            if($ready >= $quo)
            {
                $sts_ready ="";
            }else
            {
                $sts_ready ="Ready ".$ready;
            }

            if($ready=='0' AND $ordered=='0' AND $bookeds=='0')
            {
                $sts_ready ="Not Ready Stock";
            }else
            {   

                $sts_ready="";
            }
     
        }else
        {
            if($ready >= $quo)
            {
                $sts_ready ="Ready Stock";
            }else
            {
                $sts_ready ="Ready ".$ready;
            }
        }



        if($sts_ready !='Not Ready Stock')
        {
            // Arrival
            $sts_arrival ="";

            if($sts_ready == "Ready Stock")
            {
                $sts_arrival ="";
            }else
            {
                if($stcks >'0' AND $sts_ready !="")
                {
                    $sts_arrival=" + Arr ".$stcks;
                }

                if($stcks > '0' AND $sts_ready =='')
                {
                    $sts_arrival =" Arrival ".$arrv ." ".$stcks;
                }

                if($stcks < $quo AND $stcks <'0')
                {
                    $sts_arrival="";
                
                }
            }



            // hitung indent
            $htg =$quo-$ready-$ordered+$bookeds;

            if($htg<='0')
            {
                $indent ="0";
            }else
            {
                $indent = " ".$htg;
            }


            // indent
            if($indent <="0")
            {
                $sts_indent="";
            }else
            {   
                
                if(empty($sts_ready) AND empty($sts_arrival))
                {
                    $sts_indent ="Not Ready Stock";
                }else
                {   
                    $sts_indent =" + Indent ".$indent;

                }
            }

        }else
        {
            $sts_arrival="";
            $sts_indent="";
        }
        

        $sts_stock =$sts_ready."".$sts_arrival."".$sts_indent;

        $keterangan_stock = $sts_stock;

        $keterangan_stock = $keterangan_stock;

        $detailitem['keterangan_stock'] = $keterangan_stock;
        return $detailitem;
    }
    
    
    public function getLotPrice($quotation_id)
    {
        $sql = "SELECT SUM(a.best_price) AS total_best_price, b.ppn FROM tbl_quotation_item a 
        JOIN tbl_quotation b ON b.id = a.quotation_id 
        WHERE b.id = '$quotation_id'";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        $best = $query->row_array();

        $sql ="SELECT * FROM tbl_tariff_ppn";
        $ress = $this->db->query($sql)->row_array();

        $ppn = $ress['ppn'];
        $ppn = $ppn/100+1;
        
        if ($best['ppn']=='included')
        $total_best_price = $best['total_best_price'];
        else
        $total_best_price = $best['total_best_price']/$ppn;
        
        return $total_best_price;
    }

    public function getLotPrice1($quotation_id)
    {
        $sql = "SELECT SUM(a.best_price) AS total_best_price, b.ppn,
        SUM(a.panjang) as panjang,
        SUM(a.tinggi) as tinggi,SUM(a.lebar) as lebar,SUM(a.berat) as berat FROM tbl_quotation_item a 
        JOIN tbl_quotation b ON b.id = a.quotation_id 
        LEFT JOIN tbl_quotation_product c ON c.id = a.product_id
        WHERE b.id = '$quotation_id' AND a.type_produk='Primary'";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        $best = $query->row_array();

        $panjang = $best['panjang'];
        $lebar = $best['lebar'];
        $tinggi = $best['tinggi'];
        $berat1 = $best['berat'];
        $berat = $berat1;
        
        $sql ="SELECT * FROM tbl_tariff_ppn";
        $ress = $this->db->query($sql)->row_array();

        $ppn = $ress['ppn'];
        $ppn = $ppn/100+1;

        if ($best['ppn']=='included')
        $total_best_price = $best['total_best_price'];
        else
        $total_best_price = $best['total_best_price']/$ppn;

        $arr= array(
            'total_best_price' => $total_best_price,
            'berat' => $berat
        );
        
        return $arr;
    }
    
    public function addItem()
    {   

        $sql ="SELECT * FROM tbl_tariff_ppn";
        $ress = $this->db->query($sql)->row_array();
        $ppn = $ress['ppn'];

        $quotation_id   = $this->input->post('quotation_id');
        $product_id     = $this->input->post('product_id');

        $item_id        = $this->input->post('item_id');

        $ppn            = $this->input->post('ppn_item');
        
        $courier        = $this->input->post('courier');
        $delivery_cost  = $this->input->post('delivery_cost');

        $berat      = $this->input->post('berat');
        $panjang    = $this->input->post('panjang');
        $lebar      = $this->input->post('lebar');
        $tinggi     = $this->input->post('tinggi'); 

        $stock_ket          = $this->input->post('stock_ket');


        if($stock_ket == "Not Ready Stock")
        {
            $mod_stock          = $this->input->post('mod_stock');

            $days_rs                = $this->input->post('days_rs');
            $days_sea               = $this->input->post('days_sea');
            $days_air               = $this->input->post('days_air');

            if($mod_stock =='Indent Sea Freight')
            {
                $ket_stock ="Indent Sea Freight ".$days_sea." Days";

            }elseif($mod_stock == "Indent Air Freight")
            {
                $ket_stock ="Indent Air Freight ".$days_air." Days";
            }
            else
            {
                $ket_stock = "Ready Stock ".$days_rs." Days";
            }

        }else
        {
            $ket_stock=$stock_ket;
        }
      
        if (empty($product_id))
        {
            $sql = "SELECT * FROM tbl_quotation_item WHERE id = '$item_id' AND quotation_id = '$quotation_id'";
            $query = $this->db->query($sql);
            $thisitem = $query->row_array();
            
            $product_id = $thisitem['product_id'];
        }
        
        $detailproduct  = $this->getProductDetail($product_id,$quotation_id);
            
            
        $jenis_satuan   = $detailproduct['jenis_satuan'];
        
        $unit_price     = $detailproduct['harga'];      
        $currency       = $detailproduct['currency'];
        $nilai_tukar    = $detailproduct['nilai_tukar'];
        $rupiah_price   = $detailproduct['harga_produk'];
    

        $display_order = abs((int)$this->input->post('display_order'));
            
        $length = str_replace(",","",$this->input->post('length'));
        $quantity_per_length = str_replace(",","",$this->input->post('quantity_per_length'));
            
        $item_quantity  = str_replace(",","",$this->input->post('item_quantity'));
        
        if ($jenis_satuan != 'potong')
        {
            $length = 1;
            $quantity_per_length = $item_quantity;
        }
          
        $total_price    = $rupiah_price * $item_quantity;
            
        $discount_type  = str_replace(",","",$this->input->post('discount_type'));
        $item_discount  = str_replace(",","",$this->input->post('item_discount'));
        $type_produk = $this->input->post('type_produk');

        $sql ="SELECT * FROM tbl_tariff_ppn";
        $ress = $this->db->query($sql)->row_array();

        $ppn = $ress['ppn'];
        $ppn = $ppn/100+1;

        if (($ppn=='excluded') AND ($discount_type =='value'))
        $item_discount = $item_discount * $ppn;
        
        if (empty($item_discount))
        {
            $item_discount = 0;
            $discount_amount = 0;
        }
        else
        {
            if ($discount_type == 'percent')
            $discount_amount = ($total_price * $item_discount)/100;
            else
            $discount_amount = $item_discount;
        }


        if($ppn =='included')
        {

            $best_price     = $total_price - $discount_amount;

            $best_prices = $this->input->post('item_best_price'); 
            $best_price = str_replace(',', '', $best_prices);
            $hrgs = substr($best_price,-3);
            $hrg = substr($best_price, 0, -3);
            $hrg1 = $hrg."000";
            
            if($hrgs == '000')
            {
                 $best_price1 = $best_price;

            }else
            {
                 $best_price1 = $hrg1+1000;
            }

           
            $fix_best_price = $best_price1;
            $discount_amount = $total_price-$fix_best_price;



        }else
        {
            $fix_best_price     = $total_price - $discount_amount;
            $discount_amount    = $discount_amount;
        }



        $best_price     = $fix_best_price;

            
        //hapus yg sama, lalu insert lg
        if (!empty($item_id))
        {
            $this->db->where('id', $item_id);
            $this->db->delete('tbl_quotation_item');
        }

        $berat      = $berat;
        
        $this->db->where('quotation_id', $quotation_id);
        $this->db->where('product_id', $product_id);
        $this->db->where('length', $length);
        $this->db->delete('tbl_quotation_item');
                        
            
        $insert = array(
            'quotation_id'          => $quotation_id,
            'type_produk'           => $type_produk,
            'product_id'            => $product_id,
            'unit_price'            => $unit_price,
            'currency'              => $currency,
            'nilai_tukar'           => $nilai_tukar,
            'rupiah_price'          => $rupiah_price,
            'length'                => $length,
            'quantity_per_length'   => $quantity_per_length,
            'quantity'              => $item_quantity,
            'total_price'           => $total_price,
            'discount_type'         => $discount_type,
            'discount'              => $item_discount,
            'discount_amount'       => $discount_amount,
            'best_price'            => $best_price,
            // 'stock_status'           => $stock_status,
            // 'stock_time'         => $stock_time,
            // 'stock_time_scale'       => $stock_time_scale,
            'created'               => date("Y-m-d H:i:s"),
            'display_order'         => $display_order,
            'panjang'               => $panjang,
            'lebar'                 => $lebar,
            'tinggi'                => $tinggi,
            'berat'                 => $berat,
            'ket_stock'             => $ket_stock,
            'ppn'                   => $ppn,
        );
                 
        $this->db->insert('tbl_quotation_item', $insert);
                
        $lot_price = $this->getLotPrice($quotation_id);
            
        return $lot_price;
    }
    
    
    public function addNewItem()
    {
        $this->load->library('upload');
        
        $extensionList = array(".jpg", ".gif", ".jpeg", ".png");
    
        $user           = $this->session->userdata('myuser');
        $user_id        = $user['id'];
        $username       = $user['username'];
        

        $quotation_id   = $this->input->post('quotation_id');
        $quotation      = $this->getQuotation($quotation_id);
        $divisi         = $quotation['divisi'];

        $new_item_type   = $this->input->post('new_item_type');
        
        if ($new_item_type == 'new')
        $product_id     = $user_id.'-'.time();
        else
        $product_id     = $this->input->post('new_item_id');
        
        $nama_produk    = $this->input->post('new_item_name');
        $keterangan     = nl2br($this->input->post('new_item_desc'));
        $harga          = str_replace(",","",$this->input->post('new_item_price'));
        $currency       = "IDR";
        
        $satuan         = $this->input->post('new_satuan');
        
        // $stock_status    = $this->input->post('new_stock_status');
        // $stock_time  = $this->input->post('new_stock_time');
        // $stock_time_scale = $this->input->post('new_stock_time_scale');
        
        $file_location  = $_FILES['new_item_picture']['tmp_name'];
        $file_name      = $_FILES['new_item_picture']['name'];
        $extention      = strtolower(strrchr($file_name, '.'));
        
        $display_order = abs((int)$this->input->post('new_display_order'));
        
        if ($new_item_type == 'new')
        {
            $insert = array("id"    => $product_id,
                    "divisi"        => $divisi,
                    "nama_produk"   => $nama_produk,
                    "keterangan"    => $keterangan,
                    "harga"         => $harga,
                    "currency"      => $currency,
                    "satuan"        => $satuan,
                    "publish"       => '1',
                    "user"          => $username,
                );
        
            $this->db->insert('tbl_quotation_product', $insert);
        }
        elseif ($new_item_type == 'edit')
        {
            $this->db->set('divisi', $divisi);
            $this->db->set('nama_produk', $nama_produk);
            $this->db->set('keterangan', $keterangan);
            $this->db->set('harga', $harga);
            $this->db->set('satuan', $satuan);
            $this->db->where('id', $product_id);
            $this->db->update('tbl_quotation_product'); 
        }
        
        
        if (!empty($file_location))
        {
            $gambar         = md5(time().rand("00000000","99999999")).$extention;
            move_uploaded_file($file_location,"assets/images/quotation/product/$gambar");
            
            $this->qupload->ftp_upload("assets/images/quotation/product/$gambar");

            $this->db->set('gambar', $gambar);
            $this->db->where('id', $product_id);
            $this->db->update('tbl_quotation_product'); 
        }
        
        
        $rupiah_price   = $harga;
        $item_quantity  = str_replace(",","",$this->input->post('new_item_quantity'));
        $total_price    = $rupiah_price * $item_quantity;
        $discount_type  = str_replace(",","",$this->input->post('new_discount_type'));
        $item_discount  = str_replace(",","",$this->input->post('new_item_discount'));
        $new_type_produk = $this->input->post('new_type_produk');
        
        if (empty($item_discount))
        {
            $item_discount = 0;
            $discount_amount = 0;
        }
        else
        {
            if ($discount_type == 'percent')
            $discount_amount = ($total_price * $item_discount)/100;
            else
            $discount_amount = $item_discount;
        }
        
        $best_price     = $total_price - $discount_amount;
        
        $sql = "SELECT * FROM tbl_quotation_item WHERE quotation_id = '$quotation_id' AND product_id = '$product_id'";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        
        if ($num == 0)
        {
            $insert = array(
                'quotation_id'      => $quotation_id,
                'type_produk'       => $new_type_produk,
                'product_id'        => $product_id,
                'unit_price'        => $harga,
                'currency'          => $currency,
                'nilai_tukar'       => '1',
                'rupiah_price'      => $rupiah_price,
                'quantity'          => $item_quantity,
                'total_price'       => $total_price,
                'discount_type'     => $discount_type,
                'discount'          => $item_discount,
                'discount_amount'   => $discount_amount,
                'best_price'        => $best_price,
                // 'stock_status'       => $stock_status,
                // 'stock_time'     => $stock_time,
                // 'stock_time_scale'   => $stock_time_scale,
                'created'           => date("Y-m-d H:i:s"),
                'display_order'         => $display_order,
            );
             
            $this->db->insert('tbl_quotation_item', $insert);
        }
        else
        {
            $this->db->set('type_produk', $new_type_produk);
            $this->db->set('unit_price', $harga);
            $this->db->set('currency', $currency);
            $this->db->set('nilai_tukar', '1');
            $this->db->set('rupiah_price', $rupiah_price);
            $this->db->set('quantity', $item_quantity);
            $this->db->set('total_price', $total_price);
            $this->db->set('discount_type', $discount_type);
            $this->db->set('discount', $item_discount);
            $this->db->set('discount_amount', $discount_amount);
            $this->db->set('best_price', $best_price);
            
            // $this->db->set('stock_status', $stock_status);
            // $this->db->set('stock_time', $stock_time);
            // $this->db->set('stock_time_scale', $stock_time_scale);
            $this->db->set('display_order', $display_order);

            $this->db->where('quotation_id', $quotation_id);
            $this->db->where('product_id', $product_id);
            $this->db->update('tbl_quotation_item'); 
        }
        
                    
        $lot_price = $this->getLotPrice($quotation_id);
        
        return $lot_price;
    }
    
    
    public function removeItem()
    {
        $quotation_id   = $this->input->post('quotation_id');
        $id             = $this->input->post('id');
        
        $this->db->where('quotation_id', $quotation_id);
        $this->db->where('id', $id);
        //$this->db->where('length', $length);
        $this->db->delete('tbl_quotation_item');
        
        $lot_price = $this->getLotPrice($quotation_id);

        $this->db->set('published', '1');
        $this->db->where('quotation_item_id', $id);
        $this->db->update('tbl_quotation_upload_courier'); 
            
        return $lot_price;
    }   
    
    public function updatePPN()
    {
        $quotation_id   = $this->input->post('quotation_id');
        $ppn            = $this->input->post('ppn');
        
        $this->db->set('ppn', $ppn);
        $this->db->where('id', $quotation_id);
        $this->db->update('tbl_quotation');
        
        $lot_price = $this->getLotPrice($quotation_id);
            
        return $lot_price;
    }   
    

    public function saveQuotation($quotation_id,$load_type)
    {
        $setting = $this->getSetting();
        
        $folder = $this->qupload->get_folder();             
    
        $user = $this->session->userdata('myuser');
    
        $sales_id           = $user['karyawan_id'];
        $sales_inisial      = $user['inisial'];


        $sql = "SELECT * FROM tbl_tariff_ppn";
        $pp  = $this->db->query($sql)->row_array();
        $ppn = $pp['ppn'];
        
    
        $date                   = date("Y-m-d H:i:s");
        
        if(($load_type == 'exception') OR ($load_type=='auto') OR ($load_type=='auto_custom'))
        {

            $quotation              = $this->getQuotation($quotation_id);
            $price_term             = $quotation['price_term']; 
            $validity_period        = $quotation['price_term'];     
            $validity               = $quotation['validity'];
            $delivery_time          = $quotation['delivery_time'];  
            $delivery_period        = $quotation['delivery_period'];
            $project_description    = $quotation['project_description'];
            $lot_quantity           = $quotation['project_lot_quantity'];   
            // $nama_tujuan         = $quotation['nama_tujuan'];
            $destination_sicepat    = $quotation['destination_sicepat'];
            $destination_rajaongkir = $quotation['destination_rajaongkir'];
            $destination_tam        = $quotation['destination_tam'];
            $dlv_term               = $quotation['price_term'];
            $insurance              = $quotation['insurance'];
            $keterangan_jasa        = $quotation['keterangan_jasa'];
            $keterangan_jasa_custom = $quotation['keterangan_jasa_custom'];
            // $biaya_jasa          = $quotation['biaya_jasa'];
            $delivery_cost ='';

            //pengiriman
            $ship_via               = $quotation['ship_via'];
            $shipping_cost          = $quotation['shipping_cost'];
            $shipping_address       = $quotation['shipping_address'];
            
            $quotation_note         = $quotation['quotation_note'];
            $payment_terms          = $quotation['payment_terms'];
            $warranty_terms         = $quotation['warranty_terms'];
                    
            $ppn                    = $quotation['ppn'];
            
            $email_subject          = $quotation['email_subject'];
            $email_content          = $quotation['email_content'];
            $email_content          = $email_content.''.$setting['email_footnote'];
            $customer_email         = $quotation['customer_email'];
            $cc_email               = $quotation['cc_email'];
            $send_primary_only      = $quotation['send_primary_only'];  
            $quotation_number       = $quotation['quotation_number'];


            //$headerimage          = $this->input->post('headerimage');
            $headerimage            = "";
            $id_cabang              = $this->input->post('id_cabang');
            //$quotation_id         = $this->input->post('quotation_id');
            $price_term             = $this->input->post('price_term');     
            $dlv_term               = $price_term;
            $validity_time          = $this->input->post('validity');       
            $validity_period        = $this->input->post('validity_period');        
            $validity               = $validity_time.' '.$validity_period;
            $delivery_time          = $this->input->post('delivery_time');      
            $delivery_period        = $this->input->post('delivery_period');
            $project_description    = $this->input->post('project_description');
            $lot_quantity           = $this->input->post('lot_quantity');
            $asal                   = $this->input->post('asal'); //nurma
            $nama_tujuan            = $this->input->post('nama_tujuan');
            $destination_sicepat    = $this->input->post('destination');
            $destination_rajaongkir = $this->input->post('tujuan');
            $destination_tam        = $this->input->post('destination_eks_tam');
            // $delivery_cost       = $this->input->post('delivery_cost');

            $delivery_cost ='';

            if($price_term == 'Franco' OR $price_term=='Custom Logistic')
            {
                $dlv_term = $price_term.' '.$nama_tujuan;
                $insurance              = $this->input->post('insurance');
            }
            elseif($price_term =='Ex-work' OR $price_term =='Loco')
            {
                $dlv_term= $price_term." ".ucfirst($asal);
                $insurance              = 'no';
            }else
            {
                $dlv_term = $price_term;
                $insurance  = 'no';
            }

            //jasa
            $jasa                   = $this->input->post('jasa');
            if ($jasa == 'yes')
            {
                $keterangan_jasa    = $this->input->post('keterangan_jasa');
                $keterangan_jasa_custom = $this->input->post('keterangan_jasa_custom');
            }
            else
            {
                $biaya_jasa = "";
                $keterangan_jasa = "";
                $keterangan_jasa_custom ='';
            }       
            
            //pengiriman
            $ship_via               = $this->input->post('ship_via');
            $shipping_cost          = str_replace(",","",$this->input->post('shipping_cost'));
            $shipping_address       = $this->input->post('shipping_address');
            
            $quotation_note         = $this->input->post('quotation_note');
            $payment_terms          = $this->input->post('payment_terms');
            $warranty_terms         = $this->input->post('warranty_terms');
                    
            $ppn                    = $this->input->post('ppn');
            
            $email_subject          = $this->input->post('email_subject');
            $email_content          = $this->input->post('email_content');
            $email_content          = $email_content.''.$setting['email_footnote'];
            $customer_email         = $this->input->post('customer_email');
            $cc_email               = $this->input->post('cc_email');
            
            if (isset($_POST['send_primary_only']))
            $send_primary_only      = $this->input->post('send_primary_only');
            else
            $send_primary_only      = "no";


        }else
        {

            //$headerimage          = $this->input->post('headerimage');
            $headerimage            = "";
            $id_cabang              = $this->input->post('id_cabang');
            //$quotation_id         = $this->input->post('quotation_id');
            $price_term             = $this->input->post('price_term');     
            $dlv_term               = $price_term;
            $validity_time          = $this->input->post('validity');       
            $validity_period        = $this->input->post('validity_period');        
            $validity               = $validity_time.' '.$validity_period;
            $delivery_time          = $this->input->post('delivery_time');      
            $delivery_period        = $this->input->post('delivery_period');
            $project_description    = $this->input->post('project_description');
            $lot_quantity           = $this->input->post('lot_quantity');
            $asal                   = $this->input->post('asal'); //nurma
            $nama_tujuan            = $this->input->post('nama_tujuan');
            $destination_sicepat    = $this->input->post('destination');
            $destination_rajaongkir = $this->input->post('tujuan');
            $destination_tam        = $this->input->post('destination_eks_tam');
            // $delivery_cost       = $this->input->post('delivery_cost');

            $delivery_cost ='';

            if($price_term == 'Franco' OR $price_term=='Custom Logistic')
            {
                $dlv_term = $price_term.' '.$nama_tujuan;
                $insurance              = $this->input->post('insurance');
            }
            elseif($price_term =='Ex-work' OR $price_term =='Loco')
            {
                $dlv_term= $price_term." ".ucfirst($asal);
                $insurance              = 'no';
            }else
            {
                $dlv_term = $price_term;
                $insurance  = 'no';
            }

            //jasa
            $jasa                   = $this->input->post('jasa');
            if ($jasa == 'yes')
            {
                // $biaya_jasa          = str_replace(",","",$this->input->post('biaya_jasa'));
                $keterangan_jasa    = $this->input->post('keterangan_jasa');
                $keterangan_jasa_custom = $this->input->post('keterangan_jasa_custom');
            }
            else
            {
                $biaya_jasa = "";
                $keterangan_jasa = "";
                $keterangan_jasa_custom ='';
            }   


            
            //pengiriman
            $ship_via               = $this->input->post('ship_via');
            $shipping_cost          = str_replace(",","",$this->input->post('shipping_cost'));
            $shipping_address       = $this->input->post('shipping_address');
            
            $quotation_note         = $this->input->post('quotation_note');
            $payment_terms          = $this->input->post('payment_terms');
            $warranty_terms         = $this->input->post('warranty_terms');
                    
            $ppn                    = $this->input->post('ppn');
            
            $email_subject          = $this->input->post('email_subject');
            $email_content          = $this->input->post('email_content');
            $email_content          = $email_content.''.$setting['email_footnote'];
            $customer_email         = $this->input->post('customer_email');
            $cc_email               = $this->input->post('cc_email');
            
            if (isset($_POST['send_primary_only']))
            $send_primary_only      = $this->input->post('send_primary_only');
            else
            $send_primary_only      = "no";

        }



        
        
        //DAPATKAN DETAIL TBL QUOTATION
        $quotation              = $this->getQuotation($quotation_id);
        $sales_divisi           = $quotation['divisi'];
        $quotation_type         = $quotation['quotation_type'];
        $quotation_version      = $quotation['quotation_version'];
        $quotation_series       = $quotation['quotation_series'];
        $crm_id                 = $quotation['crm_id'];

        //$quotationheader      = $this->getHeader('by_id',$headerimage);
        
        $headerimage            = $this->getLetterHeaderId($quotation_id,$id_cabang);

        $crm                    = $this->crm->getDetail($crm_id);
        $lot_price              = $this->getLotPrice($quotation_id);
        $project_price          = $lot_price * $lot_quantity;
        $list_item              = $this->getListItem($quotation_id);
        
        //if(isset($_POST['project_price']))
        if ((($quotation['divisi'] =='DHC') OR ($quotation['divisi'] =='DEE')) AND ($quotation['quotation_type'] == 'project'))
        $project_price          = str_replace(",","",$this->input->post('project_price'));
        
        //echo "<br/><Br/><br/><br/><h1>$quotation[divisi] dan $quotation[quotation_type] = $project_price)";
    
        $arrayCode = array("1"=>"A",
                           "2"=>"B",
                           "3"=>"C",
                           "4"=>"D",
                           "5"=>"E",
                           "6"=>"F",
                           "7"=>"G",
                           "8"=>"H",
                           "9"=>"I",
                           "10"=>"J");
    
        
        //DAPATKAN JUMLAH QUOTATION UTK MEMBUAT KODE NOMOR QUOTATION
        if ($quotation_version == 'new')
        {
            $sql = "SELECT * FROM tbl_quotation WHERE crm_id = '$crm_id' AND quotation_version = 'new' AND id != '$quotation_id' AND status = 'sent'";
            $query = $this->db->query($sql);
            $num = $query->num_rows();
            
            $series_number = $num + 1;
            $quotation_series = $arrayCode[$series_number];
        
            $quotation_number = $sales_inisial.'-'.$sales_divisi.'-'.$crm_id.'-R1'.$quotation_series;
        
        }
        elseif ($quotation_version == 'revision')   
        {
            $sql = "SELECT * FROM tbl_quotation WHERE crm_id = '$crm_id' AND quotation_version = 'revision' AND quotation_series = '$quotation_series' AND id != '$quotation_id' AND status = 'sent'";
            $query = $this->db->query($sql);
            $num = $query->num_rows();
            
            $revision_number = $num + 2;
            
            $quotation_number = $sales_inisial.'-'.$sales_divisi.'-'.$crm_id.'-R'.$revision_number.$quotation_series;

        }
        
        $filename = $quotation_number.'.pdf';
        
        $email_subject_track = $email_subject.' ('.$quotation_number.')';
        
        //GET CURRENCY CODE
        $cur_code = $this->getCurCode($quotation_id);


        $sql ="SELECT * FROM tbl_tariff_ppn";
        $dat = $this->db->query($sql)->row_array();
        $tariff_ppn = $dat['ppn'];
        
        if($load_type == 'review' OR$load_type =='exception')
        {
            $update = array(
                'quotation_no'              => $quotation_number, 
                'quotation_series'          => $quotation_series, 
                'cur_code'                  => $cur_code, 
                'date'                      => $date, 
                'id_cabang'                 => $id_cabang, 
                'header_image'              => $headerimage, 
                'price_term'                => $dlv_term, //nurma
                'validity'                  => $validity, 
                'delivery_time'             => $delivery_time, 
                'delivery_period'           => $delivery_period, 
                'project_description'       => $project_description, 
                'project_lot_quantity'      => $lot_quantity, 
                'project_lot_price'         => $lot_price, 
                'jasa'                      => $jasa, 
                'keterangan_jasa'           => $keterangan_jasa, 
                'keterangan_jasa_custom'    => $keterangan_jasa_custom, 
                'ship_via'                  => $ship_via, 
                'shipping_cost'             => $shipping_cost, 
                'shipping_address'          => $shipping_address, 
                'ppn'                       => $ppn,
                'total_quotation_price'     => $project_price, 
                'filename'                  => $filename, 
                'quotation_note'            => $quotation_note, 
                'payment_terms'             => $payment_terms, 
                'warranty_terms'            => $warranty_terms, 
                'email_subject'             => $email_subject_track, 
                'email_content'             => $email_content, 
                'customer_email'            => $customer_email, 
                'cc_email'                  => $cc_email, 
                'send_primary_only'         => $send_primary_only,
                'destination_sicepat'       => $destination_sicepat,
                'destination_rajaongkir'    => $destination_rajaongkir,
                'delivery_cost_type'        => $delivery_cost,
                'insurance'                 => $insurance,
                'destination_tam'           => $destination_tam,
                'folder'                    => $folder,
                'tariff_ppn'                => $tariff_ppn
            );
            $this->db->where('id', $quotation_id);
            $this->db->update('tbl_quotation',$update);
        }
        elseif ($load_type =='send')
        {
            $update = array(
                'quotation_no'          => $quotation_number, 
                'quotation_series'      => $quotation_series, 
                'cur_code'              => $cur_code, 
                'date'                  => $date, 
                'id_cabang'             => $id_cabang, 
                'header_image'          => $headerimage, 
                'price_term'            => $dlv_term, //nurma
                'validity'              => $validity, 
                'delivery_time'         => $delivery_time, 
                'delivery_period'       => $delivery_period, 
                'project_description'   => $project_description, 
                'project_lot_quantity'  => $lot_quantity, 
                'project_lot_price'     => $lot_price, 
                'jasa'                  => $jasa, 
                'keterangan_jasa'       => $keterangan_jasa, 
                'keterangan_jasa_custom'=> $keterangan_jasa_custom, 
                'ship_via'              => $ship_via, 
                'shipping_cost'         => $shipping_cost, 
                'shipping_address'      => $shipping_address, 
                'ppn'                   => $ppn,
                'total_quotation_price' => $project_price, 
                'status'                => 'sent', 
                'send_date'             => $date, 
                'filename'              => $filename, 
                'quotation_note'        => $quotation_note, 
                'payment_terms'         => $payment_terms, 
                'warranty_terms'        => $warranty_terms, 
                'email_subject'         => $email_subject_track, 
                'email_content'         => $email_content, 
                'customer_email'        => $customer_email, 
                'cc_email'              => $cc_email, 
                'send_primary_only'     => $send_primary_only,
                'destination_sicepat'       => $destination_sicepat,
                'destination_rajaongkir'    => $destination_rajaongkir,
                'delivery_cost_type'        => $delivery_cost,
                'insurance'                 => $insurance,
                'destination_tam'           => $destination_tam,
                'folder'                    => $folder,
                'tariff_ppn'                => $tariff_ppn
            );
        
            $this->db->where('id', $quotation_id);
            $this->db->update('tbl_quotation',$update);

            // Wishlist ID : 46192

            $sql ="SELECT progress FROM tbl_crm WHERE id='$crm_id'";
            $cek = $this->db->query($sql)->row_array();
            $progress = $cek['progress'];
            
            if($progress !='Deal')
            {
                if($progress =='Introduction')
                {
                    $this->db->where('id', $crm_id);
                    $this->db->update('tbl_crm', array('progress' => 'Quotation'));
                }else
                {
                    $prgs_note = 'iios melakukan update dari quotation menjadi negotiation karena sudah ada follow up dari sales ke Customer';
                    $this->crm->addProgress($crm_id,'4',$prgs_note,' ','iios');
                }
            }else
            {
                $this->db->select('*');
                $this->db->from('tbl_quotation');
                $this->db->where('crm_id',$crm_id);
                $this->db->where('status','sent');
                $this->db->order_by('id', 'DESC');
                $query = $this->db->get(); 
                $quotation = $query->result_array();


                if($quotation)
                {   

                    $karyawan_id=$_SESSION['myuser']['karyawan_id'];
                    $isi_pesan = "Send Quotation <br>Quotation Primary & Value History : <br><br>";

                    foreach ($quotation as $key => $value) 
                    {

                        $quotation_id = $value['id'];
                        $date_created = $value['created'];

                        $sql ="SELECT itm.*,prd.nama_produk FROM tbl_quotation_item itm 
                                LEFT JOIN tbl_quotation_product prd ON prd.id = itm.product_id
                                WHERE itm.quotation_id ='$quotation_id' AND itm.type_produk='Primary'";
                        $product = $this->db->query($sql)->result_array();

                        $sql ="SELECT sum(best_price) as total_value FROM tbl_quotation_item 
                            WHERE quotation_id ='$quotation_id' AND type_produk='Primary'";
                        $tot = $this->db->query($sql)->row_array();
                       

                        $total_value = $tot['total_value'];


                        $sql ="SELECT * FROM tbl_karyawan WHERE id='$sales_id'";
                        $rest = $this->db->query($sql)->row_array();

                        $email = $rest['email'];
                        $email = explode("@",$email);
                        $email = $email['0'];

                        if(is_numeric($email) =='1')
                        {
                            $kode_sales = $email;
                          
                        }else
                        {
                            $kode_sales='000';

                        }

                        $total      = $total_value+$kode_sales;


                        $isi_pesan .= date('d-m-Y H:i:',strtotime($date_created))." Rp.".number_format($total,0)."<br>";

                        foreach($product as $prod)
                        {

                            $isi_pesan .=$prod['product_id']." ".$prod['nama_produk']."<br>";
                        }

                        $isi_pesan .="<br>";
                    }

          

                    $log = array(
                        'crm_id'        => $crm_id,
                        'date_created'  => date('Y-m-d H:i:s'),
                        'crm_type'      => 'Pesan',
                        'user_id'       => $karyawan_id,
                    );
                    $this->db->insert('tbl_crm_log', $log);
                    $log_id = $this->db->insert_id();

                    $pesan = array(
                    'crm_id'     => $crm_id,
                    'log_crm_id' => $log_id,
                    'sender'     => $karyawan_id,
                    'pesan'      => $isi_pesan,
                    'date_created' => date('Y-m-d H:i:s'),              
                    );
                    $this->db->insert('tbl_crm_pesan', $pesan);


                }
            }
            
        }
            
        $query = $this->db->query($sql);
        
        $total_primary = $this->getTotalPrimary($quotation_id);
        $shipping      = $this->getdatashipping($quotation_id);
        
        $sql ="SELECT * FROM tbl_tariff_ppn";
        $ress = $this->db->query($sql)->row_array();

        $ppn = $ress['ppn'];
        $ppn = $ppn/100+1;


        if($shipping['insurance'] =='yes')
        {
            $insurance =$total_primary;
            $total_insurance = 0.2/100*$insurance*$ppn;
        }else
        {   
            $total_insurance='0';
        }

        $total = $total_primary+$shipping['delv_cost']+$total_insurance+$shipping['packing_cost'];

        if ($quotation['quotation_type'] == 'project')
        {
            if (($quotation['divisi'] =='DHC') OR ($quotation['divisi'] =='DEE'))
            $total_primary = $project_price;
            else
            $total_primary = $total_primary * $lot_quantity;

            $total = $total_primary;
        }


        $sql ="SELECT * FROM tbl_karyawan WHERE id='$sales_id'";
        $rest = $this->db->query($sql)->row_array();

        $email = $rest['email'];
        $email = explode("@",$email);
        $email = $email['0'];

        if(is_numeric($email) =='1')
        {
            $kode_sales = $email;
          
        }else
        {
            $kode_sales='000';

        }



        $quotation              = $this->getQuotation($quotation_id);
        $jasa_quotation         = $quotation['jasa'];
        $crm_id                 = $quotation['crm_id'];
        $divisi                 = $quotation['divisi'];
        $keterangan_jasa        = $quotation['keterangan_jasa'];
        $keterangan_jasa_custom = $quotation['keterangan_jasa_custom'];



        if($jasa =='yes' AND $load_type !='fees')
        {
            

            $sql ="SELECT * FROM tbl_custom_fee WHERE quotation_id='$quotation_id' AND crm_id='$crm_id'";
            $data = $this->db->query($sql)->row_array();

            if(empty($data))
            {   
                $sql ="SELECT id FROM tbl_custom_fee ORDER BY id DESC LIMIT 1";
                $ress = $this->db->query($sql)->row_array();
                $cf_id = $ress['id']+1;

                $insert = array(
                    'id'                => $cf_id,
                    'date_created'      => date('Y-m-d H:i:s'),
                    'division'          => $divisi,
                    'salesman'          => $_SESSION['myuser']['karyawan_id'],
                    'status'            => 'Queue',
                    'keterangan_request'=> $keterangan_jasa_custom,
                    'nama_custom'       => $keterangan_jasa,
                    'quotation_id'      => $quotation_id,
                    'crm_id'            => $crm_id,
                    'profit'            => '50'
                );
                $this->db->insert('tbl_custom_fee', $insert);

            }else
            {   
                $cf_id = $data['id'];


                $insert = array(
                'division'          => $divisi,
                'salesman'          => $_SESSION['myuser']['karyawan_id'],
                'status'            => 'Queue',
                'keterangan_request'=> $keterangan_jasa_custom,
                'nama_custom'       => $keterangan_jasa,
                'quotation_id'      => $quotation_id,
                'crm_id'            => $crm_id,
                'profit'            => '50'
                );

                $this->db->where('quotation_id', $quotation_id);
                $this->db->where('crm_id', $crm_id);
                $this->db->update(' tbl_custom_fee',$insert); 
            }

            $insert_log = array(
                'cf_id'             => $cf_id,
                'log_type'          => 'message',
                'related_id'        => $cf_id,
                'user'              => $_SESSION['myuser']['karyawan_id'],
                'message'           => "Menambahkan Custom Fee Baru",
                'need_approval'     => 'no',
                'created'           => date('Y-m-d H:i:s'),
            );
                
            $this->db->insert('tbl_custom_fee_log',$insert_log);

            $file_url = $this->config->item('file_url');
    
            if($_FILES)
            { 
                $uploaddir = 'assets/images/upload_custom_fee';

                foreach ($_FILES['file_jasa']['name'] as $key => $value) 
                {
                    $temp_file_location = $_FILES['file_jasa']['tmp_name'][$key];
                    
                    $upload = $this->fileupload->filehandling($uploaddir,$temp_file_location,$value);

                    $response = $upload[0];
                    // $response ="Success";
                   
                    if ($response == 'Success')
                    {
                        $file_name = $upload[1];
                         // $file_name = $value;
                        
                        $file_upload = array(
                            'cf_id'         => $cf_id,
                            'file_name'     => $file_name,
                            'type'          => '0',
                            'uploader'      => $_SESSION['myuser']['karyawan_id'],
                            'date_created'  => date('Y-m-d H:i:s'),
                        );
                        $this->db->insert('tbl_custom_fee_upload', $file_upload);

                        $file_link = '<a href="'.$file_url.$uploaddir.'/'.$file_name.'" target="_blank">'.$file_name.'</a>';
                        
                        $message = "Mengupload file ".$file_link;
                            
                        
                        $insert_log = array(
                            'cf_id'             => $cf_id,
                            'log_type'          => 'message',
                            'related_id'        => $cf_id,
                            'user'              => $_SESSION['myuser']['karyawan_id'],
                            'message'           => $message,
                            'need_approval'     => 'no',
                            'created'           => date('Y-m-d H:i:s'),
                        );
                            
                        $this->db->insert('tbl_custom_fee_log',$insert_log);
                    }   

                        
                }
            }
            
        }
        

        $sql ="SELECT sum(best_price_fix) as total_best_price FROM tbl_quotation_item WHERE quotation_id='$quotation_id' AND type_produk='Primary'";
        $data = $this->db->query($sql)->row_array();
        $total_best_price = $data['total_best_price'];

    
        $this->db->set('prospect_value', $total_best_price);
        $this->db->where('id', $crm_id);
        $this->db->update('tbl_crm'); 
    }
    
    
    
    public function getKaryawan($id)
    {
        $sql = "SELECT tbl_karyawan.*, tbl_position.position FROM tbl_karyawan 
        JOIN tbl_position ON tbl_position.id = tbl_karyawan.position_id
        WHERE tbl_karyawan.id = '$id'";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        $karyawan = $query->row_array();
        
        return $karyawan;
    }
    
    public function getKacab($cabang)
    {
        if ($cabang == 'SBY')
        $position_id = "55";        
        elseif ($cabang == 'MDN')
        $position_id = "56";        
        elseif ($cabang == 'BDG')
        $position_id = "57";        
        elseif ($cabang == 'SMG')
        $position_id = "134";       

        $array_kacab_position   = array("SBY"=>"Kacab Surabaya",
                                        "MDN"=>"Kacab Medan",
                                        "BDG"=>"Kacab Bandung",
                                        "SMG"=>"Kacab Semarang");
        
        if (array_key_exists($cabang,$array_kacab_position))
        {
            $sql = "SELECT * FROM tbl_karyawan WHERE position_id = '$position_id' AND published = '1'";
            $query = $this->db->query($sql);
            $num = $query->num_rows();
            $karyawan = $query->row_array();
            
            $karyawan['jabatan'] = $array_kacab_position[$cabang];
        }
        else
        {
            $karyawan = array();
        
            $karyawan['nama'] = "";
            $karyawan['jabatan'] = "";
            $karyawan['phone_number'] = "";
            $karyawan['email'] = "";
            $karyawan['signature'] = "";
            
        }
        
        return $karyawan;
    }
    
    public function getCurCode($quotation_id)
    {
        $sql = "SELECT currency, nilai_tukar FROM tbl_quotation_item WHERE quotation_id = '$quotation_id' GROUP BY currency ORDER BY currency DESC ";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        $cur = $query->result_array();
        $data = array();
        
        if ($num > 0)
        {
            foreach ($cur as $item)
            $data[] .= $item['nilai_tukar'];
    
            $curcode = implode("/",$data);
        }
        else
        {
            $curcode = "";
        }
        
        return $curcode;
    }
        
    public function getSetting()
    {
        $sql = "SELECT * FROM tbl_quotation_setting WHERE id = '1'";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        $setting = $query->row_array();
        
        return $setting;
    }
    
    
    function getQuotationList($crm_id=NULL)
    {
        if ($crm_id != NULL)
        $filter = "AND quo.crm_id = '$crm_id'";
        else
        $filter = "";
    
        $sql = "SELECT quo.*,cus.id as custom_id,kar.nama,cus.status as custom_status FROM tbl_quotation quo 
        LEFT JOIN tbl_karyawan kar ON kar.id = quo.sales_id
        LEFT JOIN tbl_custom_fee cus ON cus.quotation_id = quo.id
        WHERE quo.status = 'sent' $filter ORDER BY quo.id";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        $list = $query->result_array();


        return $list;
    }
    
    function uploadFile($id)
    {
        if($_FILES)
        {  
            $uploaddir = 'assets/images/quotation/proposal/';

            foreach ($_FILES['userfiles']['name'] as $key => $value) 
            {
                if($value) 
                {
                    $file_name = $id.'-'.$key.'-'.time().'-'.str_replace(" ","-",$value);

                    $filepath = $uploaddir.''.$file_name;

                    move_uploaded_file($_FILES['userfiles']['tmp_name'][$key], $filepath);

                    $insert = array(
                        'quotation_id'  => $id,
                        'nama_file'     => $file_name,
                    );
                    
                    $this->db->insert('tbl_quotation_attachment', $insert);
                }
            }
        }   
    }
    
    function attachFiles($id)
    {
    
        $sql = "SELECT * FROM tbl_quotation_attachment WHERE quotation_id = '$id'";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        $list = $query->result_array();
    
        return $list;
    }
    
    function getMailStatus($crm_id)
    {
        file_get_contents('crontab/sendgrid-update.php');
    
        $setting = $this->getSetting();
    
        $array_recipient_email = explode(",",$setting['cc_emails']);
        
        if (is_array($array_recipient_email))
        $jml_bcc = count($array_recipient_email);
        else
        $jml_bcc = 0;
    
        $sql = "SELECT grd.*, quo.id, quo.customer_email, quo.cc_email, quo.send_date FROM tbl_sendgrid_update grd 
        JOIN tbl_quotation quo ON quo.email_subject = grd.subject
        WHERE quo.crm_id = '$crm_id' AND quo.status = 'sent' ORDER BY quo.crm_id";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        $list = $query->result_array();
        
        $send_date_list = array();
        $jml_recipient = array();
        $jml_delivered = array();
        $jml_notdelivered = array();
        $jml_open = array();
        $jml_open_count = array();
        
        foreach ($list as $data)
        {
            $id = $data['id'];
            $opens_count = $data['opens_count'];
            $status = $data['status'];
            $to_email = $data['to_email'];
            $send_date = $data['send_date'];
            
            $send_date_list[$id] = $send_date;
            
            if (!isset($recipient_array[$id]))
            $recipient_array[$id] = array();
            
            $customer_email = explode(",",$data['customer_email']);
            $cc_email = explode(",",$data['cc_email']);
            
            foreach ($customer_email as $index => $email_address)
            {
                if (filter_var($email_address, FILTER_VALIDATE_EMAIL))
                {
                    if (!array_key_exists($email_address,$recipient_array[$id]))
                    $recipient_array[$id][$email_address] = $email_address;
                }   
            }
            
            if (count($cc_email) > 0)
            {
                foreach ($cc_email as $index => $email_address)
                {
                    if (filter_var($email_address, FILTER_VALIDATE_EMAIL))
                    {
                        if (!array_key_exists($email_address,$recipient_array[$id]))
                        $recipient_array[$id][$email_address] = $email_address;
                    }   
                }
            }
            
            //menghitung jml akun email yg dikirim
            if (!isset($jml_recipient[$id]))
            $jml_recipient[$id] = 0;
            
            $jml_recipient[$id] = count($recipient_array[$id]) + $jml_bcc;
            
            
            //menghitung yg delivered dan tidak
            if (!isset($jml_delivered[$id]))
            $jml_delivered[$id] = 0;

            if (!isset($jml_notdelivered[$id]))
            $jml_notdelivered[$id] = 0;
            
            if ($status == 'delivered')
            $jml_delivered[$id] = $jml_delivered[$id] + 1;
            elseif ($status == 'not_delivered')
            $jml_notdelivered[$id] = $jml_notdelivered[$id] + 1;

            
            //menghitung open_click
            if (!isset($jml_open[$id]))
            $jml_open[$id] = 0;
            
            if ($opens_count > 0)
            $jml_open[$id] = $jml_open[$id] + 1;
            
            if (!isset($jml_open_count[$id]))
            $jml_open_count[$id] = 0;
            
            //check if email indotara atau bukan
            $explode_to = explode('@',$to_email);
            
            if (($opens_count > 0) AND ($explode_to[1] != 'indotara.co.id') AND ($explode_to[1] != 'indotara.id'))
            $jml_open_count[$id] = $jml_open_count[$id] + $opens_count;
        }
        
        $response = array("send_date_list" => $send_date_list,
                            "jml_recipient"=>$jml_recipient,
                            "jml_delivered"=>$jml_delivered,
                            "jml_notdelivered"=>$jml_notdelivered,
                            "jml_open"=>$jml_open,
                            "jml_open_count"=>$jml_open_count);
        
        return $response;
    
    }
    
    public function shorten_string($string)
    {
        $fixed_string_0 = "";
        $separator_0 = ",";
        $check_0 = strpos($string, $separator_0);
        
        if ($check_0 !== false) 
        {
            $explode_string = explode(",",$string);
            
            foreach ($explode_string as $index => $substr)
            {
                $substring = ltrim(rtrim(trim($substr)));
                
                if ($substring != '')
                {
                    if ($index == 0)
                    $new_string = $substring;
                    else
                    $new_string = $fixed_string_0.' '.$substring;
                
                    if (strlen($new_string) <= 35)
                    $fixed_string_0 = $new_string;
                    else
                    break;
                }   
            }
        }
        else
        {
            $fixed_string_0 = $string;
        }   
        
        
        $fixed_string_1 = "";
        $separator_1 = " ";
        $check_1 = strpos($fixed_string_0, $separator_1);
        
        if ($check_1 !== false) 
        {
            $explode_string = explode(" ",$fixed_string_0);
            
            foreach ($explode_string as $index => $substr)
            {
                $substring = ltrim(rtrim(trim($substr)));
                
                if ($substring != '')
                {
                    if ($index == 0)
                    $new_string = $substring;
                    else
                    $new_string = $fixed_string_1.' '.$substring;
                
                    if (strlen($new_string) <= 35)
                    $fixed_string_1 = $new_string;
                    else
                    break;
                }   
            }
        }
        else
        {
            $fixed_string_1 = $fixed_string_0;
        }   
        
        $fixed_string_2 = "";
        $separator_2 = ",";
        $check_2 = strpos($fixed_string_1, $separator_2);
        
        if($check_2 !== false) 
        {
            $explode_string = explode(",",$fixed_string_1);
            
            foreach ($explode_string as $index => $substr)
            {
                $substring = ltrim(rtrim(trim($substr)));
                
                if ($substring != '')
                {
                    if ($index == 0)
                    $new_string = $substring;
                    else
                    $new_string = $fixed_string_2.', '.$substring;
                
                    if (strlen($new_string) <= 35)
                    $fixed_string_2 = $new_string;
                    else
                    break;
                }   
            }
        }
        else
        {
            $fixed_string_2 = $fixed_string_1;
        }
                
        $fixed_string_3 = "";
        $separator_3 = "/";
        $check_3 = strpos($fixed_string_2, $separator_3);
        
        if ($check_3 !== false) 
        {
            $explode_string = explode("/",$fixed_string_2);
            
            foreach ($explode_string as $index => $substr)
            {
                $substring = ltrim(rtrim(trim($substr)));
                
                if ($substring != '')
                {
                    if ($index == 0)
                    $new_string = $substring;
                    else
                    $new_string = $fixed_string_3.' / '.$substring;
                
                    if (strlen($new_string) <= 35)
                    $fixed_string_3 = $new_string;
                    else
                    break;
                }   
            }
        }
        else
        {
            $fixed_string_3 = $fixed_string_2;
        }
    
        return $fixed_string_3; 
    }
    
    public function generateQuotation($load_type,$quotation_id=NULL)
    {

        require('assets/plugins/vendor/autoload.php');  //enable on php 7.2
        //include('assets/plugins/mpdf/mpdf.php');  //disable on php 7.2
        
        include "assets/plugins/phpqrcode-master/qrlib.php";

        
        $array_manager_position = array("1,","2","3","14","77","88","89","90","91","92","93","100");
        $array_kacab_position   = array("55","56","57","95","134");
        $array_cabang           = array("SBY","BDG","MDN","SMG");
        
        
        $file_url = $this->config->item('file_url');
        
        if((($load_type == 'resend') OR ($load_type == 'marketplace') OR ($load_type == 'auto')) AND ($quotation_id != NULL))
        {    
            $resend_quotation       = $this->getQuotation($quotation_id);
            $karyawan_id            = $resend_quotation['sales_id'];
            $karyawan               = $this->getKaryawan($karyawan_id);
            $user_position          = $karyawan['position_id'];
            $headerimage            = $resend_quotation['header_image'];
            $price_term             = $resend_quotation['price_term'];  
            $validity               = $resend_quotation['validity'];        
            $delivery_time          = $resend_quotation['delivery_time'];       
            $delivery_period        = $resend_quotation['delivery_period'];
            $project_description    = $resend_quotation['project_description'];
            $lot_quantity           = $resend_quotation['project_lot_quantity'];
            $dlv_term               = $price_term;
            $payment_terms          = $resend_quotation['payment_terms'];
        }
        else
        {   
            $user = $this->session->userdata('myuser');
            $user_position      = $user['position_id'];
            
            $karyawan_id        = $user['karyawan_id'];
            
            $karyawan           = $this->getKaryawan($karyawan_id);
            
            //$headerimage          = $this->input->post('headerimage');
            $headerimage            = "";
            $id_cabang              = $this->input->post('id_cabang');
            $quotation_id           = $this->input->post('quotation_id');
            $price_term             = $this->input->post('price_term'); 
            $validity_time          = $this->input->post('validity');       
            $validity_period        = $this->input->post('validity_period');        
            $validity               = $validity_time.' '.$validity_period;
            $delivery_time          = $this->input->post('delivery_time');      
            $delivery_period        = $this->input->post('delivery_period');
            $project_description    = $this->input->post('project_description');
            $lot_quantity           = $this->input->post('lot_quantity');
            $payment_terms          = $this->input->post('payment_terms');
            $asal                   = $this->input->post('asal');
            $nama_tujuan            = $this->input->post('nama_tujuan');

            if($price_term == 'Franco' OR $price_term=='Custom Logistic')
            {
                $dlv_term  = $price_term.' '.$nama_tujuan;
                $insurance = $this->input->post('insurance');
            }
            elseif($price_term =='Ex-work' OR $price_term =='Loco')
            {
                $dlv_term= $price_term." ".ucfirst($asal);
                $insurance              = 'no';


                $arr= array(
                    'delivery_type' =>'',
                    'delivery_cost' =>'0',
                );
                $this->db->where('id', $quotation_id);
                $this->db->update('tbl_quotation',$arr); 


                $arrs= array(
                    'status_logistic' =>'',
                    'delivery_cost_item' =>'0',
                    'courier_name'=>'',
                );
                $this->db->where('quotation_id', $quotation_id);
                $this->db->update('tbl_quotation_item',$arrs); 
                
            }else
            {
                $dlv_term = $price_term;
                $insurance  = 'no';
            }

            $this->saveQuotation($quotation_id,$load_type);
        }

        $quotation              = $this->getQuotation($quotation_id);
        $crm_id                 = $quotation['crm_id'];
        $header_image           = $quotation['header_image'];
        $crm                    = $this->crm->getDetail($crm_id);
        

        $ship_via               = $quotation['ship_via'];
        $shipment               = $this->shipment->getShipmentDetail($ship_via);

        $quotationheader        = $this->getLetterHeader($header_image);
        $lot_price              = $this->getLotPrice($quotation_id);
        $project_price          = $lot_price * $lot_quantity;
        $list_item              = $this->getListItem($quotation_id);
        $setting                = $this->getSetting();

        
        $cur_code           = $quotation['cur_code'];
        $filename           = $quotation['filename'];
        
        $hash               = sha1(md5($filename).'-'.$quotation_id);
        $filename_hash      = $hash.''.$filename;
            
        $quotation_number   = $quotation['quotation_no'];
        $divisi             = $quotation['divisi'];
        $folder             = $quotation['folder'];
        $type_ppn           = $quotation['ppn'];
        
        $sales_cabang       = $crm['sales_cabang'];
        
        $kacab_data         = $this->getKacab($sales_cabang);

        $nama_kacab         = $kacab_data['nama'];
        $jabatan_kacab      = $kacab_data['jabatan'];
        $telepon_kacab      = $kacab_data['phone_number'];
        $email_kacab        = $kacab_data['email'];
        $signature_kacab    = $kacab_data['signature'];
        $manager_data       = $this->divisi->getDivisiManager($divisi);
        
        $nama_manager           = $manager_data['nama_manager'];
        $jabatan_manager        = $manager_data['jabatan'];
        $telepon_manager        = $manager_data['telepon'];
        $email_manager          = $manager_data['email'];
        $signature_manager      = $manager_data['signature'];
        $quotation_cover        = $manager_data['quotation_cover'];
        $quotation_reference    = $manager_data['quotation_reference'];
        $quotation_reference1   = $manager_data['quotation_reference1'];
        $quotation_reference2   = $manager_data['quotation_reference2'];
        $quotation_reference3   = $manager_data['quotation_reference3'];
        $quotation_reference4   = $manager_data['quotation_reference4'];
        $quotation_reference5   = $manager_data['quotation_reference5'];
        $quotation_reference6   = $manager_data['quotation_reference6'];
        $quotation_reference7   = $manager_data['quotation_reference7'];
        $quotation_reference8   = $manager_data['quotation_reference8'];
        $quotation_reference9   = $manager_data['quotation_reference9'];
        
        $quotation_terms    = $quotation['payment_terms'];
        $warranty_terms     = $quotation['warranty_terms'];
        
        $customer_phone = $crm['telepon']; 
        if ((!empty($crm['telepon'])) AND (!empty($crm['tlp_hp']))) 
        $customer_phone .= " / "; 
        $customer_phone .= $crm['tlp_hp'];
        
        $header_image = $quotationheader['namafile'];
        $header_image_url = $file_url."assets/images/quotation/header/".$header_image;

        $quotation_cover_url = $file_url."assets/images/quotation/setting/".$quotation_cover;
        //$quotation_cover_url = "http://localhost/myiios/assets/images/quotation/setting/".$quotation_cover;
        

        $sql ="SELECT * FROM tbl_tariff_ppn";
        $ress = $this->db->query($sql)->row_array();

        $ppn = $ress['ppn'];
        $ppn = $ppn/100+1;

        if ($type_ppn == 'excluded')
        $ppn_info = '** Price are excluded PPn '.$ress['ppn'].'%';
        else
        $ppn_info = '** Price are included PPn '.$ress['ppn'].'%';

        $quotation_date = date("F d, Y", strtotime(date("Y-m-d")));


        $cover = '
        <div style="position:relative; height:100%; background:url('.$quotation_cover_url.');background-size: 2270px 3210px; background-repeat:no-repeat">
            <div style="position:absolute; width:100%; padding-top:128px;">
                <div style="font-size:33px; text-align:center;font-family:Calibri;font-weight:bold;color:#0a2a8d">COMMERCIAL QUOTATION</div>
                <div style="font-size:17px;text-align:center;font-family:Calibri;color:#0a2a8d">Quotation No. '.$quotation_number.'<br/>'.$quotation_date.'</div>
                <div style="font-size:24px;text-align:center;padding-bottom:25px;padding-top:15px;font-family:Calibri;font-weight:bold;color:#0a2a8d">'.$crm['perusahaan'].'</div>
            </div>
        </div>';

        

        
        $content = '<style>
        body {
            font-family:Arial; 
            font-size:11px;
            line-height:16px;
        }   
        
        table {
            font-family:Arial; 
            font-size:11px;
            line-height:16px;
        }
        
        .mytable, .mytable th, .mytable td {
           border: 1px solid black;
           border-collapse:collapse;
           font-family:Arial; 
           font-size:11px;
           font-weight:bold; 
        }
        
        .double-line {
            border:none;
            border-top:solid 1px #333;
            border-bottom:solid 1px #333;
            height:3px;
            margin-top:5px;
            margin-bottom:5px;
        }
        
        .product-list-header {
            border:solid 1px #333;
            padding:2px;
            text-align:center;
            font-weight:bold;
            font-family:Arial;
            font-size:12px;
            font-style:italic;
            background:#ddd;
        }
        
        .item-box img {
            max-width:100%;
        }   
        
        .item-box {
            font-size:11px;
            font-family:Arial;
            line-height:16px;
            border:solid 1px #333;
            margin-top:1px;
            margin-bottom:1px;
        }
        
        .item-box tr, .item-box td {
            vertical-align:top;
        }   
        
        .list-style-type {
            border:none;
            font-style:none;
        }   
        
        </style>';
        
        $content .= '
        <img src="'.$header_image_url.'" />
        <table width="100%" border="0" style="margin-top:10px;">
            <tr>
            <td width="20%"><span style="font-family:Arial;font-size:10px;">Cur. '.$cur_code.'</span></td>
            <td width="60%" align="center">
                <span style="font-family:Arial;font-size:14px;">
                    <b>Quotation No. '.$quotation_number.'</b>
                </span>
            </td>
            <td width="20%"></td>
            </tr>
        </table>
        <div class="double-line"></div>';
        

      
        $delivery_term = $quotation['price_term']; 
     

        $terms =$quotation['price_term'];

        if (strpos($terms, 'Ex-work') !== false) 
        {   
            $kota =str_replace("Ex-work","",$terms);
            $kota = trim($kota);
            $delivery_term = 'Ex Works (EXW) '.$kota;
        }

        if($quotation['insurance'] =='yes')
        {
            $keterangan_insurance = "Covered By Asuransi Tokio Marine";
        }else
        {
            $keterangan_insurance = "Not Covered";
        }

        


        $content .= '
        <table width="100%" cellpadding="2" cellspacing="0" style="font-family:Arial; font-size:11px;">
        <tbody>
            <tr><td width="14%">To</td><td width="36%">: '.$this->shorten_string($crm['pic']).'</td><td width="15%">From</td><td width="35%">: '.$karyawan['nama'].'</td></tr>
            <tr><td>Company</td><td>:  '.$this->shorten_string($crm['perusahaan']).'</td><td>Date</td><td>: '.date("d/m/Y H:i:s").'</td></tr>
            <tr><td>Phone</td><td>:  '.$this->shorten_string($customer_phone).'</td><td>Delivery Term</td><td>: '.$delivery_term.'</td></tr>
            <tr><td>Validity</td><td>: '.$validity.'</td><td>Freight Insurance</td><td>: '.$keterangan_insurance.'</td></tr>
            <tr><td>E-mail</td><td>:  '.$this->shorten_string($crm['email']).'</td><td>Term of Payment</td><td>: See Term & Condition</td></tr>
        </tbody>
        </table>
        <div class="double-line"></div>
        ';
        
        if ($quotation['quotation_type']=='product')
        {
            $content .= '
            <br/>
            <div class="product-list-header">Specification & Description of Quotation : </div>
            ';
        }

        if ($quotation['quotation_type']=='project')
        {
            $content .= '
            <table class="mytable" width="100%" cellpadding="5" border="2" bordercolor="#222" cellspacing="0">
            <thead>
                <tr><th align="center" width="5%"><b>No</b></th><th align="center"><b>Description</b></th><th align="center" width="10%"><b>Qty</b></th>
                <th align="center" width="20%"><b>Unit Price</b></th><th align="center" width="23%"><b>Total Project Price</b></th></tr>
            </thead>
            <tbody>
                <tr><td align="center">1</td><td>'.$project_description.'</td><td align="center">'.number_format($lot_quantity,0,",",".").' lot</td>
                <td align="center">Rp '.number_format($lot_price,0,",",".").',-</td>
                <td align="center">Rp '.number_format($project_price,0,",",".").',-';
                
                if ($ppn=='included')
                $content .= '<br/><span style="font-size:9px; font-weight:normal">** Harga sudah termasuk PPn 10%</span>';
                
                $content .= '
                </td></tr>
            </tbody>
            </table>
            <br/>
            <div class="product-list-header">Specification & Description of Quotation : </div>
            ';
        }       
        
        $no = 1;
        

        $sql ="SELECT * FROM tbl_freight_insurance_premi";
        $dat = $this->db->query($sql)->row_array();
        $premi      = $dat['premi'];


        foreach ($list_item as $key => $produk)
        {

            
            $product_image = $file_url."assets/images/quotation/product/".$produk['gambar'];
            
            if ($produk['type_produk'] == 'Primary')
            $type_produk = "P";
            elseif ($produk['type_produk'] == 'Comparison')
            $type_produk = "C";
            elseif ($produk['type_produk'] == 'Cross')
            $type_produk = "CS";

            $sql ="SELECT * FROM tbl_tariff_ppn";
            $ress = $this->db->query($sql)->row_array();

            $ppn = $ress['ppn'];
            $ppn = $ppn/100+1;
            
            if ($produk['ppn']=='excluded')
            {
                $rupiah_price = $produk['rupiah_price']/$ppn;
                $total_price = $produk['total_price']/$ppn;
                $discount_amount = $produk['discount_amount']/$ppn;
                $best_price = $produk['best_price']/$ppn;
            }
            else
            {
                $rupiah_price = $produk['rupiah_price'];
                $total_price = $produk['total_price'];
                $discount_amount = $produk['discount_amount'];
                $best_price = $produk['best_price'];
            }


            $panjang = $produk['panjang'];
            $lebar = $produk['lebar'];
            $tinggi = $produk['tinggi'];
            $volume_1 = $panjang * $lebar *$tinggi;
            $volume_2 = $volume_1/100;
            $volume_asli = $volume_1/1000000;
            $ttl_volume = $volume_asli*$produk['quantity'];


            if($ttl_volume < '0.4')
            {
                $volume ='0.4';
                $ket ="(min charge 0.4 m<sup>3</sup>)";
            }else
            {
                $volume = $ttl_volume;
                $ket ="";

            } 


            $sql ="SELECT * FROM tbl_tariff_ppn";
            $ress = $this->db->query($sql)->row_array();

            $ppn = $ress['ppn'];
            $ppn = $ppn/100+1;

            if($produk['ppn'] =='excluded')
            {
                $total_harga_packing = round($volume*$produk['harga_packing']);
            }else
            {
                $total_harga_packing = round($volume*$produk['harga_packing']*$ppn);
            }

            $total_harga_packing_masuk_db = round($volume*$produk['harga_packing']*$ppn);

            $ttl_packing_old = $produk['packing_cost']*$produk['quantity'];


         
            if($produk['ppn'] =='excluded')
            {
                $ttl_packing = $volume*$produk['harga_packing']/$ppn;
            }else
            {
                $ttl_packing = $volume*$produk['harga_packing'];
            }
            // 

            $packing_weight =$produk['berat']+10;


            $status_logistic = $produk['status_logistic'];

            if($status_logistic =='custom')
            {
                $delivery_cost = $produk['delivery_cost_item'];
                $delivery_type = $produk['courier_name'];
            
                if($produk['ppn'] =='excluded')
                {
                    $delv_cost      = ceil($delivery_cost*$produk['berat']*'1.25');
                    
                }elseif($produk['ppn'] =='included')
                {
                    $delv_cost      = ceil($delivery_cost*$produk['berat']*'1.25'*$ppn);
                }

                $shipping_masuk_db = ceil($delivery_cost*$produk['berat']*'1.25'*$ppn);

            }else
            {
            

                $delivery_type = $quotation['delivery_type'];
                $dlv_typ = explode(" " ,$produk['delivery_type']);
                $dlv_typ = $dlv_typ['0'];   

                // $delivery_cost = $produk['delivery_cost'];

                $delv_cost1      = $produk['delivery_cost']; 
                $vol             = ceil($produk['panjang']*$produk['lebar']*$produk['tinggi']/6000);

                if($produk['berat'] > $vol)
                {
                    $berat = $produk['berat'];
                }else
                {
                    $berat = $vol;  
                }

                $sql ="SELECT * FROM tbl_tariff_ppn";
                $ress = $this->db->query($sql)->row_array();

                $ppn = $ress['ppn'];
                $ppn = $ppn/100+1;

                if($produk['ppn'] =='excluded')
                {
                    $delv_cost      = ceil($delv_cost1*$berat/'0.8');
                }elseif($produk['ppn'] =='included')
                {
                    $delv_cost      = ceil($delv_cost1*$berat*$ppn/'0.8');
                }


                $delv_cost_db   =  ceil($delv_cost1*$berat*$ppn/'0.8');

                if($dlv_typ=='sicepat')
                {
                    if($berat >'50' AND $berat <='70')
                    {
                        $delv_cost_berat = $delv_cost*'1.25';

                        $shipping_masuk_db = $delv_cost_db*'1.25';
                    }
                    elseif($berat >'50' AND $berat <='100')
                    {
                        $delv_cost_berat = $delv_cost*'1.5';
                        $shipping_masuk_db = $delv_cost_db*'1.5';
                    }
                    elseif($berat >'100')
                    {
                        $delv_cost_berat = $delv_cost*'2';
                        $shipping_masuk_db = $delv_cost_db*'2';
                    }else
                    {
                        $delv_cost_berat=$delv_cost;
                        $shipping_masuk_db = $delv_cost_db;
                    }

                    $delv_cost = $delv_cost_berat; 
                }

            }

            
            $shipping_2             = ceil($delv_cost);
            $shipping               = round ($shipping_2, -3);

            $shipping_masuk_db      = ceil($shipping_masuk_db);
            $shipping_masuk_db      = round ($shipping_masuk_db, -3);


            if($shipping  > '100')
            {
                $shipping = $shipping;
            }else
            {
                $shipping = '0';
            }


            if($shipping =='0')
            {
                $shp = "No Shipping";
            }else
            {
                $shp = 'Rp.'.number_format($shipping,0,",",".").' ('.$delivery_type.')';
            }


        

            $total_delivery_cost = $total_harga_packing_masuk_db+$shipping_masuk_db+$insurance_masuk_db;

    
            
            if ($produk['stock_status']=='Ready Stock')
            $stock_time = "";
            else
            $stock_time = $produk['stock_time'].' '.$produk['stock_time_scale'];


            $email = $produk['email'];
            $email = explode("@",$email);
            $email = $email['0'];

            if(is_numeric($email) =='1')
            {
                $kode_sales = $email;
              
            }else
            {
                $kode_sales='000';

            }


     
            $fix_best_price     = $total_price-$discount_amount;

            $fix_best_price     = $fix_best_price+$shipping+$ttl_packing+$total_insurance;
    
            $total_price        = $rupiah_price*$produk['quantity']+$shipping;
            $ttl_discount       = $total_price-$fix_best_price;

            $shipping_dibagi = $shipping/$produk['quantity_per_length'];
            $packing_dibagi  = $total_harga_packing/$produk['quantity'];

            $rupiah_price_fix   = $rupiah_price+$shipping_dibagi+$packing_dibagi;

            $total_price_fix = $rupiah_price_fix*$produk['quantity_per_length'];

            
            if($produk['ppn']=='included')
            {
                if($key =='0')
                {
                    $fix_best_price = $fix_best_price+$kode_sales;
                    $discount_amount = $ttl_discount-$kode_sales;
                }


            }else
            {
                $fix_best_price = $fix_best_price;
                $discount_amount = $ttl_discount;
            }


            $stock          = $this->masterproduk->getProdukStock($produk['sku']);
            $import         = $this->masterproduk->getImport($produk['sku']);
            $product_id     = $produk['sku'];

            if($produk['ket_stock'] !='')
            {
                $keterangan_stock = $produk['ket_stock'];
            }else
            {

                if (isset($stock[$product_id]['all']['total']))
                $total = $stock[$product_id]['all']['total'];
                else
                $total = 0;
            
                if (isset($stock[$product_id]['all']['ready_booked']))
                $ready_booked = $stock[$product_id]['all']['ready_booked'];
                else
                $ready_booked = 0;
            
                if (isset($stock[$product_id]['all']['not_ready']))
                $not_ready = $stock[$product_id]['all']['not_ready'];
                else
                $not_ready = 0;
            
                if (isset($stock[$product_id]['all']['booked']))
                $bookeds = $stock[$product_id]['all']['booked'];
                else
                $bookeds = 0;
            
                if (isset($stock[$product_id]['all']['ordered']))
                $ordered = $stock[$product_id]['all']['ordered'];
                else
                $ordered = 0;
            
                $ready = $ready_booked - $bookeds;
                if ($ready < 0)
                $ready = 0;


   

                if($ready !='0')
                {
                    if($ready >= '0')
                    {
                       $keterangan_stock = "Ready Stock ".$ready; 
                    }else
                    {
                        
                        if($import)
                        {
                            foreach ($import as $key => $imp) 
                            {
                                $import_sblm = $import[0];
                                $jumlah_sblm = $import_sblm['ship_qty'];
                                
                                
                                if($key =='0')
                                {

                                    if($imp['ship_qty'] >= $produk['quantity'])
                                    {
                                        $keterangan_stock =  "Ready ".$ready." + arrival ".date('d-m-Y',strtotime($imp['arrival']));
                                    }else
                                    {
                                        $indent = $produk['quantity_per_length']-$imp['ship_qty'];
                                        $keterangan_stock = "Ready ".$ready." + Arr ".date('d-m-Y',strtotime($imp['arrival']))." ".$imp['ship_qty'];
                                    }
                                }elseif($key !='0' AND $jumlah_sblm >= 0)
                                {
                                    $keterangan_stock = "";
                                }
                               
                            }  
                        }else
                        {
                            $indent = 0-$ready;
                            $keterangan_stock =  "Ready ".$ready." + Indent ".$indent;
                        }
                    }
                    
                }
                else
                {
                  
                    if($import)
                    {
                        foreach ($import as $key => $imp) 
                        {
                            $import_sblm = $import[0];
                            $jumlah_sblm = $import_sblm['ship_qty'];
                            
                            if($key =='0')
                            {
                                if($imp['ship_qty'] >= 0)
                                {
                                    $keterangan_stock = "arrival ".date('d-m-Y',strtotime($imp['arrival']));

                                }else
                                {
                                    $indent = $produk['quantity_per_length']-$imp['ship_qty'];
                                    $keterangan_stock = "Arr ".date('d-m-Y',strtotime($imp['arrival']))." ".$imp['ship_qty'];
                                }
                            }elseif($key !='0' AND $jumlah_sblm >= 0)
                            {
                                $keterangan_stock =  "";
                            }
                           
                        }  
                    }else
                    {
                        $keterangan_stock =  "Not Ready Stock";
                    }
                }
            }

            // rumus

            $sql ="SELECT * FROM tbl_tariff_ppn";
            $data = $this->db->query($sql)->row_array();

            $ppns = $data['ppn'];
            $tariff_ppn_1 = $ppns/100+1;

            $discount_persen = $produk['discount'];
            $panjang = $produk['panjang'];
            $lebar = $produk['lebar'];
            $tinggi = $produk['tinggi'];
            $volume_1 = $panjang * $lebar *$tinggi;
            $volume_2 = $volume_1/100;
            $volume_asli = $volume_1/1000000;
            $total_volume = $volume_asli* $produk['quantity'];

            if($total_volume < '0.4')
            {
                $volume ='0.4';
            }else
            {
                $volume = $total_volume;
            } 

            $total_harga_packing = round($volume*$produk['harga_packing']*$tariff_ppn_1);
            $ttl_packing1 = $produk['packing_cost']/$produk['quantity'];
            $ttl_packing = $produk['packing_cost'];

            $ttl_packing = $volume*$produk['harga_packing']*$tariff_ppn_1;

            $ttl_pack = round($ttl_packing);


            $ttl_packing = $ttl_packing; //no pembulatan

            $dlv_typ = explode(" " ,$produk['delivery_type']);
            $dlv_typ = $dlv_typ['0'];

            if($produk['status_logistic'] =='custom')
            {
                $delv_cost = $produk['delivery_cost_item'];
                // $delv_cost      = ($delv_cost*'1.25'*$tariff_ppn_1);
                // $dlv_cost_masuk_ke_db = ($delv_cost*$produk['berat']*'1.25'*'1.1');
            }else
            {

                if($produk['delivery_cost_item'] =='0.00')
                {
                    $delv_cost1      = $produk['delivery_cost']; 
                    $vol             = ceil($produk['panjang']*$produk['lebar']*$produk['tinggi']/6000);

                    if($produk['berat'] > $vol)
                    {
                        $berat = $produk['berat'];
                    }else
                    {
                        $berat = $vol;  
                    }

                    $delv_cost      = ($delv_cost1*$berat/'0.8');
                   

                    $dlv_cost_masuk_ke_db = ($delv_cost1*$berat/'0.8');
                    

                    if($dlv_typ=='sicepat')
                    {
                        if($berat >'50' AND $berat <='70')
                        {
                            $delv_cost_berat = $delv_cost*'1.25';
                            $dlv_cost_masuk_ke_db = $dlv_cost_masuk_ke_db*'1.25';
                        }
                        elseif($berat >'50' AND $berat <='100')
                        {
                            $delv_cost_berat = $delv_cost*'1.5';
                            $dlv_cost_masuk_ke_db = $dlv_cost_masuk_ke_db*'1.5';
                        }
                        elseif($berat >'100')
                        {
                            $delv_cost_berat = $delv_cost*'2';
                            $dlv_cost_masuk_ke_db = $dlv_cost_masuk_ke_db*'2';

                        }else
                        {
                            $delv_cost_berat=$delv_cost;
                            $dlv_cost_masuk_ke_db = $dlv_cost_masuk_ke_db*'2';
                        }

                        $delv_cost = $delv_cost_berat; 
                    }
                }else
                {
                    $delv_cost = $produk['delivery_cost_item'];
                }
            }


            $shipping_2     = ceil($delv_cost);

    

            $shipping = $delv_cost;//no pembulatan

            $unit_price = $produk['rupiah_price'];

            
            $ttl_packing = $ttl_packing; 
            $discount_amount = $produk['discount_amount'];
        

            $packing_dibagi = $ttl_packing/$produk['quantity'];
            $ongkir_dibagi = $shipping/$produk['quantity'];


            if($produk['ppn']=='included')
            {
                $unt_price = $unit_price*$tariff_ppn_1;
                $ongkir_dibagi = $ongkir_dibagi;
                $packing_dibagi = $packing_dibagi;
            }else
            {
                $unt_price = $unit_price;
                $ongkir_dibagi = $ongkir_dibagi/$tariff_ppn_1;
                $packing_dibagi = $packing_dibagi/$tariff_ppn_1;
            }

            


            $unit_price_fix = $unt_price+$packing_dibagi+$ongkir_dibagi;

            $sql ="SELECT * FROM tbl_freight_insurance_premi";
            $dat = $this->db->query($sql)->row_array();
            $premi      = $dat['premi'];


            



            $total_delivery_cost = $ttl_packing+$shipping;

            $total_price         = $unit_price_fix*$produk['quantity'];
            $best_price          = ($unit_price*$produk['quantity'])-$discount_amount+$total_delivery_cost+$harga_retail;


            $best_price = $best_price+$harga_retail;



            if($discount_persen !='100')
            {
                $best = number_format($best_price);
                $a = str_replace(',', '', $best);
                $hrgs = substr($a,-3);
                $hrg = substr($a, 0, -3);
                $hrg1 = $hrg."000";

                $d = $hrg1;
            }else
            {
                $d = $best_price;
            }
           

            $email = $produk['email'];
            $email = explode("@",$email);


            $email = $email['0'];

            if($key =='0')
            {   
                if($best_price !='0')
                {
                    if(is_numeric($email) =='1')
                    {
                        $kode_sales = $email;
                      
                    }else
                    {
                        $kode_sales='000';
                    }
                }else
                {
                     $kode_sales='000';
                }
                
            }else
            {
                $kode_sales='000';
            }

            $aa = round($produk['best_price']);
            $bb = $aa*$tariff_ppn_1;
            $cc = $bb+$shipping+$ttl_packing;


            if($quotation['insurance'] =='yes')
            {
                if($produk['tipe_produk'] =='barang')
                {
                    $harga_premi  = $premi/100*$aa;
                    $harga_retail = $harga_premi * $ppn /0.7;
                }else
                {
                    $harga_premi="0";
                    $harga_retail="0";
                }
            }else
            {
                $harga_premi="0";
                $harga_retail="0";
            }

            $cc = $cc+$harga_retail;

            $best = number_format($cc);
            $a = str_replace(',', '', $best);
            $hrgs = substr($a,-3);
            $hrg = substr($a, 0, -3);
            $hrg1 = $hrg."000";
            $hrg1 = $hrg1+1000;

            $delivery_cost_satuan = $shipping;

            if($discount_persen =='100')
            {
                $hrg1 = $hrg1-1000;
            }

            $d = $hrg1;

            if($discount_persen !='100')
            {
                $kode_sales=$kode_sales;
            }else
            {
                $kode_sales="0";
            }


            $best_price_roundup = $d+$kode_sales;


            if($produk['ppn'] =='included')
            {
                 $discount_fix = $total_price-$best_price_roundup;
            }else
            {
                $best_price_roundup = $best_price_roundup/$tariff_ppn_1;
                $total_prices = $total_price;
                $best_price_roundups = $best_price_roundup;
                $discount_fix = $total_prices-$best_price_roundups;
            }

            // masuk DB 
            if($produk['ppn'] =='excluded')
            {
                $unit_price_fix_modif  = $unit_price_fix*$tariff_ppn_1;
                $total_price_fix_modif = $total_price*$tariff_ppn_1;
                $best_price_roundup_fix_modif = $best_price_roundup*$tariff_ppn_1;
                $discount_fix_modif = $discount_fix*$tariff_ppn_1;
            }else
            {
                $unit_price_fix_modif = $unit_price_fix;
                $total_price_fix_modif = $total_price;
                $best_price_roundup_fix_modif = $best_price_roundup;
                $discount_fix_modif = $discount_fix;
            }

            // $unit_price_fix         = str_replace(",","",number_format($unit_price_fix));
            // $total_price            = str_replace(",","",number_format($total_price));
            // $discount_masuk_db          = str_replace(",","",number_format($discount_masuk_db));
            // $best_price_roundup     = str_replace(",","",number_format($best_price_roundup));
            // $total_delivery_cost    = $total_delivery_cost;

            $harga_premi            = round($harga_premi);
            $harga_retail           = round($harga_retail);
            $quantity_fix           = $produk['quantity'];

            if($quotation['insurance'] =='yes')
            {   
                if($produk['tipe_produk'] =='barang')
                {
                    $ttl_insurance = 'Rp.'.number_format($harga_retail,0,",",".")."(Tokio Marine)";
                    $ket_insurance =", Freight Insurance: Tokio Marine.";
                }else
                {
                    $ttl_insurance = 'No Insurance';
                    $ket_insurance ='';

                }
            }else
            {   
                $harga_retail='0';
                $harga_premi='0';
                $ttl_insurance = 'No Insurance';
            }



            $id_item  = $produk['id_item'];
            $this->db->set('rupiah_price_fix', $unit_price_fix_modif);
            $this->db->set('total_price_fix', $total_price_fix_modif);
            $this->db->set('discount_amount_fix', $discount_fix_modif);
            $this->db->set('best_price_fix', $best_price_roundup_fix_modif);
            $this->db->set('delivery_cost',$total_delivery_cost);
            $this->db->set('delivery_cost_item', $delivery_cost_satuan);
            $this->db->set('quantity_fix',$quantity_fix);
            $this->db->set('harga_premi_asli',$harga_premi);
            $this->db->set('harga_premi_fix', $harga_retail);
            $this->db->where('id', $id_item);
            $this->db->update('tbl_quotation_item'); 

            // batas rumus
            
            
            if (($produk['type_produk'] == 'Primary') OR ($quotation['send_primary_only']=='no'))
            {   


                if($produk['packing_type'] =='')
                {
                    $packaging = "Standard";
                }else
                {
                    $packaging = $produk['packing_type'];
                }

                $content .= '
                    <table width="100%" cellpadding="8" cellspacing="0" class="item-box">
                    <tbody>
                        <tr valign="top">
                            <td width="6%" style="border-right:solid 1px #222">'.$no.'.<br/>('.$type_produk.')</td>                 
                            <td width="59%">'.$produk['keterangan'].'</td>
                            <td width="35%">
                                <img src="'.$product_image.'" width="35%" />
                                <br /><br />
                                <table width="100%" cellpadding="0" cellspacing="0">
                                <tbody>
                                
                                <tr><td width="80">SKU</td><td width="8">:</td><td>'.$produk['sku'].'</td></tr>

                                <tr><td width="80">Stock Status</td><td width="8">:</td><td>'.
                                $keterangan_stock.'</td></tr>

                                <tr>
                                    <td>Unit Price</td><td width="8">:</td>
                                    <td>Rp. '.number_format($unit_price_fix).' x '.$produk['quantity'].' '.$produk['satuan'].'
                                    </td>
                                </tr>
                                <tr>
                                    <td>Total Price</td>
                                    <td>:</td>
                                    <td>Rp. '.number_format($total_price).'</td>
                                </tr>
                                <tr>
                                    <td>Discount</td>
                                    <td>:</td>
                                    <td>Rp. '.number_format($discount_fix).'</td>
                                </tr>
                                <tr>
                                    <td>Best Price</td>
                                    <td>:</td>
                                    <td>Rp. '.number_format($best_price_roundup).'</td>
                                </tr>
                                </tbody>
                                </table> 
                                <small>('.$ppn_info.', Packing : '.$packaging.''.$ket_insurance.')</small>          
                            </td>
                        </tr>
                    </tbody>
                    </table>';
                    $no++;

            }       
        }

        //tampilkan jasa jika ada

        $biaya_jasa = $quotation['biaya_jasa'];
        $keterangan_jasa = $$quotation['jasa'];

        $keterangan_jasa ="yes";
        $biaya_jasa="5000000";

        if ($keterangan_jasa == 'yes')
        {   

            if($biaya_jasa !='0')
            {
                $content .= '
                <table width="100%" cellpadding="8" cellspacing="0" class="item-box">
                <tbody>
                    <tr valign="top">
                        <td width="6%" style="border-right:solid 1px #222">'.$no.'</td>     
                        <td width="59%">
                        <b>Custom Service Support</b>
                        <br>
                        Quotation Type : Custom Job/ Service
                        </td>        
                        <td width="35%">Rp '.number_format($quotation['biaya_jasa'],0).'</td>           
                    </tr>
                </tbody>
                </table>';  
            }else
            {
                $content .= '
                <table width="100%" cellpadding="8" cellspacing="0" class="item-box">
                <tbody>
                    <tr valign="top">
                        <td width="6%" style="border-right:solid 1px #222">'.$no.'</td>     
                        <td width="59%"><b>Jasa Pekerjaan</b><br/>'.$quotation['keterangan_jasa'].'</td>        
                        <td width="35%">Harga sedang di-estimasikan</td>            
                    </tr>
                </tbody>
                </table>';  

            }
            
            $no++;              
        }       

        //tampilkan pengiriman bila biayanya ada 
        if ($quotation['shipping_cost'] > 0)
        {
            $content .= '
            <table width="100%" cellpadding="8" cellspacing="0" class="item-box">
            <tbody>
                <tr valign="top">
                    <td width="6%" style="border-right:solid 1px #222">'.$no.'</td>     
                    <td width="59%"><b>Biaya Pengiriman</b><br/><b>'.$shipment['company_name'].'</b><br/>'.$quotation['shipping_address'].'</td>
                    <td width="35%">Rp '.number_format($quotation['shipping_cost'],0).'</td>                    
                </tr>
            </tbody>
            </table>';                  
        }     
        
        
        $content .= '
        <br/>
        <div style="width:470px; float:left;">
            <strong>Operational &amp; Safety Policy</strong> :<br/>
            All of PT. Indotara Persada company&acute;s operation are based on ISO 9001:2015 and OHSAS 18001:2007. The quality of our products and operations are based on consistent quality management throughout 
            our organisation. Our operations are defined by our ISO 9001 compliant quality system, which has been operating effectively and annually audited by IAS. We have also certified by ROHS - Environmental, 
            Health and Safety - management system based on OHSAS 18001:2007 in all units of the company.
        </div>
        <div style="width:180px; float:right;">
            <img src="'.$file_url.'assets/images/quotation/setting/'.$setting['iso_picture'].'"  width="180px"/>
        </div>
        <div style="clear:both"></div>
        <br>
        
        <strong>Quotation Terms &amp; Conditions:</strong>
        '.$quotation_terms.'
        <br/>

        <strong>Business Ethics &amp; Engineering Responsibilities of Supplies:</strong>
        <ol>
          <li>PT. Indotara Persada are comply to clean, clear and legal company</li>
          <li>Our company respect on clean &amp; clear professional business transaction without any collusion for personal compensation/bribe. We guarantee &quot;no bribes&quot; or under table money for every business we are dealing with</li>
          <li>We are responsible of our engineering capabilities to supply our client properly and professionally</li>
          <li>No mark-up or commision added on quotation or negotiation. Please be notified.</li>
        </ol>
        <br/>
        
        <div style="width:550px; float:left;">
            <strong>Warranty Term of Conditions:</strong>
            '.$warranty_terms.'
        </div>
        <div style="width:160px; float:right;">
            <img src="'.$file_url.'assets/images/quotation/setting/'.$setting['warranty_picture'].'" width="160px"/>
        </div>
        <div style="clear:both"></div>

        <br>
        <table width="100%" border="0">
        <tbody>
        <tr align="center" valign="top">
        <td align="center" width="20%">Sincerely Yours,<br/>
        PT. Indotara Persada<br/>
        <img src="'.$file_url.'assets/images/employee_signature/'.$karyawan['signature'].'" width="180"/><br/>
        '.$karyawan['nama'].'<br/>
        '.$karyawan['position'].'<br/>
        '.$karyawan['phone_number'].'
        </td>';
        
        /*
        if ((!in_array($user_position,$array_kacab_position)) AND (in_array($sales_cabang,$array_cabang)))
        $content .= '
        <td align="center" width="26%"><br/>
        Checked & Approved By:<br/>
        <img src="'.$file_url.'assets/images/employee_signature/'.$signature_kacab.'" width="180"/><br/>
        '.$nama_kacab.'<br/>
        '.$jabatan_kacab.'<br/>
        '.$telepon_kacab.'
        </td>';
        */

        if ((!in_array($user_position,$array_kacab_position)) AND (in_array($sales_cabang,$array_cabang)) AND (!empty($signature_kacab)) AND (!empty($telepon_kacab)))
        $content .= '
        <td align="center" width="20%"><br/>
        Checked & Approved By:<br/>
        <img src="'.$file_url.'assets/images/employee_signature/'.$signature_kacab.'" width="180"/><br/>
        '.$nama_kacab.'<br/>
        Branch Manager<br/>
        '.$telepon_kacab.'
        </td>';
        

        if ((!in_array($user_position,$array_manager_position)) AND (!empty($signature_manager)) AND (!empty($nama_manager)))
        $content .= '
        <td align="center" width="20%"><br/>
        Checked & Approved By:<br/>
        <img src="'.$file_url.'assets/images/quotation/setting/'.$signature_manager.'" width="180"/><br/>
        '.$nama_manager.'<br/>
        '.$jabatan_manager.'<br/>
        '.$telepon_manager.'
        </td>';
        

        if(!empty($setting['legal_pic_name']))
        $content .= '
        <td align="center" width="20%"><br/>
        '.$setting['legal_department_name'].'<br/>
        <img src="'.$file_url.'assets/images/quotation/setting/'.$setting['legal_pic_signature'].'" width="180"/><br/>
        '.$setting['legal_pic_name'].'<br/>
        '.$setting['legal_pic_position'].'<br/>&nbsp;&nbsp;&nbsp;
        </td>';
        
        $content .= '
        <td align="right">';
        
        if ($folder == '')
        $code = 'https://cdn.myiios.net/assets/images/quotation/proposal/'.$filename_hash;
        else
        $code = 'https://doc.myiios.net/'.$folder.'/quotation/'.$filename_hash;
        

    

        $outfile = "assets/images/".$quotation_id.".png";
        $quality = "H";
        $size = 25;
        $frame = 1;
        
        QRcode::png($code,$outfile,$quality,$size,$frame); 
        
        //SET base64 image
        $imagedata = file_get_contents($outfile);
        // alternatively specify an URL, if PHP settings allow
        $base64 = 'data:image/png;base64,' .base64_encode($imagedata);
        
        //remove image
        unlink($outfile);
        
        $content .= '<div style="font-size:10px; display:inline-block; margin-right:15px; width:125px; text-align:center;"><img src="'.$base64.'" width="125" style="border:solid 2px #000;" /><br/>
        Scan for document validity&nbsp;&nbsp;</div>';      
        
        $content .= '</td></tr>
        </tbody>
        </table>
        ';
        
        if (!empty($quotation_reference))
        $content .= '<br/><img src="'.$file_url.'assets/images/quotation/setting/'.$quotation_reference.'" width="100%"/>';     

        if (!empty($quotation_reference1))
        $content .= '<br/><img src="'.$file_url.'assets/images/quotation/setting/'.$quotation_reference1.'" width="100%"/>';        

        if (!empty($quotation_reference2))
        $content .= '<br/><img src="'.$file_url.'assets/images/quotation/setting/'.$quotation_reference2.'" width="100%"/>';        

        if (!empty($quotation_reference3))
        $content .= '<br/><img src="'.$file_url.'assets/images/quotation/setting/'.$quotation_reference3.'" width="100%"/>';        

        if (!empty($quotation_reference4))
        $content .= '<br/><img src="'.$file_url.'assets/images/quotation/setting/'.$quotation_reference4.'" width="100%"/>';        

        if (!empty($quotation_reference5))
        $content .= '<br/><img src="'.$file_url.'assets/images/quotation/setting/'.$quotation_reference5.'" width="100%"/>';    

        if (!empty($quotation_reference6))
        $content .= '<br/><img src="'.$file_url.'assets/images/quotation/setting/'.$quotation_reference6.'" width="100%"/>';    

        if (!empty($quotation_reference7))
        $content .= '<br/><img src="'.$file_url.'assets/images/quotation/setting/'.$quotation_reference7.'" width="100%"/>';    

        if (!empty($quotation_reference8))
        $content .= '<br/><img src="'.$file_url.'assets/images/quotation/setting/'.$quotation_reference8.'" width="100%"/>';    

        if (!empty($quotation_reference9))
        $content .= '<br/><img src="'.$file_url.'assets/images/quotation/setting/'.$quotation_reference9.'" width="100%"/>';

        // print_r($content);die;
        
         $mpdf = new \Mpdf\Mpdf();   //enable on php 7.2
        //$mpdf=new mPDF('c','A4','','' , 10 , 10 , 10 , 20 , 0 , 0);   //disable on php 7.2
                            
        $mpdf->SetDisplayMode('fullpage');
        
        $mpdf->SetFont('Arial');
        
        $mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list
        
        $mpdf->shrink_tables_to_fit=0;

        $mpdf->AddPageByArray([
            'margin-left' => 0,
            'margin-right' => 0,
            'margin-top' => 0,
            'margin-bottom' => 0,
        ]);
        
        $mpdf->WriteHTML($cover);

        $mpdf->AddPageByArray([
            'margin-left' => 15,
            'margin-right' => 15,
            'margin-top' => 14,
            'margin-bottom' => 14,
        ]);

        $mpdf->setFooter('<div style="padding:20px;">|Page {PAGENO} of {nbpg}|</div>');
        
        $mpdf->WriteHTML($content);

        if($load_type =='review')
        {   

            $mpdf->Output("$filename", 'D');
        }
        elseif ($load_type =='resend')
        {
            $mpdf->Output("assets/images/quotation/proposal/$filename", 'F');
            $this->sendQuotation($quotation_id,'resend');
        }
        elseif ($load_type =='marketplace')
        {
            
            $mpdf->Output("assets/images/quotation/proposal/$filename", 'F');
        }elseif($load_type == 'exception')
        {
            $mpdf->Output("assets/images/quotation/proposal/$filename", 'F');
        }
        else    
        {
                
            $aaa = $mpdf->Output("assets/images/quotation/proposal/$filename", 'F');
            $this->sendQuotation($quotation_id,'normal');
        }
    }

    public function sendQuotation($id,$sendtype)
    {
        require 'vendor/autoload.php';
        
        $file_url = $this->config->item('file_url');
        $setting = $this->getSetting();
        
        if($sendtype == 'resend')
        {

            $resend_quotation       = $this->getQuotation($id);
            $karyawan_id            = $resend_quotation['sales_id'];
            $karyawan               = $this->getKaryawan($karyawan_id);
            $user_position          = $karyawan['position_id'];

        }
        else
        {   
            
            $user = $this->session->userdata('myuser');
            $user_position      = $user['position_id'];
            $karyawan_id        = $user['karyawan_id'];
            $karyawan           = $this->getKaryawan($karyawan_id);
        }


        
        $cc_email = explode(",",$setting['cc_emails']);
        

        $quotation = $this->getQuotation($id);
        
        $list_item  = $this->getListItem($id);
        

        $attachment = $quotation['filename'];
        
        $crm_id = $quotation['crm_id'];
        
        $crm = $this->crm->getDetail($crm_id);


        $inquiry = $this->crm->cek_inquiry($crm_id);


        
        $divisi = $quotation['divisi'];
        
        $manager_data       = $this->divisi->getDivisiManager($divisi);
        $nama_manager       = $manager_data['nama_manager'];
        $email_manager      = $manager_data['email'];
        
        $customer_name = $crm['pic'];
        $customer_company = $crm['perusahaan'];
        $customer_email = explode(",",$quotation['customer_email']);
        $q_cc_email = explode(",",$quotation['cc_email']);


        $karyawan = $this->getKaryawan($karyawan_id);
        $karyawan_name = $karyawan['nama'];
        $karyawan_email = $karyawan['email'];
        $karyawan_cabang = $karyawan['cabang'];
        
        $folder = $quotation['folder'];
        
        /*
        
        $sales_cabang       = $crm['sales_cabang'];
        
        $kacab_data         = $this->getKacab($sales_cabang);

        $nama_kacab         = $kacab_data['nama'];
        $jabatan_kacab      = $kacab_data['jabatan'];
        $telepon_kacab      = $kacab_data['phone_number'];
        $email_kacab        = $kacab_data['email'];
        $signature_kacab    = $kacab_data['signature'];
        
        */
        
        
        //CHECK VIDEO & KATALOG LINK
        $count_link = 0;
        
        foreach ($list_item as $produk)
        {
            $produk_id = $produk['product_id'];
        
            $sql = "SELECT * FROM tbl_video_youtube WHERE product_id = '$produk_id'";
            $query = $this->db->query($sql);
            $num = $query->num_rows();
            $video = $query->result_array();
            
            if ($num > 0)
            {
                $count_link = $count_link + $num;
                
                $no = 1;
                foreach ($video as $youtube)
                {
                    $video_title = "Video ".$no;
                
                    $array_link[$produk_id][$video_title] = $youtube['youtube_link'];
                    
                    $no++;
                }
            }   
            
            $sql = "SELECT * FROM tbl_katalog_produk WHERE product_id = '$produk_id'";
            $query = $this->db->query($sql);
            $num = $query->num_rows();
            $produk_katalog = $query->result_array();
            
            if ($num > 0)
            {
                $count_link = $count_link + $num;
                
                $no = 1;
                foreach ($produk_katalog as $katalog)
                {
                    $katalog_title = "Katalog ".$no;
                
                    $array_link[$produk_id][$katalog_title] = $katalog['katalog_link'];
                    
                    $no++;
                }
            }   
            
        }

                
        $email_subject = $quotation['email_subject'];
        $plain_email_content = strip_tags(str_replace('||videolink||','',$quotation['email_content']));

        
        $raw_email_content = $quotation['email_content'];


        
        if (((strpos($raw_email_content, '||videolink||') !== false) AND ($quotation['quotation_type']=='product') AND ($count_link > 0)) OR ((!empty($setting['link_company_profile'])) OR (!empty($setting['link_company_movie']))))
        {

            
            $explode_email_content = explode('||videolink||',$raw_email_content);
            
            $cell = 1;
            
            $video_link = '
            <h3>Informasi produk, silakan klik untuk review:</h3>
            <br/>
            <table cellpadding="8" cellspacing="5">
            <tbody>
            <tr valign="top">';
            
            foreach ($list_item as $produk)
            {
                $produk_id = $produk['product_id'];
            
                if (isset($array_link[$produk_id]))
                {
                    $gambar_produk = $produk['gambar'];

                    $img_url = $file_url.'assets/images/quotation/product/'.$gambar_produk;
                    $img_base64 = base64_encode(file_get_contents($img_url));

                    $this->qupload->picture_to_web($img_base64,$gambar_produk);

                    $video_link .= '<td width="200">
                    <img src="https://www.indotara.co.id/emailimg/'.$gambar_produk.'" width="200"><b>'.$produk['nama_produk'].'</b>
                    <br/>Rp '.number_format(round(($produk['best_price']/$produk['quantity']),0),0).'<br/>';
                    
                    foreach ($array_link[$produk_id] as $judul_link => $url_link)
                    $video_link .= '<a href="'.$url_link.'" target="_blank">'.$judul_link.'</a><br/>';
                    
                    $video_link .= '</td>';
                    
                    
                    if ($cell % 4 == 0)
                    {
                        $video_link .= '</tr><tr valign="top">';
                    }
                    
                    $cell++;                    
                }
                            
            }
            
            $video_link .= 
            "</tr>
            </tbody>
            </table>";
            
            if ((!empty($setting['link_company_profile'])) OR (!empty($setting['link_company_movie'])))
            {
                $company_profile_link = '
                <br/><br/>
                <b>Our Company Profile:</b>
                <br/>';
                
                if (!empty($setting['link_company_profile']))
                $company_profile_link .= '<a href="'.$setting['link_company_profile'].'">Download Our Company Profile</a><br/>';

                if (!empty($setting['link_company_movie']))
                $company_profile_link .= '<a href="'.$setting['link_company_movie'].'">Watch Our Company Profile</a><br/>';
            }


            
            if(count($explode_email_content) =='2')
            {
                $expld = $explode_email_content[1];
            }else
            {
                $expld = $explode_email_content[0];
            }

            if ($count_link > 0)

            $email_content = $explode_email_content[0].''.$video_link.''.''.$company_profile_link.''.$expld;
            else
            $email_content = $raw_email_content;
        }
        else
        {
            $email_content = $plain_email_content;
        }
        
        $email_content = $email_content;

        $array_added_email = array();
        
        
        $email = new \SendGrid\Mail\Mail(); 
        $email->setFrom($karyawan_email, "PT Indotara Persada");
        $email->setSubject($email_subject);


        foreach ($customer_email as $index => $email_address)   
        {   
            $sanitize_email = trim($email_address);
        
            if ((filter_var($sanitize_email, FILTER_VALIDATE_EMAIL)) AND (!in_array($sanitize_email,$array_added_email)))
            {
                $email->addTo($sanitize_email, $customer_name);
                $array_added_email[] = $sanitize_email;
            }
        }
        
        foreach ($cc_email as $index => $email_address)     
        {
            $sanitize_email = trim($email_address);
        
            if ((filter_var($sanitize_email, FILTER_VALIDATE_EMAIL)) AND (!in_array($sanitize_email,$array_added_email)))
            {
                $email->addTo($sanitize_email, "Team Indotara Persada");
                $array_added_email[] = $sanitize_email;
            }
        }
        
        foreach ($q_cc_email as $index => $email_address)       
        {
            $sanitize_email = trim($email_address);
        
            if ((filter_var($sanitize_email, FILTER_VALIDATE_EMAIL)) AND (!in_array($sanitize_email,$array_added_email)))
            {
                $email->addTo($sanitize_email, "Team Indotara Persada");
                $array_added_email[] = $sanitize_email;
            }
        }
        
        
        //to manager email
        if ((filter_var($email_manager, FILTER_VALIDATE_EMAIL)) AND (!in_array($email_manager,$array_added_email)))
        {
            $email->addTo($email_manager, "Team Indotara Persada");
            $array_added_email[] = $email_manager;
        }

        //to karyawan
        if ((filter_var($karyawan_email, FILTER_VALIDATE_EMAIL)) AND (!in_array($karyawan_email,$array_added_email)))
        {
            $email->addTo($karyawan_email, "Team Indotara Persada");
            $array_added_email[] = $karyawan_email;
        }

        //to kacab
        if ((filter_var($email_kacab, FILTER_VALIDATE_EMAIL)) AND (!in_array($email_kacab,$array_added_email)))
        {
            $email->addTo($email_kacab, "Team Indotara Persada");
            $array_added_email[] = $email_kacab;
        }

        //to Sales
        if ((filter_var('sales@indotara.co.id', FILTER_VALIDATE_EMAIL)) AND (!in_array('sales@indotara.co.id',$array_added_email)))
        {
            $email->addTo('sales@indotara.co.id', "Team Indotara Persada");
            $array_added_email[] = 'sales@indotara.co.id';
        }
        
        $email->setReplyTo($karyawan_email, $karyawan_name);
        $email->addContent("text/plain", $plain_email_content);
        $email->addContent("text/html", $email_content);

        
        if (($quotation['quotation_type']=='project') AND (($quotation['divisi']=='DHC') OR ($quotation['divisi']=='DEE')))
        {
            if($_FILES)
            {  
                $uploaddir = 'assets/images/quotation/proposal/';
    
                foreach ($_FILES['quotationfiles']['name'] as $key => $value) 
                {
                    if($value) 
                    {
                        $file_name = $id.'-'.$key.'-'.time().'-'.str_replace(" ","-",$value);
    
                        $filepath = $uploaddir.''.$file_name;
    
                        move_uploaded_file($_FILES['quotationfiles']['tmp_name'][$key], $filepath);
                        
                        $file_path = 'assets/images/quotation/proposal/'.$file_name;
                        $finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
                        $mime_type =  finfo_file($finfo, $file_path);
                        
                        $file_encoded = base64_encode(file_get_contents($file_path));
                        
                        $email->addAttachment(
                            $file_encoded,
                            $mime_type,
                            $file_name,
                            "attachment"
                        );
                        
                        $array_quotation_file[] = $file_path;
                    }
                }
            }   
        }
        else
        {
            //JIKA BUKAN PROJECT DHC, ATTACH PENAWARAN
            //========================================      


            $file_path = 'assets/images/quotation/proposal/'.$attachment;
            $finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
            $mime_type =  finfo_file($finfo, $file_path);

            $file_encoded = base64_encode(file_get_contents($file_path));
            
            $email->addAttachment(
                $file_encoded,
                $mime_type,
                $attachment,
                "attachment"
            );
        }   
        
        if($_FILES)
        {  
            $uploaddir = 'assets/images/quotation/proposal/';

            foreach ($_FILES['userfiles']['name'] as $key => $value) 
            {
                if($value) 
                {
                    $file_name = $id.'-'.$key.'-'.time().'-'.str_replace(" ","-",$value);

                    $filepath = $uploaddir.''.$file_name;

                    move_uploaded_file($_FILES['userfiles']['tmp_name'][$key], $filepath);
                    
                    $file_path = 'assets/images/quotation/proposal/'.$file_name;
                    $finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
                    $mime_type =  finfo_file($finfo, $file_path);
                    
                    $file_encoded = base64_encode(file_get_contents($file_path));
                    
                    $email->addAttachment(
                        $file_encoded,
                        $mime_type,
                        $file_name,
                        "attachment"
                    );
                    
                    $array_file[] = $file_name;
                }
            }
        }   
            
        // $dotenv = new Dotenv\Dotenv('/home/');
        // $dotenv->load();
        // $sendgrid_apikey = getenv('SENDGRID_API_KEY');
        
        // $sendgrid = new \SendGrid($sendgrid_apikey);
        
        // $response = $sendgrid->send($email);

        $response="aaa";
        

        
        /*
        try {
            $response = $sendgrid->send($email);
            print $response->statusCode() . "\n";
            print_r($response->headers());
            print $response->body() . "\n";
        } catch (Exception $e) {
            //echo 'Caught exception: '. $e->getMessage() ."\n";
        }
        */
        $response="aaaa";
        if ($response)
        {
            //===============================LETAKKAN CRM LOG DI SINI ========================================//

            if ($sendtype != 'resend')
            {
                $file_url   = $this->config->item('file_url');
                $note       = $quotation['quotation_note'];
                $value      = $quotation['total_quotation_price'];
                $pesan      = 'Mengirimkan Penawaran <a href="'.$file_url.'assets/images/quotation/proposal/'.$quotation['quotation_no'].'.pdf" target="_blank" >'.$quotation['quotation_no'].'</a> ke customer ';
                $log_pesan  = $this->crm->add_pesan_log($crm_id, $pesan, $id,$note,$value);

                $pesan1         = '<span class="biru-muda">Upload bukti pengiriman file PDF Quotation via  via whatsapp(crop gambar)<br>
                            kelalaian upload akan berakibat penalty point. Segera upload bukti pengiriman bila penawaran
                            sudah terkirim</span>';
                $log_pesan  = $this->crm->log_bukti_quotation($crm_id, $pesan1, $id);

                $pesan_whatsapp     = '<span class="biru-muda">Kirim text ini via whatsapp(crop gambar).</span><br> <span style="color:red;">Dengan ini menginformasikan bahwa penawaran yang baru dikirimkan telah disertkan freight insurance (asuransi pengiriman barang) dari maskapai asuransi PT.Asuransi Tokio Marine Indonesia untuk menjamin keselamatan barang tiba sampai di tujuan dengan perlindungan terbaik. sebagai informasi proteksi asuransiadalah optional.</span>';


                $log_pesan_wa   = $this->crm->log_bukti_text_wa($crm_id, $pesan_whatsapp, $id);

            

            }
                        
            /*
            
            Untuk mendapatkan daftar email yg dikirim utk ditulis di log = implode(","$customer_email); 
            Nomor penawaran utk ditulis di log = $quotation['quotation_no'];
            Nama sales yg mengirim penawaran = $karyawan_name
            CRM ID = $crm_id
            
            */
            //===============================END OF LETAKKAN CRM LOG DI SINI ========================================//     
                
                
                
            if (isset($array_file))
            {
                foreach ($array_file as $index => $filename)
                {
                    $filepath = 'assets/images/quotation/proposal/'.$filename;
                    
                    if ((file_exists($filepath)) AND (!empty($filename)))
                    unlink($filepath); 
                }
            }
            
            if (isset($array_quotation_file))
            {
                //$implode = implode("|",$array_quotation_file);
                
                $attachment = str_replace(".pdf",".zip",$attachment);
                $attachment_path = 'assets/images/quotation/proposal/'.$attachment;

                $zip = new ZipArchive;
                if ($zip->open($attachment_path, ZipArchive::CREATE) === TRUE)
                {
                    // Add files to the zip file
                    
                    foreach ($array_quotation_file as $index => $quotation_filepath)
                    {
                        $zip->addFile($quotation_filepath);
                    }
                                     
                    // All files are added, so close the zip file.
                    $zip->close();
                }

                $this->db->set('filename', $attachment);
                $this->db->where('id', $id);
                $this->db->update('tbl_quotation'); 
                
                //hapus file
                foreach ($array_quotation_file as $index => $quotation_filepath)
                {
                    if (file_exists($quotation_filepath))
                    unlink($quotation_filepath); 
                }
            }
            
            //RENAME FILE QUOTATION SBLM DIKIRIM KE COLO
            $hash = sha1(md5($attachment).'-'.$id);
            $filename_hash = $hash.''.$attachment;
            rename('assets/images/quotation/proposal/'.$attachment,'assets/images/quotation/proposal/'.$filename_hash);
            
            $this->db->set('filename', $filename_hash);
            $this->db->where('id', $id);
            $this->db->update('tbl_quotation');     
            
                
            if ($folder == '')  
            $this->qupload->ftp_upload('assets/images/quotation/proposal/'.$filename_hash);
            else
            $this->qupload->doc_server_ftp_upload('assets/images/quotation/proposal/'.$filename_hash,$folder.'/quotation/'.$filename_hash);
            
            redirect('crm/details/'.$crm_id);
        
        }
        else
        {
            echo "No response from sendgrid";
            
            try {
                $response = $sendgrid->send($email);
                print $response->statusCode() . "\n";
                print_r($response->headers());
                print $response->body() . "\n";
            } catch (Exception $e) {
                echo 'Caught exception: '. $e->getMessage() ."\n";
            }
        }
        
        //echo $email_content;
        
    }
    
    
    public function getFailSendQuotation()
    {
        $now_date = date("Y-m-d H:i:s");
        $past_date = date('Y-m-d H:i:s', strtotime('-2 hours', strtotime($now_date)));

    
        $sql = "SELECT id, filename FROM tbl_quotation WHERE quotation_type = 'product' AND status = 'sent' AND customer_email != '' AND send_date BETWEEN '$past_date' AND '$now_date'";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        $quote = $query->result_array();
        
        return $quote;
    }

    public function get_ongkos_kirim()
    {   
                
        if($this->input->post())
        {
            $asal = $this->input->post('origin');
            $tujuan = $this->input->post('destination');
            $tujuan_sicepat = $this->input->post('destination_sicepat');
            $origin_sicepat = $this->input->post('origin_sicepat');
            $destination_tam = $this->input->post('destination_tam');

            $alamat_lengkap = $tis->input->post('alamat_lengkap');
            $longitude = $this->input->post('longitude');
            $latitude = $this->input->post('latitude');


            $kurir ="jne:pos:tiki:rpx:pandu:wahana:sicepat:jnt:pahala:sap:jet:indah:first:ncs:star:ninja";
            $quotation_id = $this->input->post('quotation_id');

            $sql ="SELECT itm.product_id,itm.berat ,itm.panjang,itm.lebar,itm.tinggi,itm.quantity
                    FROM tbl_quotation_item itm
                    LEFT JOIN tbl_quotation_product prd ON prd.id = itm.product_id 
                    WHERE itm.quotation_id='$quotation_id' AND itm.type_produk='Primary'";
            $result = $this->db->query($sql)->result_array();

            $total_berat= array();
            $total_volume = array();

            foreach ($result as $key => $res) 
            {   
            
                $vol   = ($res['panjang']*$res['lebar']*$res['tinggi']/6000);

            
                $vol   = $vol*$res['quantity'];

                $berat = $res['berat']* $res['quantity'];


                array_push($total_berat,$berat);
                array_push($total_volume,$vol);

            }

        

            $ttl_berat = array_sum($total_berat);
            $ttl_volume = array_sum($total_volume);

            if($ttl_berat > $ttl_volume)
            {
                $berat_sicepat = $ttl_berat;
            
            }elseif($ttl_berat < $ttl_volume)
            {
                $berat_sicepat = $ttl_volume;
                
            }elseif($ttl_berat == $ttl_volume)
            {
                $berat_sicepat = $ttl_berat;
            }

            $berat_sicepat = round($berat_sicepat);


            $sql ="SELECT itm.*
                    FROM tbl_quotation_item itm
                    LEFT JOIN tbl_quotation_product prd ON prd.id = itm.product_id 
                    WHERE itm.quotation_id='$quotation_id' AND itm.type_produk='Primary' GROUP BY itm.product_id ";
            $restss = $this->db->query($sql)->result_array();

            $total_tam =[];
            foreach ($restss as $key => $value) 
            {
                $panjang = $value['panjang'];
                $lebar  = $value['lebar'];
                $tinggi = $value['tinggi'];
                $berat1 = $value['berat'];
                $quantity_per_length = $value['quantity'];
                $total2 = $panjang*$lebar*$tinggi;
                $total1 = $total2/4000;
                $total_volume = $total1*$quantity_per_length;
        

                if($total_volume > $berat1)
                {
                    $total = $total_volume;
                }elseif($total_volume < $berat1)
                {
                    $total = $berat1;
                }elseif($total_volume == $berat1)
                {
                    $total = $berat1;
                }

                array_push($total_tam, $total);
            }

            $volume_tam = array_sum($total_tam);

            
            // sicepat
            $url_sicepat="http://api.sicepat.com/customer/tariff?api-key=0c38426c0291145b769dd3f0ea165e65&origin=".$origin_sicepat."&destination=".$tujuan_sicepat."&weight=".$berat_sicepat;

            $curl1 = curl_init();
            curl_setopt_array($curl1, array(
              CURLOPT_URL => $url_sicepat,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET",
            ));

            $response1 = curl_exec($curl1);
            curl_close($curl1);


            $responses1  = json_decode($response1,TRUE);
            $sicepat    = $responses1['sicepat'];
            $sicepat    = $sicepat['results'];
            
            $sicepat1= [];
            foreach ($sicepat as $key => $scpt) 
            {
                $sql ="SELECT * FROM tbl_service_pickup WHERE jasa_kirim='SiCepat'";
                $res = $this->db->query($sql)->row_array();
                $pickup_service = $res['pickup_service'];
                if($pickup_service)
                {
                    $pickup_service = ucfirst($pickup_service);
                }else
                {
                    $pickup_service = '-';
                }

                $arr = array(
                    'service' => $scpt['service'],
                    'description' => $scpt['description'],
                    'tariff' => $scpt['tariff'],
                    'minPrice' => $scpt['minPrice'], 
                    'unitPrice' => $scpt['unitPrice'],
                    'etd' => $scpt['etd'],
                    'pickup_service' =>$pickup_service
                );

                array_push($sicepat1,$arr);
            }

            $results1 =[];
       
            $sql ="SELECT * FROM tbl_tariff_tam WHERE kode ='$destination_tam'";
            $res= $this->db->query($sql)->row_array();

            $tujuan = $res['tujuan'];
            $kode = $res['kode'];
            $harga = $res['harga']; 
            $estimasi = $res['estimasi'];

            if($volume_tam >= '30')
            {
                $volume_tam = $volume_tam;
            }elseif($volume_tam < '30')
            {
                $volume_tam ='30';
            }

            $total_harga_pengiriman = $harga* $volume_tam;
            $pickup_service = 'Yes';

            $tam = array(
                'tujuan' =>$tujuan,
                'kode' => $kode,
                'harga' => $harga,
                'estimasi' =>$estimasi,
                'total_harga_pengiriman' =>$total_harga_pengiriman,
                'pickup_service' => 'Yes',
            );


            $deliveree = $this->getDelivereeQuote($alamat_lengkap,$latitude,$longitude,$quotation_id);

            $results = array(
                'sicepat' =>$sicepat1,
                'results' =>$results1,
                'tam'     => $tam,
            );
            return $results;
        }

    }


    public function getDeliveryQuote()
    {

        $vehicle_type = $this->getVehicle();
    }


    public function getVehicle()
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.sandbox.deliveree.com/public_api/v1/vehicle_types',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'Authorization: y4SYxEvxNfLT-Y46t6zH'
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        
        $response = json_encode($response);

        print_R($response);die;



    }

    public function update_courier()
    {
        $courier = $this->input->post('courier');
        $harga  = $this->input->post('harga');
        $quotation_id = $this->input->post('quotation_id');

    
        $sql ="SELECT itm.id,itm.product_id, itm.berat ,itm.panjang,itm.lebar,itm.tinggi,itm.quantity
                    FROM tbl_quotation_item itm
                    LEFT JOIN tbl_quotation_product prd ON prd.id = itm.product_id 
                    WHERE itm.quotation_id='$quotation_id' AND itm.type_produk='Primary'";
        $result = $this->db->query($sql)->result_array();

        $total_berat= array();
        $total_volume = array();

        foreach ($result as $key => $res) 
        {   
            
            $vol   = ($res['panjang']*$res['lebar']*$res['tinggi']/6000);
            $volume   = $vol*$res['quantity'];

            $berat = $res['berat']* $res['quantity'];

            array_push($total_berat,$berat);
            array_push($total_volume,$volume);
        }

        $ttl_berat = array_sum($total_berat);
        $ttl_volume = array_sum($total_volume);

        if($ttl_berat > $ttl_volume)
        {
            $total_brt = $ttl_berat;
            $pakai = 'berat';
        }elseif($ttl_berat < $ttl_volume)
        {
            $total_brt = $ttl_volume;
            $pakai = 'volume';
        }elseif($ttl_berat == $ttl_volume)
        {
            $total_brt = $ttl_berat;
            $pakai = 'berat';
        }

        $berat = round($total_brt);



        $sql ="SELECT * FROM tbl_tariff_ppn";
        $ress = $this->db->query($sql)->row_array();

        $ppn = $ress['ppn'];
        $ppn = $ppn/100+1;

        $rumus_baru =$harga/0.8*$ppn;

    
        
        if(strpos($courier, 'sicepat') !== false) 
        {

            if($berat <='50')
            {
                $delv_cost = $rumus_baru;
            }
            elseif($berat >'50' AND $berat <='70')
            {   
            
                $delv_cost = $rumus_baru*1.25;
            }
            elseif($berat >'70' AND $berat <='100')
            {
           
                $delv_cost = $rumus_baru*1.5;
            }
            elseif($berat > '100')
            {   
                $delv_cost = $rumus_baru*2;
            }

        }else
        {
            $delv_cost = $rumus_baru;
        }


        $harga_per_kilo = $delv_cost/$berat;

        
        foreach ($result as $key => $res) 
        {   
            $id_item    = $res['id'];
            $vol_item   = ($res['panjang']*$res['lebar']*$res['tinggi']/6000);
            $vol_item   = $vol_item*$res['quantity'];

            $berat_item = $res['berat']* $res['quantity'];


            if($pakai =='berat')
            {
                $berat_hitung = $berat_item;
            }else
            {
                $berat_hitung = $vol_item;
            }

            $harga_per_item = $delv_cost/$total_brt*$berat_hitung;

            

            $this->db->set('delivery_cost_item',$harga_per_item);
            $this->db->where('id', $id_item);
            $this->db->update('tbl_quotation_item'); 
        }

        
        $this->db->set('delivery_cost',$harga_per_kilo);
        $this->db->set('delivery_type', $courier);
        $this->db->where('id', $quotation_id);
        $this->db->update('tbl_quotation'); 

        $this->db->set('status_logistic','');
        $this->db->where('quotation_id', $quotation_id);
        $this->db->update('tbl_quotation_item'); 
    }

    public function update_packing()
    {
        $packing_type = $this->input->post('packing_type');
        $id = $this->input->post('id');

        $sql ="SELECT * FROM tbl_packing_type WHERE packing_type ='$packing_type'";
        $res = $this->db->query($sql)->row_array();

        if($res)
        {
            $harga = $res['harga'];
        }else
        {
            $harga ='0';
        }
        

        $sql ="SELECT itm.id,itm.product_id,itm.quotation_id,qp.id as id_product,
                itm.panjang,itm.lebar,qp.tinggi,itm.quantity
                FROM tbl_quotation_item itm 
                LEFT JOIN tbl_quotation_product qp ON qp.id = itm.product_id
                WHERE itm.id='$id'";
        $rest = $this->db->query($sql)->row_array();


        $panjang = $rest['panjang'];
        $lebar = $rest['lebar'];
        $tinggi = $rest['tinggi'];
        $volume_1 = $panjang * $lebar *$tinggi;
        $volume_2 = $volume_1/100;
        $volume_asli = $volume_1/1000000;
        $total_volume = $volume_asli* $rest['quantity'];

        if($total_volume < '0.4')
        {
            $volume ='0.4';
        }else
        {
            $volume = $total_volume;
        } 

        $total_harga = round($volume*$harga);
        $total_harga = $total_harga; //12nov2021

        $this->db->where('id', $id);
        $this->db->update('tbl_quotation_item', array('packing_type' => $packing_type, 'packing_cost' => $total_harga));

    }

    public function get_primary_weight($quotation_id)
    {
        $sql ="SELECT itm.berat,itm.quantity FROM tbl_quotation_item itm
                    LEFT JOIN tbl_quotation_product prd ON prd.id = itm.product_id 
                    WHERE itm.quotation_id='$quotation_id' AND itm.type_produk='Primary'";
        $res = $this->db->query($sql)->result_array();
            
        $total_berat = array();

        foreach ($res as $key => $value) 
        {
            $brt = $value['berat'] * $value['quantity'];
            array_push($total_berat,$brt);
        }

    
        $berat = array_sum($total_berat);

        return $berat;
    }

    public function get_primary_volume($quotation_id)
    {
         $sql ="SELECT itm.berat,itm.quantity,itm.tinggi,itm.lebar,itm.panjang
                    FROM tbl_quotation_item itm
                    LEFT JOIN tbl_quotation_product prd ON prd.id = itm.product_id 
                    WHERE itm.quotation_id='$quotation_id' AND itm.type_produk='Primary'";
        $res = $this->db->query($sql)->result_array();


        $total_volume = array();

        foreach ($res as $key => $value) 
        {
            $vol   = ($value['panjang']*$value['lebar']*$value['tinggi']/6000);
            $vol   = $vol*$value['quantity'];

            array_push($total_volume,$vol);
        }

        $volume = array_sum($total_volume);

        return $volume;
    }

    public function get_city()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://pro.rajaongkir.com/api/city?key=cb936188d3f12a376ee430ca5c7f3659",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "key: cb936188d3f12a376ee430ca5c7f3659"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        $responses = json_decode($response,TRUE);
        $rajaongkir = $responses['rajaongkir'];
        $results = $rajaongkir['results'];

        return $results;
    }

    public function get_pickup_service($delivery_type)
    {
        $type = explode(' ', $delivery_type);
        $type = $type['0'];

        $sql ="SELECT pickup_service FROM tbl_service_pickup WHERE jasa_kirim LIKE '%$type%'";
        $res = $this->db->query($sql)->row_array();

        return $res;
    }

    public function AddOngkirCustomLogistik()
    {   

        $courier            = $this->input->post('courier_name');
        $total_ongkir       = $this->input->post('ongkir');
        $final_ongkir       = $total_ongkir;
        $item_id            = $this->input->post('item_id');
        $quotation_id       = $this->input->post('quotation_id');

        $sql                = "SELECT * FROM tbl_quotation WHERE id='$quotation_id'";
        $rs                 = $this->db->query($sql)->row_array();
        $crm_id             = $rs['crm_id'];

        $sql ="SELECT itm.berat as berat,itm.panjang as panjang,itm.lebar as lebar,itm.tinggi as tinggi 
                    FROM tbl_quotation_item itm
                    LEFT JOIN tbl_quotation_product prd ON prd.id = itm.product_id 
                    WHERE itm.quotation_id='$quotation_id' AND itm.id='$item_id'";
        $res = $this->db->query($sql)->row_array();
        $berat = $res['berat'];

        $sql = "SELECT * FROM tbl_tariff_ppn";
        $data = $this->db->query($sql)->row_array();
        $tariff = $data['ppn'];

        $tariff_ppn = $tariff/100+1;


        if($berat >'0')
        {
            $harga_per_kilo = $final_ongkir/$berat;

            $harga_custom = $final_ongkir*'1.25'*$tariff_ppn;

            $this->db->set('status_logistic','custom');
            $this->db->set('delivery_cost_item', $harga_custom);
            $this->db->set('delivery_cost', $harga_custom);
            $this->db->set('courier_name', $courier);
            $this->db->where('id', $item_id);
            $this->db->update('tbl_quotation_item'); 
        }


        if($_FILES)
        { 
            $this->db->set('published', '1');
            $this->db->where('quotation_item_id', $item_id);
            $this->db->update('tbl_quotation_upload_courier'); 

            $uploaddir = 'assets/images/upload_crm';

            foreach ($_FILES['userfiles']['name'] as $key => $value) 
            {
                $temp_file_location = $_FILES['userfiles']['tmp_name'][$key];
                
                $upload = $this->fileupload->filehandling($uploaddir,$temp_file_location,$value);
                if ($upload[0] == 'Success')
                {
                    $file_name = $upload[1];
                    
                    $insert = array(
                        'quotation_id'      => $quotation_id,
                        'quotation_item_id' => $item_id,
                        'filename'          => $file_name,
                        'user_created'      => $_SESSION['myuser']['karyawan_id'],
                        'date_created'      => date('Y-m-d H:i:s'),
                        'crm_id'            => $crm_id,
                    );
                    $this->db->insert('tbl_quotation_upload_courier', $insert);
                }      
            }
        }
    }




    public function getfilelogistic($id_item)
    {
        $sql ="SELECT * FROM tbl_quotation_upload_courier 
               WHERE quotation_item_id ='$id_item' AND published='0'";
        $res = $this->db->query($sql)->result_array();

        return $res;
    }

    
    public function get_custom_logistic($item_id,$quotation_id)
    {
        $sql ="SELECT itm.* FROM tbl_quotation_item itm
                    LEFT JOIN tbl_quotation_product prd ON prd.id = itm.product_id 
                    WHERE itm.quotation_id='$quotation_id' AND itm.id='$item_id'";
        $res = $this->db->query($sql)->row_array();

        $sql ="SELECT * FROM tbl_tariff_ppn";
        $ress = $this->db->query($sql)->row_array();

        $ppn = $ress['ppn'];
        $ppn = $ppn/100+1;



        $ongkir = $res['delivery_cost_item']/1.25/$ppn;

        $data = array(
            'ongkir' => $ongkir,
            'delivery_cost_item' => $res['delivery_cost_item'],
            'delivery_cost_' => $res['delivery_cost'],
            'courier_name' => $res['courier_name'],
        );

        return $data;
    }

    public function getdatashipping($quotation_id)
    {   

        $sql ="SELECT b.status_logistic,b.delivery_cost_item,b.courier_name,a.nama_produk, a.keterangan, a.gambar, a.jenis_satuan, a.publish, a.satuan, 
        b.id, b.product_id, b.type_produk,
        b.rupiah_price, b.length, 
        b.quantity_per_length, b.quantity,
        b.total_price, b.discount_amount,
        b.best_price, b.stock_status, 
        b.stock_time, b.stock_time_scale,
        b.display_order, c.ppn,b.berat,b.panjang,
        b.lebar,b.tinggi,
        c.delivery_type,
        c.delivery_cost,b.packing_cost,b.packing_type,pc.harga as harga_packing,c.insurance
        FROM tbl_quotation_product a 
        JOIN tbl_quotation_item b ON b.product_id = a.id 
        JOIN tbl_quotation c ON c.id = b.quotation_id
        LEFT JOIN tbl_packing_type pc ON pc.packing_type = b.packing_type
            WHERE c.id = '$quotation_id' AND  b.type_produk='Primary'
        ORDER BY b.display_order, b.id";
        $res1 = $this->db->query($sql)->result_array();


        $sql ="SELECT * FROM tbl_tariff_ppn";
        $ress = $this->db->query($sql)->row_array();

        $ppn = $ress['ppn'];
        $ppn = $ppn/100+1;

        $delv_cost2 =[];
        foreach ($res1 as $key => $res) 
        {   
            $status_logistic = $res['status_logistic'];

            if($status_logistic =='custom')
            {
                $delivery_cost = $res['delivery_cost_item'];
                $delivery_type = $res['courier_name'];

                $delv_costt = ceil($delivery_cost*$res['berat']);
                $shipping_1     = $delv_costt*'1.25'*$ppn;
                
            }else
            {
                $delivery_cost = $res['delivery_cost'];
                $delivery_type = $res['delivery_type'];

                $delv_costt = ceil($delivery_cost*$res['berat']);
                // $shipping_1  = $delv_costt*$ppn/'0.9';
                $shipping_1     = $delv_costt*$ppn/'0.8';
            }
            
            $berat = $res['berat'];
            $panjang = $res['panjang'];
            $lebar = $res['lebar'];
            $tinggi = $res['tinggi'];
            $volume_1 = $panjang * $lebar *$tinggi;
            $volume_2 = $volume_1/100;
            $volume_asli = $volume_1/1000000;


            if($volume_asli < '0.4')
            {
                $volume ='0.4';
            }else
            {
                $volume = $volume_asli;

            } 

            $total_harga_packing = round($volume*$res['harga_packing']);
            // $delv_costt = ceil($delivery_cost*$res['berat']);
            $packing_weight =$res['berat']+10;

            // $shipping_1  = $delv_costt*'1.1'/'0.9';
            $shipping_2     = ceil($shipping_1);
            $shipping_3     = round ($shipping_2, -3);
            // $shipping        = 100+$shipping_3;
             $shipping      = $shipping_3;

            if($shipping  > '100')
            {
                $shipping = $shipping;
            }else
            {
                $shipping = '0';
            }

            $delv_cost1 = $shipping;



            array_push($delv_cost2,$delv_cost1);
            
        }

        $delv_cost = array_sum($delv_cost2);

        $sql ="SELECT b.status_logistic,b.delivery_cost_item,b.courier_name,a.nama_produk, a.keterangan, a.gambar, a.jenis_satuan, a.publish, a.satuan, 
        b.id, b.product_id, b.type_produk,
        b.rupiah_price, b.length, 
        b.quantity_per_length, b.quantity,
        b.total_price, b.discount_amount,
        b.best_price, b.stock_status, 
        b.stock_time, b.stock_time_scale,
        b.display_order, c.ppn,SUM(b.berat) as berat,SUM(b.panjang) as panjang,
        SUM(b.lebar) as lebar,SUM(b.tinggi)as tinggi,
        c.delivery_type,
        c.delivery_cost,b.packing_cost,b.packing_type,pc.harga as harga_packing,c.insurance
        FROM tbl_quotation_product a 
        JOIN tbl_quotation_item b ON b.product_id = a.id 
        JOIN tbl_quotation c ON c.id = b.quotation_id
        LEFT JOIN tbl_packing_type pc ON pc.packing_type = b.packing_type
            WHERE c.id = '$quotation_id' AND  b.type_produk='Primary'
        ORDER BY b.display_order, b.id";
        $res = $this->db->query($sql)->row_array();


        $status_logistic = $res['status_logistic'];

        if($status_logistic =='custom')
        {
            $delivery_type = $res['courier_name'];
        }else
        {
            $delivery_type = $res['delivery_type'];
        }


        $packing_type = $res['packing_type'];
        $insurance    = $res['insurance'];

        if($packing_type)
        {
            $packing_cost = $res['packing_cost'];
        }else
        {
            $packing_cost ='0';
        }
        

        $arr = array('packing_type' => $packing_type,
                    'packing_cost' => $packing_cost,
                    'delv_cost' => $delv_cost,
                    'delivery_type' => $delivery_type,
                    'insurance' => $insurance);
        return $arr;
    }


     public function get_tariff_tam()
    {
        $sql ="SELECT * FROM tbl_tariff_tam ORDER BY provinsi ASC";
        $res= $this->db->query($sql)->result_array();

        return $res;
    }


    
    public function cek_double_crm($quotation_id)
    {


        $sql="SELECT cr.sales_id,date(cr.date_created) as date_crm, quo.id,quo.crm_id,cr.divisi,IF (cr.customer_type = 1, cs.id, ncs.id) AS customer_id,IF (cr.customer_type = 1, cs.perusahaan, ncs.perusahaan) AS perusahaan, IF (cr.customer_type = 1, cs.pic, ncs.pic) AS pic, IF (cr.customer_type = 1, cs.email, ncs.email) AS email, IF (cr.customer_type = 1, cs.telepon, ncs.telepon) AS telepon, IF (cr.customer_type = 1, cs.tlp_hp, ncs.tlp_hp) AS tlp_hp FROM tbl_quotation quo 
              LEFT JOIN tbl_crm cr ON cr.id = quo.crm_id
              LEFT JOIN tbl_customer cs ON (cr.customer_id = cs.id AND cr.customer_type = '1')
              LEFT JOIN tbl_non_customer ncs ON (cr.customer_id = ncs.id AND cr.customer_type = '0')
              WHERE quo.id ='$quotation_id'";
        $res = $this->db->query($sql)->row_array();
        $customer_email = $res['email'];
        $customer_id = $res['customer_id'];
        $telepon = $res['telepon'];
        $tlp_hp = $res['tlp_hp'];
        $perusahaan = $res['perusahaan'];
        $pic = $res['pic'];
        $crm_id = $res['crm_id'];
        $divisi = $res['divisi'];
        $date_crm = $res['date_crm'];
        $tlp_hp = $res['tlp_hp'];
        $sales = $res['sales_id'];




        $sql ="SELECT cr.status_closed,cr.sales_id,cr.salesman,quo.id as quotation_id,quo.quotation_no,quo.crm_id,cr.divisi,IF (cr.customer_type = 1, cs.id, ncs.id) AS customer_id,IF (cr.customer_type = 1, cs.perusahaan, ncs.perusahaan) AS perusahaan, IF (cr.customer_type = 1, cs.pic, ncs.pic) AS pic, IF (cr.customer_type = 1, cs.email, ncs.email) AS email, IF (cr.customer_type = 1, cs.telepon, ncs.telepon) AS telepon, IF (cr.customer_type = 1, cs.tlp_hp, ncs.tlp_hp) AS tlp_hp FROM tbl_quotation quo 
            LEFT JOIN tbl_crm cr ON cr.id = quo.crm_id
            LEFT JOIN tbl_customer cs ON (cr.customer_id = cs.id AND cr.customer_type = '1')
            LEFT JOIN tbl_non_customer ncs ON (cr.customer_id = ncs.id AND cr.customer_type = '0')
            WHERE cr.divisi ='$divisi' AND cr.sales_id !='$sales' AND (cr.status_closed NOT IN ('Loss','Deal')) AND cr.id !='$crm_id'
            AND ((cs.id ='$customer_id' OR ncs.id='$customer_id') OR  (cs.perusahaan ='$perusahaan' OR ncs.perusahaan='$perusahaan') OR (cs.pic ='$pic' OR ncs.pic='$pic') OR (cs.email ='$customer_email' OR ncs.email ='$customer_email'))  AND cr.date_created > '2021-04-27 12:00:00' AND quo.status ='sent'  GROUP BY crm_id";
        $rest = $this->db->query($sql)->row_array();

                
        if(!empty($rest))
        {
            $quo_id         = $rest['quotation_id'];
            $quotation_no   = $rest['quotation_no'];
            $salesman       = $rest['salesman'];
            $crm_id_1       = $rest['crm_id'];
            $sales_id       = $rest['sales_id'];

            $customer_email_1   = $rest['email'];
            $customer_id_1      = $rest['customer_id'];
            $telepon_1          = $rest['telepon'];
            $tlp_hp_1           = $rest['tlp_hp'];
            $perusahaan_1       = $rest['perusahaan'];
            $pic_1              = $rest['pic'];


            $cek =[];

            if(!empty($customer_email) AND $customer_email !='-' )
            {   if($customer_email == $customer_email_1)
                {
                    $ceks = "benar";

                    $cek_email ='sama';
                    array_push($cek, $ceks);
                }else
                {
                    $cek_email ='tidak';
                }
            }else
            {
                $cek_email ='tidak';
            }

            
            $telepon =str_replace(" ","",$telepon);
            $telepon = str_replace("-","",$telepon);
            $telepon_1 =str_replace(" ","",$telepon_1);
            $telepon_1 = str_replace("-","",$telepon_1);

            if(!empty($telepon) AND $telepon !='-' AND $telepon !='0' )
            { 
                if($telepon == $telepon_1)
                {
                    $ceks = "benar";
                    $cek_telepon ='sama';
                    array_push($cek, $ceks);
                }else
                {
                    $cek_telepon ='tidak';
                }
            }else
            {
                $cek_telepon ='tidak';
            }

            $tlp_hp =str_replace(" ","",$tlp_hp);
            $tlp_hp = str_replace("-","",$tlp_hp);
            $tlp_hp_1 =str_replace(" ","",$tlp_hp_1);
            $tlp_hp_1 = str_replace("-","",$tlp_hp_1);

            if(!empty($tlp_hp) AND $tlp_hp !='-' AND $tlp_hp !='0')
            {

                if($tlp_hp == $tlp_hp_1 )
                {
                    $ceks = "benar";
                    $cek_tlp_hp ='sama';
                    array_push($cek, $ceks);
                }else
                {
                    $cek_tlp_hp ='tidak';
                }
            }else
            {
                $cek_tlp_hp ='tidak';
            }

    

            if(!empty($perusahaan) AND $perusahaan !='-' )
            {

                if($perusahaan_1 == $perusahaan)
                {
                    $ceks = "benar";
                    $cek_perusahaan ='sama';
                    array_push($cek, $ceks);
                }else
                {
                    $cek_perusahaan ='tidak';
                }
            }else
            {
                $cek_perusahaan ='tidak';
            }

            if(!empty($pic) AND $pic !='-' )
            {
                if($pic == $pic_1)
                {
                    $ceks = "benar";
                    $cek_pic ='sama';
                    array_push($cek, $ceks);
                }else
                {
                    $cek_pic ='tidak';
                }
            }else
            {
                $cek_pic ='tidak';
            }


            // PRIMARY
      
            $sql ="SELECT product_id FROM tbl_quotation_item WHERE quotation_id = '$quotation_id' AND type_produk IN ('Primary')";
            $quo1 = $this->db->query($sql)->result_array();
                $product1=[];

            foreach ($quo1 as $key => $val1) 
            {
                    array_push($product1,$val1['product_id']);
            }


            $sql2 ="SELECT product_id FROM tbl_quotation_item WHERE quotation_id = '$quo_id' AND type_produk IN ('Primary')";
            $quo2 = $this->db->query($sql2)->result_array();
            $product2=[];

            foreach ($quo2 as $key => $val2) 
            {
                array_push($product2,$val2['product_id']);
            }

            $result = array_intersect($product1, $product2);

            if(!empty($result))
            {
                $cek_primary = "sama";
            }else
            {
                $cek_primary = "tidak";
            }


            // COMPARISON
            $sql ="SELECT product_id FROM tbl_quotation_item WHERE quotation_id = '$quotation_id' AND type_produk IN ('Comparison')";
            $comp1 = $this->db->query($sql)->result_array();
            $product_comp1=[];

            foreach ($comp1 as $key => $val1) 
            {
                    array_push($product1,$val1['product_id']);
            }


            $sql2 ="SELECT product_id FROM tbl_quotation_item WHERE quotation_id = '$quo_id' AND type_produk IN ('Comparison')";
            $comp2 = $this->db->query($sql2)->result_array();
            $product_comp2=[];

            foreach ($comp2 as $key => $val2) 
            {
                array_push($product2,$val2['product_id']);
            }

            $result_comp = array_intersect($product_comp1, $product_comp2);

            if(!empty($result_comp))
            {
                $cek_comparison = "sama";
            }else
            {
                $cek_comparison = "tidak";
            }


            // CROSS
            $sql ="SELECT product_id FROM tbl_quotation_item WHERE quotation_id = '$quotation_id' AND type_produk IN ('Cross')";
            $cr1 = $this->db->query($sql)->result_array();
            $product_cr1=[];

            foreach ($cr1 as $key => $val1) 
            {
                    array_push($product1,$val1['product_id']);
            }


            $sql2 ="SELECT product_id FROM tbl_quotation_item WHERE quotation_id = '$quo_id' AND type_produk IN ('Cross')";
            $cr2 = $this->db->query($sql2)->result_array();
            $product_cr2=[];

            foreach ($cr2 as $key => $val2) 
            {
                array_push($product2,$val2['product_id']);
            }

            $result_comp = array_intersect($product_cr1, $product_cr2);

            if(!empty($result_comp))
            {
                $cek_cross = "sama";
            }else
            {
                $cek_cross = "tidak";
            }



            if($cek_telepon =='sama' OR $cek_perusahaan=='sama')
            {
                $keterangan_1 = 'sama';
            }else
            {
                $keterangan_1 ='tidak';
            }


            if($cek_primary =='sama' OR $cek_cross =='sama' OR $cek_comparison =='sama')
            {
                $keterangan_2 = 'sama';
            }else
            {
                $keterangan_2 ='tidak';
            }

    

            if($keterangan_1 =='sama' AND $keterangan_2 =='sama')
            {
                    $keterangan='sama';
                    $data = array('quotation_no' =>$quotation_no,
                               'keterangan' => 'sama',
                               'salesman' => $salesman,
                            );

            }else
            {
                 $data = array('quotation_no' =>'',
                               'keterangan' => $keterangan,
                               'salesman' => ''
                            );
            }

        }else
        {   
            $keterangan ='tidak';
            $data = array('quotation_no' =>'',
                               'keterangan' => $keterangan,
                               'salesman' => ''
                            );
        }

        

        return $data;
    }

    public function hitung_dpp()
    {   

        $id           = $this->input->post('quotation_id');
        $item         = $this->quotation->getListItem($id);

        $ttl_semua = array();

        foreach ($item as $key=> $produk)
        { 
            if($produk['type_produk'] == 'Primary')
            {
                $rupiah_price = $produk['rupiah_price'];
                $total_price = $produk['total_price'];
                $discount_amount = $produk['discount_amount'];
                $best_price = $produk['best_price'];


                // print_r($produk['sku']."-".$produk['type_produk']."<br>");
                
                // print_r("harga barang (no kode) ".number_format($rupiah_price,0)."<br>");
                // print_r("discount (no kode) ".number_format($discount_amount,0)."<br>");
                // print_r("total sesudah discount  (no kode) ".number_format($best_price,0)."<br>");
           

                $email = $produk['email'];
                $email = explode("@",$email);


                $email = $email['0'];

                if(is_numeric($email) =='1')
                {
                    $kode_sales = $email;
                  
                }else
                {
                    $kode_sales='000';

                }


                if($key =='0')
                {
                    $best_price = $best_price+$kode_sales;
                    $discount_amount = $discount_amount-$kode_sales;
                }


                $dlv_typ = explode(" " ,$produk['delivery_type']);
                $dlv_typ = $dlv_typ['0'];

                $sql ="SELECT * FROM tbl_tariff_ppn";
                $ress = $this->db->query($sql)->row_array();

                $ppn = $ress['ppn'];
                $ppn = $ppn/100+1;

                if($produk['status_logistic'] =='custom')
                {
                    $delv_cost = $produk['delivery_cost_item'];
                    $delv_cost      = ceil($delv_cost*$produk['berat']*'1.25'*$ppn);
                }else
                {

                    $delv_cost1      = $produk['delivery_cost']; 
                    $vol             = ceil($produk['panjang']*$produk['lebar']*$produk['tinggi']/6000);

                    if($produk['berat'] > $vol)
                    {
                        $berat = $produk['berat'];
                    }else
                    {
                        $berat = $vol;  
                    }

                    $sql ="SELECT * FROM tbl_tariff_ppn";
                    $ress = $this->db->query($sql)->row_array();

                    $ppn = $ress['ppn'];
                    $ppn = $ppn/100+1;

                
                    $delv_cost      = ceil($delv_cost1*$berat*$ppn/'0.8');


                    if($dlv_typ=='sicepat')
                    {
                        if($berat >'50' AND $berat <='70')
                        {
                            $delv_cost_berat = $delv_cost*'1.25';
                        }
                        elseif($berat >'50' AND $berat <='100')
                        {
                            $delv_cost_berat = $delv_cost*'1.5';
                        }
                        elseif($berat >'100')
                        {
                            $delv_cost_berat = $delv_cost*'2';

                        }else
                        {
                            $delv_cost_berat=$delv_cost;
                        }

                        $delv_cost = $delv_cost_berat; 
                    }
                }


                $shipping_2     = ceil($delv_cost);
                $shipping       = round ($shipping_2, -3);

                if($shipping >'100')
                {
                    $shipping = $shipping;
                }else
                {
                    $shipping ='0';
                }

                $panjang = $produk['panjang'];
                $lebar = $produk['lebar'];
                $tinggi = $produk['tinggi'];
                $volume_1 = $panjang * $lebar *$tinggi;
                $volume_2 = $volume_1/100;
                $volume_asli = $volume_1/1000000;
                $total_volume = $volume_asli* $produk['quantity'];

                if($total_volume < '0.4')
                {
                    $volume ='0.4';
                }else
                {
                    $volume = $total_volume;
                }

                $sql ="SELECT * FROM tbl_tariff_ppn";
                $ress = $this->db->query($sql)->row_array();

                $ppn = $ress['ppn'];
                $ppn = $ppn/100+1;

                $total_harga_packing = round($volume*$produk['harga_packing']*$ppn);
                $ttl_packing1 = $produk['packing_cost']/$produk['quantity'];
                $ttl_packing = $produk['packing_cost'];

                $ttl_packing = $volume*$produk['harga_packing']*$ppn;

                $ttl_pack = round($ttl_packing);

                $a = str_replace(',', '', $ttl_pack);
                $hrgs = substr($a,-3);
                $hrg = substr($a, 0, -3);
                $hrg1 = $hrg."000";
                $d = $hrg1+1000;
                

                if($hrgs == '000')
                {
                     $c = $hrg1;

                }else
                {
                     $c = $hrg1+1000;
                }

                $ttl_packing = $c;

                $sql ="SELECT * FROM tbl_tariff_ppn";
                $ress = $this->db->query($sql)->row_array();

                $ppn = $ress['ppn'];
                $ppn = $ppn/100+1;
  

                if($produk['insurance'] =='yes')
                {
                    $insurance =$best_price;
                    $total_insurance = 0.2/100*$insurance*$ppn;
                }else
                {   
                    $total_insurance='0';  
                }

                $total_semua = $best_price+$shipping+$total_insurance+$ttl_packing;
                array_push($ttl_semua,$total_semua);

                // print_R("Shipping  ".number_format($shipping,0)."<br>");
                // print_R("Packing  ".number_format($ttl_packing,0)."<br>");
                // print_R("insurance  ".number_format($total_insurance,0)."<br>");
                //  print_R("total udah di tambah  ".number_format($total_semua,0)."<br><br><br>");
            }
        }


        $sql ="SELECT * FROM tbl_tariff_ppn";
        $ress = $this->db->query($sql)->row_array();

        $ppn = $ress['ppn'];
        $ppn = $ppn/100+1;

        $ttl_sum_1 = array_sum($ttl_semua);
        $ttl_sum_1 = $ttl_sum_1;
        $ttl_sum = $ttl_sum_1/$ppn;

        $ttls = round($ttl_sum);

        return $ttls;
    }

    public function save_komisi()
    {
        $quotation_id   = $this->input->post('quotation_id');
        $komisi_value = $this->input->post('komisi_value');
        $komisi_value = str_replace(',','',$komisi_value);
        $komisi_persen = $this->input->post('komisi_persen');
        $type_komisi = $this->input->post('type_komisi');

        $this->db->set('type_komisi', $type_komisi);
        $this->db->set('komisi_persen', $komisi_persen);
        $this->db->set('komisi_value', $komisi_value);
        $this->db->where('id', $quotation_id);
        $this->db->update('tbl_quotation'); 

    }

        public function get_product_iios($value)
    {
        $this->db->select('*');
        $this->db->from('tbl_quotation_product ');
        $this->db->where('id',$value);
        $prod = $this->db->get()->row_array();

        return $prod;
    }

    public function get_kurs($currency)
    {
        $this->db->select('kurs');
        $this->db->from('tbl_kurs');
        $this->db->where('currency',$currency);
        $this->db->order_by('id','DESC');
        $this->db->limit('1');
        $kurs = $this->db->get()->row_array();
        $kurs =$kurs['kurs'];

        return $kurs;
    }

    public function text_quotation()
    {
        $quotation_id   = $this->input->post('quotation_id');

        $sql ="SELECT * FROM tbl_tariff_ppn";
        $ress = $this->db->query($sql)->row_array();

        $ppn = $ress['ppn'];
        $ppn = $ppn/100+1;


        $psn ="<span style='color:black;'>Quotation Verification : </span><br><br>";

        $sql ="SELECT * FROM tbl_quotation WHERE id='$quotation_id'";
        $res = $this->db->query($sql)->row_array();
        $quotation_id       = $res['id'];
        $created            = $res['created'];
        $quotation_id       = $res['id'];
        $price_term         = $res['price_term'];
        $delivery_time      = $res['delivery_time'];
        $delivery_period    = $res['delivery_period'];
        $komisi_value       = $res['komisi_value']*$ppn;
        $komisi_value_no_ppn= $res['komisi_value'];
        $komisi_persen      = $res['komisi_persen'];


        $sql = "SELECT a.tipe_produk,b.discount,b.id as id_item,c.insurance,krw.email,c.created,b.ket_stock,a.id as sku,b.status_logistic,b.delivery_cost_item,b.courier_name,b.quotation_id,a.nama_produk, a.keterangan, a.gambar, a.jenis_satuan, a.publish, a.satuan, 
        b.id, b.product_id, b.type_produk, b.rupiah_price, b.length, b.quantity_per_length, b.quantity, b.total_price, b.discount_amount, b.best_price, b.stock_status, b.stock_time, b.stock_time_scale, b.display_order, c.ppn,b.berat,b.panjang,b.lebar,b.tinggi,c.delivery_type,c.delivery_cost,b.packing_cost,b.packing_type,pc.harga as harga_packing,c.tariff_ppn
        FROM tbl_quotation_product a 
        JOIN tbl_quotation_item b ON b.product_id = a.id 
        JOIN tbl_quotation c ON c.id = b.quotation_id
        LEFT JOIN tbl_packing_type pc ON pc.packing_type = b.packing_type
        LEFT JOIN tbl_karyawan krw ON krw.id = c.sales_id
        WHERE c.id = '$quotation_id' AND  b.type_produk='Primary'
        ORDER BY b.display_order, b.id";
        $res1 = $this->db->query($sql)->result_array();


        $surplus =[];
        $minus =[];
        $persen_plus =[];
        $persen_minus =[];
        $current_nett_price =[];
        $sold =[];
        $dlv_cost =[];
        $ship_insurance =[];
        $total_packing =[];
        $total_current =[];
        $warning=array();

        
        foreach ($res1 as $key => $rs) 
        {   


            $status_logistic = $rs['status_logistic'];

            $stock = $this->masterproduk->getProdukStock($rs['product_id']);

            if (isset($stock[$rs['product_id']]['all']['total']))
            $total = $stock[$rs['product_id']]['all']['total'];
            else
            $total = 0;
        
            if (isset($stock[$rs['product_id']]['all']['ready_booked']))
            $ready_booked = $stock[$rs['product_id']]['all']['ready_booked'];
            else
            $ready_booked = 0;
        
            if (isset($stock[$rs['product_id']]['all']['not_ready']))
            $not_ready = $stock[$rs['product_id']]['all']['not_ready'];
            else
            $not_ready = 0;
        
            if (isset($stock[$rs['product_id']]['all']['booked']))
            $booked = $stock[$rs['product_id']]['all']['booked'];
            else
            $booked = 0;
        
            if (isset($stock[$rs['product_id']]['all']['ordered']))
            $ordered = $stock[$rs['product_id']]['all']['ordered'];
            else
            $ordered = 0;
        
            $ready = $ready_booked - $booked;
            if ($ready < 0)
            $ready = 0;

            $prod    = $this->get_product_iios($rs['product_id']);

            if($prod)
            {
                $product_id     = $prod['id'];
                $nama_produk    = $prod['nama_produk'];
                $currency       = $prod['currency'];
                $harga          = $prod['harga'];
                $max_discount   = $prod['max_discount'];

                $getkurs = $this->get_kurs($currency);

                $kurs     = $getkurs;
                $kurs1    = str_replace(".", "", $kurs);
                $kurs1    = substr($kurs1,0,-2);

                if($currency =='IDR')
                {
                    $harga_rupiah = $harga;
                }
                else
                { 
                    $cek_setting ="SELECT * FROM tbl_history_kurs_setting WHERE kurs ='$currency' ORDER BY id DESC LIMIT 1";
                    $setting = $this->db->query($cek_setting);
                    $info_setting = $setting->row_array();

                    if(empty($info_setting) OR $info_setting['type_currency'] =='floating')
                    {
                        $sql2 = "SELECT * FROM tbl_kurs WHERE currency  = '$currency' ORDER BY id DESC";
                        $query2 = $this->db->query($sql2);
                        $infokurs = $query2->row_array();

                        $sqls ="SELECT * FROM tbl_kurs_multiply_floating WHERE currency ='$currency' ORDER BY id DESC LIMIT 1";
                        $res = $this->db->query($sqls)->row_array();
                        $multiply = $res['multiply'];

                        if($multiply)
                        {
                            $nilai_tukar =  $infokurs['kurs']*$multiply/100;
                        }else
                        {
                            $nilai_tukar =  $infokurs['kurs'];
                        }

                    }else
                    {
                        $sql2 = "SELECT * FROM tbl_kurs_fixed WHERE kurs ='$currency' ORDER BY id DESC LIMIT 1";
                        $query2 = $this->db->query($sql2);
                        $infokurs = $query2->row_array();
                        $nilai_tukar =  $infokurs['currency'];
                    }

                    $harga_rupiah = $harga * $nilai_tukar;
                }

                $persentase = 35/100;
                $persentase_1 = 1-$persentase;
                $harga_max= $harga_rupiah*$persentase_1;
                $discount = 35/100*$harga_rupiah;
                $harga_fix = $harga_rupiah - $discount;

                $harga1 = $harga_fix*$rs['quantity'];

                $sql ="SELECT * FROM tbl_tariff_ppn";
                $ress = $this->db->query($sql)->row_array();

                $ppn = $ress['ppn'];
                $ppn = $ppn/100+1;

                $harga_pricelist = $harga1;

            }else
            {   
                $harga_pricelist= '0';
            }

          
      

            $ppn = $rs['tariff_ppn'];
            $ppn = $ppn/100+1;

            $harga_pricelist = $harga_pricelist*$ppn;
            

            // rumus baru 
            $discount_persen = $rs['discount'];
            $panjang = $rs['panjang'];
            $lebar = $rs['lebar'];
            $tinggi = $rs['tinggi'];
            $volume_1 = $panjang * $lebar *$tinggi;
            $volume_2 = $volume_1/100;
            $volume_asli = $volume_1/1000000;
            $total_volume = $volume_asli* $rs['quantity'];

            if($total_volume < '0.4')
            {
                $volume ='0.4';
            }else
            {
                $volume = $total_volume;
            } 

            $total_harga_packing = round($volume*$rs['harga_packing']*$tariff_ppn_1);
            $ttl_packing1 = $rs['packing_cost']/$rs['quantity'];
            $ttl_packing = $rs['packing_cost'];

            $ttl_packing = $volume*$rs['harga_packing']*$tariff_ppn_1;

            $ttl_pack = round($ttl_packing);


            $ttl_packing = $ttl_packing; //no pembulatan

            $dlv_typ = explode(" " ,$rs['delivery_type']);
            $dlv_typ = $dlv_typ['0'];

            if($rs['status_logistic'] =='custom')
            {
                $delv_cost = $rs['delivery_cost_item'];
                
            }else
            {

                if($rs['delivery_cost_item'] =='0.00')
                {
                    $delv_cost1      = $rs['delivery_cost']; 
                    $vol             = ceil($rs['panjang']*$rs['lebar']*$rs['tinggi']/6000);

                    if($rs['berat'] > $vol)
                    {
                        $berat = $rs['berat'];
                    }else
                    {
                        $berat = $vol;  
                    }

                    $delv_cost      = ($delv_cost1*$berat/'0.8');
                   

                    $dlv_cost_masuk_ke_db = ($delv_cost1*$berat/'0.8');
                    

                    if($dlv_typ=='sicepat')
                    {
                        if($berat >'50' AND $berat <='70')
                        {
                            $delv_cost_berat = $delv_cost*'1.25';
                            $dlv_cost_masuk_ke_db = $dlv_cost_masuk_ke_db*'1.25';
                        }
                        elseif($berat >'50' AND $berat <='100')
                        {
                            $delv_cost_berat = $delv_cost*'1.5';
                            $dlv_cost_masuk_ke_db = $dlv_cost_masuk_ke_db*'1.5';
                        }
                        elseif($berat >'100')
                        {
                            $delv_cost_berat = $delv_cost*'2';
                            $dlv_cost_masuk_ke_db = $dlv_cost_masuk_ke_db*'2';

                        }else
                        {
                            $delv_cost_berat=$delv_cost;
                            $dlv_cost_masuk_ke_db = $dlv_cost_masuk_ke_db*'2';
                        }

                        $delv_cost = $delv_cost_berat; 
                    }
                }else
                {
                    $delv_cost = $rs['delivery_cost_item'];
                }
            }



            $shipping_2     = ceil($delv_cost);

      

            $shipping = $delv_cost;//no pembulatan

            $unit_price = $rs['rupiah_price'];

            
            $ttl_packing = $ttl_packing; 
            $discount_amount = $rs['discount_amount'];
        

            $packing_dibagi = $ttl_packing/$rs['quantity'];
            $ongkir_dibagi = $shipping/$rs['quantity'];



            if($rs['ppn']=='included')
            {
                $unt_price = $unit_price*$tariff_ppn_1;
                $ongkir_dibagi = $ongkir_dibagi;
                $packing_dibagi = $packing_dibagi;
            }else
            {
                $unt_price = $unit_price;

                if(!empty($ongkir_dibagi) OR $ongkir_dibagi !='0')
                {
                     $ongkir_dibagi = $ongkir_dibagi/$ppn;
                }else
                {
                    $ongkir_dibagi="0";
                }

                if(!empty($ongkir_dibagi) OR $packing_dibagi !='0')
                {
                     $packing_dibagi = $packing_dibagi/$ppn;
                }else
                {
                    $packing_dibagi="0";
                }
               
                
            }


            $unit_price_fix = $unt_price+$packing_dibagi+$ongkir_dibagi;

            $total_delivery_cost = $ttl_packing+$shipping;

            $total_price         = $unit_price_fix*$rs['quantity'];
            $best_price          = ($unit_price*$rs['quantity'])-$discount_amount+$total_delivery_cost;



            $best_price = $best_price+$harga_retail;

            if($discount_persen !='100')
            {
                $best = number_format($best_price);
                $a = str_replace(',', '', $best);
                $hrgs = substr($a,-3);
                $hrg = substr($a, 0, -3);
                $hrg1 = $hrg."000";

                $d = $hrg1;
            }else
            {
                $d = $best_price;
            }


           

            $email = $rs['email'];
            $email = explode("@",$email);


            $email = $email['0'];

            if($key =='0')
            {   
                if($best_price !='0')
                {
                    if(is_numeric($email) =='1')
                    {
                        $kode_sales = $email;
                      
                    }else
                    {
                        $kode_sales='000';
                    }
                }else
                {
                     $kode_sales='000';
                }
                
            }else
            {
                $kode_sales='000';
            }

            $aa = round($rs['best_price']);
            $bb = $aa*$ppn;
            $cc = $bb+$shipping+$ttl_packing;
              

            if($quotation['insurance'] =='yes')
            {
                if($rs['tipe_produk'] =='barang')
                {
                    $harga_premi  = $premi/100*$aa;
                    $harga_retail = $harga_premi*$tariff_ppn_1/0.7;
                    
                }else
                {
                    $harga_premi="0";
                    $harga_retail="0";
                }
            }else
            {
                $harga_premi="0";
                $harga_retail="0";
            }

            $cc = $cc+$harga_retail;


            $best = number_format($cc);
            $a    = str_replace(',', '', $best);
            $hrgs = substr($a,-3);
            $hrg  = substr($a, 0, -3);
            $hrg1 = $hrg."000";
            $hrg1 = $hrg1+1000;


            if($discount_persen =='100')
            {
                $hrg1 = $hrg1-1000;
            }
   
            $d = $hrg1;

        


            $best_price_roundup = $d+$kode_sales;
            $best_price = $best_price_roundup;

            $current = $harga_pricelist+$total_delivery_cost+$harga_retail;
        

            $selisih = $best_price-$current;


            //baruuu
       
            if($selisih >='0')
            {
                $persen  = $selisih/$current*100;
                $persen  = round($persen,2);

                array_push($surplus,$selisih);
                array_push($persen_plus,$persen);

                $ver = "<b><span style='color:green'>(Price Verified, Stock : ".$ready." Unit)<br>
                        * sold : Rp " . number_format($best_price,2,',',',')." ; Current nett Price 
                        Rp ".number_format($current,2,',',',')." ; Surplus :  Rp " . 
                        number_format($selisih,2,',',',')." ( ".$persen."% )</span></b>";
            }else
            {
                $persen  = $selisih/$current*100;
                $persen  = round($persen,2);

                array_push($minus,$selisih);
                array_push($persen_minus,$persen);


                $ver = "<b><span style='color:red'>(Price Not Verified, Stock : ".$ready." Unit)<br>
                        * sold : Rp " . number_format($best_price,2,',',',')." ; Current nett Price
                        Rp ".number_format($current,2,',',',')." ; Minus : - Rp " . 
                        number_format($selisih,2,',',',')." ( ".$persen."% )</span></b>";
            }

            $psn .= "<span style='color:black'>". $rs['product_id']." - ".$rs['nama_produk'] ." x ".$rs['quantity']." Unit </span>".$ver."<br>";

            array_push($current_nett_price,$harga_pricelist);
            array_push($sold, $best_price);
            array_push($dlv_cost,$shipping);
            array_push($ship_insurance,$harga_retail);
            array_push($total_packing,$ttl_packing);
            array_push($total_current,$current);
        }

      

        $total_current_nett = array_sum($current_nett_price);
        $sum_minus          = array_sum($minus);
        $sum_minus          = $sum_minus+$komisi_value;
        $sum_persen_minus   = array_sum($persen_minus);
        $sum_persen_plus    = array_sum($persen_plus);
        $sum_suplus         = array_sum($surplus);
        $total_transaction  = array_sum($sold);
        $total_shipping     = array_sum($dlv_cost);
        $ttl_insurance      = array_sum($ship_insurance);
        $harga_packing      = array_sum($total_packing);

        $ttl_current      = array_sum($total_current);

    
        $diff =datediff(date('Y-m-d H:i:s'),$created);
        $days = $diff['days'];

        if($days >'7')
        {
            $vld = "not Valid";
        }else
        {
            $vld ="Valid";
        }

        $getkurss = $this->get_kurs('USD');
        $kurss     = $getkurss;
        $kurss1    = str_replace(".", "", $kurss);
        $kurss1    = substr($kurss1,0,-2);


        $cek_setting ="SELECT * FROM tbl_history_kurs_setting WHERE kurs ='USD' ORDER BY id DESC LIMIT 1";
        $setting = $this->db->query($cek_setting);
        $info_setting = $setting->row_array();

        if(empty($info_setting) OR $info_setting['type_currency'] =='floating')
        {
                $sql2 = "SELECT * FROM tbl_kurs WHERE currency  = 'USD' ORDER BY id DESC";
                $query2 = $this->db->query($sql2);
                $infokurs = $query2->row_array();

                $sqls ="SELECT * FROM tbl_kurs_multiply_floating WHERE currency ='USD' ORDER BY id DESC LIMIT 1";
                $res = $this->db->query($sqls)->row_array();
                $multiply = $res['multiply'];

                if($multiply)
                {
                    $nilai_tukar =  $infokurs['kurs']*$multiply/100;
                }else
                {
                    $nilai_tukar =  $infokurs['kurs'];
                }

        }else
        {
                $sql2 = "SELECT * FROM tbl_kurs_fixed WHERE kurs ='USD' ORDER BY id DESC LIMIT 1";
                $query2 = $this->db->query($sql2);
                $infokurs = $query2->row_array();
                $nilai_tukar =  $infokurs['currency'];
        }
        $kurss1 = $nilai_tukar;

        $persen_plus1  = $sum_suplus/$total_transaction*100;
        $persen_minus1 = $sum_minus/$total_transaction*100;

        $psn .="<br><span style='color:black'> Quotation Date : ".date('d-m-Y H:i:s',strtotime($created))." (".$days."D - ".$vld.")</span><br>";

        $psn .="<span style='color:black'> Current Currency Rate : 1 USD = Rp. ".number_format($kurss1,2,',',',')."</span><br>";

        $psn .="<span style='color:black'> Price Term : ".$price_term."</span><br>";
        $psn .="<span style='color:black'> Delivery Time : ".$delivery_time." ".$delivery_period."s</span><br><br>";



        $psn  .="<span style='color:black'>Refferal Commision (Minus) : Rp. ".number_format($komisi_value,2,',',',')." / ".$komisi_persen."% </span><br>";

        $psn  .="<span style='color:black'>Refferal Commision Received by Customer : Rp. ".number_format($komisi_value_no_ppn,2,',',',')." / ".$komisi_persen."% </span><br>";

        $psn  .="<span style='color:black'>Shipping : Rp. ".number_format($total_shipping,2,',',',')."</span><br>";

        // $psn  .="<span style='color:black'>Ship Insurance : Rp. ".$ttl_insurance."</span><br>";

        $psn  .="<span style='color:black'>Packing : Rp. ".number_format($harga_packing,0,',',',')."</span><br><br>";

        $ttl = $total_transaction+$total_shipping+$ttl_insurance+$harga_packing;

        $ttl1 = $total_transaction-$komisi_value-$ttl_current;
        $ttl2 = $ttl_current+$komisi_value;



        if($ttl1 >='0')
        {

            $prsn = $ttl1/$ttl2*100;
            $psn .="<b><span style='color:green;'>Surplus : Rp. ". number_format($ttl1,2,',',',')." (".number_format($prsn,2)."%)</span></b><br>";

            $warning ='no';

        }else
        {   
            $prsn = $ttl1/$ttl2*100;
            $psn .="<b><span style='color:red;'>Minus : Rp. ". number_format($ttl1,2,',',',')." (".number_format($prsn,2)."%)</span></b><br>";

            $warning = 'yes';
        }

        $ttl = $sum_suplus-$sum_minus;
        
        

        $aa = array(
            'warning'=> $warning,
            'pesan' => $psn
        );

        return $aa;
    }


    public function verifikasi($quotation_id)
    {
    

        $sql ="SELECT * FROM tbl_tariff_ppn";
        $ress = $this->db->query($sql)->row_array();

        $ppn = $ress['ppn'];
        $ppn = $ppn/100+1;


        $psn ="<span style='color:black;'>Quotation Verification : </span><br><br>";

        $sql ="SELECT * FROM tbl_quotation WHERE id='$quotation_id'";
        $res = $this->db->query($sql)->row_array();
        $quotation_id       = $res['id'];
        $created            = $res['created'];
        $quotation_id       = $res['id'];
        $price_term         = $res['price_term'];
        $delivery_time      = $res['delivery_time'];
        $delivery_period    = $res['delivery_period'];
        $komisi_value       = $res['komisi_value']*$ppn;
        $komisi_value_no_ppn= $res['komisi_value'];
        $komisi_persen      = $res['komisi_persen'];


        $sql = "SELECT a.tipe_produk,b.discount,b.id as id_item,c.insurance,krw.email,c.created,b.ket_stock,a.id as sku,b.status_logistic,b.delivery_cost_item,b.courier_name,b.quotation_id,a.nama_produk, a.keterangan, a.gambar, a.jenis_satuan, a.publish, a.satuan, 
        b.id, b.product_id, b.type_produk, b.rupiah_price, b.length, b.quantity_per_length, b.quantity, b.total_price, b.discount_amount, b.best_price, b.stock_status, b.stock_time, b.stock_time_scale, b.display_order, c.ppn,b.berat,b.panjang,b.lebar,b.tinggi,c.delivery_type,c.delivery_cost,b.packing_cost,b.packing_type,pc.harga as harga_packing,c.tariff_ppn
        FROM tbl_quotation_product a 
        JOIN tbl_quotation_item b ON b.product_id = a.id 
        JOIN tbl_quotation c ON c.id = b.quotation_id
        LEFT JOIN tbl_packing_type pc ON pc.packing_type = b.packing_type
        LEFT JOIN tbl_karyawan krw ON krw.id = c.sales_id
        WHERE c.id = '$quotation_id' AND  b.type_produk='Primary'
        ORDER BY b.display_order, b.id";
        $res1 = $this->db->query($sql)->result_array();


        $surplus =[];
        $minus =[];
        $persen_plus =[];
        $persen_minus =[];
        $current_nett_price =[];
        $sold =[];
        $dlv_cost =[];
        $ship_insurance =[];
        $total_packing =[];
        $total_current =[];
        $warning=array();

        
        foreach ($res1 as $key => $rs) 
        {   


            $status_logistic = $rs['status_logistic'];

            $stock = $this->masterproduk->getProdukStock($rs['product_id']);

            if (isset($stock[$rs['product_id']]['all']['total']))
            $total = $stock[$rs['product_id']]['all']['total'];
            else
            $total = 0;
        
            if (isset($stock[$rs['product_id']]['all']['ready_booked']))
            $ready_booked = $stock[$rs['product_id']]['all']['ready_booked'];
            else
            $ready_booked = 0;
        
            if (isset($stock[$rs['product_id']]['all']['not_ready']))
            $not_ready = $stock[$rs['product_id']]['all']['not_ready'];
            else
            $not_ready = 0;
        
            if (isset($stock[$rs['product_id']]['all']['booked']))
            $booked = $stock[$rs['product_id']]['all']['booked'];
            else
            $booked = 0;
        
            if (isset($stock[$rs['product_id']]['all']['ordered']))
            $ordered = $stock[$rs['product_id']]['all']['ordered'];
            else
            $ordered = 0;
        
            $ready = $ready_booked - $booked;
            if ($ready < 0)
            $ready = 0;

            $prod    = $this->get_product_iios($rs['product_id']);

            if($prod)
            {
                $product_id     = $prod['id'];
                $nama_produk    = $prod['nama_produk'];
                $currency       = $prod['currency'];
                $harga          = $prod['harga'];
                $max_discount   = $prod['max_discount'];

                $getkurs = $this->get_kurs($currency);

                $kurs     = $getkurs;
                $kurs1    = str_replace(".", "", $kurs);
                $kurs1    = substr($kurs1,0,-2);

                if($currency =='IDR')
                {
                    $harga_rupiah = $harga;
                }
                else
                { 
                    $cek_setting ="SELECT * FROM tbl_history_kurs_setting WHERE kurs ='$currency' ORDER BY id DESC LIMIT 1";
                    $setting = $this->db->query($cek_setting);
                    $info_setting = $setting->row_array();

                    if(empty($info_setting) OR $info_setting['type_currency'] =='floating')
                    {
                        $sql2 = "SELECT * FROM tbl_kurs WHERE currency  = '$currency' ORDER BY id DESC";
                        $query2 = $this->db->query($sql2);
                        $infokurs = $query2->row_array();

                        $sqls ="SELECT * FROM tbl_kurs_multiply_floating WHERE currency ='$currency' ORDER BY id DESC LIMIT 1";
                        $res = $this->db->query($sqls)->row_array();
                        $multiply = $res['multiply'];

                        if($multiply)
                        {
                            $nilai_tukar =  $infokurs['kurs']*$multiply/100;
                        }else
                        {
                            $nilai_tukar =  $infokurs['kurs'];
                        }

                    }else
                    {
                        $sql2 = "SELECT * FROM tbl_kurs_fixed WHERE kurs ='$currency' ORDER BY id DESC LIMIT 1";
                        $query2 = $this->db->query($sql2);
                        $infokurs = $query2->row_array();
                        $nilai_tukar =  $infokurs['currency'];
                    }

                    $harga_rupiah = $harga * $nilai_tukar;
                }

                $persentase = 35/100;
                $persentase_1 = 1-$persentase;
                $harga_max= $harga_rupiah*$persentase_1;
                $discount = 35/100*$harga_rupiah;
                $harga_fix = $harga_rupiah - $discount;

                $harga1 = $harga_fix*$rs['quantity'];

                $sql ="SELECT * FROM tbl_tariff_ppn";
                $ress = $this->db->query($sql)->row_array();

                $ppn = $ress['ppn'];
                $ppn = $ppn/100+1;

                $harga_pricelist = $harga1;

            }else
            {   
                $harga_pricelist= '0';
            }

          
      

            $ppn = $rs['tariff_ppn'];
            $ppn = $ppn/100+1;

            $harga_pricelist = $harga_pricelist*$ppn;
            

            // rumus baru 
            $discount_persen = $rs['discount'];
            $panjang = $rs['panjang'];
            $lebar = $rs['lebar'];
            $tinggi = $rs['tinggi'];
            $volume_1 = $panjang * $lebar *$tinggi;
            $volume_2 = $volume_1/100;
            $volume_asli = $volume_1/1000000;
            $total_volume = $volume_asli* $rs['quantity'];

            if($total_volume < '0.4')
            {
                $volume ='0.4';
            }else
            {
                $volume = $total_volume;
            } 

            $total_harga_packing = round($volume*$rs['harga_packing']*$tariff_ppn_1);
            $ttl_packing1 = $rs['packing_cost']/$rs['quantity'];
            $ttl_packing = $rs['packing_cost'];

            $ttl_packing = $volume*$rs['harga_packing']*$tariff_ppn_1;

            $ttl_pack = round($ttl_packing);


            $ttl_packing = $ttl_packing; //no pembulatan

            $dlv_typ = explode(" " ,$rs['delivery_type']);
            $dlv_typ = $dlv_typ['0'];

            if($rs['status_logistic'] =='custom')
            {
                $delv_cost = $rs['delivery_cost_item'];
                
            }else
            {

                if($rs['delivery_cost_item'] =='0.00')
                {
                    $delv_cost1      = $rs['delivery_cost']; 
                    $vol             = ceil($rs['panjang']*$rs['lebar']*$rs['tinggi']/6000);

                    if($rs['berat'] > $vol)
                    {
                        $berat = $rs['berat'];
                    }else
                    {
                        $berat = $vol;  
                    }

                    $delv_cost      = ($delv_cost1*$berat/'0.8');
                   

                    $dlv_cost_masuk_ke_db = ($delv_cost1*$berat/'0.8');
                    

                    if($dlv_typ=='sicepat')
                    {
                        if($berat >'50' AND $berat <='70')
                        {
                            $delv_cost_berat = $delv_cost*'1.25';
                            $dlv_cost_masuk_ke_db = $dlv_cost_masuk_ke_db*'1.25';
                        }
                        elseif($berat >'50' AND $berat <='100')
                        {
                            $delv_cost_berat = $delv_cost*'1.5';
                            $dlv_cost_masuk_ke_db = $dlv_cost_masuk_ke_db*'1.5';
                        }
                        elseif($berat >'100')
                        {
                            $delv_cost_berat = $delv_cost*'2';
                            $dlv_cost_masuk_ke_db = $dlv_cost_masuk_ke_db*'2';

                        }else
                        {
                            $delv_cost_berat=$delv_cost;
                            $dlv_cost_masuk_ke_db = $dlv_cost_masuk_ke_db*'2';
                        }

                        $delv_cost = $delv_cost_berat; 
                    }
                }else
                {
                    $delv_cost = $rs['delivery_cost_item'];
                }
            }



            $shipping_2     = ceil($delv_cost);

      

            $shipping = $delv_cost;//no pembulatan

            $unit_price = $rs['rupiah_price'];

            
            $ttl_packing = $ttl_packing; 
            $discount_amount = $rs['discount_amount'];
        

            $packing_dibagi = $ttl_packing/$rs['quantity'];
            $ongkir_dibagi = $shipping/$rs['quantity'];



            if($rs['ppn']=='included')
            {
                $unt_price = $unit_price*$tariff_ppn_1;
                $ongkir_dibagi = $ongkir_dibagi;
                $packing_dibagi = $packing_dibagi;
            }else
            {
                $unt_price = $unit_price;

                if(!empty($ongkir_dibagi) OR $ongkir_dibagi !='0')
                {
                     $ongkir_dibagi = $ongkir_dibagi/$ppn;
                }else
                {
                    $ongkir_dibagi="0";
                }

                if(!empty($ongkir_dibagi) OR $packing_dibagi !='0')
                {
                     $packing_dibagi = $packing_dibagi/$ppn;
                }else
                {
                    $packing_dibagi="0";
                }
               
                
            }


            $unit_price_fix = $unt_price+$packing_dibagi+$ongkir_dibagi;

            $total_delivery_cost = $ttl_packing+$shipping;

            $total_price         = $unit_price_fix*$rs['quantity'];
            $best_price          = ($unit_price*$rs['quantity'])-$discount_amount+$total_delivery_cost;



            $best_price = $best_price+$harga_retail;

            if($discount_persen !='100')
            {
                $best = number_format($best_price);
                $a = str_replace(',', '', $best);
                $hrgs = substr($a,-3);
                $hrg = substr($a, 0, -3);
                $hrg1 = $hrg."000";

                $d = $hrg1;
            }else
            {
                $d = $best_price;
            }


           

            $email = $rs['email'];
            $email = explode("@",$email);


            $email = $email['0'];

            if($key =='0')
            {   
                if($best_price !='0')
                {
                    if(is_numeric($email) =='1')
                    {
                        $kode_sales = $email;
                      
                    }else
                    {
                        $kode_sales='000';
                    }
                }else
                {
                     $kode_sales='000';
                }
                
            }else
            {
                $kode_sales='000';
            }

            $aa = round($rs['best_price']);
            $bb = $aa*$ppn;
            $cc = $bb+$shipping+$ttl_packing;
              

            if($quotation['insurance'] =='yes')
            {
                if($rs['tipe_produk'] =='barang')
                {
                    $harga_premi  = $premi/100*$aa;
                    $harga_retail = $harga_premi*$tariff_ppn_1/0.7;
                    
                }else
                {
                    $harga_premi="0";
                    $harga_retail="0";
                }
            }else
            {
                $harga_premi="0";
                $harga_retail="0";
            }

            $cc = $cc+$harga_retail;


            $best = number_format($cc);
            $a    = str_replace(',', '', $best);
            $hrgs = substr($a,-3);
            $hrg  = substr($a, 0, -3);
            $hrg1 = $hrg."000";
            $hrg1 = $hrg1+1000;


            if($discount_persen =='100')
            {
                $hrg1 = $hrg1-1000;
            }
   
            $d = $hrg1;

        


            $best_price_roundup = $d+$kode_sales;
            $best_price = $best_price_roundup;

            $current = $harga_pricelist+$total_delivery_cost+$harga_retail;
        

            $selisih = $best_price-$current;


            //baruuu
       
            if($selisih >='0')
            {
                $persen  = $selisih/$current*100;
                $persen  = round($persen,2);

                array_push($surplus,$selisih);
                array_push($persen_plus,$persen);

                $ver = "<b><span style='color:green'>(Price Verified, Stock : ".$ready." Unit)<br>
                        * sold : Rp " . number_format($best_price,2,',',',')." ; Current nett Price 
                        Rp ".number_format($current,2,',',',')." ; Surplus :  Rp " . 
                        number_format($selisih,2,',',',')." ( ".$persen."% )</span></b>";
            }else
            {
                $persen  = $selisih/$current*100;
                $persen  = round($persen,2);

                array_push($minus,$selisih);
                array_push($persen_minus,$persen);


                $ver = "<b><span style='color:red'>(Price Not Verified, Stock : ".$ready." Unit)<br>
                        * sold : Rp " . number_format($best_price,2,',',',')." ; Current nett Price
                        Rp ".number_format($current,2,',',',')." ; Minus : - Rp " . 
                        number_format($selisih,2,',',',')." ( ".$persen."% )</span></b>";
            }

            $psn .= "<span style='color:black'>". $rs['product_id']." - ".$rs['nama_produk'] ." x ".$rs['quantity']." Unit </span>".$ver."<br>";

            array_push($current_nett_price,$harga_pricelist);
            array_push($sold, $best_price);
            array_push($dlv_cost,$shipping);
            array_push($ship_insurance,$harga_retail);
            array_push($total_packing,$ttl_packing);
            array_push($total_current,$current);
        }

      

        $total_current_nett = array_sum($current_nett_price);
        $sum_minus          = array_sum($minus);
        $sum_minus          = $sum_minus+$komisi_value;
        $sum_persen_minus   = array_sum($persen_minus);
        $sum_persen_plus    = array_sum($persen_plus);
        $sum_suplus         = array_sum($surplus);
        $total_transaction  = array_sum($sold);
        $total_shipping     = array_sum($dlv_cost);
        $ttl_insurance      = array_sum($ship_insurance);
        $harga_packing      = array_sum($total_packing);

        $ttl_current      = array_sum($total_current);

    
        $diff =datediff(date('Y-m-d H:i:s'),$created);
        $days = $diff['days'];

        if($days >'7')
        {
            $vld = "not Valid";
        }else
        {
            $vld ="Valid";
        }

        $getkurss = $this->get_kurs('USD');
        $kurss     = $getkurss;
        $kurss1    = str_replace(".", "", $kurss);
        $kurss1    = substr($kurss1,0,-2);


        $cek_setting ="SELECT * FROM tbl_history_kurs_setting WHERE kurs ='USD' ORDER BY id DESC LIMIT 1";
        $setting = $this->db->query($cek_setting);
        $info_setting = $setting->row_array();

        if(empty($info_setting) OR $info_setting['type_currency'] =='floating')
        {
                $sql2 = "SELECT * FROM tbl_kurs WHERE currency  = 'USD' ORDER BY id DESC";
                $query2 = $this->db->query($sql2);
                $infokurs = $query2->row_array();

                $sqls ="SELECT * FROM tbl_kurs_multiply_floating WHERE currency ='USD' ORDER BY id DESC LIMIT 1";
                $res = $this->db->query($sqls)->row_array();
                $multiply = $res['multiply'];

                if($multiply)
                {
                    $nilai_tukar =  $infokurs['kurs']*$multiply/100;
                }else
                {
                    $nilai_tukar =  $infokurs['kurs'];
                }

        }else
        {
                $sql2 = "SELECT * FROM tbl_kurs_fixed WHERE kurs ='USD' ORDER BY id DESC LIMIT 1";
                $query2 = $this->db->query($sql2);
                $infokurs = $query2->row_array();
                $nilai_tukar =  $infokurs['currency'];
        }
        $kurss1 = $nilai_tukar;

        $persen_plus1  = $sum_suplus/$total_transaction*100;
        $persen_minus1 = $sum_minus/$total_transaction*100;

        $psn .="<br><span style='color:black'> Quotation Date : ".date('d-m-Y H:i:s',strtotime($created))." (".$days."D - ".$vld.")</span><br>";

        $psn .="<span style='color:black'> Current Currency Rate : 1 USD = Rp. ".number_format($kurss1,2,',',',')."</span><br>";

        $psn .="<span style='color:black'> Price Term : ".$price_term."</span><br>";
        $psn .="<span style='color:black'> Delivery Time : ".$delivery_time." ".$delivery_period."s</span><br><br>";



        $psn  .="<span style='color:black'>Refferal Commision (Minus) : Rp. ".number_format($komisi_value,2,',',',')." / ".$komisi_persen."% </span><br>";

        $psn  .="<span style='color:black'>Refferal Commision Received by Customer : Rp. ".number_format($komisi_value_no_ppn,2,',',',')." / ".$komisi_persen."% </span><br>";

        $psn  .="<span style='color:black'>Shipping : Rp. ".number_format($total_shipping,2,',',',')."</span><br>";

        // $psn  .="<span style='color:black'>Ship Insurance : Rp. ".$ttl_insurance."</span><br>";

        $psn  .="<span style='color:black'>Packing : Rp. ".number_format($harga_packing,0,',',',')."</span><br><br>";

        $ttl = $total_transaction+$total_shipping+$ttl_insurance+$harga_packing;

        $ttl1 = $total_transaction-$komisi_value-$ttl_current;
        $ttl2 = $ttl_current+$komisi_value;



        if($ttl1 >='0')
        {

            $prsn = $ttl1/$ttl2*100;
            $psn .="<b><span style='color:green;'>Surplus : Rp. ". number_format($ttl1,2,',',',')." (".number_format($prsn,2)."%)</span></b><br>";

            $warning ='no';

        }else
        {   
            $prsn = $ttl1/$ttl2*100;
            $psn .="<b><span style='color:red;'>Minus : Rp. ". number_format($ttl1,2,',',',')." (".number_format($prsn,2)."%)</span></b><br>";

            $warning = 'yes';
        }

        $ttl = $sum_suplus-$sum_minus;

        $pesan = $psn;

        return $pesan;
    }

    public function request_exception($crm_id)
    {
        $quotation_id = $this->input->post('quotation_id');
        $msg = $this->input->post('msg');
        
        $log = array(
                'crm_id'        => $crm_id,
                'date_created'  => date('Y-m-d H:i:s'),
                'crm_type'      => 'request_exception',
                'user_id'       => $_SESSION['myuser']['karyawan_id'],
            );
        $this->db->insert('tbl_crm_log', $log);
        $log_id = $this->db->insert_id();

        $msg ="Request Exception Quotation <br> Alasan :".$msg;
        $pesan = array(
                'crm_id'       => $crm_id,
                'log_crm_id'   => $log_id,
                'sender'       => $_SESSION['myuser']['karyawan_id'],
                'pesan'        => $msg,
                'date_created' => date('Y-m-d H:i:s'),           
            );
        $this->db->insert('tbl_crm_pesan', $pesan);
        $psn_id = $this->db->insert_id();

        $load_type = 'exception';
        $this->generateQuotation($load_type,$quotation_id);

    }

    public function approval_komisi($crm_id)
    {
        $quotation_id = $this->input->post('quotation_id');


        if(in_array($_SESSION['myuser']['position_id'],array("1,","2","77","88","89","90","91","92","93","100")))
        {
            $type_log ="pesan";
        }else
        {
            $type_log = "Verifikasi Quotation";
        }

        $log = array(
                'crm_id'        => $crm_id,
                'date_created'  => date('Y-m-d H:i:s'),
                'crm_type'      => $type_log,
                'user_id'       => $_SESSION['myuser']['karyawan_id'],
            );
        $this->db->insert('tbl_crm_log', $log);
        $log_id = $this->db->insert_id();

        $msg = $this->verifikasi($quotation_id);

        $pesan = array(
                'crm_id'       => $crm_id,
                'log_crm_id'   => $log_id,
                'sender'       => $_SESSION['myuser']['karyawan_id'],
                'pesan'        => $msg,
                'date_created' => date('Y-m-d H:i:s'),           
            );
        $this->db->insert('tbl_crm_pesan', $pesan);
        $psn_id = $this->db->insert_id();

        if(!in_array($_SESSION['myuser']['position_id'],array("1,","2","77","88","89","90","91","92","93","100")))
        {

            $logs = array(
                    'crm_id'        => $crm_id,
                    'date_created'  => date('Y-m-d H:i:s'),
                    'log_id'        => $log_id,
                    'quotation_id'  => $quotation_id,
                    'user_created'  => $_SESSION['myuser']['karyawan_id'],
                );
            $this->db->insert('tbl_crm_quotation_approval', $logs);
            $load_type = 'exception';
        }else
        {
            $load_type ='send';
        }

        
        $this->generateQuotation($load_type,$quotation_id);

    }

    public function getBranchList()
    {
        $sql = "SELECT * FROM tbl_cabang";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        $list = $query->result_array();
    
        return $list;

    }

    public function getLetterHeaderId($quotation_id, $id_cabang)
    {
        $sql = "SELECT tbl_quotation_product.brand_id FROM tbl_quotation_item 
        JOIN tbl_quotation_product ON tbl_quotation_product.id = tbl_quotation_item.product_id 
        WHERE tbl_quotation_item.quotation_id = '$quotation_id' AND tbl_quotation_item.type_produk = 'Primary' ORDER BY tbl_quotation_item.display_order, tbl_quotation_item.id LIMIT 1";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        $item = $query->row_array();

        $brand_id = $item['brand_id'];

        $sql = "SELECT * FROM tbl_quotation_letter_header WHERE brand_id = '$brand_id' AND branch_id = '$id_cabang'";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        $list = $query->row_array();

        $headerimage = $list['id'];

        return $headerimage;
    }


    public function getLetterHeader($id)
    {
        $sql = "SELECT * FROM tbl_quotation_letter_header WHERE id = '$id'";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        $list = $query->row_array();
    
        return $list;

    }

    public function getPremi()
    {
        $sql ="SELECT * FROM tbl_freight_insurance_premi";
        $data = $this->db->query($sql)->row_array();

        return $data;
    }

    public function getppn()
    {
        $sql ="SELECT * FROM tbl_tariff_ppn";
        $ress = $this->db->query($sql)->row_array();

        $ppn = $ress['ppn'];
        $ppn = $ppn/100+1;

        return $ppn;
    }

    public function getTarifppn()
    {
        $sql ="SELECT * FROM tbl_tariff_ppn";
        $ress = $this->db->query($sql)->row_array();

        $ppn = $ress['ppn'];

        return $ppn;
    }


    public function getProductStock($product_id,$quantity,$item_id)
    {
        $file_url = $this->config->item('file_url');


        if(!empty($item_id))
        {
            $sql ="SELECT * FROM tbl_quotation_item WHERE id='$item_id'";
            $data = $this->db->query($sql)->row_array();
            $product_id = $data['product_id'];
        }

        $quantity_quotation = $quantity;
    
        $sql = "SELECT * FROM tbl_quotation_product WHERE id = '$product_id' AND publish = '0'";
        $query = $this->db->query($sql);
        $detailproduct = $query->row_array();


        $stock  = $this->masterproduk->getProdukStock($product_id);
        $import = $this->masterproduk->getImport($product_id);

        if (isset($stock[$product_id]['all']['total']))
        $total = $stock[$product_id]['all']['total'];
        else
        $total = 0;
    
        if (isset($stock[$product_id]['all']['ready_booked']))
        $ready_booked = $stock[$product_id]['all']['ready_booked'];
        else
        $ready_booked = 0;
    
        if (isset($stock[$product_id]['all']['not_ready']))
        $not_ready = $stock[$product_id]['all']['not_ready'];
        else
        $not_ready = 0;
    
        if (isset($stock[$product_id]['all']['booked']))
        $bookeds = $stock[$product_id]['all']['booked'];
        else
        $bookeds = 0;
    
        if (isset($stock[$product_id]['all']['ordered']))
        $ordered = $stock[$product_id]['all']['ordered'];
        else
        $ordered = 0;
    
        $ready = $ready_booked - $bookeds;
        if ($ready < 0)
        $ready = 0;

    

        $sts_stock ='';
        $quo =$quantity_quotation;
        $stcks = $ordered-$bookeds;



        // get IMPORT
        foreach ($import as $key => $imp) 
        {
            $import_sblm = $import[0];
            $jumlah_sblm = $import_sblm['ship_qty'];
            
            if($key =='0')
            {
                $arrv = date('d-m-Y',strtotime($imp['arrival']));
            }
        } 

      


        // READY
        $sts_ready="";

        if($ready <='0')
        {
            $sts_ready ="";

            if($ready >= $quo)
            {
                $sts_ready ="";
            }else
            {
                $sts_ready ="Ready ".$ready;
            }

            if($ready=='0' AND $ordered=='0' AND $bookeds=='0')
            {
                $sts_ready ="Not Ready Stock";
            }else
            {   

                $sts_ready="";
            }
     
        }else
        {
            if($ready >= $quo)
            {
                $sts_ready ="Ready Stock";
            }else
            {
                $sts_ready ="Ready ".$ready;
            }
        }

        if($sts_ready !='Not Ready Stock')
        {
            // Arrival
            $sts_arrival ="";

            if($sts_ready == "Ready Stock")
            {
                $sts_arrival ="";
            }else
            {
                if($stcks >'0' AND $sts_ready !="")
                {
                    $sts_arrival=" + Arr ".$stcks;
                }

                if($stcks > '0' AND $sts_ready =='')
                {
                    $sts_arrival =" Arrival ".$arrv ." ".$stcks;
                }

                if($stcks < $quo AND $stcks <'0')
                {
                    $sts_arrival="";
                
                }
            }



            // hitung indent
            $htg =$quo-$ready-$ordered+$bookeds;

            if($htg<='0')
            {
                $indent ="0";
            }else
            {
                $indent = " ".$htg;
            }


            // indent
            if($indent <="0")
            {
                $sts_indent="";
            }else
            {   
                
                if(empty($sts_ready) AND empty($sts_arrival))
                {
                    $sts_indent ="Not Ready Stock";
                }else
                {   
                    $sts_indent =" + Indent ".$indent;

                }
            }

        }else
        {
            $sts_arrival="";
            $sts_indent="";
        }
        

        $sts_stock =$sts_ready."".$sts_arrival."".$sts_indent;

        $keterangan_stock = $sts_stock;

        $keterangan_stock = $keterangan_stock;

        return $keterangan_stock;
    }
    
}