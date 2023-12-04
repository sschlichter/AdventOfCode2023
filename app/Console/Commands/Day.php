<?php

namespace App\Console\Commands;

use App\DayController;
use App\Day1;
use App\Day2;
use App\Day3;
use App\Day4;
use App\Day5;
use App\Day6;
use App\Day7;
use App\Day8;
use App\Day9;
use App\Day10;
use App\Day11;
use App\Day12;
use App\Day13;
use App\Day14;
use App\Day15;
use App\Day16;
use App\Day17;
use App\Day18;
use App\Day19;
use App\Day20;
use App\Day21;
use App\Day22;
use App\Day23;
use App\Day24;
use App\Day25;
use Illuminate\Console\Command;

class Day extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'day {dayNum} {partNum}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to run Advent of Code puzzles. Give the day number as an argument to run the command for that particular day.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dayNum = $this->argument('dayNum');
        if($dayNum < 1 || $dayNum > 25)
        {
            $this->error("Invalid Day Number (should be 1-25)");
            return;
        }
        $partNum = $this->argument('partNum');
        $this->info("Running command for Day " . $dayNum . " Part " . $partNum);

        $class = "App\Day" . $dayNum;
        $test = new $class($dayNum);
        switch($partNum)
        {
            case 1:
                $test->part1Answer();
                break;
            case 2:
                $test->part2Answer();
                break;
            default:
                $this->error("Invalid Part Number (should be 1 or 2)");
        }
    }
}
