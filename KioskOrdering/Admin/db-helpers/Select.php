<?php

    class Select extends Connection{
        
        //Order details
        public function getOrderedFoodByTransactionID($transID){
            $con = $this->connect();
            
            $stmt = $con->prepare('SELECT * FROM `food_orders` INNER JOIN `food` ON `food`.FoodID = `food_orders`.FoodID WHERE TransactionID = ?');
            $stmt->execute([$transID]);
            $data = $stmt->fetchAll();
            
            return $data;
        }
        
        public function getIncludedFoodInPromo($orderID){
            $con = $this->connect();
            
            $stmt = $con->prepare('SELECT * FROM `promo_orders_included` INNER JOIN food ON food.FoodID = promo_orders_included.FoodID WHERE promo_orders_included.OrderID = ?');
            $stmt->execute([$orderID]);
            $data = $stmt->fetchAll();
            
            return $data;
        }
        
        public function getOrderedPromoByTransactionID($transID){
            $con = $this->connect();
            
            $stmt = $con->prepare('SELECT * FROM `promo_orders` INNER JOIN promo ON promo.PromoID = promo_orders.PromoID WHERE TransactionID = ?');
            $stmt->execute([$transID]);
            $data = $stmt->fetchAll();
            
            return $data;
        }
        
        public function getFoodSize($sizeID){
            $con = $this->connect();
            
            $stmt = $con->prepare('SELECT Size FROM food_size WHERE SizeID = ?');
            $stmt->execute([$sizeID]);
            $data = $stmt->fetch();
            
            return $data;
        }
        
        //Today's Payment method count
        public function getTodaysServed(){
            date_default_timezone_set('Asia/Manila');
            $con = $this->connect();
            
            $date = date("Y-m-d");
            
            $stmt = $con->prepare('SELECT COUNT(*) FROM `payment_transaction` WHERE DATE(DatePaid) = ?');
            $stmt->execute([$date]);
            $data = $stmt->fetch();
            
            return $data;
        }
        
        //Dashboard
        public function getLastweekTableActivity(){
            $con = $this->connect();
            
            $stmt = $con->prepare('SELECT *, COUNT(*) as AveLoad FROM table_activity WHERE YEARWEEK(EnteredAt, 1) = YEARWEEK(NOW() - INTERVAL 1 WEEK, 1) GROUP BY DATE(EnteredAt)');
            $stmt->execute();
            $data = $stmt->fetchAll();
            
            return $data;
        }
        
        public function getThisWeekTableActivity(){
            $con = $this->connect();
            
            $stmt = $con->prepare('SELECT *, COUNT(*) as AveLoad FROM table_activity WHERE YEARWEEK(EnteredAt, 0) = YEARWEEK(NOW()) GROUP BY DATE(EnteredAt)');
            $stmt->execute();
            $data = $stmt->fetchAll();
            
            return $data;
        }
        
        
        //Best sellers
        public function getFoodBestSeller($category){
            $con = $this->connect();
            
            $stmt = $con->prepare('SELECT food.FoodID, food.Name, SUM(Quantity) AS TotalSold FROM `food_orders` INNER JOIN food ON food.FoodID = food_orders.FoodID WHERE food.Category RLIKE(?) GROUP BY food_orders.FoodID');
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
        
        //Orders Table
        public function getPaymentTransactionsFoodOrders($tableNo, $paymentMethod){
            $con = $this->connect();

            $stmt = $con->prepare('SELECT payment_transaction.TransactionID, payment_transaction.TableNo, payment_transaction.PaymentMethod, SUM(food_orders.TotalPrice) AS TotalPrice, payment_transaction.DatePaid FROM payment_transaction INNER JOIN food_orders ON food_orders.TransactionID = payment_transaction.TransactionID WHERE payment_transaction.TableNo RLIKE(?) AND payment_transaction.PaymentMethod RLIKE(?) GROUP BY(payment_transaction.TransactionID)');
            $stmt->execute([$tableNo, $paymentMethod]);
            $data = $stmt->fetchAll();

            return $data;
        }
        
        public function getPaymentTransactionsPromoOrders($tableNo, $paymentMethod){
            $con = $this->connect();

            $stmt = $con->prepare('SELECT payment_transaction.TransactionID, payment_transaction.TableNo, payment_transaction.PaymentMethod, promo_orders.TotalPrice, payment_transaction.DatePaid FROM payment_transaction INNER JOIN promo_orders ON payment_transaction.TransactionID = promo_orders.TransactionID WHERE payment_transaction.TableNo RLIKE(?) AND payment_transaction.PaymentMethod RLIKE(?)');
            $stmt->execute([$tableNo, $paymentMethod]);
            $data = $stmt->fetchAll();

            return $data;
        }
        
        public function getTotalOrdersMade(){
            $con = $this->connect();
            
            $stmt = $con->prepare('SELECT COUNT(*) AS TotalOrdersMade FROM `payment_transaction`');
            $stmt->execute([]);
            
            return $stmt->fetchAll();
        }
        
        //Payment Method Count
        public function getPaymentMethodCount(){
            $con = $this->connect();
            
            $stmt = $con->prepare('SELECT PaymentMethod, COUNT(PaymentMethod) AS PaymentMethodCount FROM `payment_transaction` GROUP BY PaymentMethod');
            $stmt->execute([]);
            
            return $stmt->fetchAll();
        }
        
        //Feedback count
        public function getFeedbackCounts(){
            $con = $this->connect();
            
            $stmt = $con->prepare('SELECT FeedBack, COUNT(FeedBack) AS FeedbackCount FROM `customer_feedback` GROUP BY Feedback');
            $stmt->execute([]);
            
            return $stmt->fetchAll();
        }

        //admin
        public function getAdminByUsernamePasswordRole($uName, $pass, $role){
            $con = $this->connect();

            $stmt = $con->prepare('SELECT * FROM `employee_account` INNER JOIN employee ON employee_account.AdminID = employee.AdminID WHERE employee_account.Username = ? AND employee_account.Password = ? AND employee.Position = ?');
            $stmt->execute([$uName, $pass, $role]);
            $admin = $stmt->fetch();

            return $admin;
        }
        
        public function getTables(){
            $pdo = $this->connect();

            $stmt = $pdo->prepare('SELECT * FROM `customer_table`');
            $stmt->execute();
            $tables = $stmt->fetchAll();

            return $tables;
        }

        //Attributes
        public function getSizeBySizeID($sizeID){
            $pdo = $this->connect();

            $stmt = $pdo->prepare('SELECT * FROM food_size WHERE SizeID = ?');
            $stmt->execute([$sizeID]);
            $size = $stmt->fetch();

            return $size;
        }

        //Food
        public function getFoodByFoodID($foodID){
            $pdo = $this->connect();

            $stmt = $pdo->prepare('SELECT * FROM food WHERE FoodID = ?');
            $stmt->execute([$foodID]);
            $food = $stmt->fetch();

            return $food;
        }

        //Promo
        public function getPromoByPromoID($promoID){
            $pdo = $this->connect();

            $stmt = $pdo->prepare('SELECT * FROM promo WHERE PromoID = ?');
            $stmt->execute([$promoID]);
            $promo = $stmt->fetch();

            return $promo;
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