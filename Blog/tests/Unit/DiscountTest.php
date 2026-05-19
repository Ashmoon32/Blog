<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class DiscountTest extends TestCase
{
    /** @test */
    public function it_calculates_a_10_percent_discount_correctly(): void
    {
        // 1. Arrange
        $price = 100;

        // 2. Act
        $total = $price - ($price * 0.10);

        // 3. Assert
        $this->assertEquals(90, $total);
    }
}