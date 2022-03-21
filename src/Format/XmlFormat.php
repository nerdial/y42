<?php

namespace App\Format;

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
            // you need to convert the xml content into collections and entities here
        }


    }

    public function toFile()
    {
        // convert collections to xml  and save it
        // to file implementation
    }


}