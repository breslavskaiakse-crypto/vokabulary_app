<?php

declare(strict_types=1);

/**
 * Class PrimeNumberChecker
 * 
 * Provides functionality to check whether a given number is a prime number.
 * A prime number is a natural number greater than 1 that has no positive 
 * divisors other than 1 and itself.
 */
class PrimeNumberChecker
{
    /**
     * Checks whether a given number is a prime number.
     * 
     * @param int $number The number to check
     * @return bool True if the number is prime, false otherwise
     */
    public function isPrime(int $number): bool
    {
        // Numbers less than 2 are not prime
        if ($number < 2) {
            return false;
        }
        
        // 2 is the only even prime number
        if ($number === 2) {
            return true;
        }
        
        // Even numbers greater than 2 are not prime
        if ($number % 2 === 0) {
            return false;
        }
        
        // Check for divisors from 3 to sqrt($number), stepping by 2 (only odd numbers)
        // We only need to check up to sqrt($number) because if a number has a factor
        // greater than sqrt($number), it must also have a factor less than sqrt($number)
        $sqrt = (int)sqrt($number);
        for ($i = 3; $i <= $sqrt; $i += 2) {
            if ($number % $i === 0) {
                return false;
            }
        }
        
        return true;
    }
}

// Example usage (commented out):
// $checker = new PrimeNumberChecker();
// echo $checker->isPrime(7) ? "7 is prime\n" : "7 is not prime\n";
// echo $checker->isPrime(10) ? "10 is prime\n" : "10 is not prime\n";
// echo $checker->isPrime(17) ? "17 is prime\n" : "17 is not prime\n";

