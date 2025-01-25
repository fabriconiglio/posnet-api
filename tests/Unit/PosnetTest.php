<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\CreditCard;
use App\Models\Posnet;

class PosnetTest extends TestCase {
    public function testDoPaymentWithInsufficientFunds(): void {
        $this->expectException(\RuntimeException::class);

        $card = new CreditCard(
            'VISA',
            'Test Bank',
            '12345678',
            1000.0,
            ['dni' => '12345678', 'name' => 'John', 'lastName' => 'Doe']
        );

        $posnet = new Posnet();
        $posnet->doPayment($card, 2000.0, 1);
    }
}
