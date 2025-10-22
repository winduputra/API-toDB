@extends('layouts.adminlte')

@push('style')

<link rel="stylesheet" href="{{ url('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ url('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ url('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush

@section('content')

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">User</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item active"><a>User</a></li>
        </ol>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex justify-content-between align-items-center w-100">
              <h3 class="card-title">List User</h3>
              <a href="{{ route('user.add') }}" class="btn btn-sm btn-success font-weight-bold">
                Tambah
              </a>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="user" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Username</th>
                  <th>Akses</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($users as $item)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $item->name }}</td>
                  <td>{{ $item->username }}</td>
                  <td>{{ $item->role_name }}</td>
                  <td>
                    <a href="{{ route('user.update', ['id' => $item->id]) }}" class="btn btn-sm btn-warning">
                      <i class="fas fa-edit"></i>
                    </a>
                    <button data-id="{{ $item->id }}" data-name="{{ $item->name }}" class="ml-1 btn btn-sm btn-danger delete-confirm">
                      <i class="fas fa-trash-alt"></i>
                    </button>
                  </td>
                </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Username</th>
                  <th>Akses</th>
                  <th>Aksi</th>
                </tr>
              </tfoot>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
      </div>

    </div>

  </div>
</section>

@endsection

@push('script')

<script src="{{ url('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ url('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ url('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ url('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ url('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script>
  $(function () {
    $('#user').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });

  $(document).ready(function () {
    $('.delete-confirm').click(function(event) {
      var id = $(this).data('id');
      var name = $(this).data('name');
      event.preventDefault();
      Swal.fire({
        title: `Hapus "${name}"?`,
        text: 'Anda tidak akan dapat mengembalikan ini!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true,
      }).then(result => {
        if (result.isConfirmed) {
          $.ajax({
            url: `/user/delete/${id}`,
            type: 'POST',
            data: {
              id: id,
              '_token': '{{ csrf_token() }}',
            },
            success: function () {
              Swal.fire({
                title: 'Success',
                text: 'Hapus User!',
                icon: 'success',
                dangerMode: true,
              }).then(function() {
                location.reload();
              });
            },
            error: function (xhr, status, error) {
              var err = JSON.parse(xhr.responseText);
              Swal.fire({
                title: 'Error',
                text: err?.Message,
                icon: 'error',
              });
            }
          })
        }
      });
    })
  });
</script>
@endpush
