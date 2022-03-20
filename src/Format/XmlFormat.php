<?php

namespace App\Format;

use App\Entity\Product;
use App\Interface\StorageInterface;


class XmlFormat extends BaseFormat
{

    public function __construct(
        private StorageInterface $storage
    )
    {
        parent::__construct($this->storage);

    }


    public function prepareData()
    {
        $content = $this->storage->getContent();

        if (!empty($content)) {
            $items = json_decode($this->storage->getContent());

            foreach ($items as $item) {
                $product = new Product(
                    id: $item->id,
                    title: $item->title,
                    description: $item->description,
                    category: $item->category,
                    price: $item->price
                );
                $this->collection->add($product);
            }
        }


    }

    public function toFile()
    {
       // to file implementation
    }


}