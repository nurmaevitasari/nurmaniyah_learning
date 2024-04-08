<?php
defined('BASEPATH') OR exit('No direct script access allowed');
  
class Quotation_model extends CI_Model {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();

        $user = $this->session->userdata('myuser');

        if(!isset($user) or empty($user))
        {
            redirect('c_loginuser');
        }
    }
 
 	public function getProductDetail($product_id)
	{
		$sql = "SELECT * FROM tbl_quotation_product WHERE id  = '$product_id'";
		$query = $this->db->query($sql);
		$detailproduct = $query->row_array();
		
		$detailproduct['imglink'] = "https://myiios.net/test.jpg";
		
		$currency_produk = $detailproduct['currency'];
		
		if ($currency_produk != 'IDR')
		{
			$sql2 = "SELECT * FROM tbl_kurs WHERE currency  = '$currency_produk' ORDER BY id DESC";
			$query2 = $this->db->query($sql2);
			$infokurs = $query2->row_array();
			
			$nilai_tukar =  str_replace(".00","",$infokurs['kurs']);
			$nilai_tukar =  str_replace(".","",$nilai_tukar);
			$detailproduct['nilai_tukar'] = $nilai_tukar;
			$detailproduct['harga_produk'] = $detailproduct['harga'] * $nilai_tukar;
		}	
		else
		{
			$detailproduct['harga_produk'] = $detailproduct['harga'];
		}
		
		return $detailproduct;
	}
 
    public function addItem()
	{
		$sales_id       = $_SESSION['myuser']['karyawan_id'];
        $sales_username = $_SESSION['myuser']['username'];
        
		$crm_id         = $this->input->post('crm_id');
       	$product_id     = $this->input->post('product_id');
		
		$detailproduct 	= $this->quotation->getProductDetail($product_id);
		
		$currency	 	= $detailproduct['currency'];
		$unit_price 	= $detailproduct['harga'];
		$rupiah_price 	= $detailproduct['harga_produk'];
		
        $item_quantity  = $this->input->post('item_quantity');
        $item_discount  = $this->input->post('item_discount');
		if (empty($item_discount))
		$item_discount = 0;

		$total_price 	= $rupiah_price * $item_quantity;
		$best_price 	= $total_price - $item_discount;
		
		$sql = "SELECT id FROM tbl_crm WHERE id = '$crm_id'";
		$query = $this->db->query($sql);
		$num = $query->num_rows();
		
		//hanya diproses jika crm ditemukan	
		if ($num > 0)
		{	
			//cek apakah sudah ada id quotationnya, jika blm diinsert dulu
			$sql2 = "SELECT * FROM tbl_quotation WHERE crm_id = '$crm_id' AND sales_id = '$sales_id' AND status = 'draft'";
			$query2 = $this->db->query($sql2);
			$num2 = $query2->num_rows();
			
			if ($num2 > 0)
			{
				$quote = $query2->row_array();
				$quotation_id = $quote['id'];
			}
			else
			{
				$insert_quote = array(
					'crm_id'  	=> $crm_id,
					'sales_id'  => $sales_id,
					'created'  	=> date("Y-m-d H:i:s"),
					'author'    => $sales_username,
				);
			 
				$this->db->insert('tbl_quotation', $insert_quote);
				$quotation_id = $this->db->insert_id();
			}
			
			$insert = array(
				'quotation_id'  => $quotation_id,
				'product_id'    => $product_id,
				'unit_price'	=> $unit_price,
				'currency'		=> $currency,
				'rupiah_price'  => $rupiah_price,
				'quantity'      => $item_quantity,
				'total_price'	=> $total_price,
				'discount'		=> $item_discount,
				'best_price'	=> $best_price,
			);
		 
			$this->db->replace('tbl_quotation_item', $insert);
		}
	}	
}