<?php

namespace App\Service\FirstTask;

use App\Exception\EmptyStackException;
use App\Exception\NullElementException;
use App\Interface\StackInterface;

class Stack implements StackInterface
{

    public function __construct(
        private array $items = []
    )
    {
    }

    public function size(): int
    {
        return count($this->items);
    }

    /**
     * @throws NullElementException
     */
    public function push($item = null): bool
    {
        if (!isset($item)) {
            throw new NullElementException(message: 'Supplied element is null');
        }

        return array_push($this->items, $item);

    }

    /**
     * @throws EmptyStackException
     */
    public function pop()
    {
        if ($this->empty()) {
            throw new EmptyStackException(message: 'Stack is empty!');
        }

        return array_pop($this->items);

    }

    /**
     * @throws EmptyStackException
     */
    public function peek()
    {
        if ($this->empty()) {
            throw new EmptyStackException(message: 'Stack is empty!');
        }

        return end($this->items);
    }

    public function empty(): bool
    {
        return empty($this->items);
    }
}