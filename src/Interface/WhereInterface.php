<?php

namespace App\Interface;

interface WhereInterface
{
    public function limit(int $limit): self;

    public function offset(int $offset = 1): self;

    public function delete(): bool;

    public function get(): \Iterator;

    public function count(): int;
}