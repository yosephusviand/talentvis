<?php
class WalletUserModel
{
    private $balance;
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
        $this->balance = 0;
    }

    public function getBalance($id)
    {
        $query = "SELECT * FROM users_wallet where user_id = '$id' order by id desc limit 1";
        $result = $this->db->query($query);
        $this->balance = $result->fetch_assoc()['saldo'];
        return $this->balance;
    }

    public function getData($id)
    {
        $query = "SELECT users_wallet.*, users.name FROM users_wallet left join users on users_wallet.tf_from = users.id or users_wallet.tf_to = users.id where user_id = '$id'";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function deposit($amount, $type, $id)
    {
        $saldo = $this->getBalance($id) + $amount;
        $query = "INSERT INTO users_wallet (saldo, type, credit, created_at, user_id) VALUES ('$saldo', '$type', '$amount', now(), '$id')";
        $this->db->query($query);
        $querySaldo = "SELECT * FROM users_wallet where user_id = '$id' order by id desc limit 1";
        $this->balance = $this->db->query($querySaldo)->fetch_assoc()['saldo'];
    }

    public function withdraw($amount, $type, $id)
    {
        if ($amount <= $this->getBalance($id)) {
            $saldo = $this->getBalance($id) - $amount;
            $query = "INSERT INTO users_wallet (saldo, type, debit, created_at, user_id) VALUES ('$saldo', '$type', '$amount', now(), '$id')";
            $this->db->query($query);
            $querySaldo = "SELECT * FROM users_wallet where user_id = '$id' order by id desc limit 1";
            $this->balance = $this->db->query($querySaldo)->fetch_assoc()['saldo'];
        } else {
            return false;
        }
    }

    public function transfer($amount, $type, $to, $from)
    {
        if ($amount <= $this->getBalance($from)) {
        $saldo = $this->getBalance($from) - $amount;
        $query = "INSERT INTO users_wallet (saldo, type, debit, created_at, user_id, tf_to) VALUES ('$saldo', '$type', '$amount', now(), '$from', '$to')";
        $this->db->query($query);
        $saldoTo = $this->getBalance($to) + $amount;
        $query1 = "INSERT INTO users_wallet (saldo, type, credit, created_at, user_id, tf_from) VALUES ('$saldoTo', '$type', '$amount', now(), '$to', '$from')";
        $this->db->query($query1);

        $querySaldo = "SELECT * FROM users_wallet where user_id = '$from' order by id desc limit 1";
        $this->balance = $this->db->query($querySaldo)->fetch_assoc()['saldo'];
        } else {
            return false;
        }
    }
}
