<?php 

class UsersModel {
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function register($username, $password, $name)
    {
        // Implement registration logic, e.g., insert user data into the database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (username, password, name, created_at) VALUES ('$username', '$hashedPassword', '$name', now())";
        $this->db->query($query);

        return true;
    }

    public function login($username, $password)
    {
        // Implement login logic, e.g., check user credentials in the database
        $query = "SELECT * FROM users WHERE username='$username'";
        $result = $this->db->query($query);

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                return $user;
            }
        }

        return null;
    }

    public function getData($id)
    {
        $query = "SELECT * FROM users where id = '$id'";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllData($id)
    {
        $query = "SELECT * FROM users where id != '$id'";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}