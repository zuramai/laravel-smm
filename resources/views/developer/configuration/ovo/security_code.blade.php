@extends('layouts.auth')
@section('content')
<div class="container text-center">
	<h3 class="mb-2">Login OVO</h3>
	<br>
	<div class="row">
		<div class="col-md-4 offset-md-4">
                @if ($errors->any())
                    <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                    </div>
                @endif
			<form method="POST">
				@csrf
				<div class="form-group row">
					<label class="col-md-4 col-form-label">PIN OVO: </label>
					<input type="text" name="pin" class="form-control col-md-8">
				</div>
				<button class="btn btn-primary btn-sm float-right">Submit</button>
			</form>
		</div>
	</div>
</div>
@endsection