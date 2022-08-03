<?php
namespace application\models;
use PDO;

class MenuModel extends Model {
    public function menuListbyWeather(&$param) {
        $sql = " SELECT A.* FROM menu_cd A
        INNER JOIN menu_weather B
        ON A.imenu = B.imenu WHERE";
        for($i=0; $i<count($param); $i++) {
            $sql .= " iweather = {$param[$i]}";
            if($i < count($param) - 1) {
                $sql .= " OR";
            }
        }
        $sql .= " GROUP BY A.imenu";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}