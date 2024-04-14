<?php
$user = "root";
$password = "";
$db = "user";
$socket = __DIR__ . "/mysql.sock";

$data = mysqli_connect($host, $user, $password, $db);
if ($data == false) {
    die("erreur de connexion: " . mysqli_connect_error());
}
?>
<?php
if (isset($_GET["delete"])) {
    $ppr_to_delete = $_GET["delete"];
    
    // Implement your SQL DELETE query here to delete the personnel record
    $query = "DELETE FROM personnel WHERE ppr = '$ppr_to_delete'";
    $result = mysqli_query($data, $query);
    
    // Optionally, you can add some error handling to check if the deletion was successful
    if ($result) {
        // Redirect back to the adminhome.php page after successful deletion
        header("Location: adminhome.php");
        exit;
    } else {
        echo "Error deleting personnel: " . mysqli_error($data);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }
        th {
            background-color: #f2f2f2;
        }
        a {
            color: #333;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
       
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        .search-form {
            margin-bottom: 20px;
        }
        .personnel-table {
            width: 100%;
        }
        .action-links {
            display: flex;
            justify-content: center;
        }
        .action-links a {
            margin: 0 5px;
        }
    </style>
</head>
<body>
<div class="text-left mt-3" >
            <a href="logout.php" class="btn btn-secondary">Logout</a>
</div><br> <br>
    <h1>Page d' Administration</h1>
    <!-- Add Personnel Button -->
    <a href="add_personnel.php" class="btn btn-primary">Ajouter un personnel</a>

    <h2>Liste des personnels</h2>

    <!-- Rest of the code remains the same -->

    <!-- Search Bar -->
 <div class="search-form">   
    <form action="#" method="GET">
        <div class="form-group col-md-6">
            <label for="search">Rechercher un personnel:</label>
            <div class="input-group">
              <input type="text" id="search" class="form-control" name="search" placeholder="Nom et prénom">
              <div class="input-group-append">
                <button type="submit" class="btn btn-primary">Rechercher</button>
               </div>
            </div>
        </div>
   </form>
    <!-- Rest of the code remains the same -->

    <div class="personnel-table">
        <table class="personnel-table" style="float:right;">
            <tr>
                <th>Nom et prénom</th>
                <th>N°</th>
                <th>PPR</th>
                <th>Grade</th>
                <th>Service</th>
                <th>Action</th>
            </tr>
            <?php
            $search = isset($_GET["search"]) ? $_GET["search"] : "";
            $query = "SELECT * FROM personnel WHERE nom_prenom LIKE '%$search'";
            $result = mysqli_query($data, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["nom_prenom"] . "</td>";
                    echo "<td>" . $row["n"] . "</td>";
                    echo "<td>" . $row["ppr"] . "</td>";
                    echo "<td>" . $row["grade"] . "</td>";
                    echo "<td>" . $row["service_name"] . "</td>"; // Ajout du nom du service
                    echo "<td>
                        <a href='edit_personnel.php?edit=" . $row["ppr"] . "'>Modifier</a> | 
                        <a href='adminhome.php?delete=" . $row["ppr"] . "'>Supprimer</a>
                        </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Aucun personnel disponible.</td></tr>";
            }
            ?>
        </table>
    </div>

</body>
</html>
