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
            $sql = "INSERT INTO menu_cd
                    SET menu = :search_word
                        icate2 = :icate2";
    
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":menu", $param["search_word"]);
            $stmt->bindValue(":icate2", $param["icate2"]);
            $stmt->execute();

            return $stmt->rowCount();
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

        //레스토랑 저장
        public function insSearchRest(&$param) {
            $sql = "INSERT INTO restaurant 
                    SET rest_name = :rest_name, 
                        rest_address = :rest_address, 
                        tel = :tel, 
                        open_close = :open_close, 
                        lon_y = :lon_y, 
                        lat_x = :lat_x, 
                        img_path = :img_path";
            
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
            $sql = "INSERT INTO menu_list 
                    SET imenu = :imenu,
                        menu = :menu,
                        price = :price,
                        irest = :irest";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":imenu", $param["imenu"]);
            $stmt->bindValue(":menu", $param["menu"]);
            $stmt->bindValue(":price", $param["price"]);
            $stmt->bindValue(":irest", $param["irest"]);
            $stmt->execute();

            return $stmt->rowCount();
        }
    }