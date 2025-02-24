<?php
require_once '../config/database.php';
$mysqli = getConnection();
session_start();

$result = $mysqli->query('SELECT * FROM news ORDER BY date DESC');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des actualités</title>
</head>
<body class="bg-gray-100">
    <?php require '../includes/header.php'; ?>
    
    <main class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Liste des actualités</h1>
        <div class="space-y-6">
            <?php while ($article = $result->fetch_assoc()): ?>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-semibold">
                            <a href="news-view.php?id=<?= $article['idn'] ?>" 
                               class="text-blue-600 hover:text-blue-800 transition duration-300">
                                <?= htmlspecialchars($article['title']) ?>
                            </a>
                        </h2>
                        <?php if ($_SESSION['lastname'].' '.$_SESSION['firstname']===$article['author']) :?>
                            <div class="flex space-x-4">
                                <a href="news-modif.php?id=<?= $article['idn'] ?>" 
                                   class="text-yellow-500 hover:text-yellow-600 transition duration-300">
                                    <i class="fas fa-edit"></i> Modifier
                                </a>
                                <a href="news-remove.php?id=<?= $article['idn'] ?>" 
                                   class="text-red-500 hover:text-red-600 transition duration-300">
                                    <i class="fas fa-trash"></i> Supprimer
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <?php 
        $result->free();
        $mysqli->close();
        ?>
    </main>

    <?php require '../includes/footer.php'; ?>
</body>
</html>
