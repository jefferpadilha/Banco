<?php
class User {
    private $name;
    private $cpf;
    private $email;
    private $account;

    public function __construct($name, $cpf, $email) {
        $this->name = $name;
        $this->cpf = $cpf;
        $this->email = $email;
    }

    public function setAccount($account) {
        $this->account = $account;
    }

    public function getAccount() {
        return $this->account;
    }

    public function getName() {
        return $this->name;
    }

    public function getCpf() {
        return $this->cpf;
    }

    public function getEmail() {
        return $this->email;
    }
}
