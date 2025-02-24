<?php 
session_start();
require_once '../config/database.php';
$mysqli = getConnection();

$error = '';
$success = '';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Récupérer les informations de l'utilisateur
$stmt = $mysqli->prepare('SELECT * FROM users WHERE idu = ?');
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Mise à jour du profil
if (isset($_POST['update_profile'])) {
    $lastname = trim($_POST['lastname']);
    $firstname = trim($_POST['firstname']);
    $email = trim($_POST['email']);
    $confirm_email = trim($_POST['confirm_email']);

    if ($email !== $confirm_email) {
        $error = "Les adresses email ne correspondent pas";
    } else {
        $stmt = $mysqli->prepare('UPDATE users SET lastname = ?, firstname = ?, email = ? WHERE idu = ?');
        $stmt->bind_param('sssi', $lastname, $firstname, $email, $_SESSION['user_id']);
        
        if ($stmt->execute()) {
            $success = "Profil mis à jour avec succès";
            $_SESSION['lastname'] = $lastname;
            $_SESSION['firstname'] = $firstname;
        } else {
            $error = "Erreur lors de la mise à jour du profil";
        }
    }
}

// Changement de mot de passe
if (isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];

    if ($new_password !== $confirm_new_password) {
        $error = "Les nouveaux mots de passe ne correspondent pas";
    } else if (!password_verify($current_password, $user['pwd'])) {
        $error = "Mot de passe actuel incorrect";
    } else {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $mysqli->prepare('UPDATE users SET pwd = ? WHERE idu = ?');
        $stmt->bind_param('si', $hashed_password, $_SESSION['user_id']);
        
        if ($stmt->execute()) {
            $success = "Mot de passe changé avec succès";
        } else {
            $error = "Erreur lors du changement de mot de passe";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profil</title>
</head>

<body class="bg-gray-200">
    <?php require '../includes/header.php'; ?>
    
    <main class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-center mb-8">Profil <?= htmlspecialchars($_SESSION['lastname'].' '.$_SESSION['firstname'])?></h1>
        
        <?php if ($error): ?>
            <div class="mb-4 text-center">
                <p class="text-red-500"><?= htmlspecialchars($error) ?></p>
            </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="mb-4 text-center">
                <p class="text-green-500"><?= htmlspecialchars($success) ?></p>
            </div>
        <?php endif; ?>

        <div class="grid md:grid-cols-2 gap-8 max-w-6xl mx-auto">
            <!-- Informations de profil -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-semibold mb-6 text-gray-800">Informations de profil</h2>
                <form method='post' class="space-y-4">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="lastname">Nom</label>
                            <input class="w-full bg-gray-50 border-2 border-gray-200 rounded py-2 px-4 text-gray-700 focus:outline-none focus:bg-white focus:border-purple-500" 
                                   id="lastname" 
                                   type="text" 
                                   name="lastname" 
                                   value="<?= htmlspecialchars($user['lastname']) ?>">
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="firstname">Prénom</label>
                            <input class="w-full bg-gray-50 border-2 border-gray-200 rounded py-2 px-4 text-gray-700 focus:outline-none focus:bg-white focus:border-purple-500" 
                                   id="firstname" 
                                   type="text" 
                                   name="firstname" 
                                   value="<?= htmlspecialchars($user['firstname']) ?>">
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
                            <input class="w-full bg-gray-50 border-2 border-gray-200 rounded py-2 px-4 text-gray-700 focus:outline-none focus:bg-white focus:border-purple-500" 
                                   id="email" 
                                   type="email" 
                                   name="email" 
                                   value="<?= htmlspecialchars($user['email']) ?>">
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="confirm_email">Confirmer l'email</label>
                            <input class="w-full bg-gray-50 border-2 border-gray-200 rounded py-2 px-4 text-gray-700 focus:outline-none focus:bg-white focus:border-purple-500" 
                                   id="confirm_email" 
                                   type="email" 
                                   name="confirm_email" 
                                   value="<?= htmlspecialchars($user['email']) ?>">
                        </div>
                    </div>
                    
                    <div class="pt-4">
                        <button class="w-full bg-orange-800 hover:bg-orange-900 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out transform hover:scale-105" 
                                type="submit" 
                                name="update_profile">
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>

            <!-- Changement de mot de passe -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-semibold mb-6 text-gray-800">Changer le mot de passe</h2>
                <form method="post" class="space-y-4">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="current_password">Mot de passe actuel</label>
                            <input class="w-full bg-gray-50 border-2 border-gray-200 rounded py-2 px-4 text-gray-700 focus:outline-none focus:bg-white focus:border-purple-500" 
                                   id="current_password" 
                                   type="password" 
                                   name="current_password" 
                                   required>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="new_password">Nouveau mot de passe</label>
                            <input class="w-full bg-gray-50 border-2 border-gray-200 rounded py-2 px-4 text-gray-700 focus:outline-none focus:bg-white focus:border-purple-500" 
                                   id="new_password" 
                                   type="password" 
                                   name="new_password" 
                                   required>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="confirm_new_password">Confirmer le nouveau mot de passe</label>
                            <input class="w-full bg-gray-50 border-2 border-gray-200 rounded py-2 px-4 text-gray-700 focus:outline-none focus:bg-white focus:border-purple-500" 
                                   id="confirm_new_password" 
                                   type="password" 
                                   name="confirm_new_password" 
                                   required>
                        </div>
                    </div>
                    
                    <div class="pt-4">
                        <button class="w-full bg-orange-800 hover:bg-orange-900 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out transform hover:scale-105" 
                                type="submit" 
                                name="change_password">
                            Changer le mot de passe
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="text-center mt-8">
            <a href="private.php" class="text-orange-800 hover:text-orange-900 font-semibold transition duration-300">
                ← Retour à l'espace privé
            </a>
        </div>
    </main>

    <?php require '../includes/footer.php'; ?>
</body>
</html>
