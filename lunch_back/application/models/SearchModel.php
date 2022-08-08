<?php
    namespace application\models;
    use PDO;

    class SearchModel extends Model {
        //검색카테고리
        public function getSearchCategoryList() {
            $sql = "SELECT a.*, b.icate2, b.midcate, c.imenu, c.menu
                    FROM category1 a, category2 b, menu_cd c
                    WHERE a.icate1 = b.icate1 and b.icate2 = c.icate2
                    ORDER BY a.icate1 asc";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
    
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        //메뉴코드 가져오기
        public function getMenuCD(&$param) {
            $sql = "SELECT imenu FROM menu_cd 
                    WHERE icate2 = :icate2 AND menu = :menu";
    
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":icate2", $param["icate2"]);
            $stmt->bindValue(":menu", $param["menu"]);
            $stmt->execute();

            $rs = $stmt->fetch(PDO::FETCH_ASSOC);
            return $rs["imenu"];
        }

        //검색 시 음식점 리스트 가져오기
        public function getRestList(&$param) {
            $sql = "SELECT a.*, d.menu
                    FROM restaurant a, menu_list b, category2 c, menu_cd d
                    WHERE a.irest = b.irest AND b.imenu = d.imenu AND d.icate2 = c.icate2 AND d.menu = :menu
                    GROUP BY a.irest";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":menu", $param["search_word"]);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ); 
        }

        //검색 로그 저장
        public function insSearchLog(&$param) {
            $sql = "INSERT INTO search_log (search_word)
                    VALUES (:search_word)";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":search_word", $param["search_word"]);
            $stmt->execute();

            return $stmt->rowCount();
        }

        //category2 저장
        public function insMenuCate2(&$param) {
            $sql = "INSERT INTO category2 (midcate, icate1)
                    VALUES (:midcate, :icate1)
                    ON DUPLICATE KEY UPDATE moddt = now()";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":midcate", $param["midcate"]);
            $stmt->bindValue(":icate1", $param["icate1"]);

            $stmt->execute();

            return intval($this->pdo->lastInsertId());
        }

        public function selcate2($param) {
            $sql = "SELECT a.icate2 FROM category2 a, category1 b 
                    WHERE a.icate1 = b.icate1 and a.midcate = :midcate and a.icate1 = :icate1";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":midcate", $param["midcate"]);
            $stmt->bindValue(":icate1", $param["icate1"]);
            $stmt->execute();

            $rs = $stmt->fetch(PDO::FETCH_ASSOC);
            return $rs["icate2"];
        }

        //메뉴 코드 저장
        public function insMenuCD(&$param) {
            $sql = "INSERT INTO menu_cd (menu, icate2)
                    VALUES (:menu, :icate2)
                    ON duplicate key update moddt = now()";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":menu", $param["menu"]);
            $stmt->bindValue(":icate2", $param["icate2"]);
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
            $sql = "INSERT INTO menu_list (imenu, menu, price, irest)
                    VALUES (:imenu, :menu, :price, :irest)
                    ON duplicate key update moddt = now()";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":imenu", $param["imenu"]);
            $stmt->bindValue(":menu", $param["name"]);
            $stmt->bindValue(":price", $param["price"]);
            $stmt->bindValue(":irest", $param["irest"]);
            $stmt->execute();

            return $stmt->rowCount();
        }
    }