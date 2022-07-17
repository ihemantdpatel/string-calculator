<?php

declare(strict_types=1);

namespace App\Library\Parsers;

use App\Library\Parser;

/**
    * @property array<string> $delimiters
    * @property array<int> $numbers
*/
class StringParser implements Parser
{
    private string $delimiter_control;
    public string $input;

    /** @var array<int,string> */
    private array $delimiters;
    /** @var array<int,string>|array<int,int> */
    public array $numbers;

    public function __construct()
    {
        // Format: "//[delimiter]\n[delimiter separated numbers]"
        $this->delimiter_control = "/\/\/(.*)/";
        $this->delimiters = [];
        $this->numbers = [];
        $this->input = "";
    }

    /**
     * @return void
     */
    public function parse(): void
    {
        //The beginning of the string will now contain a small control code which is a custom delimiter.
        $this->delimiters = $this->getDelimiter();
        // If not delimiter present then throw an exception
        if (!$this->delimiters) {
            throw new \InvalidArgumentException('Invalid input');
        }
        //use the above delimiter to split the numbers.
        $this->fetchNumbers();
    }

    /**
        *@return array<string>
    */
    private function getDelimiter(): array
    {
        preg_match($this->delimiter_control, $this->input, $matches);
        return isset($matches[1]) ? explode(',', $matches[1]) : [','];
    }

    /**
     * @return void
     */
    private function fetchNumbers(): void
    {
        $this->multiexplode($this->removeControlCodeFromInput());
    }

    /**
     * @return string
     */
    private function removeControlCodeFromInput(): string
    {
        return str_replace('//' . implode(',', $this->delimiters), '', $this->input);
    }

    /**
     * @param string $string
     *
     * @return void
     */
    private function multiexplode(string $string): void
    {
        // Explode string with multiple delimiters.
        $ready = preg_replace('/\s+/', ' ', str_replace($this->delimiters, $this->delimiters[0], $string));
        if (is_null($ready) || empty($this->delimiters[0])) {
            throw new \InvalidArgumentException('Invalid input');
        } else {
            $this->numbers = explode($this->delimiters[0], $ready);
        }
    }
}
