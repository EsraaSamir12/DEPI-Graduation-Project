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
<html>
<head>
    <title>Details - <?php echo $scholarship['Program']; ?></title>
    <style>
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }
        .details-card {
            border: 1px solid #ddd;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            background: white;
        }
        .back-btn {
            display: inline-block;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 20px;
            transition: 0.3s;
        }
        .back-btn:hover {
            background: #0056b3;
            transform: translateY(-2px);
        }
        .detail-section {
            margin: 25px 0;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            border-left: 4px solid #007bff;
        }
        .detail-section h3 {
            margin-top: 0;
            color: #2c3e50;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }
        .info-item {
            padding: 10px;
            background: white;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }
        .info-item strong {
            color: #495057;
            display: block;
            margin-bottom: 5px;
        }
        
        .timeline {
            position: relative;
            padding: 20px 0;
        }
        .timeline::before {
            content: '';
            position: absolute;
            left: 20px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #007bff;
        }
        .timeline-item {
            position: relative;
            margin-bottom: 30px;
            padding-left: 50px;
        }
        .timeline-item::before {
            content: '';
            position: absolute;
            left: 12px;
            top: 5px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #007bff;
            border: 3px solid white;
        }
        .timeline-date {
            font-weight: bold;
            color: #007bff;
            margin-bottom: 5px;
        }
        
        /* Icons */
        .icon {
            font-size: 20px;
        }
        .money { color: #28a745; }
        .calendar { color: #dc3545; }
        .university { color: #6f42c1; }
    </style>
</head>
<body>
    <div class="container">
        <a href="All_scholorships.php" class="back-btn">← Back to Scholarships</a>
        
        <div class="details-card">
            <h1 style="text-align: center; color: #2c3e50; margin-bottom: 30px;">🎓 <?php echo $scholarship['Program']; ?></h1>
            
            <!-- المعلومات الأساسية -->
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
                        <strong>Degree</strong>
                        <?php echo $scholarship['Degree']; ?>
                    </div>
                    <div class="info-item">
                        <strong>Study Field</strong>
                        <?php echo $scholarship['StudyField']; ?>
                    </div>
                </div>
            </div>

            <div class="detail-section">
                <h3><span class="icon university">🏫</span> University Information</h3>
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
                        <?php echo $scholarship['Rating']; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Timeline -->
            <div class="detail-section">
                <h3><span class="icon calendar">⏰</span> Program Timeline</h3>
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
                        <div class="timeline-date">📄 Deadline For Documents</div>
                        <div><?php echo $scholarship['DeadlineForDocuments']; ?></div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if(!empty($scholarship['StartYear']) && !empty($scholarship['StartMonth'])): ?>
                    <div class="timeline-item">
                        <div class="timeline-date">📅 Start Year/Month</div>
                        <div>Year: <?php echo $scholarship['StartYear']; ?>, Month: <?php echo $scholarship['StartMonth']; ?></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- المعلومات المالية -->
            <div class="detail-section">
                <h3><span class="icon money">💰</span> Financial Information</h3>
                <div class="info-grid">
                    <?php if(!empty($scholarship['MinScholarshipCoverageTuition'])): ?>
                    <div class="info-item">
                        <strong>Min Scholarship Coverage (Tuition)</strong>
                        $<?php echo $scholarship['MinScholarshipCoverageTuition']; ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php if(!empty($scholarship['MaxScholarshipCoverageTuition'])): ?>
                    <div class="info-item">
                        <strong>Max Scholarship Coverage (Tuition)</strong>
                        $<?php echo $scholarship['MaxScholarshipCoverageTuition']; ?>
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
                        <strong>Living Expense Coverage</strong>
                        <?php echo $scholarship['ScholarshipCoverageLivingExpense']; ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php if(!empty($scholarship['TuitionCategoryType'])): ?>
                    <div class="info-item">
                        <strong>Tuition Category Type</strong>
                        <?php echo $scholarship['TuitionCategoryType']; ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php if(!empty($scholarship['DeadlineForPayment'])): ?>
                    <div class="info-item">
                        <strong>Deadline For Payment</strong>
                        <?php echo $scholarship['DeadlineForPayment']; ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php if(!empty($scholarship['MinApplicationServiceFeeByDollars'])): ?>
                    <div class="info-item">
                        <strong>Min Application Service Fee</strong>
                        $<?php echo $scholarship['MinApplicationServiceFeeByDollars']; ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php if(!empty($scholarship['MaxApplicationServiceFeeByDollars'])): ?>
                    <div class="info-item">
                        <strong>Max Application Service Fee</strong>
                        $<?php echo $scholarship['MaxApplicationServiceFeeByDollars']; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- روابط -->
            <?php if(!empty($scholarship['OfficialLink'])): ?>
            <div class="detail-section">
                <h3><span class="icon">🔗</span> Important Links</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <strong>Application Link</strong>
                        <a href="<?php echo $scholarship['OfficialLink']; ?>" target="_blank" style="color: #007bff; text-decoration: none; font-weight: bold;">
                            🌐 Apply Now
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>
</body>
</html>