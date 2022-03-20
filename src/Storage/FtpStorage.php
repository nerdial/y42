<?php

namespace App\Storage;

use App\Interface\StorageInterface;

class FtpStorage implements StorageInterface
{


    private $connection;


    public function __construct(
        private string $host,
        private int    $port,
        private string $username,
        private string $password,
        private string $filepath
    )
    {
        $this->open();
    }

    public function getContent(): string
    {
        $content = '';
        ftp_login($this->connection, $this->username, $this->port);
        ftp_get($this->connection, $content, $this->filepath, FTP_BINARY);
        return $content;
    }

    public function save(string $data): bool
    {
        return ftp_put($this->connection, $this->filepath, $data, FTP_ASCII);
    }

    public function open()
    {
        $this->connection = ftp_connect($this->host, $this->port);
    }

    public function flush()
    {

    }
}