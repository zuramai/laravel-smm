@extends('layouts.horizontal')

@section('content')
<div class="container-fluid">
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0">API Dokumentasi</h4>
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
		                <h4 class='header-title mt-0'><span>API Profile</span></h4>
                        <div class="table table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <td>HTTP Method</td>
                                    <td>POST</td>
                                </tr>
                                <tr>
                                    <td>API URL</td>
                                    <td>{{ url('/api/profile') }}</td>
                                </tr>
                                @auth
                                <tr>
                                    <td>API Key</td>
                                    <td>{{ auth()->user()->api_key }}</td>
                                </tr>
                                @endauth
                            </table>
                        </div>
                            <div class="section-api">
                                <div class="section-api-header">
                                    <h3>Get Profile Info</h3>
                                </div>
                                <div class="section-api-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-md">    
                                      
                                                <tr>
                                                    <th>
                                                        Parameter
                                                    </th>
                                                    <th>
                                                        Deskripsi
                                                    </th>
                                                </tr>
                                            
                                                <tr>
                                                    <td>key</td>
                                                    <td>API Key anda</td>
                                                </tr>
                                           
                                            
                                        </table>
                                    </div>
                                    <div class="responses">
                                        <div class="response">
                                        <p>Success Response:</p>
                                            <pre class="prettyprint">
                                                {
                                                    "success": true,
                                                    "data": {
                                                        "account_status": "Active",
                                                        "balance": 14200,
                                                    }
                                                }
                                            </pre>
                                        </div>
                                    <div class="responses">
                                        <div class="response">
                                            <p>Failed response:</p>
                                            <pre class="prettyprint">
                                                {
                                                    "success": false,
                                                    "error": "Wrong API Key"
                                                }
                                            </pre>
                                            
                                        </div>
                                        
                                    </div>
                                </div>
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