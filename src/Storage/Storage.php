<?php
namespace Supabase\Storage;

use Supabase\Supabase\Supabase;

class Storage extends Supabase
{
  private $files;

  private function FilesType($files,$table)
  {
    if(!isset($files)){
      return "File not selected.";
    }
    if (!isset($table)) {
      return "please provide Table name.";
    }

    $extensions = ['txt', 'pdf', 'pptx', 'xlsx', 'docs', 'zip', 'csv', 'mp3', 'mp4', 'ogg', 'webp', 'png', 'jpg', 'jpeg', 'gif', 'svg'];

  }
  
  public function uploadImages()
  {
    // Images
  }

  public function uploadVideos()
  {
    // Videos
  }

  public function uploadAudios()
  {
    // Audios
  }

  public function uploadFiles()
  {
    // files
  }
}
