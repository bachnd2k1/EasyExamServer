<?php
class User {
    public $email;
    public $idClass;
    public $name;
    public $password;
    public $role;
    public function __construct($email, $idClass, $name, $password, $role) {
        $this->email = $email;
        $this->idClass = $idClass;
        $this->name = $name;
        $this->password = $password;
        $this->role = $role;
    }
}

?>