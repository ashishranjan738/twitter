<?php
    class User {
        protected $pdo;
        function __construct($pdo){
            $this->pdo=$pdo;
        }

        public function checkInput($var){
            $var = htmlspecialchars($var);
            $var = trim($var);
            $var = stripcslashes($var);
            return $var;
        }

        public function login($email,$password){
            $password=md5($password);
            $stmt = $this->pdo->prepare("SELECT `user_id` FROM `users` WHERE `email` = :email AND `password`=:password");
            $stmt->bindParam(":email",$email,PDO::PARAM_STR);
            $stmt->bindParam(":password",$password,PDO::PARAM_STR);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_OBJ);
            $count = $stmt->rowCount();

            if($count>0){
                $_SESSION['user_id'] = $user->user_id;
                header('Location: home.php');
            }else{
                return false;
            }
        }
    }
?>