<?php

namespace App;

class Day8 extends DayBase
{
    public function part1(): int
    {
        $sum = 0;
        $lines = explode("\n", $this->contents);
        $directions = str_split(array_shift($lines));
        $mapping = array();
        foreach($lines as $line)
        {
            if(!empty($line))
            {
                $start = str_split(explode(' = ', $line)[0]);
                $left = ltrim(explode(', ', explode(' = ', $line)[1])[0], '(');
                $right = rtrim(explode(', ', explode(' = ', $line)[1])[1], ')');

                $node = new Node();
                $node->left = $left;
                $node->right = $right;

                $mapping[$start[0]][$start[1]][$start[2]] = $node;
            }
        }
        $current = 'AAA';
        while($current != 'ZZZ'){
            $sum++;
            $nextDirection = array_shift($directions);
            $directions[] = $nextDirection;
            $key = str_split($current)[0];
            $key2= str_split($current)[1];
            $key3 = str_split($current)[2];

            if($nextDirection == 'L'){
                $current = $mapping[$key][$key2][$key3]->left;
            }
            else{
                $current = $mapping[$key][$key2][$key3]->right;
            }
        }
        return $sum;
    }

    public function part2(): int
    {
        $sum = 0;
        $lines = explode("\n", $this->contents);
        $directions = str_split(array_shift($lines));
        $mapping = array();
        $currentNodes = array();
        foreach($lines as $line)
        {
            if(!empty($line))
            {
                $start = str_split(explode(' = ', $line)[0]);
                $left = ltrim(explode(', ', explode(' = ', $line)[1])[0], '(');
                $right = rtrim(explode(', ', explode(' = ', $line)[1])[1], ')');

                $node = new Node();
                $node->left = $left;
                $node->right = $right;

                $mapping[$start[0]][$start[1]][$start[2]] = $node;
                if($start[2] == 'A'){
                    $currentNodes[implode($start)] = array(implode($start), 0);
                }
            }
        }

        $done = false;
        while($done === false){
            $nextDirection = array_shift($directions);
            $directions[] = $nextDirection;
            $done = true;
            foreach($currentNodes as $key=>$current) {

                $key1 = str_split($current[0])[0];
                $key2 = str_split($current[0])[1];
                $key3 = str_split($current[0])[2];
                if($key3 == 'Z'){
                    continue;
                }

                if ($nextDirection == 'L') {
                    $current[0] = $mapping[$key1][$key2][$key3]->left;
                } else {
                    $current[0] = $mapping[$key1][$key2][$key3]->right;
                }
                if(str_split($current[0])[2] != 'Z'){
                    $done = false;
                }
                $current[1]++;
                $currentNodes[$key] = $current;
            }
        }
        $sum = 1;
        foreach($currentNodes as $current){
            $sum = $this->getLCM($sum, $current[1]);
        }

        return $sum;
    }

    public function getLCM($x, $y){
        if ($x > $y) {
            $temp = $x;
            $x = $y;
            $y = $temp;
        }

        for($i = 1; $i < ($x+1); $i++) {
            if ($x%$i == 0 && $y%$i == 0)
                $gcd = $i;
        }

        return ($x*$y)/$gcd;
    }
}

class Node
{
    public $left;
    public $right;
}
