@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header header-elements">
            <span class="me-2">Data User</span>

            <div class="card-header-elements ms-auto">
                <a href="{{ route('add_users') }}" class="btn -bottom-3 btn-primary">
                    <span class="tf-icon ti ti-plus ti-xs me-1"></span>Add
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <caption class="ms-4">Data Damkar</caption>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->username }}</td>
                                <td>{{ $row->email }}</td>
                                <td>{{ $row->role }}</td>
                                <td>
                                    <button type="button" class="btn btn-icon btn-outline-secondary">
                                        <span class="ti ti-map-2 text-info"></span>
                                    </button>

                                    <button type="button" class="btn btn-icon btn-outline-secondary"
                                        onclick="hapus({{ $row->id }})">
                                        <span class="ti ti-trash-x text-danger"></span>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
