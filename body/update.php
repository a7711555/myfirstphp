<?php
session_start();
if(@$_SESSION["administrator"] == NULL || $_SESSION["administrator"] == "" || !isset($_SESSION["administrator"])) {
    exit("Admin only  <a href='index.php'>return</a>");
}

$id = @$_GET["id"];

$servername = "localhost";
$username = "";
$password = "";
$dbname = "";




if($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt2 = $conn->addQuery("UPDATE article SET title = :title, content = :content WHERE id = :id", [
        ":title" => $_POST["title"],
        ":content" => $_POST["content"],
        ":id" => $id
    ]);
}

$stmt = $conn->bindQuery(" SELECT title, content FROM article WHERE id = :id", [":id" => $id]);


?>
<!doctype>
<html>
<head>
    <title>Article editor</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
    <form method="POST" action="./update?id=<?php echo $id?>">
        <div>
            <label>title: </label><br />
            <input type="text" name="title" value="<?php echo $stmt[0]["title"]; ?>">
        </div>
        <div>
            <label>content: </label><br />
            <textarea name="content" rows="10" cols="100"><?php echo $stmt[0]['content']; ?></textarea>
        </div>
        <button>submit</button>
    <form>
    <a href="./dashboard">return</a>
</body>
<html>
