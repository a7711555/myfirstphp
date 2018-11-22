<?php
    session_start();
    if(@$_SESSION["administrator"] == NULL || $_SESSION["administrator"] == "" || !isset($_SESSION["administrator"])) {
        exit("Admin only  <a href='index.php'>return</a>");
    }
?>

<!doctype html>
<html>
<head>
    <title>dashboard</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
    <ul style="display:inline; list-style-type: none;">
        <li style="display:inline;"><a href="/study/">Index|</a></li>
        <li style="display:inline;"><a href="articles.php">All articles|</a></li>
        <li style="display:inline;"><a href="create_article.php">Create article|</a></li>
        <li style="display:inline;"><a href="dashboard.php">Dashboard|</a></li>
        <li style="display:inline;"><a href="view_article.php">Search article</a></li>
    </ul>
    <table border="1">
        <tr>
            <th>Time</th>
            <th>Title</th>
            <th>Function</th>
        </tr>
    <?php
        $servername = "localhost";
        $username = "setfire";
        $password = "aaa111";
        $dbname = "member";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->exec("SET NAMES UTF8");
            $conn->setAttribute( PDO :: ATTR_ERRMODE , PDO :: ERRMODE_EXCEPTION );

            if($_SERVER["REQUEST_METHOD"] == "GET") {
                $stmt3 = $conn->prepare( "DELETE FROM article WHERE id = :id" );
                $stmt3->bindParam(":id", $_GET["id"]);
                $stmt3->execute();
            }

            // get data quantities
            $stmt2 = $conn->prepare( "SELECT COUNT(*) FROM article");
            $stmt2 -> execute();
            $row=$stmt2->fetchAll(PDO::FETCH_ASSOC);
            $num = $row[0]['COUNT(*)'];

            // get datas
            $stmt = $conn->prepare("SELECT create_time, title, id FROM article");
            $stmt -> execute();
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            for($i=0; $i<$num; $i++) {
                $id = $row[$i]["id"];
                echo "<tr><td>".$row[$i]["create_time"]."</td><td>".$row[$i]["title"]."</td><td><a href='update.php?id=$id'>修改</a>|<a href='dashboard.php?id=$id'>刪除</a></td></tr>";
            }
            $conn = NULL;
        }
        catch (PDOException $e) {
            echo "Connect failed: ". $e->getMessage();
        }

    ?>
    </table>
    <form method="POST" action="<?php echo htmlentities($_SERVER["PHP_SELF"]) ?>">
        <input type="hidden" value="logout" name="logout" />
        <button>logout</button>
    </form>
</body>
</html>

<?php
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        session_unset();
        session_destroy();
        echo "<script>window.location.href='index.php';</script>";
    }
?>