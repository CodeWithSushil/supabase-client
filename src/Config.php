<?php declare(strict_types=1);

namespace Supabase;

use Throwable;
//use Dotenv;

class Config extends Throwable {
    private string $host;
    private int $port;
    private string $database;
    private string $username;
    private string $password;
    public $connection;

    private function getDotEnv(){
        $this->host = $_ENV['HOST'];
        $this->port = $_ENV['POST'];
        $this->database = $_ENV['DATABASE'];
        $this->username = $_ENV['USERNAME'];
        $this->password = $_ENV['PASSWORD'];
    }

    public static function connect(){

        $this->connection = null;

        try {
            $this->connection = new PDO("pgsql:host={$this->host};port={$this->port};dbname={$this->database};", $this->username, $this->password);

        } catch (Throwable $th) {
            print($th->getMessage());
        }
        getDotEnv();
    }
}
