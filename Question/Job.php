<?php
    
    class CongViec{
        public $MaNV;
        public $MaCViec;
        public $TenCViec;
        public $DealineCV;
        public $CreateBy;
        public $CreateDate;
      //  public $AsignedTo;
        public $Status;

        function __construct($MaNV, $MaCViec, $TenCViec, $DealineCV, $CreateBy,  $CreateDate, $Status)
        {
            $this ->MaNV = $MaNV;
            $this ->MaCViec = $MaCViec;
            $this ->TenCViec = $TenCViec;
            $this ->DealineCV = $DealineCV;
             $this ->CreateBy = $CreateBy;
            $this ->CreateDate = $CreateDate;
           // $this ->AsignedTo = $AsignedTo;
            $this ->Status = $Status;
        }
    }

?>