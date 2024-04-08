<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Imagecompressor extends CI_Controller {

	public function __construct()
	{

		parent::__construct();
		$user = $this->session->userdata('myuser');

		if(!isset($user) or empty($user))
		{
			redirect('c_loginuser');

		}

	}

	public function index()
	{


			//print_r($imgdir);

			$data = array(
				'view' => 'content/imagecompressor/index',
				'extra' => array(
					'css' => array(
						'plugins/fileupload/component.css',
					),
					'js' => array(),
				),
				//'imgdir' => $imgdir,
			);

			$this->load->view('template/home', $data);
	}

	public function getData()
	{
			$path = FCPATH.'/assets/images/';
			$originalpath = $path.'upload';
			$compresspath = $path.'compress';

			$imgdir = scandir($compresspath);

			$data = array();
			$key = 0;
			foreach($imgdir as $row)
			{
					$imageori = (is_file($compresspath.'/'.$row) && file_exists($originalpath.'/'.$row)) ? $row : '';

					if(!empty($imageori))
					{
							$data[$key]['ID'] = ($key+1);

							$thumb = explode('.',$row);
							$thumb = $thumb[0].'_thumb.'.$thumb[1];

							$thumb = (file_exists($compresspath.'/'.'thumbs/'.$thumb)) ? '<img src="'.base_url('assets/images/compress/thumbs/'.$thumb).'" />' : '';

							$data[$key]['Thumb'] = $thumb;
							$data[$key]['OriginalImage'] = '<a href="'.base_url('assets/images/upload/'.$row).'">'.$row.'</a> ('.number_format(filesize($originalpath.'/'.$row), 0, ',','.').' bytes)';
							$data[$key]['Compression'] = '<a href="'.base_url('assets/images/compress/'.$row).'">'.$row.'</a> ('.number_format(filesize($compresspath.'/'.$row), 0, ',','.').' bytes)';
							$data[$key]['Created'] = date('d M Y H:i:s', filemtime($compresspath.'/'.$row));

							$data[$key]['Action'] = '
								<div class="btn-group">
								  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								    <i class="fa fa-ellipsis-v"></i>
								  </button>
								  <ul class="dropdown-menu pull-right">
								    <li><a href="#"><i class="fa fa-compress"></i> Re-compress</a></li>
										<li><a href="#"><i class="fa fa-trash-o"></i> Remove</a></li>
								  </ul>
								</div>';

							$key++;
					}

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

	public function compress()
	{
				$post = $this->input->post();

				$config['upload_path']          = FCPATH.'/assets/images/upload/';
				$config['allowed_types']        = 'gif|jpg|png';
				$config['file_name']        		= (!empty($post['filename'])) ? $post['filename'] : 'img_'.date('ymdHis').'_'.rand(0,9999);
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

						$args = array(
							'source_image' => $data['upload_data']['full_path'],
							'quality' => $post['quality'],
							'width' => $post['width'],
							'height' => $post['height'],
							'ratio' => ($post['ratio'] == 1) ? TRUE : FALSE,
							'new_image' => FCPATH.'/assets/images/compress',
							'create_thumb' => FALSE,
							'library' => 'imagemagick',
						);
						//print_r($data);
						if($this->_compress_image($args))
						{
								$thumbs = array(
									'source_image' => $data['upload_data']['full_path'],
									'quality' => 100,
									'width' => 75,
									'height' => 50,
									'ratio' => TRUE,
									'new_image' => FCPATH.'/assets/images/compress/thumbs',
									'create_thumb' => TRUE,
									'library' => 'imagemagick',
									'thumb_marker' => '_thumb',
								);

								$this->_compress_image($thumbs);

								$this->session->set_flashdata('alert_success', 'Your Image has been succesfully compressed.');
								redirect('imagecompressor');
						}
						else
						{
							$this->session->set_flashdata('alert_failed', 'Failed to compress image, please try again.');
							redirect('imagecompressor');
						}

						//print_r($data);
						//$this->load->view('upload_success', $data)

				}
	}

  private function _compress_image($args)
  {

		$config['image_library'] = $args['library'];

		if($args['library'] == 'imagemagick'){
			$config['library_path'] = '/usr/bin/convert';
		}

		$config['create_thumb'] = $args['create_thumb'];
		$config['source_image'] = $args['source_image'];
		$config['quality'] = $args['quality'].'%';
		$config['new_image'] = $args['new_image'];
		$config['maintain_ratio'] = $args['ratio'];
    $config['width']         = $args['width'];
    $config['height']       = $args['height'];

		if(!empty($args['thumb_marker'])){
			$config['thumb_marker'] = $args['thumb_marker'];
		}

    $this->load->library('image_lib');
		$this->image_lib->initialize($config);

    if ( ! $this->image_lib->resize())
    {
        echo $this->image_lib->display_errors();
				exit;
    }
		else
		{
				$this->image_lib->clear();
				return TRUE;
		}

		$this->image_lib->clear();

  }

}
