@extends('layout')

@section('title')
    Faq
@endsection

@section('description')
@endsection

@section('keywords')
    analyse sémantique, mots-clés, descripteurs, analyse de texte, expressions
@endsection

@section('content')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">Faq</h2>
    </div>

    {{-- Faq --}}
    <div class="grid grid-cols-12 gap-6">

        <!-- BEGIN: FAQ Menu -->
        <div class="intro-y col-span-12 lg:col-span-4 xl:col-span-3">
            <div class="box mt-5">
                <div class="p-5">
                    @foreach($faqNavs as $i => $faqNav)
                        <a class="flex items-center text-theme-4 font-medium {{$i > 0 ? 'mt-5': ''}}" href="{{ route('faq.show', $faqNav->slug) }}">{{ $faqNav->name }}</a>
                    @endforeach

                </div>
            </div>
        </div>
        <!-- END: FAQ Menu -->

        <!-- BEGIN: FAQ Content -->
        <div class="intro-y col-span-12 lg:col-span-8 xl:col-span-9">
            <div class="intro-y box lg:mt-5">
                <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">{{ $faq->name }}</h2>
                </div>
                <div class="p-5">
                    {!! $faq->content !!}
                </div>
            </div>
        </div>
        <!-- END: FAQ Content -->
    </div>
@endsection
