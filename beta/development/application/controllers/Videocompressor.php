<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Videocompressor extends CI_Controller {

	public function __construct()
	{

		parent::__construct();
		$user = $this->session->userdata('myuser');

		if(!isset($user) or empty($user))
		{
			redirect('c_loginuser');
		}

    $this->load->library('video_lib');

	}

  public function index()
  {
      $data = array(
        'view' => 'content/videocompressor/index',
        'extra' => array(
          'css' => array(
            'plugins/fileupload/component.css',
          ),
          'js' => array(),
        ),
      );

      $this->load->view('template/home', $data);
  }

  public function compress()
  {
    $post = $this->input->post();

    $config['upload_path']          = FCPATH.'/assets/video/input/';
    $config['allowed_types']        = 'mp4|mpeg|avi';
    $config['file_name']        		= (!empty($post['filename'])) ? $post['filename'] : 'vid_'.date('ymdHis').'_'.rand(0,9999);
    //$config['encrypt_name']					= TRUE;

    $this->load->library('upload', $config);

    if ( ! $this->upload->do_upload('file1'))
    {
        $error = array('error' => $this->upload->display_errors());
        print_r($error);
        //$this->load->view('upload_form', $error);
    }
    else
    {
        $data = array('upload_data' => $this->upload->data());
        //var_dump($data);
        $config = array(
          'input_video_path' => $data['upload_data']['full_path'],
          'output_video_path' => FCPATH.'assets/video/output/',
          'new_file_name' => $data['upload_data']['raw_name'],
          'new_format' => !empty($post['video_format']) ? $post['video_format'] : $data['upload_data']['file_ext'],
        );

        $this->video_lib->initialize($config);
        if($this->video_lib->reduce())
        {
          $this->session->set_flashdata('alert_success', 'Your Video has been succesfully compressed.');
          redirect('videocompressor');
        }
        else
        {
          $this->session->set_flashdata('alert_failed', 'Failed to compress video, please try again.');
          redirect('videocompressor');
        }

    }
  }

  public function getData()
	{
			$path = FCPATH.'assets/video/';
			$originalpath = $path.'input';
			$compresspath = $path.'output';

			$dir = scandir($compresspath);
      $dir = array_diff($dir, array('.','..'));
      // print_r($dir);
      // exit;
			$data = array();
			$key = 0;

			foreach($dir as $row)
			{
          // $output = pathinfo($compresspath.'/'.$row);
          //
          // $input = pathinfo($originalpath.'/'.$row);

          //$ori = (is_file($compresspath.'/'.$row) && file_exists($originalpath.'/'.$row)) ? $row : '';

					//if($input['filename'] == $output['filename'])
					//{
							$data[$key]['ID'] = ($key+1);

							//$data[$key]['OriginalVideo'] = '<a href="'.base_url('assets/video/input/'.$input['basename']).'">'.$input['basename'].'</a> ('.number_format(filesize($originalpath.'/'.$input['basename']), 0, ',','.').' bytes)';
							$data[$key]['Compression'] = '<a href="'.base_url('assets/video/output/'.$row).'">'.$row.'</a> ('.number_format(filesize($compresspath.'/'.$row), 0, ',','.').' bytes)';
							$data[$key]['Created'] = date('d M Y H:i:s', filemtime($compresspath.'/'.$row));

							$data[$key]['Actions'] = '';

							$key++;
					//}

			}

			//print_r($data);
			//exit;

			$results = array(
				"sEcho" => 1,
				"iTotalRecords" => count($data),
				"iTotalDisplayRecords" => count($data),
				"aaData"=> $data,
			);

			echo json_encode($results);
	}

	public function test()
	{
    // $arr = array(
    //   0 => 'gajah.'
    // );

    // $example = array('An example','Another example','One Example','Last example');
    // $searchword = 'last';
    // $matches = array();
    // foreach($example as $k=>$v) {
    //     if(preg_match("/\b$searchword\b/i", $v)) {
    //         $matches[$k] = $v;
    //     }
    // }
    //
    // print_r($matches);
    //
    // exit;
    $path = FCPATH.'assets/video/';
    $originalpath = $path.'input';
    $compresspath = $path.'output';

    $dir = scandir($compresspath);
    $ori = scandir($originalpath);

    //print_r($ori);
    //exit;

    foreach($dir as $row)
    {
      $output = pathinfo($compresspath.'/'.$row);
      $filename = $output['filename'];

      $input = in_array();
      array_search(strpos(), $ori);

      var_dump($input);

    }
    exit;

    $config = array(
      'input_video_path' => FCPATH.'assets/video/input/OCBC.mp4',
      'output_video_path' => FCPATH.'assets/video/output/',
      'new_file_name' => 'OCBC3',
      //'new_format' => 'mpeg'
    );

    $this->video_lib->initialize($config);
    if($this->video_lib->reduce())
    {
       echo "Success";
    }
    else
    {
      echo "Failed";
    }

  }
}
