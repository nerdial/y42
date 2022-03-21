## 👨‍💻 &nbsp;How to install


#### &nbsp;-  Clone the project

```bash
git clone git@github.com:nerdial/y42.git
cd ./y42
```

#### &nbsp;- Install packages

This project only has one dependency to ftp extension which is not required

If you have ftp extension installed, run following command

```bash
composer install
```

If you don't  , it does not matter, Run following command only

```bash
composer install --ignore-platform-reqs
```

<hr>

#### &nbsp;- Run unit tests

```bash
./vendor/bin/phpunit tests
```

<hr>

### &nbsp; Implementation

<hr>

#### &nbsp;- You can find example of code usage in these directories

```bash
./src/Api/FirstTask
./src/Api/SecondTask
```


#### &nbsp;- Task 1

I implemented all the necessary method for the stack with unit tests



#### &nbsp;- Task 2

For the second task user must implement 2 interfaces.
I created one for file-system storage and the other for json format with mock implementation for ftp and xml.

The idea here is to use collections and entities to handle this task.

This collection and base format takes care of the database queries and converting to file system  etc.


In order to add new format or storage you need to implement these interfaces:


Lets we are adding new format to our project,
so we should extend BaseFormat and implement two methods
```php

namespace App\Format;

class YmlFormat extends BaseFormat
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
     * So in this case we are getting the content of the file which is yml and 
     * converting it into entities
     */
    public function prepareData()
    {
        
    }

    /**
     * @return void
     * On the other hand, user must implement another method to convert 
     * all the entities into proper file structure in this case :
     * yml content and pass it to the storage to save the data.
     */
    public function toFile()
    {
       
    }

}
```

And If you want to introduce new storage you should implement this interface

```php
namespace App\Interface;

interface StorageInterface
{

    public function getContent() :string;

    public function save(string $data): bool;

    public function open();

    public function flush();
}
```


