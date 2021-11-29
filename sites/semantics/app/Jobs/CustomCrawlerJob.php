<?php

namespace App\Jobs;

use App\Models\Job;
use App\Models\Url;
use Illuminate\Bus\Queueable;
use App\Custom\Syntex\MakeDecFile;
use Illuminate\Support\Facades\Log;
use App\Custom\Syntex\SyntexWrapper;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use League\Csv\Reader;


class CustomCrawlerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $params;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $this->uuid = $this->job->getJobId();
        Log::debug('Uuid: ' . $this->uuid);

        $job = Job::create(['uuid' => $this->uuid, 'name' => ucFirst($this->params['filename']), 'user_id' => 1, 'type_id' => 4, 'status_id' => 2, 'percentage' => 5, 'message' => 'Initialisation du traitement']);

        $csv = Reader::createFromPath($this->params['filepath'], 'r');
        $csv->setDelimiter($this->params['separtor']);
        $csv->setHeaderOffset(0);


        $headerList = $csv->getHeader();
        $mustHeaders = ['id', 'title', 'content'];

        $errors = [];
        foreach($mustHeaders as $mustHeader) {
            if (!in_array($mustHeader, $headerList)) {
                    $errors[] = $mustHeader;
            }
        }

        if (!empty($errors)) {
           
        }

        foreach ($csv->getRecords() as $record) {
            Url::firstOrCreate([
                'uuid' => $this->uuid,
                'url' => $record['id']
            ], [
                'title' => $record['title'],
                'content' => $record['content'],
            ]);
        }

        (new MakeDecFile($this->uuid))->run();
        (new SyntexWrapper($this->uuid))->run();
        
        Job::insertUpdate(['uuid' => $this->uuid, 'percentage' => 100, 'status_id' => 3, 'message' => 'Traitement terminé']);
    }


}
