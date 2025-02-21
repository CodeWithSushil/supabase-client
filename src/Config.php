<?php declare(strict_types=1);

namespace Supabase;

use PDO;
use Dotenv\Dotenv;

class Config {
    private string $host;
    private int $port;
    private string $database;
    private string $username;
    private string $password;
    public $connection;

    private function getDotEnv(){
        $dotenv = Dotenv::createImmutable(__dir__);
        $dotenv->safeLoad();

        $this->host = $_ENV['HOST'];
        $this->port = $_ENV['POST'];
        $this->database = $_ENV['DATABASE'];
        $this->username = $_ENV['USERNAME'];
        $this->password = $_ENV['PASSWORD'];
    }

    public function connect(){

        $this->connection = null;

        try {
            $this->connection = new PDO("pgsql:host={$this->host};port={$this->port};dbname={$this->database};", $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        } catch (\Throwable $th) {
            print($th->getMessage());
        }
        $this->getDotEnv();
    }
}

$con = new Config();
$con->connect();
