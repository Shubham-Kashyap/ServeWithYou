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
    <div class="image text-center">
       <img src="{{ URL::to('images/user_images/mahsool-logo.png') }}" class="thumbnail img-responsive" style="max-width: 200px;
    height: 100px;
    align-items: center;
    border-radius: 96px;"/>
    </div>
    </div>
    </div>
         <div class="row p-3 justify-content-center">
<div class=" col-xs-12 ">
<p>Hi {{$email}},</p>
 <p class="text-justify"> We are happy to have you signed up for <strong>Mahsool</strong>. We have received a signup request against phone number <strong>{{ $phone_no }}</strong>. Please use the following credentials while login into our app</p>
   <p class="text-center" style="font-size: 59px;">{{ $pwd }} </p>

<p>Regards,</p>
<p>Mahsool App</p>
</div>
</div>
<div class="row p-3 justify-content-center">
<div class="col-xs-12 ">
<p class="text-center">&copy; <strong>Mahsool 2021 All rights reserved</strong></p>
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