<?php 
require_once '../config/database.php';
session_start();
$error = '';

if (isset($_POST['login'])) {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email = htmlspecialchars(trim($_POST['email']));
        $password = $_POST['password'];

        $mysqli = getConnection();

        // Préparer la requête
        $stmt = $mysqli->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            // Vérifier le mot de passe 
            if (password_verify($password, $user['pwd'])) {
                $_SESSION['user_id'] = $user['idu'];
                $_SESSION['lastname'] = $user['lastname'];
                $_SESSION['firstname'] = $user['firstname'];

                // Redirection vers la page privée
                header('Location: private.php');
                exit();
            } else {
                $error = 'Email ou mot de passe incorrect';
            }
        } else {
            $error = 'Email ou mot de passe incorrect';
        }
        $stmt->close();
        $mysqli->close();
    } else {
        $error = 'Veuillez remplir tous les champs';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URCA Blog - Connexion</title>
</head>
<body class="bg-gray-100">
    <?php require '../includes/header.php'; ?>
    
    <main class="container mx-auto px-4 py-8 flex items-center justify-center min-h-screen">
        <div class="bg-white rounded-lg shadow-xl p-8 w-full max-w-md">
            <div class="flex justify-center mb-6">
                <img src="../src/logo-urca.svg" alt="Logo URCA" class="h-20">
            </div>
            
            <h1 class="text-3xl font-bold text-center text-gray-800 mb-2">URCA Blog</h1>
            <h2 class="text-xl text-center text-gray-600 mb-6">Connexion</h2>
            
            <?php if ($error): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="" class="space-y-6">
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-envelope mr-2"></i>Adresse email
                    </label>
                    <input type="email" id="email" name="email" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-lock mr-2"></i>Mot de passe
                    </label>
                    <input type="password" id="password" name="password" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <button name="login" type="submit" 
                        class="w-full bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-md transition duration-300">
                    Se connecter
                </button>
            </form>
            
            <div class="text-center mt-6">
                <p class="text-gray-600">
                    Pas encore de compte ? 
                    <a href="registration.php" class="text-blue-500 hover:text-blue-600 transition duration-300">
                        S'inscrire
                    </a>
                </p>
            </div>
        </div>
    </main>

    <?php require '../includes/footer.php'; ?>
</body>
</html>
