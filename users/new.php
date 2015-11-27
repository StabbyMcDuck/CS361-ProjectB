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

      <!-- Bootstrap core CSS -->
      <link href="../css/bootstrap.min.css" rel="stylesheet">

      <!-- Custom styles for this template -->
      <link href="../css/users/new.css" rel="stylesheet">

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

    <div class="container">

      <form action="create.php" class="form-signin" id="form" method="post">
        <h2 class="form-signin-heading">Create user</h2>
        
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus name="email">
        
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required name="password">
        
        <select class="form-control">
          <option>1</option>
          <option>2</option>
          <option>3</option>
        </select>
  </div>
        
        <button class="btn btn-lg btn-primary btn-block" type="submit">Create user</button>

          <p id="form-errors">

          </p>
      </form>
        <p class="form-signin">Already have an account? <a href="../session/new.php">Login</a></p>

    </div> <!-- /container -->



  </body>
</html>