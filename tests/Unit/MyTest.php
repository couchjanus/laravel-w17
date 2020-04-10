<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class MyTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testTrue() {
        $this->assertTrue(true);
    }
 
    public function testFalse() {
        $this->assertFalse(false);
    }

}
