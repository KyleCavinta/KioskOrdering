<?php
    date_default_timezone_set('Asia/Manila');

    class Insert extends Connection{

        public function setFeedback($feedbackID, $tableNo, $feedback){
            $pdo = $this->connect();
            
            $date = date('Y-m-d H:i:s');

            $stmt = $pdo->prepare('INSERT INTO `customer_feedback`(FeedbackID, `TableNo`, `Feedback`, `CreatedAt`) VALUES (?, ?, ?, ?)');
            return $stmt->execute([$feedbackID, $tableNo, $feedback, $date]);
        }

        public function setTableActivity($activityID, $tableNo){
            $pdo = $this->connect();
            
            $date = date('Y-m-d H:i:s');
            
            $stmt = $pdo->prepare('INSERT INTO `table_activity`(`ActivityID`, `TableNo`, `EnteredAt`) VALUES (?, ?, ?)');
            return $stmt->execute([$activityID, $tableNo, $date]);
        }

    }