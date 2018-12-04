<?php
    session_start();
    if(@$_SESSION["administrator"] == NULL || $_SESSION["administrator"] == "" || !isset($_SESSION["administrator"])) {
        exit("<div>Admin only  <a href='./'>return</a></div>");
    }
?>

<!doctype html>
<html>
<head>
    <title>dashboard</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
    <table border="1">
        <tr>
            <th>Time</th>
            <th>Title</th>
            <th>Function</th>
        </tr>
    <?php
            if($_SERVER["REQUEST_METHOD"] == "GET") {
                $stmt2 = $conn->addQuery( "DELETE FROM article WHERE id = :id", [
                    ":id" => @$_GET["id"]
                ]);
            }
            
            // get datas
            $stmt = $conn->bindQuery("SELECT create_time, title, id FROM article");
            foreach($stmt as $row) {
                $id = $row["id"];
                echo "<tr><td>".$row["create_time"]."</td><td>".$row["title"]."</td><td><a href='./update?id=$id'>修改</a>|<a href='./dashboard?id=$id'>刪除</a></td></tr>";
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