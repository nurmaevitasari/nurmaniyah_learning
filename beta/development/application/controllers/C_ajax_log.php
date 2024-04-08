<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class C_ajax_log extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_ajax_log');
		$this->load->helper('url');

        $user = $this->session->userdata('myuser');
        
        if(!isset($user) or empty($user))
        {
            redirect('c_loginuser');
        }
    }
 
    public function index()
    {
		$this->load->model('m_ajax_log');
	
		if (isset($_SERVER['REMOTE_ADDR']))
		$ip_address = $_SERVER['REMOTE_ADDR'];
		else
		$ip_address = "unknown";
		
		if (isset($_SERVER['REQUEST_URI']))
		$url = urldecode(str_replace("/index.php/c_ajax_log?url=","",$_SERVER['REQUEST_URI']));
		else
		$url = "unknown";
		
		
		if (isset($_SESSION['myuser']))
		{
			$myuser_username = $_SESSION['myuser']['username'];
			if (isset($_SESSION['myuser']['logintype']))
			$logintype = $_SESSION['myuser']['logintype'];
			else
			$logintype = "";
		}
		else
		{
			$myuser_username = "";
			$logintype = "";
		}
		
		
		if (isset($_SERVER['HTTP_USER_AGENT']))
		$browser = $_SERVER['HTTP_USER_AGENT'];
		else
		$browser = "unknown";
		
		if (isset($_SERVER['HTTP_REFERER']))
		$referrer = $_SERVER['HTTP_REFERER'];
		else
		$referrer = "";
		
		$warning = "";
		
		if (!empty($myuser_username))
		{
			$this->load->model('m_ajax_log');
	
			$prevdata['result'] = $this->m_ajax_log->get_latest_data($myuser_username);
			
			$prev_session_username = $prevdata['result'][0]['session_username'];
			$prev_browser = $prevdata['result'][0]['browser'];
			$prev_ip = $prevdata['result'][0]['ip_address'];
			
			if (($prev_session_username == $myuser_username) AND ($prev_ip != $ip_address))
			$warning = "Different IP Address"; 
			
			if (($prev_session_username == $myuser_username) AND ($prev_ip != $ip_address) AND ($prev_browser != $browser)) 
			$warning .= ", "; 
			
			if (($prev_session_username == $myuser_username) AND ($prev_browser != $browser))
			$warning .= "Different Browser "; 
		}

	
		$args = array(
			'ip_address' => $ip_address,
			'session_username'	=> $myuser_username,
			'logintype'	=> $logintype,
			'url_accessed'	=> $url,
			'referrer'		=> $referrer,
			'browser' => $browser,
			'notes' => 'View Link/Page',
			'warning' => $warning

			);
		
		
		$this->m_ajax_log->input_data('log_akses', $args);

	}
	
	public function button()
    {
		if (isset($_SERVER['REMOTE_ADDR']))
		$ip_address = $_SERVER['REMOTE_ADDR'];
		else
		$ip_address = "unknown";
		
		if (isset($_SERVER['REQUEST_URI']))
		$url = urldecode(str_replace("/index.php/c_ajax_log?url=","",$_SERVER['REQUEST_URI']));
		else
		$url = "unknown";
		
		$getbtn = explode('button?btnname=',$url);
		$button_name = $getbtn[1];
		
		if (isset($_SESSION['myuser']))
		{
			$myuser_username = $_SESSION['myuser']['username'];
			if (isset($_SESSION['myuser']['logintype']))
			$logintype = $_SESSION['myuser']['logintype'];
			else
			$logintype = "";
		}
		else
		{
			$myuser_username = "";
			$logintype = "";
		}
		
		if (isset($_SERVER['HTTP_USER_AGENT']))
		$browser = $_SERVER['HTTP_USER_AGENT'];
		else
		$browser = "unknown";
		
		if (isset($_SERVER['HTTP_REFERER']))
		$referrer = $_SERVER['HTTP_REFERER'];
		else
		$referrer = "";
		
		$warning = "";
		
		if (!empty($myuser_username))
		{
			$this->load->model('m_ajax_log');
	
			$prevdata['result'] = $this->m_ajax_log->get_latest_data($myuser_username);
			
			$prev_session_username = $prevdata['result'][0]['session_username'];
			$prev_browser = $prevdata['result'][0]['browser'];
			$prev_ip = $prevdata['result'][0]['ip_address'];
			
			if (($prev_session_username == $myuser_username) AND ($prev_ip != $ip_address))
			$warning = "Different IP Address"; 
			
			if (($prev_session_username == $myuser_username) AND ($prev_ip != $ip_address) AND ($prev_browser != $browser)) 
			$warning .= ", "; 
			
			if (($prev_session_username == $myuser_username) AND ($prev_browser != $browser))
			$warning .= "Different Browser "; 
		}

	
		$args = array(
			'ip_address' => $ip_address,
			'session_username'	=> $myuser_username,
			'logintype'	=> $logintype,
			'url_accessed'	=> $url,
			'referrer'		=> $referrer,
			'browser' => $browser,
			'notes' => 'Button Clicked : '.$button_name,
			'warning' => $warning

			);
		
		$this->load->model('m_ajax_log');
		$this->m_ajax_log->input_data('log_akses', $args);

	}
	
	public function form()
    {
		if (isset($_SERVER['REMOTE_ADDR']))
		$ip_address = $_SERVER['REMOTE_ADDR'];
		else
		$ip_address = "unknown";
		
		if (isset($_SERVER['REQUEST_URI']))
		$url = urldecode(str_replace("/index.php/c_ajax_log?url=","",$_SERVER['REQUEST_URI']));
		else
		$url = "unknown";
		
		if (isset($_SESSION['myuser']))
		{
			$myuser_username = $_SESSION['myuser']['username'];
			if (isset($_SESSION['myuser']['logintype']))
			$logintype = $_SESSION['myuser']['logintype'];
			else
			$logintype = "";
		}
		else
		{
			$myuser_username = "";
			$logintype = "";
		}
		
		if (isset($_SERVER['HTTP_USER_AGENT']))
		$browser = $_SERVER['HTTP_USER_AGENT'];
		else
		$browser = "unknown";
		
		if (isset($_SERVER['HTTP_REFERER']))
		$referrer = $_SERVER['HTTP_REFERER'];
		else
		$referrer = "";
		
		$warning = "";
		
		if (!empty($myuser_username))
		{
			$this->load->model('m_ajax_log');
	
			$prevdata['result'] = $this->m_ajax_log->get_latest_data($myuser_username);
			
			$prev_session_username = $prevdata['result'][0]['session_username'];
			$prev_browser = $prevdata['result'][0]['browser'];
			$prev_ip = $prevdata['result'][0]['ip_address'];
			
			if (($prev_session_username == $myuser_username) AND ($prev_ip != $ip_address))
			$warning = "Different IP Address"; 
			
			if (($prev_session_username == $myuser_username) AND ($prev_ip != $ip_address) AND ($prev_browser != $browser)) 
			$warning .= ", "; 
			
			if (($prev_session_username == $myuser_username) AND ($prev_browser != $browser))
			$warning .= "Different Browser "; 
		}

	
		$args = array(
			'ip_address' => $ip_address,
			'session_username'	=> $myuser_username,
			'logintype'	=> $logintype,
			'url_accessed'	=> $url,
			'referrer'		=> $referrer,
			'browser' => $browser,
			'notes' => 'Submit Form',
			'warning' => $warning

			);
		
		$this->load->model('m_ajax_log');
		$this->m_ajax_log->input_data('log_akses', $args);

	}


}