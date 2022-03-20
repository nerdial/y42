<?php

namespace App\Api\FirstTask;

use App\Stack\Stack;

class StackExample
{

    public function index()
    {

        $stack = new Stack();
        $stack->push('first item');
        $stack->push('second item');
        $stack->size();
        $stack->pop();
        $stack->peek();
        $stack->empty();

    }

}