<?php
    date_default_timezone_set('Asia/Manila');

    class Insert extends Connection{
        
        public function setEmployee($adminID, $fName, $lName, $pos){
            $con = $this->connect();
            
            $stmt = $con->prepare('INSERT INTO `employee`(`AdminID`, `Firstname`, `Lastname`, `Position`) VALUES (?, ?, ?, ?)');
            return $stmt->execute([$adminID, $fName, $lName, $pos]);
        }
        
        public function setEmployeeAccount($adminID, $username, $password){
            $con = $this->connect();
            
            $stmt = $con->prepare('INSERT INTO `employee_account`(`AdminID`, `Username`, `Password`) VALUES (?, ?, ?)');
            return $stmt->execute([$adminID, $username, $password]);
        }

        public function setPaymentTransaction($transactionID, $tableNo, $paymentMethod, $amountPaid){
            $con = $this->connect();

            $date = date('Y-m-d H:i:s');
            
            $stmt = $con->prepare('INSERT INTO `payment_transaction`(`TransactionID`, `TableNo`, `PaymentMethod`, `AmountPaid`, `DatePaid`) VALUES (?, ?, ?, ?, ?)');
            return $stmt->execute([$transactionID, $tableNo, $paymentMethod, $amountPaid, $date]);
        }

        public function setPromoOrders($orderID, $transactionID, $tableNo, $promoID, $totalPrice){
            $con = $this->connect();

            $stmt = $con->prepare('INSERT INTO `promo_orders`(`OrderID`, `TransactionID`, `TableNo`, `PromoID`, `TotalPrice`) VALUES (?, ?, ?, ?, ?)');
            return $stmt->execute([$orderID, $transactionID, $tableNo, $promoID, $totalPrice]);
        }

        public function setPromoOrdersIncluded($includeID, $orderID, $foodID){
            $con = $this->connect();

            $stmt = $con->prepare('INSERT INTO `promo_orders_included`(`IncludeID`, `OrderID`, `FoodID`) VALUES (?, ?, ?)');
            return $stmt->execute([$includeID, $orderID, $foodID]);
        }

        public function setFoodOrders($orderID, $transactionID, $tableNo, $foodID, $sizeID, $quantity, $totalPrice){
            $con = $this->connect();

            $stmt = $con->prepare('INSERT INTO `food_orders`(`OrderID`, `TransactionID`, `TableNo`, `FoodID`, `SizeID`, `Quantity`, `TotalPrice`) VALUES (?, ?, ?, ?, ?, ?, ?)');
            return $stmt->execute([$orderID, $transactionID, $tableNo, $foodID, $sizeID, $quantity, $totalPrice]);
        }
    }