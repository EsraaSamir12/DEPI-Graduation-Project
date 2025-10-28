<?php
include("connection.php");

// البحث
$search = "";
if(isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    
    // البحث في الجداول الثلاثة
    $query = "SELECT s.Schol_ID, s.Program, s.TeachingLanguage, s.Degree, 
                     u.University, u.Location, u.Rating,
                     f.MinScholarshipCoverageTuition, f.MaxScholarshipCoverageTuition
              FROM scholarship s 
              LEFT JOIN university u ON s.Uni_ID = u.Uni_ID 
              LEFT JOIN Financedetails f ON s.FinanceID = f.FinanceID 
              WHERE s.Program LIKE '%$search%' 
                 OR s.TeachingLanguage LIKE '%$search%' 
                 OR s.Degree LIKE '%$search%' 
                 OR u.University LIKE '%$search%'
                 OR u.Location LIKE '%$search%'
                 OR u.Rating LIKE '%$search%'
                 OR f.TuitionCategoryType LIKE '%$search%'
              ORDER BY s.Program";
} else {
    // بدون بحث - كل المنح
    $query = "SELECT s.Schol_ID, s.Program, s.TeachingLanguage, s.Degree, 
                     u.University, u.Location, u.Rating,
                     f.MinScholarshipCoverageTuition, f.MaxScholarshipCoverageTuition
              FROM scholarship s 
              LEFT JOIN university u ON s.Uni_ID = u.Uni_ID 
              LEFT JOIN Financedetails f ON s.FinanceID = f.FinanceID 
              ORDER BY s.Program";
}

$result = mysqli_query($connect, $query);

if($result === false) {
    die("Query failed: " . mysqli_error($connect));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home - Scholarships</title>
    <style>
        .scholarship-card {
            border: 1px solid #ddd;
            padding: 20px;
            margin: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            width: 300px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .cards-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .error { color: red; }
        .details-btn {
            display: inline-block;
            padding: 10px 15px;
            background: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }
        .details-btn:hover {
            background: #218838;
        }
        /* إضافة ستايلات البحث */
        .search-box {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            text-align: center;
        }
        .search-input {
            width: 70%;
            padding: 12px 20px;
            border: 2px solid #007bff;
            border-radius: 25px;
            font-size: 16px;
            outline: none;
        }
        .search-btn {
            padding: 12px 30px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 25px;
            margin-left: 10px;
            cursor: pointer;
            font-size: 16px;
        }
        .search-btn:hover {
            background: #0056b3;
        }
        .results-count {
            margin: 15px 0;
            color: #666;
            font-style: italic;
        }
        .clear-search {
            display: inline-block;
            margin-left: 10px;
            color: #007bff;
            text-decoration: none;
        }
        .university-info {
            background: #e9ecef;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
        }
        .funding-info {
            background: #d4edda;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
            color: #155724;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- صندوق البحث -->
        <div class="search-box">
            <h2>🔍 Search Scholarships</h2>
            <form action="" method="GET">
                <input type="text" name="search" class="search-input" 
                       placeholder="Search by program, university, location, degree, language, rating..." 
                       value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit" class="search-btn">Search</button>
                <?php if(!empty($search)): ?>
                    <a href="home.php" class="clear-search">Clear Search</a>
                <?php endif; ?>
            </form>
            
            <?php if(!empty($search)): ?>
                <div class="results-count">
                    Search results for: "<strong><?php echo htmlspecialchars($search); ?></strong>"
                </div>
            <?php endif; ?>
        </div>

        <h1>Available Scholarships</h1>
        
        <div class="cards-container">
            <?php 
            $count = mysqli_num_rows($result);
            
            if($count > 0) {
                if(!empty($search)) {
                    echo "<div class='results-count'>Found $count scholarship(s)</div>";
                }
                
                while($row = mysqli_fetch_assoc($result)): ?>
                    <div class="scholarship-card">
                        <h3>Program: <?php echo $row['Program']; ?></h3>
                        <p><strong>Teaching Language:</strong> <?php echo $row['TeachingLanguage']; ?></p>
                        <p><strong>Degree:</strong> <?php echo $row['Degree']; ?></p>
                        
                        <!-- معلومات إضافية من البحث -->
                        <?php if(!empty($row['StudyField'])): ?>
                            <p><strong>Field:</strong> <?php echo $row['StudyField']; ?></p>
                        <?php endif; ?>
                        
                        <?php if(!empty($row['University'])): ?>
                            <div class="university-info">
                                <p><strong>University:</strong> <?php echo $row['University']; ?></p>
                                <p><strong>Location:</strong> <?php echo $row['Location']; ?></p>
                                <?php if(!empty($row['Rating'])): ?>
                                    <p><strong>Rating:</strong> <?php echo $row['Rating']; ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if(!empty($row['MinScholarshipCoverageTuition'])): ?>
                            <div class="funding-info">
                                <p><strong>Tuition Coverage:</strong> 
                                    $<?php echo $row['MinScholarshipCoverageTuition']; ?>
                                    <?php if(!empty($row['MaxScholarshipCoverageTuition'])): ?>
                                        - $<?php echo $row['MaxScholarshipCoverageTuition']; ?>
                                    <?php endif; ?>
                                </p>
                            </div>
                        <?php endif; ?>
                        
                        <a href="details.php?schol_id=<?php echo $row['Schol_ID']; ?>" class="details-btn">
                            MORE DETAILS
                        </a>
                    </div>
                <?php endwhile;
            } else {
                if(!empty($search)) {
                    echo "<div class='error'>No scholarships found for: '" . htmlspecialchars($search) . "'</div>";
                    echo "<p>Try searching with different keywords like: Computer Science, Engineering, USA, Bachelor, English, etc.</p>";
                } else {
                    echo "<p class='error'>No scholarships found.</p>";
                }
            }
            ?>
        </div>
    </div>
</body>
</html>