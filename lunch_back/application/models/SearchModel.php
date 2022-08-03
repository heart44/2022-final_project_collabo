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

        public function insSearchLog(&$param) {
            $sql = "INSERT INTO search_log (search_word)
                    VALUES (:search_word)";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":search_word", $param["search_word"]);
            $stmt->execute();

            return $stmt->rowCount();
        }
    }