<?php
namespace Supabase\Supabase;
use Exception;

class Supabase
{
  private string|null $apikey;
  protected string|null $url;

  public function __construct($url=null, $apikey=null)
  {
    if (!isset($url)){
      throw new Exception("Supabase URL must be specified");
    } elseif(!isset($apikey)){
      throw new Exception("Supabase API_KEY must be specified"); 
    } else {
      $this->apikey = $apikey;
      $this->url = $url ."/rest/v1";
    }
  }
  
  protected function grab($url, $method, $data=null)
  {
    $headers = array(
      "apikey: $this->apikey",
      "Authorization: Bearer $this->apikey",
      "Content-Type: application/json",
      "Prefer: return=minimal",
      "Range: 0-9",
      "Prefer: resolution=merge-duplicates"
    );

    $options = array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_HTTPHEADER => $headers,
      CURLOPT_CUSTOMREQUEST => $method,
      CURLOPT_TIMEOUT => 120,
      CURLOPT_ENCODING => "UTF-8",
      CURLOPT_CONNECTTIMEOUT => 120
    );

    $ch = curl_init();
    curl_setopt_array($ch, $options);
    if(isset($data)){
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }
    $html = curl_exec($ch);
    return $html;

    if(curl_errno($ch)){
      $error = curl_error($ch);
      echo "Error :". $error;
    }
    curl_close($ch);
  }
}
