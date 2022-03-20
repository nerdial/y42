<?php

namespace App\Storage;

use App\Interface\StorageInterface;

class FileStorage implements StorageInterface
{

    public function __construct(private string $filepath)
    {
    }

    public function save(string $data): bool
    {
        $file = fopen($this->filepath, 'w+');
        return fwrite($file, $data);
    }

    public function open()
    {
        $file = fopen($this->filepath, 'w+');
    }

    public function getContent(): string
    {
        return file_get_contents($this->filepath);
    }

    public function flush()
    {
        file_put_contents($this->filepath, '');
    }
}