"use strict";

var app = angular.module("pokomon", ["ngRoute", "ngResource"]);

app.config(function($routeProvider) {
    $routeProvider
        .when("/page/:id", {
            templateUrl : function(page){
                return "assets/page-"+page.id+".html"
            },
            controller: "pagesController"
        })
        .otherwise("/page/0");
})
    .controller("pagesController",function($scope, $routeParams){
        $scope.page=parseInt($routeParams.id) || 0;
    })
    .controller("userController", function($scope, $http){
        $http.get('?controller=user')
            .success(function(response){
                $scope.users = response;
            })
    })
    .factory('scoreService', function() {
        var score = 0;
        function setScore(scoreVal) {
            score = scoreVal;
        }
        function getScore() {
            return score;
        }
    })
    .controller("gameController", function($scope, $http, $location, $window, scoreService){
        $scope.lvl = -1;
        $scope.pokemons = null;
        $http.get('/?controller=pokemon')
            .success(function(response) {
                $scope.pokemons = response;
            });
        $scope.postScore = function() {
            if (typeof ($scope.username) == "undefined" || $scope.username == "")
                $window.alert("Please enter your name!");
            else
                $http.post('/?controller=user', {name: $scope.username, score: scoreService.getScore()})
                    .success(function() {
                        $location.path('#/page/2');
                    });
        }
    })
    .directive("pokomon", function(scoreService) {
        return {
            templateUrl:"assets/directives/pokomon.html",
            replace: true,
            restrict: 'E',
            controller: function($scope, $interval) {
                $scope.ballPos={'X':0,'Y':0};
                var tictac, tic = 0, startTime;
                // score ~= (pokemon.power * (5сек - врем€ лика))
                $scope.start=function(){
                    startTime = Date.now();
                    tictac=$interval(function(){
                        var finishTime = parseInt(5 - (Date.now() - startTime)/1000);
                        if (finishTime <= 0) {
                            finish();
                        }
                        lvlup(finishTime);
                        tic++;
                        $scope.ballPos.X=50*Math.sin(tic/50);
                        $scope.ballPos.Y=20*Math.cos(tic/20);
                    },50);
                };

                $scope.lvlup = function(finishTime) {
                    lvl++;
                    if ($scope.lvl >= pokemons.length) {
                        finish();
                    } else {
                        $http.get('/?controller=pokemon&id=' + lvl.toString())
                            .success(function (response) {
                                $scope.curPokomon = response;
                            });
                        scoreService.setScore(scoreService.getScore() + $scope.curPokomon.power * finishTime);
                    }
                };

                $scope.catchPokomon = function() {
                    lvlup();
                };

                $scope.finish = function($location) {
                    $location.path('#/page/4');
                };

                $scope.stop=function() {
                    $interval.cancel(tictac);
                };
            }
        }
    })
    .directive("menu", function(){
        return {
            templateUrl:"assets/directives/menu.html",
            replace: true,
            restrict: 'E',
            controller: function($scope, $http, $routeParams) {
                $scope.page=parseInt($routeParams.id) || 0;
                $http.get('/?controller=menu')
                    .success(function(response){
                        $scope.menu = response;
                    })
            }
        }
    });