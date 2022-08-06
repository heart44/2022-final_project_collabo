<?php

namespace application\models;
use PDO;

class UserModel extends Model {
    public function signup(&$param){
        $sql = "INSERT INTO user
                (
                    social_type, email, nick, pw, birth, job
                )
                VALUES
                (
                    :social_type, :email, :nick, :pw, :birth, :job
                )
                -- ON duplicate key update
                -- moddt = now()
                ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':social_type', $param["social_type"]);
        $stmt->bindValue(':nick', $param["nick"]);
        $stmt->bindValue(':email', $param["email"]);
        $stmt->bindValue(':pw', $param["pw"]);
        $stmt->bindValue(':birth', $param["birth"]);
        $stmt->bindValue(':job', $param["job"]);
        $stmt->execute();
        return $stmt->rowCount();
        // return intval($this->pdo->lastInsertId());
    }

    public function signin(&$param) {
        $sql = " SELECT * FROM user WHERE email = :email ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':email', $param["email"]);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}