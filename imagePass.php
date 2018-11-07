<?php
  require_once("include/header.php");
?>
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
	<section class="wrapper">
    <div class="form-w3layouts">
          <!-- page start-->
          <!-- page start-->
          <div class="row">
              <div class="col-lg-12">
                      <section class="panel" >
                        <div id="myModal" class="modal">

                          <!-- Modal content -->
                          <div class="modal-content">
                            <span class="close">&times;</span>
                            <p>Vous avez modifiez votre mot de passe avec succès</p>
                          </div>

                        </div>
                          <header class="panel-heading">
                              Image Password
                          </header>
                          <div class="panel-body" style="positon:relative">
                            <div class="ajax-laod"style="z-index: 20;position: absolute;top: 0;left: 0;width: 100%;height: 100%;background-color: rgba(0,0,0,0.2);display:none">
                                <img src="images/ajax-loader.gif" style="position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);">
                            </div>
                              <div class="position-center">
                                  <form role="form" id="form1" enctype="multipart/form-data" >

                                  <div class="form-group">
                                      <label for="exampleInputFile">Choisir une image</label>
                                      <input type="file" name="fileToUpload" >
                                      <p class="help-block"></p>
                                  </div>
                                  <button type="submit" class="btn btn-info">Uploader </button>
                              </form>

                              </div>
                              <form role="form" id="form2" methode="post" style="display:none">
                                <div class="col-md-6 w3-agile-map-left">
                                  <img src="" class="img-responsive">
                                </div>
                                <div class="col-md-6 " >
                                  <h4>La taille des régions </h4>
                                  <input id="champ1" name="regionSize" value="20" min="20" max="120" step="20" type="range">
                                  <div class="range" style="position:relative">
                                    <span>20</span>
                                    <span style="left: 19%;">40</span>
                                    <span style="left: 38%;">60</span>
                                    <span style="left: 58%;">80</span>
                                    <span style="left: 76%;">100</span>
                                    <span style="left: 96%;">120</span>
                                  </div>
                                  <div style="margin-top:20px"></div>
                                  <input type="hidden" name="action" value="segment">

                                  <button type="submit" class="btn btn-info">Segmenter </button><br>
                                  <a class="btn btn-info" onclick="backToImageUp()">Changer l'image </a>
                                </div>
                              </form>
                              <form role="form" id="form3" methode="post" style="display:none">
                                <h4>Clicker sur les region pour choisir le  mot de passe </h4>
                                <div class="col-md-6 w3-agile-map-left">
                                  <div class="panel panel-default">
                                    <div class="panel-heading" style="font-size: 14px;height: 35px;line-height: 35px;">Les regions de l'image</div>
                                    <div class="panel-body" style="border: 1px solid #ddede0 !important;">
                                      <img style="display:none" id="region" src="" class="img-responsive">
                                      <canvas id="canvas1" ></canvas>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-6 w3-agile-map-left">
                                  <div class="panel panel-default">
                                    <div class="panel-heading" style="font-size: 14px;height: 35px;line-height: 35px;">Les couleurs des regions de l'image</div>
                                    <div class="panel-body" style="border: 1px solid #ddede0 !important;">
                                      <img style="display:none" id="colored" src="" class="img-responsive">
                                      <canvas id="canvas2" ></canvas>
                                    </div>
                                  </div>
                                  <h4></h4>
                                </div>
                                <div class="col-md-6 w3-agile-map-left">
                                  <H4>Mot de passe : </h4>
                                  <canvas id="pass_canvas" width="800" height="40px" ></canvas>


                                  <a type="submit" class="btn btn-info" onclick="clearLast()">Back  </a>
                                  <a type="submit" class="btn btn-info" onclick="clearPass()">Clear  </a>
                                  <input type="hidden" name="action" value="saveImagePass">
                                  <button type="submit" class="btn btn-info">Sauvegarder </button>
                                  <a type="submit" class="btn btn-info" onclick="backToSegment()">Change segmentation </a>
                                </div>
                              </form>
                          </div>
                      </section>

              </div>
            </div>
      </div>
  </section>
 <!-- footer -->

  <!-- / footer -->
