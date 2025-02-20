<?php
declare(strict_types=1);

namespace Supabase;
use Supabase\Supabase;

class Functions extends Supabase
{
  public function getAllData(?string $table=null)
  {
    if (!isset($table)) {
      echo "Please provide your Supabase table name.";
    } else {
      $path = "$this->url/$table";
      $html = $this->grab($path, "GET");
      $data = json_decode($html, true);
      return $data;
    }
  }

  public function getSingleData(?string $table=null, array $query=[])
  {
    if (!isset($table)) {
      echo "Please provide your Supabase table name.";
    } elseif(!isset($query)) {
      echo "Please provide your column name.";
    } else {
      $path = "$this->url/$table?select=$query";
      $html = $this->grab($path, "GET");
      $data = json_decode($html, true);
      return $data;
    }
  }

  public function postData(?string $table=null, array $query=[], ?string $on_conflict=null)
  {
	if (!isset($table)) {
	  echo "Please provide your Supabase table name.";
	} elseif (!isset($query)) {
	  echo "Please provide your data.";
	} else {
	  // If $on_conflict is provided, append to the path
	  if (!empty($on_conflict)) {
		$path = "$this->url/$table?on_conflict=$on_conflict";
	  } else {
		$path = "$this->url/$table";
	  }

	  $html = $this->grab($path, "POST", json_encode($query));
    return $html;
  }
  }

  public function updateData(?string $table=null, ?int $id=null, array $query=[])
  {
    if (!isset($table)) {
      echo "Please provide your Supabase table name.";
    } elseif (!isset($id)) {
      echo "Please provide id.";
    } elseif (!isset($query)) {
      echo "Please provide your data.";
    } else {
      $path = "$this->url/$table?id=eq.$id";
      $html = $this->grab($path, "PATCH", json_encode($query));
      return $html;
    }
  }

  public function deleteData(?string $table=null, ?int $id=null)
  {
    if (!isset($table)) {
      echo "Please provide your Supabase table name.";
    } elseif (!isset($id)) {
      echo "Please provide id.";
    } else {
      $path = "$this->url/$table?id=eq.$id";
      $html = $this->grab($path, "DELETE");
      return $html;
    }
  }

  public function pages(?string $table=null)
  {
    $path = "$this->url/$table?select=*";
    $html = $this->grab($path, "GET");
    $data = json_decode($html, true);
    return $data;
  }

  public function filter(?string $table=null, ?int $range=null)
  {
    $path = "$this->url/$table?id=eq.$range&select=*";
    $html = $this->grab($path, "GET");
    $data = json_decode($html, true);
    return $data;
  }

  public function matchs(?string $table=null, array $query=[])
  {
    $path = "$this->url/$table";
    $html = $this->grab($path, "POST", json_encode($query));
    return $html;
  }

  public function config(){
      $host = $_ENV['HOST'];
      $dbname = $_ENV['DATABASE'];
      $port = $_ENV['PORT'];
      $user = $_ENV['USER'];
      $pass = $_ENV['PASSWORD'];

  }
}
