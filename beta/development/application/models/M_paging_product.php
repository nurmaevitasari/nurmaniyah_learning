<?php


 class M_paging_product extends CI_Model  {
 
  
  function view($num, $offset)  {
  
  /*variable num dan offset digunakan untuk mengatur jumlah
    data yang akan dipaging, yang kita panggil di controller*/
  
  $query = $this->db->get("tbl_product",$num, $offset);
  return $query->result();
  
  }
 }
