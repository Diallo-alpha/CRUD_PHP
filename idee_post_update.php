<?php
// **Connexion à la base de données**
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "innovTech";

$donne_post = $_POST;
    if(!isset($donne_post['id']) || !is_numeric($donne_post['id']) || empty($donne_post['titre']) || empty($donne_post['description'])
        ||trim(strip_tags($donne_post['titre'])) === ''
        ||trim(strip_tags($donne_post['description'])) === ''
    ){
        echo "il manque des donné pour permettre la modification";
        return;
    }
    try{
        $id = (int)$donne_post['id'];
        $titre = trim(strip_tags($donne_post['titre']));
        $description = trim(strip_tags($donne_post['description']));
        $conn = new PDO("mysql:host=$servername;dbname=$dbname",$username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $donne_insert = $conn->prepare('UPDATE idee SET titre = :titre, description = :description WHERE id = :id');
        $donne_insert->execute([
            'titre' => $titre,
            'description' => $description,
            'id' => $id,
        ]);
    }
    
    catch(PDOException $e){
            echo "connexion echouéé" .$e->getMessage();
        }

    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>modification d'idée</title>
        <link rel="stylesheet" href="idee_update.css" />
    </head>
    <body>
        <div class="container">
            <?php require_once(__DIR__ . '/header.php'); ?>
            <div class="card">
            <div class="card">
                <h4><b>titre :</b><?php echo ($titre); ?></h4>
                <p><b>description :</b><?php echo ($description); ?></p>
            </div>
            </div>
        </div>
    </body>
    </html>
    <?php $rootUrl = "http://localhost:81/innova/"; // Modifier l'URL de base si nécessaire
    header('Location: ' . $rootUrl . 'accueil.php');
    exit(); // Terminer le script après la redirection ?>