<?php
$route = new Router(Request::uri()); //搭配 .htaccess 排除資料夾名稱後解析 URL
$route->getParameter(1); // 從 http://127.0.0.1/game/aaa/bbb 取得 aaa 字串之意

$route = new Router(Request::uri()); //搭配 .htaccess 排除資料夾名稱後解析 URL
include('view/header.php'); // 載入共用的頁首
switch($route->getParameter(1)) {
    case "articles":
        include("body/articles.php");
        break;
    case "create_article":
        include("body/create_article.php");
        break;
    case "dashboard":
        include("body/dashboard.php");
        break;
    case "view_article":
        include("body/view_article.php");
        break;
    case "update":
        include("body/update.php");
        break;
    case "poster":
        include("body/poster.php");
        break;
    default:
        include("default.php");
        break;
}
include('view/footer.php'); // 載入共用的頁尾

class Request {
    public static function uri()
    {
        $uri = str_replace(static::getFolderName(), "", static::redirect_url());
        return trim($uri, '/');
    }

    private static function redirect_url() {
        if( isset($_SERVER['REDIRECT_URL']) ) {
            return $_SERVER['REDIRECT_URL'];
        }
        return explode("?", $_SERVER['REQUEST_URI'] )[0];
    }

    private static function getFolderName()
    {
        $folder_name = str_replace("/index.php", "", $_SERVER['PHP_SELF']);
        return $folder_name;
    }
}

class Router {
    private $routes = [
        "^([a-zA-Z0-9-_]+)\/?$",
        "^([a-zA-Z0-9-_]+)\/([a-zA-Z0-9-_]+)\/?$",
        "^([a-zA-Z0-9-_]+)\/([a-zA-Z0-9-_]+)\/([a-zA-Z0-9-_]+)\/?$",
        "^([a-zA-Z0-9-_]+)\/([a-zA-Z0-9-_]+)\/([a-zA-Z0-9-_]+)\/([a-zA-Z0-9-_]+)\/?$"
    ];
    private $parameters = [];
    public function __construct($url) {
        foreach ($this->routes as $route) {
            if (!preg_match("/" . $route . "/", $url, $matches))
                continue;
            $this->parameters = array_slice($matches, 1);
        }
    }
    public function getParameter($index){
      if(isset($this->parameters[($index-1)])){
        return $this->parameters[($index-1)];
      }else{
        return "";
      }
    }
}

?>