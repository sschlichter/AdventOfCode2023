<?php

namespace App;

use NumberFormatter;

class Day1 extends DayBase
{
    public function part1(): int
    {
        $sum = 0;
        foreach(explode("\n", $this->contents) as $line)
        {
            preg_match_all('/\d/', $line, $matches);
            $result = reset($matches[0]) . end($matches[0]);
            $sum += intval($result);
        }
        return $sum;
    }

    public function part2(): int
    {
        $sum = 0;
        foreach(explode("\n", $this->contents) as $line)
        {
            preg_match_all('/(?=(one|two|three|four|five|six|seven|eight|nine|\d))/', $line, $matches);
            $format = numfmt_create('en_US', NumberFormatter::SPELLOUT);
            $result = numfmt_parse($format, reset($matches[1])) . numfmt_parse($format, end($matches[1]));
            $sum += intval($result);
        }
        return $sum;
    }
}
