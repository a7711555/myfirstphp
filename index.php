<!doctype html>
<html>
<head>
    <title>Hello</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
    <ul style="display:inline; list-style-type: none;">
        <li style="display:inline;"><a href="articles.php">All articles|</a></li>
        <li style="display:inline;"><a href="create_article.php">Create article|</a></li>
        <li style="display:inline;"><a href="dashboard.php">Dashboard|</a></li>
        <li style="display:inline;"><a href="view_article.php">Search article</a></li>
    </ul>

    <h1>Welcome </h1><h2>welcome </h2><h3>welcome</h3>

    <?php
    session_start(); // turn session
    
    // session check
    if(@$_SESSION["administrator"] != "" && $_SESSION["administrator"] != NULL && isset($_SESSION["administrator"])) {
        echo "HI, Admin<br /><br />      
        <form method='POST' action=". htmlentities($_SERVER["PHP_SELF"]). ">
            <input type='hidden' value='logout' name='logout' />
            <button>logout</button>
        </form>";
    } else {
        echo 
        '<div>
            <form method="POST" action="index.php">
                Admin: 
                <input type="text" name="pwd">
                <button>login</button>
            </form>
        </div>';
    }


    if($_SERVER["REQUEST_METHOD"] == "POST") {
        // logout
        if(@$_POST["logout"] == "logout") {
            session_unset();
            session_destroy();
            exit("<script>window.location.href='index.php';</script>");
        }

        // login
        if (md5($_POST["pwd"]) === "eabd8ce9404507aa8c22714d3f5eada9") {
            $_SESSION["administrator"] = "eabd8ce9404507aa8c22714d3f5eada9";
            header('refresh:1;url=""') ;
        } else {
            echo "<script>alert('invalid password');</script>";
        }

    }
    ?>
    
</body>
</html>