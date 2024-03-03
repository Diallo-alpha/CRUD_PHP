<?php
    $servername = "localhost";
    $dbname = "innovTech";
    $username = "root";
    $passworld ="";

    $donne_get = $_GET;

    if(!isset($donne_get['id']) || !is_numeric($donne_get['id'])){
        echo "il faut un identifiant pour supprimer la recette";
        return;
    }
    try{
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $passworld);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        echo "erreur de connexion" .$e->getMessage();
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="delete.css" />
        <title>supprimer</title>
    </head>
    <body>
            <?php require_once(__DIR__ .'/header.php'); ?>
            <div class="container">
            <form action="idee_delete.php" method="POST">
            <div class="hidden">
                <label for="id">Identifiant de la recette</label>
                <input type="hidden"  id="id" name="id" value="<?php echo $donne_get['id']; ?>">
            </div>
            <button type="submit">supprimé</button>
        </form>
        <br />
    </div>
</form>
    </body>
    </html>