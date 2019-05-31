@extends('layouts.horizontal')

@section('content')
<div class="container-fluid">
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0">Penggunaan Saldo</h4>
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
		                <h4 class='header-title mt-0'><span>Riwayat Penggunaan Saldo</span></h4>
		              	
						<div class="table-responsive">
							<table class="table table-striped table-md">
								<tr>
									<th>#</th>
									<th>Action</th>
									<th>Username</th>
									<th>Deskripsi</th>
									<th>Tanggal</th>
								</tr>
									@foreach($balance_histories as $history)
									<tr>
										<td>{{ $history->id }}</td>
										<td>
											<span class="badge badge-{{ ($history->action == 'Cut Balance') ? 'danger' : 'success' }}">		
												{{ $history->action }}
											</span>
										</td>
										<td>{{ $history->user->name }}</td>
										<td>{{ $history->desc }}</td>
										<td>{{ date('d F Y H:i:s', strtotime($history->created_at)) }}</td>
									</tr>
									@endforeach
							</table>
						</div>
						<div class="float-right">
							{{ $balance_histories->links() }}
						</div>
							                
		              </div>
		            
		            </div>
          		</div>
          	</div>
            
          </div>
    </div>
</div>




</div>
@endsection