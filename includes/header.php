<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">
  <!-- Ajout de l'id "navbar" et de la transition pour le scroll -->
  <header id="navbar" class="bg-transparent backdrop-blur-md shadow-md fixed w-full top-0 z-50 transition-transform duration-300">
    <div class="container mx-auto px-4 py-3">
      <div class="flex items-center justify-between">
        <div class="flex-shrink-0">
          <a href="/urca/index.php">
            <img src="/urca/src/logo-urca.svg" alt="URCA Logo" class="h-12">
          </a>
        </div>
        <div class="md:hidden">
          <button class="menu-toggle text-black hover:text-gray-700 text-2xl focus:outline-none">
            <i class="fas fa-bars"></i>
          </button>
        </div>
        <nav class="hidden md:block w-full md:w-auto">
          <ul class="flex flex-col items-center md:flex-row md:space-x-8 md:mt-0">
            <li>
              <a href="../news/news-list.php" class="flex items-center py-2 text-black hover:text-gray-700">
                <i class="fas fa-newspaper mr-2"></i>
                Liste des actualités
              </a>
            </li>
            <?php if (!isset($_SESSION['user_id'])): ?>
              <li>
                <a href="/urca/users/registration.php" class="flex items-center py-2 text-black hover:text-gray-700">
                  <i class="fas fa-user-plus mr-2"></i>
                  Inscription
                </a>
              </li>
              <li>
                <a href="/urca/users/login.php" class="flex items-center py-2 px-4 bg-green-500 text-black rounded-lg hover:bg-green-600 transition duration-300">
                  <i class="fas fa-sign-in-alt mr-2"></i>
                  Connexion
                </a>
              </li>
            <?php else: ?>
              <li>
                <a href="/urca/users/user-profil.php" class="flex items-center py-2 text-black hover:text-gray-700">
                  <i class="fas fa-user mr-2"></i>
                  Espace Privé
                </a>
              </li>
              <li>
                <a href="/urca/news/news-add.php" class="flex items-center py-2 text-black hover:text-gray-700">
                  <i class="fas fa-plus-circle mr-2"></i>
                  Ajouter une actualité
                </a>
              </li>
              <li>
                <a href="/urca/users/disconnect.php" class="flex items-center p-2 bg-red-500 text-black rounded-lg hover:bg-red-600 transition duration-300">
                  <i class="fas fa-sign-out-alt mr-2"></i>
                </a>
              </li>
            <?php endif; ?>
          </ul>
        </nav>
      </div>
    </div>
  </header>

  <!-- Espace pour compenser la hauteur du header fixe -->
  <div class="pt-20"><!-- Spacer for fixed header --></div>

  
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Toggle du menu mobile
      const menuToggle = document.querySelector('.menu-toggle');
      const mainNav = document.querySelector('nav');

      menuToggle.addEventListener('click', function () {
        mainNav.classList.toggle('hidden');
        mainNav.classList.toggle('block');
        mainNav.classList.toggle('absolute');
        mainNav.classList.toggle('top-16');
        mainNav.classList.toggle('left-0');
        mainNav.classList.toggle('right-0');
        mainNav.classList.toggle('bg-white');
        mainNav.classList.toggle('z-50');
        mainNav.classList.toggle('p-4');
      });

      // Gestion de l'affichage du header au scroll
      let lastScrollY = window.pageYOffset;
      const navbar = document.getElementById('navbar');

      window.addEventListener('scroll', () => {
        const currentScrollY = window.pageYOffset;
        if (currentScrollY > lastScrollY) {
          navbar.classList.add('-translate-y-full');
        } else {
          navbar.classList.remove('-translate-y-full');
        }
        lastScrollY = currentScrollY;
      });
    });
  </script>
</body>
</html>
