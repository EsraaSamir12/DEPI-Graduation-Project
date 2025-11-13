<?php
include("connection.php");

$applicant_id = $_SESSION['ApplicantID'] ?? $_SESSION['user_id'] ?? $_SESSION['id'] ?? 0;

if($applicant_id == 0) {
    header("location: login.php");
    exit();
}

$sql_applicant = "SELECT * FROM Applicant WHERE ApplicantID = ?";
$stmt = mysqli_prepare($connect, $sql_applicant);
mysqli_stmt_bind_param($stmt, "i", $applicant_id);
mysqli_stmt_execute($stmt);
$result_applicant = mysqli_stmt_get_result($stmt);

if(!$result_applicant || mysqli_num_rows($result_applicant) == 0) {
    die("User not found in database");
}

$applicant = mysqli_fetch_assoc($result_applicant);

function calculateAge($dob) {
    if(empty($dob) || $dob == '0000-00-00') return 'N/A';
    $birthDate = new DateTime($dob);
    $today = new DateTime();
    return $today->diff($birthDate)->y;
}
$age = calculateAge($applicant['DOB']);

$sql_applications = "SELECT s.Program, u.University 
                     FROM Application a 
                     JOIN Scholarship s ON a.ScholID = s.Schol_ID 
                     JOIN University u ON s.Uni_ID = u.Uni_ID 
                     WHERE a.ApplicantID = ?";
$stmt_apps = mysqli_prepare($connect, $sql_applications);
mysqli_stmt_bind_param($stmt_apps, "i", $applicant_id);
mysqli_stmt_execute($stmt_apps);
$result_applications = mysqli_stmt_get_result($stmt_apps);

$applications = [];
if($result_applications) {
    while($row = mysqli_fetch_assoc($result_applications)) {
        $applications[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scholar Verse - Profile</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #4a8b78ff 0%,  #209672ff 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .logo {
            color: white;
            font-size: 28px;
            font-weight: bold;
        }

        .back-home {
            color: white;
            text-decoration: none;
            font-size: 16px;
        }

        .welcome-section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .welcome-section h1 {
            color: #333;
            margin-bottom: 10px;
            font-size: 24px;
        }

        .profile-form {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            color: #666;
            margin-bottom: 5px;
            font-size: 14px;
        }

        .form-group input {
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
            background: #f8f9fa;
        }

        .form-group input:focus {
            outline: none;
            border-color: #4a8b78ff;
        }

        .scholarships-section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .scholarships-section h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 22px;
        }

        .scholarship-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .scholarship-item {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            border-left: 4px solid #4a8b78ff;
        }

        .scholarship-item h3 {
            color: #333;
            margin-bottom: 5px;
        }

        .action-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 30px;
        }

        .btn {
            padding: 15px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
            text-decoration: none;
            display: block;
        }

        .btn-primary {
            background: #4a8b78ff;
            color: white;
        }

        .btn-secondary {
            background: #e9ecef;
            color: #333;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .logout-form {
            margin-top: 20px;
            text-align: center;
        }

        .logout-btn {
            background: #dc3545;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">Scholar Verse</div>
            <div style="display: flex; align-items: center; gap: 15px;">
                <?php if(isLoggedIn()): ?>
                    <span style="color: white;">Welcome, <?php echo getUserName(); ?></span>
                    <form method="POST" style="display: inline;">
                        <button type="submit" name="logout" class="logout-btn">Logout</button>
                    </form>
                <?php else: ?>
                    <a href="login.php" class="auth-btn">Sign in</a>
                <?php endif; ?>
                <a href="index.php" class="back-home">Back to Home</a>
            </div>
        </div>

        <div class="welcome-section">
            <h1>Hi <?php echo htmlspecialchars($applicant['FullName']); ?></h1>
            <p>good to see you again!</p>
        </div>

        <div class="profile-form">
            <div class="form-grid">
                <div class="form-group">
                    <label>Name:</label>
                    <input type="text" value="<?php echo htmlspecialchars($applicant['FullName'] ?? 'N/A'); ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" value="<?php echo htmlspecialchars($applicant['Email'] ?? 'N/A'); ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Age:</label>
                    <input type="text" value="<?php echo $age; ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Degree:</label>
                    <input type="text" value="<?php echo htmlspecialchars($applicant['GPA'] ?? 'N/A'); ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Nationality:</label>
                    <input type="text" value="<?php echo htmlspecialchars($applicant['Nationality'] ?? 'N/A'); ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Major:</label>
                    <input type="text" value="<?php echo htmlspecialchars($applicant['Major'] ?? 'N/A'); ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Year of Study:</label>
                    <input type="text" value="<?php echo htmlspecialchars($applicant['YearOfStudy'] ?? 'N/A'); ?>" readonly>
                </div>
            </div>
        </div>

        <div class="scholarships-section">
            <h2>Applied Scholarships</h2>
            <div class="scholarship-list">
                <?php if(!empty($applications)): ?>
                    <?php foreach($applications as $app): ?>
                    <div class="scholarship-item">
                        <h3><?php echo htmlspecialchars($app['Program']); ?></h3>
                        <p>University: <?php echo htmlspecialchars($app['University']); ?></p>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="scholarship-item">
                        <h3>No scholarships applied yet</h3>
                        <p>Start applying to see your progress here!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="action-buttons">
            <a href="track_progress.php" class="btn btn-primary">Track the Progress</a>
            <a href="scholarships.php" class="btn btn-secondary">Find Scholarships to Fund Your Study Abroad</a>
        </div>

        
    </div>
</body>
</html>