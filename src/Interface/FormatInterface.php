<?php

namespace App\Interface;


interface FormatInterface
{

    public function __construct(StorageInterface $storage);

    public function insert(EntityInterface $entity): bool;

    public function findById(int $id): EntityInterface;

    public function updateById(int $id, EntityInterface $entity): bool;

    public function where(array $conditions): WhereInterface;

    public function findAll(): \Iterator;

    public function flush();

}