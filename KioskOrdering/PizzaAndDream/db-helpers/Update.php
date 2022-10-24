<?php

    class Update extends Connection{

        public function updateTableStatus($tableNo, $status){
            $pdo = $this->connect();
            
            $stmt = $pdo->prepare('UPDATE customer_table SET Status = ? WHERE TableNo = ?');
            return $stmt->execute([$status, $tableNo]);
        }
    }