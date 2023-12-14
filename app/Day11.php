<?php

namespace App;

class Day11 extends DayBase
{
    public function part1(): int
    {
        $sum = 0;
        $galaxies = array();
        for($i = 0; $i < count(explode("\n", $this->contents)); $i++)
        {
            $line = explode("\n", $this->contents)[$i];
            for($j = 0; $j < count(str_split($line)); $j++)
            {
                $space = str_split($line)[$j];
                if($space == '#')
                {
                    $galaxies[$i][$j] = $sum;
                    $sum++;
                }
            }
        }

        //dump($galaxies);
        $rowIncrement = 0;
        $columnIncrement = 0;
        $fileLength = count(explode("\n", $this->contents));
        $lineLength = strlen(explode("\n", $this->contents)[0]);

        $valueAdjusted = array();

        for($i = 0; $i < $fileLength; $i++) {
            if (array_key_exists($i, $galaxies) == false) {
                $rowIncrement++;
            }
        }
        for($i = $fileLength - 1; $i >= 0; $i--){
            if(array_key_exists($i, $galaxies)){
                for($j = 0; $j < $lineLength; $j++){
                    if(array_key_exists($j, $galaxies[$i]) && in_array($galaxies[$i][$j], $valueAdjusted) == false){
                        $value = $galaxies[$i][$j];
                        unset($galaxies[$i][$j]);
                        $galaxies[$i + $rowIncrement][$j] = $value;
                        $valueAdjusted[] = $value;
                    }
                }
            }
            else{
                $rowIncrement--;
            }
        }
        for($i = 0; $i < count($galaxies); $i++){
            if(array_key_exists($i, $galaxies) && count($galaxies[$i]) == 0){
                unset($galaxies[$i]);
            }
        }
        $flippedGalaxies = $this->flipDiagonally($galaxies);
        //dump($flippedGalaxies);
        $valueAdjusted = array();
        for($i = 0; $i < $lineLength; $i++) {
            if (array_key_exists($i, $flippedGalaxies) == false) {
                $columnIncrement++;
            }
        }
        for($i = $lineLength; $i >= 0; $i--){
            if(array_key_exists($i, $flippedGalaxies)){
                for($j=0; $j < $fileLength * 2; $j++){
                    if(array_key_exists($j, $flippedGalaxies[$i]) && in_array($flippedGalaxies[$i][$j], $valueAdjusted) == false){
                        $value = $flippedGalaxies[$i][$j];
                        unset($flippedGalaxies[$i][$j]);
                        $flippedGalaxies[$i + $columnIncrement][$j] = $value;
                        $valueAdjusted[] = $value;
                    }
                }
            }
            else{
                $columnIncrement--;
            }
        }
        $galaxies = $this->flipDiagonally($flippedGalaxies);
        for($i = 0; $i < count($galaxies); $i++){
            if(array_key_exists($i, $galaxies) && count($galaxies[$i]) == 0){
                unset($galaxies[$i]);
            }
        }

        $shortestPath = 0;
        foreach($galaxies as $key1=>$galaxyRow){
            foreach($galaxyRow as $key2=>$galaxy){
                foreach($galaxies as $compareX=>$compareGalaxyRow){
                    foreach($compareGalaxyRow as $compareY=>$compareGalaxy) {
                        if ($galaxy < $compareGalaxy) {
//                            dump('Comparing ' . $galaxy . ' and ' . $compareGalaxy);
//                            dump($key1 . ' ' . $compareX);
//                            dump($key2 . ' ' . $compareY);
//                            dump('Length = ' . (abs($key1 - $compareX) + abs($key2 - $compareY)));
                            $shortestPath += (abs($key1 - $compareX) + abs($key2 - $compareY));
                        }
                    }
                }
            }
        }

        return $shortestPath;
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
        $increment = 999999;
        $galaxies = array();
        for($i = 0; $i < count(explode("\n", $this->contents)); $i++)
        {
            $line = explode("\n", $this->contents)[$i];
            for($j = 0; $j < count(str_split($line)); $j++)
            {
                $space = str_split($line)[$j];
                if($space == '#')
                {
                    $galaxies[$i][$j] = $sum;
                    $sum++;
                }
            }
        }

        //dump($galaxies);
        $rowIncrement = 0;
        $columnIncrement = 0;

        $valueAdjusted = array();

        for($i = 0; $i <= max(array_keys($galaxies)); $i++) {
            if (array_key_exists($i, $galaxies) == false) {
                $rowIncrement+=$increment;
            }
        }
        $flippedGalaxies = $this->flipDiagonally($galaxies);
        $maxLines = max(array_keys($flippedGalaxies));
        for($i = 0; $i <= $maxLines; $i++) {
            if (array_key_exists($i, $flippedGalaxies) == false) {
                $columnIncrement+=$increment;
            }
        }
        dump("finishing finding blank lines");
        //dump($rowIncrement);
        $maxLines = max(array_keys($galaxies));
        for($i = $maxLines; $i >= 0; $i--){
            if(array_key_exists($i, $galaxies)){
                $lineLength = max(array_keys($galaxies[$i]));
                for($j = 0; $j <= $lineLength; $j++){
                    if(array_key_exists($j, $galaxies[$i]) && in_array($galaxies[$i][$j], $valueAdjusted) == false){
                        $value = $galaxies[$i][$j];
                        unset($galaxies[$i][$j]);
                        $galaxies[$i + $rowIncrement][$j] = $value;
                        $valueAdjusted[] = $value;
                        //dump('Adjusted Galaxy ' . $value . ' from ' . $i . ' ' . $j . ' to ' . $i + $rowIncrement . ' ' . $j);
                    }
                }
            }
            else{
                //dump('Row ' . $i . ' doesnt have a glaxaxy, new row increment = ' . $rowIncrement);
                $rowIncrement-=$increment;
            }
        }
        dump("Finished shifting horizontally");
        $maxLines = max(array_keys($galaxies));
        for($i = 0; $i <= $maxLines; $i++){
            if(array_key_exists($i, $galaxies) && count($galaxies[$i]) == 0){
                unset($galaxies[$i]);
            }
        }
        $flippedGalaxies = $this->flipDiagonally($galaxies);
        //dump($flippedGalaxies);
        $valueAdjusted = array();
        $maxLines = max(array_keys($flippedGalaxies));
        for($i = $maxLines; $i >= 0; $i--){
            if(array_key_exists($i, $flippedGalaxies)){
                $lineLength = max(array_keys($flippedGalaxies[$i]));
                for($j=0; $j <= $lineLength; $j++){
                    if(array_key_exists($j, $flippedGalaxies[$i]) && in_array($flippedGalaxies[$i][$j], $valueAdjusted) == false){
                        $value = $flippedGalaxies[$i][$j];
                        unset($flippedGalaxies[$i][$j]);
                        $flippedGalaxies[$i + $columnIncrement][$j] = $value;
                        $valueAdjusted[] = $value;
                    }
                }
            }
            else{
                $columnIncrement-=$increment;
            }
        }
        dump("Finsihed shifting vertically");
        $galaxies = $this->flipDiagonally($flippedGalaxies);
        $maxLines = max(array_keys($galaxies));
        for($i = 0; $i <= $maxLines; $i++){
            if(array_key_exists($i, $galaxies) && count($galaxies[$i]) == 0){
                unset($galaxies[$i]);
            }
        }
        //dump($galaxies);

        dump("calculating shortest path");
        $shortestPath = 0;
        foreach($galaxies as $key1=>$galaxyRow){
            foreach($galaxyRow as $key2=>$galaxy){
                foreach($galaxies as $compareX=>$compareGalaxyRow){
                    foreach($compareGalaxyRow as $compareY=>$compareGalaxy) {
                        if ($galaxy < $compareGalaxy) {
//                            dump('Comparing ' . $galaxy . ' and ' . $compareGalaxy);
//                            dump($key1 . ' ' . $compareX);
//                            dump($key2 . ' ' . $compareY);
//                            dump('Length = ' . (abs($key1 - $compareX) + abs($key2 - $compareY)));
                            $shortestPath += (abs($key1 - $compareX) + abs($key2 - $compareY));
                        }
                    }
                }
            }
        }

        return $shortestPath;
    }
}
