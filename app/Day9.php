<?php

namespace App;

class Day9 extends DayBase
{
    public function part1(): int
    {
        $sum = 0;
        foreach(explode("\n", $this->contents) as $line)
        {
            if(!empty($line))
            {
                $reading = explode(' ', $line);
                $nextReading = end($reading) + $this->getNextReading($reading);
                $sum += $nextReading;
            }
        }
        return $sum;
    }

    public function getNextReading($array)
    {
        for($i = 1; $i < count($array); $i++)
        {
            $diff = $array[$i] - $array[$i-1];
            $newArray[] = $diff;
        }
        if(empty($newArray) || $this->isAllZeros($newArray)){
            return 0;
        }
        else{
            return end($newArray) + $this->getNextReading($newArray);
        }
    }

    public function getPreviousReading($array)
    {
        for($i = 1; $i < count($array); $i++)
        {
            $diff = $array[$i] - $array[$i-1];
            $newArray[] = $diff;
        }
        if(empty($newArray) || $this->isAllZeros($newArray)){
            return 0;
        }
        else{
            return reset($newArray) - $this->getPreviousReading($newArray);
        }
    }

    public function isAllZeros($array)
    {
        $all_zero = true;
        foreach($array as $value) {
            if ($value != '0') {
                $all_zero = false;
                break;
            }
        }
        return $all_zero;
    }

    public function part2(): int
    {
        $sum = 0;
        foreach(explode("\n", $this->contents) as $line)
        {
            if(!empty($line))
            {
                $reading = explode(' ', $line);
                $nextReading = reset($reading) - $this->getPreviousReading($reading);
                $sum += $nextReading;
            }
        }
        return $sum;
    }
}
