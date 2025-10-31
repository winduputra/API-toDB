@extends('layouts.adminlte')

@section('content')

  <section class="content">
    <div class="container-fluid">
      @include('components.summary')
    
      <div class="row mt-3">
        <div class="col-md-6 col-12">
    
          <div class="card">
            <div class="card-header">
                <h3 class="card-title">Update BeLa</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('bela.update') }}" method="post">
                @csrf
                <div class="form-group">
                    <input type="text" name="bela" min="1" class="form-control" value="{{ getBela() }}" required>
                </div>

                <button type="submit" class="btn btn-success btn-block btn-sm">Update</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection
