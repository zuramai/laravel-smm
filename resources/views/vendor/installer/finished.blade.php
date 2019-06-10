@extends('vendor.installer.layouts.master')

@section('template_title')
    {{ trans('installer_messages.final.templateTitle') }}
@endsection

@section('title')
    <i class="fa fa-flag-checkered fa-fw" aria-hidden="true"></i>
    {{ trans('installer_messages.final.title') }}
@endsection

@section('container')

	@if(session('message')['dbOutputLog'])
		<p><strong><small>{{ trans('installer_messages.final.migration') }}</small></strong></p>
		<pre><code>{{ session('message')['dbOutputLog'] }}</code></pre>
	@endif

	<b>Buat akun admin baru</b>
	<form method="POST">
		@csrf
		<div class="form-group">
			<label>Nama</label>
			<input type="text" name="name" class="form-control">
		</div>
		<div class="form-group">
			<label>Username</label>
			<input type="text" name="username" class="form-control">
		</div>
		<div class="form-group">
			<label>Email</label>
			<input type="email" name="email" class="form-control">
		</div>
		<div class="form-group">
			<label>Password</label>
			<input type="password" name="password" class="form-control">
		</div>
		<div class="form-group">
			<label>No HP</label>
			<input type="text" name="phone" class="form-control">
		</div>
		<div class="form-group">
			<label>Saldo</label>
			<input type="text" name="balance" class="form-control">
		</div>
	    <div class="buttons">
	        <button type="submit"  class="button">Submit</button>
	    </div>
	</form>

@endsection
