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
                              ChessBoard 3D PassWord
                          </header>
                          <div class="panel-body" style="positon:relative">
                            <div class="ajax-laod"style="z-index: 20;position: absolute;top: 0;left: 0;width: 100%;height: 100%;background-color: rgba(0,0,0,0.2);display:none">
                                <img src="images/ajax-loader.gif" style="position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);">
                            </div>
                              <div class="position-center">
                                  <form role="form" id="form1" enctype="multipart/form-data" >

                                  <div class="form-group">
                                      <label for="exampleInputFile">Choisir la combinaison de mot de passe</label>
                                      <div id="board2"></div>

                                  </div>
                                  <div style="position: absolute;margin-top: -200px;">
                                    <input type="hidden" name="action" value="save3dPass">
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
<!-- morris JavaScript -->
<script>
  $("#board2").width($("#form1").width());
  $("#board2").height($("#form1").width());
  var outPut = "rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR";
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
  $("#form1").on("submit",function(){
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

       function clearPass(){
         board2.start();
       }
</script>
	<!-- //calendar -->
</body>
</html>
