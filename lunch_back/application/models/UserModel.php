<?php

namespace application\models;
use PDO;

class UserModel extends Model {
    public function signup(&$param){
        $sql = "INSERT INTO user
                (
                    social_type, email, pw, nick, birth, job
                )
                VALUES
                (
                    :social_type, :email, :pw, :nick, :birth, :job
                )
                ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':social_type', $param["social_type"]);
        $stmt->bindValue(':nick', $param["nick"]);
        $stmt->bindValue(':email', $param["email"]);
        $stmt->bindValue(':pw', $param["pw"]);
        $stmt->bindValue(':birth', $param["birth"]);
        $stmt->bindValue(':job', $param["job"]);
        $stmt->execute();
        return intval($this->pdo->lastInsertId());
    }

    public function signin(&$param) {
        $sql = " SELECT * FROM user WHERE email = :email ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':email', $param["email"]);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // 중복이메일검사
    public function doubleCheckUser(&$param) {
        $sql = " SELECT social_type, email FROM user
                 WHERE social_type = :social_type AND email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':social_type', $param["social_type"]);
        $stmt->bindValue(':email', $param["email"]);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}