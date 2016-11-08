<!DOCTYPE HTML>
<html ng-app="game">
<head>
    <meta charset="utf-8">
    <title>Chinpokomon the game web-app</title>
    <script src="../../localhost/js/lib/angular.js"></script>
    <script src="../../localhost/js/lib/angular-route.js"></script>
    <script src="../../localhost/js/lib/angular-resource.js"></script>
    <script src="../js/app.js"></script>
    <link href="../css/style.css" rel="stylesheet">
</head>

<body>
<div class ="gameName">
    <a href="index.php"> Chinpokomon the game </a>
</div>

    <ng-view></ng-view>

</body>
</html>