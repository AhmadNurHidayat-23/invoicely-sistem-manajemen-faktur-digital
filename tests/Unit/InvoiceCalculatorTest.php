<?php

namespace Tests\Unit;

use App\Services\InvoiceCalculator;
use PHPUnit\Framework\TestCase;

class InvoiceCalculatorTest extends TestCase
{
    public function test_it_calculates_all_lines_and_tax_with_integer_money(): void
    {
        $result = (new InvoiceCalculator)->calculate([
            ['item_name' => 'A', 'quantity' => 3, 'unit_price' => 12345],
            ['item_name' => 'B', 'quantity' => 2, 'unit_price' => 98765],
        ], '11.25');
        $this->assertSame(37035, $result['items'][0]['total_price']);
        $this->assertSame(234565, $result['totals']['subtotal']);
        $this->assertSame(1125, $result['totals']['tax_percentage']);
        $this->assertSame(26389, $result['totals']['tax_amount']);
        $this->assertSame(260954, $result['totals']['total']);
    }

    public function test_it_rounds_half_up_and_supports_zero_tax(): void
    {
        $calculator = new InvoiceCalculator;
        $items = [['item_name' => 'A', 'quantity' => 1, 'unit_price' => 5]];
        $this->assertSame(1, $calculator->calculate($items, '10')['totals']['tax_amount']);
        $this->assertSame(0, $calculator->calculate($items, '9.99')['totals']['tax_amount']);
        $this->assertSame(5, $calculator->calculate($items)['totals']['total']);
    }

    public function test_the_maximum_validated_input_stays_within_integer_precision(): void
    {
        $items = array_fill(0, 100, ['item_name' => 'Maksimal', 'quantity' => 1000, 'unit_price' => 999999999]);
        $result = (new InvoiceCalculator)->calculate($items, '100');
        $this->assertSame(99999999900000, $result['totals']['subtotal']);
        $this->assertSame(199999999800000, $result['totals']['total']);
        $this->assertIsInt($result['totals']['tax_amount']);
    }
}
