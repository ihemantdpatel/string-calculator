<?php

declare(strict_types=1);

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Calculator;

final class CalculatorTest extends TestCase
{
    /**
     * @test
     * Case 1
    */
    public function emptyString(): void
    {
        $calc = new Calculator();
        $this->assertEquals(0, $calc->add(""));
    }

    /**
     * @test
     * @dataProvider inValidInputProvider
    */
    public function invalidString(?string $input): void
    {
        $calc = new Calculator();
        try {
            $this->assertEquals(0, $calc->add($input));
        } catch (\Exception $e) {
            $this->assertEquals($e->getMessage(), 'Invalid input');
        }
    }

    /**
     * @test
     * Case 4
    */
    public function negativeWithSingleNumber(): void
    {
        $calc = new Calculator();
        try {
            $calc->add("1,-2");
            $this->fail("Expected exception not thrown");
        } catch (\Exception $e) {
            $this->assertEquals($e->getMessage(), 'Negatives not allowed. Invalid input -2');
        }
    }

    /**
     * @test
     * Case 4
    */
    public function negativeWithMultipleNumber(): void
    {
        $calc = new Calculator();
        try {
            $calc->add("1,-2,-3,-4");
            $this->fail("Expected exception not thrown");
        } catch (\Exception $e) {
            $this->assertEquals($e->getMessage(), 'Negatives not allowed. Invalid input -2,-3,-4');
        }
    }

    /**
     * @test
     * @dataProvider validStringInputProvider
    */
    public function nonEmptyString(int $output, string $input): void
    {
        $calc = new Calculator();
        $this->assertEquals($output, $calc->add($input));
    }

    /**
     * @return array<int,array<int,int|string>>
     */
    public function validStringInputProvider(): array
    {
        return [
            [2, "1"],                               //Case 1
            [3, "1,2"],                             //Case 1
            [9, "1\n,2,1,5"],                       //Case 2.a
            [12, "1,\n3,2,6"],                      //Case 2.b
            [13, "\n1,3,\n2,7\n"],                  //Case 2
            [6, "//$\n1$2$3"],                      //Case 3
            [6, "//_\n1_2_3"],                      //Case 3
            [6, "//;\n1;2;3"],                      //Case 3
            [7, "//@\n1@2@4"],                      //Case 3
            [2, "2,1001"],                          //Bonus Case 1
            [2, "2,1001"],                          //Bonus Case 1
            [8, "//***\n1***2***5"],                //Bonus Case 2
            [1, "//***\n1"],                        //Bonus Case 2
            [10, "//$$$\n1$$$5$$$4$$$1001"],        //Bonus Case 1&2
            [7, "//$,@\n1$2@4"],                    //Bonus Case 3
            [15, "//$,@\n15"],                      //Bonus Case 3
            [14, "//$,@,;\n1$2@4;7"],               //Bonus Case 3
            [5, "//***,$$$\n1$$$2***2"],            //Bonus Case 4
            [5, "//***,$$$\n1$$$2***2$$$1001"]     //Bonus Case 1&4
        ];
    }

    /**
     * @return array<int,array<int,string|null|int>>
     */
    public function inValidInputProvider(): array
    {
        return [
            ["$\n1$2$3"],
            ["1,,2,3"],
            ["//\n1$2$3"],
            ["\n1$2$3"],
            ["//$,@\n"],
            ["2&1001"],
            [null]
        ];
    }
}
