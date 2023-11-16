 <?php

    class DatabaseConnection
    {
        private $host = 'localhost';
        private $username = 'yosephus';
        private $password = 'yosephus';
        private $database = 'talentvis';
        private $connection;

        public function __construct()
        {
            $this->connect();
        }

        private function connect()
        {
            $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);

            if ($this->connection->connect_error) {
                die("Connection failed: " . $this->connection->connect_error);
            }
        }

        public function query($sql)
        {
            $result = $this->connection->query($sql);
            return $result;
        }

        public function close()
        {
            $this->connection->close();
        }
    }
