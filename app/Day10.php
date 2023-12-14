<?php

namespace App;

class Day10 extends DayBase
{
    public function part1(): int
    {
        $sum = 0;
        $start = $this->findStartingPoint();
        $x1 = $start[0];
        $y1 = $start[1];
        $nextDirection1 = 'N';
        $x2 = $start[0];
        $y2 = $start[1];
        $nextDirection2 = 'S';

        // find the two paths from the starting point
        $westValue = substr(explode("\n", $this->contents)[$x1], $y1 - 1, 1);
        $eastValue = substr(explode("\n", $this->contents)[$x1], $y1 + 1, 1);
        $northValue = substr(explode("\n", $this->contents)[$x1 - 1], $y1, 1);
        $southValue = substr(explode("\n", $this->contents)[$x1 + 1], $y1, 1);
        $firstDirectionFound = false;
        if($westValue == '-' || $westValue == 'L' || $westValue == 'F'){
            $y1--;
            $firstDirectionFound = true;
            if($westValue == '-')
                $nextDirection1 = 'W';
            else if ($westValue == 'L')
                $nextDirection1 = 'N';
            else if ($westValue == 'F')
                $nextDirection1 = 'S';
        }
        if($eastValue == '-' || $eastValue == 'J' || $eastValue == '7'){
            if($firstDirectionFound){
                $y2++;
                if($eastValue == '-')
                    $nextDirection2 = 'E';
                else if ($eastValue == 'J')
                    $nextDirection2 = 'N';
                else if ($eastValue == '7')
                    $nextDirection2 = 'S';
            }
            else{
                $y1++;
                if($eastValue == '-')
                    $nextDirection1 = 'E';
                else if ($eastValue == 'J')
                    $nextDirection1 = 'N';
                else if ($eastValue == '7')
                    $nextDirection1 = 'S';
            }
        }
        if($northValue == '|' || $northValue == 'F' || $northValue == '7'){
            if($firstDirectionFound){
                $x2--;
                if($northValue == '|')
                    $nextDirection2 = 'N';
                else if ($northValue == 'F')
                    $nextDirection2 = 'E';
                else if ($northValue == '7')
                    $nextDirection2 = 'W';
            }
            else{
                $x1--;
                if($northValue == '|')
                    $nextDirection1 = 'N';
                else if ($northValue == 'F')
                    $nextDirection1 = 'E';
                else if ($northValue == '7')
                    $nextDirection1 = 'W';
            }
        }
        if($southValue == '|' || $southValue == 'J' || $southValue == 'L'){
            $x2++;
            if($southValue == '|')
                $nextDirection2 = 'S';
            else if ($southValue == 'J')
                $nextDirection2 = 'W';
            else if ($southValue == 'L')
                $nextDirection2 = 'E';
        }

        $sum++;
        $prevx1 = -1;
        $prevy1 = -1;

        while(($x1 != $x2 || $y1 != $y2) && ($prevx1 != $x2 || $prevy1 != $y2)){
            if($sum % 1000 == 0){
                dump('Iterating ' . $sum);
            }
            $prevx1 = $x1;
            $prevy1 = $y1;
            $firstPath = $this->findNextCoordinate($x1, $y1, $nextDirection1);
            //dump($firstPath);
            $secondPath = $this->findNextCoordinate($x2, $y2, $nextDirection2);
            //dump($secondPath);


            $x1 = $firstPath[0];
            $y1 = $firstPath[1];
            $nextDirection1 = $firstPath[2];

            $x2 = $secondPath[0];
            $y2 = $secondPath[1];
            $nextDirection2 = $secondPath[2];

            $sum++;
        }

        return $sum;
    }

    public function findStartingPoint(){
        for($i = 0; $i < count(explode("\n", $this->contents)); $i++){
            for($j = 0; $j < strlen(explode("\n", $this->contents)[$i]); $j++) {
                if(substr(explode("\n", $this->contents)[$i], $j, 1) == 'S'){
                    return [$i, $j];
                }
            }
        }
    }

