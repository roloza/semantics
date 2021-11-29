<!-- BEGIN: Breadcrumb -->
<div class="-intro-x breadcrumb mr-auto hidden sm:flex">
    <a href="{{ route('accueil') }}">Accueil</a>
    @if (isset($breadcrumb))
    @foreach($breadcrumb as $element)
        <i class="fas fa-chevron-right breadcrumb__icon"></i>
        @if (isset($element['link']))
            <a href="{{ $element['link'] }}" >{{ $element['title'] }}</a>
        @else
            <span class="breadcrumb--active">{{ $element['title'] }}</span>
        @endif
    @endforeach
    @endif
</div>
<!-- END: Breadcrumb -->