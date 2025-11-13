<?php
include("connection.php");

echo "<h3>Testing Database Connection</h3>";

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "✅ Database connected successfully<br>";
}

$tables = mysqli_query($connect, "SHOW TABLES");
echo "<h3>Available Tables:</h3>";
while ($table = mysqli_fetch_array($tables)) {
    echo "📊 " . $table[0] . "<br>";
}

echo "<h3>Scholarship Data:</h3>";
$result = mysqli_query($connect, "SELECT * FROM scholarship LIMIT 5");
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo "🎓 " . $row['Program'] . " (ID: " . $row['Schol_ID'] . ")<br>";
    }
} else {
    echo "❌ No scholarships found";
}
?>