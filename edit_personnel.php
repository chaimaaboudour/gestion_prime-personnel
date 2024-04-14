<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("location:login.php");
    exit;
}

$user = "root";
$password = "";
$db = "user";
$socket = __DIR__ . "/mysql.sock";

$data = mysqli_connect($host, $user, $password, $db);
if ($data == false) {
    die("erreur de connexion: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ppr = isset($_POST["ppr"]) ? $_POST["ppr"] : "";
    $nom_prenom = isset($_POST["nom_prenom"]) ? $_POST["nom_prenom"] : "";
    $n = isset($_POST["n"]) ? $_POST["n"] : "";
    $grade = isset($_POST["grade"]) ? $_POST["grade"] : "";
    $service_name = isset($_POST["service_name"]) ? $_POST["service_name"] : "";

    $query = "UPDATE personnel SET nom_prenom='$nom_prenom', n='$n', grade='$grade', service_name='$service_name' WHERE ppr='$ppr'";
    $result = mysqli_query($data, $query);

    if ($result) {
        echo "Personnel modifié avec succès.";
        header("Location: adminhome.php"); // Redirection vers la page "adminhome.php"
        exit;
    } else {
        echo "Erreur lors de la modification du personnel: " . mysqli_error($data);
    }
} else {
    $ppr = isset($_GET["edit"]) ? $_GET["edit"] : "";
    $query = "SELECT * FROM personnel WHERE ppr = '$ppr'";
    $result = mysqli_query($data, $query);
    $personnelData = mysqli_fetch_assoc($result);

    if (!$personnelData) {
        // Rediriger vers la page "adminhome.php" si le personnel n'est pas trouvé
        header("Location: adminhome.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier les informations d'un personnel</title>
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
        .error-message {
            color: red;
            margin-top: 10px;
        }
        .success-message {
            color: green;
            margin-top: 10px;
        }
        a {
            color: #333;
            text-decoration: none;
            display: block;
            text-align: center;
            margin-top: 20px;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Modifier les informations d'un personnel</h1>
    <?php if (isset($personnelData)) : ?>
    <form action="#" method="POST">
        <input type="hidden" name="ppr" value="<?php echo $personnelData['ppr']; ?>">
        <div class="form-group">
            <label for="nom_prenom">Nom et prénom:</label>
            <input type="text" id="nom_prenom" class="form-control" placeholder="Nom et prénom" name="nom_prenom" value="<?php echo $personnelData['nom_prenom']; ?>" required>
        </div>
        <div class="form-group">
            <label for="n">N°:</label>
            <input type="text" id="n" class="form-control" placeholder="N°" name="n" value="<?php echo $personnelData['n']; ?>" required>
        </div>
        <div class="form-group">
            <label for="grade">Grade:</label>
            <input type="text" id="grade" class="form-control" placeholder="Grade" name="grade" value="<?php echo $personnelData['grade']; ?>" required>
        </div>
        <div class="form-group">
            <label for="service_name">Service:</label>
            <input type="text" id="service_name" class="form-control" placeholder="Service" name="service_name" value="<?php echo $personnelData['service_name']; ?>" required>
        </div>
        <br>
        <input type="submit" value="Modifier">
    </form>
    <?php else : ?>
    <p class="error-message">Personnel introuvable.</p>
    <?php endif; ?>
    <a href="logout.php">Logout</a>
</body>
</html>

