
<head>
    <title>Poster</title>
</head>
<body>
    <form method="POST">
        <div>
            <label>Recipient</label>
            <input type="email" name="emailto">
        </div>
        <div>
            <label>Subject</label>
            <input type="text" name="subject">
        </div>
        <div>
            <label>Your email</label>
            <input type="email" name="mailfrom">
        </div>
        <div>
            <label>Your name</label>
            <input type="text" name="mailfromname">
        </div>
        <div>
            <textarea name="content" cols="20" rows="5"></textarea>
        </div>
        <button>submit</button>
    </form>
</body>


<?php
class Config {
    const MAIL_USER_NAME = "user@gmail.com"; // 用來寄信的 GMAIL 帳號
    const MAIL_USER_PASSWROD = "password";      // 用來寄信的 GMAIL 密碼
}

header('Content-Type: text/html; charset=utf-8');
if(!empty($_POST)) {
    try { 
        $to = $_POST["emailto"];
        $subject = $_POST["subject"];
        $body = $_POST["content"];
        $mail = new Mail(Config::MAIL_USER_NAME, Config::MAIL_USER_PASSWROD);
        $mail->setFrom($_POST["mailfrom"], $_POST["mailfromname"]);
        $mail->addAddress($to);
        $mail->subject($subject);
        $mail->body($body);
        if($mail->send()){
            echo "<div style='color:green;'>success<div>";
        }else{
            echo "<div style='color:red;'>fail</div>";
        }
    } catch(Exception $e) {
        echo 'Caught exception: ',  $e->getMessage();
        $error[] = $e->getMessage();
    }
}
?>