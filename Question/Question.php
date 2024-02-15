<?php
class Question{
    public $idQuestion;
    public $question;
    public $answers;
    public $correctNum;
    public $idTest;
    function __construct($idQuestion, $question, $correctNum,$idTest,$answers)
    {
        $this ->idQuestion  = $idQuestion ;
        $this ->question = $question;
        $this ->correctNum = $correctNum;
        $this ->idTest = $idTest;
        $this ->answers = $answers;
    }

}
?>