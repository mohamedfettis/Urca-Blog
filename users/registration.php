<?php 
require_once '../config/database.php';
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //validation des champs du formulaire
    $lastname = htmlspecialchars(trim($_POST['lastname']));
    $firstname = htmlspecialchars(trim($_POST['firstname']));
    $email =htmlspecialchars(trim( $_POST['email']));
    $confirm_email = htmlspecialchars(trim($_POST['confirm_email']));
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    //verification des informations

    if ($email !== $confirm_email) {
        $error = 'Les emails ne correspondent pas';
    } elseif ($password !== $confirm_password) {
        $error = 'Les mots de passe ne correspondent pas';
        //connextion a la base de donnee 

    } else {
        $mysqli = getConnection();
        $stmt = $mysqli->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows >0){
            $error = "Cet email est déjà utilisé";
        }else{
            //hashage de password 

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            //insertion des informations dans la base de donnee
            $stmt = $mysqli->prepare('INSERT INTO users (lastname,firstname,email,pwd) VALUES (?,?,?,?)');
            $stmt->bind_param('ssss',$lastname,$firstname,$email,$hashed_password);
            if ($stmt->execute()){
                header('location: login.php');
                exit;
            }else{
                $error = 'Une erreur est survenue';
            }

        }
        $mysqli->close();
      
    }
}



?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URCA Blog - Inscription</title>
</head>
<body class="bg-gray-100">
    <?php require '../includes/header.php'; ?>
  <div class="flex items-center justify-center min-h-screen  bg-gray-50">
    <div class="max-w-md w-full bg-white shadow-md my-8 rounded-lg p-8">
      <div class="flex justify-center mb-6">
        <img src="../src/logo-urca.svg" alt="Logo URCA" class="h-12">
      </div>
      <h1 class="text-3xl font-bold text-center text-gray-800 mb-1">URCA Blog</h1>
      <h2 class="text-xl text-center text-gray-600 mb-6">Inscription</h2>
      <?php 
        if ($error) {
          echo '<p class="text-red-500 mb-4">' . $error . '</p>';
        }
      ?>
      <form class="space-y-5" method="POST">
        <!-- Nom -->
        <div class="relative">
          <input type="text" id="username" name="lastname" required placeholder=" "
                 class="peer block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:border-green-500 focus:shadow-md transition-all duration-300 ease-in-out" />
          <label for="username" class="absolute left-3 top-2 text-gray-500 pointer-events-none transition-all duration-300 ease-in-out
                 peer-placeholder-shown:top-2 peer-focus:-top-3 peer-focus:text-xs peer-focus:text-green-500">
            <i class="fas fa-user mr-1"></i> Nom
          </label>
        </div>
        <!-- Prénom -->
        <div class="relative">
          <input type="text" id="firstname" name="firstname" required placeholder=" "
                 class="peer block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:border-green-500 focus:shadow-md transition-all duration-300 ease-in-out" />
          <label for="firstname" class="absolute left-3 top-2 text-gray-500 pointer-events-none transition-all duration-300 ease-in-out
                 peer-placeholder-shown:top-2 peer-focus:-top-3 peer-focus:text-xs peer-focus:text-green-500">
            <i class="fas fa-user mr-1"></i> Prénom
          </label>
        </div>
        <!-- Email -->
        <div class="relative">
          <input type="email" id="email" name="email" required placeholder=" "
                 class="peer block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:border-green-500 focus:shadow-md transition-all duration-300 ease-in-out" />
          <label for="email" class="absolute left-3 top-2 text-gray-500 pointer-events-none transition-all duration-300 ease-in-out
                 peer-placeholder-shown:top-2 peer-focus:-top-3 peer-focus:text-xs peer-focus:text-green-500">
            <i class="fas fa-envelope mr-1"></i> Adresse email
          </label>
        </div>
        <!-- Confirmer email -->
        <div class="relative">
          <input type="email" id="confirm_email" name="confirm_email" required placeholder=" "
                 class="peer block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:border-green-500 focus:shadow-md transition-all duration-300 ease-in-out" />
          <label for="confirm_email" class="absolute left-3 top-2 text-gray-500 pointer-events-none transition-all duration-300 ease-in-out
                 peer-placeholder-shown:top-2 peer-focus:-top-3 peer-focus:text-xs peer-focus:text-green-500">
            <i class="fas fa-envelope mr-1"></i> Confirmer email
          </label>
        </div>
        <!-- Mot de passe -->
        <div class="relative">
          <input type="password" id="password" name="password" required placeholder=" "
                 class="peer block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:border-green-500 focus:shadow-md transition-all duration-300 ease-in-out" />
          <label for="password" class="absolute left-3 top-2 text-gray-500 pointer-events-none transition-all duration-300 ease-in-out
                 peer-placeholder-shown:top-2 peer-focus:-top-3 peer-focus:text-xs peer-focus:text-green-500">
            <i class="fas fa-lock mr-1"></i> Mot de passe
          </label>
        </div>
        <!-- Confirmer mot de passe -->
        <div class="relative">
          <input type="password" id="confirm_password" name="confirm_password" required placeholder=" "
                 class="peer block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:border-green-500 focus:shadow-md transition-all duration-300 ease-in-out" />
          <label for="confirm_password" class="absolute left-3 top-2 text-gray-500 pointer-events-none transition-all duration-300 ease-in-out
                 peer-placeholder-shown:top-2 peer-focus:-top-3 peer-focus:text-xs peer-focus:text-green-500">
            <i class="fas fa-lock mr-1"></i> Confirmer le mot de passe
          </label>
        </div>
        <!-- Bouton d'inscription -->
        <button name="register" type="submit" 
                class="w-full py-2 bg-green-500 hover:bg-green-600 text-white font-bold rounded-md transition duration-300 ease-in-out">
          S'inscrire
        </button>
      </form>
      <div class="mt-6 text-center">
        <p class="text-gray-600">Déjà inscrit ? <a href="login.php" class="text-blue-500 hover:underline">Se connecter</a></p>
      </div>
    </div>
  </div>
    <?php require '../includes/footer.php'; ?>
</body>

</html>
