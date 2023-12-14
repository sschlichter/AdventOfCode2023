<?php

namespace App;

class Day7 extends DayBase
{
    function sortCards($a, $b)
    {
        $a = preg_replace('/J/', '0', $a);
        $b = preg_replace('/J/', '0', $b);
        return strcmp($b, $a);
    }

    function compareCards($a, $b)
    {
        $a = preg_replace('/A/', 'E', $a);
        $a = preg_replace('/K/', 'D', $a);
        $a = preg_replace('/Q/', 'C', $a);
        $a = preg_replace('/J/', '0', $a);
        $a = preg_replace('/T/', 'A', $a);

        $b = preg_replace('/A/', 'E', $b);
        $b = preg_replace('/K/', 'D', $b);
        $b = preg_replace('/Q/', 'C', $b);
        $b = preg_replace('/J/', '0', $b);
        $b = preg_replace('/T/', 'A', $b);

        for($i = 0; $i < strlen($a); $i++){
            if($a[$i] == $b[$i]){
                continue;
            }
            return strcmp($b[$i], $a[$i]);
        }
        return 0;
    }

    public function part1(): int
    {
        $sum = 0;
        $highCards = array();
        $onePairs = array();
        $twoPairs = array();
        $threeKinds = array();
        $fullHouses = array();
        $fourKinds = array();
        $fiveKinds = array();
        foreach(explode("\n", $this->contents) as $line)
        {
            if(!empty($line))
            {
                $hand = explode(' ', $line)[0];
                $bid = explode(' ', $line)[1];
                $handArr = str_split($hand);
                sort($handArr);
                if($handArr[0] === $handArr[4]){
                    $fiveKinds[$hand] = $bid;
                }
                else if($handArr[0] === $handArr[3] || $handArr[1] === $handArr[4]){
                    $fourKinds[$hand] = $bid;
                }
                else if(($handArr[0] === $handArr[1] && $handArr[2] === $handArr[4])
                || ($handArr[0] === $handArr[2] && $handArr[3] === $handArr[4])){
                    $fullHouses[$hand] = $bid;
                }
                else if($handArr[0] === $handArr[2] || $handArr[1] === $handArr[3] || $handArr[2] === $handArr[4]){
                    $threeKinds[$hand] = $bid;
                }
                else if(($handArr[0] === $handArr[1] && ($handArr[2] === $handArr[3] || $handArr[3] === $handArr[4]))
                || ($handArr[1] === $handArr[2] && $handArr[3] === $handArr[4])){
                    $twoPairs[$hand] = $bid;
                }
                else if ($handArr[0] === $handArr[1] || $handArr[1] === $handArr[2] || $handArr[2] === $handArr[3]
                || $handArr[3] === $handArr[4]){
                    $onePairs[$hand] = $bid;
                }
                else{
                    $highCards[$hand] = $bid;
                }
            }
        }

        $highRank = count($highCards) + count($onePairs) + count($twoPairs) + count($threeKinds) + count($fullHouses) + count($fourKinds) + count($fiveKinds);
        uksort($fiveKinds, array($this, 'compareCards'));
        uksort($fourKinds, array($this, 'compareCards'));
        uksort($fullHouses, array($this, 'compareCards'));
        uksort($threeKinds, array($this, 'compareCards'));
        uksort($twoPairs, array($this, 'compareCards'));
        uksort($onePairs, array($this, 'compareCards'));
        uksort($highCards, array($this, 'compareCards'));

        foreach($fiveKinds as $key=>$val){
            dump('Rank ' . $highRank . '=' . $key );
            $sum += ($val * $highRank);
            $highRank--;
        }
        foreach($fourKinds as $key=>$val){
            dump('Rank ' . $highRank . '=' . $key );
            $sum += ($val * $highRank);
            $highRank--;
        }
        foreach($fullHouses as $key=>$val){
            dump('Rank ' . $highRank . '=' . $key );
            $sum += ($val * $highRank);
            $highRank--;
        }
        foreach($threeKinds as $key=>$val){
            dump('Rank ' . $highRank . '=' . $key );
            $sum += ($val * $highRank);
            $highRank--;
        }
        foreach($twoPairs as $key=>$val){
            dump('Rank ' . $highRank . '=' . $key );
            $sum += ($val * $highRank);
            $highRank--;
        }
        foreach($onePairs as $key=>$val){
            dump('Rank ' . $highRank . '=' . $key );
            $sum += ($val * $highRank);
            $highRank--;
        }
        foreach($highCards as $key=>$val){
            dump('Rank ' . $highRank . '=' . $key );
            $sum += ($val * $highRank);
            $highRank--;
        }

        return $sum;
    }

