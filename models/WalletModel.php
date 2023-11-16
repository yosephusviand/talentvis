<?php
class WalletModel{
    private $balance;
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
        $this->balance = 0;
    }

    public function getBalance()
    {
        $query = "SELECT * FROM wallet order by id desc limit 1";
        $result = $this->db->query($query);
        $this->balance = $result->fetch_assoc()['saldo'];
        return $this->balance;
    }

    public function getData(){
        $query = "SELECT * FROM wallet";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function deposit($amount, $type)
    {   $saldo = $this->getBalance() + $amount;
        $query = "INSERT INTO wallet (saldo, type, credit, created_at) VALUES ('$saldo', '$type', '$amount', now())";
        $this->db->query($query);
        $querySaldo = "SELECT * FROM wallet order by id desc limit 1";
        $this->balance = $this->db->query($querySaldo)->fetch_assoc()['saldo'];
    }

    public function withdraw($amount, $type)
    {
        if ($amount <= $this->getBalance()) {
            $saldo = $this->getBalance() - $amount;
            $query = "INSERT INTO wallet (saldo, type, debit, created_at) VALUES ('$saldo', '$type', '$amount', now())";
            $this->db->query($query);
            $querySaldo = "SELECT * FROM wallet order by id desc limit 1";
            $this->balance = $this->db->query($querySaldo)->fetch_assoc()['saldo'];
        } else {
            return false;
        }
    }
}