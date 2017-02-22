'use strict';

// Declare app level module which depends on views, and components
angular.module('iBlis', [
  'ngRoute',
  'reports'
]).
config(['$locationProvider', '$routeProvider','$interpolateProvider', function($locationProvider, $routeProvider,$interpolateProvider) {
  $locationProvider.hashPrefix('!');
  $interpolateProvider.startSymbol('<%');
  $interpolateProvider.endSymbol('%>');
}]);