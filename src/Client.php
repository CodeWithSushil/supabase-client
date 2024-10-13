<?php
namespace Supabase;
use Supabase\Supabase\Supabase;
use Dotenv\Dotenv;

class Client extends Supabase
{
  public static function connection()
  {
    $env = dirname(__DIR__);
    $dotenv = Dotenv::createImmutable($env);
    $dotenv->load();

    $URL = $_ENV['SB_URL'];
    $API_KEY = $_ENV['SB_APIKEY'];
    $clinet = new Supabase($URL, $API_KEY);
  }

  public static function getAllData($table=null)
  {
    if (!isset($table)) {
     print("Please provide your table name.");
    } else {
      echo $path = parent::url/$table;
      $html = $this->grab($path, "GET");
      $data = json_decode($html, true);
      return $data;
    }
  }

  public function getSingleData($table=null, $query=[])
  {
    if (!isset($table)) {
      echo "Please provide your table name.";
    } elseif(!isset($query)) {
      echo "Please provide your column name.";
    } else {
      $path = "$this->url/$table?select=$query";
      $html = $this->grab($path, "GET");
      $data = json_decode($html, true);
      return $data;
    }
  }

  public function postData($table=null, $query=[])
  {
    if (!isset($table)) {
      echo "Please provide your table name.";
    } elseif (!isset($query)) {
      echo "Please provide your data.";
    } else {
      $path = "$this->url/$table";
      $html = $this->grab($path, "POST", json_encode($query));
      return $html;
    }
  }

  public function updateData($table=null, int $id=null, $query=[])
  {
    if (!isset($table)) {
      echo "Please provide your table name.";
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

  public function deleteData($table=null, int $id=null)
  {
    if (!isset($table)) {
      echo "Please provide your table name.";
    } elseif (!isset($id)) {
      echo "Please provide id.";
    } else {
      $path = "$this->url/$table?id=eq.$id";
      $html = $this->grab($path, "DELETE");
      return $html;
    }
  }

  public function pages($table=null)
  {
    $path = "$this->url/$table?select=*";
    $html = $this->grab($path, "GET");
    $data = json_decode($html, true);
    return $data;
  }

  public function filter($table=null, int $range=null)
  {
    $path = "$this->url/$table?id=eq.$range&select=*";
    $html = $this->grab($path, "GET");
    $data = json_decode($html, true);
    return $data;
  }

  public function matchs($table=null, $query=[])
  {
    $path = "$this->url/$table";
    $html = $this->grab($path, "POST", json_encode($query));
    return $html;
  }

}
