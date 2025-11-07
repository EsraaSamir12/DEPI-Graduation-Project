<?php
include("connection.php");

$query = "SELECT Schol_ID, Program, TeachingLanguage, Degree FROM scholarship";
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Available Scholarships</h1>
        
        <div class="cards-container">
            <?php 
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)): ?>
                    <div class="scholarship-card">
                        <h3>Program: <?php echo $row['Program']; ?></h3>
                        <p><strong>Teaching Language:</strong> <?php echo $row['TeachingLanguage']; ?></p>
                        <p><strong>Degree:</strong> <?php echo $row['Degree']; ?></p>
                        
                     <a href="details.php?schol_id=<?php echo $row['Schol_ID']; ?>" class="details-btn">
                            MORE DETAILS
                        </a>
                    </div>
                <?php endwhile;
            } else {
                echo "<p class='error'>No scholarships found.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>