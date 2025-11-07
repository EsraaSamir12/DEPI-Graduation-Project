<?php
include("connection.php");

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
<html>
<head>
    <title>Login</title>
    <style>
        .error { color: red; }
        div { margin: 10px 0; }
        label { display: inline-block; width: 150px; }
        .container { max-width: 400px; margin: 50px auto; padding: 20px; border: 1px solid #ccc; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        
        <?php if(!empty($error_msg)): ?>
            <div class="error"><?php echo $error_msg; ?></div>
        <?php endif; ?>
        
        <form action="" method="post">
            <div>
                <label for="Email">Email</label>
                <input type="email" id="Email" name="Email" value="<?php echo htmlspecialchars($Email); ?>" required>
            </div>
            
            <div>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" name="login">Login</button>
        </form>
        
        <p>Don't have an account? <a href="sign_up.php">Sign up here</a></p>
    </div>
</body>
</html>