    public function findNextCoordinate($x, $y, $nextDirection){
        if($y > 0)
            $westValue = substr(explode("\n", $this->contents)[$x], $y - 1, 1);
        $eastValue = substr(explode("\n", $this->contents)[$x], $y + 1, 1);
        if($x > 0)
            $northValue = substr(explode("\n", $this->contents)[$x - 1], $y, 1);
        $southValue = substr(explode("\n", $this->contents)[$x + 1], $y, 1);

        if($nextDirection == 'W' && ($westValue == '-' || $westValue == 'L' || $westValue == 'F' || $westValue == 'S')){
            //dump('Going West');
            $y--;
            if($westValue == '-')
                $nextDirection = 'W';
            else if ($westValue == 'L')
                $nextDirection = 'N';
            else if ($westValue == 'F')
                $nextDirection = 'S';
        }
        else if($nextDirection == 'E' && ($eastValue == '-' || $eastValue == 'J' || $eastValue == '7' || $eastValue == 'S')){
            //dump('Going East');
            $y++;
            if($eastValue == '-')
                $nextDirection = 'E';
            else if ($eastValue == 'J')
                $nextDirection = 'N';
            else if ($eastValue == '7')
                $nextDirection = 'S';
        }
        else if($nextDirection == 'N' && ($northValue == '|' || $northValue == 'F' || $northValue == '7' || $northValue == 'S')){
            //dump('Going North');
            $x--;
            if($northValue == '|')
                $nextDirection = 'N';
            else if ($northValue == 'F')
                $nextDirection = 'E';
            else if ($northValue == '7')
                $nextDirection = 'W';
        }
        else if($nextDirection == 'S' && ($southValue == '|' || $southValue == 'J' || $southValue == 'L' || $southValue == 'S')){
            //dump('Going South');
            $x++;
            if($southValue == '|')
                $nextDirection = 'S';
            else if ($southValue == 'J')
                $nextDirection = 'W';
            else if ($southValue == 'L')
                $nextDirection = 'E';
        }
        else{
            dd("Invalid move\nNext Direction=" . $nextDirection . "\n");
        }
        return [$x, $y, $nextDirection];
    }

    public function part2(): int
    {
        $sum = 0;
        $start = $this->findStartingPoint();
        $x1 = $start[0];
        $y1 = $start[1];
        $nextDirection1 = 'N';
        $mapping = array();
        $mapping[$x1][$y1] = $sum;

        // find the two paths from the starting point
        $westValue = substr(explode("\n", $this->contents)[$x1], $y1 - 1, 1);
        $eastValue = substr(explode("\n", $this->contents)[$x1], $y1 + 1, 1);
        $northValue = substr(explode("\n", $this->contents)[$x1 - 1], $y1, 1);
        $southValue = substr(explode("\n", $this->contents)[$x1 + 1], $y1, 1);
        if($westValue == '-' || $westValue == 'L' || $westValue == 'F'){
            $y1--;
            if($westValue == '-')
                $nextDirection1 = 'W';
            else if ($westValue == 'L')
                $nextDirection1 = 'N';
            else if ($westValue == 'F')
                $nextDirection1 = 'S';
        }
        else if($eastValue == '-' || $eastValue == 'J' || $eastValue == '7'){
            $y1++;
            if($eastValue == '-')
                $nextDirection1 = 'E';
            else if ($eastValue == 'J')
                $nextDirection1 = 'N';
            else if ($eastValue == '7')
                $nextDirection1 = 'S';
        }
        else if($northValue == '|' || $northValue == 'F' || $northValue == '7'){
            $x1--;
            if($northValue == '|')
                $nextDirection1 = 'N';
            else if ($northValue == 'F')
                $nextDirection1 = 'E';
            else if ($northValue == '7')
                $nextDirection1 = 'W';
        }
        else if($southValue == '|' || $southValue == 'J' || $southValue == 'L'){
            $x1++;
            if($southValue == '|')
                $nextDirection1 = 'S';
            else if ($southValue == 'J')
                $nextDirection1 = 'W';
            else if ($southValue == 'L')
                $nextDirection1 = 'E';
        }

        $sum++;
        $mapping[$x1][$y1] = $sum;

        while($x1 != $start[0] || $y1 != $start[1]){
            if($sum % 1000 == 0){
                dump('Iterating ' . $sum);
            }
            $firstPath = $this->findNextCoordinate($x1, $y1, $nextDirection1);
            //dump($firstPath);

            $x1 = $firstPath[0];
            $y1 = $firstPath[1];
            $nextDirection1 = $firstPath[2];
            $mapping[$x1][$y1] = $sum;

            $sum++;
        }

        $insideLoop = 0;
        for($i = 0; $i < count(explode("\n", $this->contents)); $i++){
            $crosses = 0;
            $prevPipe = '-';
            for($j = 0; $j < strlen(explode("\n", $this->contents)[$i]); $j++) {
                if(array_key_exists($i, $mapping) && array_key_exists($j, $mapping[$i])) {
                    $pipe = substr(explode("\n", $this->contents)[$i], $j, 1);
                    //dump('Comparing pipe ' . $pipe . ' with previous Pipe ' . $prevPipe);
                    if($pipe == 'L'
                        || $pipe == '|'
                        || ($pipe == '7' && $prevPipe != 'F' && $prevPipe !='L')
                        || $pipe == 'F'
                        || ($pipe == 'J' && $prevPipe != 'L' && $prevPipe != 'F')){
                        $crosses++;
                    }
                    if(($pipe == '7' && ($prevPipe == 'F'))
                        || ($pipe == 'J' && ($prevPipe == 'L'))){
                        $crosses--;
                    }
                    if($pipe != '-' && $pipe != 'S') {
                        $prevPipe = $pipe;
                    }
                }else{
                    if($crosses % 2 == 1){
                        $insideLoop++;
                    }
                }
            }
        }

        return $insideLoop;
    }
}
