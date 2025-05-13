@extends('dashboard.index')

@section('content')
    <x-layout.defaultt title="Edit Produk {{ $product->name }}">
        
        <form action="{{ route('product.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
                <h2>Live Camera Preview</h2>
                <video id="video" width="300" height="225" autoplay style="display: none;"></video>
                <br>
                <button id="startStopCamera" type="button" class="btn btn-secondary">Start Camera</button>
                <button id="capture" type="button" class="btn btn-success">Take Photo</button>
                <br>
                <div class="d-flex w-100">
                    <div>
                        <p class="text-center">Foto Baru</p>
                        <canvas id="canvas" width="300" height="225" style="display: none;"></canvas>
                        <img id="photo" alt="Captured Photo" style="margin-top:10px;display:none" />
                    </div>
                    <div>
                        <p class="text-center">Foto Lama</p>
                        <img src="{{ asset('').$product->photo }}" alt="">
                    </div>
                </div>
                <br>
                <label class="mt-3">Scan Barcode</label>
                <input class="form-control" type="text" name="barcode_text" id="barcode_text" value="{{ $product->barcode }}" required>
                <button id="startBarcodeScan" type="button" class="btn btn-warning mt-2">Start Barcode Scan</button>
                <br>
                <label class="mt-3">Nama Produk</label>
                <input class="form-control" type="text" name="name" value="{{ $product->name }}" required>
                <label class="mt-3">Varian</label>
                <input class="form-control" type="text" name="varian" value="{{ $product->varian }}" required>
                <label class="mt-3">Ukuran</label>
                <input class="form-control" type="text" name="size" value="{{ $product->size }}" required>
                <label class="mt-3">Satuan</label>
                <input class="form-control" type="text" name="unit" value="{{ $product->unit }}" required>
                <input type="hidden" name="id" value="{{ $product->id }}">
                <button type="submit" class="btn btn-primary mt-3">Simpan</button>
        </form>
    </x-layout.defaultt>
    
@endsection
