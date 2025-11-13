login page
<?php
include("connection.php");
if (!isset($_SESSION)) {
    session_start();
}

$error_msg = "";
$Email = "";

if(isset($_POST['login'])){  
    $Email = isset($_POST['Email']) ? $_POST['Email'] : "";
    $password = isset($_POST['password']) ? $_POST['password'] : "";
    
    if(empty($Email) || empty($password)){
        $error_msg = "Please fill all required fields";
    } else {
        $select = "SELECT * FROM `applicant` WHERE `Email` = '$Email'";
        $run_select = mysqli_query($connect, $select);
        
        if($run_select && mysqli_num_rows($run_select) > 0){
            $user = mysqli_fetch_assoc($run_select);
            
            if(password_verify($password, $user['password'])){
                $_SESSION['user_id'] = $user['ApplicantID'];
                $_SESSION['user_name'] = $user['FullName'];
                $_SESSION['user_email'] = $user['Email'];
                
                echo "<script>alert('Login successful!');</script>";
                echo "<script>window.location.href = 'profile.php';</script>";
            } else {
                $error_msg = "Invalid password";
            }
        } else {
            $error_msg = "Email not found";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign In</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    body {
      font-family: "Poppins", sans-serif;
      background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
        url("images/header_image.jpg") no-repeat center center/cover;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .signin-container {
      background-color: rgba(255, 255, 255, 0.125);
      padding: 40px;
      border-radius: 15px;
      width: 350px;
      box-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
      text-align: center;
    }

    h2 {
      margin-bottom: 25px;
      color: #ffffff;
    }

    input {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border-radius: 8px;
      border: 1px solid #ccc;
      font-size: 16px;
    }

    button {
      width: 100%;
      padding: 12px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      margin-top: 15px;
    }

    button:hover {
      background-color: #0056b3;
    }

    .signup-link {
      margin-top: 20px;
      font-size: 14px;
      color: white;
    }

    .signup-link a {
      color: #007bff;
      text-decoration: none;
      font-weight: bold;
    }

    .signup-link a:hover {
      text-decoration: underline;
    }
    
    .error { 
        color: red; 
        background: rgba(255, 255, 255, 0.8);
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 15px;
    }
  </style>
</head>
<body>
  <div class="signin-container">
    <h2>Sign In</h2>
    
    <?php if(!empty($error_msg)): ?>
        <div class="error"><?php echo $error_msg; ?></div>
    <?php endif; ?>
    
    <form action="" method="post">
      <input type="email" id="Email" name="Email" placeholder="Email" value="<?php echo htmlspecialchars($Email); ?>" required />
      <input type="password" id="password" name="password" placeholder="Password" required />
      <button type="submit" name="login">Sign In</button>
    </form>
    <div class="signup-link">
      Don't have an account? <a href="sign_up.php">Sign up now</a>
    </div>
  </div>
</body>
</html>