"use strict";

var app = angular.module("game", ["ngRoute", "ngResource"]);

app.config(function($routeProvider) {
    $routeProvider
        .when("/toplist", {
            templateUrl : function() {
                return "assets/page-2.html";
            },
            controller: "userController"
        })
        .when("/game", {
            templateUrl : "assets/page-3.html",
            controller: 'gameController'
        })
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
            }
        )
    })
    .factory('scoreService', function() {
        var score = 0;
        function setScore(scoreVal) {
            score = scoreVal;
        }
        function getScore() {
            return score;
        }
        return {
            setScore: setScore,
            getScore: getScore
        }
    })
    .controller("gameController", function($scope, $http, $location, $window, scoreService){
        $scope.lvl = 0;
        $scope.pokemons = null;
        $scope.scoreService = scoreService;
        $scope.showButtonMove = true;
        $http.get('/?controller=pokemon')
            .success(function(response) {
                $scope.pokemons = response;
            });

        $scope.start = function() {
            $scope.$emit('startMoving');
        };

        $scope.$on('finish', function() {
            $scope.gameGone = false;
            $scope.showButtonMove = true;
            $location.path('/page/4');
        });

        $scope.postScore = function() {
            if (typeof ($scope.username) == "undefined" || $scope.username == "")
                $window.alert("Please enter your name!");
            else {
                $http.post('/?controller=user', {
                        "name": $scope.username,
                        "score": $scope.scoreService.getScore()
                })
                    .success(function () {
                        $scope.scoreService.setScore(0);
                        $location.path('/toplist');
                    }
                );
            }
        }
    })
    .directive("pokomon", function() {
        return {
            templateUrl:"assets/directives/pokomon.html",
            replace: true,
            restrict: 'E',
            controller: function($scope, $interval, $location, $http, scoreService, $window) {
                $scope.gameGone = false;
                $scope.ballPos={'X':0,'Y':0};
                var tictac, tic = 0;
                $scope.startTime = 0;
                $http.get('/?controller=pokemon&id=0')
                    .success(function(response) {
                        $scope.curPokomon = response;
                    }
                )
                // score ~= (pokemon.power * (5сек - врем€ лика))
                $scope.$on('startMoving', function(event) {
                    $scope.gameGone = true;
                    $scope.showButtonMove = false;
                    $scope.startTime = Date.now();
                    tictac=$interval(function(){ //todo POKOMON IS NOT MOVING
                        var finishTime = parseInt(5 - (Date.now() - $scope.startTime)/1000);
                        if (finishTime <= 0) {
                            $scope.$emit('finish');
                        }
                        tic++;
                        $scope.ballPos.X=50*Math.sin(tic/50);
                        $scope.ballPos.Y=20*Math.cos(tic/20);
                    }, 50);
                });

                $scope.lvlup = function() {
                    $scope.lvl++;
                    if ($scope.lvl >= $scope.pokemons.length) {
                        $scope.$emit('finish');
                    } else {
                        $scope.curPokomon = $scope.pokemons[$scope.lvl];
                    }
                    $scope.stop();
                    $scope.startTime = Date.now();
                    $scope.$emit('startMoving');
                };

                $scope.catchPokomon = function() {
                    var finishTime = parseInt(5 - (Date.now() - $scope.startTime)/1000);
                    if (finishTime <= 0) {
                        $scope.$emit('finish');
                    }
                    var newScore = parseInt($scope.curPokomon.power) * parseInt(finishTime);
                    if (newScore >= 0)
                        $scope.scoreService.setScore(parseInt($scope.scoreService.getScore()) + newScore);
                    $scope.lvlup();
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
                    }
                )
            }
        }
    });