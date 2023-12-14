<?php

namespace App;

class Day12 extends DayBase
{
    public function part1(): int
    {
        $sum = 0;
        global $cachedValue;
        $cachedValue = array();

        foreach(explode("\n", $this->contents) as $line)
        {
            if(!empty($line))
            {
                $conditions = explode(' ', $line)[0];
                $record = explode(' ', $line)[1];
                $conditions = preg_replace('/\.+/', '.', $conditions);
                if(substr($conditions, 0, 1) == '.'){
                    $conditions = substr($conditions, 1);
                }
                if(substr($conditions, strlen($conditions) - 1, 1) == '.'){
                    $conditions = substr($conditions, 0, strlen($conditions) - 1);
                }

                $record = (explode(',', $record));

                $sum += $this->solveCached($conditions, $record);
            }
        }
        return $sum;
    }

    public function solveCached($springs, $groups){
        global $cachedValue;
        $groupsString = implode(',', $groups);
        if(array_key_exists($springs, $cachedValue) && array_key_exists($groupsString, $cachedValue[$springs])){
            return $cachedValue[$springs][$groupsString];
        }
        if(strlen($springs) == 0){
            if(count($groups) == 0){
                $cachedValue[$springs][$groupsString] = 1;
                return 1;
            }
            else {
                $cachedValue[$springs][$groupsString] = 0;
                return 0;
            }
        }
        $curr = substr($springs, 0,1);
        if($curr == '#'){
            if(count($groups) == 0 || strlen($springs) < $groups[0]){
                $cachedValue[$springs][$groupsString] = 0;
                return 0;
            }
            if(str_contains(substr($springs, 0, $groups[0]), '.')){
                $cachedValue[$springs][$groupsString] = 0;
                return 0;
            }
            if(substr(substr($springs, $groups[0]), 0, 1) == '#'){
                $cachedValue[$springs][$groupsString] = 0;
                return 0;
            }
            if(strlen($springs) > $groups[0]){
                if(substr($springs, $groups[0], 1) == '?'){
                    $newGroups = $groups;
                    array_shift($newGroups);
                    $result = $this->solveCached(ltrim(substr($springs, $groups[0] + 1), '.'), $newGroups);
                    $cachedValue[$springs][$groupsString] = $result;
                    return $result;
                }
            }
            $newGroups = $groups;
            array_shift($newGroups);
            $result = $this->solveCached(ltrim(substr($springs, $groups[0]), '.'), $newGroups);
            $cachedValue[$springs][$groupsString] = $result;
            return $result;
        }
        elseif($curr == '.'){
            $result = $this->solveCached(substr($springs, 1), $groups);
            $cachedValue[$springs][$groupsString] = $result;
            return $result;
        }
        elseif($curr == '?'){
            $result = $this->solveCached("#" . substr($springs, 1), $groups) + $this->solveCached("." . substr($springs, 1), $groups);
            $cachedValue[$springs][$groupsString] = $result;
            return $result;
        }
        else {
            $cachedValue[$springs][$groupsString] = 0;
            return 0;
        }
    }

    public function part2(): float
    {
        global $cachedValue;
        $cachedValue = array();
        ini_set('memory_limit', '512M');
        $sum = 0;
        foreach(explode("\n", $this->contents) as $line)
        {
            if(!empty($line))
            {
                $conditions = explode(' ', $line)[0];
                $record = explode(' ', $line)[1];

                $record = (explode(',', $record));

                $conditions = str_repeat('?' . $conditions, 5);

                $conditions = preg_replace('/\.+/', '.', $conditions);
                if(substr($conditions, 0, 1) == '.'){
                    $conditions = substr($conditions, 1);
                }
                if(substr($conditions, strlen($conditions) - 1, 1) == '.'){
                    $conditions = substr($conditions, 0, strlen($conditions) - 1);
                }

                $copyRecord = $record;
                for($i = 0; $i < 4; $i++){
                    $record = array_merge($record, $copyRecord);
                }

                $result = $this->solveCached(substr($conditions, 1), $record);

                $sum += $result;
            }
        }
        dump(sprintf('%20.0F', $sum));
        return $sum;
    }
}
