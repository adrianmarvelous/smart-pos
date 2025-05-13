@extends('dashboard.index')

@section('content')
    <x-layout.defaultt title="Toko">
        <div class="responsive-table">
            <table  id="basic-datatables" class="table">
                <thead>
                    <th>No</th>
                    <th>Nama Toko</th>
                    <th>Aksi</th>
                </thead>
                <tbody>
                    @foreach ($stores as $key => $item)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $item->store_name }}</td>
                        <td>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{ $key }}">
                            <i class="fa fa-pencil-alt"></i>
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal{{ $key }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('store.update') }}" method="post">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Edit Toko</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <label for="">Nama</label>
                                                <input class="form-control" type="text" name="store_name" value="{{ $item->store_name }}" required>
                                                <label class="mt-3" for="">Alamat</label>
                                                <input class="form-control" type="text" name="address" value="{{ $item->address }}" required>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModaldelet{{ $key }}">
                            <i class="fa fa-trash"></i>
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModaldelet{{ $key }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('store.delete') }}" method="post">
                                            @csrf
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title" id="exampleModalLabel">Hapus Toko</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah yakin ingin menghapus toko {{ $item->store_name }}
                                            </div>
                                            <div class="modal-footer">
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <button type="button" class="btn btn-light" data-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-layout.defaultt>
@endsection
