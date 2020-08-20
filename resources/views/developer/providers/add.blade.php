@extends('layouts.horizontal-developer')

@section('content')
<div class="container-fluid">
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0">Tambah Provider</h4>
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
                            <h4 class='header-title mt-0'><span>Tambah provider baru</span></h4>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                                <form role="form" method="POST">
                                    {{ csrf_field() }}
                                    <fieldset class="scheduler-border">
                                        
                                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                            <label for="name" class="control-label">Nama Provider</label>
                                            <input type="text"
                                                   class="form-control"
                                                   value="{{ old('name') }}"
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
                                                       value="{{ old('order_end_point') }}"
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
                                                    <option value="SOSMED">Sosial Media</option>
                                                    <option value="PULSA">Pulsa</option>
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
                                                    <option value="POST">POST</option>
                                                    <option value="GET">GET</option>
                                                </select>
                                                @if ($errors->has('order_method'))
                                                    <span class="help-block">
                                                    <strong>{{ $errors->first('order_method') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="form-group{{ $errors->has('order_request_body') ? ' has-error' : '' }}">
                                                <label for="order_request_body" class="control-label">Request Parameter</label>
                                                <table class="table table-bordered tbl-order-request">
                                                    <thead>
                                                    <tr>
                                                        <th>Parameter</th>
                                                        <th>Parameter Type</th>
                                                        <th>Value</th>
                                                        <th>&nbsp;</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td><input type="text" name="order_key[]" class="form-control order-key" data-validation="required"></td>
                                                        <td>
                                                            <select name="order_key_type[]" class="form-control order-key-type" data-validation="required">
                                                                <option value="table_column" selected>Order Column</option>
                                                                <option value="custom">Custom Value</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select name="order_key_value[]" class="form-control order-key-value" data-validation="required">
                                                                <optgroup label="Sosmed">
                                                                    <option value="target">target/link</option>
                                                                    <option value="price">price</option>
                                                                    <option value="service_id">service_id</option>
                                                                    <option value="quantity">quantity</option>
                                                                    <option value="custom_comments">custom_comments</option>
                                                                    <option value="username">username (like_comment)</option>
                                                                </optgroup>
                                                                <optgroup label="Pulsa">
                                                                    <option value="portalpulsa_inquiry">Portalpulsa Inquiry</option>
                                                                    <option value="portalpulsa_no">Portalpulsa no</option>
                                                                    <option value="portalpulsa_trxid">Portalpulsa trxid</option>
                                                                    <option value="nometer_pln">nometer_pln</option>
                                                                    <option value="service_id">service_id</option>
                                                                    <option value="phone">target/phone</option>
                                                                </optgroup>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <button
                                                                    type="button"
                                                                    class="btn btn-danger btn-sm order-key-remove">
                                                                <span class="fas fa-trash"></span>
                                                            </button>
                                                        </td>
                                                    </tr>
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
                                                    <tr>
                                                        <td><input type="text" name="header_order_key[]" class="form-control order-key" ></td>
                                                        <td>
                                                            <input type="text" class="form-control order-key-value" name="header_order_key_value[]">
                                                        </td>
                                                        <td>
                                                            <button
                                                                    type="button"
                                                                    class="btn btn-danger btn-sm order-key-remove">
                                                                <span class="fas fa-trash"></span>
                                                            </button>
                                                        </td>
                                                    </tr>
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
                                                <label for="order_success_response" class="control-label">Response Sukses</label>
                                                <br>
                                                <small>Validasi JSON disini: <a rel="noopener noreferrer" href="https://jsonlint.com/" target="_new">https://jsonlint.com/</a></small>
                                                <textarea
                                                        class="form-control"
                                                        data-validation="required"
                                                        id="order_success_response"
                                                        style="height: 150px;"
                                                        name="order_success_response">{{ old('order_success_response') }}</textarea>
                                                @if ($errors->has('order_success_response'))
                                                    <span class="help-block">
                                                    <strong>{{ $errors->first('order_success_response') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="form-group{{ $errors->has('order_id_key') ? ' has-error' : '' }}">
                                                <label for="order_id_key" class="control-label">Order ID key</label>
                                                <input type="text"
                                                       class="form-control"
                                                       value="order"
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
                                        <br>
                                        <div class="fieldset-outline">
                                            <h6>Status API</h6>
                                            <div class="form-group{{ $errors->has('end_point') ? ' has-error' : '' }}">
                                                <label for="status_end_point" class="control-label">API URL</label>
                                                <input type="text"
                                                       class="form-control"
                                                       value="{{ old('status_end_point') }}"
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
                                                    <option value="POST">POST</option>
                                                    <option value="GET">GET</option>
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
                                                    <tr>
                                                        <td><input type="text" name="status_key[]" class="form-control status-key" data-validation="required"></td>
                                                        <td>
                                                            <select name="status_key_type[]" class="form-control status-key-type" data-validation="required">
                                                                <option value="table_column">Order Column</option>
                                                                <option value="custom">Custom Value</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select name="status_key_value[]" class="form-control order-key-value" data-validation="required">
                                                                <optgroup label="Sosmed">
                                                                    <option value="id">order_id</option>
                                                                    <option value="target">target/link</option>
                                                                    <option value="price">price</option>
                                                                    <option value="service_id">service_id</option>
                                                                    <option value="quantity">quantity</option>
                                                                    <option value="custom_comments">custom_comments</option>
                                                                    <option value="username">username (like_comment)</option>
                                                                </optgroup>
                                                                <optgroup label="Pulsa">
                                                                    <option value="id">order_id</option>
                                                                    <option value="portalpulsa_inquiry">Portalpulsa Order Inquiry</option>
                                                                    <option value="portalpulsa_no">Portalpulsa no</option>
                                                                    <option value="portalpulsa_trxid">Portalpulsa trxid</option>
                                                                    <option value="nometer_pln">nometer_pln</option>
                                                                    <option value="service_id">Service id</option>
                                                                    <option value="phone">target/phone</option>
                                                                </optgroup>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <button
                                                                    type="button"
                                                                    class="btn btn-danger btn-sm status-key-remove">
                                                                <span class="fas fa-trash"></span>
                                                            </button>
                                                        </td>
                                                    </tr>
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
                                                    <tr>
                                                        <td><input type="text" name="header_status_key[]" class="form-control order-key" ></td>
                                                        <td>
                                                            <input type="text" class="form-control order-key-value" name="header_status_key_value[]">
                                                        </td>
                                                        <td>
                                                            <button
                                                                    type="button"
                                                                    class="btn btn-danger btn-sm order-key-remove">
                                                                <span class="fas fa-trash"></span>
                                                            </button>
                                                        </td>
                                                    </tr>
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
                                                <label for="status_success_response" class="control-label">Success Response (JSON)</label>
                                                <br>
                                                <small>Validasi JSON Disini: <a rel="noopener noreferrer" href="https://jsonlint.com/" target="_new">https://jsonlint.com/</a></small>
                                                <textarea
                                                        class="form-control"
                                                        data-validation="required"
                                                        id="status_success_response"
                                                        style="height: 150px;"
                                                        name="status_success_response">{{ old('status_success_response') }}</textarea>
                                                @if ($errors->has('status_success_response'))
                                                    <span class="help-block">
                                                    <strong>{{ $errors->first('status_success_response') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="form-group{{ $errors->has('start_counter_key') ? ' has-error' : '' }}">
                                                <label for="start_counter_key" class="control-label">Sosmed: Start Count Key | Pulsa: SN Key</label>
                                                <input type="text"
                                                       class="form-control"
                                                       value="start_count"
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
                                            <div class="form-group{{ $errors->has('status_key') ? ' has-error' : '' }}">
                                                <label for="status_key_equal" class="control-label">Status Key</label>
                                                <input type="text"
                                                       class="form-control"
                                                       value="status"
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
                                                <label for="remains_key" class="control-label">Sosmed: Remains Key | Pulsa: Note key (opsional)</label>
                                                <input type="text"
                                                       class="form-control"
                                                       value="remains"
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
                                                            {{ old('process_all_order') == '1' ? 'selected' : '' }}>Yes
                                                    </option>
                                                    <option
                                                            value="0"
                                                            {{ old('process_all_order') == '0' ? 'selected' : '' }}>No
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </fieldset>
                                      <div class="mr-3 form-group text-right">
                                        <button type="submit" class="btn btn-primary">Tambah</button>
                                      </div>    
                                </form>
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
                '<option value="target">target/link</option>'+
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
            if ($('.tbl-order-request > tbody tr').length > 1) {
                $(this).parents('tr').remove();
            }
        });

        $('.order-key-add').on('click', function () {
            var tr = $(this).parent('td').parent('tr').parent('tfoot').parent('table').find('tbody tr:last').clone(true, true);
            tr.find('input').val('');
            
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