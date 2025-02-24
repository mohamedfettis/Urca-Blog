<?php 
require_once '../config/database.php';

$mysqli = getConnection();



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $mysqli->prepare('UPDATE news SET title = ?, content = ?, image = ? WHERE idn = ?');
    $stmt->bind_param('ssi', $_POST['title'], $_POST['content'], $_POST['image'], $_POST['idn']);
    $stmt->execute();
    $stmt->close();
    $mysqli->close();
    header('location: news-list.php');
    exit;
    }
if(!isset($_GET['id'])){
    header('location: news-list.php');
    exit;
}

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


<!DOCTYPE html>
<html>
  

    <body>
        <?php require_once '../includes/header.php';?>

        <main class="max-w-2xl mx-auto p-6">
            <h1 class="text-3xl font-bold mb-6">Modifier une actualité</h1>
            <form action="post" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <div class="mb-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Titre</label>
                <input type="text" name="title" id="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?= htmlspecialchars($article['title']) ?>">
                </div>
                <div class="mb-4">
                <label for="content" class="block text-gray-700 text-sm font-bold mb-2">Contenu</label>
                <textarea name="content" id="content" cols="30" rows="10" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"><?= htmlspecialchars($article['content']) ?></textarea>
                </div>
                <div class="mb-6">
                <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Image</label>
                <input type="file" name="image" id="image" class="block w-full text-gray-700 border border-gray-300 rounded py-2 px-3 leading-tight focus:outline-none focus:border-blue-500" value="<?= htmlspecialchars($article['image']) ?>">
                </div>
                <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Modifier
                </button>
                </div>
            </form>
        </main>

        <?php require_once '../includes/footer.php';?>

    </body>
</html>

<?php
$stmt->close();
$mysqli->close();

?>