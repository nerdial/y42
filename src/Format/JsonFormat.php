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

    /**
     * @return void
     * User should implement prepareData,
     * It basically means converting the content of the file into meaningful
     * structure for the application.
     * So in this case we are getting the content of the file which is json and
     * converting it into entities
     */
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

    /**
     * @return void
     * On the other hand, user must implement another method to convert
     * all the entities into proper file structure in this case :
     * json content and pass it to the storage to save the data.
     */
    public function toFile()
    {
        $data = [];
        foreach ($this->collection->getIterator() as $item) {
            $data[] = $item->toArray();
        }
        $this->storage->save(json_encode($data, JSON_PRETTY_PRINT));
    }

}