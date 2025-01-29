<?php

declare(strict_types=1);

namespace App;

class Helper
{
    public static function fakeCardNumber(): string
    {
        $numberList = ['4', '5', '37'];
        $randNumber = array_rand($numberList);
        $cardNumber = $numberList[$randNumber];

        $length = 16;

        while (strlen($cardNumber) < $length - 1) {
            $cardNumber .= mt_rand(0, 9);
        }

        $cardNumber .= self::calculateCardNumberChecksum($cardNumber);

        return $cardNumber;
    }

    private static function calculateCardNumberChecksum(string $number): int
    {
        $sum = 0;
        $reverseDigits = strrev($number);

        for ($i = 0; $i < strlen($reverseDigits); $i++) {
            $digit = (int) $reverseDigits[$i];

            if ($i % 2 === 0) {
                $digit *= 2;

                if ($digit > 9) {
                    $digit -= 9;
                }
            }

            $sum += $digit;
        }

        return (10 - ($sum % 10)) % 10;
    }

    public static function makePostRequest(string $url, array $payload): array
    {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

        $responseBody = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        return [
            'status' => $statusCode,
            'body'   => json_decode($responseBody, true),
        ];
    }
}
