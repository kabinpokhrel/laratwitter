@extends('layouts.app')
@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.0/angular.min.js"></script>
<style type="text/css">
  html, body, #map-canvas  {
  margin: 0;
  padding: 0;
  height: 100%;
}

#map {
  width:500px;
  height:480px;
}
</style>
  
    
@stop
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            {!! Form::open(array('action' => 'AppController@mapsearched')) !!}            
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="text" name="query" value="{{ old('query') }}" autofocus placeholder="Search Keywords" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="text" name="count" value="{{ old('count') }}" placeholder="limit count" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <fieldset>
                        <legend>Location</legend>
                        
                    </fieldset>
                </div>
                <fieldset>
                    <div class="form-group">
                        <button type="button" class="btn btn-link btn-block btn-lg" data-toggle="modal" data-target="#myMapModal">
                          <i class="fa fa-map"></i> Map
                        </button>
                          <div class="modal fade" id="myMapModal">
                              <div class="modal-dialog">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                           <h4 class="modal-title">Map Location</h4>
                          
                                      </div>
                                      <div class="modal-body">
                                          <div class="container">
                                              <div class="row">
                                                  <div id="map" class=""></div>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                          <button type="button" class="btn btn-primary" data-dismiss="modal">Okay!</button>
                                      </div>
                                  </div>
                                  <!-- /.modal-content -->
                              </div>
                              <!-- /.modal-dialog -->
                              </div>
                              <!-- /.modal -->
                    </div>
                    <div class="form-group">
                        <input type="text" name="ne" id="ne" value="" placeholder="lat, lng" class="form-control" />
                        <input type="text" name="se" id="se" value="" placeholder="lat, lng" class="form-control" />
                        <input type="text" name="sw" id="sw" value="" placeholder="lat, lng" class="form-control" />
                        <input type="text" name="nw" id="nw" value="" placeholder="lat, lng" class="form-control" />
                    </div>
                </fieldset>
                <fieldset>
                    <button type="submit" class="btn btn-primary btn-block">Search</button>
                </fieldset>
            {!! Form::close() !!}
        </div>
        
        
        <div class="col-md-9">  
        
           @if(!empty($results))
             
             @foreach($results->statuses as $tweets)
             <ul class="list-group">
                 <a href="{!! Twitter::linkTweet($tweets) !!}">
                  <li class="list-group-item">
                      {!! Twitter::linkify($tweets->text) !!}
                      <br />
                      <small class="text-danger">{!! Twitter::ago($tweets->created_at) !!}</small>
                    <button type="button" class="btn btn-link pull-right" data-toggle="modal" data-target="#myMapModal">
                      Retweet
                    </button>
                      <div class="modal fade" id="myMapModal">
                          <div class="modal-dialog">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                       <h4 class="modal-title">Select Location</h4>
                      
                                  </div>
                                  <div class="modal-body">
                                      <div class="container">
                                          <div class="row">
                                              <div id="map" class=""></div>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="modal-footer">
                                      <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
                                  </div>
                                  
                              </div>
                              <!-- /.modal-content -->
                          </div>
                          <!-- /.modal-dialog -->
                          </div>
                          <!-- /.modal -->
                  </li>
                  </a>
            </ul>      
             @endforeach
             
           @endif
        </div>
    </div>
</div>
@endsection

@section('footer')
<script type='text/javascript' src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyADHM2F0LHf0g-Z_Uy_BTb6z5Nce7eSrnU&callback=initMap">
    </script>
<script type="text/javascript">

var map;  
// This example adds a user-editable rectangle to the map.
  function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
      center: {lat: 44.5452, lng: -78.5389},
      zoom: 9
    });

    var bounds = {
      north: 44.599,
      south: 44.490,
      east: -78.443,
      west: -78.649
    };

    // Define a rectangle and set its editable property to true.
    var rectangle = new google.maps.Rectangle({
      bounds: bounds,
      draggable: true,
      editable: true
    });
    rectangle.setMap(map);
    
    google.maps.event.addListener(rectangle, "bounds_changed", function() {
       handleBounds(rectangle.getBounds());
    });
  }
  
    $("#myMapModal").on("shown", function() {
        
    new map.setCenter(new google.maps.LatLng(54, -2));
    new google.maps.event.trigger(map, 'resize');
    });
    
    function handleBounds(bounds){
        var NE = bounds.getNorthEast();
        var SW = bounds.getSouthWest();
        var NW = new google.maps.LatLng(NE.lat(),SW.lng());
        var SE = new google.maps.LatLng(SW.lat(),NE.lng());
        $('#ne').val(NE.lat() + ', ' + NE.lng());
        $('#se').val(SE.lat() + ', ' + SE.lng());
        $('#sw').val(SW.lat() + ', ' + SW.lng());
        $('#nw').val(NW.lat() + ', ' + NW.lng());
        var newBounds = new google.maps.LatLngBounds(SW,NE);
        map.fitBounds(newBounds);
    }

</script>
@stop
