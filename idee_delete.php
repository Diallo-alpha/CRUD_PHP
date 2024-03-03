<?php
$servername = "localhost";
$dbname = "innovTech";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connexion échouée : " . $e->getMessage();
}

$post_donne = $_POST;
if (!isset($post_donne['id']) || !is_numeric($post_donne['id'])) {
    echo "Il faut un identifiant valide pour supprimer une idée.";
    return;
}

$delete_idee = $conn->prepare("DELETE FROM idee WHERE id = :id");
$delete_idee->execute([
    'id' => $post_donne['id'],
]);

$rootUrl = "http://localhost:81/innova/"; // Modifier l'URL de base si nécessaire
header('Location: ' . $rootUrl . 'accueil.php');
exit(); // Terminer le script après la redirection
?>
