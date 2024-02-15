<?php
class Test{
    public $id;
    public $name;
    public $createDate;
    public $idCreate;

    function __construct($id, $name, $createDate, $idCreate)
    {
        $this ->id = $id;
        $this ->name = $name;
        $this ->createDate = $createDate;
        $this ->idCreate = $idCreate;
    }

}
?>