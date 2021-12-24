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

        $job = Job::create(['uuid' => $this->uuid, 'name' => ucFirst($this->params['filename']), 'user_id' => $this->params['userId'], 'type_id' => 4, 'status_id' => 2, 'percentage' => 5, 'message' => 'Initialisation du traitement']);

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

        Job::where('uuid', $this->uuid)->update(['percentage' => 60, 'message' => 'Analyse linguistique en cours']);
        Log::debug('MakeDecFile');
        try {
            (new MakeDecFile($this->uuid))->run();
        } catch(\Exception $e) {
            Log::debug($e->getMessage());
            Job::insertUpdate(['uuid' => $this->uuid, 'percentage' => 100, 'status_id' => 4, 'message' => $e->getMessage()]);
            return false;
        }
        Job::where('uuid', $this->uuid)->update(['percentage' => 80, 'message' => 'Consolidation des données']);

        Log::debug('SyntexWrapper');
        try {
            (new SyntexWrapper($this->uuid))->run();

        } catch(\Exception $e) {
            Log::debug($e->getMessage());
            Job::insertUpdate(['uuid' => $this->uuid, 'percentage' => 100, 'status_id' => 4, 'message' => 'Erreur lors de l\'analyse des données']);
            return false;
        }
        Job::insertUpdate(['uuid' => $this->uuid, 'percentage' => 100, 'status_id' => 3, 'message' => 'Traitement terminé']);
    }


}
