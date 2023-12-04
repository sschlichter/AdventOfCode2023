<?php

namespace App;

class Day2 extends DayBase
{
    public function part1(): int
    {
        $actualRedCubeCount = 12;
        $actualGreenCubeCount = 13;
        $actualBlueCubeCount = 14;
        $gameSum = 0;

        foreach(explode("\n", $this->contents) as $line){
            if(preg_match("/^Game \d*:/", $line))
                $gameNumber = intval(trim(explode(" ", explode(":", $line)[0])[1]));
            else{
                continue;
            }
            $fullGame = trim(explode(":", $line)[1]);
            $thisGameBlueCount = 0;
            $thisGameGreenCount = 0;
            $thisGameRedCount = 0;
            foreach (explode(";", $fullGame) as $game) {
                foreach (explode(",", $game) as $pull) {
                    $color = explode(" ", trim($pull))[1];
                    $num = intval(explode(" ", trim($pull))[0]);
                    if (strtolower(trim($color)) == 'blue') {
                        if ($num > $thisGameBlueCount){
                            $thisGameBlueCount = $num;
                        }
                    } elseif (strtolower(trim($color)) == 'green') {
                        if ($num > $thisGameGreenCount){
                            $thisGameGreenCount = $num;
                        }
                    } elseif (strtolower(trim($color)) == 'red') {
                        if ($num > $thisGameRedCount){
                            $thisGameRedCount = $num;
                        }
                    }
                }
            }
            if ($thisGameBlueCount <= $actualBlueCubeCount && $thisGameGreenCount <= $actualGreenCubeCount && $thisGameRedCount <= $actualRedCubeCount) {
                $gameSum += $gameNumber;
            }
        }
        return $gameSum;
    }

    public function part2(): int
    {
        $actualRedCubeCount = 12;
        $actualGreenCubeCount = 13;
        $actualBlueCubeCount = 14;
        $gameSum = 0;

        foreach(explode("\n", $this->contents) as $line)
        {
            if(empty($line))
            {
                continue;
            }
            $fullGame = trim(explode(":", $line)[1]);
            $thisGameBlueCount = 1;
            $thisGameGreenCount = 1;
            $thisGameRedCount = 1;
            foreach (explode(";", $fullGame) as $game) {
                foreach (explode(",", $game) as $pull) {
                    $color = explode(" ", trim($pull))[1];
                    $num = intval(explode(" ", trim($pull))[0]);
                    if (strtolower(trim($color)) == 'blue') {
                        if ($num > $thisGameBlueCount){
                            $thisGameBlueCount = $num;
                        }
                    } elseif (strtolower(trim($color)) == 'green') {
                        if ($num > $thisGameGreenCount){
                            $thisGameGreenCount = $num;
                        }
                    } elseif (strtolower(trim($color)) == 'red') {
                        if ($num > $thisGameRedCount){
                            $thisGameRedCount = $num;
                        }
                    }
                }
            }
            $power = $thisGameGreenCount * $thisGameRedCount * $thisGameBlueCount;
            $gameSum+=$power;
        }
        return $gameSum;
    }
}
