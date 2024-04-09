<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<nav class="navbar navbar-expand-lg navbar-light">
        <img src="logo.png"  width="60" height="60">
             
              
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                
                  <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                      <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="Customer.php">Customers</a>
                      </li>
                      <?php
                        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                            // User is logged in, display their name and a "Logout" button
                            echo '<li class="nav-item"><span class="nav-link">Welcome, ' . $_SESSION['username'] . '</span></li>';
                            echo '<li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>';
                        } else {
                            // User is not logged in, display "Login" and "Register" buttons
                            echo '<li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>';
                            echo '<li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>';
                        }
                        
                      ?>
                  </ul>
           </div>
        </nav>