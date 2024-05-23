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
   $port = 0000;

   $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password";

   try {
       $pdo = new PDO($dsn);
   } catch (PDOException $e) {
       die("Error al conectar con la base de datos: " . $e->getMessage());
   }
   
    // Recibe el input 
    $variable2= $_GET['id21'];
    $variable3= $_GET['id22'];

    // Ejecutar la consulta SQL
    $query = "
    SELECT pi.nombre, grpr.nombre
    FROM f1.equipo_granpremio JOIN f1.piloto AS pi ON eqpi_id = pi.id 
        JOIN f1.escuderia AS esc ON eqes_id = esc.id 
        JOIN f1.temporada AS temp ON eqt_id = temp.id
        JOIN f1.granpremio AS grpr ON gp_id = grpr.id
    WHERE posicion_carrera = 1 AND esc.nombre = :valor2 AND temp.agno = :valor3;";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':valor2' => $variable2, ':valor3' => $variable3]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
       
    // Mostrar los resultados
    if (count($result) > 0) {
        echo "<h2>Resultados</h2>";
        echo "<table>";
        echo "<tr><th>Tiempo vuelta mas rapida</th><th> Escuderia </th><th>Temporada</th></tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row['pi.nombre'] . "</td>";
            echo "<td>" . $row['grpr.nombre'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron resultados.";
    }

    // Cerrar la conexionn
    $pdo = null;
?>
</body>
</html>
