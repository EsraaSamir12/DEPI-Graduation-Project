
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Find Scholarships - ScholarVerse</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <header class="navbar">
    <div class="container nav-inner">
      <div class="brand">ScholarVerse</div>
      <nav class="nav-links center-links">
        <a href="index.php">Home</a>
        <a href="index.php#about">About</a>
        <a href="scholarships.html" class="active">Scholarships</a>
        <a href="index.php#contact">Contact</a>
      </nav>
      <div class="auth-section">
        <a href="signup.html" class="auth-btn">Sign in</a>
      </div>
    </div>
  </header>

  <div style="margin-top: 100px;"></div>

  <section class="scholarship-form-section">
    <h2>Find the Best Scholarships for You 🎓</h2>
    <form class="scholarship-form">
      <label>Full Name:</label>
      <input type="text" placeholder="Enter your name" required>

      <label>Phone Number:</label>
      <input type="tel" placeholder="Enter your phone" required>

      <label>Current Country:</label>
      <input type="text" placeholder="Where are you from?" required>

      <label>Destination Country:</label>
      <input type="text" placeholder="Where do you want to study?" required>

      <label>Field of Study:</label>
      <input type="text" placeholder="Your major or field" required>

      <label>Study Level:</label>
      <select required>
        <option value="">Select level</option>
        <option>Undergraduate</option>
        <option>Master’s</option>
        <option>PhD</option>
      </select>

      <label>Funding Type:</label>
      <select required>
        <option value="">Select funding type</option>
        <option>Fully Funded</option>
        <option>Partially Funded</option>
      </select>

      <button type="submit" class="submit-btn">Find Scholarships</button>
    </form>
  </section>
   <script src="main.js"></script>
</body>
</html>
