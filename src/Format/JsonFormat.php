<?php

namespace App\Format;

use App\Collection\ProductCollection;
use App\Entity\Product;
use App\Interface\StorageInterface;


class JsonFormat extends BaseFormat
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

        $this->collection = new ProductCollection();

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
        $data = [];
        foreach ($this->collection->getIterator() as $item) {
            $data[] = $item->toArray();
        }
        $this->storage->save(json_encode($data, JSON_PRETTY_PRINT));
    }

}