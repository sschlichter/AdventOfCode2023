<?php

namespace App;

class Day4 extends DayBase
{
    public function part1(): int
    {
        $sum = 0;

        foreach(explode("\n", $this->contents) as $line) {
            if(!empty($line)){
                $score = 0;
                $game = explode(":", $line)[1];
                $winningNumbers = explode("|", $game)[0];
                $winners = explode(" ", $winningNumbers);
                $myNumbers = explode("|", $game)[1];
                $nums = explode(" ", $myNumbers);
                foreach($nums as $i){
                    if(empty($i)){
                        continue;
                    }
                    if(in_array($i, $winners)){
                        if($score == 0){
                            $score = 1;
                        }else{
                            $score *= 2;
                        }
                    }
                }
                $sum += $score;
            }
        }
        return $sum;
    }

    public function part2(): int
    {
        $numOfCards = array_fill(0, 214, 1);
        $currentCardIndex = 0;
        foreach(explode("\n", $this->contents) as $line) {
            if (!empty($line)) {
                $matches = 0;
                $game = explode(":", $line)[1];
                $winningNumbers = explode("|", $game)[0];
                $winners = explode(" ", $winningNumbers);
                $myNumbers = explode("|", $game)[1];
                $nums = explode(" ", $myNumbers);
                foreach($nums as $i){
                    if(empty($i)){
                        continue;
                    }
                    if(in_array($i, $winners)){
                        $matches++;
                    }
                }
                for($i = 1; $i <= $matches; $i++){
                    if($currentCardIndex + $i < 214) {
                        $numOfCards[$currentCardIndex + $i]+=$numOfCards[$currentCardIndex];
                    }
                }
            }
            $currentCardIndex++;
        }
        return array_sum($numOfCards);
    }
}
