<?php
session_start();
require_once '../config/database.php';

// Vérification de l'authentification
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$error = '';
$success = '';
$author = $_SESSION['lastname'].' '.$_SESSION['firstname'];


if (isset($_POST['submit'])) {
    $mysqli = getConnection();
    $image = null;
    
    // Validation CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = "Erreur de sécurité, veuillez réessayer";
    } else {
        // Nettoyage des données
        $title = trim($_POST['title']);
        $content = trim($_POST['content']);
        // Validation des champs
        if (empty($title) || empty($content)) {
            $error = "Le titre et le contenu sont obligatoires";
        } else {
            // Gestion de l'image
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                $filename = $_FILES['image']['name'];
                $filetype = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                $maxSize = 2 * 1024 * 1024; //2mo

                if (!in_array($filetype, $allowed)) {
                    $error = "Format de fichier non autorisé";
                } elseif ($_FILES['image']['size'] > $maxSize) {
                    $error = "Le fichier est trop volumineux (max 2 Mo)";
                } else {
                    $targetDir = '../img/';
                    if (!is_dir($targetDir) && !mkdir($targetDir, 0755, true)) {
                        $error = "Erreur de création du dossier";
                    } else {
                        $image = uniqid() . '.' . $filetype;
                        if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetDir . $image)) {
                            $error = "Erreur lors de l'upload";
                            $image = null;
                        }
                    }
                }
            }

            if (empty($error)) {
                $stmt = $mysqli->prepare('INSERT INTO news (title, content, image, author, date) VALUES (?, ?, ?, ?, NOW())');
                if ($stmt) {
                    $stmt->bind_param('ssss', $title, $content, $image, $author);

                    if ($stmt->execute()) {
                        $_SESSION['success'] = "Actualité ajoutée avec succès";
                        header('refresh:1;url=news-list.php');
                        exit();
                    } else {
                        $error = "Erreur base de données: " . $stmt->error;
                    }
                    $stmt->close();
                } else {
                    $error = "Erreur de préparation: " . $mysqli->error;
                }
            }
        }
    }
    $mysqli->close();
}

// Génération token CSRF
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une actualité</title>
</head>


<body>
<?php require '../includes/header.php'; ?>


<main class="flex items-center justify-center min-h-screen bg-gray-100">
  <div class="container m-10 p-4 md:p-8 bg-white rounded-lg shadow-xl">
    <?php if ($error): ?>
      <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded transition duration-300">
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <h1 class="text-3xl font-bold mb-6 text-gray-800">Ajouter une actualité</h1>
    
    <form method="post" enctype="multipart/form-data" class="space-y-6">
      <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

      <div class="form-group space-y-2">
        <label for="title" class="block text-sm font-medium text-gray-700">Titre *</label>
        <input 
          type="text" 
          name="title" 
          id="title" 
          required 
          value="<?= isset($_POST['title']) ? htmlspecialchars($_POST['title']) : '' ?>"
          class="w-full py-2 px-3 border border-gray-300 rounded focus:outline-none focus:border-green-500 focus:shadow-lg transition duration-300"
        >
      </div>

      <div class="form-group space-y-2">
        <label for="author" class="block text-sm font-medium text-gray-700">Auteur</label>
        <input 
          type="text" 
          name="author" 
          id="author" 
          readonly 
          value="<?= $author ?>"
          class="w-full py-2 px-3 border border-gray-300 rounded bg-gray-100 text-gray-700 cursor-not-allowed"
        >
      </div>

      <div class="form-group space-y-2">
        <label for="content" class="block text-sm font-medium text-gray-700">Contenu *</label>
        <textarea 
          name="content" 
          id="content" 
          required 
          rows="10"
          class="w-full py-2 px-3 border border-gray-300 rounded focus:outline-none focus:border-green-500 focus:shadow-lg transition duration-300"
        ><?= isset($_POST['content']) ? htmlspecialchars($_POST['content']) : '' ?></textarea>
      </div>

      <div class="form-group space-y-2">
        <label for="image" class="block text-sm font-medium text-gray-700">Image (optionnel, max 2 Mo)</label>
        <input 
          type="file" 
          name="image" 
          id="image" 
          accept="image/*" 
          class="w-full py-2 px-3 border border-gray-300 rounded focus:outline-none focus:border-green-500 focus:shadow-lg transition duration-300"
        >
      </div>

      <div class="form-actions flex space-x-4">
        <button 
          type="submit" 
          name="submit" 
          class="px-6 py-2 bg-green-500 hover:bg-green-600 text-white font-bold rounded transition duration-300"
        >
          Poster
        </button>
        <a 
          href="news-list.php" 
          class="px-6 py-2 bg-red-500 hover:bg-red-600 text-white font-bold rounded transition duration-300"
        >
          Annuler
        </a>
      </div>
    </form>
  </div>
</main>


    <?php include_once '../includes/footer.php'; ?>


    
</body>

</html>