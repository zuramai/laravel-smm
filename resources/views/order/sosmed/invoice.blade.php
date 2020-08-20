@extends('layouts.horizontal')
@section('content')

<div class="container-fluid">

    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box d-print-none">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0">Invoice</h4>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <!-- end page title end breadcrumb -->

    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body">

                    <div class="row">
                        <div class="col-12">
                            <div class="invoice-title">
                                <h4 class="float-right font-16"><strong>Order #{{ $order->id }}</strong></h4>
                                <h3 class="m-t-0">
                                    <img src="{{asset(config('web_config')['WEB_LOGO_URL_DARK'])}}" alt="logo" height="28"/>
                                </h3>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <address>
                                        <strong>Ditagih ke:</strong><br>
                                        {{$order->user->name}}<br>
                                        {{$order->user->phone}}<br>
                                    </address>
                                </div>
                                <div class="col-6  text-right">
                                    <address>
                                        <strong>Tanggal Order:</strong><br>
                                        {{ date('F d, Y', strtotime($order->created_at)) }}<br><br>
                                    </address>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 m-t-30">
                                    <address>
                                        <strong>Pembayaran:</strong><br>
                                        Saldo {{ config('web_config')['APP_NAME'] }}<br>
                                    </address>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="panel panel-default">
                                <div class="p-2">
                                    <h3 class="panel-title font-20"><strong>Ringkasan Order</strong></h3>
                                </div>
                                <div class="">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <td><strong>Layanan</strong></td>
                                                <td class="text-center"><strong>Jumlah</strong>
                                                </td>
                                                <td class="text-center"><strong>Harga/1000</strong></td>
                                                <td class="text-right"><strong>Total</strong></td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                            <tr>
                                                <td>{{$order->service->name}}</td>
                                                <td class="text-center">{{ Numberize::make($order->quantity) }}</td>
                                                <td class="text-center">{{ config('web_config')['CURRENCY_CODE'] }} {{Numberize::make( ($order->place_from=='WEB'?$order->service->price:$order->service->price_oper)+$order->service->keuntungan)}}</td>
                                                <td class="text-right">{{ config('web_config')['CURRENCY_CODE'] }} {{ Numberize::make($order->price,2) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="no-line"></td>
                                                <td class="no-line"></td>
                                                <td class="no-line text-center">
                                                    <strong>Total</strong></td>
                                                <td class="no-line text-right"><h4 class="m-0">{{ config('web_config')['CURRENCY_CODE'] }} {{ Numberize::make($order->price) }}</h4></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="d-print-none mo-mt-2">
                                        <div class="float-right">
                                            <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light"><i class="fa fa-print"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div> <!-- end row -->

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->


</div> <!-- end container-fluid -->
@endsection