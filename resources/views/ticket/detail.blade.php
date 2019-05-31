@extends('layouts.horizontal')

@section('content')
<div class="container-fluid">
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0">{{ $data_ticket->subject }}</h4>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
          <div class="section-body">
          
          	<div class="row">
          		<div class="col-12">
          			<div class="card">
                 
                  <div class="card-body">
		                <h4 class='header-title mt-0'><span>Tiket Saya</span></h4>
		              	@if(session('success'))
	                        <div class="alert alert-primary" role="alert">
	                            <i class="fa fa-check-circle"></i> {!! session('success') !!}
	                        </div>
		              	@elseif(session('danger'))
	                        <div class="alert alert-danger" role="alert">
	                            <i class="fa fa-exclamation-circle"></i> {{ session('danger') }}
	                        </div>
	                    @endif
	                    @if ($errors->has('quantity'))
		                    	<div class="alert alert-danger" role="alert">
		                            <i class="fa fa-exclamation-circle"></i> {{ $errors->first('quantity') }}
		                        </div>
						@endif
						
						
						        <a href="#" class="btn btn-primary btn-icon icon-left btn-lg btn-block mb-4 d-md-none" data-toggle-slide="#ticket-items">
                      <i class="fas fa-list"></i> All Tickets
                    </a>
                    @foreach($ticket as $data)
                    <div class="tickets">
                      <div class="ticket-content" style="width: 100%">
                        <div class="ticket-header d-flex flex-row">
                          <div class="ticket-sender-picture img-shadow">
                            <img src="{{ asset('img/users/'.$data->user->photo) }}" class="rounded-circle" alt="image" width="50" height="50">
                          </div>
                          <div class="ticket-detail ml-3">
                            <div class="ticket-title">
                              <h4 class='header-title mt-0 mb-0'>{{ $data->user->name }}</h4>
                            </div>
                            <div class="ticket-info d-flex flex-row">
                              <div class="font-weight-600 fsz-12">{{ $data->user->level }}</div>
                              <div class="bullet"></div>
                              <div class="text-primary font-weight-600">{{$data->created_at->diffForHumans()}}</div>
                            </div>
                          </div>
                        </div>
                        <div class="ticket-description">
                          <p>{!! nl2br(htmlentities($data->content)) !!}</p>
                          
                          <div class="ticket-divider"></div>
                        </div>
                      </div>
                    </div>
                    @endforeach
                    @if($data_ticket->status != 'Closed')
	                   <div class="ticket-form">
	                    <form method="POST" action="">
	                    	@csrf
	                      <div class="form-group">
	                        <textarea class=" form-control" placeholder="Type a reply ..." name="content"></textarea>
	                      </div>
	                      <div class="form-group text-right">
	                        <button class="btn btn-primary btn-lg">
	                          Reply
	                        </button>
	                      </div>
	                    </form>
	                   </div>
                     @else
                      <p>Ticket ditutup, silahkan buat <a href="{{ url('/ticket/add') }}">tiket baru</a></p>
                     @endif
		              </div>
		            
		            </div>
          		</div>
          		<div class="col-md-4">
          			
          		</div>
          	</div>
            
          </div>
        </section>




</div>
@endsection