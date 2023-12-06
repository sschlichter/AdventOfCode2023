<?php

namespace App;

class Day5 extends DayBase
{
    public function part1(): int
    {
        $answer = -1;
        $seeds = array();
        $locations = array();
        $seedToSoil = array();
        $soilToFert = array();
        $fertToWater = array();
        $waterToLight = array();
        $lightToTemp = array();
        $tempToHum = array();
        $humToLoc = array();
        $lines = explode("\n", $this->contents);
        // set up all the arrays
        for($i = 0; $i < count($lines); $i++)
        {
            if(preg_match('/^seeds:/', $lines[$i])){
                $seeds = explode(' ', trim(explode(':', $lines[$i])[1]));
            }
            else if(preg_match('/^seed-to-soil map:/', $lines[$i])){
                $i++;
                while(preg_match('/map:/', $lines[$i]) == false && empty($lines[$i]) == false){
                    $this->fillArray($seedToSoil, $lines[$i]);
                    $i++;
                }
                ksort($seedToSoil);
            }
            else if(preg_match('/^soil-to-fertilizer map:/', $lines[$i])){
                $i++;
                while(preg_match('/map:/', $lines[$i]) == false && empty($lines[$i]) == false){
                    $this->fillArray($soilToFert, $lines[$i]);
                    $i++;
                }
                ksort($soilToFert);
            }
            else if(preg_match('/^fertilizer-to-water map:/', $lines[$i])){
                $i++;
                while(preg_match('/map:/', $lines[$i]) == false && empty($lines[$i]) == false){
                    $this->fillArray($fertToWater, $lines[$i]);
                    $i++;
                }
                ksort($fertToWater);
            }
            else if(preg_match('/^water-to-light map:/', $lines[$i])){
                $i++;
                while(preg_match('/map:/', $lines[$i]) == false && empty($lines[$i]) == false){
                    $this->fillArray($waterToLight, $lines[$i]);
                    $i++;
                }
                ksort($waterToLight);
            }
            else if(preg_match('/^light-to-temperature map:/', $lines[$i])){
                $i++;
                while(preg_match('/map:/', $lines[$i]) == false && empty($lines[$i]) == false){
                    $this->fillArray($lightToTemp, $lines[$i]);
                    $i++;
                }
                ksort($lightToTemp);
            }
            else if(preg_match('/^temperature-to-humidity map:/', $lines[$i])){
                $i++;
                while(preg_match('/map:/', $lines[$i]) == false && empty($lines[$i]) == false){
                    $this->fillArray($tempToHum, $lines[$i]);
                    $i++;
                }
                ksort($tempToHum);
            }
            else if(preg_match('/^humidity-to-location map:/', $lines[$i])){
                $i++;
                while(preg_match('/map:/', $lines[$i]) == false && empty($lines[$i]) == false){
                    $this->fillArray($humToLoc, $lines[$i]);
                    $i++;
                }
                ksort($humToLoc);
            }
        }

        foreach($seeds as $seed)
        {
            if(empty($seed)){
                continue;
            }
            $soil = $this->getDestination($seedToSoil, $seed);
            $fert = $this->getDestination($soilToFert, $soil);
            $water = $this->getDestination($fertToWater, $fert);
            $light = $this->getDestination($waterToLight, $water);
            $temp = $this->getDestination($lightToTemp, $light);
            $hum = $this->getDestination($tempToHum, $temp);
            $loc = $this->getDestination($humToLoc, $hum);
            $locations[] = $loc;
        }
        sort($locations);
        $answer = $locations[0];
        return $answer;
    }

