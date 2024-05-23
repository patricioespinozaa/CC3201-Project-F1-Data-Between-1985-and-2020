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
    $variable4= $_GET['id4'];

    // Ejecutar la consulta SQL
    $query = "SELECT result.pm, result.nombre, result.agno
            FROM 
    (SELECT eqgp.pm, esc.nombre, agno
        FROM
            (SELECT AVG(vuelta_rapida_c) AS pm, eqes_id, eqt_id 
                FROM f1.equipo_granpremio JOIN f1.granpremio ON gp_id = id
                WHERE fecha>'2008-01-01'
                GROUP BY eqes_id, eqt_id) AS eqgp
            , f1.temporada AS temp
            , f1.escuderia as esc
        WHERE eqgp.eqt_id = temp.id and eqgp.eqes_id = esc.id) AS result
    WHERE result.nombre = :valor4";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':valor4' => $variable4]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
       
    // Mostrar los resultados
    if (count($result) > 0) {
        echo "<h2>Resultados</h2>";
        echo "<table>";
        echo "<tr><th>Tiempo vuelta mas rapida</th><th> Escuderia </th><th>Temporada</th></tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row['eqgp.pm'] . "</td>";
            echo "<td>" . $row['esc.nombre'] . "</td>";
            echo "<td>" . $row['agno'] . "</td>";
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
