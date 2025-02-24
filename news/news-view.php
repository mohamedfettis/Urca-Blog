<?php 
require_once '../config/database.php';
session_start();
if(!isset($_GET['id'])){
    header('location: news-list.php');
    exit;
}

$mysqli = getConnection();
$stmt = $mysqli->prepare('SELECT * FROM news WHERE idn = ?');
$stmt->bind_param('i', $_GET['id']);
$stmt->execute();
$result = $stmt->get_result();
$article = $result->fetch_assoc();

if (!$article){
    header('location: news-list.php');
    exit;
}
?>

<head>
    <title><?= htmlspecialchars($article['title']) ?></title>
   
</head>
<body>

    <?php require_once '../includes/header.php' ?>
    <main class="bg-gray-50 min-h-screen py-12">
  <div class="container mx-auto px-4">
    <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
      <div class="p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-4"><?= htmlspecialchars($article['title']) ?></h1>
        <p class="text-sm text-gray-500 mb-6"><?= $article['date'] ?></p>
        <?php if ($article['image']): ?>
          <img class="w-full max-h-[500px] mb-6 rounded" src="../img/<?= htmlspecialchars($article['image']) ?>" alt="Image de l'article">
        <?php endif; ?>
        <div class="prose prose-lg text-gray-700 mb-6">
          <?= htmlspecialchars($article['content']) ?>
        </div>
        <a href="news-list.php" class="inline-block px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition duration-300">
          Retour à la liste
        </a>
      </div>
    </div>
  </div>
</main>

    <?php require_once '../includes/footer.php'?>

</body>

</html>

<?php
$stmt->close();
$mysqli->close(); 
?>
