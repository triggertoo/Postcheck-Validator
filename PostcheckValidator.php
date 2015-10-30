<?php

class PostcheckValidator
{
    /**
     * Validates a Postcheck number
     * @see http://search.cpan.org/dist/Algorithm-CheckDigits/lib/Algorithm/CheckDigits/M10_010.pm
     *
     * @param String $pc Postcheck number
     *
     * @return bool
     */
    public static function isValidPostcheck($pc)
    {
      $pcParts = explode('-', $pc);

      if (count($pcParts) !== 3) {
        return false;
      }

      foreach ($pcParts as $pcPart) {
        if (!is_numeric($pcPart)) {
          return false;
        }
      }

      $digits = str_split($pcParts[0] . $pcParts[1]);
      $checkDigit = (int) $pcParts[2];
      $sequence = array(0, 9, 4, 6, 8, 2, 7, 1, 3, 5);

      $cf = 0; // carry forward

      foreach ($digits as $digit) {
        $p = ($digit + $cf) % 10; // position
        $cf = $sequence[$p];
      }

      if ((10 - $cf) % 10 === $checkDigit) {
        return true;
      }

      return false;
    }
}