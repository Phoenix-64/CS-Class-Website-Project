<?php


class DB
{

    private $dbHost = "db";

    private $dbUsername = "admin";

    private $dbPassword = "1234";

    private $dbName = "ajaxdb";


    public function __construct()
    {
        if (!isset($this->db)) {
            // Connect to the database
            $conn = new mysqli($this->dbHost, $this->dbUsername, $this->dbPassword, $this->dbName);
            if ($conn->connect_error) {
                die("Failed to connect with MySQL: ".$conn->connect_error);
            } else {
                $this->db = $conn;
            }
        }

    }//end __construct()


    public function is_token_empty()
    {
        $result = $this->db->query("SELECT id FROM tokens WHERE provider = 'google'");
        if ($result->num_rows) {
            return false;
        }

        return true;

    }//end is_token_empty()


    public function get_refersh_token()
    {
        $sql = $this->db->query("SELECT provider_value FROM tokens WHERE provider='google'");
        return $sql->fetch_assoc()['provider_value'];

    }//end get_refersh_token()


    public function update_refresh_token($token)
    {
        if ($this->is_token_empty()) {
            $this->db->query("INSERT INTO tokens(provider, provider_value) VALUES('google', '$token')");
        } else {
            $this->db->query("UPDATE tokens SET provider_value = '$token' WHERE provider = 'google'");
        }

    }//end update_refresh_token()


}//end class
