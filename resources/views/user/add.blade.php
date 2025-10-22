@extends('layouts.adminlte')

@push('style')

@endpush

@section('content')

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        {{-- <h1 class="m-0">Pangkat</h1> --}}
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('user.list') }}">User</a></li>
          <li class="breadcrumb-item active">Tambah</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    
    <div class="row justify-content-center">
      <div class="col-md-6 col-offset-md-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Tambah User</h3>
          </div>
          <form method="post" action="{{ route('user.add') }}">
            @csrf
            <div class="card-body">
              <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name" name="name" placeholder="Masukkan Nama Lengkap" required>
                @foreach($errors->get('name') as $msg)
                  <span class="text-danger text-small">{{ $msg }}</span>
                @endforeach
              </div>

              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" id="username" name="username" placeholder="Masukkan Username" required>
                @foreach($errors->get('username') as $msg)
                  <span class="text-danger text-small">{{ $msg }}</span>
                @endforeach
              </div>

              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" id="password" name="password" placeholder="Masukkan Password" required>
                @foreach($errors->get('password') as $msg)
                  <span class="text-danger text-small">{{ $msg }}</span>
                @endforeach
              </div>
              
              <div class="form-group">
                <label for="role_id">Akses User</label>
                <select name="role_id" id="role_id" class="form-control" required>
                  <option value="2">User</option>
                  <option value="1">Admin</option>
                </select>
                @foreach($errors->get('role_id') as $msg)
                  <span class="text-danger text-small">{{ $msg }}</span>
                @endforeach
              </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-success">Tambah</button>
            </div>
          </form>
        </div>

      </div>

    </div>

  </div>
</section>

@endsection

@push('script')

@endpush