    public function part2(): int
    {
        $sum = 0;
        $highCards = array();
        $onePairs = array();
        $twoPairs = array();
        $threeKinds = array();
        $fullHouses = array();
        $fourKinds = array();
        $fiveKinds = array();
        foreach(explode("\n", $this->contents) as $line)
        {
            if(!empty($line))
            {
                $hand = explode(' ', $line)[0];
                $bid = explode(' ', $line)[1];
                $handArr = str_split($hand);
                $values = array_count_values($handArr);
                arsort($values);
                $popular = array_slice(array_keys($values), 0, 2, true);
                $handArr = array_replace($handArr,
                    array_fill_keys(
                        array_keys($handArr, 'J'),
                        $popular[0] == 'J' && count($popular) > 1? strval($popular[1]):strval($popular[0])
                    )
                );
                usort($handArr, array($this, 'sortCards'));
                if($handArr[0] === $handArr[4]){
                    $fiveKinds[$hand] = $bid;
                }
                else if($handArr[0] === $handArr[3] || $handArr[1] === $handArr[4]){
                    $fourKinds[$hand] = $bid;
                }
                else if(($handArr[0] === $handArr[1] && $handArr[2] === $handArr[4])
                    || ($handArr[0] === $handArr[2] && $handArr[3] === $handArr[4])){
                    $fullHouses[$hand] = $bid;
                }
                else if($handArr[0] === $handArr[2] || $handArr[1] === $handArr[3] || $handArr[2] === $handArr[4]){
                    $threeKinds[$hand] = $bid;
                }
                else if(($handArr[0] === $handArr[1] && ($handArr[2] === $handArr[3] || $handArr[3] === $handArr[4]))
                    || ($handArr[1] === $handArr[2] && $handArr[3] === $handArr[4])){
                    $twoPairs[$hand] = $bid;
                }
                else if ($handArr[0] === $handArr[1] || $handArr[1] === $handArr[2] || $handArr[2] === $handArr[3]
                    || $handArr[3] === $handArr[4]){
                    $onePairs[$hand] = $bid;
                }
                else{
                    $highCards[$hand] = $bid;
                }
            }
        }

        $highRank = count($highCards) + count($onePairs) + count($twoPairs) + count($threeKinds) + count($fullHouses) + count($fourKinds) + count($fiveKinds);
        uksort($fiveKinds, array($this, 'compareCards'));
        uksort($fourKinds, array($this, 'compareCards'));
        uksort($fullHouses, array($this, 'compareCards'));
        uksort($threeKinds, array($this, 'compareCards'));
        uksort($twoPairs, array($this, 'compareCards'));
        uksort($onePairs, array($this, 'compareCards'));
        uksort($highCards, array($this, 'compareCards'));

        dump('Five of a kind:');
        foreach($fiveKinds as $key=>$val){
            dump('Rank ' . $highRank . '=' . $key );
            $sum += ($val * $highRank);
            $highRank--;
        }
        dump('Four of a kind:');
        foreach($fourKinds as $key=>$val){
            dump('Rank ' . $highRank . '=' . $key );
            $sum += ($val * $highRank);
            $highRank--;
        }
        dump('Full House:');
        foreach($fullHouses as $key=>$val){
            dump('Rank ' . $highRank . '=' . $key );
            $sum += ($val * $highRank);
            $highRank--;
        }
        dump('Three of a kind:');
        foreach($threeKinds as $key=>$val){
            dump('Rank ' . $highRank . '=' . $key );
            $sum += ($val * $highRank);
            $highRank--;
        }
        dump('Two Pairs:');
        foreach($twoPairs as $key=>$val){
            dump('Rank ' . $highRank . '=' . $key );
            $sum += ($val * $highRank);
            $highRank--;
        }
        dump('One Pair:');
        foreach($onePairs as $key=>$val){
            dump('Rank ' . $highRank . '=' . $key );
            $sum += ($val * $highRank);
            $highRank--;
        }
        dump('High Card:');
        foreach($highCards as $key=>$val){
            dump('Rank ' . $highRank . '=' . $key );
            $sum += ($val * $highRank);
            $highRank--;
        }

        return $sum;
    }
}
