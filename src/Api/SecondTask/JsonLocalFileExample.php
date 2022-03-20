<?php

namespace App\Api\SecondTask;

use App\Collection\ProductCollection;
use App\Entity\Product;
use App\Format\JsonFormat;
use App\Storage\FileStorage;

class JsonLocalFileExample
{

    /**
     * @throws \App\Exception\NotFoundException
     */
    public function index()
    {
        $fileStorage = new FileStorage('cache/database.json');

        $product = new Product(
            id: rand(1, 20000) * rand(1, 200),
            title: 'First Product',
            description: 'good description',
            category: 'Car',
            price: 12000
        );
        $secondProduct = new Product(
            id: rand(1, 20000) * rand(1, 200),
            title: 'First Product',
            description: 'good description',
            category: 'Car',
            price: 12000
        );

        $format = new JsonFormat($fileStorage);


        // insert one record
        $format->insert($product);


        $collection = new ProductCollection();
        $collection->add($product);
        $collection->add($secondProduct);
        // batch insert
        $format->batchInsert($collection);


        // find by id
        $item = $format->findById($product->getId());

        $product->setCategory('Brand');

        // update by id
        $format->updateById($product->getId(), $product);

        // get all items from database
        $items = $format->findAll();

        // where clause => filter
        $items = $format->where([
            'category' => 'Car',
            'title' => 'First Product'
        ])->get();

        // delete all the records with conditions
        $items = $format->where([
            'category' => 'Car',
            'title' => 'First Product'
        ])->delete();

        // with limit
        $items = $format->where([
            'category' => 'Car',
            'title' => 'First Product'
        ])->limit(2)->get();


        // offset and limit
        $items = $format->where([
            'category' => 'Car',
            'title' => 'First Product'
        ])->offset(10)->limit(10)->get();


        // counting the filter only
        $items = $format->where([
            'category' => 'Car',
            'title' => 'First Product'
        ])->count();


        // deleting an item from database
        $format->deleteById($item->getId());

    }


}