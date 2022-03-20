<?php

namespace App\Interface;

interface CollectionInterface
{

    public function add(EntityInterface $entity);

    public function get(int $index): EntityInterface;

    public function update(int $index, EntityInterface $entity);

    public function remove(int $index);

    public function removeByKey(string $key, $value);

    public function filter(array $conditions): \Iterator;

    public function getIterator(): \Iterator;

    public function count(): int;

    public function flush(): bool;

}