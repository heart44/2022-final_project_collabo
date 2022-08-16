<?php
    namespace application\models;
    use PDO;

    class SearchModel extends Model {
        //메뉴코드 가져오기
        public function getMenuCD(&$param) {
            $sql = "SELECT imcd FROM menu_cd 
                    WHERE menucd = :menucd";
    
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":menucd", $param["search_word"]);
            $stmt->execute();

            $rs = $stmt->fetch(PDO::FETCH_ASSOC);
            return $rs["imcd"];
        }

        //검색 시 음식점 리스트 가져오기
        public function getRestList(&$param) {
            $sql = "SELECT a.*, c.menucd
                    FROM restaurant a, menu_list b, menu_cd c
                    WHERE a.irest = b.irest AND b.imcd = c.imcd AND c.menucd LIKE :menucd
                    GROUP BY a.irest
                    ORDER BY a.irest asc";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":menucd", "%".$param["search_word"]."%");
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ); 

            //(6371*ACOS(COS(RADIANS(:lat_y))*COS(RADIANS(a.lat_y))*COS(RADIANS(a.lon_x)-RADIANS(:lon_x))+SIN(RADIANS(:lat_y))*SIN(RADIANS(a.lat_y)))) AS dis
            //$stmt->bindValue(":lat_y", $param["lat_y"]);
            //$stmt->bindValue(":lon_x", $param["lon_x"]);
            //HAVING dis <= 1
            //ORDER BY dis
        }

        //검색 로그 저장
        public function insSearchLog(&$param) {
            $sql = "INSERT INTO search_log (search_word, iuser)
                    VALUES (:search_word, :iuser)";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":search_word", $param["search_word"]);
            $stmt->bindValue(":iuser", $param["iuser"]);
            $stmt->execute();

            return $stmt->rowCount();
        }

        //검색 로그 가져오기
        public function getMostSearchLog() {
            $sql = "SELECT search_word
                    FROM search_log
                    GROUP BY search_word
                    HAVING COUNT(*) = ( SELECT MAX(mycnt)
                                        FROM ( 
                                            SELECT search_word, COUNT(*) AS mycnt
                                            FROM search_log
                                            WHERE DATE(search_date) = DATE(NOW())
                                            GROUP BY search_word) AS rs )";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
    
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        //메뉴 코드 저장
        public function insMenuCD(&$param) {
            $sql = "INSERT INTO menu_cd (menucd)
                    VALUES (:menucd)
                    ON duplicate key update moddt = now()";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":menucd", $param["search_word"]);
            $stmt->execute();

            return intval($this->pdo->lastInsertId());
        }

        //레스토랑 저장
        public function insSearchRest(&$param) {
            $sql = "INSERT INTO restaurant (rest_name, rest_address, tel, open_close, lon_x, lat_y, img_path)
                    VALUES (:rest_name, :rest_address, :tel, :open_close, :lon_x, :lat_y, :img_path)
                    ON duplicate key update moddt = now()";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":rest_name", $param["name"]);
            $stmt->bindValue(":rest_address", $param["addr"]);
            $stmt->bindValue(":tel", $param["tel"]);
            $stmt->bindValue(":open_close", $param["open_close"]);
            $stmt->bindValue(":lon_x", $param["lon_x"]);
            $stmt->bindValue(":lat_y", $param["lat_y"]);
            $stmt->bindValue(":img_path", $param["img_path"]);
            $stmt->execute();

            return intval($this->pdo->lastInsertId());
        }

        //메뉴 저장
        public function insSearchMenu(&$param) {
            $sql = "INSERT INTO menu_list (imcd, menu, price, irest)
                    VALUES (:imcd, :menu, :price, :irest)
                    ON duplicate key update moddt = now()";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":imcd", $param["imcd"]);
            $stmt->bindValue(":menu", $param["name"]);
            $stmt->bindValue(":price", $param["price"]);
            $stmt->bindValue(":irest", $param["irest"]);
            $stmt->execute();

            return $stmt->rowCount();
        }

        //메뉴 가져오기
        public function getMenuList() {
            $sql = "SELECT * FROM menu_list
                    GROUP BY menu, irest
                    ORDER BY imenu";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ); 
        }
    }