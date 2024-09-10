<?php

use App\Models\Invoice;

if (!function_exists('generateInvoiceNumber')) {
    function generateInvoiceNumber()
    {
        // Get the last invoice number from the database
        $lastInvoice = Invoice::orderBy('id', 'desc')->first();

        // Default start
        $nextNumber = 1;

        if ($lastInvoice) {
            // Extract the numeric part from the last invoice number
            $lastInvoiceNumber = intval(str_replace('INV', '', $lastInvoice->invoice_number));

            // Increment the number
            $nextNumber = $lastInvoiceNumber + 1;
        }

        // Format the number with leading zeros (for numbers less than 10000)
        $formattedNumber = str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        // Prepend 'INV' to the formatted number
        return 'INV' . $formattedNumber;
    }
}
