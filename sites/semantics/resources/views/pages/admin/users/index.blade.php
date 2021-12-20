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

    <h2 class="intro-y text-lg font-medium mt-10">Utilisateurs</h2>

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12">
            <div class="intro-y box p-5">
                <table class="table">
                    <thead>
                    <tr>
                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Id</th>
                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Avatar</th>
                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Nom</th>
                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">email</th>
                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Profile</th>
                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">#jobs</th>
                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Date de création</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td class="border">{{ $user->id }}</td>
                            <td class="border"><img alt="Avatar" class="rounded-full w-8 h-8" src="{{ (new \App\Custom\Tools\Avatar($user->email))->base64() }}"></td>
                            <td class="border">{{ $user->name }}</td>
                            <td class="border">{{ $user->email }}</td>
                            <td class="border">{{ $user->profile->name }}</td>
                            <td class="border">{{ $user->count_job ?? 0 }}</td>
                            <td class="border">{{ $user->created_at }}</td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="mt-5">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
