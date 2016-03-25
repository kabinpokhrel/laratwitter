@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-offset-3 col-md-8">
            {!! Form::open(array('action' => 'AppController@search', 'class' => 'form-inline')) !!}
              <div class="form-group">
                <input type="text" name="query" value="{{ old('query') }}" autofocus placeholder="Search Keywords" class="form-control">
              </div>
              <div class="form-group">
                <input type="text" name="count" value="{{ old('count') }}" placeholder="limit count" class="form-control">
              </div>
              <button type="submit" class="btn btn-primary">Search</button>
            {!! Form::close() !!}
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
           @if(! empty($results))
             
             @foreach($results->statuses as $tweets)
             <ul class="list-group">
                 <a href="{!! Twitter::linkTweet($tweets) !!}">
                  <li class="list-group-item">
                      {!! Twitter::linkify($tweets->text) !!}
                      <br />
                      <small class="text-danger">{!! Twitter::ago($tweets->created_at) !!}</small>
                  </li>
                  </a>
            </ul>      
             @endforeach
             
           @endif
        </div>
    </div>
</div>
@endsection
