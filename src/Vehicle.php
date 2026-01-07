<?php

class Vehicle
{
    public int $amountOfWheels;
    public int $maximumSpeed;
    public string $color = 'black';

    public function __construct(int $amountOfWheels, int $maximumSpeed) {
        $this->amountOfWheels = $amountOfWheels;
        $this->maximumSpeed = $maximumSpeed;
    }

    public function calculateTimeForDistance(int $distance): float {
        return $distance / $this->maximumSpeed;
    }
}

$car = new Vehicle(4, 180);
$bike = new Vehicle(2, 20);

echo 'Time necessary for distance: ' . $car->calculateTimeForDistance(1360);
