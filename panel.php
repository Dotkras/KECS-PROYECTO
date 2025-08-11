<?php 
session_start();

header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

require_once 'db.php';

// ✅ Validar solo que haya sesión activa
if (!isset($_SESSION['usuario']) || !isset($_SESSION['rol']) || $_SESSION['usuario'] === "") {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gestión de Zapatería</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      /* Fondo degradado animado rojo y negro */
      background: linear-gradient(-45deg, #ff0000, #000000, #ff0000, #000000);
      background-size: 400% 400%;
      animation: gradient 10s ease infinite;
    }

    @keyframes gradient {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    header {
      background-color: rgba(0,0,0,0.85);
      color: white;
      padding: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    main {
      max-width: 900px;
      margin: 30px auto;
      padding: 20px;
      background-color: rgba(255,255,255,0.9);
      box-shadow: 0 0 10px rgba(0,0,0,0.3);
      border-radius: 8px;
    }
    h1 {
      margin: 0;
      color: white;
    }
    .titulo-principal {
      text-align: center;
      font-size: 2.5em;
      font-weight: bold;
      color: white;
      margin-top: 20px;
      text-shadow: 2px 2px 5px black;
    }
    a.logout-button {
      background-color: #dc3545;
      color: white;
      padding: 8px 15px;
      border-radius: 5px;
      text-decoration: none;
      font-weight: bold;
      transition: background-color 0.3s ease;
    }
    a.logout-button:hover {
      background-color: #b02a37;
    }
    .subtitulo {
      font-size: 1.4em;
      margin-bottom: 20px;
      color: #6c757d;
      text-align: center;
      font-weight: bold;
    }
    a.button {
      display: inline-block;
      margin-bottom: 20px;
      padding: 10px 20px;
      background-color: #28a745;
      color: white;
      text-decoration: none;
      border-radius: 5px;
    }
    a.button:hover {
      background-color: #218838;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      padding: 12px;
      text-align: center;
      border-bottom: 1px solid #dee2e6;
    }
    th {
      background-color: #007bff;
      color: white;
    }
    tr:nth-child(even) {
      background-color: #f2f2f2;
    }
    .acciones a {
      margin: 0 5px;
      text-decoration: none;
      color: #007bff;
    }
    .acciones a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <header>
    <h1>Gestión de Zapatería</h1>
    <a href="logout.php" class="logout-button">Cerrar sesión</a>
  </header>

  <div class="titulo-principal">Zapatería Reynaldo</div>

  <main>
    <?php if ($_SESSION['rol'] === 'admin'): ?>
      <a class="button" href="agregar.php">Agregar Producto</a>
    <?php endif; ?>

    <table>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Talla</th>
        <th>Precio</th>
        <th>Stock</th>
        <th>Acciones</th>
      </tr>
      <?php
      $result = $conn->query("SELECT * FROM productos");
      while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['nombre']}</td>
                <td>{$row['talla']}</td>
                <td>\${$row['precio']}</td>
                <td>{$row['stock']}</td>
                <td class='acciones'>";

        if ($_SESSION['rol'] === 'admin') {
            echo "<a href='editar.php?id={$row['id']}'>Editar</a> | 
                  <a href='eliminar.php?id={$row['id']}' onclick=\"return confirm('¿Seguro?')\">Eliminar</a>";
        } else {
            echo "No autorizado";
        }

        echo    "</td>
              </tr>";
      }
      ?>
    </table>
  </main>

  <script>
    if (window.performance && performance.navigation.type === performance.navigation.TYPE_BACK_FORWARD) {
      window.location.href = 'index.php';
    }
  </script>
</body>
</html>
