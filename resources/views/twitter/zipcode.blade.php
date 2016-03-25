@extends('layouts.app')
@section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.0/angular.min.js"></script>
    
    
@stop
@section('content')
<div class="container" ng-app="myApp">
    <div class="row" ng-controller="ZipcodeController">
        <div class="col-md-3">
            {!! Form::open(array('action' => 'AppController@zipcodesearch')) !!}            
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
                        <div class="col-md-6">
                            <select class="form-control" ng-model="country" name="country">
                              <option value="">--Select--</option>
                              <option value="US" selected>USA</option>
                              <option value="IN">India</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" name="zipcode" ng-model="zipcode" value="{{ old('zipcode') }}" placeholder="Zipcode" class="form-control">
                                <button class="btn-link" ng-click="searchPlace(zipcode, country)" type="button">Search Place</button>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <fieldset>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-8">
                            <select class="form-control" name="radius">
                                <option value="">Select Radius</option>
                                <?php 
                                    for($i= 1; $i<100; $i++){
                                        echo '<option value="' . $i . '">' . $i . '</option>';
                                    }
                                ?>
                              
                              
                            </select>
                            </div>
                            <div class="col-sm-4"><small for="">Miles</small></div>
                        </div>
                        
                        <input type="text" ng-model="lat" name="lat" value="<% lat %>" placeholder="lattitude" class="form-control" />
                        <input type="text" ng-model="lng" name="lng" value="<% lng %>" placeholder="longitude" class="form-control" />
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
                    <button type="button" class="btn btn-link pull-right" data-toggle="modal" data-target="#myModal">
                      Retweet
                    </button>
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Retweet Below </h4>
                              </div>
                              {!! Form::open(array('action' => array('AppController@retweet', $tweets->id))) !!}
                              <div class="modal-body">
                                <div class="form-group">
                                  <textarea class="form-control" name="retweet" placeholder="Type your message" rows="4" cols="50"></textarea>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Post Retweet</button>
                              </div>
                              {!! Form::close() !!}
                            </div><!-- /.modal-content -->
                          </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->
                  </li>
                  </a>
            </ul>      
             @endforeach
             
           @endif
        </div>
    </div>
</div>

<script type="text/javascript">
    var myApp = angular.module('myApp', [], function($interpolateProvider){
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
    });
        myApp.controller('ZipcodeController', ['$scope','$http', function($scope, $http) {
          $scope.lat = [];
          $scope.lng = [];
          var url = 'http://maps.googleapis.com/maps/api/geocode/json?';
          
          $scope.searchPlace = function(pincode, country){
            $http.get(url + 'address=' + pincode + '|country='+ country).success(function(data) {
              
              //console.log(data);
              //$scope.address = data.results[0].formatted_address;
              $scope.lat = data.results[0].geometry.location.lat;
              $scope.lng = data.results[0].geometry.location.lng;
              $scope.message = "successs";
            });
            
          }
        }]);  
        
    </script>
@endsection
