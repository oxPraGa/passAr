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
                              AR ChessBoard 3D PassWord
                          </header>
                          <div class="panel-body" style="positon:relative">
                            <div class="ajax-laod"style="z-index: 20;position: absolute;top: 0;left: 0;width: 100%;height: 100%;background-color: rgba(0,0,0,0.2);display:none">
                                <img src="images/ajax-loader.gif" style="position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);">
                            </div>
                              <div class="position-center">
                                  <form role="form" id="form1" enctype="multipart/form-data" style="text-align:center">

                                  <div class="form-group">
                                      <label for="exampleInputFile">Générer le marker</label>
                                      <img src="" id="marker" style="display:none"/>
                                  </div>
                                  <a type="submit" class="btn btn-info" onclick="gener()">Générer </a>
                                  <a type="submit" class="btn btn-info down"  style="display: none" onclick="downloadIMG()">Télécharger l'image </a>
                                  <a type="submit" class="btn btn-info down"  style="display: none" onclick="downloadPDF()">Télécharger PDF </a>
                                  <br><br>
                                  <input type="hidden" name="action" value="saveMarker"/>
                                  <button type="submit" class="btn btn-info down" style="display: none" > Sauvez </button>
                                  <input type='file' id='fileinput' style='display: none'>
                              </form>
                              <form role="form" id="form2" enctype="multipart/form-data" style="display: none; text-align:center">

                                  <div class="form-group">
                                                                      <label for="exampleInputFile">Choisir la combinaison de mot de passe</label>
                                                                      <div id="board2"></div>

                                                                  </div>
                                                                  <div style="position: absolute;margin-top: -200px;">
                                                                    <input type="hidden" name="action" value="save3dPassAr">
                                                                    <input type="hidden" name="pass" id="passW" value="">
                                                                    <a class="btn btn-info" onclick="clearPass()"> Clear </a>
                                                                    <button type="submit" class="btn btn-info"> Sauvez </button>
                                </div>
                            </form>
                              </div>

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
<script src='js/pdfMake/pdfmake.min.js'></script>
<script src='js/vendor/pdfMake/vfs_fonts.js'></script>

<!-- include THREEx.ArPatternFile -->
<script src='js/threex-arpatternfile.js'></script>
<!-- morris JavaScript -->
<script>
// THREEx.ArPatternFile.encodeImageURL(, function onComplete(patternFileString){
//   //THREEx.ArPatternFile.triggerDownload(patternFileString)
//
//   $("#marker").show();
// })


var fullMarkerURL;
var inerImage = "";
var board2;
var outPut = "rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR";
function gener(){
//  var mark = Math.floor(Math.random(0,1)*199);
  THREEx.ArPatternFile.buildFullMarker("marker/11.png", 0.5, function onComplete(markerUrl){
    inerImage = "marker/11.png";
    fullMarkerURL = markerUrl;
    console.log(fullMarkerURL);
    $("#marker").attr("src",fullMarkerURL );
    $("#marker").slideDown("slow");
    $(".down").show();
  })
}

function downloadIMG(){
  var domElement = window.document.createElement('a');
  domElement.href = fullMarkerURL;
  domElement.download = 'marker.png';
  document.body.appendChild(domElement)
  domElement.click();
  document.body.removeChild(domElement)
}
function downloadPDF(){
	        var docDefinition = {
			content: [
				{
					image: fullMarkerURL,
					width: 300,
					alignment: 'center',
				},
			]
	        }
	        pdfMake.createPdf(docDefinition).download("marker.pdf");
          console.log(docDefinition);
}

  $("#form1").on("submit",function(){
    var values = $(this).serialize();
    toDataURL(inerImage,function(dataUrl) {
      THREEx.ArPatternFile.encodeImageURL(dataUrl, function onComplete(patternFileString){
        values +="&marker="+patternFileString;
  			console.log(patternFileString);
        $.ajax({
            url: "include/ajax.php",
            type: "POST",
            data : values,

            beforeSend: function() {
              $(".ajax-laod").slideDown("slow");
            },
            success: function(data){
                 $(".ajax-laod").slideUp("slow",function(){
                    $("#form1").slideUp("slow",function(){
                        $("#form2").slideDown("slow",function(){
                          $("#board2").width($("#form2").width());
                          $("#board2").height($("#form2").width());
                          outPut = "rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR";
                          $("#passW").val(outPut);
                          var board2 = new ChessBoard3('board2', {
                          draggable: true,
                          dropOffBoard: 'trash',
                          sparePieces: false ,
                          rotateControls : true,
                          position : 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR' ,
                          onChange: function(oldPos, newPos) {
                            //window.location.href = "#info://";
                            outPut = ChessBoard3.objToFen(newPos);
                            $("#passW").val(outPut);
                          }
                          });
                        });


                    });

                 });
              },
              error: function(xhr, ajaxOptions, thrownError) {
                 console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
              }
          });

  		});
  });



    return false;

   });

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

       function updateFullMarkerImage(){
         // get patternRatio
         var patternRatio = 90/100

         THREEx.ArPatternFile.buildFullMarker(innerImageURL, patternRatio, function onComplete(markerUrl){
           fullMarkerURL = markerUrl

           var fullMarkerImage = document.createElement('img')
           fullMarkerImage.src = fullMarkerURL

           // put fullMarkerImage into #imageContainer
           var container = document.querySelector('#imageContainer')
           while (container.firstChild) container.removeChild(container.firstChild);
           container.appendChild(fullMarkerImage)
         })
       }

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

       function clearPass(){
         board2.start();
       }
       function toDataURL(src, callback, outputFormat) {
        var img = new Image();
        img.crossOrigin = 'Anonymous';
        img.onload = function() {
          var canvas = document.createElement('CANVAS');
          var ctx = canvas.getContext('2d');
          var dataURL;
          canvas.height = this.naturalHeight;
          canvas.width = this.naturalWidth;
          ctx.drawImage(this, 0, 0);
          dataURL = canvas.toDataURL(outputFormat);
          callback(dataURL);
        };
        img.src = src;
        if (img.complete || img.complete === undefined) {
          img.src = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";
          img.src = src;
        }
      }
</script>
	<!-- //calendar -->
</body>
</html>
