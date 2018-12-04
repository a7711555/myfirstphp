<!doctype html>
<html>
<head>
    <title>Post new article</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
    <form method="POST">
        <div>
            <label>title: </label><br />
            <input type="text" name="title" />
        <div>
        <div>
            <label>content: </label><br />
            <textarea  name="content" rows="4" cols="50"></textarea>
        <div>
        <div>
            <input type="checkbox" id="hide" name="hide" value="1" /><label for="hide"> hide article</label>
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
    $conn = Database::get();
    if($hide) {
        $stmt = $conn->addQuery("INSERT INTO article (title, content, is_published) VALUES (:title, :content, 0)", [
            ":title" => $title,
            ":content" => $content
        ]);
        return "Creating completed!";
    } else {
        $stmt = $conn->addQuery("INSERT INTO article (title, content) VALUES (:title, :content)", [
            ":title" => $title,
            ":content" => $content
        ]);
        return "Creating completed!";
    }
}
?>