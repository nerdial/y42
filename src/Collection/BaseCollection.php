<?php

namespace App\Collection;

use App\Exception\NotFoundException;
use App\Interface\CollectionInterface;
use App\Interface\EntityInterface;

class BaseCollection implements CollectionInterface
{
    private array $items;

    public function add(EntityInterface $entity)
    {
        $this->items[] = $entity;
    }

    /**
     * @throws NotFoundException
     */
    public function get(int $index): EntityInterface
    {
        if (!isset($this->items[$index]))
            throw new NotFoundException('Item not found');
        return $this->items[$index];
    }

    public function remove(int $index)
    {
        unset($this->items[$index]);
    }

    public function update(int $index, EntityInterface $entity)
    {
        $this->items[$index] = $entity;
    }

    public function findIndexByKey($key, $value)
    {
        foreach ($this->items as $index => $item) {
            if (call_user_func_array([$item, 'get' . ucfirst($key)], []) == $value) {
                return $index;
            }
        }
        throw new NotFoundException('Item not found in the collection');
    }

    public function updateByKey(string $key, $value, EntityInterface $entity)
    {
        $index = $this->findIndexByKey($key, $value);
        $this->update($index, $entity);
    }

    public function removeByKey(string $key, $value)
    {
        $index = $this->findIndexByKey($key, $value);
        $this->remove($index);
    }

    public function filter(array $conditions): \Iterator
    {
        $items = $this->items;
        foreach ($conditions as $condition => $value) {
            $items = array_filter($items,
                fn($item): bool => call_user_func_array([$item, 'get' . ucfirst($condition)], []) == $value
            );
        }
        return new \ArrayIterator($items);
    }

    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->items);
    }

    public function count(): int
    {
       return count($this->items);
    }

    public function flush(): bool
    {
        $this->items = [];
        return true;
    }
}