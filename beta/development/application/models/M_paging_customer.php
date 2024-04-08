<?php


 class M_paging_customer extends CI_Model  {
 
  
  function view($num, $offset)  {
  
  /*variable num dan offset digunakan untuk mengatur jumlah
    data yang akan dipaging, yang kita panggil di controller*/
  
  $query = $this->db->get("tbl_customer",$num, $offset);
  return $query->result();
  
  }
 }

?>
