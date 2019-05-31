@extends('layouts.horizontal-developer')

@section('content')
<div class="container-fluid">
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0"> Kelola Berita</h4>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>

          <div class="section-body">
          
          	<div class="row">
          		<div class="col-md-6">
          			<div class="card">
		              <div class="">
		              </div>
		             
		              <div class="card-body">
		                <h4 class='header-title mt-0'><span><i class=" dripicons-view-list-large "></i> Riwayat Aktifitas</span></h4>
		              	
						<div class="table-responsive">
							<table class="table table-striped table-md">
								<tr>
									<th>#</th>
									<th>Waktu</th>
									<th>Type</th>
									<th>Username</th>
									<th>IP</th>
									<th>User Agent</th>
								</tr>
									@foreach($activities as $activity)
									<tr>
										<td>#{{ $activity->id }}</td>
										<td>{{ date('d F Y H:i:s', strtotime($activity->created_at)) }}</td>
										<td>{{ $activity->type }}</td>
										<td>{{ $activity->user->name }}</td>
										<td>{{ $activity->ip }}</td>
										<td>{{ $activity->user_agent }}</td>
									</tr>
									@endforeach
							</table>
						</div>
						<div class="float-right mt-2">
							{{ $activities->links() }}
						</div>
							                
		              </div>
		            
		            </div>
          		</div>
          		<div class="col-md-6">
          			<div class="card">
		              <div class="">
		              </div>
		             
		              <div class="card-body">
		                <h4 class='header-title mt-0'><span><i class=" dripicons-wallet "></i> Riwayat Penggunaan Saldo</span></h4>
		              	
						<div class="table-responsive">
							<table class="table table-striped table-md">
								<tr>
									<th>#</th>
									<th>Action</th>
									<th>Username</th>
									<th>Deskripsi</th>
									<th>Waktu</th>
								</tr>
									@foreach($balance_histories as $history)
									<tr>
										<td>#{{ $history->id }}</td>
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
						<div class="float-right mt-2">
							{{ $activities->links() }}
						</div>
							                
		              </div>
		            
		            </div>
          		</div>
          	</div>
            
          </div>
        </div></div>




</div>
@endsection