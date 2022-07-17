<?php

namespace App\Library;

use App\Library\Parsers\StringParser;
use App\Library\Parser;

/**
 * [Description ParserFactory]
 */
class ParserFactory
{
    public const STRING = 'STRING';

    public function create(string $kind): Parser
    {
        switch ($kind) {
            case self::STRING:
            default:
                return new StringParser();
        }
    }
}
