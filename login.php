<?php

$user="root";
$password="";
$db="user";
$socket = __DIR__ . "/mysql.sock";
session_start();
$data=mysqli_connect($host,$user,$password,$db);
if($data==false)
{
    die("connection erreur");
}
if ($_SERVER["REQUEST_METHOD"]=="POST")
{
    $username=isset($_POST["username"]) ? $_POST["username"] : "";
    $password=isset($_POST["password"]) ? $_POST["password"] : "";
    $sql="select * from login where username='".$username."'
    AND password='".$password."'
    ";
    $result=mysqli_query($data,$sql);
    $row=mysqli_fetch_array($result);
    if($row["usertype"]=="user")
    {
         $_SESSION["username"]=$username;
         header("location:userhome.php");
    }
    elseif($row["usertype"]=="admin")
    {   
         $_SESSION["username"]=$username;

         header("location:adminhome.php");
    }
    else
    {
        echo "username or password incorrect";
    }

}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de connexion</title>
    <style>
               body {
            font-family: Arial, sans-serif;
            background-image: url("prime_background.jpg");
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        
        form {
            max-width: 250px;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 50px; /* Adjust the padding */
            border-radius: 5px;
            margin-top: 20px; /* Add margin to separate from the title */
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        .input-container {
            position: relative;
            margin-bottom: 15px;
        }

        .input-icon {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: #ccc;
        }

        input[type="text"],
        input[type="password"] {
            width: 80%;
            padding: 10px 35px 10px 35px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #2C8BFF;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #2491FF;
        }

        .error-message {
            color: rgba(255, 255, 255, 0.9) ;
            margin-top: 10px;
            text-align: center;
        }
    </style>
    </style>
    <!-- Link to Font Awesome CDN for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

    <form action="#" method="POST">
        <div class="input-container">
            <i class="fas fa-user input-icon"></i>
            <input type="text" id="username" name="username" placeholder="Nom d'utilisateur" required>
        </div>
        <div class="input-container">
            <i class="fas fa-lock input-icon"></i>
            <input type="password" id="password" name="password" placeholder="Mot de passe" required>
        </div>
        <div>
            <input type="submit" value="Se connecter">
        </div>
    </form>
    
    <div class="error-message">
        <!-- Display any login errors here -->
        <?php
        if (isset($_SESSION["username"])) {
            echo "Bienvenue, " . $_SESSION["username"] . " ! Vous avez accès au contenu exclusif des primes.";
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
            echo "Nom d'utilisateur ou mot de passe incorrect.";
        }
        ?>
    </div>
</body>
</html>


