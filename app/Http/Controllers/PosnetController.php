<?php

namespace App\Http\Controllers;

use App\Models\CreditCard;
use App\Models\Posnet;
use Exception;
use Illuminate\Http\Request;

class PosnetController extends Controller {
    private Posnet $posnet;

    public function __construct() {
        $this->posnet = new Posnet();
    }

    public function registerCard(Request $request) {
        try {
            $card = new CreditCard(
                $request->cardType,
                $request->bankName,
                $request->cardNumber,
                $request->availableLimit,
                [
                    'dni' => $request->holderDNI,
                    'name' => $request->holderName,
                    'lastName' => $request->holderLastName
                ]
            );

            $this->posnet->registerCard($card);

            return response()->json([
                'status' => 'success',
                'message' => 'Card registered successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function processPayment(Request $request) {
        try {
            $card = $this->findCard($request->cardNumber);

            $ticket = $this->posnet->doPayment(
                $card,
                $request->amount,
                $request->installments
            );

            return response()->json([
                'status' => 'success',
                'ticket' => $ticket->toArray()
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function findCard(string $cardNumber): CreditCard {
        $card = CreditCard::where('card_number', $cardNumber)->first();

        if (!$card) {
            throw new Exception('Card not found');
        }

        return $card;
    }
}
