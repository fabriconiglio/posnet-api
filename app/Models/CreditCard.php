<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditCard {
    private string $cardType;
    private string $bankName;
    private string $cardNumber;
    private float $availableLimit;
    private array $cardHolder;

    public function __construct(
        string $cardType,
        string $bankName,
        string $cardNumber,
        float $availableLimit,
        array $cardHolder
    ) {
        $this->validateCardType($cardType);
        $this->validateCardNumber($cardNumber);

        $this->cardType = $cardType;
        $this->bankName = $bankName;
        $this->cardNumber = $cardNumber;
        $this->availableLimit = $availableLimit;
        $this->cardHolder = $cardHolder;
    }

    private function validateCardType(string $cardType): void {
        if (!in_array(strtoupper($cardType), ['VISA', 'AMEX'])) {
            throw new \InvalidArgumentException('Card type must be VISA or AMEX');
        }
    }

    private function validateCardNumber(string $cardNumber): void {
        if (strlen($cardNumber) !== 8 || !is_numeric($cardNumber)) {
            throw new \InvalidArgumentException('Card number must be 8 digits');
        }
    }

    public function hasAvailableLimit(float $amount): bool {
        return $this->availableLimit >= $amount;
    }

    public function deductAmount(float $amount): void {
        if (!$this->hasAvailableLimit($amount)) {
            throw new \RuntimeException('Insufficient funds');
        }
        $this->availableLimit -= $amount;
    }

    public function getCardHolderFullName(): string {
        return $this->cardHolder['name'] . ' ' . $this->cardHolder['lastName'];
    }

    // Getters
    public function getAvailableLimit(): float {
        return $this->availableLimit;
    }
}
