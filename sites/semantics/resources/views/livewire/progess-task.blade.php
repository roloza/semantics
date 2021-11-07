<div wire:poll.500ms>
    @if($job !== null)
    <!--  BEGIN: task progress  -->
    <div class="pos intro-y grid grid-cols-12 gap-5 mt-5">
        <div class="col-span-12 xl:col-span-12">
            <div class="intro-y block sm:flex items-center h-10">
                <h3 class="text-lg font-medium mr-auto">{{ $job->failed_job === null ? $job->status->name : 'Erreur'}}</h3>
                @if(isset($job->status) && $job->status->id === 3)
                <div class="flex items-center sm:ml-auto mt-3 sm:mt-0">
                    <a href="{{ route('accueil') }}" class="btn box flex items-center text-gray-700 dark:text-gray-300">
                        Consulter cette analyse
                    </a>
                </div>
                    @endif
            </div>
            <div class="progress h-4 rounded mt-3">
                <div style="width: {{ $job->percentage }}%" class="progress-bar bg-theme-1 rounded" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="mt-3">
                <span class="px-3 py-1 rounded-full border border-theme-1 text-theme-1 dark:text-theme-10 dark:border-theme-10 mr-1">{{ isset($job->status) ? $job->status->name : 'En attente'}}</span>
            </div>
        </div>
    </div>
    <!--  BEGIN: task progress  -->
    @endif
</div>
