@extends('layouts.app')
@section('scripts')

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.0/angular.min.js"></script>

@stop
@section('content')
<div class="container">
    <div class="row">
        {!! Form::open(array('route' => array('retweet', 1234566))) !!}
        <div class="col-md-3">
            <h4>Dataset</h4>
            <ul class="list-group">
                <li class="list-group-item">
                    @if($filename)
                    <input type="checkbox" name="{{ $filename }}" required />
                    &nbsp; <a href="#">{{ $filename }}</a> 
                    @endif
                </li>
            </ul>
        </div>
        <div class="col-md-9">  
            <div class="row">
                <div class="col-md-8">
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                    <h4>Mass Retweet</h4>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-8">
                                    <textarea name="tweet_text" class="form-control" rows="6" cols="50" placeholder="Tweet here..."></textarea>
                                </div>
                                <div class="col-md-4">
                                    <p>Selet the dataset and write tweet to post mass retweet..</p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    {{ Form::submit('Retweet', array('class' => 'btn btn-primary')) }}
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
                <div class="col-md-4">
                    
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection

@section('footer')
<script type='text/javascript' src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

@stop
