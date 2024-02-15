<?php
class RecordTest {
    public $idRoom;
    public $idQuestion;
    public $idStudent;
    public $nameStudent;
    public $point;
    public $time;
    public $correctQuestion;
    public $currentQuestion;
    public $answer;
    public $state;
    public $questions;
    public $day; // Ensure this property name matches the column name in your database
    public $isViewed;
    function __construct($idRoom, $idQuestion, $idStudent, $nameStudent, $point, $time, $correctQuestion, $currentQuestion, $answer, $state, $questions, $day,$isViewed) {
        // Constructor with questions array
        $this->idRoom = $idRoom;
        $this->idQuestion = $idQuestion;
        $this->idStudent = $idStudent;
        $this->nameStudent = $nameStudent;
        $this->point = $point;
        $this->time = $time;
        $this->correctQuestion = $correctQuestion;
        $this->currentQuestion = $currentQuestion;
        $this->answer = $answer;
        $this->state = $state;
        $this->questions = $questions; // Assign the provided questions array
        $this->day = $day;
        $this->isViewed = $isViewed;
    }
}
?>
