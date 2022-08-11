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

    public function updateUser(&$param) {
        $sql = "UPDATE user SET ";
        if(isset($param['nick']) && isset($param['birth']) && isset($param['job'])){
           $sql .= "nick = '{$param['nick']}', 
            birth = '{$param['birth']}', 
            job = '{$param['job']}', ";
        }
        if(isset($param['pw']) && $param['pw'] !== "") {
            $sql .= "pw = '{$param['pw']}', ";
        }
        if(isset($param['profileimg']) !== "") {
            $sql .= "profileimg = '{$param['profileimg']}',";
        }
        $sql .= " moddt = NOW() 
        WHERE iuser = :iuser";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':iuser', $param["iuser"]);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function selRest(&$param) {
        $sql = " SELECT * FROM restaurant WHERE ";
        for($i = 0; $i<count($param); $i++) {
            $sql .= "rest_name LIKE '%{$param[$i]}%' ";
            if($i !== count($param)-1) {
                $sql .= "OR ";
            }
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function insDiary(&$param) {
        $sql = "INSERT INTO user_diary
        (
            iuser, irest, rest_name, rating, text, eatdt, path
        )
        VALUES
        (
            :iuser, :irest, :rest_name, :rating, :text, :eatdt, :path
        )";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':iuser', $param["iuser"]);
        $stmt->bindValue(':irest', $param["irest"]);
        $stmt->bindValue(':rest_name', $param["rest_name"]);
        $stmt->bindValue(':rating', $param["rating"]);
        $stmt->bindValue(':text', $param["text"]);
        $stmt->bindValue(':eatdt', $param["eatdt"]);
        $stmt->bindValue(':path', $param["path"]);
        $stmt->execute();
        return intval($this->pdo->lastInsertId());
    }

    public function getDiary(&$param) {
        $sql = " SELECT * FROM user_diary WHERE iuser = :iuser ";
        if(isset($param["idiary"])) {
            $sql .= "AND idiary = {$param["idiary"]}";
        }
        $sql .= " ORDER BY eatdt";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':iuser', $param["iuser"]);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function updateDiary(&$param) {
        $sql = "UPDATE user_diary SET
                moddt = NOW(),
                irest = :irest,
                rest_name = :rest_name,
                rating = :rating,
                text = :text,
                eatdt = :eatdt,
                path = :path
                WHERE iuser = :iuser AND idiary = :idiary";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':iuser', $param["iuser"]);
        $stmt->bindValue(':idiary', $param["idiary"]);
        $stmt->bindValue(':irest', $param["irest"]);
        $stmt->bindValue(':rest_name', $param["rest_name"]);
        $stmt->bindValue(':rating', $param["rating"]);
        $stmt->bindValue(':text', $param["text"]);
        $stmt->bindValue(':eatdt', $param["eatdt"]);
        $stmt->bindValue(':path', $param["path"]);
        $stmt->execute();
        return $stmt->rowCount();        
    }

    public function deleteDiary(&$param) {
        $sql = "DELETE FROM user_diary WHERE idiary = :idiary";
        $stmt = $this->pdo->prepare($sql);        
        $stmt->bindValue(":idiary", $param["idiary"]);
        $stmt->execute();
        return $stmt->rowCount();
    }
}