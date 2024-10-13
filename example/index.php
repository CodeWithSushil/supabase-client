<?php
require_once __DIR__."/vendor/autoload.php";

use Supabase\Supabase\Supabase as Supabase; 

$url="https://your_project_id.supabase.co";
$apikey="";
$table="users";

$client = new Supabase($url,$apikey,$table);

$html = $client->get($table);
//$html = $client->fetch($table,'name');
echo "<pre>";
print_r($html);

$data = [
  "name" => "Code With Sushil",
  "age" => 23
];
//$client->post($table, $data);
//$client->update($table, $id, $data);
//$id = 15;
//$client->delete($table, $id);
