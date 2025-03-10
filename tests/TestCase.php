<?php

namespace LVR\CreditCard\Tests;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function __construct(string $name = '')
    {
        parent::__construct($name ?: class_basename($this));
    }
}
