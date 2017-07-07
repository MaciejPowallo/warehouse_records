@extends('welcome')
@section('content')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default ">
                <div class="alert alert-danger">
                    <i class="fa fa-exclamation-triangle fa-2x" aria-hidden="true"></i>
                        Nie posiadasz uprawnień do wykonania tej operacji !!!
                </div>

                <div class="panel-body text-center">
                    <a href="{{ URL::asset('index.php') }}">
                    	<img src="{{asset('images/error.jpg')}}" alt="" style="margin: auto" class="img-responsive logo">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection





