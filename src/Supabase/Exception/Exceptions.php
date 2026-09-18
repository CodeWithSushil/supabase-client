<?php
declare(strict_types=1);
namespace Supabase\Client;

class Exceptions extends Exception {
  public static function Error()
  {
    throw new Exception('Error');
  }
};
