<?php
require_once 'dbconfig.php';

class USER
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

    public function register($fname, $lname, $email, $password, $hash)
    {
        try {
            $password = md5($password);
            $stmt = $this->conn->prepare("INSERT INTO users(firstname, lastname, email, password, hash) VALUES(:fName, :lName, :e_mail, :pass, :active_code)");
            $stmt->bindparam(":fName", $fname);
            $stmt->bindparam(":lName", $lname);
            $stmt->bindparam(":e_mail", $email);
            $stmt->bindParam(":pass", $password);
            $stmt->bindparam(":active_code", $hash);
            $stmt->execute();
            return $stmt;
        }
        catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function login($email, $password)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE email=:email_id");
            $stmt->execute(array(":email_id" => $email));
            $userRow = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($stmt->rowCount() == 1) {
                if ($userRow['active'] == "1") {
                    if ($userRow['password'] == md5($password)) {
                        $_SESSION['userSession'] = $userRow['user_id'];
                        $_SESSION['userSessionName'] = $userRow['firstname'];

                        return true;
                    } else {
                        header("Location: login.php?error1");
                        $_SESSION['message'] = "Password should be hashed.";
                        exit;
                    }
                } else {
                    header("Location: login.php?error2");
                    $_SESSION['message'] = "Your account is not activate.";
                    exit;
                }
            } else {
                header("Location: login.php?error3");
                $_SESSION['message'] = "No data found in database.";
                exit;
            }
        }
        catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }


    public function is_logged_in()
    {
        if (isset($_SESSION['userSession'])) {
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
        $_SESSION['userSession'] = false;
    }

    function send_mail($email, $message, $subject)
    {
        require_once ('PHPMailer/PHPMailerAutoload.php');
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls";
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 587;
        $mail->AddAddress($email);
        $mail->Username = "satish4link@gmail.com";
        $mail->Password = "leaked55";
        $mail->SetFrom('satish4link@gmail.com', 'Mens Fashain');
        //$mail->AddReplyTo("gaju.adhikari@gmail.com","Coding Cage");
        $mail->Subject = $subject;
        $mail->MsgHTML($message);
        $mail->Send();
    }

}
