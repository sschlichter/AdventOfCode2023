<?php

namespace App;

class Day6 extends DayBase
{
    public function part1(): int
    {
        $sum = 1;
        $lines = explode("\n", $this->contents);


        $times = preg_split('/\s+/', trim(explode(":", array_shift($lines))[1]));
        $distances = preg_split('/\s+/', trim(explode(":", array_shift($lines))[1]));

        for($i = 0; $i < count($times); $i++){
            $wins = 0;
            for($holdTime = 1; $holdTime < $times[$i]; $holdTime++){
                $driveTime = $times[$i] - $holdTime;
                if($driveTime * $holdTime > $distances[$i]){
                    $wins++;
                }
            }
            $sum *= $wins;
        }

        return $sum;
    }

    public function part2(): int
    {
        $lines = explode("\n", $this->contents);

        $times = preg_split('/\s+/', trim(explode(":", array_shift($lines))[1]));
        $distances = preg_split('/\s+/', trim(explode(":", array_shift($lines))[1]));

        $time = intval(implode($times));
        $distance = intval(implode($distances));

        $minTime = 0;
        $maxTime = $time;
        for($i = 0; $i < $time; $i++){
            if($time * $i - pow($i, 2) >= $distance){
                $minTime = $i;
                break;
            }
        }
        for($i = $time; $i > 0; $i--){
            if($time * $i - pow($i, 2) >= $distance){
                $maxTime = $i;
                break;
            }
        }
        return $maxTime - $minTime + 1;
    }
}
