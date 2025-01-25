<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Posnet {
    private array $registeredCards = [];

    public function registerCard(CreditCard $card): void {
        $this->registeredCards[] = $card;
    }

    public function doPayment(CreditCard $card, float $amount, int $installments): PaymentTicket {
        $this->validateInstallments($installments);

        $totalAmount = $this->calculateTotalAmount($amount, $installments);

        if (!$card->hasAvailableLimit($totalAmount)) {
            throw new \RuntimeException('Insufficient credit limit');
        }

        $card->deductAmount($totalAmount);

        return new PaymentTicket(
            $card->getCardHolderFullName(),
            $totalAmount,
            $installments
        );
    }

    private function validateInstallments(int $installments): void {
        if ($installments < 1 || $installments > 6) {
            throw new \InvalidArgumentException('Installments must be between 1 and 6');
        }
    }

    private function calculateTotalAmount(float $amount, int $installments): float {
        if ($installments === 1) {
            return $amount;
        }

        $surcharge = ($installments - 1) * 0.03;
        return $amount * (1 + $surcharge);
    }
}

