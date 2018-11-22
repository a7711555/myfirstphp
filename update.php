<?php
session_start();
if(@$_SESSION["administrator"] == NULL || $_SESSION["administrator"] == "" || !isset($_SESSION["administrator"])) {
    exit("Admin only  <a href='index.php'>return</a>");
}

$id = @$_GET["id"];

$servername = "localhost";
$username = "setfire";
$password = "aaa111";
$dbname = "member";


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->exec("SET NAMES UTF8");
    $conn->setAttribute( PDO :: ATTR_ERRMODE , PDO :: ERRMODE_EXCEPTION );

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $stmt2 = $conn->prepare("UPDATE article SET title = :title, content = :content WHERE id = :id");
        $stmt2->bindParam(":title", $_POST["title"]);
        $stmt2->bindParam(":content", $_POST["content"]);
        $stmt2->bindParam(":id", $id);
        $stmt2->execute();
    }
    
    $stmt = $conn->prepare(" SELECT title, content FROM article WHERE id = :id");
    $stmt->bindParam(":id", $id );
    $stmt->execute();
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
catch (PDOEXception $e) {
    echo "Connect Failed: ". $e->getMessage();
}
?>
<!doctype>
<html>
<head>
    <title>Article editor</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
    <form method="POST" action="update.php?id=<?php echo $id?>">
        <div>
            <label>title: </label><br />
            <input type="text" name="title" value="<?php echo $row[0]["title"]; ?>">
        </div>
        <div>
            <label>content: </label><br />
            <textarea name="content" rows="10" cols="100"><?php echo $row[0]['content']; ?></textarea>
        </div>
        <button>submit</button>
    <form>
    <a href="dashboard.php">return</a>
</body>
<html>