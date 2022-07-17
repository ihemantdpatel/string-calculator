<?php

declare(strict_types=1);

namespace App;

use App\Validator;
use App\Library\Parser;
use App\Library\ParserFactory;

/**
 * String Calculator
 * @author  Hemant Patel <ihemantpatel@outlook.com>
*/
class Calculator
{
    private Parser $parser;
    private Validator $validator;

    /**
    * No Negative Numbers
    * @var int
    */
    private const LOWER_LIMIT = 0;
    /**
    * Upper Limit
    * @var int
    */
    private const UPPER_LIMIT = 1000;

    public function __construct()
    {
        // Can be optimized using Dependency Injection.
        $this->validator = new Validator();
        $this->parser = (new ParserFactory())->create(ParserFactory::STRING);
    }

    /**
     * Parse given input as string and perform addition on those numbers. Output should be an integer.
     * @param string $numbers
     * @return int
     */
    public function add(?string $numbers): int
    {
        try {
            //Empty strings should return 0.
            if (empty($numbers)) {
                return 0;
            } else {
                $this->parser->input =  trim($numbers);
                $this->parser->parse();
                if ($this->validator->isValid($this->parser->numbers)) {
                    return $this->calculate();
                } else {
                    throw new \InvalidArgumentException(trim($this->validator->exception_message, ','));
                }
            }
        } catch (\Exception $e) {
            throw $e;
        } finally {
            unset($this->parser);
            unset($this->validator);
            unset($this->exception_message);
            unset($this->is_exception);
        }
    }

    /**
     * @return int
     */
    private function calculate(): int
    {
        //Numbers larger than 1000 should be ignored.
        $final_numbers = array_filter($this->parser->numbers, function (int $value) {
            return ($value >= self::LOWER_LIMIT && $value <= self::UPPER_LIMIT);
        });
        return array_sum($final_numbers);
    }
}