</section>
<!--main content end-->
</section>
<script src="js/bootstrap.js"></script>
<script src="js/jquery.dcjqaccordion.2.7.js"></script>
<script src="js/scripts.js"></script>
<script src="js/jquery.slimscroll.js"></script>
<script src="js/jquery.nicescroll.js"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot-chart/excanvas.min.js"></script><![endif]-->
<script src="js/jquery.scrollTo.js"></script>
<!-- morris JavaScript -->
<script>
  var image_pass = new Array();
  var pass_canvas = document.getElementById('pass_canvas');
  var pass_context = pass_canvas.getContext('2d');
	$(document).ready(function() {
      $("#form1").on("submit",function(){
        var formData = new FormData($(this)[0]);
        console.log(formData);
        $.ajax({
            url: "include/upload.php",
            type: "POST",
            data : formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $(".ajax-laod").slideDown("slow");
            },
            success: function(data){
              $(".ajax-laod").slideUp("slow");
              console.log("{"+data+"}");
                if( data.includes("img.")){
                  $("#form2 img").attr("src", "data/"+data+"?"+new Date().getTime());
                  $("#form1").slideUp("slow",function() {
                      $("#form2").slideDown("slow");
                  });
                }else{
                  alert(data);
                }

            },
            error: function(xhr, ajaxOptions, thrownError) {
               console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
        return false;
      });

      $("#form2").on("submit",function(){
        	 var values = $(this).serialize();
           console.log(values);
        $.ajax({
            url: "include/ajax.php",
            type: "POST",
            data : values,

            beforeSend: function() {
              $(".ajax-laod").slideDown("slow");
            },
            success: function(data){
          //    console.log(data);
              $("#region").attr("src","data/region_img.jpg?"+ new Date().getTime());
              $("#colored").attr("src","data/colored_img.jpg?"+new Date().getTime());
              var exit = 0;
              var interval = setInterval(function(){
                  if($("#region").height() != 0){

                    var MAX_WIDTH = $("#region").width();
                    var MAX_HEIGHT = $("#region").height();

                    var canvas = document.getElementById('canvas1');
                    var canvas2 = document.getElementById('canvas2');


                    base_image = new Image();
                    base_image2 = new Image();
                    base_image.src = 'data/region_img.png';
                    base_image2.src = 'data/colored_img.png';
                    base_image.onload = function (imageEvent){
                      var width = base_image.naturalWidth;
                      var height = base_image.naturalHeight;
                      canvas.width  = width;
                      canvas.height = height;
                      context = canvas.getContext('2d');
                      context.drawImage(base_image, 0,0);
                      exit++;
                    }

                    base_image2.onload = function (imageEvent){

                      var width = base_image2.naturalWidth;
                      var height = base_image2.naturalHeight;

                      canvas2.width  = width;
                      canvas2.height = height;
                      context2 = canvas2.getContext('2d');

                      context2.drawImage(base_image2, 0,0);

                    exit++;

                    }
                    if(exit == 2) {
                      $('#canvas2').click(function(e) {
                          var pos = findPos(this);
                          var x = e.pageX - pos.x;
                          var y = e.pageY - pos.y;
                          var coord = "x=" + x + ", y=" + y;
                          var p = context2.getImageData(x, y, 1, 1).data;
                          var hex = "#" + ("000000" + rgbToHex(p[0], p[1], p[2])).slice(-6);
                          image_pass.push(hex);
                          drawCircle(pass_context);
                      });
                      $('#canvas1').click(function(e) {

                        var pos = findPos(this);
                        var x = e.pageX - pos.x;
                        var y = e.pageY - pos.y;
                        var coord = "x=" + x + ", y=" + y;

                        var p = context2.getImageData(x, y, 1, 1).data;
                        var hex = "#" + ("000000" + rgbToHex(p[0], p[1], p[2])).slice(-6);
                        image_pass.push(hex);
                        drawCircle(pass_context);
                      });
                      clearInterval(interval);
                    }

                  }
              }, 100);


              $(".ajax-laod").slideUp("slow");
              $("#form2").slideUp("slow",function() {
                  $("#form3").slideDown("slow");
              });
            },
            error: function(xhr, ajaxOptions, thrownError) {
               console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
        return false;
      });

  });

  $("#form3").on("submit",function(){
    var values = $(this).serialize();

    var pass_json = JSON.stringify(image_pass);
    values +="&pass="+pass_json;
    console.log(values);
 $.ajax({
     url: "include/ajax.php",
     type: "POST",
     data : values,

     beforeSend: function() {
       $(".ajax-laod").slideDown("slow");
     },
     success: function(data){
          if(data === "ok"){
            $(".ajax-laod").slideUp("slow",function(){
                  modal.style.display = "block";
            });

          }
     },
     error: function(xhr, ajaxOptions, thrownError) {
        console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
     }
 });
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

    function drawCircle(cont){
        var color = image_pass[image_pass.length-1];
        console.log(color);
        cont.fillStyle = color;
        cont.beginPath();
        if(image_pass.length == 1)
          cont.arc(20, 20, 15 , 0, 2 * Math.PI);
        else
          cont.arc((image_pass.length-1)*40+20, 20, 15 , 0, 2 * Math.PI);
        cont.fill()
    }

    function clearPass(){
      image_pass = [];
      pass_context.clearRect(0, 0, pass_canvas.width, pass_canvas.height);
      return false;
    }
    function clearLast(){
      // #var color = image_pass[image_pass.length-1];

      pass_context.fillStyle = "#FFFFFF";
      pass_context.beginPath();
      if(image_pass.length == 1)
        pass_context.arc(20, 20, 15 , 0, 2 * Math.PI);
      else
        pass_context.arc((image_pass.length-1)*40+20, 20, 16 , 0, 2 * Math.PI);
      pass_context.fill()
      if( image_pass.length  != 0)
      image_pass.length = image_pass.length- 1;
    }


    // Get the modal
    var modal = document.getElementById('myModal');

    // Get the button that opens the modal
    // var btn = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on the button, open the modal
    // btn.onclick = function() {
    //     modal.style.display = "block";
    // }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    function backToSegment(){
      $("#form3").slideUp("slow",function() {
          $("#form2").slideDown("slow");
      });
      return false;
    }
    function backToImageUp(){
      $("#form2").slideUp("slow",function() {
          $("#form1").slideDown("slow");
      });
      return false;
    }
</script>
	<!-- //calendar -->
</body>
</html>
