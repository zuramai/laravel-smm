@extends('layouts.horizontal-developer')

@section('content')
<div class="container-fluid">
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0"> Kelola Kode Undangan</h4>
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
		                <h4 class='header-title mt-0'><span><i class=" ti-files "></i> Semua Kode Undangan</span></h4>
                     @if(session('success'))

                        <div class="alert alert-success" role="alert">
                            <i class="fa fa-check-circle"></i> {{ session('success') }}
                        </div>

                    @endif
  		              <div class="card-body-header text-right" style="display: flex; justify-content: flex-end;">
                      <form method="POST" class="mr-2" action="invitation_code/random">
                        @csrf
                        <button class="btn btn-info" type="submit">Tambah kode acak</button>
                      </form>
  		                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        Tambah kode baru
                      </button>
  		              </div>
                    <div class="clearfix mb-3"></div>
                    <div class="table-responsive">
                      <table class="table table-striped table-md">
                          <tr>
                            <th>#</th>
                            <th>Kode</th>
                            <th>Sisa penggunaan</th>
                            <th>Status</th>
                            <th>Dibuat pada</th>
                            <th>Action</th>
                          </tr>
                          @foreach($code as $data)
                            <tr>
                              <td>{{ $data->id }}</td>
                              <td>{{ $data->code }}</td>
                              <td>{{ $data->remains }}</td>
                              <td>
                                <span class="badge badge-{{ ($data->status == 'Redeemed') ? 'danger' : 'success' }}">
                                {{ $data->status }}
                                </span>
                              </td>
                              <td>{{ $data->created_at }}</td>
                              <td>
                                <form method="POST">
                                  @csrf
                                  @method('delete')
                                  <input type="hidden" value="{{ $data->id }}" name="id">
                                  <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                </form>
                              </td>
                            </tr>
                          @endforeach
                          @forelse($code as $data)
                            @empty
                            <tr>
                              <td colspan="5" class="text-center">No data</td>
                            </tr>
                          @endforelse
                      </table>
                    </div>
                    {{$code->links()}}
                  </div>
		            </div>
          		</div>
          	</div>
            
          </div>
        </div></div>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah kode undangan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            <form method="POSt">
              @csrf
              <div class="modal-body">
                  <div class="form-group">
                    <label>Kode</label>
                    <input type="text" name="code" class="form-control">
                  </div>
                  <div class="form-group">
                    <label>Jumlah batas penggunaan</label>
                    <input type="number" name="max" class="form-control">
                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Tambah</button>
              </div>
            </form>
            </div>
          </div>
        </div>
</div>
@endsection