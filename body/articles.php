<!doctype html>
<html>
<head>
    <title>Articles</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>


<?php

$stmt = $conn->bindQuery("SELECT title, content, is_published FROM article");
echo "<table border='1'>";
foreach($stmt as $row) {
    if($row["is_published"]) {
        echo "<tr><td>".$row["title"]."</td><td>".$row["content"]."</td></tr>";
    } else {
        echo "<div>One article is not publish!</div>";
    }
}

echo "</table>";
?>