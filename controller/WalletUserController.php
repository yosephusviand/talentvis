<?php

class WalletUserController
{
    private $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function deposit($amount, $type, $id)
    {
        $this->model->deposit($amount, $type, $id);
    }

    public function withdraw($amount, $type, $id)
    {
        return $this->model->withdraw($amount, $type, $id);
    }

    public function transfer($amount, $type, $to, $from)
    {
        return $this->model->transfer($amount, $type, $to, $from);
    }
}
