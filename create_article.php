<!doctype html>
<html>
<head>
    <title>Post new article</title>
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
    <form method="POST" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>">
        <div>
            <label>title: </label><br />
            <input type="text" name="title" />
        <div>
        <div>
            <label>content: </label><br />
            <textarea  name="content" rows="4" cols="50"></textarea>
        <div>
        <div>
            <input type="radio" name="hide" value="1" /><label> hide article</label>
        </div>
        <button>submit</button>
    </form>
</body>
</html>

<?php
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if(!isset($_POST["hide"])) {
            $_POST["hide"] = 0;
        }
        echo add_article($_POST["title"], $_POST["content"], $_POST["hide"]);
    }

    function add_article($title, $content, $hide) {
        $servername = "localhost";
        $username = "setfire";
        $password = "aaa111";
        $dbname = "member";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->exec("SET NAMES UTF8");
            $conn->setAttribute( PDO :: ATTR_ERRMODE , PDO :: ERRMODE_EXCEPTION );

            
            if($hide) {
                $stmt = $conn->prepare("INSERT INTO article (title, content, is_published) VALUES (:title, :content, :published)");
                $stmt->bindParam(':title', $title);
                $stmt->bindParam(':content', $content);
                $hide = 0;
                $stmt->bindParam(':published', $hide);
                $stmt->execute();
                return "Creating completed!";
            } else {
                $stmt = $conn->prepare("INSERT INTO article (title, content) VALUES (:title, :content)");
                $stmt->bindParam(':title', $title);
                $stmt->bindParam(':content', $content);
                $stmt->execute();
                return "Creating completed!";
            }
        }
        catch(PDOException $e) {
            return "Connect failed: ". $e->getMessage();
        }
        
    }
?>