<?php

namespace App\Observers;

abstract class Observer
{
    public abstract function handle($event, $data);
}