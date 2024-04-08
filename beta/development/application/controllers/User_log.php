<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class User_log extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_userlog','userlog');
		
		
    }
 
    public function index()
    {
        $this->load->helper('url');
        $data['view'] = 'content/Access_log_view';
        $this->load->view('template/home', $data);
    }
 
    public function ajax_list()
    {
        $list = $this->userlog->get_datatables();
        $data = array();
		$user_prev_browser = array();
		$user_prev_ip = array();
        $no = $_POST['start'];
        foreach ($list as $logdata) {
    		$no++;
            $row = array();
			
			if ($logdata->logintype == 'Superuser')
			$logintype = "(Master Password)";
			else
			$logintype = "";
			
			if (!empty($logdata->warning))
			{
				$row[] = '<font color="red">'.$logdata->timestamp.'</font>';
				$row[] = '<font color="red">'.$logdata->session_username.'<br />'.$logintype.'</font>';
				
				if (($logdata->notes == 'View Link/Page') OR ($logdata->notes == ''))
				$row[] = '<font color="red">'.$logdata->notes.'</font><br /><a href="'.urldecode($logdata->url_accessed).'" target="_blank"><font color="red">'.urldecode($logdata->url_accessed).'</font></a>';
				else
				$row[] = '<font color="red">'.$logdata->notes.'</font>';

				$row[] = '<a href="'.urldecode($logdata->referrer).'" target="_blank"><font color="red">'.urldecode($logdata->referrer).'</font></a>';
				$row[] = '<font color="red">'.$logdata->browser.'</font>';
				$row[] = '<font color="red">'.$logdata->ip_address.'</font>';
				$row[] = '<font color="red">'.$logdata->warning.'</font>';
			}
			else
			{
				$row[] = $logdata->timestamp;
				$row[] = $logdata->session_username.'<br />'.$logintype;
				
				if (($logdata->notes == 'View Link/Page') OR ($logdata->notes == ''))
				$row[] = $logdata->notes.'<br /><a href="'.urldecode($logdata->url_accessed).'" target="_blank">'.urldecode($logdata->url_accessed).'</a>';
				else
				$row[] = $logdata->notes;


				$row[] = '<a href="'.urldecode($logdata->referrer).'" target="_blank">'.urldecode($logdata->referrer).'</a>';
				$row[] = $logdata->browser;
				$row[] = $logdata->ip_address;
				$row[] = $logdata->warning;
			}
				
			$data[] = $row;
           
			
	    }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->userlog->count_all(),
                        "recordsFiltered" => $this->userlog->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
}