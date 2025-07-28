@extends('dashboard.index')

@section('content')
    <x-layout.defaultt title="List Produk">
        <div class="d-flex justify-content-end mb-3">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            Tambah Produk
            </button>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <h2>Live Camera Preview</h2>
                        <video id="video" width="300" height="225" autoplay style="display: none;"></video>
                        <br>
                        <button id="startStopCamera" type="button" class="btn btn-secondary">Start Camera</button>
                        <button id="capture" type="button" class="btn btn-success">Take Photo</button>
                        <canvas id="canvas" width="300" height="225" style="display: none;"></canvas>
                        <br>
                        <img id="photo" alt="Captured Photo" style="margin-top:10px;display:none" />
                        <label class="mt-3">Scan Barcode</label>
                        <input class="form-control" type="text" name="barcode_text" id="barcode_text" required>
                        <button id="startBarcodeScan" type="button" class="btn btn-warning mt-2">Start Barcode Scan</button>
                        <br>
                        <label class="mt-3">Nama Produk</label>
                        <input class="form-control" type="text" name="name" required>
                        <label class="mt-3">Varian</label>
                        <input class="form-control" type="text" name="varian" required>
                        <label class="mt-3">Ukuran</label>
                        <input class="form-control" type="text" name="size" required>
                        <label class="mt-3">Satuan</label>
                        <input class="form-control" type="text" name="unit" required>
                        <label class="mt-3">Harga Beli</label>
                        <input class="form-control" type="number" name="harga_beli" required>
                        <label class="mt-3">Harga Jual</label>
                        <input class="form-control" type="number" name="harga_jual" required>
                        <label class="mt-3">Stok</label>
                        <input class="form-control" type="number" name="stock" required>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="image_data" id="image_data">
                        {{-- <button type="submit" class="btn btn-primary mt-3">Submit Photo</button> --}}
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
        <div class="table-responsive">
            <table  id="basic-datatables" class="table">
                <thead>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Varian</th>
                    <th>Ukuran</th>
                    <th>Satuan</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </thead>
                <tbody>
                    @foreach ($products as $key => $item)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->varian }}</td>
                        <td>{{ $item->size }}</td>
                        <td>{{ $item->unit }}</td>
                        <td>
                            <img src="{{ asset('').$item->photo }}" alt="">
                        </td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('product.edit',['id' => $item->id]) }}"><i class="fa fa-pencil-alt"></i></a>
                            <!-- Button trigger modal -->
                            {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{ $key }}">
                            <i class="fa fa-pencil-alt"></i>
                            </button> --}}
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal{{ $key }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="" method="post">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Edit Produk</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <h2>Live Camera Preview</h2>
                                                <video id="video" width="300" height="225" autoplay style="display: none;"></video>
                                                <br>
                                                <button id="startStopCamera" type="button" class="btn btn-secondary">Start Camera</button>
                                                <button id="capture" type="button" class="btn btn-success">Take Photo</button>
                                                <canvas id="canvas" width="300" height="225" style="display: none;"></canvas>
                                                <br>
                                                <img id="photo" alt="Captured Photo" style="margin-top:10px;display:none" />
                                                <label class="mt-3">Scan Barcode</label>
                                                <input class="form-control" type="text" name="barcode_text" id="barcode_text" value="{{ $item->barcode }}">
                                                <button id="startBarcodeScan" type="button" class="btn btn-warning mt-2">Start Barcode Scan</button>
                                                <br>
                                                <label class="mt-3">Nama Produk</label>
                                                <input class="form-control" type="text" name="name" value="{{ $item->name }}">
                                                <label class="mt-3">Varian</label>
                                                <input class="form-control" type="text" name="varian" value="{{ $item->varian }}">
                                                <label class="mt-3">Ukuran</label>
                                                <input class="form-control" type="text" name="size" value="{{ $item->size }}">
                                                <label class="mt-3">Satuan</label>
                                                <input class="form-control" type="text" name="unit" value="{{ $item->unit }}">
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
                                        <form action="{{ route('product.delete') }}" method="post">
                                            @csrf
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title" id="exampleModalLabel">Hapus Produk</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah yakin ingin menghapus Produk {{ $item->name.' '.$item->varian }}
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
