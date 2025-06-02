<?php
class Account {
    private $number;
    private $balance = 0;

    public function __construct($number) {
        $this->number = $number;
    }

    public function deposit($amount) {
        $this->balance += $amount;
    }

    public function withdraw($amount) {
        if ($amount > $this->balance) {
            echo "Saldo insuficiente.";
        } else {
            $this->balance -= $amount;
        }
    }

    public function getBalance() {
        return $this->balance;
    }
}
