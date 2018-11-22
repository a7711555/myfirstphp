<?php

header("Content-Type:text/html; charset=utf-8");

function search($title) {
    $servername = "localhost";
    $username = "setfire";
    $password = "aaa111";
    $dbname = "member";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->exec("SET NAMES UTF8");
        $conn->setAttribute( PDO :: ATTR_ERRMODE , PDO :: ERRMODE_EXCEPTION );
        
        // if article id exist or not
        $stmt2 = $conn->prepare( "SELECT COUNT(*) FROM article WHERE title LIKE ?" );
        $param = array("%$title%");
        $stmt2 -> execute($param);
        $row=$stmt2->fetchAll(PDO::FETCH_ASSOC);
        if($row[0]['COUNT(*)'] != 0){ // if article exist  
            $stmt = $conn->prepare( "SELECT title, content FROM article WHERE  title LIKE ?" );
            $param = array("%$title%");
            $stmt -> execute($param);
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return "<br />".$row[0]["title"]."<br /><br />"."CONTENT:<br />".$row[0]["content"];
        } else {
            return "Article doesn't exist!";
        }
    } 
    catch (PDOException $e) {
        echo "Connect failed: ". $e->getMessage();
    }
}

$conn = null; 
?>

<!doctype html lang="zh-Hant-TW">
<html>
<head>
    <title>view articles</title>
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
    <form method="POST" action="<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>">
        <input type="text" name="title" placeholder="Enter the title">
        <button>Search</button>
    </form>

    <?php 
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        echo search($_POST["title"]);
    }
    ?>
</body>
</html>