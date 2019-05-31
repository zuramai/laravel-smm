@extends('layouts.horizontal')

@section('content')
<div class="container-fluid">
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0">Riwayat Deposit</h4>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>

          <div class="section-body">
          
          	<div class="row">
          		<div class="col-md-12">
          			<div class="card">
                  <div class="card-body">
		                <h4 class='header-title mt-0'><span>Riwayat Deposit</span></h4>
                     @if(session('success'))

                        <div class="alert alert-success" role="alert">
                            <i class="fa fa-check-circle"></i> {{ session('success') }}
                        </div>

                    @endif
  		              
                    <div class="table-responsive">
                      <table class="table table-striped table-md">
                          <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Type</th>
                            <th>Jumlah</th>
                            <th>Pengirim</th>
                            <th>Get saldo</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                          @foreach($deposit as $data)
                          <tr>
                            <td>{{ $data->id }}</td>
                            <td>{{$data->created_at}}</td>
                            <td>{{$data->methods->name}} ({{$data->methods->type}})</td>
                            <td>Rp {{number_format($data->quantity)}}</td>
                            <td>{{$data->sender}}</td>
                            <td>Rp {{number_format($data->get_balance)}}</td>
                            <td><span class="badge badge-{{ ($data->status=='Success' ? 'success' : ($data->status == 'Pending' ? 'warning' : 'danger')) }}">{{$data->status}}</span>
                            <td>
                              @if($data->methods->type == 'MANUAL')
                                <a href="{{ url('contact') }}" class="btn btn-info">Konfirmasi</a>
                              @else
                                <button class="btn btn-secondary" disabled data-toggle="tooltip" data-placement="bottom" title="Fitur konfirmasi hanya untuk deposit manual">Konfirmasi</button>
                              @endif
                              @if(!$data->status == 'Canceled' || !$data->status == 'Success')
                              <form method="POST" class="form-delete">
                                @csrf
                                @method('delete')
                                <input type="hidden" value="{{ $data->id }}" name="id">
                                <button type="submit" class="btn btn-danger" id="cancel_deposit" data-delete='{{ $data->id }}'>Cancel</button>
                              </form>
                              @endif
                            </td>
                          </tr>
                          @endforeach
                      </table>
                    </div>
                    <div class="mt-2">{{ $deposit->links() }}</div>
                  </div>
		            </div>
          		</div>
          	</div>
            
          </div>
        </section>
</div>
@endsection