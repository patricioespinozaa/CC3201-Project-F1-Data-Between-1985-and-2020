<!DOCTYPE html>
<html>
  <head>
    <title>Circuitos en el pais</title>
  </head>
<body>

<head>
  <title>Tabla Enmarcada</title>

  <style>
    table {
      border-collapse: collapse;
      width: 100%;
    }

    th, td {
      border: 1px solid black;
      padding: 8px;
      text-align: left;
    }
    body {
    background-color: #eaf2ff;
}
    th {
      background-color: #FFCBA4;
    }
  </style>

</head>

<body>
   <?php
   // Establecer la conexion con la base de datos
   $host = 'localhost';
   $dbname = 'cc3201';
   $user = 'webuser';
   $password = 'f1_team';
   $port = '0000';

   $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password";

   try {
       $pdo = new PDO($dsn);
   } catch (PDOException $e) {
       die("Error al conectar con la base de datos: " . $e->getMessage());
   }
   
    // Recibe el input 
    $variable2= $_GET['id'];

    // Ejecutar la consulta SQL
    $query = "SELECT nombre FROM (SELECT cir_id FROM f1.circuito_pais WHERE pa_id = :valor1) AS cirid JOIN f1.circuito ON cirid.cir_id = id";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':valor2' => $variable2]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
       
    // Mostrar los resultados
    if (count($result) > 0) {
        echo "<h2>Resultados</h2>";
        echo "<table>";
        echo "<tr><th>Nombre de los circuitos</th></tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row['nombre'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron resultados.";
    }

    // Cerrar la conexi�n
    $pdo = null;
?>
</body>
</html>
