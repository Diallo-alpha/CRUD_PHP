<?php 
// Initialisation de la variable fk_categorie à null
$fk_categorie = null;

// Vérification si le formulaire est envoyé
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérification des données reçues
    $adresseMail = $_POST['email'];
    if (!isset($adresseMail) || !filter_var($adresseMail, FILTER_VALIDATE_EMAIL)) {
        echo "Veuillez ajouter un email valide.";
        return;
    }
    
    // Vérification si la catégorie est sélectionnée
    if(isset($_POST['categorie'])) {
        // Récupération de la valeur de la catégorie sélectionnée
        $categorie = $_POST['categorie'];

        // Connexion à la base de données
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "innovTech";
        
        try {
            // Connexion à la base de données
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Recherche de l'ID de catégorie correspondant
            $stmt = $conn->prepare("SELECT id FROM categorie WHERE libelle = :libelle");
            $stmt->bindParam(':libelle', $categorie);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $fk_categorie = $result['id'];
            } else {
                echo "La catégorie sélectionnée n'est pas valide.";
                return;
            }
        } catch (PDOException $e) {
            echo "Connexion échouée : " . $e->getMessage();
            return;
        }
    } else {
        echo "Veuillez sélectionner une catégorie.";
        return;
    }
    
    // Récupération des autres données du formulaire
    $titre = $_POST['titre'];
    if (!isset($titre) || is_numeric($titre)) {
        echo "Votre titre ne doit pas être un nombre.";
        return;
    }
    
    $description = $_POST['description'];
    if (!isset($description)) {
        echo "Veuillez ajouter une description.";
        return;
    }
    
    $date_ajout = date('Y-m-d H:i:s');
    
    try {
        // Connexion à la base de données (dans le bloc try externe)
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Préparation de la requête SQL
        $sql = "INSERT INTO idee (email, titre, description, date_ajout, fk_categorie) VALUES (:email, :titre, :description, :date_ajout, :fk_categorie)";
        $stmt = $conn->prepare($sql);

        // Liaison des paramètres
        $stmt->bindParam(':email', $adresseMail);
        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':date_ajout', $date_ajout);
        $stmt->bindParam(':fk_categorie', $fk_categorie);

        // Exécution de la requête
        $stmt->execute();
        header('Location: accueil.php');
        //echo "L'idée a été ajoutée avec succès.";  
        
    } catch (PDOException $e) {
        echo "Connexion échouée : " . $e->getMessage();
    }
}
?>
