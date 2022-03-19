<?php

namespace App\Interface;

interface StackInterface
{

    public function size(): int;

    public function push(): bool;

    public function pop();

    public function peek();

    public function empty(): bool;

}