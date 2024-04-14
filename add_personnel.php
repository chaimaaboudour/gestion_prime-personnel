<?php
$user = "root";
$password = "";
$db = "user";
$socket = __DIR__ . "/mysql.sock";

$data = mysqli_connect($host, $user, $password, $db);
if ($data == false) {
    die("erreur de connexion: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom_prenom = isset($_POST["nom_prenom"]) ? $_POST["nom_prenom"] : "";
    $ppr = isset($_POST["ppr"]) ? $_POST["ppr"] : "";
    $grade = isset($_POST["grade"]) ? $_POST["grade"] : "";
    $service_name = isset($_POST["service_name"]) ? $_POST["service_name"] : "";

    // Use prepared statements to avoid SQL injection
    $query = "INSERT INTO personnel (nom_prenom, ppr, grade, service_name) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($data, $query);
    mysqli_stmt_bind_param($stmt, "ssss", $nom_prenom, $ppr, $grade, $service_name);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "Personnel ajouté avec succès.";
    } else {
        echo "Erreur lors de l'ajout du personnel: " . mysqli_error($data);
    }
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un personnel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }
        form {
            max-width: 500px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }
        form label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        form input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        form input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 10px;
            width: 100%;
            transition: background-color 0.3s;
        }
        form input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .text-center {
            text-align: center;
        }
        .btn {
            margin-top: 10px;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .btn-secondary:hover {
            background-color: #545b62;
        }
    </style>
</head>
<body>
    <h1>Ajouter un personnel</h1>
    <form action="#" method="POST">
        <div class="form-group">
            <label for="nom_prenom">Nom et prénom:</label>
            <input type="text" id="nom_prenom" class="form-control" name="nom_prenom" required placeholder="Nom et Prenom">
        </div>
        <div class="form-group">
            <label for="ppr">PPR:</label>
            <input type="text" id="ppr" class="form-control" name="ppr"  placeholder="PPR">
        </div>
        <div class="form-group">
            <label for="grade">Grade:</label>
            <input type="text" id="grade" class="form-control" name="grade" required placeholder="Grade">
        </div>
        <div class="form-group">
            <label for="service_name">Service:</label>
            <input type="text" id="service_name" class="form-control" name="service_name" required placeholder="Service">
        </div>
        <input type="submit" value="Ajouter">
    </form>
    <div class="text-center mt-3">
        <a href="logout.php" class="btn btn-secondary">Logout</a>
    </div>
</body>
</html>


