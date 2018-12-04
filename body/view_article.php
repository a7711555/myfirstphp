<?php

header("Content-Type:text/html; charset=utf-8");

function search($title) {  
    $conn = Database::get();
 
    // if article id exist or not
    $stmt2 = $conn->bindQuery( "SELECT COUNT(*) FROM article WHERE title LIKE :title", [
        ":title" => "%{$title}%"
    ]);
    if($stmt2[0]['COUNT(*)'] != 0){ // if article exist  
        $stmt = $conn->bindQuery( "SELECT title, content FROM article WHERE  title LIKE :title", [
            ":title" => "%{$title}%"
        ]);
        return "<br />".$stmt[0]["title"]."<br /><br />"."CONTENT:<br />".$stmt[0]["content"];
    } else {
        return "Article doesn't exist!";
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
    <form method="POST" action="./view_article">
        <input type="text" name="title" placeholder="Enter the title">
        <button>Search</button>
    </form>

    <?php 
    if($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["title"])) {
        echo search($_POST["title"]);
    } else {
        echo "Enter a correct keyword!";
    }
    ?>
</body>
</html>