<?php 
session_start();
require_once 'config/database.php';
$mysqli = getConnection();
if ($mysqli->connect_error) {
    die("Erreur de connexion : " . $mysqli->connect_error);
}

if (!$_SESSION['user_id']) {
    $result = $mysqli->query("SELECT * FROM news ORDER BY date DESC LIMIT 3");

  
}else{
    $result = $mysqli->query("SELECT * FROM news ORDER BY date DESC");

}


$user = $mysqli->query('SELECT * FROM users WHERE idu = ?');






?>
<head>
    <link rel="stylesheet" href="css/index.css">
    <title>Accueil</title>
</head>
<?php
// Inclure le header
include 'includes/header.php';
?>
<?php if(!$_SESSION['user_id']): ?>
        <section class="relative bg-cover bg-fixed bg-center h-screen" style=" background-image: url('src/bg1.jpeg');">
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <div class="relative flex items-center justify-center h-full">
            <div class="text-center text-white">
            <h1 class="text-4xl md:text-6xl font-semibold font-bold mb-6">Découvrez nos articles</h1>
            <a href="news-list.php" class="inline-block bg-transparent hover:opacity-50 border border-white  text-white font-bold py-3 px-6 rounded transition duration-300">
                    Voir nos articles
            </a>
            </div>
            </div>
        </section>

    <?php endif; ?>   
<main class="main-content bg-gray-50 py-8">
<h2 class="text-2xl font-semibold mb-6 text-gray-800 ml-4" >Nos derniers articles</h2>
    
  <section class="articles-section container mx-auto px-4 grid gap-6 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
    
    <?php while ($articl = $result->fetch_assoc()): ?>
      <div class="article-card bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-2xl transition-shadow duration-300 border-t-4 border-[#B17613] max-h-[800px] flex flex-col">
        <img src="img/<?= htmlspecialchars($articl['image']) ?>" alt="Image de l'article" class="article-image w-full h-48 object-cover">
        <div class="article-info p-4 flex flex-col flex-grow">
          <h2 class="article-title max-h-[50px]  flex-grow overflow-hidden text-xl font-semibold text-[#B17613]"><?= $articl['title']; ?></h2>
          <p class="article-description mt-2 text-gray-700 max-h-[200px] overflow-y-auto flex-grow overflow-hidden">
            <?= $articl['content'] ?>
          </p>
          <div class="article-meta mt-4 flex justify-between text-sm text-gray-500">
            <span class="article-author">Auteur: <?= $articl['author'] ?></span>
            <span class="article-date">Date: <?= $articl['date'] ?></span>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </section>
</main>



<?php
include 'includes/footer.php';

?>