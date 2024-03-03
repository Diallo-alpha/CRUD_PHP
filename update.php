<?php
// **Connexion à la base de données**
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "innovTech";

// **Récupération de l'ID de l'idée depuis l'URL**
$idee_id = isset($_GET['id']) ? intval($_GET['id']) : null;

try {
    // **Connexion à la base de données**
    $connu = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $connu->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($idee_id !== null) {
        // **Préparation de la requête SQL**
        // Ajout de commentaires pour expliquer la requête
        $sql_update = $connu->prepare("SELECT * FROM idee WHERE id = :id");

        // **Exécution de la requête avec les paramètres**
        $sql_update->execute([
            'id' => $idee_id, // Injection du paramètre :id
        ]);

        // **Récupération des résultats**
        $idee = $sql_update->fetch(PDO::FETCH_ASSOC);
    } else {
        $idee = false; // Aucune idée trouvée si l'identifiant est absent
    }
    
} catch(PDOException $e) {
    // **En cas d'erreur, afficher le message d'erreur**
    echo "Erreur : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une idée</title>
    <link rel="stylesheet" href="update.css">
</head>
<body>
    <?php require_once(__DIR__ . '/header.php'); ?>
  
    <div class="container">
        <h2>Modifier une idée</h2>
        <?php if($idee !== false): ?>
        <form action="idee_post_update.php" method="post">
        <input type="hidden" name="id" value="<?php echo isset($idee['id']) ? $idee['id'] : ''; ?>">
            <div class="form-group">
                <label for="titre">Titre :</label>
                <input type="text" name="titre" id="titre" value="<?php echo isset($idee['titre']) ? $idee['titre'] : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description :</label>
                <textarea id="description" name="description" rows="6" required><?php echo isset($idee['description']) ? $idee['description'] : ''; ?></textarea>
            </div>
            <button type="submit">Modifier</button>
        </form>
        <?php else: ?>
            <p>Aucune idée trouvée pour l'ID spécifié.</p>
        <?php endif; ?>
    </div>
</body>
</html>
