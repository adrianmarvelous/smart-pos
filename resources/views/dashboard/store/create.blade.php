@extends('dashboard.index')

@section('content')
    <x-layout.defaultt title="Buat Toko Baru">
        <form action="{{ route('store.create_store') }}" method="get">
            <label for="">Nama</label>
            <input class="form-control" type="text" name="store_name" required>
            <label class="mt-3" for="">Alamat</label>
            <input class="form-control" type="text" name="address" required>
            <div class="d-flex justify-content-end">
                <button class="btn btn-primary mt-3">Simpan</button>
            </div>
        </form>
    </x-layout.defaultt>
@endsection
