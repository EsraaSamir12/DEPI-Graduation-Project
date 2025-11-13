<?php
include("connection.php");

$search = "";
$show_scholarships = false;

if(isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    $show_scholarships = true;
}

if(isset($_GET['view_all']) && $_GET['view_all'] == '1') {
    $show_scholarships = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>ScholarVerse</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    .scholarship-card {
        border: 1px solid #ddd;
        padding: 20px;
        margin: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        width: 300px;
        background: white;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .scholarship-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    .cards-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        margin: 20px 0;
    }
    .search-results {
        background: #f8f9fa;
        padding: 30px;
        border-radius: 10px;
        margin-top: 20px;
    }
    .details-btn {
        display: inline-block;
        padding: 10px 15px;
        background: #28a745;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        margin-top: 10px;
        text-align: center;
        width: 100%;
    }
    .details-btn:hover {
        background: #218838;
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <header class="navbar">
    <div class="container nav-inner">
      <div class="brand">ScholarVerse</div>
      <nav class="nav-links center-links">
        <a href="index.php">Home</a>
        <a href="index.php#about">About</a>
        <a href="index.php?view_all=1">Scholarships</a>
        <a href="index.php#contact">Contact</a>
      </nav>
      <div class="auth-section">
        <?php if(isLoggedIn()): ?>
          <span style="color: white; margin-right: 15px;">Welcome, <?php echo getUserName(); ?></span>
          <form method="POST" style="display: inline;">
            <button type="submit" name="logout" class="auth-btn" style="background: #dc3545; border: none; color: white; padding: 10px 20px; border-radius: 5px; cursor: pointer;">Logout</button>
          </form>
        <?php else: ?>
          <a href="login.php" class="auth-btn">Sign in</a>
        <?php endif; ?>
      </div>
    </div>
  </header>

  <!-- ====== SEARCH SECTION ==-->
  <section class="search-section">
    <div class="container">
      <h2>Search Scholarships</h2>
      <p>Find scholarships by country, field, or keyword</p>
      <form action="" method="GET">
        <div class="search-bar">
          <input type="text" name="search" placeholder="Search by country, field, or keyword..." 
                 value="<?php echo htmlspecialchars($search); ?>" />
          <button type="submit">Search</button>
        </div>
      </form>

      <div class="view-all-container">
        <a href="index.php?view_all=1" class="view-all-btn">View All Scholarships</a>
      </div>
    </div>
  </section>

  <!-- ====== SCHOLARSHIPS RESULTS === -->
  <?php if($show_scholarships): ?>
  <section class="search-results">
    <div class="container">
      <h2 style="text-align: center; margin-bottom: 30px;">
        <?php echo !empty($search) ? "Search Results" : "All Scholarships"; ?>
      </h2>
      
      <div class="cards-container">
        <?php
        if(!empty($search)) {
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
            $query = "SELECT s.Schol_ID, s.Program, s.TeachingLanguage, s.Degree, 
                             u.University, u.Location, u.Rating,
                             f.MinScholarshipCoverageTuition, f.MaxScholarshipCoverageTuition
                      FROM scholarship s 
                      LEFT JOIN university u ON s.Uni_ID = u.Uni_ID 
                      LEFT JOIN Financedetails f ON s.FinanceID = f.FinanceID 
                      ORDER BY s.Program";
        }

        $result = mysqli_query($connect, $query);
        
        if($result && mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo '<div class="scholarship-card" onclick="window.location.href=\'details_of_scholorship.php?schol_id=' . $row['Schol_ID'] . '\'">';
                echo '<h3>' . htmlspecialchars($row['Program']) . '</h3>';
                echo '<p><strong>Degree:</strong> ' . htmlspecialchars($row['Degree']) . '</p>';
                echo '<p><strong>Teaching Language:</strong> ' . htmlspecialchars($row['TeachingLanguage']) . '</p>';
                
                if(!empty($row['University'])) {
                    echo '<div style="background: #e9ecef; padding: 10px; border-radius: 5px; margin: 10px 0;">';
                    echo '<p><strong>University:</strong> ' . htmlspecialchars($row['University']) . '</p>';
                    echo '<p><strong>Location:</strong> ' . htmlspecialchars($row['Location']) . '</p>';
                    if(!empty($row['Rating'])) {
                        echo '<p><strong>Rating:</strong> ' . htmlspecialchars($row['Rating']) . '</p>';
                    }
                    echo '</div>';
                }
                
                if(!empty($row['MinScholarshipCoverageTuition'])) {
                    echo '<div style="background: #d4edda; padding: 10px; border-radius: 5px; margin: 10px 0; color: #155724;">';
                    echo '<p><strong>Tuition Coverage:</strong> $' . $row['MinScholarshipCoverageTuition'];
                    if(!empty($row['MaxScholarshipCoverageTuition'])) {
                        echo ' - $' . $row['MaxScholarshipCoverageTuition'];
                    }
                    echo '</p>';
                    echo '</div>';
                }
                
                echo '<a href="details_of_scholorship.php?schol_id=' . $row['Schol_ID'] . '" class="details-btn">View Full Details</a>';
                echo '</div>';
            }
        } else {
            echo '<p style="text-align: center; color: #666; width: 100%;">No scholarships found.</p>';
        }
        ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <!-- ====== HERO SECTION === -->
  <section class="hero">
    <div class="hero-overlay">
      <div class="hero-content">
        <h1>Find Your Perfect Scholarship</h1>
        <p>Explore thousands of scholarships around the world.</p>
        <a href="sign_up.php" class="cta">Get Started</a>
      </div>
    </div>
  </section>

  <section class="scholarship-info">
    <h2 class="section-title">Know more about <span>Scholarships</span></h2>
    <div class="cards-container">
      <div class="info-card">
        <h3>What is a Scholarship</h3>
        <p>A scholarship is financial help given to students to continue their studies.</p>
        <a href="https://www.southalabama.edu/departments/financialaffairs/scholarships/whatisascholarship.html" target="_blank" class="learn-more">Learn more →</a>
      </div>
    </div>
  </section>

</body>
</html>