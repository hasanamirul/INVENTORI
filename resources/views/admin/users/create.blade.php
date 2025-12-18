@extends('admin.layouts.app')

@section('content')
    <div class="container mt-4">
        <h3>Tambah User</h3>
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input name="name" class="form-control" required />
            </div>
            <div class="mb-3">
                <label class="form-label">NIP</label>
                <input name="nip" class="form-control" />
            </div>
            <div class="mb-3">
                <label class="form-label">Bidang</label>
                <input name="bidang" class="form-control" />
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input name="email" type="email" class="form-control" required />
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input name="password" type="password" class="form-control" required />
            </div>
            <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-control">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <button class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection
