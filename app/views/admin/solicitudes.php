<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Administrar Solicitudes</title>
  <link rel="stylesheet" href="public/css/style.css">
  <script src="public/js/jquery-4.0.0.min.js"></script>
  <script src="public/js/solicitud.js"></script>
</head>

<body>

  <nav>
    <div class="nav-left">
      <span class="nav-brand">Talleres</span>
      <a href="index.php?page=talleres">Talleres</a>
      <a href="index.php?page=admin">Solicitudes</a>
    </div>
    <div class="nav-right">
      <span>Admin:
        <?= htmlspecialchars($_SESSION['user'] ?? 'Administrador') ?>
      </span>
      <button id="btnLogout" class="btn btn-logout">Cerrar sesión</button>
    </div>
  </nav>

  <main>
    <div class="page-header">
      <div>
        <h2>Solicitudes pendientes</h2>
        <p style="color:var(--muted);font-size:0.9rem;">Aprobar o rechazar solicitudes de inscripción</p>
      </div>
    </div>
    <div class="table-container">
      <table id="tabla-solicitudes">
        <thead>
          <tr>
            <th>ID</th>
            <th>Taller</th>
            <th>Usuario</th>
            <th>Cupos</th>
            <th>Fecha</th>
            <th>Opciones</th>
          </tr>
        </thead>
        <tbody id="solicitudes-body">
          <tr>
            <td colspan="6" class="loader">Cargando solicitudes...</td>
          </tr>
        </tbody>
      </table>
    </div>
  </main>

  <div id="mensaje"></div>
</body>

</html>