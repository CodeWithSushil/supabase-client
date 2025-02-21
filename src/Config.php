<?php declare(strict_types=1);

namespace Supabase;

use PDO;
use Dotenv\Dotenv;

require('./vendor/autoload.php');

class Config {
    private string$host;
    private int $port;
    private string $database;
    private string $username;
    private string $password;
    public $connection;

    private function getDotEnv(){
        $dotenv = Dotenv::createImmutable('../');
        $dotenv->safeLoad();

        $this->host = $_ENV['HOST'];
        $this->port = getenv('PORT');
        $this->database = getenv('DATABASE');
        $this->username = getenv('USERNAME');
        $this->password = getenv('PASSWORD');
    }

    public function connect(){
        $this->getDotEnv();
        $this->connection = null;

        try {
            $this->connection = new PDO("pgsql:host={$this->host};port={$this->port};dbname={$this->database};", $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        } catch (\Throwable $th) {
            print($th->getMessage());
        }
        //$this->getDotEnv();
    }
}

$con = new Config();
$con->connect();
