<?php

namespace application\models;
use PDO;

class UserModel extends Model {
    public function signUp(&$param){
        $sql = "INSERT INTO user
                (
                    social_type, email, nick, birth, job, profileimg

                )
                VALUES
                (
                    :social_type, :email, :nick, :birth, :job, :profileimg
                )
                ON duplicate key update
                moddt = now()";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':social_type', $param["social_type"]);
        $stmt->bindValue(':email', $param["email"]);
        $stmt->bindValue(':nick', $param["nick"]);
        $stmt->bindValue(':birth', 0);
        $stmt->bindValue(':job', 0);
        $stmt->bindValue(':profileimg', $param["profileimg"]);
        $stmt->execute();
        return intval($this->pdo->lastInsertId());
    }
}