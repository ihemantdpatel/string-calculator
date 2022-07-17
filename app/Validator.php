<?php

declare(strict_types=1);

namespace App;

/**
 * Validations for String Calculator
 * @author  Hemant Patel <ihemantpatel@outlook.com>
*/
class Validator
{
    public string $exception_message;
    private bool $is_valid;

    public function __construct()
    {
        $this->is_valid = true;
        $this->exception_message = "Negatives not allowed. Invalid input ";
    }

    /**
        * @param array<int> $numbers
    */
    public function isValid(array $numbers): bool
    {
        // Check for Invalid Numbers
        foreach ($numbers as $number) {
            if (!is_numeric($number) || empty($number)) {
                $this->exception_message = "Invalid input";
                $this->is_valid = false;
            }
        }

        // Check for Negative Numbers
        foreach ($numbers as $number) {
            if (is_numeric($number) &&  $number < 0) {
                $this->is_valid = false;
                $this->exception_message = $this->exception_message . $number . ',';
            }
        }
        return $this->is_valid;
    }
}
