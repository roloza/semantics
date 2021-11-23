<div wire:poll.500ms>
    @if($job !== null)
        @if($job->failedJob === null)
            <!--  BEGIN: task progress  -->
            <div class="pos intro-y grid grid-cols-12 gap-5 mt-5">
                <div class="col-span-12 xl:col-span-12">
                    <div class="intro-y block sm:flex items-center h-10">
                        <h3 class="text-lg font-medium mr-auto">{{ $job->message }}</h3>
                        @if(isset($job->status) && $job->status->id === 3)
                        <div class="flex items-center sm:ml-auto mt-3 sm:mt-0">
                            <a href="{{ route('analyse.show', [$job->type->slug, $job->uuid]) }}" class="btn box flex items-center text-gray-700 dark:text-gray-300">
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
            <!--  END: task progress  -->
            @else
                <!--  BEGIN: task progress ERROR  -->
                <div class="pos intro-y grid grid-cols-12 gap-5 mt-5">
                    <div class="col-span-12 xl:col-span-12">
                        <div class="intro-y block sm:flex items-center h-10">
                            <h3 class="text-lg font-medium mr-auto">Oops une erreur est survenue</h3>
                        </div>

                    <div class="progress h-4 rounded mt-3">
                        <div style="width: 100%" class="progress-bar bg-theme-6 rounded" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="mt-3">
                        <span class="px-3 py-1 rounded-full border border-theme-6 text-theme-6 dark:text-theme-6 dark:border-theme-6 mr-1">Erreur</span>
                    </div>

                    </div>
                </div>
                <!--  END: task ERROR  -->
            @endif
    @endif

</div>
