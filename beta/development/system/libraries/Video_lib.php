<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CI_Video_lib{

  private $path_info;
  private $input_video_path;
  private $output_video_path;
  private $new_file_name;
  private $new_format;
  private $file_name;
  private $extension;
  private $new_file;
  private $input;
  private $output;

  public function __construct(){
    exec(BASEPATH.'FFmpeg/ffmpeg.exe');
  }

  public function initialize($config = array())
  {
    $this->input_video_path = $config['input_video_path'];

    $this->output_video_path = $config['output_video_path'];

    $this->path_info = pathinfo($this->input_video_path);
    $this->file_path = $this->path_info['dirname'].'/';
    $this->file_name = $this->path_info['filename'];
    $this->extension = $this->path_info['extension'];

    $this->new_format = !empty($config['new_format']) ? $config['new_format'] : $this->extension;
    $this->new_file_name = !empty($config['new_file_name']) ? $config['new_file_name'] : $this->file_name;

    $this->new_file = $this->new_file_name.'.'.$this->new_format;

    $this->input = $this->file_path.$this->file_name.'.'.$this->extension;
    $this->output = $this->output_video_path.$this->new_file;

  }

  private function reduce_src(){
      return "ffmpeg -i {$this->input} -c:v libx264 -preset slow -crf 22 -c:a copy {$this->output}";
  }

  public function reduce(){
    exec($this->reduce_src(), $output, $results);

    if(!$results)
    {
      return TRUE;
    }
    else
    {
      return FALSE;
    }

  }

}
