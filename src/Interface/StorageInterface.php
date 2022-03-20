<?php

namespace App\Interface;

interface StorageInterface
{

    public function getContent() :string;

    public function save(string $data): bool;

    public function open();

    public function flush();
}