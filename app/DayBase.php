<?php

namespace App;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

abstract class DayBase
{
    public string $contents;

    public function __construct(int $day){
        $inputFile = 'Day' . $day . 'Input.txt';
        $this->contents = Storage::get($inputFile);
    }

    public function part1Answer(){
        Log::info("Part 1 Answer: " . $this->part1());
    }

    public function part2Answer(){
        Log::info("Part 2 Answer: " . $this->part2());
    }

    abstract public function part1():mixed;
    abstract public function part2():mixed;
}
