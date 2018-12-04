<?php
class MyPDO extends PDO {
    private $_dsn = 'mysql:host=localhost;dbname=dbname';
    private $_user = 'dbuser';
    private $_pwd = 'dbpwd';
    private $_encode = 'utf8';
    private $_stmt;

    function __construct() {
        try {
            parent::__construct($this->_dsn, $this->_user, $this->_pwd);
            $this->__setEncode();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    private function __setEncode() {
        $this->query("SET NAMES '{$this->_encode}'");
        $this->setAttribute( PDO :: ATTR_ERRMODE , PDO :: ERRMODE_EXCEPTION );
    }

    function bindQuery($sql, array $bind=[]) {
        $this->_stmt = $this->prepare($sql);
        $this->_bind($bind);
        $this->_stmt->execute();
        return $this->_stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    function addQuery($sql, array $bind=[]) {
        $this->_stmt = $this->prepare($sql);
        $this->_bind($bind);
        $this->_stmt->execute();
    }

    private function _bind($bind) {
        foreach($bind as $key=>$value) {
            $this->_stmt->bindValue($key, $value, is_numeric($value)?PDO::PARAM_INT:PDO::PARAM_STR);
        }
    }

    function getError() {
        $error = $this->_stmt->errorInfo();
        echo "errorCode: " . $error[0] . ", errorMsg: " . $error[2];
    }
}