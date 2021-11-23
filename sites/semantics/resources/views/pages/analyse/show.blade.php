@extends('layout')

@section('title')
    Lancer une analyse
@endsection

@section('description')
    Analyser la sémantique, un page unique, un site entier ou encore le web en général
@endsection

@section('keywords')
    analyse sémantique, mots-clés, descripteurs, analyse de texte, expressions
@endsection

@section('content')
<div class="grid grid-cols-12 gap-6 mt-8">

    <x-analyse.partials.title :job="$job"/>

    <div class="col-span-12 lg:col-span-9 xxl:col-span-10">
        <div class="grid grid-cols-12 gap-6">

            <div class="col-span-12 mt-6">
                <div class="grid grid-cols-12 gap-6">
                    {{-- Themes : Vert 9, Bleu 10, Orange 11, Jaune 12 --}}
                    {{-- <x-analyse.one-report-box label="Pages analysées" :value="$countUrls" theme="10" icon="far fa-file-alt"/> --}}
                    <x-analyse.one-report-box label="Mots-clés" :value="$countKeywords" theme="11" icon="far fa-chart-bar" size="4"/>
                    <x-analyse.one-report-box label="Expressions" :value="$countSyntagmes" theme="12" icon="fas fa-chart-area" size="4"/>
                    <x-analyse.one-report-box label="Thême principal" :value="$bestKeyword->lemme" theme="9" icon="fas fa-book-reader" size="4"/>
                </div>
            </div>

            {{-- BEGIN : Descripteurs Site --}}
            <div class="col-span-12 mt-8">
                <x-analyse.partials.word-cloud :data="$dataWordCloud" name="Sujets principaux de cette page" showMore="1"/>
            </div>
            {{-- END : Descripteurs Site --}}
        </div>
    </div>

    <div class="col-span-12 lg:col-span-3 xxl:col-span-2">
        <div class="intro-y box p-5 mt-6">
            <x-analyse.partials.navigation :job="$job"/>
        </div>
    </div>

    <div class="col-span-12">
        <x-analyse.partials.network-graph :keyword="$bestKeywordLength1" :job="$job" />
    </div>
</div>

@endsection
