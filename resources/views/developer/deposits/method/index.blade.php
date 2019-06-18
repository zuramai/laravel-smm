@extends('layouts.horizontal-developer')

@section('content')
<div class="container-fluid">
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0"> Kelola Deposit</h4>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>

          <div class="section-body">
          
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="">
                  </div>
                  <div class="card-body">
                    <h4 class='header-title mt-0'><span>Kelola Metode Deposit </span></h4>
                     @if(session('success'))

                        <div class="alert alert-success" role="alert">
                            <i class="fa fa-check-circle"></i> {{ session('success') }}
                        </div>

                    @endif
                    <div class="float-left">
                      <a href="{{ url('developer/deposit/method/add') }}" class="btn btn-primary">Tambah</a>
                    </div>

                    <div class="clearfix mb-3"></div>

                    <div class="table-responsive">
                      <table class="table table-striped table-md">
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Kode</th>
                            <th>Tipe</th>
                            <th>Data</th>
                            <th>Rate</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                          @foreach($methods as $method)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{$method->name}}</td>
                            <td>{{$method->code}}</td>
                            <td>{{$method->type}}</td>
                            <td>{{$method->data}} ({{$method->note}})</td>
                            <td>{{$method->rate}}</td>
                            <td><span class="badge badge-{{ $method->status=='Active' ? 'success' : 'danger' }}">{{$method->status}}</span></td>
                            <td>
                              <a href="{{ url('developer/deposit/method/edit/'.$method->id) }}" class="btn btn-info">Edit</a>
                              <form method="POST" class="form-delete">
                                @method('delete')
                                @csrf
                                <input type="hidden" value="{{ $method->id }}" name="id">
                                <button type="button" class="btn btn-danger">Delete</button>
                              </form>
                            </td>
                          </tr>
                          @endforeach
                      </table>
                    </div> 
                    {{$methods->links()}}
                  </div>
                </div>
              </div>
              
            </div>
          	<div class="row">
          	</div>
            
          </div>
        </div>
      </div>
</div>
@endsection