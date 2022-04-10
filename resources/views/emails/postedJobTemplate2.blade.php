<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
         <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>
    <body>
    <div style="display:grid;place-items:center;">
<div class="container" style="margin:0!important;padding:0!important;">
<div class="row justify-content-center">
  <div class="col-md-8 col-xs-12" style="padding-right: 0!important; margin-top: 10px;
    margin-bottom: 10px;
    margin-left: 10px;
    margin-right: 10px;">
    <div class="container" style="box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;">
        <div class="row justify-content-center p-3">
                 <div class=" col-xs-12">
    <div class="image" style="text-align: center;">
       <img src="https://apace-storage.s3.us-east-2.amazonaws.com/apacelogo.png" class="thumbnail img-responsive" style="max-width:200px; height:100px;align-items:center"/>
    </div>
    </div>
    </div>
         <div class="row p-3 justify-content-center">
<div class=" col-xs-12 ">
 <p style="text-align: justify;"> We received a password reset request for your account with <strong>APACE</strong>. If you made this request, please press the button below to reset your password. If you do not understand why you are receiving this e-mail, it may be because somebody else has entered your e-mail address into our password reminder form. If so, you may ignore this message.</p>
   <p style="text-align: center;"> <a target="blank" href="<%=process.env.APP_URL%>/reset/<%=token%>"
                                            style="background:linear-gradient(to right, #0085A7 0%, #74134B 100%);text-decoration:none !important; font-weight:500; margin-top:35px; color:#fff;text-transform:uppercase; font-size:14px;padding:10px 24px;display:inline-block;border-radius:50px;">Click Here to Reset
                                            Password</a></p>
<p>Regards,</p>
<p>APACE</p>
</div>
</div>
<div class="row p-3 justify-content-center">
<div class="col-xs-12 ">
<p style="text-align:center;">&copy; <strong>2021 APACE All rights reserved</strong></p>
</div>
</div>
        </div>
    </div>
  </div>
</div>
</div>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
</html>
