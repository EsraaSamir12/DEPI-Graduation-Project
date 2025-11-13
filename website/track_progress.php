<?php
require_once 'connection.php'; 

if(!isset($_SESSION['ApplicantID']) && !isset($_SESSION['user_id']) && !isset($_SESSION['id'])) {
    header("location: login.php");
    exit();
}

if(isset($_SESSION['ApplicantID'])) {
    $applicant_id = $_SESSION['ApplicantID'];
} elseif(isset($_SESSION['user_id'])) {
    $applicant_id = $_SESSION['user_id'];
} elseif(isset($_SESSION['id'])) {
    $applicant_id = $_SESSION['id'];
} else {
    header("location: login.php");
    exit();
}

$sql = "SELECT 
            a.ApplicationID,
            a.ApplicationDate,
            a.Recommendation,
            s.Program,
            u.University,
            er.Score as ExamScore,
            er.Result as ExamResult,
            i.Result as InterviewResult
        FROM Application a 
        JOIN Scholarship s ON a.ScholID = s.Schol_ID 
        JOIN University u ON s.Uni_ID = u.Uni_ID 
        LEFT JOIN ExamResult er ON a.ApplicationID = er.ApplicationID
        LEFT JOIN Interview i ON a.ApplicationID = i.ApplicationID
        WHERE a.ApplicantID = ?";

$stmt = mysqli_prepare($connect, $sql);
mysqli_stmt_bind_param($stmt, "i", $applicant_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$applications = [];

if($result && mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        // حساب الحالة
        $status = "Under Review 🔍";
        if ($row['Recommendation'] == 'Accepted') {
            $status = "Accepted ✅";
        } elseif ($row['Recommendation'] == 'Rejected') {
            $status = "Rejected ❌";
        } elseif ($row['InterviewResult'] != NULL) {
            $status = "Interview Stage 🗣️";
        } elseif ($row['ExamResult'] != NULL) {
            $status = "Exam Stage 📝";
        }

        $examResult = "Not Taken";
        $examClass = "";
        if ($row['ExamScore'] !== NULL) {
            $examResult = ($row['ExamScore'] >= 8) ? "Pass ✅" : "Fail ❌";
            $examClass = ($row['ExamScore'] >= 8) ? 'exam-pass' : 'exam-fail';
        }

        $interviewResult = "Not Scheduled";
        $interviewClass = "";
        if ($row['InterviewResult'] !== NULL) {
            $interviewResult = ($row['InterviewResult'] == 'Pass') ? "Pass ✅" : "Fail ❌";
            $interviewClass = ($row['InterviewResult'] == 'Pass') ? 'exam-pass' : 'exam-fail';
        }

        $applications[] = [
            'Program' => $row['Program'],
            'ApplicationDate' => $row['ApplicationDate'],
            'Status' => $status,
            'ExamResult' => $examResult,
            'ExamClass' => $examClass,
            'InterviewResult' => $interviewResult,
            'InterviewClass' => $interviewClass,
            'University' => $row['University']
        ];
    }
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scholar Verse - Track Progress</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #4a8b78ff 0%, #209672ff 100%);
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
            background: rgba(255,255,255,0.2);
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .back-home:hover {
            background: rgba(255,255,255,0.3);
        }

        .progress-section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .progress-section h1 {
            color: #333;
            margin-bottom: 30px;
            font-size: 24px;
            text-align: center;
        }

        .scholarship-progress {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .scholarship-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 25px;
            border-left: 4px solid #4a8b78ff;
            transition: transform 0.3s;
        }

        .scholarship-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .scholarship-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .scholarship-name {
            color: #333;
            font-size: 20px;
            font-weight: bold;
        }

        .scholarship-status {
            background: #4a8b78ff;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
        }

        .university {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .progress-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .detail-group {
            display: flex;
            flex-direction: column;
        }

        .detail-label {
            color: #666;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .detail-value {
            color: #333;
            font-size: 16px;
            font-weight: 500;
        }

        .exam-pass {
            color: #28a745;
            font-weight: bold;
        }

        .exam-fail {
            color: #dc3545;
            font-weight: bold;
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

        .no-applications {
            text-align: center;
            padding: 40px;
            color: #666;
        }

        .no-applications h3 {
            margin-bottom: 10px;
            color: #333;
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
                        <button type="submit" name="logout" style="background: #dc3545; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer;">Logout</button>
                    </form>
                <?php endif; ?>
                <a href="profile.php" class="back-home">Back to Profile</a>
            </div>
        </div>

        <div class="progress-section">
            <h1>Track the process</h1>
            <div class="scholarship-progress">
                <?php if(!empty($applications)): ?>
                    <?php foreach($applications as $app): ?>
                    <div class="scholarship-card">
                        <div class="scholarship-header">
                            <div class="scholarship-name"><?php echo htmlspecialchars($app['Program']); ?></div>
                            <div class="scholarship-status"><?php echo $app['Status']; ?></div>
                        </div>
                        <div class="university">University: <?php echo htmlspecialchars($app['University']); ?></div>
                        <div class="progress-details">
                            <div class="detail-group">
                                <span class="detail-label">Date of apply:</span>
                                <span class="detail-value"><?php echo htmlspecialchars($app['ApplicationDate']); ?></span>
                            </div>
                            <div class="detail-group">
                                <span class="detail-label">Field of Scholarship:</span>
                                <span class="detail-value"><?php echo htmlspecialchars($app['Program']); ?></span>
                            </div>
                            <div class="detail-group">
                                <span class="detail-label">Exam:</span>
                                <span class="detail-value <?php echo $app['ExamClass']; ?>"><?php echo $app['ExamResult']; ?></span>
                            </div>
                            <div class="detail-group">
                                <span class="detail-label">Interview:</span>
                                <span class="detail-value <?php echo $app['InterviewClass']; ?>"><?php echo $app['InterviewResult']; ?></span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-applications">
                        <h3>No scholarships applied yet</h3>
                        <p>Start applying to see your progress here!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="action-buttons">
            <a href="profile.php" class="btn btn-primary">Back to profile page</a>
            <a href="#" class="btn btn-secondary">Find More Scholarships</a>
        </div>
    </div>
</body>
</html>