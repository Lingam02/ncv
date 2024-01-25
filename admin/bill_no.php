<?php
function invoice_num($input, $pad_len = 7, $prefix = null)
{
    if ($pad_len <= strlen($input)) {
        trigger_error('$pad_len cannot be less than or equal to the length of $input to generate an invoice number', E_USER_ERROR);
    }

    if (is_string($prefix)) {
        return sprintf("%s%s", $prefix, str_pad($input, $pad_len, "0", STR_PAD_LEFT));
    }

    return str_pad($input, $pad_len, "0", STR_PAD_LEFT);
}

// Generate the invoice number
$generated_invoice = invoice_num(1); // Change the parameters as needed

?>