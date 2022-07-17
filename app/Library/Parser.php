<?php

declare(strict_types=1);

namespace App\Library;

/**
 * @property string $input
 * @property array<int> $numbers
*/

interface Parser
{
    /**
     * Parses the given string to fetch delimiters & Numbers.
     *
     * @return void
    */
    public function parse(): void;
}
