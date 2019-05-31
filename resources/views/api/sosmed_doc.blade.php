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
		                <h4 class='header-title mt-0'><span>API Dokumentasi Sosial Media</span></h4>
                        <div class="table table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <td>HTTP Method</td>
                                    <td>POST</td>
                                </tr>
                                <tr>
                                    <td>API URL</td>
                                    <td>{{ url('/api/sosmed') }}</td>
                                </tr>
                                @auth
                                <tr>
                                    <td>API Key</td>
                                    <td>{{ $user->api_key }}</td>
                                </tr>
                                @endauth
                            </table>
                        </div>
                            <div class="section-api">
                                <div class="section-api-header">
                                    <h3>Get Service</h3>
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
                                           
                                                <tr>
                                                    <td>action</td>
                                                    <td>services</td>
                                                </tr>
                                            
                                        </table>
                                    </div>
                                    <div class="responses">
                                        <div class="response">
                                        <p>Success Response:</p>
                                            <pre class="prettyprint">
                                                {
                                                    success: true,
                                                    data: {
                                                        id: 1,
                                                        name: 'Instagram Followers Khusus Zooopedia Termurah S1',
                                                        min: 100,
                                                        max: 100000,
                                                        price: 2150,
                                                        status: 'Active',
                                                        note: 'SUPER INSTANT, HIGH QUALITY, SILAHKAN DIORDER'
                                                    }
                                                }
                                            </pre>
                                        </div>
                                    <div class="responses">
                                        <div class="response">
                                            <p>Failed response:</p>
                                            <pre class="prettyprint">
                                                {
                                                    success: false,
                                                    error: "Incorrect Request"
                                                }
                                            </pre>
                                            
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="section-api">
                                <div class="section-api-header">
                                    <h3>Pemesanan Baru</h3>
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
                                           
                                                <tr>
                                                    <td>action</td>
                                                    <td>order</td>
                                                </tr>
                                           
                                                <tr>
                                                    <td>service</td>
                                                    <td>Id layanan, bisa dilihat di <a href="{{ url('price/sosmed') }}">Daftar layanan</a></td>
                                                </tr>
                                           
                                                <tr>
                                                    <td>target</td>
                                                    <td>Target pesanan sesuai kebutuhan (username/url/id).</td>
                                                </tr>
                                           
                                                <tr>
                                                    <td>quantity</td>
                                                    <td>Jumlah pesan</td>
                                                </tr>
                                           
                                                <tr>
                                                    <td>custom_comments</td>
                                                    <td>Daftar komentar, dipisahkan dengan enter atau \r\n atau \n. (Hanya diperlukan jika pesan layanan custom komentar)</td>
                                                </tr>
                                           
                                                <tr>
                                                    <td>custom_link</td>
                                                    <td>Link post. (Hanya diperlukan jika pesan layanan Like Komentar Instagram)</td>
                                                </tr>
                                            
                                        </table>
                                    </div>
                                    <div class="responses">
                                        <div class="response">
                                        <p>Success Response:</p>
                                            <pre class="prettyprint">
                                                {
                                                    success: true,
                                                    data: {
                                                        id: 2413
                                                    }
                                                }
                                            </pre>
                                        </div>
                                    <div class="responses">
                                        <div class="response">
                                            <p>Failed response:</p>
                                            <pre class="prettyprint">
                                                {
                                                    success: false,
                                                    error: "Service not found"
                                                }
                                            </pre>
                                            
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="section-api">
                                <div class="section-api-header">
                                    <h3>Order status</h3>
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
                                           
                                                <tr>
                                                    <td>action</td>
                                                    <td>status</td>
                                                </tr>
                                           
                                                <tr>
                                                    <td>order_id</td>
                                                    <td>ID Pesanan</td>
                                                </tr>
                                            
                                        </table>
                                    </div>
                                    <div class="responses">
                                        <div class="response">
                                        <p>Success Response:</p>
                                            <pre class="prettyprint">
                                                {
                                                    success: true,
                                                    data: {
                                                        status: "Success",
                                                        start_count: 1320,
                                                        remains: 0,
                                                    }
                                                }
                                            </pre>
                                        </div>
                                    <div class="responses">
                                        <div class="response">
                                            <p>Failed response:</p>
                                            <pre class="prettyprint">
                                                {
                                                    success: false,
                                                    error: "API Key salah"
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
        </section>
</div>
@endsection