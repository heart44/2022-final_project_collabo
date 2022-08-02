<<<<<<< HEAD
<?php
namespace application\models;

use Exception;
use PDO;

class Model {
    public function __construct() {
        $dsn = _DBTYPE . ':host=' ._DBHOST. ';dbname=' . _DBNAME . ';charset=' . _CHARSET;
        try {
            $this->pdo = new PDO($dsn, _DBUSER, _DBPASSWORD);

            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(Exception $e) {
            var_dump("DB 접속 중 에러가 발생하였습니다. :::: " . $e->getMessage());
        }
    }
}
=======
<?php
namespace application\models;

use Exception;
use PDO;

class Model {
    public function __construct() {
        $dsn = _DBTYPE . ':host=' ._DBHOST. ';dbname=' . _DBNAME . ';charset=' . _CHARSET;
        try {
            $this->pdo = new PDO($dsn, _DBUSER, _DBPASSWORD);

            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(Exception $e) {
            var_dump("DB 접속 중 에러가 발생하였습니다. :::: " . $e->getMessage());
        }
    }
}
>>>>>>> 93f5c0f25fc41565e98c2054866523d2f5e27c06
