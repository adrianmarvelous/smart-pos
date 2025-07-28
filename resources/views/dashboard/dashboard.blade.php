@extends('dashboard.index')


@section('content')
    <x-layout.defaultt title="Dashboard">
        @if ($user->modelHasRoles->isEmpty())
            <div>
                <a class="btn btn-primary p-3 m-3" href="{{ route('store.create') }}">
                    <i class="fa fa-store fa-10x"></i>
                    <br>
                    Make Store
                </a>
                <a class="btn btn-info p-3 m-3" href="{{ route('store.join') }}">
                    <i class="fa fa-users fa-10x"></i>
                    <br>
                    Be a Crew Store
                </a>
            </div>
        @endif
    </x-layout.defaultt>

@endsection
