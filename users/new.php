<?php 
    include('../configuration.php');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <meta name="author" content="">

      <title>New User</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="http://malsup.github.com/jquery.form.js"></script>

      <script>
          // wait for the DOM to be loaded
          $(document).ready(function() {
              var options = {
                  error: function(xhr, statusText, errorThrown) {
                      $('#form-errors').html(xhr.responseJSON.message);
                  },
                  success: function(responseJSON, statusText, xhr, formElement) {
                      $(location).attr('href','../session/new.php');
                  }
              };
              $('#form').ajaxForm(options);
          });
      </script>
  </head>

  <body>
<!-- JS for log in errors -->
<script language="javascript">
        var flag=0;
        function username()
        {
            user=loginform.username.value;
            if(user=="")
            {
                document.getElementById("error0").innerHTML="Enter UserID";
                flag=1;
            }
        }   
        function password()
        {
            pass=loginform.password.value;
            if(pass=="")
            {
                document.getElementById("error1").innerHTML="Enter password";   
                flag=1;
            }
        }

        function check(form)
        {
            flag=0;
            username();
            password();
            if(flag==1)
                return false;
            else
                return true;
        }

    </script>
    

    <div class="container">
      <?php
        include("../header.php");
        printHeader();
      ?>

      <form action="create.php" class="form-signin" id="form" method="post">
        <h2 class="form-signin-heading">Create user</h2>
        
        <label for="inputEmail" class="sr-only">Email address</label>
        <div id="error0"></div>
        <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus name="email">
        
        <label for="inputPassword" class="sr-only">Password</label>
        <div id="error1"></div>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required name="password">
        
        <br>
        <br>
        <button class="btn btn-lg btn-primary" type="submit">Create user</button>

          <p id="form-errors">

          </p>
      </form>
        <p class="form-signin">Already have an account? <a href="../session/new.php">Login</a></p>

    </div> <!-- /container -->



  </body>
</html>
