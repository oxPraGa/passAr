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
<div class="w3layouts-main" style="min-width: 600px;">
	<h2>Authentifiez vous</h2>
		<form action="#" method="post">
			<span class="error" style="width: 100%;text-align: center;color: red;display:none">Le nom d'utilisateur ou le mot de passe est incorrect</span>
			<input type="text" class="ggg" name="username" splaceholder="Nom d'utilisateur" required="">
			<input type="hidden" class="ggg action" name="action" value="getAuthetType" required="">
			<input type="hidden" class="ggg passText" name="password" placeholder="PASSWORD" required="" style='display:none'>
			<div class="password_image" style="text-align:center;display:none">
				<canvas id="canvas1" width="0" height="0"></canvas>
				<canvas id="canvas2" style="display:none"></canvas>
				<a onclick="clearPass()" style="padding: 8px 20px;font-size: 18px;text-transform: uppercase;letter-spacing: 2px;background: #595352;color: white;border: none;outline: none;display: table;cursor: pointer;margin: auto;">Clear</a>
			</div>
			<div class="password_3d" style="display:none">
					<div id="board2"></div>
					<a onclick="clearPass3d()" style="padding: 8px 20px;font-size: 18px;text-transform: uppercase;letter-spacing: 2px;background: #595352;color: white;border: none;outline: none;display: table;cursor: pointer;margin: auto;position: absolute;margin-top: -170px;left: 45%;">Clear</a>
			</div>

				<div class="clearfix"></div>

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
	<!-- <script src="js/chessboard3_AR.js"></script> -->
	<script src="js/chessboard3.js"></script>
<script>
var image_pass = new Array();
var pass_type, board2,outPut;
	$("form").on("submit",function(){
			 var values = $(this).serialize();
			if (pass_type == 0) {
				$(".action").val("authentet");
				var values = $(this).serialize();
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
		}else if( pass_type ==  1){
			$(".action").val("authentet_image");

			var values = $(this).serialize();
			var pass_json = JSON.stringify(image_pass);
			values +="&password="+pass_json;
			$.ajax({
				url: "include/ajax.php",
				type: "post",
				data: values ,
				success: function (response) {

					console.log(response);
					if(response == 1) {
							window.location.replace("index.php");
					}else{
							$(".error").slideDown();
							image_pass.length = [];
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
				 var err = eval("(" + jqXHR.responseText + ")");
					 alert(err.Message);
				}
			});
		}else if( pass_type ==  2){
			$(".action").val("authentet_3D");
			var values = $(this).serialize();
			//console.log(values);
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
		}else{
				$.ajax({
					url: "include/ajax.php",
					type: "post",
					data: values ,
					success: function (response) {
						 // you will get response from your php page (what you echo or print)
						console.log(response);
						if(response == 0) {
							pass_type = 0;
							$('.passText').attr('type', 'password');
							$('.passText').slideDown();

						}
						if(response == 2){
								$(".password_3d").slideDown();
								$("#board2").width($("form").width());
								$("#board2").height($("form").width());
								$("input[type=submit]").attr("style","position: absolute;margin-top: -120px;left: 43%;");
								outPut = "rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR";
								$("#passW").val(outPut);
								board2 = new ChessBoard3('board2', {
								draggable: true,
								dropOffBoard: 'trash',
								sparePieces: false ,
								rotateControls : true,
								position : 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR' ,
								onChange: function(oldPos, newPos) {
									//window.location.href = "#info://";
									outPut = ChessBoard3.objToFen(newPos);
									$(".passText").val(outPut);
								}
								});
								pass_type = 2;
						}
						if(response == 1){
							$(".password_image").show();
							pass_type = 1;
							$("#password_image").slideDown();
							var canvas = document.getElementById('canvas1');
							var canvas2 = document.getElementById('canvas2');


							base_image = new Image();
							base_image2 = new Image();

							base_image2.src = 'data/colored_img.png';
							base_image.src = 'data/img_resized.png';
							base_image.onload = function (imageEvent){
								var width = base_image.naturalWidth;
								var height = base_image.naturalHeight;
								canvas.width  = width;
								canvas.height = height;
								context = canvas.getContext('2d');
								context.drawImage(base_image, 0,0);

							}
							base_image2.onload = function (imageEvents){

								var width = base_image2.naturalWidth;
								var height = base_image2.naturalHeight;
								canvas2.width  = width;
								canvas2.height = height;
								context2 = canvas2.getContext('2d');
								context2.drawImage(base_image2, 0,0);


							$('#canvas1').click(function(e) {

								var pos = findPos(this);
								var x = e.pageX - pos.x;
								var y = e.pageY - pos.y;
								var coord = "x=" + x + ", y=" + y;

								var p = context2.getImageData(x, y, 1, 1).data;
								var hex = "#" + ("000000" + rgbToHex(p[0], p[1], p[2])).slice(-6);
								image_pass.push(hex);
								console.log(image_pass);
							});

							}
						}
						if(response == 3){
								$(".w3layouts-main").css("min-width","100%");
								pass_type = 3;
								var outPut = "rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR";
								var board2 = new ChessBoard3('board2', {
								draggable: true,
								dropOffBoard: 'trash',
								sparePieces: false ,
								rotateControls : true,
								position : 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR' ,
								onChange: function(oldPos, newPos) {
									window.location.href = "#info://";
									outPut = ChessBoard3.objToFen(newPos);
								}
								});
								var praga = "wwi";
						}
					},
					error: function(jqXHR, textStatus, errorThrown) {
					 var err = eval("(" + jqXHR.responseText + ")");
						 alert(err.Message);
					}
			});
			}

		return false;
	});

	function findPos(obj) {
    var curleft = 0, curtop = 0;
    if (obj.offsetParent) {
        do {
            curleft += obj.offsetLeft;
            curtop += obj.offsetTop;
        } while (obj = obj.offsetParent);
        return { x: curleft, y: curtop };
    }
    return undefined;
    }

    function rgbToHex(r, g, b) {
        if (r > 255 || g > 255 || b > 255)
            throw "Invalid color component";
        return ((r << 16) | (g << 8) | b).toString(16);
    }

		function clearPass(){
			image_pass = [];
			return false;
		}
		function clearPass3d(){
			board2.start();
		}

</script>
</body>
</html>
