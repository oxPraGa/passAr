<!DOCTYPE html>
<head>
<title>AR Pass experience</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- bootstrap-css -->
<link rel="stylesheet" href="css/bootstrap.min.css" >
<!-- //bootstrap-css -->
<!-- Custom CSS -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href="css/style-responsive.css" rel="stylesheet"/>
<!-- font CSS -->
<link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<!-- font-awesome icons -->
<link rel="stylesheet" href="css/font.css" type="text/css"/>
<link href="css/font-awesome.css" rel="stylesheet">
<!-- //font-awesome icons -->
	<style>
		/* canvas{
			height: 640px !important;
			width: 640px !important;
		}

		video {
			height: 640px !important;
			width: 640px !important;
		} */
	</style>
</head>
<body class="login">
<div class="log-w3">
<div class="w3layouts-main" style="min-width: 700px;">
	<h2>AR Pass</h2>
		<form action="#" id="form" method="post">
			<span class="error" style="width: 100%;text-align: center;color: red;display:none">Le nom d'utilisateur ou le mot de passe est incorrect</span>
			<div class="password_AR" style="width:100%" >
				<div id="board2" style='text-align: center; z-index: 1;width:100%;position:relative' ></div>
			</div>
				<div class="clearfix"></div>

				<input type="hidden" value="authentet_3D" name="action"  />
				<input type="hidden" value="admin" name="username"  />
				<!-- <input type="hidden" value="" id="pass" name="password"  /> -->
				<input type="submit" value="Sign In" name="connecter" >
		</form>

</div>
</div>
<script src="js/jquery.min.js"></script>
	<script src="build/three.js"></script>
	<script src="js/loaders/DDSLoader.js"></script>
	<script src="js/loaders/MTLLoader.js"></script>
	<script src="js/loaders/OBJLoader.js"></script>
	<script src="js/controls/OrbitControls.js"></script>
	<script src="js/Detector.js"></script>
	<script src="js/libs/stats.min.js"></script>
	<script src="js/controls/DragControls.js"></script>
	<script src="js/controls/TrackballControls.js"></script>
	<script src="js/renderers/Projector.js"></script>
	<script src="build/ar.js"></script>
	<script src="js/chessboard3_AR.js"></script>
	<!-- <script src="js/chessboard3.js"></script> -->
<script>
$("#board2").width(640);
$("#board2").height(480);

var outPut = "rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR";
$("#outPut").val(outPut);

board2 = new ChessBoard3('board2', {
draggable: true,
dropOffBoard: 'trash',
sparePieces: false ,
rotateControls : true,
position : 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR' ,
onChange: function(oldPos, newPos) {
  //window.location.href = "#info://";
  outPut = ChessBoard3.objToFen(newPos);
	$("#outPut").val(outPut);
}
});
$("form").on("submit",function(){

	var values = $(this).serialize();
	values +="&password="+outPut;
	console.log(values);
	$.ajax({

		url: "include/ajax.php",
		type: "post",
		data: values ,
		success: function (response) {
			 // you will get response from your php page (what you echo or print)
			console.log(response);
			if(response == 1) {
					window.location.replace("index.php");
			}else{
					$(".error").slideDown();
			}
		},
		error: function(jqXHR, textStatus, errorThrown) {
		 var err = eval("(" + jqXHR.responseText + ")");
			 alert(err.Message);
		}
	});
	return false;
});
</script>
</body>
</html>
