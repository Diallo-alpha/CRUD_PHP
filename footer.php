<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une idée</title>
    <link rel="stylesheet" href="add_ide.css">
</head>
<body>
    <?php require_once(__DIR__ . '/header.php'); ?>
  
    <div class="container">
        <h2>Ajouter une idée</h2>
        <form action="sub_ide.php" method="post">
            <div class="form-group">
                <label for="categories">Catégorie :</label>
                <select name="categories" id="categories">
                    <?php
                    // Connexion à la base de données
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "innovTech";

                    try {
                        // Connexion à la base de données
                        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        // Récupération des catégories depuis la base de données
                        $sql_categories = "SELECT * FROM categorie";
                        $stmt_categories = $conn->prepare($sql_categories);
                        $stmt_categories->execute();

                        // Génération des options du menu déroulant des catégories
                        while($row = $stmt_categories->fetch(PDO::FETCH_ASSOC)){
                            echo '<option value="' .$row['id'] . '">' .$row['libelle'].'</option>';
                        }
                    } catch (PDOException $e) {
                        echo "Connexion échouée : " . $e->getMessage();
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="category">mail :</label>
                <input type="email" id="category" name="email" required>
            </div>
            <div class="form-group">
                <label for="titre">Titre : </label>
                <input type="text" name="titre" id="titre" required>
            </div>
            <div class="form-group">
                <label for="description">description :</label>
                <textarea id="description" name="description" rows="6" required></textarea>
            </div>
            <!--
            <div class="form-group">
                <label for="date">date</label>
                <input type="date" name="date" id="date" required>
                 </div> -->
            <button type="submit">Ajouter</button>
        </form>
    </div>
</body>
</html>
