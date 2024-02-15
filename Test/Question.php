<?php
class Question{
    public $id;
    public $question;
    public $answers;
    public $correctNum;
    public $idTest;
    function __construct($id,$question,$answers, $correctNum,$idTest)
    {
        $this ->id = $id;
        $this ->question = $question;
        $this ->answers = $answers;
        $this ->correctNum = $correctNum;
        $this ->idTest = $idTest;
    }

}
?>