<?php  
session_start();
if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
    exit;
}
require_once '../config/database.php';
$mysqli = getConnection();
$stmt = $mysqli->prepare('SELECT * FROM users WHERE idu = ?');
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

?>


<body>
    <?php require '../includes/header.php'; ?>
    <main class="container mx-auto p-6 bg-white">
         <div class="max-w-md mx-auto bg-gray-50 shadow-lg rounded-lg p-6">
            <h2 class="text-2xl font-bold text-red-800 mb-4">Vos Informations Personnelles</h2>
            <p class="mb-2">
            <strong>Nom Complet :</strong> <?= htmlspecialchars($_SESSION['firstname'] . ' ' . $_SESSION['lastname']) ?>
            </p>
            <p class="mb-2">
            <strong>ID Utilisateur :</strong> <?= htmlspecialchars($_SESSION['user_id']) ?>
            </p>
            <p class="mb-2">
            <strong>Email :</strong> <?= htmlspecialchars($user['email'] ?? 'Non renseigné') ?>
            </p>
            <p>
            <strong>Statut :</strong> Actif
            </p>
        </div>
    </main>

    <?php require '../includes/footer.php'; ?>

</body>

</html>