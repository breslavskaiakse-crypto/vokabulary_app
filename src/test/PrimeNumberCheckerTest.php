<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require_once '../primenumber.php';

/**
 * Test class for PrimeNumberChecker
 */
class PrimeNumberCheckerTest extends TestCase
{
    private PrimeNumberChecker $checker;

    /**
     * Set up test fixture
     */
    protected function setUp(): void
    {
        $this->checker = new PrimeNumberChecker();
    }

    /**
     * Test that prime numbers return true
     * 
     * @dataProvider primeNumberProvider
     */
    public function testIsPrimeReturnsTrueForPrimeNumbers(int $number): void
    {
        $this->assertTrue($this->checker->isPrime($number));
    }

    /**
     * Test that non-prime numbers return false
     * 
     * @dataProvider nonPrimeNumberProvider
     */
    public function testIsPrimeReturnsFalseForNonPrimeNumbers(int $number): void
    {
        $this->assertFalse($this->checker->isPrime($number));
    }

    /**
     * Test edge cases: numbers less than 2
     * 
     * @dataProvider edgeCaseProvider
     */
    public function testIsPrimeReturnsFalseForEdgeCases(int $number): void
    {
        $this->assertFalse($this->checker->isPrime($number));
    }

    /**
     * Test large prime numbers
     */
    public function testIsPrimeWithLargePrimeNumbers(): void
    {
        $largePrimes = [97, 101, 103, 107, 109, 113, 127, 131, 137, 139, 149, 151];
        
        foreach ($largePrimes as $prime) {
            $this->assertTrue(
                $this->checker->isPrime($prime),
                "Failed asserting that {$prime} is prime"
            );
        }
    }

    /**
     * Test large composite numbers
     */
    public function testIsPrimeWithLargeCompositeNumbers(): void
    {
        $composites = [100, 102, 104, 105, 108, 110, 120, 125, 130, 135, 140, 150];
        
        foreach ($composites as $composite) {
            $this->assertFalse(
                $this->checker->isPrime($composite),
                "Failed asserting that {$composite} is not prime"
            );
        }
    }

    /**
     * Data provider for prime numbers
     */
    public static function primeNumberProvider(): array
    {
        return [
            [2],
            [3],
            [5],
            [7],
            [11],
            [13],
            [17],
            [19],
            [23],
            [29],
            [31],
            [37],
            [41],
        ];
    }

    /**
     * Data provider for non-prime numbers
     */
    public static function nonPrimeNumberProvider(): array
    {
        return [
            [1],
            [4],
            [6],
            [8],
            [9],
            [10],
            [12],
            [14],
            [15],
            [16],
            [18],
            [20],
            [21],
            [22],
            [24],
            [25],
            [26],
            [27],
            [28],
            [30],
            [32],
            [33],
            [34],
            [35],
        ];
    }

    /**
     * Data provider for edge cases
     */
    public static function edgeCaseProvider(): array
    {
        return [
            [0],
            [-1],
            [-2],
            [-10],
            [-100],
        ];
    }
}

