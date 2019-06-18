@extends('layouts.horizontal-developer')

@section('content')
<div class="container-fluid">
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0">Edit Provider</h4>
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
                            <h4 class='header-title mt-0'><span><i class="fas fa-edit"></i> Edit provider</span></h4>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="login-form">
                                <form method="POST">
                                    {{ csrf_field() }}
                                    @method('PUT')
                                    <input type="hidden" name="_method" value="PUT">
                                    <fieldset class="scheduler-border">
                                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                            <label for="name" class="control-label">Nama Provider</label>
                                            <input type="text"
                                                   class="form-control"
                                                   value="{{ $api->name }}"
                                                   data-validation="required"
                                                   id="name"
                                                   name="name">
                                            @if ($errors->has('name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <br>
                                        <div class="fieldset-outline">
                                            <h6>Order API</h6>
                                            <div class="form-group{{ $errors->has('order_end_point') ? ' has-error' : '' }}">
                                                <label for="order_end_point" class="control-label">API URL</label>
                                                <input type="text"
                                                       class="form-control"
                                                       value="{{ $api->order_end_point }}"
                                                       data-validation="url"
                                                       id="order_end_point"
                                                       name="order_end_point">
                                                @if ($errors->has('order_end_point'))
                                                    <span class="help-block">
                                                    <strong>{{ $errors->first('order_end_point') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                                                <label for="type" class="control-label">Tipe</label>
                                                <select class="form-control" name="type">
                                                    <option value="SOSMED" {{ ($api->type == 'SOSMED') ? 'selected' : '' }}>Sosial Media</option>
                                                    <option value="PULSA" {{ ($api->type == 'PULSA') ? 'selected' : '' }}>Pulsa</option>
                                                </select>
                                                @if ($errors->has('type'))
                                                    <span class="help-block">
                                                    <strong>{{ $errors->first('type') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="form-group{{ $errors->has('order_method') ? ' has-error' : '' }}">
                                                <label for="order_method" class="control-label">HTTP Method</label>
                                                <select class="form-control" style="width:auto" name="order_method" id="order_method">
                                                    <option value="POST" {{ ($api->order_method === "POST") ? 'selected' : '' }}>POST</option>
                                                    <option value="GET" {{ ($api->order_method === "GET") ? 'selected' : '' }}>GET</option>
                                                </select>
                                                @if ($errors->has('order_method'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('order_method') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group{{ $errors->has('order_request_body') ? ' has-error' : '' }}">
                                                <label for="order_request_body" class="control-label">Request Parameters</label>
                                                <table class="table table-bordered" id="tbl-order-request">
                                                    <thead>
                                                    <tr>
                                                        <th>Parameter</th>
                                                        <th>Parameter Type</th>
                                                        <th>Value</th>
                                                        <th>&nbsp;</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if( ! $apiRequestParams->isEmpty() )
                                                        @foreach($apiRequestParams as $row)

                                                            @if($row->api_type === "status")
                                                                @continue
                                                            @endif
                                                            <tr>
                                                                <td>
                                                                    <input type="text" name="order_key[]" value="{{ $row->param_key }}" class="form-control order-key" data-validation="required">
                                                                </td>
                                                                <td>
                                                                    <select name="order_key_type[]" class="form-control order-key-type" data-validation="required">
                                                                        <option value="table_column" {{ ($row->param_type === "table_column") ? 'selected' : '' }}>Order Column</option>
                                                                        <option value="custom" {{ ($row->param_type === "custom") ? 'selected' : '' }}>Custom Value</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    @if($row->param_type === "table_column")
                                                                        <select name="order_key_value[]" class="form-control order-key-value" data-validation="required">
                                                                            <optgroup label="Sosmed">
                                                                                <option value="id" {{ ($row->param_value ==='id') ? 'selected' : '' }} >id</option>
                                                                                <option value="target" {{ ($row->param_value ==='target') ? 'selected' : '' }} >link/target</option>
                                                                                <option value="price" {{ ($row->param_value ==='price') ? 'selected' : '' }}>price</option>
                                                                                <option value="package_id" {{ ($row->param_value ==='package_id') ? 'selected' : '' }}>package_id</option>
                                                                                <option value="start_counter" {{ ($row->param_value ==='start_counter') ? 'selected' : '' }}>start_counter</option>
                                                                                <option value="quantity" {{ ($row->param_value ==='quantity') ? 'selected' : '' }} >quantity</option>
                                                                                <option value="custom_comments" {{ ($row->param_value ==='custom_comments') ? 'selected' : '' }} >custom_comments</option>
                                                                                <option value="username" {{ ($row->param_value ==='username') ? 'selected' : '' }} >username (untuk like comment)</option>
                                                                            </optgroup>
                                                                            <optgroup label="Pulsa">
                                                                                <option value="portalpulsa_inquiry" {{ ($row->param_value =='portalpulsa_inquiry') ? 'selected' : '' }}>Portalpulsa Order Inquiry</option>
                                                                                <option value="portalpulsa_no" {{ ($row->param_value =='portalpulsa_no') ? 'selected' : '' }}>Portalpulsa no</option>
                                                                                <option value="portalpulsa_trxid" {{ ($row->param_value =='portalpulsa_trxid') ? 'selected' : '' }}>Portalpulsa trxid</option>
                                                                                <option value="nometer_pln" {{ ($row->param_value =='nometer_pln') ? 'selected' : '' }}>nometer_pln</option>
                                                                                <option value="service_id" {{ ($row->param_value =='service_id') ? 'selected' : '' }}>Service id</option>
                                                                                <option value="phone" {{ ($row->param_value =='phone') ? 'selected' : '' }}>target/phone</option>
                                                                            </optgroup>
                                                                        </select>
                                                                    @else
                                                                        <input type="text" class="form-control order-key-value" value="{{ $row->param_value }}" name="order_key_value[]" data-validation="required">
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <button
                                                                            type="button"
                                                                            class="btn btn-danger btn-sm order-key-remove">
                                                                        <span class="fas fa-trash"></span>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                    </tbody>
                                                    <tfoot>
                                                    <tr>
                                                        <td colspan="4">
                                                            <button
                                                                    type="button"
                                                                    class="btn btn-primary btn-sm order-key-add">
                                                                <span class="fas fa-plus"></span>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                                @if ($errors->has('order_key_value'))
                                                    <span class="help-block">
                                                    <strong>{{ $errors->first('order_key_value') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="form-group{{ $errors->has('order_request_body') ? ' has-error' : '' }}">
                                                <label for="order_request_body" class="control-label">Request Header (Opsional)</label>
                                                <table class="table table-bordered tbl-order-request">
                                                    <thead>
                                                    <tr>
                                                        <th>Parameter</th>  
                                                        <th>Value</th>
                                                        <th>&nbsp;</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if(!$apiRequestHeader->isEmpty())
                                                            @foreach($apiRequestHeader as $data_header)

                                                                @if($data_header->api_type === "order")
                                                                    <tr>
                                                                        <td>
                                                                            <input type="text" name="header_order_key[]" class="form-control order-key" value="{{ $data_header->header_key }}"></td>
                                                                        <td>
                                                                            <input type="text" class="form-control order-key-value" name="header_order_key_value[]" value="{{ $data_header->header_value }}">
                                                                        </td>
                                                                        <td>
                                                                            <button
                                                                                    type="button"
                                                                                    class="btn btn-danger btn-sm order-key-remove">
                                                                                <span class="fas fa-trash"></span>
                                                                            </button>
                                                                        </td>
                                                                    </tr>
                                                                @else
                                                                    @continue
                                                                @endif
                                                            @endforeach
                                                        @else

                                                        @endif
                                                    </tbody>
                                                    <tfoot>
                                                    <tr>
                                                        <td colspan="4">
                                                            <button
                                                                    type="button"
                                                                    class="btn btn-primary btn-sm order-key-add">
                                                                <span class="fas fa-plus"></span>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                                @if ($errors->has('order_key_value'))
                                                    <span class="help-block">
                                                    <strong>{{ $errors->first('order_key_value') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="form-group{{ $errors->has('order_success_response') ? ' has-error' : '' }}">
                                                <label for="order_success_response" class="control-label">Success Response</label>
                                                <br>
                                                <small>Validasi JSON Disini: <a rel="noopener noreferrer" href="https://jsonlint.com/" target="_new">https://jsonlint.com/</a></small>
                                                <textarea
                                                        class="form-control"
                                                        data-validation="required"
                                                        id="order_success_response"
                                                        style="height: 150px;"
                                                        name="order_success_response">{{ $api->order_success_response }}</textarea>
                                                @if ($errors->has('order_success_response'))
                                                    <span class="help-block">
                                                    <strong>{{ $errors->first('order_success_response') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="form-group{{ $errors->has('order_id_key') ? ' has-error' : '' }}">
                                                <label for="order_id_key" class="control-label">Order ID Key</label>
                                                <input type="text"
                                                       class="form-control"
                                                       value="{{ $api->order_id_key }}"
                                                       data-validation="required"
                                                       style="width:auto"
                                                       id="order_id_key"
                                                       name="order_id_key">
                                                @if ($errors->has('order_id_key'))
                                                    <span class="help-block">
                                                    <strong>{{ $errors->first('order_id_key') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <br>
                                        <div class="fieldset-outline">
                                            <h6>Order Status API</h6>
                                            <div class="form-group{{ $errors->has('end_point') ? ' has-error' : '' }}">
                                                <label for="status_end_point" class="control-label">API URL</label>
                                                <input type="text"
                                                       class="form-control"
                                                       value="{{ $api->status_end_point }}"
                                                       data-validation="url"
                                                       id="status_end_point"
                                                       name="status_end_point">
                                                @if ($errors->has('status_end_point'))
                                                    <span class="help-block">
                                                    <strong>{{ $errors->first('status_end_point') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="form-group{{ $errors->has('status_method') ? ' has-error' : '' }}">
                                                <label for="status_method" class="control-label">HTTP Method</label>
                                                <select class="form-control" style="width:auto" name="status_method" id="status_method">
                                                    <option value="POST" {{ ($api->status_method === "POST") ? 'selected' : '' }}>POST</option>
                                                    <option value="GET" {{ ($api->status_method === "GET") ? 'selected' : '' }}>GET</option>
                                                </select>
                                                @if ($errors->has('status_method'))
                                                    <span class="help-block">
                                                    <strong>{{ $errors->first('status_method') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="form-group{{ $errors->has('status_request_body') ? ' has-error' : '' }}">
                                                <label for="status_request_body" class="control-label">Request Parameter</label>
                                                <table class="table table-bordered" id="tbl-status-request">
                                                    <thead>
                                                    <tr>
                                                        <th>Parameter</th>
                                                        <th>Parameter Type</th>
                                                        <th>Value</th>
                                                        <th>&nbsp;</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if( ! $apiRequestParams->isEmpty() )
                                                        @foreach($apiRequestParams as $row)

                                                            @if($row->api_type === "order")
                                                                @continue
                                                            @endif
                                                            <tr>
                                                                <td>
                                                                    <input type="text" name="status_key[]" value="{{ $row->param_key }}" class="form-control status-key" data-validation="required">
                                                                </td>
                                                                <td>
                                                                    <select name="status_key_type[]" class="form-control status-key-type" data-validation="required">
                                                                        <option value="table_column" {{ ($row->param_type === "table_column") ? 'selected' : '' }}>Order Column</option>
                                                                        <option value="custom" {{ ($row->param_type === "custom") ? 'selected' : '' }}>Custom Value</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    @if($row->param_type === "table_column")
                                                                        <select name="status_key_value[]" class="form-control status-key-value" data-validation="required">
                                                                            <optgroup label="Sosmed">
                                                                                <option value="target" {{ ($row->param_value =='target') ? 'selected' : '' }}>target/link</option>
                                                                                <option value="price" {{ ($row->param_value =='price') ? 'selected' : '' }}>price</option>
                                                                                <option value="service_id" {{ ($row->param_value =='service_id') ? 'selected' : '' }}>service_id</option>
                                                                                <option value="quantity" {{ ($row->param_value =='quantity') ? 'selected' : '' }}>quantity</option>
                                                                                <option value="custom_comments" {{ ($row->param_value =='custom_comments') ? 'selected' : '' }}>custom_comments</option>
                                                                                <option value="username" {{ ($row->param_value =='username') ? 'selected' : '' }}>username (like_comment)</option>
                                                                            </optgroup>
                                                                            <optgroup label="Pulsa">
                                                                                <option value="portalpulsa_inquiry" {{ ($row->param_value =='portalpulsa_inquiry') ? 'selected' : '' }}>Portalpulsa Order Inquiry</option>
                                                                                <option value="portalpulsa_no" {{ ($row->param_value =='portalpulsa_no') ? 'selected' : '' }}>Portalpulsa no</option>
                                                                                <option value="portalpulsa_trxid" {{ ($row->param_value =='portalpulsa_trxid') ? 'selected' : '' }}>Portalpulsa trxid</option>
                                                                                <option value="nometer_pln" {{ ($row->param_value =='nometer_pln') ? 'selected' : '' }}>nometer_pln</option>
                                                                                <option value="service_id" {{ ($row->param_value =='service_id') ? 'selected' : '' }}>Service id</option>
                                                                                <option value="phone" {{ ($row->param_value =='phone') ? 'selected' : '' }}>target/phone</option>
                                                                            </optgroup>
                                                                        </select>
                                                                    @else
                                                                        <input type="text" class="form-control status-key-value" value="{{ $row->param_value }}" name="status_key_value[]" data-validation="required">
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <button
                                                                            type="button"
                                                                            class="btn btn-danger btn-sm status-key-remove">
                                                                        <span class="fas fa-trash"></span>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                    </tbody>
                                                    <tfoot>
                                                    <tr>
                                                        <td colspan="4">
                                                            <button
                                                                    type="button"
                                                                    class="btn btn-primary btn-sm status-key-add">
                                                                <span class="fas fa-plus"></span>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                                @if ($errors->has('status_key_value'))
                                                    <span class="help-block">
                                                    <strong>{{ $errors->first('status_key_value') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="form-group{{ $errors->has('order_request_body') ? ' has-error' : '' }}">
                                                <label for="order_request_body" class="control-label">Request Header (Opsional)</label>
                                                <table class="table table-bordered tbl-order-request">
                                                    <thead>
                                                    <tr>
                                                        <th>Parameter</th>  
                                                        <th>Value</th>
                                                        <th>&nbsp;</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    
                                                        @if(!$apiRequestHeader->isEmpty())
                                                            @foreach($apiRequestHeader as $data_header)
                                                                @if($data_header->api_type === "status")
                                                                    <tr>
                                                                        <td>
                                                                            <input type="text" name="header_status_key[]" class="form-control order-key" value="{{ $data_header->header_key }}"></td>
                                                                        <td>
                                                                            <input type="text" class="form-control order-key-value" name="header_status_key_value[]" value="{{ $data_header->header_value }}">
                                                                        </td>
                                                                        <td>
                                                                            <button
                                                                                    type="button"
                                                                                    class="btn btn-danger btn-sm order-key-remove">
                                                                                <span class="fas fa-trash"></span>
                                                                            </button>
                                                                        </td>
                                                                    </tr>
                                                                @else
                                                                    @continue
                                                                @endif
                                                            @endforeach 
                                                        @endif
                                                    </tbody>
                                                    <tfoot>
                                                    <tr>
                                                        <td colspan="4">
                                                            <button
                                                                    type="button"
                                                                    class="btn btn-primary btn-sm order-key-add">
                                                                <span class="fas fa-plus"></span>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                                @if ($errors->has('order_key_value'))
                                                    <span class="help-block">
                                                    <strong>{{ $errors->first('order_key_value') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="form-group{{ $errors->has('status_success_response') ? ' has-error' : '' }}">
                                                <label for="status_success_response" class="control-label">Success Response</label>
                                                <br>
                                                <small>Validasi JSON Disini: <a rel="noopener noreferrer" href="https://jsonlint.com/" target="_new">https://jsonlint.com/</a></small>
                                                <textarea
                                                        class="form-control"
                                                        data-validation="required"
                                                        id="status_success_response"
                                                        style="height: 150px;"
                                                        name="status_success_response">{{ $api->status_success_response }}</textarea>
                                                @if ($errors->has('status_success_response'))
                                                    <span class="help-block">
                                                    <strong>{{ $errors->first('status_success_response') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="form-group{{ $errors->has('start_counter_key') ? ' has-error' : '' }}">
                                                <label for="start_counter_key" class="control-label">Start Count Key</label>
                                                <input type="text"
                                                       class="form-control"
                                                       value="{{ $api->start_counter_key }}"
                                                       data-validation="required"
                                                       style="width:auto"
                                                       id="start_counter_key"
                                                       name="start_counter_key">
                                                @if ($errors->has('start_counter_key'))
                                                    <span class="help-block">
                                                    <strong>{{ $errors->first('start_counter_key') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="form-group{{ $errors->has('status_key_equal') ? ' has-error' : '' }}">
                                                <label for="status_key_equal" class="control-label">Status Key</label>
                                                <input type="text"
                                                       class="form-control"
                                                       value="{{ $api->status_key }}"
                                                       data-validation="required"
                                                       style="width:auto"
                                                       id="status_key_equal"
                                                       name="status_key_equal">
                                                @if ($errors->has('status_key_equal'))
                                                    <span class="help-block">
                                                    <strong>{{ $errors->first('status_key_equal') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="form-group{{ $errors->has('remains_key') ? ' has-error' : '' }}">
                                                <label for="remains_key" class="control-label">Remains Key</label>
                                                <input type="text"
                                                       class="form-control"
                                                       value="{{ $api->remains_key }}"
                                                       data-validation="required"
                                                       style="width:auto"
                                                       id="remains_key"
                                                       name="remains_key">
                                                @if ($errors->has('remains_key'))
                                                    <span class="help-block">
                                                    <strong>{{ $errors->first('remains_key') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="process_all_order" class="control-label">Auto Refund</label>
                                            
                                                <select
                                                        class="form-control"
                                                        data-validation="required"
                                                        style="width:auto"
                                                        id="process_all_order"
                                                        name="process_all_order">
                                                    <option
                                                            value="1"
                                                            {{ $api->process_all_order == '1' ? 'selected' : '' }}>Yes
                                                    </option>
                                                    <option
                                                            value="0"
                                                            {{ $api->process_all_order  == '0' ? 'selected' : '' }}>No
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                          <div class="mr-3 form-group text-right">
                                            <button type="submit" class="btn btn-primary">Edit</button>
                                          </div>    
                                    </fieldset>
                                </form>
                            </div>
                              
                          </div>
                </div>
              </div>
            </div>
            
          </div>
        </div></div>
</div>
@endsection

@push('scripts')
<script>
    var tableColumns = '<select name="order_key_value[]" class="form-control order-key-value" data-validation="required">' +
        '<optgroup label="Sosmed">'+
                '<option value="target">target/link/target</option>'+
                '<option value="price">price</option>'+
                '<option value="service_id">service_id</option>'+
                '<option value="quantity">quantity</option>'+
                '<option value="custom_comments">custom_comments</option>'+
                '<option value="username">username (like_comment)</option>'+
            '</optgroup>'+
            '<optgroup label="Pulsa">'+
                '<option value="portalpulsa_inquiry">Portalpulsa Inquiry</option>'+
                '<option value="portalpulsa_no">Portalpulsa no</option>'+
                '<option value="portalpulsa_trxid">Portalpulsa trxid</option>'+
                '<option value="nometer_pln">nometer_pln</option>'+
                '<option value="service_id">Service id</option>'+
                '<option value="phone">target/phone</option>'+
            '</optgroup>' +
        '</select>';
    var custom = '<input type="text" class="form-control order-key-value" name="order_key_value[]" data-validation="required">';

    $(function () {
        $('.order-key-remove').on('click', function () {
                $(this).parents('tr').remove();
            
        });
        $('.order-key-add').on('click', function () {
            var tr = $(this).parent('td').parent('tr').parent('tfoot').parent('table').find('tbody tr:last').clone(true, true);
            tr.find('input').val('');

            // Making select box selected
            $(tr).find(".order-key-type").val($('.tbl-order-request tbody tr:last').find(".order-key-type").val());


            $(tr).appendTo($(this).parent('td').parent('tr').parent('tfoot').parent('table').find('tbody'));
        });

        $('.order-key-type').on('change', function () {
            var v = $(this).val();
            td = $(this).parents('td').siblings().eq(1);

            if (v === "table_column") {
                td.html(tableColumns);
            } else {
                td.html(custom);
            }
        });


        var tableColumnsStatus = '<select name="status_key_value[]" class="form-control status-key-value" data-validation="required">' +
            '<optgroup label="Sosmed">'+
                '<option value="id">order id</option>' +
                '<option value="target">link/target</option>' +
                '<option value="price">price</option>' +
                '<option value="service_id">service_id</option>' +
                '<option value="start_counter">start_counter</option>' +
                '<option value="quantity">quantity</option>' +
                '<option value="custom_comments">custom_data</option>' +
            '</optgroup>'+
           '<optgroup label="Pulsa">'+
                '<option value="portalpulsa_inquiry">Portalpulsa Inquiry</option>'+
                '<option value="portalpulsa_no">Portalpulsa no</option>'+
                '<option value="portalpulsa_trxid">Portalpulsa trxid</option>'+
                '<option value="nometer_pln">nometer_pln</option>'+
                '<option value="service_id">Service id</option>'+
                '<option value="phone">target/phone</option>'+
            '</optgroup>' +
            '</select>';
        var customStatus = '<input type="text" class="form-control status-key-value" name="status_key_value[]" data-validation="required">';

        $('.status-key-remove').on('click', function () {
            if ($('#tbl-status-request > tbody tr').length > 1) {
                $(this).parents('tr').remove();
            }
        });

        $('.status-key-add').on('click', function () {
            var tr = $('#tbl-status-request tbody tr:last').clone(true, true);
            tr.find('input').val('');

            // Making select box selected
            $(tr).find(".status-key-type").val($('#tbl-status-request tbody tr:last').find(".status-key-type").val());


            $(tr).appendTo('#tbl-status-request > tbody');
        });

        $('.status-key-type').on('change', function () {
            var v = $(this).val();
            td = $(this).parents('td').siblings().eq(1);

            if (v === "table_column") {
                td.html(tableColumnsStatus);
            } else {
                td.html(customStatus);
            }
        });

    });
</script>
@endpush