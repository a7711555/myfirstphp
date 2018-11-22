<!doctype html>
<html>
<head>
    <title>Articles</title>
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
</body>
</html>


<?php
$servername = "localhost";
$username = "setfire";
$password = "aaa111";
$dbname = "member";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->exec("SET NAMES UTF8");
    $conn->setAttribute( PDO :: ATTR_ERRMODE , PDO :: ERRMODE_EXCEPTION );
    
    // if article id exist or not
    $stmt2 = $conn->prepare( "SELECT COUNT(*) FROM article");
    $stmt2 -> execute();
    $row=$stmt2->fetchAll(PDO::FETCH_ASSOC);
    $num = $row[0]['COUNT(*)'];
    $stmt = $conn->prepare("SELECT title, content, is_published FROM article");
    $stmt->execute();
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<table border='1'>";
    for($i=0; $i<$num; $i++) {
        if($row[$i]["is_published"]) {
            echo "<tr><td>".$row[$i]["title"]."</td><td>".$row[$i]["content"]."</td></tr>";
        } else {
            echo "<div>One article is not publish!</div>";
        }
    }
    echo "</table>";
    $conn = null ; 
} 
catch (PDOException $e) {
    echo "Connect failed: ". $e->getMessage();
}
?>