    public function part2(): int
    {
        $answer = -1;
        $seeds = array();
        $locations = array();
        $seedToSoil = array();
        $soilToFert = array();
        $fertToWater = array();
        $waterToLight = array();
        $lightToTemp = array();
        $tempToHum = array();
        $humToLoc = array();
        $lines = explode("\n", $this->contents);
        // set up all the arrays
        for($i = 0; $i < count($lines); $i++)
        {
            if(preg_match('/^seeds:/', $lines[$i])){
                $seeds = explode(' ', trim(explode(':', $lines[$i])[1]));
            }
            else if(preg_match('/^seed-to-soil map:/', $lines[$i])){
                $i++;
                while(preg_match('/map:/', $lines[$i]) == false && empty($lines[$i]) == false){
                    $this->fillArray($seedToSoil, $lines[$i]);
                    $i++;
                }
                ksort($seedToSoil);
            }
            else if(preg_match('/^soil-to-fertilizer map:/', $lines[$i])){
                $i++;
                while(preg_match('/map:/', $lines[$i]) == false && empty($lines[$i]) == false){
                    $this->fillArray($soilToFert, $lines[$i]);
                    $i++;
                }
                ksort($soilToFert);
            }
            else if(preg_match('/^fertilizer-to-water map:/', $lines[$i])){
                $i++;
                while(preg_match('/map:/', $lines[$i]) == false && empty($lines[$i]) == false){
                    $this->fillArray($fertToWater, $lines[$i]);
                    $i++;
                }
                ksort($fertToWater);
            }
            else if(preg_match('/^water-to-light map:/', $lines[$i])){
                $i++;
                while(preg_match('/map:/', $lines[$i]) == false && empty($lines[$i]) == false){
                    $this->fillArray($waterToLight, $lines[$i]);
                    $i++;
                }
                ksort($waterToLight);
            }
            else if(preg_match('/^light-to-temperature map:/', $lines[$i])){
                $i++;
                while(preg_match('/map:/', $lines[$i]) == false && empty($lines[$i]) == false){
                    $this->fillArray($lightToTemp, $lines[$i]);
                    $i++;
                }
                ksort($lightToTemp);
            }
            else if(preg_match('/^temperature-to-humidity map:/', $lines[$i])){
                $i++;
                while(preg_match('/map:/', $lines[$i]) == false && empty($lines[$i]) == false){
                    $this->fillArray($tempToHum, $lines[$i]);
                    $i++;
                }
                ksort($tempToHum);
            }
            else if(preg_match('/^humidity-to-location map:/', $lines[$i])){
                $i++;
                while(preg_match('/map:/', $lines[$i]) == false && empty($lines[$i]) == false){
                    $this->fillArray($humToLoc, $lines[$i]);
                    $i++;
                }
                ksort($humToLoc);
            }
        }

        $maxLocation = 0;
        $minLocation = 0;
        foreach($humToLoc as $x)
        {
            if($x->destination + $x->length > $maxLocation)
            {
                $maxLocation = $x->destination + $x->length;
            }
            if(key($x) < $minLocation || $minLocation == -1)
            {
                $minLocation = key($x);
            }
            if($x->destination < $minLocation || $minLocation == -1)
            {
                $minLocation = $x->destination;
            }
        }
        $minLocation = 0;
        for($i = $minLocation; $i < $maxLocation; $i++)
        {
            if($i % 100000 == 0)
            {
                dump('iterating at ' . $i);
            }
            $seed = $this->getSource($humToLoc, $i);
            $seed = $this->getSource($tempToHum, $seed);
            $seed = $this->getSource($lightToTemp, $seed);
            $seed = $this->getSource($waterToLight, $seed);
            $seed = $this->getSource($fertToWater, $seed);
            $seed = $this->getSource($soilToFert, $seed);
            $seed = $this->getSource($seedToSoil, $seed);
            for($x = 0; $x < count($seeds); $x+=2)
            {
                if($seed >= $seeds[$x] && $seed < $seeds[$x] + $seeds[$x+1]){
                    dump($seeds[$x] . ' ' . $seeds[$x] + $seeds[$x+1]);
                    return $i;
                }
            }
        }
        return $answer;
    }

    public function fillArray(& $array, $line)
    {
        $vals = explode(' ', $line);
        $dest = $vals[0];
        $source = $vals[1];
        $len = intval($vals[2]);
        $map = new Mapper();
        $map->destination = $dest;
        $map->length = $len;
        $array[$source] = $map;
    }

    public function getDestination($array, $source)
    {
        $dest = $source;
        foreach($array as $key => $val)
        {
            if(intval($source) >= intval($key) && intval($source) < intval($key) + intval($val->length))
            {
                $diff = intval($source) - intval($key);
                $dest = intval($val->destination) + $diff;
                break;
            }
        }
        return $dest;
    }

    public function getSource($array, $destination)
    {
        //dump('Destination ' . $destination);
        $source = $destination;
        foreach($array as $key => $val)
        {
            if(intval($source) >= intval($val->destination) && intval($source) < intval($val->destination) + intval($val->length))
            {
                $diff = intval($source) - intval($val->destination);
                $source = intval($key) + $diff;
                //dump('Key ' . $key);
                //dump('Source ' . $source);
                break;
            }
        }
        return $source;
    }
}

class Mapper
{
    public $prev;
    public $next;
    public $length;
    public $destination;
}


