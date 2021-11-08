<div>
    <!--  BEGIN: table latest analyses  -->
    <div class="col-span-12 mt-6">
        @if (isset($title) && $title !== '')
            <div class="intro-y block sm:flex items-center h-10">
                <h2 class="text-lg font-medium truncate mr-5">{{ $title }}</h2>
            </div>
        @endif
        <div class="box p-5">
            @if (session()->has('message'))

                <div class="alert alert-success-soft alert-dismissible show flex items-center mb-2" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        X
                    </button>
                </div>
            @endif

            <span class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                <div class="xl:flex sm:mr-auto">
                    <div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
                        <input id="filter-value" class="form-control sm:w-40 xxl:w-full mt-2 sm:mt-0" type="text" placeholder="Recherche..." wire:model.debounce.500ms="search">
                        <button id="filter-clear" class="btn btn-secondary w-full sm:w-16 mt-2 sm:mt-0 sm:ml-1" wire:click="resetFilters()">Reset</button>
                    </div>
                </div>
            </span>

            @if ($jobs->count() > 0 )
            <div class="mt-5 overflow-x-auto">
                <table class="table" wire:poll.visible>
                    <thead>
                    <tr class="bg-gray-700 dark:bg-dark-1 text-white">
                        <th class="whitespace-nowrap" style="width: 150px;">Type</th>
                        <th class="whitespace-nowrap">Nom</th>
                        <th class="whitespace-nowrap" style="width: 144px;">Statut</th>
                        <th class="whitespace-nowrap" style="width: 144px;">Actions</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($jobs as $k => $job)
                    <tr>
                        <td class="border-b dark:border-dark-5">{{ $job->type->name }}</td>
                        <td class="border-b dark:border-dark-5">
                            <div class="font-medium whitespace-nowrap">{{ $job->name }}</div>
                            <div class="text-gray-600 text-xs whitespace-nowrap">
                                @foreach($job->params as $name => $param)
                                    <strong>{{$name}}:</strong> {{$param}}<br>
                                @endforeach
                            </div>
                        </td>
                        <td class="border-b dark:border-dark-5">
                            @if($job->failed_job === null)
                                <span class="py-1 px-2 rounded-full text-xs bg-theme-9 text-white font-medium">
                                    {{ isset($job->status->name) ? $job->status->name : 'En attente'}}
                                </span>
                            @else
                                <span class="py-1 px-2 rounded-full text-xs bg-theme-6 text-white font-medium">
                                    Erreur
                                </span>
                            @endif
                        </td>

                        <td class="border-b dark:border-dark-5">
                            @if(isset($job->status) && $job->status->id === 3)
                                <a href="{{ route('accueil', $job->uuid) }}" class="btn btn-primary mr-1 mb-2 tooltip" title="Consulter"><i class="fas fa-eye"></i></a>
                                <button class="btn btn-danger mr-1 mb-2 tooltip" title="Supprimer" wire:click="deleteJob('{{ $job->uuid }}')"><i class="fas fa-trash"></i></button>
                                @endif
                        </td>

                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $jobs->links() }}
            </div>

            @else
                <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0 pt-8">
                    <p>Aucune analyse trouvée</p>
                </div>

            @endif
            </div>
        </div>
    </div>
</div>
