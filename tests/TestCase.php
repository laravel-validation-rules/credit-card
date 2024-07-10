<?php

namespace LVR\CreditCard\Tests;

class TestCase extends \Orchestra\Testbench\TestCase
{
    // The TestCase::__construct in the new PHPUnit versions requires first argument,
    // this workaround allows to instantiate test files in the tests.
    public function __construct($name = null)
    {
        parent::__construct($name ?? get_class($this));
    }
}
