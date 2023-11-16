<?php

class WalletController {
    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function deposit($amount, $type)
    {
        $this->user->deposit($amount, $type);
    }

    public function withdraw($amount, $type)
    {
        return $this->user->withdraw($amount, $type);
    }
}