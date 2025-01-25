<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentTicket {
    private string $clientFullName;
    private float $totalAmount;
    private float $installmentAmount;
    private int $installments;

    public function __construct(
        string $clientFullName,
        float $totalAmount,
        int $installments
    ) {
        $this->clientFullName = $clientFullName;
        $this->totalAmount = $totalAmount;
        $this->installments = $installments;
        $this->installmentAmount = $totalAmount / $installments;
    }

    public function toArray(): array {
        return [
            'clientFullName' => $this->clientFullName,
            'totalAmount' => $this->totalAmount,
            'installmentAmount' => $this->installmentAmount,
            'installments' => $this->installments
        ];
    }
}
