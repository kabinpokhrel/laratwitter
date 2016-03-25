@extends('layouts.app')
@section('scripts')
<link rel="stylesheet" href="{{ asset('css/terminal.css') }}" type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.0/angular.min.js"></script>


@stop
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <h4>Location</h4>
        </div>
        <div class="col-md-9">  
            <div class="row">
                <div class="col-md-8">
                    <h4>Terminal</h4>
                </div>
                <div class="col-md-4"></div>
            </div>
            <div id="term_stream" class="terminal" style="height=200px;"></div>
        </div>
    </div>
</div>
@endsection

@section('footer')
<script type='text/javascript' src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="{{ asset('js/terminal.js') }}"></script>
<script type="text/javascript">
$(function($, undefined) {
    $('#term_stream').terminal(function(command, term) {
        
        if (command !== '') {
            try {
                var result = window.eval(command);
                if (result !== undefined) {
                    term.echo(new String(result));
                }
                if (command == 'test') {
                    term.echo("you just typed 'test'");
                }
            } catch(e) {
                term.error(new String(e));
            }
        } else {
          term.echo('');
        }
    }, 
    {
        greetings: 'Streaming Interpreter',
        name: 'js_demo',
        height: 200,
        width: 580,
        prompt: 'twitter> '});
});

</script>
@stop
