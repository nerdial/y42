<?php

namespace App\Interface;

interface WhereInterface
{
    public function limit(int $limit): self;

    public function offset(int $offset = 0): self;

    public function delete(): bool;

    public function get(): \Iterator;

    public function count(): int;
}