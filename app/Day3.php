<?php

namespace App;

class Day3 extends DayBase
{
    public function part1(): int
    {
        $sum = 0;
        $fileArray = explode("\n", $this->contents);
        for($i = 0; $i < count($fileArray); $i++){
            for($j = 0; $j<strlen($fileArray[$i]); $j++){
                if(preg_match('/\d/', $fileArray[$i][$j])){
                    //$this->info("Found! " . $fileArray[$i][$j]);
                    $startIndex = $j;
                    $endIndex = $j;
                    $numString = $fileArray[$i][$j];
                    //check right of digit
                    while($j + 1 < strlen($fileArray[$i]) && preg_match('/\d/', $fileArray[$i][$j + 1])){
                        $numString .= $fileArray[$i][$j + 1];
                        $endIndex = $j + 1;
                        $j++;
                    }
                    //is there a symbol somewhere close by?
                    $foundSymbol = false;
                    //look on the line above
                    for($x = $startIndex - 1; $x <= $endIndex + 1 && $i > 0 && $x < strlen($fileArray[$i]); $x++){
                        if(preg_match('/[^\d|.]/', $fileArray[$i-1][$x])){
                            $foundSymbol = true;
                        }
                    }
                    //look left
                    if(preg_match('/[^\d|.]/', $fileArray[$i][$startIndex - 1])){
                        $foundSymbol = true;
                    }
                    //look right
                    if($endIndex + 1 < strlen($fileArray[$i]) && preg_match('/[^\d|.]/', $fileArray[$i][$endIndex + 1])){
                        $foundSymbol = true;
                    }
                    //look below
                    if($i + 1 < count($fileArray) - 1) {
                        for ($x = $startIndex - 1; $x <= $endIndex + 1 && $i < count($fileArray) - 1 && $x < strlen($fileArray[$i]); $x++) {
                            if (preg_match('/[^\d|.]/', $fileArray[$i + 1][$x])) {
                                $foundSymbol = true;
                            }
                        }
                    }
                    if($foundSymbol){
                        $sum += intval($numString);
                    }
                }
            }
        }
        return $sum;
    }

    public function part2(): int
    {
        $sum = 0;
        $fileArray = explode("\n", $this->contents);

        for($i = 0; $i < count($fileArray); $i++) {
            for ($j = 0; $j < strlen($fileArray[$i]); $j++) {
                if(preg_match('/\*/', $fileArray[$i][$j])){
                    $partNumberCount = 0;
                    $gearRatio = 1;
                    //check line above
                    if($i > 0){
                        for($x = $j - 1; $x <= $j + 1; $x++){
                            if(preg_match('/\d/', $fileArray[$i - 1][$x])){
                                $numString = $fileArray[$i - 1][$x];
                                $left = 1;
                                while($x - $left >= 0 && preg_match('/\d/', $fileArray[$i - 1][$x - $left])){
                                    $numString = $fileArray[$i - 1][$x - $left] . $numString;
                                    $left++;
                                }
                                while($x + 1 < strlen($fileArray[$i - 1]) && preg_match('/\d/', $fileArray[$i - 1][$x + 1])){
                                    $numString .= $fileArray[$i - 1][$x + 1];
                                    $x++;
                                }
                                $gearRatio *= intval($numString);
                                $partNumberCount++;
                            }
                        }
                    }
                    //check line below
                    if($i + 1 < count($fileArray)){
                        for($x = $j - 1; $x < strlen($fileArray[$i + 1]) && $x >= 0 && $x <= $j + 1; $x++){
                            if(preg_match('/\d/', $fileArray[$i + 1][$x])){
                                $numString = $fileArray[$i + 1][$x];
                                $left = 1;
                                while($x - $left >= 0 && preg_match('/\d/', $fileArray[$i + 1][$x - $left])){
                                    $numString = $fileArray[$i + 1][$x - $left] . $numString;
                                    $left++;
                                }
                                while($x + 1 < strlen($fileArray[$i + 1]) && preg_match('/\d/', $fileArray[$i + 1][$x + 1])){
                                    $numString .= $fileArray[$i + 1][$x + 1];
                                    $x++;
                                }
                                $gearRatio *= intval($numString);
                                $partNumberCount++;
                            }
                        }
                    }
                    //check left
                    if($j > 0){
                        if(preg_match('/\d/', $fileArray[$i][$j - 1])){
                            $numString = $fileArray[$i][$j - 1];
                            $left = 2;
                            while($j - $left >= 0 && preg_match('/\d/', $fileArray[$i][$j - $left])){
                                $numString = $fileArray[$i][$j - $left] . $numString;
                                $left++;
                            }
                            $gearRatio *= intval($numString);
                            $partNumberCount++;
                        }
                    }
                    //check right
                    if($j + 1 < strlen($fileArray[$i])){
                        if(preg_match('/\d/', $fileArray[$i][$j + 1])){
                            $numString = $fileArray[$i][$j + 1];
                            $j++;
                            while($j + 1 < strlen($fileArray[$i]) && preg_match('/\d/', $fileArray[$i][$j + 1])){
                                $numString .= $fileArray[$i][$j + 1];
                                $j++;
                            }
                            $gearRatio *= intval($numString);
                            $partNumberCount++;
                        }
                    }

                    if($partNumberCount == 2){
                        $sum += $gearRatio;
                    }
                }
            }
        }
        return $sum;
    }
}
