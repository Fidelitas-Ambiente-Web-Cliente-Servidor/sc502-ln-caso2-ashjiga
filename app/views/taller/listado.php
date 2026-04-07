<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Talleres Disponibles</title>
  <link rel="stylesheet" href="public/css/style.css">
  <script src="public/js/jquery-4.0.0.min.js"></script>
  <script src="public/js/taller.js"></script>
</head>

<body>

  <nav>
    <div class="nav-left">
      <span class="nav-brand">Talleres</span>
      <a href="index.php?page=talleres">Talleres</a>
      <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
      <a href="index.php?page=admin">Administrar</a>
      <?php endif; ?>
    </div>
    <div class="nav-right">
      <span>
        <?= htmlspecialchars($_SESSION['user'] ?? 'Usuario') ?>
      </span>
      <button id="btnLogout" class="btn btn-logout">Cerrar sesión</button>
    </div>
  </nav>

  <main>
    <div class="page-header">
      <div>
        <h2>Talleres disponibles</h2>
        <p style="color:var(--muted);font-size:0.9rem;">Taller para solicitar inscripción</p>
      </div>
    </div>
    <div id="talleres-container" class="talleres-grid">
      <p class="loader">Cargando talleres...</p>
    </div>
  </main>

  <div id="mensaje"></div>
</body>

</html>