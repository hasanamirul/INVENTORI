@extends('admin.layouts.app')

@section('content')
    <div class="container mt-4">
        <h3>Edit User</h3>
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input name="name" class="form-control" value="{{ old('name', $user->name) }}" required />
            </div>
            <div class="mb-3">
                <label class="form-label">NIP</label>
                <input name="nip" class="form-control" value="{{ old('nip', $user->nip) }}" />
            </div>
            <div class="mb-3">
                <label class="form-label">Bidang</label>
                <input name="bidang" class="form-control" value="{{ old('bidang', $user->bidang) }}" />
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required />
            </div>
            <div class="mb-3">
                <label class="form-label">Password (kosongkan jika tidak diubah)</label>
                <input name="password" type="password" class="form-control" />
            </div>
            <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-control">
                    <option value="user" {{ $user->role=='user'? 'selected':'' }}>User</option>
                    <option value="admin" {{ $user->role=='admin'? 'selected':'' }}>Admin</option>
                </select>
            </div>
            <button class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection
