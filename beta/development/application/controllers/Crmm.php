<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Crm extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Crm_model','crm');

        $user = $this->session->userdata('myuser');
        
        if(!isset($user) or empty($user))
        {
            redirect('c_loginuser');
        }
    }
 
    public function index()
    {
        $this->load->helper('url');
        $data['view'] = 'content/crm/index';
        $this->load->view('template/home', $data);
    }

    public function details($id)
    {
        $data['crm']    = $this->crm;
        $data['selKar'] = $this->crm->selKaryawan();
        $data['ketentuan']  = $this->crm->getKetentuan($id);
        $data['contributor'] = $this->crm->getContributor($id);
        $data['detail'] = $this->crm->getDetail($id);
        $data['files'] = $this->crm->getFiles($id);
        $data['log'] = $this->crm->getLog($id);
        $data['karyawan'] = $this->crm->getKaryawan($id);
        $data['link'] = $this->crm->getLink($id);
        $data['grplink'] = $this->crm->getGroupLink($id);
        $data['changesales'] = $this->crm->getChangeSales($id); 
        $data['con_published'] = $this->crm->CheckContributor($id);
        $data['gethighlight'] = $this->crm->gethighlight($id);
        
        $data['view'] = 'content/crm/content_detail_crm';
        $this->load->view('template/home', $data);
    }

    public function add()
    {
        if($this->input->post())
        {
            //$this->crm->addData();
            $html = "<div class='alert alert-success' style='font-size: 14px;'>
                        <span class='fa fa-check-circle fa-lg'></span> Data prospek baru berhasil ditambahkan.
                        <span class='close' data-dismiss='alert' aria-label='close'>&times;</span>
                    </div>";
            $this->session->set_flashdata('message', $html);

            redirect('crm/details/'.$this->crm->addData());
        }

        $data['employee'] = $this->crm->getEmployee();
        $data['view'] = 'content/crm/form_new_crm';
        $this->load->view('template/home', $data);
    }
 
    public function ajax_list($cons='')
    {
  
        $list = $this->crm->get_datatables($cons);
        $data = array();
        //$no = $_POST['start'];
        $no = $this->crm->count_all($cons)+1;
        foreach ($list as $crm) {
            $no--;
            $row = array();
            $row[] = $no;
            $row[] = '<span style="display: none;">'.$crm->date_closed.'</span>'.date('d-m-Y H:i:s', strtotime($crm->date_closed));
            $row[] = $crm->id;
            $row[] = '<span style="display: none;">'.$crm->date_created.'</span>'.date('d-m-Y H:i:s', strtotime($crm->date_created)).'<br><b>'.strtoupper($crm->divisi).' - '.$crm->nickname.'</b>';
            $row[] = $crm->perusahaan.'<br>'.$crm->pic;
            $row[] = $crm->prospect.'<br> Competitor : '.$crm->competitor.'<br>'.$this->getStatusLinkCRM($crm).'<br> <span style="background-color : red; color : white;"> '.$crm->status_cancel.' </span>'.$this->getLinkModul($crm);
            $row[] = $this->getProgress($crm);
            $row[] = $this->getValue($crm, $cons);
            $row[] = '<span style="display: none;">'.$crm->last_followup.'</span>'.date('d-m-Y H:i:s', strtotime($crm->last_followup));
            $row[] = $this->getStatusApproval($crm);
            $row[] = '<center><a target="_blank" href="'.site_url("crm/details/".$crm->id).'" class="btn btn-default btn-sm" style="margin-bottom: 2px;"> Detail</a></center>';
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->crm->count_all($cons),
                        "recordsFiltered" => $this->crm->count_filtered($cons),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    private function getLinkModul($args)
    {
        $crm = $args;
        $str = '';

        if($crm->link_modul == '2' AND $crm->link_modul_id) {
            $str .= 'Delivery By : <a target="_blank" href="'.site_url("c_delivery/details/".$crm->link_modul_id).'">Delivery ID '.$crm->link_modul_id.'</a>';
           }
        return $str;    
    }

    private function getProgress($args)
    {
        $crm = $args;
        $str = '';
        $x = $crm->date_closed;
        $y = $crm->date_created;
        $z = date('Y-m-d H:i:s');

        $str .= '<div class="progress">';
        
        if($crm->progress == 'Introduction') {
            $str .='<div class="progress-bar progress-bar-Introduction" role="progressbar" style="width:25%"></div>'; 

        }else if($crm->progress == 'Quotation') {
            $str .= '<div class="progress-bar progress-bar-Introduction" role="progressbar" style="width:25%"></div>';
            $str .= '<div class="progress-bar progress-bar-Quotation" role="progressbar" style="width:25%"></div>';

        }else if($crm->progress == 'Negotiation') {
            $str .= '<div class="progress-bar progress-bar-Introduction" role="progressbar" style="width:25%"></div>';
            $str .= '<div class="progress-bar progress-bar-Quotation" role="progressbar" style="width:25%"></div>';
            $str .= '<div class="progress-bar progress-bar-Negotiation" role="progressbar" style="width:25%"></div>';
        
        }else if ($crm->progress == 'Deal') {
            $str .= '<div class="progress-bar progress-bar-Introduction" role="progressbar" style="width:25%"></div>';
            $str .= '<div class="progress-bar progress-bar-Quotation" role="progressbar" style="width:25%"></div>';
            $str .= '<div class="progress-bar progress-bar-Negotiation" role="progressbar" style="width:25%"></div>';
            $str .= '<div class="progress-bar progress-bar-Deal" role="progressbar" style="width:25%"></div>';
        }
        
        $str .= '</div>';

        if($crm->status_closed == 'Loss' AND $crm->date_closed != '0000-00-00 00:00:00') {
            $str .= "<b style='color : red; '>Loss Stage</b>  <br>";
        }elseif($crm->status_closed == 'Deal' AND $crm->date_closed != '0000-00-00 00:00:00') {
            $str .= $crm->progress." Stage <br>"; 
        }else {
            $str .= $crm->progress." Stage <br>";
            
            $x = $z;
        }

            $diff = datediff($x, $y);
            $str .= $diff['days_total']." Days"; 

        return $str;
    }

    private function getValue($args, $cons)
    {
        $crm = $args;
        $str ='';

        if($cons == 'Deal') {
            $str .= "Rp. ".number_format($crm->deal_value, "0", ",", ".")."<br> Posibilities : ".$crm->posibilities."%";
        }else {
            $str .= "Rp. ".number_format($crm->prospect_value, "0", ",", ".")."<br> Posibilities : ".$crm->posibilities."%";
        }

        return $str;
    }

    private function getStatusApproval($args)
    {
        $crm = $args;
        $str = '';

        switch ($crm->progress_sts) {
            case '1':
                $str = '<span style="color : red;">Waiting for Approval</span>';
                break;
            case '2':
                $str = '<b style="color : green;">Approved</b>';
                break;
            case '3':
                $str = '<b style="color : red;">Not Approved</b>';
                break;
        }

        return $str;
    }

    private function getStatusLinkCRM($args)
    {
         $crm = $args;
         $str = '';

         $str .= "<b> Status : </b> ";
         switch ($crm->status_show) {
             case 'Undelivered':
                 $str .= "<b style='color : red;'> Undelivered </b>";
                 break;
             case 'Delivery':
                 $str .= "<b style='color : orange;'> Delivery </b>";
                 break;
             case 'SPS on Working':
                 $str .= "<b style='color : orange;'> SPS on Working </b>";
                 break;    
             case 'On Project':
                 $str .= "<b style='color : orange;'> On Project </b>";
                 break;
             case 'Finished':
                 $str .= "<b style='color : green;'> Finished </b>";
                 break;    
            default : 
                 $str .= "-";
                 break;
         }

         return $str;
    }

    public function add_customer()
    {
        echo json_encode($this->crm->add_customer());
    }

    public function addNotes()
    {
        $this->crm->addNotes();
    }

    public function addContributor()
    {
        $this->crm->addContributor();
        $id = $this->input->post('crm_id');
        redirect('crm/details/'.$id);
    }

    public function FollowUp()
    {
        $this->crm->FollowUp();
        $id = $this->input->post('crm_id');
        redirect('crm/details/'.$id);
    }

    public function UpProgress()
    {
        $this->crm->addProgress();
        $id = $this->input->post('crm_id');
        redirect('crm/details/'.$id);
    }

    public function add_pesan()
    {
        if($this->input->post())
        {
            $this->crm->add_pesan();
            
            $id = $this->input->post('crm_id');
            redirect('crm/details/'.$id);
        }
    }

    public function uploadFile()
    {
        if($this->input->post())
        {
            $id = $this->input->post('crm_id');
            $this->crm->uploadfiles($id);
            redirect('crm/details/'.$id);
        }
    }

    public function CloseCRM($id)
    {
        if($this->input->post())
        {
            $id = $this->input->post('crm_id');
            $this->crm->uploadfiles($id);
            
        }
        redirect('crm/details/'.$id);
    }

    public function edit($id)
    {
        $data['contributor'] = $this->crm->getContributor($id);
        $data['edit'] = $this->crm->getDetail($id);
        $data['karyawan'] = $this->crm->getKaryawan($id);
        $data['view'] = 'content/content_edit_crm';
        $this->load->view('template/home', $data);
    }

     public function ApprovalProgress($type, $crm_id, $appr_id, $log_id ='')
    {
        $this->crm->ApprovalProgress($type, $crm_id, $appr_id, $log_id);

        redirect('crm/details/'.$crm_id);
    }

    public function ChangeSales()
    {
        redirect('crm/details/'.$this->crm->ChangeSales());
    }

    public function Uploadhighlight()
    {
        if($this->input->post())
        {
            $id = $this->input->post('crm_id');
            $this->crm->Uploadhighlight();

            redirect('Crm/details/'.$id);
        }   
    }

    public function NotesHighlight()
    {
        $id = $this->input->post('crm_id');
        $this->crm->Highlight_fin();

        redirect('Crm/details/'.$id);
    }

    public function linkTodel($crm_id)
    {
        $sql = "SELECT id, divisi, deal_value, if(customer_type = '1', customer_id, '0') as customer_id, customer_type FROM tbl_crm WHERE id = $crm_id";
        $row_arr = $this->db->query($sql)->row_array();

        $arr = array(
            'id' => $row_arr['id'],
            'divisi' => $row_arr['divisi'],
            'deal_value' => $row_arr['deal_value'],
            'customer_id' => $row_arr['customer_id'],
            'customer_type' => $row_arr['customer_type'],
            'modul' => '8',
        );

        $this->session->set_userdata('sess_crm_id', $arr);
        redirect('C_delivery/add/delv');
    }

    public function linkToSPS($crm_id)
    {
        $sql = "SELECT id, divisi, deal_value, if(customer_type = '1', customer_id, '0') as customer_id, customer_type FROM tbl_crm WHERE id = $crm_id";
        $row_arr = $this->db->query($sql)->row_array();

        $this->session->set_userdata('sess_crm_id', $row_arr);
        redirect('C_new_sps/add');
    }

    public function linkToProject($crm_id)
    {
        $sql = "SELECT id, divisi, if(customer_type = '1', customer_id, '0') as customer_id, customer_type FROM tbl_crm WHERE id = $crm_id";
        $row_arr = $this->db->query($sql)->row_array();

        $this->session->set_userdata('sess_crm_id', $row_arr);
        redirect('Project/add');
    }

    public function linkToSPSDemo($crm_id)
    {
        $sql = "SELECT id, divisi, deal_value, if(customer_type = '1', customer_id, '0') as customer_id, customer_type FROM tbl_crm WHERE id = $crm_id";
        $row_arr = $this->db->query($sql)->row_array();

        $this->session->set_userdata('sess_crm_id', $row_arr);
        redirect('C_new_sps/addDemo');
    }

    public function linkToSPSSurvey($crm_id)
    {
        $sql = "SELECT id, divisi, deal_value, if(customer_type = '1', customer_id, '0') as customer_id, customer_type FROM tbl_crm WHERE id = $crm_id";
        $row_arr = $this->db->query($sql)->row_array();

        $this->session->set_userdata('sess_crm_id', $row_arr);
        redirect('C_new_sps/addSurvey');
    }
 
}

