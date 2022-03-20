<?php

namespace App\Api\SecondTask;

use App\Entity\Product;
use App\Format\XmlFormat;
use App\Storage\FtpStorage;

class XmlFtp
{

    /**
     * @throws \App\Exception\NotFoundException
     */
    public function index()
    {
        $ftpStorage = new FtpStorage(
            host: '192.168.1.1',
            port: 22,
            username: 'admin',
            password: '123456',
            filepath: '/home/user/database/database.xml'
        );


        $product = new Product(
            id: rand(1, 20000) * rand(1, 200),
            title: 'First Product',
            description: 'good description',
            category: 'Car',
            price: 12000
        );

        $format = new XmlFormat($ftpStorage);

        $format->insert($product);

        // find by id
        $item = $format->findById($product->getId());

        $product->setCategory('Brand');

        // update by id
        $format->updateById($product->getId(), $product);

        // get all items from database
        $items = $format->findAll();

        // where clause
        $items = $format->where([
            'category' => 'Car',
            'title' => 'First Product'
        ])->get();


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