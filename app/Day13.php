<?php

namespace App;

class Day13 extends DayBase
{
    public function part1(): int
    {
        $sum = 0;
        foreach(explode("\n\n", $this->contents) as $pattern)
        {
            $arr = array();
            $i = 0;
            foreach(explode("\n", $pattern) as $line){
                if(empty($line) == false) {
                    $arr[$i] = str_split($line);
                    $i++;
                }
            }
            //dump("check horizontal");
            $horizontal = $this->findReflection($arr);
            //dump("check vertical");
            $vertical = $this->findReflection($this->flipDiagonally($arr));
            if($horizontal > 0){
                //dump($horizontal);
                $sum += 100 * $horizontal;
            }
            else if($vertical > 0){
                //dump($vertical);
                $sum += $vertical;
            }
            else{
                dump('wat');
            }
        }
        return $sum;
    }

    public function findReflection($arr): int
    {
        //dump($arr);
        $arrLength = max(array_keys($arr));
        for($i = 0; $i < $arrLength; $i++){
            if($arr[$i] == $arr[$i+1]){
                //dump("initial match starting on line " . $i . " to array length " . $arrLength);
                $up = $i - 1;
                $down = $i + 2;
                //dump($up . " and " . $down);
                $match = true;
                while($up >= 0 && $down <= $arrLength){
                    if($arr[$up] == $arr[$down]){
                        $up--;
                        $down++;
                        //dump($up . " and " . $down);
                    }
                    else{
//                        dump("no match");
//                        dump($arr[$up]);
//                        dump($arr[$down]);
                        $match = false;
                        break;
                    }
                }
                if($match)
                    return $i+1;
            }
        }
        return -1;
    }

    public function findSmudgeReflection($arr): int
    {
        //dump($arr);
        $arrLength = max(array_keys($arr));
        for($i = 0; $i < $arrLength; $i++){
            $mismatches = 0;
            if($this->lineDifferences($arr[$i], $arr[$i+1]) <= 1){
                $mismatches += $this->lineDifferences($arr[$i], $arr[$i+1]);
                //dump("initial match starting on line " . $i . " to array length " . $arrLength);
                $up = $i - 1;
                $down = $i + 2;
                //dump($up . " and " . $down);
                $match = true;
                while($up >= 0 && $down <= $arrLength){
                    if($this->lineDifferences($arr[$up], $arr[$down]) <= 1 && $mismatches <= 1){
                        $mismatches += $this->lineDifferences($arr[$up], $arr[$down]);
                        $up--;
                        $down++;
                        //dump($up . " and " . $down);
                    }
                    else{
//                        dump("no match");
//                        dump($arr[$up]);
//                        dump($arr[$down]);
                        $match = false;
                        break;
                    }
                }
                if($match && $mismatches == 1)
                    return $i+1;
            }
        }
        return -1;
    }

    public function lineDifferences($line1, $line2): int{
        $len = max(array_keys($line1));
        $mismatches = 0;
        for($i = 0; $i <= $len; $i++){
            if($line1[$i] != $line2[$i]){
                $mismatches++;
            }
        }
        return $mismatches;
    }

    public function flipDiagonally($arr) {
        $out = array();
        foreach ($arr as $key => $subarr) {
            foreach ($subarr as $subkey => $subvalue) {
                $out[$subkey][$key] = $subvalue;
            }
        }
        return $out;
    }

    public function part2(): int
    {
        $sum = 0;
        foreach(explode("\n\n", $this->contents) as $pattern)
        {
            $arr = array();
            $i = 0;
            foreach(explode("\n", $pattern) as $line){
                if(empty($line) == false) {
                    $arr[$i] = str_split($line);
                    $i++;
                }
            }
            $horizontal = $this->findSmudgeReflection($arr);
            $vertical = $this->findSmudgeReflection($this->flipDiagonally($arr));
            if($horizontal > 0){
                $sum += 100 * $horizontal;
            }
            else if($vertical > 0){
                $sum += $vertical;
            }
            else{
                dump('wat');
            }
        }
        return $sum;
    }
}
