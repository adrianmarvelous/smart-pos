@extends('dashboard.index')


@section('content')
    <x-layout.defaultt title="List Crew Store">
        <div class="responsive-table">
            <table  id="basic-datatables" class="table">
                <thead>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </thead>
                <tbody>
                    @foreach ($user as $key => $item)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $item->hasUser->name }}</td>
                        <td>{{ $item->hasUser->email }}</td>
                        <td style="text-transform: capitalize">{{ $item->hasRole->name }}</td>
                        <td>
                            
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{ $key }}">
                            <i class="fa fa-pencil-alt"></i>
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal{{ $key }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('store.update_role') }}" method="post">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Edit Role</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <label for="">Role</label>
                                                <select class="form-control mt-3" name="role" id="">
                                                    <option style="text-transform: capitalize" value="{{ $item->hasRole->id }}" selected>{{ $item->hasRole->name }}</option>
                                                    @foreach ($roles as $role)
                                                        @if ($role->id != $item->hasRole->id)
                                                            <option style="text-transform: capitalize" value="{{ $role->id }}">{{ $role->name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <input type="hidden" name="user_id" value="{{ $item->hasUser->id }}">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
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
