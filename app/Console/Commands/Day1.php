<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use NumberFormatter;

class Day1 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:day1';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $contents = Storage::get('Day1Input.txt');
        $sum = 0;
        foreach(explode("\n", $contents) as $line){
            preg_match_all('/\d/', $line, $matches);
            $result = reset($matches[0]) . end($matches[0]);
            $sum += intval($result);
        }
        $this->info('Day 1 part 1: sum of all calibration values = ' . $sum);

        $sum = 0;
        foreach(explode("\n", $contents) as $line){
            preg_match_all('/(?=(one|two|three|four|five|six|seven|eight|nine|\d))/', $line, $matches);
            $format = numfmt_create('en_US', NumberFormatter::SPELLOUT);
            $result = numfmt_parse($format, reset($matches[1])) . numfmt_parse($format, end($matches[1]));
            $sum += intval($result);
        }
        $this->info('Day 1 part 2: sum of all calibration values = ' . $sum);
    }
}
