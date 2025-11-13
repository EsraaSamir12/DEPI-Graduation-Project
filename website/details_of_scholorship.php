<?php
include("connection.php");

$schol_id = isset($_GET['schol_id']) ? $_GET['schol_id'] : 0;

$query = "SELECT s.*, u.*, f.*
          FROM scholarship s 
          LEFT JOIN university u ON s.Uni_ID = u.Uni_ID 
          LEFT JOIN Financedetails f ON s.FinanceID = f.FinanceID 
          WHERE s.Schol_ID = $schol_id";

$result = mysqli_query($connect, $query);

if($result === false) {
    die("Query failed: " . mysqli_error($connect));
}

$scholarship = mysqli_fetch_assoc($result);

if(!$scholarship) {
    die("Scholarship not found");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details - <?php echo $scholarship['Program']; ?></title>
    <link rel="stylesheet" href="style.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #209672ff 0%, #f8f9fa);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: #fff;
            color: #333;
            text-decoration: none;
            border-radius: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .back-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
            background: #f8f9fa;
        }
        
        .details-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
        }
        
        .program-header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f1f3f4;
        }
        
        .program-header h1 {
            font-size: 2.5rem;
            color: #2c3e50;
            margin-bottom: 10px;
            background: linear-gradient(135deg, #4a8b78ff, #209672ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .program-header .degree-badge {
            display: inline-block;
            background: #e3f2fd;
            color: #1976d2;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .detail-section {
            margin: 30px 0;
            padding: 25px;
            background: #f8f9fa;
            border-radius: 15px;
            border-left: 4px solid #4a8b78ff;
            transition: transform 0.3s ease;
        }
        
        .detail-section:hover {
            transform: translateX(5px);
        }
        
        .detail-section h3 {
            color: #2c3e50;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1.3rem;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        
        .info-item {
            background: white;
            padding: 20px;
            border-radius: 12px;
            border: 1px solid #e9ecef;
            transition: all 0.3s ease;
        }
        
        .info-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        
        .info-item strong {
            color: #495057;
            display: block;
            margin-bottom: 8px;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .timeline {
            position: relative;
            padding: 20px 0;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            left: 25px;
            top: 0;
            bottom: 0;
            width: 3px;
            border-radius: 2px;
        }
        
        .timeline-item {
            position: relative;
            margin-bottom: 35px;
            padding-left: 70px;
        }
        
        .timeline-item::before {
            content: '';
            position: absolute;
            left: 18px;
            top: 8px;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #4a8b78ff;
            border: 4px solid white;
            box-shadow: 0 0 #4a8b78ff;
        }
        
        .timeline-date {
            font-weight: 600;
            color: #4a8b78ff;
            margin-bottom: 8px;
            font-size: 1.1rem;
        }
        
        .apply-btn {
            display: inline-block;
            background: linear-gradient(135deg, #4a8b78ff, #209672ff);
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }
        
        .apply-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }
        
        .icon {
            font-size: 24px;
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }
            
            .details-card {
                padding: 20px;
            }
            
            .program-header h1 {
                font-size: 2rem;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
            }
            
            .timeline-item {
                padding-left: 50px;
            }
            
            .timeline::before {
                left: 15px;
            }
            
            .timeline-item::before {
                left: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <a href="index.php" class="back-btn">← Back to Scholarships</a>
            
            <?php if(isLoggedIn()): ?>
                <div style="display: flex; align-items: center; gap: 15px;">
                    <span style="color: white;">Welcome, <?php echo getUserName(); ?></span>
                    <form method="POST" style="display: inline;">
                        <button type="submit" name="logout" style="background: #dc3545; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer;">Logout</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="details-card">
            <div class="program-header">
                <h1>🎓 <?php echo $scholarship['Program']; ?></h1>
                <span class="degree-badge"><?php echo $scholarship['Degree']; ?> Program</span>
            </div>
            
            <div class="detail-section">
                <h3><span class="icon">📚</span> Program Details</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <strong>Program Name</strong>
                        <?php echo $scholarship['Program']; ?>
                    </div>
                    <div class="info-item">
                        <strong>Teaching Language</strong>
                        <?php echo $scholarship['TeachingLanguage']; ?>
                    </div>
                    <div class="info-item">
                        <strong>Degree Level</strong>
                        <?php echo $scholarship['Degree']; ?>
                    </div>
                </div>
            </div>

            <div class="detail-section">
                <h3><span class="icon">🏫</span> University Information</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <strong>University</strong>
                        <?php echo $scholarship['University']; ?>
                    </div>
                    <div class="info-item">
                        <strong>Location</strong>
                        <?php echo $scholarship['Location']; ?>
                    </div>
                    <?php if(!empty($scholarship['Rating'])): ?>
                    <div class="info-item">
                        <strong>University Rating</strong>
                        ⭐ <?php echo $scholarship['Rating']; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="detail-section">
                <h3><span class="icon">⏰</span> Program Timeline</h3>
                <div class="timeline">
                    <?php if(!empty($scholarship['Duration'])): ?>
                    <div class="timeline-item">
                        <div class="timeline-date">📅 Program Duration</div>
                        <div><?php echo $scholarship['Duration']; ?> 
                            <?php if(!empty($scholarship['DurationCategoryType'])): ?>
                                (<?php echo $scholarship['DurationCategoryType']; ?>)
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if(!empty($scholarship['StartingDate'])): ?>
                    <div class="timeline-item">
                        <div class="timeline-date">🎯 Starting Date</div>
                        <div><?php echo $scholarship['StartingDate']; ?></div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if(!empty($scholarship['DeadlineForDocuments'])): ?>
                    <div class="timeline-item">
                        <div class="timeline-date">📄 Documents Deadline</div>
                        <div><?php echo $scholarship['DeadlineForDocuments']; ?></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="detail-section">
                <h3><span class="icon">💰</span> Financial Information</h3>
                <div class="info-grid">
                    <?php if(!empty($scholarship['MinScholarshipCoverageTuition'])): ?>
                    <div class="info-item">
                        <strong>Minimum Tuition Coverage</strong>
                        $<?php echo number_format($scholarship['MinScholarshipCoverageTuition'], 2); ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php if(!empty($scholarship['MaxScholarshipCoverageTuition'])): ?>
                    <div class="info-item">
                        <strong>Maximum Tuition Coverage</strong>
                        $<?php echo number_format($scholarship['MaxScholarshipCoverageTuition'], 2); ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php if(!empty($scholarship['ScholarshipCoverageAccommodation'])): ?>
                    <div class="info-item">
                        <strong>Accommodation Coverage</strong>
                        <?php echo $scholarship['ScholarshipCoverageAccommodation']; ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php if(!empty($scholarship['ScholarshipCoverageLivingExpense'])): ?>
                    <div class="info-item">
                        <strong>Living Expenses Coverage</strong>
                        <?php echo $scholarship['ScholarshipCoverageLivingExpense']; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php if(!empty($scholarship['OfficialLink'])): ?>
            <div class="detail-section" style="text-align: center;">
                <h3><span class="icon">🔗</span> Ready to Apply?</h3>
                <p style="margin-bottom: 20px; color: #666;">Click the button below to start your application process</p>
                <a href="<?php echo $scholarship['OfficialLink']; ?>" target="_blank" class="apply-btn">
                    🌐 Start Application Now
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>