<?php
include("includes/config.php"); 
require_once('utility.php');
https_redirect();
 
/* LOGGED IN CHECK */
if(!userLoggedIn() || !userTypeLoggedIn('SECRETARY_OFFICER')) {   
    myRedirectTo('login.php', 'SessionTimeOut');
    exit;
  }
?>
<!DOCTYPE html>
<html lang="en">

  <head>
    <?php include("includes/head.php"); ?>
  <title></title> <!-- already set in head.php, here only to remove sonarcloud error -->
    <link href="css/dashboard.css" rel="stylesheet" type="text/css">
    <link href="css/responsive.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" 
      integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/lecture_rec.css">
    <link rel="stylesheet" type="text/css" href="css/w3.css"> 
    <script src="https://code.jquery.com/jquery-1.7.1.min.js" type="text/javascript"></script>
    
    <!-- Bootstrap Date-Picker Plugin -->
    <script type="text/javascript" src="./css/bootstrap-datepicker-1.9.0-dist/js/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="./css/bootstrap-datepicker-1.9.0-dist/css/bootstrap-datepicker.css">
    
    <?php  
      if(isset($_GET[MSG])&& !empty($_GET[MSG])) {
        $_GET[MSG] = "";
      }
    ?>

 </head>

  <body>
    <?php include("includes/user_header.php"); ?>
    <script>
    $(document).ready(function() {
      $('[data-toggle=offcanvas]').click(function() {
        $('.row-offcanvas').toggleClass('active');
      });
    });
  </script>
  <div class="container-fluid" style="height: 100%; margin-top:48px">
    <div class="row row-offcanvas row-offcanvas-left" style="height: 100%">
    <?php include("includes/dashboard_secretary.php"); ?> 

    <script>
    var homeElement = document.getElementById("homeDash");
    var publishCommunicationElement = document.getElementById("publish_communication_dashboard");
    if (homeElement.classList) {
      homeElement.classList.remove("active");
    }
    if (publishCommunicationElement.classList) {
      publishCommunicationElement.classList.add("active");
    }
  </script>

<div class="col main formContainer text-center bg-light">
    <!--toggle sidebar button-->
    <p class="visible-xs" id="sidebar-toggle-btn">
      <button type="button" class="btn btn-light btn-xs" data-toggle="offcanvas">
        <em data-feather="menu"></em>
      </button>
    </p> 
    <form class="form-record col-md-9 ml-lg-15 ml-md-5 ml-sm-1 col-lg-7 pt-3 px-4" action="record_communication.php" method="post" name="comm_recording"> 
    <img class="mb-4" src="images/icons/communication_recording.png" alt="" width="102" height="102">  
    <h1 class="h3 mb-3 font-weight-normal" id='commRecordingTitle'>Official Communication Recording</h1>

        <!-- Text area for lecture's topic recording -->
        <div class="form-group-text">
          <label for="topicTitleTextArea">Insert the official communication title</label>
          <textarea class="form-control" id="topicTitleTextArea" rows="1" name="title"></textarea>
        </div>

        <!-- Text area for lecture's topic recording -->
        <div class="form-group-text">
          <label for="lectureTextArea">Insert a description</label>
          <textarea class="form-control" id="lectureTextArea" rows="3" name="subtitle"></textarea>
        </div>        

        <!-- POST Method response -->
        <?php 
          if(isset($_SESSION[MSG])) {
            if(!empty($_SESSION[MSG])) {
                if($_SESSION[MSG] != COMMUNICATION_RECORDING_OK){ ?>
                    <div class="w3-padding-small w3-small w3-round w3-margin-bottom error-back-color w3-text-red"><span id="msg-result"><strong><?php echo $_SESSION[MSG];?></strong></span></div></strong>
                <?php } else { ?>
                    <div class="w3-padding-small w3-small w3-round w3-margin-bottom success-back-color w3-text-green"><span id="msg-result"><strong><?php echo $_SESSION[MSG];?></strong></span></div></strong>
                <?php
                }
              }
          $_SESSION[MSG] = "";
          } ?>    
        
        <button class="btn btn-lg btn-primary btn-block" type="submit" id="confirm">Confirm</button>
    </form>
  </div>
  </body>
  <!-- Icons -->
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<script>
    feather.replace()
</script>
</html>