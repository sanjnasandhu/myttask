<?php

class OauthUser {
    private $host          = "localhost";
    private $username      = "root";
    private $password      = "redhat";
    private $database_name = "sachin";
    private $table         = 'users';
	private $db;
    
    function __construct(){
		$this->db = new mysqli($this->host, $this->username, $this->password, $this->database_name);
		if($this->db->connect_error){
			die("Failed to connect with MySQL database: " . $this->db->connect_error);
		}
    }
	
	function verifyUser($userInfo) {
		
		$qry_body = "	`oauth_provider` = 'facebook',
							`oauth_id`		 = '".$userInfo['id']."',
							`name`           = '".$userInfo['name']."',
							`first_name`     = '".$userInfo['first_name']."', 
							`last_name`      = '".$userInfo['last_name']."', 
							`email`          = '".$userInfo['email']."', 
							`picture`        = '".$userInfo['picture']['url']."'";


		
		$select_qry = "select * from `users` where `oauth_provider`='facebook' and `oauth_id`= '".$userInfo['id']."'";
		$res = $this->db->query($select_qry);
		if($res->num_rows > 0) {
            $qry = "update ".$this->table." set ".$qry_body." WHERE `oauth_provider` = 'facebook' AND `oauth_id` = '".$userInfo['id']."'";
		} else {
            $qry = "insert into ".$this->table." set ".$qry_body.", `created_at`='".date("Y-m-d H:i:s")."'";		
		}

		$this->db->query($qry);
		$_SESSION['user_is_login']     = true;
		$_SESSION['user_id']      = $userInfo['id'];
		$_SESSION['user_name']    = $userInfo['name'];
		$_SESSION['user_fname']   = $userInfo['first_name'];
		$_SESSION['user_lname']   = $userInfo['last_name'];
		$_SESSION['user_email']   = $userInfo['email'];
		$_SESSION['user_picture'] = $userInfo['picture']['url'];
		header('location:welcome.php');
		exit();
	}
	
}
?>