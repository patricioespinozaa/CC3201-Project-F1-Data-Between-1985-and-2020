<!DOCTYPE html>
<html lang="en">
    <head>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    </head>
<body>
    <?php
        echo "<table>";
        echo "<tr>
                <th> id de estudiante </th>
                <th> n° ejercicio </th>
                <th> nota </th>
            </tr>";
        class TableRows extends RecursiveIteratorIterator {
            function __construct($it) {
                parent::__construct($it, self::LEAVES_ONLY);
            }
            function current() {
                return "<td>" . parent::current(). "</td>";
            }
            function beginChildren() {
                echo "<tr>";
            }
            function endChildren() {
                echo "</tr>" . "\n";
            }
        }

        try {
            $pdo = new PDO('psql:
                            host=localhost;
                            port=0000;
                            dbname=cc3201
                            user=webuser;
                            password=f1_team');
            $variable1=$_GET['id3'],
            $stmt = $pdo->prepare('SELECT nombre 
                                    FROM f1.piloto 
                                    WHERE nombre = :valor1');
            $stmt->execute( ['valor1' => $variable1]);
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

            foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
                echo $v;
            }
        }
        echo "</table>";
    ?>
</body>
</html>