<!DOCTYPE HTML>
<html ng-app="game">
<head>
    <meta charset="utf-8">
    <title>Chinpokomon the game web-app</title>
    <script src="js/lib/angular.js"></script>
    <script src="js/lib/angular-route.js"></script>
    <script src="js/lib/angular-resource.js"></script>
    <script src="js/app.js"></script>
    <link href="css/style.css" rel="stylesheet">
    <style>
        body {
            background-color: #434343;
        }
    </style>
</head>

<body>
<div class ="gameName">
    Chinpokomon the game
</div>
<menu></menu>
<ng-view></ng-view>

</body>
</html>