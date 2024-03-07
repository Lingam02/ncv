<?php
function tagcal($string)
{
    // Extract numeric part and prefix from the input tag
    if (preg_match('/(\d+)$/', $string, $matches)) {
        $numericPart = $matches[1];
        $numlen = strlen($numericPart);
        $position = strlen($string) - $numlen;

        // Use substr to get the string part without the numeric part
        $stringPart = substr($string, 0, $position);

        $newIntValue = intval($numericPart) + 1;
        $newStrValue = sprintf('%0' . $numlen . 'd', $newIntValue);

        $newtag =  $stringPart . $newStrValue;

        return $newtag;
    } else {
        echo "No numeric part found\n";
    }
}
echo 'test';
echo tagcal('A23-0A2034', 2);
