<?php  
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "innovTech";

try {
    $conns = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conns->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "connexion réussie";
} catch(PDOException $e) {
    echo "connexion à échoué : " . $e->getMessage();
}

$mysql = "SELECT * FROM idee";
$stmt = $conns->prepare($mysql);
$stmt->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="accueil.css" />
    <title>Accueil</title>
</head>
<body>
    <?php require_once(__DIR__ . '/header.php'); ?>
    <div class="card-container">
        <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <div class="card">
                <div class="card-header">Catégorie: <?php 
                        $categorie = $row['fk_categorie'];
                        switch($categorie) {
                            case 1:
                                echo "Développement web";
                                break;
                            case 2:
                                echo "Intelligence Artificielle";
                                break;
                            default:
                                echo "Catégorie invalide";
                        }
                    ?></div>
                <div class="card-body">
                    <div class="card-title">Titre: <?php echo $row['titre']; ?></div>
                    <div class="card-text"><?php echo $row['description']; ?></div>
                </div>
        <div class="button-container">
        <button class="add-button"><a href="update.php?id=<?php echo $row['id']?>">Modifier</a></button>
        <button class="delete-button"><a href="delete.php?id=<?php echo $row['id']?>">Supprimer</a></button>
        </div>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
