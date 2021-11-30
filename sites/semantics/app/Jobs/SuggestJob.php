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


class SuggestJob implements ShouldQueue
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

        $job = Job::create(['uuid' => $this->uuid, 'name' => ucFirst($this->params['keyword']), 'user_id' => 1, 'type_id' => 5, 'status_id' => 2, 'percentage' => 5, 'message' => 'Initialisation du traitement']);

        $suggest = new \App\Custom\Search\Suggest($this->params['keyword']);
        $suggest->run();
        $contentHtml = $suggest->toHtmlContent();

        Url::firstOrCreate([
            'uuid' => $this->uuid,
            'url' => (string)$contentHtml['url']
        ], [
            'title' => $contentHtml['title'],
            'content' => $contentHtml['content'],
        ]);

        (new MakeDecFile($this->uuid))->run();
        (new SyntexWrapper($this->uuid))->runSuggest();

        Job::insertUpdate(['uuid' => $this->uuid, 'percentage' => 100, 'status_id' => 3, 'message' => 'Traitement terminé']);
    }


}