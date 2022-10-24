<?php

    class Select extends Connection{

        //Food Attributes
        public function getCategories(){
            $pdo = $this->connect();

            $stmt = $pdo->prepare('SELECT * FROM food_category');
            $stmt->execute();
            $categories = $stmt->fetchAll();

            return $categories;
        }

        public function getSizeBySizeID($sizeID){
            $pdo = $this->connect();

            $stmt = $pdo->prepare('SELECT * FROM food_size WHERE SizeID = ?');
            $stmt->execute([$sizeID]);
            $size = $stmt->fetch();

            return $size;
        }
        
        public function getFoodBestSeller($category){
            $con = $this->connect();
            
            $stmt = $con->prepare('SELECT food.FoodID, food.Name, food.Category, SUM(Quantity) AS TotalSold FROM `food_orders` INNER JOIN food ON food.FoodID = food_orders.FoodID WHERE food.Category RLIKE(?) GROUP BY food_orders.FoodID');
            $stmt->execute([$category]);
            $data = $stmt->fetchAll();
            
            return $data;
        }
        
        public function getFoodBestSellerFromPromo($category){
            $con = $this->connect();
            
            $stmt = $con->prepare('SELECT promo_orders_included.FoodID, COUNT(promo_orders_included.FoodID) AS TotalSold FROM `promo_orders_included` INNER JOIN food ON food.FoodID = promo_orders_included.FoodID WHERE food.Category RLIKE(?) GROUP BY promo_orders_included.FoodID');
            $stmt->execute([$category]);
            $data = $stmt->fetchAll();
            
            return $data;
        }
        
        //Promo Queries
        public function getPromoIncludesByPromoID($promoID){
            $pdo = $this->connect();

            $stmt = $pdo->prepare('SELECT * FROM `promo_includes` WHERE PromoID = ?');
            $stmt->execute([$promoID]);
            $includes = $stmt->fetchAll();

            return $includes;
        }

        public function getPromoByPromoID($promoID){
            $pdo = $this->connect();

            $stmt = $pdo->prepare('SELECT * FROM promo WHERE PromoID = ?');
            $stmt->execute([$promoID]);
            $promo = $stmt->fetch();

            return $promo;
        }

        public function getPromosBySearch($string){
            $pdo = $this->connect();

            $stmt = $pdo->prepare('SELECT * FROM `promo` WHERE Name RLIKE(?)');
            $stmt->execute([$string]);
            $promos = $stmt->fetchAll();

            return $promos;
        }

        public function getPromos(){
            $pdo = $this->connect();

            $stmt = $pdo->prepare('SELECT * FROM `promo`');
            $stmt->execute();
            $promos = $stmt->fetchAll();

            return $promos;
        }

        //Food Queries
        public function getFoodsBySearch($string){
            $pdo = $this->connect();

            $stmt = $pdo->prepare('SELECT * FROM `food` WHERE Name RLIKE(?) OR Category RLIKE(?)');
            $stmt->execute([$string, $string]);
            $foods = $stmt->fetchAll();

            return $foods;
        }

        public function getFoodsByCategory($category){
            $pdo = $this->connect();

            $stmt = $pdo->prepare('SELECT * FROM `food` WHERE Category RLIKE(?)');
            $stmt->execute([$category]);
            $foods = $stmt->fetchAll();

            return $foods;
        }

        public function getFoodsByCategoryAndMinPrice($category){
            $pdo = $this->connect();

            $stmt = $pdo->prepare('SELECT * FROM `food` WHERE Category = ? AND Price = (SELECT MIN(Price) FROM food WHERE Category = ?)');
            $stmt->execute([$category, $category]);
            $foods = $stmt->fetchAll();

            return $foods;
        }

        public function getFoodByFoodID($foodID){
            $pdo = $this->connect();

            $stmt = $pdo->prepare('SELECT * FROM `food` WHERE FoodID = ?');
            $stmt->execute([$foodID]);
            $food = $stmt->fetch();

            return $food;
        }

        public function getFoodSizesByCategory($category){
            $con = $this->connect();

            $stmt = $con->prepare('SELECT * FROM `food_size` WHERE Category = ?');
            $stmt->execute([$category]);
            $sizes = $stmt->fetchAll();

            return $sizes;
        }

        public function getIncrementedID($table, $columnName){
            $pdo = $this->connect();
            
            $stmt = $pdo->prepare("SELECT $columnName FROM $table ORDER BY $columnName DESC LIMIT 1");
            $stmt->execute();
            $id = $stmt->fetch(PDO::FETCH_ASSOC)[$columnName];

            $numID = preg_replace('/[^0-9]/', '', $id);
            $strID = preg_replace('/[^a-zA-Z-]/', '', $id);
            $id = $strID . sprintf('%04d', ++$numID);
            
            return $id;
        }
    }