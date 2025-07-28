@extends('dashboard.index')

@section('content')
    <x-layout.defaultt title="Bergabung dengan Toko">
        <form action="{{ route('store.apply') }}" method="post">
            @csrf
            <label for="">Masukan Kode Unik Toko</label>
            <input class="form-control" type="text" name="unique_code" required>
            <div class="d-flex justify-content-end">
                <button class="btn btn-primary mt-3">Gabung Toko</button>
            </div>
        </form>
    </x-layout.defaultt>
@endsection
