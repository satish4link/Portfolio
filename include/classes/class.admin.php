<?php
session_start();
require_once 'dbconfig.php';

class ADMIN
{	
	private $conn;
	
	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConn();
		$this->conn = $db;
    }
	
	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}
	
	public function lastID()
	{
		$stmt = $this->conn->lastInsertId();
		return $stmt;
	}
	
	
	public function adminLogin($username,$password)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT * FROM adminpanel WHERE username=:username AND password =:password");
			$stmt->execute(array(":username"=>$username, ":password"=>$password));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			
			if($stmt->rowCount() == 1)
			{
				$_SESSION['adminSession'] = $userRow['id'];
                $_SESSION['adminSessionName'] = $userRow['username'];
                        
				return true;
			}
			else
			{
				header("Location: index.php?error1");
                $_SESSION['message'] = "No data found in database.";
				exit;
			}		
		}
		catch(PDOException $ex)
		{
			$_SESSION['message'] = $ex->getMessage();
		}
	}
	
	
	public function is_logged_in()
	{
		if(isset($_SESSION['adminSession']))
		{
			return true;
		}
	}
	
	public function redirect($url)
	{
		header("Location: $url");
	}
	
	public function logout()
	{
		session_destroy();
		$_SESSION['adminSession'] = false;
	}
	
}