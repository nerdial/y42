<?php

namespace App\Collection;

use App\Interface\CollectionInterface;
use App\Interface\FormatInterface;
use App\Interface\WhereInterface;


class WhereCollection implements WhereInterface
{

    private ?int $limit = null;
    private ?int $offset = 0;
    protected bool $hasLimit = false;


    public function __construct(
        private FormatInterface     $format,
        private array               $conditions,
        private CollectionInterface $collection
    )
    {
    }

    public function limit(int $limit): self
    {
        if ($limit <= 0) throw new \InvalidArgumentException('Limit must be greater than 0');

        $this->limit = $limit;
        $this->hasLimit = true;
        return $this;
    }

    public function offset(int $offset = 0): self
    {
        if ($offset < 0) throw new \InvalidArgumentException('Offset must be 0 or greater');

        $this->offset = $offset;
        $this->hasLimit = true;
        return $this;
    }

    public function delete(): bool
    {
        $items = $this->collection->filter($this->conditions);
        while ($items->valid()) {
            $item = $items->current();
            $primaryId = $item->getId();
            $this->collection->removeByKey('id', $primaryId);
            $items->next();
        }
        $this->format->toFile();
        return true;
    }

    public function get(): \Iterator
    {
        return $this->filter();
    }

    public function count(): int
    {
        return $this->filter()->count();
    }

    private function filter(): \Iterator
    {
        $filters = $this->collection->filter($this->conditions);

        if (!$this->hasLimit) return $filters;

        $items = [];

        if(!isset($this->limit)){

            $limiter = new \LimitIterator($filters, $this->offset);
        }
        else {
            $limiter = new \LimitIterator($filters, $this->offset, $this->limit);
        }

        foreach ($limiter as $item) {
            $items [] = $item;
        }
        return new \ArrayIterator($items);

    }

}