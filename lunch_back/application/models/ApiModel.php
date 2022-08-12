<?php
    namespace application\models;
    use PDO;

    class ApiModel extends Model {
        //지역 카테고리
        public function selArea() {
            $sql = "SELECT * FROM `area`";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function AreaCate1List() {
            $sql = "SELECT area1 FROM area";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    
        public function AreaCate2List(&$param) {
            $sql = "SELECT area2, area3, area4 FROM area
                    WHERE area1 = :area1
                    GROUP BY area2, area3, area4";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":area1", $param["area1"]);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    
        public function AreaCate3List(&$param) {
            $sql = "SELECT area3, area4 FROM area
                    WHERE area1 = :area1
                    AND area2 = :area2
                    OR area3 = :area3
                    GROUP BY area4";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":area1", $param["area1"]);
            $stmt->bindValue(":area2", $param["area2"]);
            $stmt->bindValue(":area3", $param["area3"]);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }


        //밥친구 리스트
        public function selBobfList() {
            $sql = "SELECT 
                        bobf.*,
                        user.nick
                    FROM bobf
                        LEFT JOIN user
                        ON bobf.iuser = user.iuser
                    ORDER BY ibobf DESC
                    ";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }


        //밥친구 글 쓰기
        public function insBobF(&$param) {
            $sql = "INSERT INTO bobf SET
                    restname = :restname, 
                    iuser = :iuser, 
                    title = :title, 
                    partydt = :partydt, 
                    ctnt = :ctnt, 
                    total_mem = :total_mem, 
                    cur_mem = :cur_mem, 
                    img_path = :img,
                    sido = :sido,
                    gugun = :gugun
                    ";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":restname", $param["restname"]);
            $stmt->bindValue(":iuser", $param["iuser"]);
            $stmt->bindValue(":title", $param["title"]);
            $stmt->bindValue(":partydt", $param["partydt"]);
            $stmt->bindValue(":ctnt", $param["ctnt"]);
            $stmt->bindValue(":total_mem", $param["total_mem"]);
            $stmt->bindValue(":cur_mem", $param["cur_mem"]);
            $stmt->bindValue(":img", $param["img"]);
            $stmt->bindValue(":sido", $param["sido"]);
            $stmt->bindValue(":gugun", $param["gugun"]);
            $stmt->execute();
            return intval($this->pdo->lastInsertId());
        }

        //밥친구 디테일
        public function selBobfDetail(&$param) {
            $sql = "SELECT a.*, b.* FROM bobf AS a
                    LEFT JOIN user AS b
                    ON a.iuser = b.iuser
                    WHERE a.ibobf = :ibobf";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":ibobf", $param["ibobf"]);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        //밥친구 글 삭제
        public function delBobfDetail(&$param) {
            $sql = "DELETE FROM bobf
                    WHERE ibobf = :ibobf";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":ibobf", $param["ibobf"]);
            $stmt->execute();
            return $stmt->rowCount();
        }

        //밥친구 글 수정
        public function updateBobfDetail(&$param) {
            $sql = "UPDATE bobf SET
                        restname = :restname,
                        title = :title,
                        partydt = :partydt,
                        total_mem = :total_mem,
                        cur_mem = :cur_mem,
                        img_path = :img,
                        ctnt = :ctnt,
                        sido = :sido,
                        gugun = :gugun
                        WHERE ibobf = :ibobf AND iuser = :iuser";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":ibobf", $param["ibobf"]);
            $stmt->bindValue(":title", $param["title"]);
            $stmt->bindValue(":iuser", $param["iuser"]);
            $stmt->bindValue(":restname", $param["restname"]);
            $stmt->bindValue(":partydt", $param["partydt"]);
            $stmt->bindValue(":ctnt", $param["ctnt"]);
            $stmt->bindValue(":total_mem", $param["total_mem"]);
            $stmt->bindValue(":cur_mem", $param["cur_mem"]);
            $stmt->bindValue(":img", $param["img"]);
            $stmt->bindValue(":sido", $param["sido"]);
            $stmt->bindValue(":gugun", $param["gugun"]);
            $stmt->execute();
            return $stmt->rowCount();
        }

        
        public function selRestList(&$param) {
            $sql = "SELECT * FROM restaurant
                    WHERE rest_name = :rest_name";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":rest_name", $param["rest_name"]);
            $stmt->execute();
            return $stmt->rowCount();
        }

        



    }