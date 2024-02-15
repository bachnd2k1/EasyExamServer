<?php  
    class Room{
        public $idRoom;
        public $nameRoom;
        public $idTest;
        public $idCreateUser;
        public $numOfUser;
        public $time;
        public $currentNumUser;
        public $state;
        public $createTime;
        public $isViewed;
        public $startTime;
        function __construct($idRoom, $nameRoom, $idTest, $idCreateUser, $numOfUser, $time, $currentNumUser, $state, $createTime, $isViewed, $startTime) {
            $this->idRoom = $idRoom;
            $this->nameRoom = $nameRoom;
            $this->idTest = $idTest;
            $this->idCreateUser = $idCreateUser;
            $this->numOfUser = $numOfUser;
            $this->time = $time;
            $this->currentNumUser = (int)$currentNumUser; // Cast to integer
            $this->state = $state;
            $this->createTime = $createTime;
            $this->isViewed = $isViewed;
            $this->startTime = $startTime;
        }
        
    }
?>