<?php

function convertRupeesToWords($amount) {
    $ones = array(
        0 => 'Zero',
        1 => 'One',
        2 => 'Two',
        3 => 'Three',
        4 => 'Four',
        5 => 'Five',
        6 => 'Six',
        7 => 'Seven',
        8 => 'Eight',
        9 => 'Nine'
    );

    $twos = array(
        10 => 'Ten',
        11 => 'Eleven',
        12 => 'Twelve',
        13 => 'Thirteen',
        14 => 'Fourteen',
        15 => 'Fifteen',
        16 => 'Sixteen',
        17 => 'Seventeen',
        18 => 'Eighteen',
        19 => 'Nineteen',
        20 => 'Twenty',
        30 => 'Thirty',
        40 => 'Forty',
        50 => 'Fifty',
        60 => 'Sixty',
        70 => 'Seventy',
        80 => 'Eighty',
        90 => 'Ninety'
    );

    if ($amount < 10) {
        return $ones[$amount];
    } elseif ($amount < 20) {
        return $twos[$amount];
    } elseif ($amount < 100) {
        $tens = floor($amount / 10) * 10;
        $remainder = $amount % 10;
        return $twos[$tens] . ($remainder > 0 ? '-' . $ones[$remainder] : '');
    } elseif ($amount < 1000) {
        $hundreds = floor($amount / 100);
        $remainder = $amount % 100;
        return $ones[$hundreds] . ' Hundred' . ($remainder > 0 ? ' and ' . convertRupeesToWords($remainder) : '');
    } elseif ($amount < 100000) {
        $thousands = floor($amount / 1000);
        $remainder = $amount % 1000;
        return convertRupeesToWords($thousands) . ' Thousand' . ($remainder > 0 ? ' ' . convertRupeesToWords($remainder) : '');
    } elseif ($amount < 10000000) {
        $lakhs = floor($amount / 100000);
        $remainder = $amount % 100000;
        return convertRupeesToWords($lakhs) . ' Lakh' . ($remainder > 0 ? ' ' . convertRupeesToWords($remainder) : '');
    } elseif ($amount < 1000000000) {
        $crores = floor($amount / 10000000);
        $remainder = $amount % 10000000;
        return convertRupeesToWords($crores) . ' Crore' . ($remainder > 0 ? ' ' . convertRupeesToWords($remainder) : '');
    } else {
        return 'Amount is too large to convert.';
    }
}



?>
