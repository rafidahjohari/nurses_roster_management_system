<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <link rel="stylesheet" href="styles.css">
     <!--<link rel="stylesheet" href="../Style/nav_bar.css">-->
    <!---we had linked our css file----->
</head>


<body>
    <div class="FULL-PAGE">
        <div class="navbar">
                        
              <h1 class ="logo">Nurses Roster Management System</h1>
           
            <nav>
                <ul id='MenuItems'>
                   
            <!--<li><a href='Register.php'>Register</a></li>-->
                </ul>
            </nav>
        </div>
        <div id='login-form'class='login-page'>
            <div class="form-box">
                <div class='button-box'>     

  <div class="container">
    <form method="post" action="loginProcess.php">
      <h2>Login Page</h2>
      <div class="form-group">
        <label for="username">User ID:</label>
        <input type="text" name="username" id="username" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
      </div>
      <button type="submit">Login</button>
    </form>
  </div>
</body>
</html>