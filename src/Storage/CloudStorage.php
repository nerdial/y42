<?php

namespace App\Storage;

use App\Interface\StorageInterface;

class CloudStorage implements StorageInterface
{


    public function getContent(): string
    {
        // TODO: Implement getContent() method.
    }

    public function save(string $data): bool
    {
        // TODO: Implement save() method.
    }

    public function open()
    {
        // TODO: Implement open() method.
    }

    public function flush()
    {
        // TODO: Implement flush() method.
    }
}