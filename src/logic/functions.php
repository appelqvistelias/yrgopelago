<?php

declare(strict_types=1);

// See if transferCode is valid
function isValidUuid(string $uuid): bool
{

    if (!is_string($uuid) || (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $uuid) !== 1)) {
        return false;
    }

    return true;
}

// Discount function
function calculateDiscount(float $totalCost): float
{
    $discount = $totalCost * 0.7;
    return round($discount);
}

// Sanitize input
function sanitizeInput(string $input): string
{
    return trim(htmlspecialchars($input));
}