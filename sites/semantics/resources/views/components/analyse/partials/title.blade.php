<div class="col-span-12">
    <h1 class="text-lg font-medium truncate mr-5">
        @if(isset($title) && $title!== "")
            {{ $title }}
        @else
            Analyse {{ $job->type->name }} : {{ $job->name }}
        @endif
    </h1>
    @foreach($job->parameters as $param)
        @if($param->name === 'url')
        <div>
            <strong>Url{{ $job->type->slug === "site" ? '' : ' du site' }} : </strong><a class="ml-auto text-theme-1 dark:text-theme-10 truncate" href="{{ $param->value }}">{{ $param->value }}</a>
        </div>
        @endif
    @endforeach

</div>
