<?php

namespace App\Format;

use App\Collection\WhereCollection;
use App\Exception\NotFoundException;
use App\Interface\CollectionInterface;
use App\Interface\EntityInterface;
use App\Interface\FormatInterface;
use App\Interface\StorageInterface;
use App\Interface\WhereInterface;

abstract class BaseFormat implements FormatInterface
{

    protected CollectionInterface $collection;
    protected array $conditions = [];

    public function __construct(
        private StorageInterface $storage
    )
    {
        $this->prepareData();
    }

    public abstract function prepareData();

    public abstract function toFile();

    public function insert(EntityInterface $entity): bool
    {
        $this->collection->add($entity);
        $this->toFile();
        return true;
    }

    public function batchInsert(CollectionInterface $collection): bool
    {
        foreach ($collection->getIterator() as $entity) {
            $this->collection->add($entity);
        }
        $this->toFile();
        return true;
    }

    public function count(): int
    {
        return $this->collection->count();
    }

    public function where(array $conditions): WhereInterface
    {
        return new WhereCollection(
            format: $this,
            conditions: $conditions,
            collection: $this->collection
        );
    }

    public function updateById(int $id, EntityInterface $entity): bool
    {
        $this->collection->updateByKey('id', $id, $entity);
        $this->toFile();
        return true;
    }

    public function deleteById(int $id): bool
    {
        $this->collection->removeByKey('id', $id);
        $this->toFile();
        return true;
    }

    /**
     * @throws NotFoundException
     */
    public function findById(int $id): EntityInterface
    {
        $iterator = $this->collection->getIterator();
        while ($iterator->valid()) {

            $current = $iterator->current();
            if ($current->getId() == $id) return $current;

            $iterator->next();

        }
        throw new NotFoundException('Item was not found in the database');
    }

    public function findAll(): \Iterator
    {
        return $this->collection->getIterator();
    }

    public function flush()
    {
        $this->collection->flush();
        $this->storage->flush();
    }
}