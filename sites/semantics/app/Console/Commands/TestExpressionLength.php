<?php

namespace App\Console\Commands;

use League\Csv\Reader;
use Illuminate\Support\Str;
use App\Custom\AntonymeCrawler;
use App\Custom\Tools\StopWords;
use App\Models\Antonym;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class TestExpressionLength extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:test-length';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $expressions = [
            'moment de l'
        ];

        $res = [];
        foreach($expressions as $lemme) {

            $res = [
                'lemme' => $lemme,
                'longeueurNow' => preg_match_all('/\pL+/u',$lemme, $matches),
                'longueur' => $this->lemmeLength($lemme)
            ];

        }

        dd($res);


        return Command::SUCCESS;
    }

    private function lemmeLength($lemme)
    {
        $items = explode(' ', $lemme);
        $list = [];
        foreach($items as $item)
        {
            if (StopWords::isStopWord($item)) {
                continue;
            }
            $list[] = $item;
        }
        $lemme = implode(' ', $list);

        return preg_match_all('/\pL+/u',$lemme, $matches);
    }


}
