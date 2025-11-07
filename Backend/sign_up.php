<?php
include("connection.php");

$error_msg = "";
$FullName = "";
$Email = "";
$password = "";
$confirm_pass = "";
$Nationality = "";
$CurrentLevel = "";
$Major = "";
$Gender = "";
$GPA = "";
$Country = "";
$City = "";

if(isset($_POST['submit'])){  
    $FullName = isset($_POST['FullName']) ? $_POST['FullName'] : "";
    $Email = isset($_POST['Email']) ? $_POST['Email'] : "";
    $password = isset($_POST['password']) ? $_POST['password'] : "";
    $confirm_pass = isset($_POST['confirm_pass']) ? $_POST['confirm_pass'] : "";
    $Nationality = isset($_POST['Nationality']) ? $_POST['Nationality'] : "";
    $CurrentLevel = isset($_POST['CurrentLevel']) ? $_POST['CurrentLevel'] : "";
    $Major = isset($_POST['Major']) ? $_POST['Major'] : "";
    $Gender = isset($_POST['Gender']) ? $_POST['Gender'] : "";
    $GPA = isset($_POST['GPA']) ? $_POST['GPA'] : "";
    $Country = isset($_POST['Country']) ? $_POST['Country'] : "";
    $City = isset($_POST['City']) ? $_POST['City'] : "";
    
    $passwordhashing = password_hash($password, PASSWORD_DEFAULT);
    
    $lowercase = preg_match('@[a-z]@', $password);
    $uppercase = preg_match('@[A-Z]@', $password);
    $numbers = preg_match('@[0-9]@', $password);
    
    $select = "SELECT * FROM `applicant` WHERE `Email` = '$Email'";
    $run_select = mysqli_query($connect, $select);
    
    if($run_select === false) {
        $error_msg = "Database error: " . mysqli_error($connect);
    } else {
        $rows = mysqli_num_rows($run_select);
        
        if(empty($FullName) || empty($Email) || empty($password) || empty($confirm_pass) || empty($Nationality) || empty($CurrentLevel) || empty($Major) || empty($Gender) || empty($GPA) || empty($Country) || empty($City)){
            $error_msg = "Please fill all required data";
        } elseif($rows > 0){
            $error_msg = "This email is already taken";
        } elseif($lowercase < 1 || $uppercase < 1 || $numbers < 1){
            $error_msg = "Password must contain at least 1 uppercase, 1 lowercase and number";
        } elseif($password != $confirm_pass){
            $error_msg = "Password doesn't match confirmed password";
        } else {
            // Insert into database with correct column names
            $insert = "INSERT INTO applicant (FullName, Email, password, Nationality, CurrentLevel, Major, Gender, GPA, Country, City) 
                       VALUES ('$FullName', '$Email', '$passwordhashing', '$Nationality', '$CurrentLevel', '$Major', '$Gender', '$GPA', '$Country', '$City')";
            $run_insert = mysqli_query($connect, $insert);
            
            if($run_insert){
                echo "<script>alert('Registration successful!');</script>";
                // Clear form after successful registration
                $FullName = $Email = $Nationality = $CurrentLevel = $Major = $Gender = $GPA = $Country = $City = "";
            } else {
                $error_msg = "Error: " . mysqli_error($connect);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
    <style>
        .error { color: red; }
        div { margin: 10px 0; }
        label { display: inline-block; width: 150px; }
    </style>
</head>
<body>
    <h1>Signup</h1>
    
    <?php if(!empty($error_msg)): ?>
        <div class="error"><?php echo $error_msg; ?></div>
    <?php endif; ?>
    
    <form action="" method="post" id="signup" novalidate>
        <div>
            <label for="FullName">Full Name</label>
            <input type="text" id="FullName" name="FullName" value="<?php echo htmlspecialchars($FullName); ?>" required>
        </div>
        
        <div>
            <label for="Email">Email</label>
            <input type="email" id="Email" name="Email" value="<?php echo htmlspecialchars($Email); ?>" required>
        </div>
        
        <div>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        
        <div>
            <label for="confirm_pass">Repeat password</label>
            <input type="password" id="confirm_pass" name="confirm_pass" required>
        </div>
        
        <div>
            <label for="Nationality">Nationality</label>
            <select id="Nationality" name="Nationality" required>
    <option value="Afghan" <?php echo ($Nationality == 'Afghan') ? 'selected' : ''; ?>>Afghan</option>
    <option value="Albanian" <?php echo ($Nationality == 'Albanian') ? 'selected' : ''; ?>>Albanian</option>
    <option value="Algerian" <?php echo ($Nationality == 'Algerian') ? 'selected' : ''; ?>>Algerian</option>
    <option value="American" <?php echo ($Nationality == 'American') ? 'selected' : ''; ?>>American</option>
    <option value="Andorran" <?php echo ($Nationality == 'Andorran') ? 'selected' : ''; ?>>Andorran</option>
    <option value="Angolan" <?php echo ($Nationality == 'Angolan') ? 'selected' : ''; ?>>Angolan</option>
    <option value="Antiguans" <?php echo ($Nationality == 'Antiguans') ? 'selected' : ''; ?>>Antiguans</option>
    <option value="Argentinean" <?php echo ($Nationality == 'Argentinean') ? 'selected' : ''; ?>>Argentinean</option>
    <option value="Armenian" <?php echo ($Nationality == 'Armenian') ? 'selected' : ''; ?>>Armenian</option>
    <option value="Australian" <?php echo ($Nationality == 'Australian') ? 'selected' : ''; ?>>Australian</option>
    <option value="Austrian" <?php echo ($Nationality == 'Austrian') ? 'selected' : ''; ?>>Austrian</option>
    <option value="Azerbaijani" <?php echo ($Nationality == 'Azerbaijani') ? 'selected' : ''; ?>>Azerbaijani</option>
    <option value="Bahamian" <?php echo ($Nationality == 'Bahamian') ? 'selected' : ''; ?>>Bahamian</option>
    <option value="Bahraini" <?php echo ($Nationality == 'Bahraini') ? 'selected' : ''; ?>>Bahraini</option>
    <option value="Bangladeshi" <?php echo ($Nationality == 'Bangladeshi') ? 'selected' : ''; ?>>Bangladeshi</option>
    <option value="Barbadian" <?php echo ($Nationality == 'Barbadian') ? 'selected' : ''; ?>>Barbadian</option>
    <option value="Barbudans" <?php echo ($Nationality == 'Barbudans') ? 'selected' : ''; ?>>Barbudans</option>
    <option value="Batswana" <?php echo ($Nationality == 'Batswana') ? 'selected' : ''; ?>>Batswana</option>
    <option value="Belarusian" <?php echo ($Nationality == 'Belarusian') ? 'selected' : ''; ?>>Belarusian</option>
    <option value="Belgian" <?php echo ($Nationality == 'Belgian') ? 'selected' : ''; ?>>Belgian</option>
    <option value="Belizean" <?php echo ($Nationality == 'Belizean') ? 'selected' : ''; ?>>Belizean</option>
    <option value="Beninese" <?php echo ($Nationality == 'Beninese') ? 'selected' : ''; ?>>Beninese</option>
    <option value="Bhutanese" <?php echo ($Nationality == 'Bhutanese') ? 'selected' : ''; ?>>Bhutanese</option>
    <option value="Bolivian" <?php echo ($Nationality == 'Bolivian') ? 'selected' : ''; ?>>Bolivian</option>
    <option value="Bosnian" <?php echo ($Nationality == 'Bosnian') ? 'selected' : ''; ?>>Bosnian</option>
    <option value="Brazilian" <?php echo ($Nationality == 'Brazilian') ? 'selected' : ''; ?>>Brazilian</option>
    <option value="British" <?php echo ($Nationality == 'British') ? 'selected' : ''; ?>>British</option>
    <option value="Bruneian" <?php echo ($Nationality == 'Bruneian') ? 'selected' : ''; ?>>Bruneian</option>
    <option value="Bulgarian" <?php echo ($Nationality == 'Bulgarian') ? 'selected' : ''; ?>>Bulgarian</option>
    <option value="Burkinabe" <?php echo ($Nationality == 'Burkinabe') ? 'selected' : ''; ?>>Burkinabe</option>
    <option value="Burmese" <?php echo ($Nationality == 'Burmese') ? 'selected' : ''; ?>>Burmese</option>
    <option value="Burundian" <?php echo ($Nationality == 'Burundian') ? 'selected' : ''; ?>>Burundian</option>
    <option value="Cambodian" <?php echo ($Nationality == 'Cambodian') ? 'selected' : ''; ?>>Cambodian</option>
    <option value="Cameroonian" <?php echo ($Nationality == 'Cameroonian') ? 'selected' : ''; ?>>Cameroonian</option>
    <option value="Canadian" <?php echo ($Nationality == 'Canadian') ? 'selected' : ''; ?>>Canadian</option>
    <option value="Cape Verdean" <?php echo ($Nationality == 'Cape Verdean') ? 'selected' : ''; ?>>Cape Verdean</option>
    <option value="Central African" <?php echo ($Nationality == 'Central African') ? 'selected' : ''; ?>>Central African</option>
    <option value="Chadian" <?php echo ($Nationality == 'Chadian') ? 'selected' : ''; ?>>Chadian</option>
    <option value="Chilean" <?php echo ($Nationality == 'Chilean') ? 'selected' : ''; ?>>Chilean</option>
    <option value="Chinese" <?php echo ($Nationality == 'Chinese') ? 'selected' : ''; ?>>Chinese</option>
    <option value="Colombian" <?php echo ($Nationality == 'Colombian') ? 'selected' : ''; ?>>Colombian</option>
    <option value="Comoran" <?php echo ($Nationality == 'Comoran') ? 'selected' : ''; ?>>Comoran</option>
    <option value="Congolese" <?php echo ($Nationality == 'Congolese') ? 'selected' : ''; ?>>Congolese</option>
    <option value="Costa Rican" <?php echo ($Nationality == 'Costa Rican') ? 'selected' : ''; ?>>Costa Rican</option>
    <option value="Croatian" <?php echo ($Nationality == 'Croatian') ? 'selected' : ''; ?>>Croatian</option>
    <option value="Cuban" <?php echo ($Nationality == 'Cuban') ? 'selected' : ''; ?>>Cuban</option>
    <option value="Cypriot" <?php echo ($Nationality == 'Cypriot') ? 'selected' : ''; ?>>Cypriot</option>
    <option value="Czech" <?php echo ($Nationality == 'Czech') ? 'selected' : ''; ?>>Czech</option>
    <option value="Danish" <?php echo ($Nationality == 'Danish') ? 'selected' : ''; ?>>Danish</option>
    <option value="Djibouti" <?php echo ($Nationality == 'Djibouti') ? 'selected' : ''; ?>>Djibouti</option>
    <option value="Dominican" <?php echo ($Nationality == 'Dominican') ? 'selected' : ''; ?>>Dominican</option>
    <option value="Dutch" <?php echo ($Nationality == 'Dutch') ? 'selected' : ''; ?>>Dutch</option>
    <option value="East Timorese" <?php echo ($Nationality == 'East Timorese') ? 'selected' : ''; ?>>East Timorese</option>
    <option value="Ecuadorean" <?php echo ($Nationality == 'Ecuadorean') ? 'selected' : ''; ?>>Ecuadorean</option>
    <option value="Egyptian" <?php echo ($Nationality == 'Egyptian') ? 'selected' : ''; ?>>Egyptian</option>
    <option value="Emirian" <?php echo ($Nationality == 'Emirian') ? 'selected' : ''; ?>>Emirian</option>
    <option value="Equatorial Guinean" <?php echo ($Nationality == 'Equatorial Guinean') ? 'selected' : ''; ?>>Equatorial Guinean</option>
    <option value="Eritrean" <?php echo ($Nationality == 'Eritrean') ? 'selected' : ''; ?>>Eritrean</option>
    <option value="Estonian" <?php echo ($Nationality == 'Estonian') ? 'selected' : ''; ?>>Estonian</option>
    <option value="Ethiopian" <?php echo ($Nationality == 'Ethiopian') ? 'selected' : ''; ?>>Ethiopian</option>
    <option value="Fijian" <?php echo ($Nationality == 'Fijian') ? 'selected' : ''; ?>>Fijian</option>
    <option value="Filipino" <?php echo ($Nationality == 'Filipino') ? 'selected' : ''; ?>>Filipino</option>
    <option value="Finnish" <?php echo ($Nationality == 'Finnish') ? 'selected' : ''; ?>>Finnish</option>
    <option value="French" <?php echo ($Nationality == 'French') ? 'selected' : ''; ?>>French</option>
    <option value="Gabonese" <?php echo ($Nationality == 'Gabonese') ? 'selected' : ''; ?>>Gabonese</option>
    <option value="Gambian" <?php echo ($Nationality == 'Gambian') ? 'selected' : ''; ?>>Gambian</option>
    <option value="Georgian" <?php echo ($Nationality == 'Georgian') ? 'selected' : ''; ?>>Georgian</option>
    <option value="German" <?php echo ($Nationality == 'German') ? 'selected' : ''; ?>>German</option>
    <option value="Ghanaian" <?php echo ($Nationality == 'Ghanaian') ? 'selected' : ''; ?>>Ghanaian</option>
    <option value="Greek" <?php echo ($Nationality == 'Greek') ? 'selected' : ''; ?>>Greek</option>
    <option value="Grenadian" <?php echo ($Nationality == 'Grenadian') ? 'selected' : ''; ?>>Grenadian</option>
    <option value="Guatemalan" <?php echo ($Nationality == 'Guatemalan') ? 'selected' : ''; ?>>Guatemalan</option>
    <option value="Guinea-Bissauan" <?php echo ($Nationality == 'Guinea-Bissauan') ? 'selected' : ''; ?>>Guinea-Bissauan</option>
    <option value="Guinean" <?php echo ($Nationality == 'Guinean') ? 'selected' : ''; ?>>Guinean</option>
    <option value="Guyanese" <?php echo ($Nationality == 'Guyanese') ? 'selected' : ''; ?>>Guyanese</option>
    <option value="Haitian" <?php echo ($Nationality == 'Haitian') ? 'selected' : ''; ?>>Haitian</option>
    <option value="Herzegovinian" <?php echo ($Nationality == 'Herzegovinian') ? 'selected' : ''; ?>>Herzegovinian</option>
    <option value="Honduran" <?php echo ($Nationality == 'Honduran') ? 'selected' : ''; ?>>Honduran</option>
    <option value="Hungarian" <?php echo ($Nationality == 'Hungarian') ? 'selected' : ''; ?>>Hungarian</option>
    <option value="I-Kiribati" <?php echo ($Nationality == 'I-Kiribati') ? 'selected' : ''; ?>>I-Kiribati</option>
    <option value="Icelander" <?php echo ($Nationality == 'Icelander') ? 'selected' : ''; ?>>Icelander</option>
    <option value="Indian" <?php echo ($Nationality == 'Indian') ? 'selected' : ''; ?>>Indian</option>
    <option value="Indonesian" <?php echo ($Nationality == 'Indonesian') ? 'selected' : ''; ?>>Indonesian</option>
    <option value="Iranian" <?php echo ($Nationality == 'Iranian') ? 'selected' : ''; ?>>Iranian</option>
    <option value="Iraqi" <?php echo ($Nationality == 'Iraqi') ? 'selected' : ''; ?>>Iraqi</option>
    <option value="Irish" <?php echo ($Nationality == 'Irish') ? 'selected' : ''; ?>>Irish</option>
    <option value="Israeli" <?php echo ($Nationality == 'Israeli') ? 'selected' : ''; ?>>Israeli</option>
    <option value="Italian" <?php echo ($Nationality == 'Italian') ? 'selected' : ''; ?>>Italian</option>
    <option value="Ivorian" <?php echo ($Nationality == 'Ivorian') ? 'selected' : ''; ?>>Ivorian</option>
    <option value="Jamaican" <?php echo ($Nationality == 'Jamaican') ? 'selected' : ''; ?>>Jamaican</option>
    <option value="Japanese" <?php echo ($Nationality == 'Japanese') ? 'selected' : ''; ?>>Japanese</option>
    <option value="Jordanian" <?php echo ($Nationality == 'Jordanian') ? 'selected' : ''; ?>>Jordanian</option>
    <option value="Kazakhstani" <?php echo ($Nationality == 'Kazakhstani') ? 'selected' : ''; ?>>Kazakhstani</option>
    <option value="Kenyan" <?php echo ($Nationality == 'Kenyan') ? 'selected' : ''; ?>>Kenyan</option>
    <option value="Kittian and Nevisian" <?php echo ($Nationality == 'Kittian and Nevisian') ? 'selected' : ''; ?>>Kittian and Nevisian</option>
    <option value="Kuwaiti" <?php echo ($Nationality == 'Kuwaiti') ? 'selected' : ''; ?>>Kuwaiti</option>
    <option value="Kyrgyz" <?php echo ($Nationality == 'Kyrgyz') ? 'selected' : ''; ?>>Kyrgyz</option>
    <option value="Laotian" <?php echo ($Nationality == 'Laotian') ? 'selected' : ''; ?>>Laotian</option>
    <option value="Latvian" <?php echo ($Nationality == 'Latvian') ? 'selected' : ''; ?>>Latvian</option>
    <option value="Lebanese" <?php echo ($Nationality == 'Lebanese') ? 'selected' : ''; ?>>Lebanese</option>
    <option value="Liberian" <?php echo ($Nationality == 'Liberian') ? 'selected' : ''; ?>>Liberian</option>
    <option value="Libyan" <?php echo ($Nationality == 'Libyan') ? 'selected' : ''; ?>>Libyan</option>
    <option value="Liechtensteiner" <?php echo ($Nationality == 'Liechtensteiner') ? 'selected' : ''; ?>>Liechtensteiner</option>
    <option value="Lithuanian" <?php echo ($Nationality == 'Lithuanian') ? 'selected' : ''; ?>>Lithuanian</option>
    <option value="Luxembourger" <?php echo ($Nationality == 'Luxembourger') ? 'selected' : ''; ?>>Luxembourger</option>
    <option value="Macedonian" <?php echo ($Nationality == 'Macedonian') ? 'selected' : ''; ?>>Macedonian</option>
    <option value="Malagasy" <?php echo ($Nationality == 'Malagasy') ? 'selected' : ''; ?>>Malagasy</option>
    <option value="Malawian" <?php echo ($Nationality == 'Malawian') ? 'selected' : ''; ?>>Malawian</option>
    <option value="Malaysian" <?php echo ($Nationality == 'Malaysian') ? 'selected' : ''; ?>>Malaysian</option>
    <option value="Maldivian" <?php echo ($Nationality == 'Maldivian') ? 'selected' : ''; ?>>Maldivian</option>
    <option value="Malian" <?php echo ($Nationality == 'Malian') ? 'selected' : ''; ?>>Malian</option>
    <option value="Maltese" <?php echo ($Nationality == 'Maltese') ? 'selected' : ''; ?>>Maltese</option>
    <option value="Marshallese" <?php echo ($Nationality == 'Marshallese') ? 'selected' : ''; ?>>Marshallese</option>
    <option value="Mauritanian" <?php echo ($Nationality == 'Mauritanian') ? 'selected' : ''; ?>>Mauritanian</option>
    <option value="Mauritian" <?php echo ($Nationality == 'Mauritian') ? 'selected' : ''; ?>>Mauritian</option>
    <option value="Mexican" <?php echo ($Nationality == 'Mexican') ? 'selected' : ''; ?>>Mexican</option>
    <option value="Micronesian" <?php echo ($Nationality == 'Micronesian') ? 'selected' : ''; ?>>Micronesian</option>
    <option value="Moldovan" <?php echo ($Nationality == 'Moldovan') ? 'selected' : ''; ?>>Moldovan</option>
    <option value="Monacan" <?php echo ($Nationality == 'Monacan') ? 'selected' : ''; ?>>Monacan</option>
    <option value="Mongolian" <?php echo ($Nationality == 'Mongolian') ? 'selected' : ''; ?>>Mongolian</option>
    <option value="Moroccan" <?php echo ($Nationality == 'Moroccan') ? 'selected' : ''; ?>>Moroccan</option>
    <option value="Mosotho" <?php echo ($Nationality == 'Mosotho') ? 'selected' : ''; ?>>Mosotho</option>
    <option value="Motswana" <?php echo ($Nationality == 'Motswana') ? 'selected' : ''; ?>>Motswana</option>
    <option value="Mozambican" <?php echo ($Nationality == 'Mozambican') ? 'selected' : ''; ?>>Mozambican</option>
    <option value="Namibian" <?php echo ($Nationality == 'Namibian') ? 'selected' : ''; ?>>Namibian</option>
    <option value="Nauruan" <?php echo ($Nationality == 'Nauruan') ? 'selected' : ''; ?>>Nauruan</option>
    <option value="Nepalese" <?php echo ($Nationality == 'Nepalese') ? 'selected' : ''; ?>>Nepalese</option>
    <option value="New Zealander" <?php echo ($Nationality == 'New Zealander') ? 'selected' : ''; ?>>New Zealander</option>
    <option value="Nicaraguan" <?php echo ($Nationality == 'Nicaraguan') ? 'selected' : ''; ?>>Nicaraguan</option>
    <option value="Nigerian" <?php echo ($Nationality == 'Nigerian') ? 'selected' : ''; ?>>Nigerian</option>
    <option value="Nigerien" <?php echo ($Nationality == 'Nigerien') ? 'selected' : ''; ?>>Nigerien</option>
    <option value="North Korean" <?php echo ($Nationality == 'North Korean') ? 'selected' : ''; ?>>North Korean</option>
    <option value="Northern Irish" <?php echo ($Nationality == 'Northern Irish') ? 'selected' : ''; ?>>Northern Irish</option>
    <option value="Norwegian" <?php echo ($Nationality == 'Norwegian') ? 'selected' : ''; ?>>Norwegian</option>
    <option value="Omani" <?php echo ($Nationality == 'Omani') ? 'selected' : ''; ?>>Omani</option>
    <option value="Pakistani" <?php echo ($Nationality == 'Pakistani') ? 'selected' : ''; ?>>Pakistani</option>
    <option value="Palauan" <?php echo ($Nationality == 'Palauan') ? 'selected' : ''; ?>>Palauan</option>
    <option value="Panamanian" <?php echo ($Nationality == 'Panamanian') ? 'selected' : ''; ?>>Panamanian</option>
    <option value="Papua New Guinean" <?php echo ($Nationality == 'Papua New Guinean') ? 'selected' : ''; ?>>Papua New Guinean</option>
    <option value="Paraguayan" <?php echo ($Nationality == 'Paraguayan') ? 'selected' : ''; ?>>Paraguayan</option>
    <option value="Peruvian" <?php echo ($Nationality == 'Peruvian') ? 'selected' : ''; ?>>Peruvian</option>
    <option value="Polish" <?php echo ($Nationality == 'Polish') ? 'selected' : ''; ?>>Polish</option>
    <option value="Portuguese" <?php echo ($Nationality == 'Portuguese') ? 'selected' : ''; ?>>Portuguese</option>
    <option value="Qatari" <?php echo ($Nationality == 'Qatari') ? 'selected' : ''; ?>>Qatari</option>
    <option value="Romanian" <?php echo ($Nationality == 'Romanian') ? 'selected' : ''; ?>>Romanian</option>
    <option value="Russian" <?php echo ($Nationality == 'Russian') ? 'selected' : ''; ?>>Russian</option>
    <option value="Rwandan" <?php echo ($Nationality == 'Rwandan') ? 'selected' : ''; ?>>Rwandan</option>
    <option value="Saint Lucian" <?php echo ($Nationality == 'Saint Lucian') ? 'selected' : ''; ?>>Saint Lucian</option>
    <option value="Salvadoran" <?php echo ($Nationality == 'Salvadoran') ? 'selected' : ''; ?>>Salvadoran</option>
    <option value="Samoan" <?php echo ($Nationality == 'Samoan') ? 'selected' : ''; ?>>Samoan</option>
    <option value="San Marinese" <?php echo ($Nationality == 'San Marinese') ? 'selected' : ''; ?>>San Marinese</option>
    <option value="Sao Tomean" <?php echo ($Nationality == 'Sao Tomean') ? 'selected' : ''; ?>>Sao Tomean</option>
    <option value="Saudi" <?php echo ($Nationality == 'Saudi') ? 'selected' : ''; ?>>Saudi</option>
    <option value="Scottish" <?php echo ($Nationality == 'Scottish') ? 'selected' : ''; ?>>Scottish</option>
    <option value="Senegalese" <?php echo ($Nationality == 'Senegalese') ? 'selected' : ''; ?>>Senegalese</option>
    <option value="Serbian" <?php echo ($Nationality == 'Serbian') ? 'selected' : ''; ?>>Serbian</option>
    <option value="Seychellois" <?php echo ($Nationality == 'Seychellois') ? 'selected' : ''; ?>>Seychellois</option>
    <option value="Sierra Leonean" <?php echo ($Nationality == 'Sierra Leonean') ? 'selected' : ''; ?>>Sierra Leonean</option>
    <option value="Singaporean" <?php echo ($Nationality == 'Singaporean') ? 'selected' : ''; ?>>Singaporean</option>
    <option value="Slovakian" <?php echo ($Nationality == 'Slovakian') ? 'selected' : ''; ?>>Slovakian</option>
    <option value="Slovenian" <?php echo ($Nationality == 'Slovenian') ? 'selected' : ''; ?>>Slovenian</option>
    <option value="Solomon Islander" <?php echo ($Nationality == 'Solomon Islander') ? 'selected' : ''; ?>>Solomon Islander</option>
    <option value="Somali" <?php echo ($Nationality == 'Somali') ? 'selected' : ''; ?>>Somali</option>
    <option value="South African" <?php echo ($Nationality == 'South African') ? 'selected' : ''; ?>>South African</option>
    <option value="South Korean" <?php echo ($Nationality == 'South Korean') ? 'selected' : ''; ?>>South Korean</option>
    <option value="Spanish" <?php echo ($Nationality == 'Spanish') ? 'selected' : ''; ?>>Spanish</option>
    <option value="Sri Lankan" <?php echo ($Nationality == 'Sri Lankan') ? 'selected' : ''; ?>>Sri Lankan</option>
    <option value="Sudanese" <?php echo ($Nationality == 'Sudanese') ? 'selected' : ''; ?>>Sudanese</option>
    <option value="Surinamer" <?php echo ($Nationality == 'Surinamer') ? 'selected' : ''; ?>>Surinamer</option>
    <option value="Swazi" <?php echo ($Nationality == 'Swazi') ? 'selected' : ''; ?>>Swazi</option>
    <option value="Swedish" <?php echo ($Nationality == 'Swedish') ? 'selected' : ''; ?>>Swedish</option>
    <option value="Swiss" <?php echo ($Nationality == 'Swiss') ? 'selected' : ''; ?>>Swiss</option>
    <option value="Syrian" <?php echo ($Nationality == 'Syrian') ? 'selected' : ''; ?>>Syrian</option>
    <option value="Taiwanese" <?php echo ($Nationality == 'Taiwanese') ? 'selected' : ''; ?>>Taiwanese</option>
    <option value="Tajik" <?php echo ($Nationality == 'Tajik') ? 'selected' : ''; ?>>Tajik</option>
    <option value="Tanzanian" <?php echo ($Nationality == 'Tanzanian') ? 'selected' : ''; ?>>Tanzanian</option>
    <option value="Thai" <?php echo ($Nationality == 'Thai') ? 'selected' : ''; ?>>Thai</option>
    <option value="Togolese" <?php echo ($Nationality == 'Togolese') ? 'selected' : ''; ?>>Togolese</option>
    <option value="Tongan" <?php echo ($Nationality == 'Tongan') ? 'selected' : ''; ?>>Tongan</option>
    <option value="Trinidadian or Tobagonian" <?php echo ($Nationality == 'Trinidadian or Tobagonian') ? 'selected' : ''; ?>>Trinidadian or Tobagonian</option>
    <option value="Tunisian" <?php echo ($Nationality == 'Tunisian') ? 'selected' : ''; ?>>Tunisian</option>
    <option value="Turkish" <?php echo ($Nationality == 'Turkish') ? 'selected' : ''; ?>>Turkish</option>
    <option value="Tuvaluan" <?php echo ($Nationality == 'Tuvaluan') ? 'selected' : ''; ?>>Tuvaluan</option>
    <option value="Ugandan" <?php echo ($Nationality == 'Ugandan') ? 'selected' : ''; ?>>Ugandan</option>
    <option value="Ukrainian" <?php echo ($Nationality == 'Ukrainian') ? 'selected' : ''; ?>>Ukrainian</option>
    <option value="Uruguayan" <?php echo ($Nationality == 'Uruguayan') ? 'selected' : ''; ?>>Uruguayan</option>
    <option value="Uzbekistani" <?php echo ($Nationality == 'Uzbekistani') ? 'selected' : ''; ?>>Uzbekistani</option>
    <option value="Venezuelan" <?php echo ($Nationality == 'Venezuelan') ? 'selected' : ''; ?>>Venezuelan</option>
    <option value="Vietnamese" <?php echo ($Nationality == 'Vietnamese') ? 'selected' : ''; ?>>Vietnamese</option>
    <option value="Welsh" <?php echo ($Nationality == 'Welsh') ? 'selected' : ''; ?>>Welsh</option>
    <option value="Yemenite" <?php echo ($Nationality == 'Yemenite') ? 'selected' : ''; ?>>Yemenite</option>
    <option value="Zambian" <?php echo ($Nationality == 'Zambian') ? 'selected' : ''; ?>>Zambian</option>
    <option value="Zimbabwean" <?php echo ($Nationality == 'Zimbabwean') ? 'selected' : ''; ?>>Zimbabwean</option>

            </select>
        </div>
        
        <div>
            <label for="CurrentLevel">Current Level</label>
            <select id="CurrentLevel" name="CurrentLevel" required>
                <option value="">Select Level</option>
                <option value="Graduated" <?php echo ($CurrentLevel == 'Graduated') ? 'selected' : ''; ?>>Graduated</option>
                <option value="Non Graduated" <?php echo ($CurrentLevel == 'Non Graduated') ? 'selected' : ''; ?>>Non Graduated</option>
            </select>
        </div>
        
        <div>
            <label for="Major">Major</label>
            <input type="text" id="Major" name="Major" value="<?php echo htmlspecialchars($Major); ?>" required>
        </div>
        
        <div>
            <label for="Gender">Gender</label>
            <select id="Gender" name="Gender" required>
                <option value="">Select Gender</option>
                <option value="Male" <?php echo ($Gender == 'Male') ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?php echo ($Gender == 'Female') ? 'selected' : ''; ?>>Female</option>
            </select>
        </div>
        
        <div>
            <label for="GPA">GPA</label>
            <input type="text" id="GPA" name="GPA" value="<?php echo htmlspecialchars($GPA); ?>" required>
        </div>
        
        <div>
            <label for="Country">Country</label>
            <select id="Country" name="Country" required>
    <option value="">Select Country</option>
    <option value="Afghanistan" <?php echo ($Country == 'Afghanistan') ? 'selected' : ''; ?>>Afghanistan</option>
    <option value="Albania" <?php echo ($Country == 'Albania') ? 'selected' : ''; ?>>Albania</option>
    <option value="Algeria" <?php echo ($Country == 'Algeria') ? 'selected' : ''; ?>>Algeria</option>
    <option value="Andorra" <?php echo ($Country == 'Andorra') ? 'selected' : ''; ?>>Andorra</option>
    <option value="Angola" <?php echo ($Country == 'Angola') ? 'selected' : ''; ?>>Angola</option>
    <option value="Antigua and Barbuda" <?php echo ($Country == 'Antigua and Barbuda') ? 'selected' : ''; ?>>Antigua and Barbuda</option>
    <option value="Argentina" <?php echo ($Country == 'Argentina') ? 'selected' : ''; ?>>Argentina</option>
    <option value="Armenia" <?php echo ($Country == 'Armenia') ? 'selected' : ''; ?>>Armenia</option>
    <option value="Australia" <?php echo ($Country == 'Australia') ? 'selected' : ''; ?>>Australia</option>
    <option value="Austria" <?php echo ($Country == 'Austria') ? 'selected' : ''; ?>>Austria</option>
    <option value="Azerbaijan" <?php echo ($Country == 'Azerbaijan') ? 'selected' : ''; ?>>Azerbaijan</option>
    <option value="Bahamas" <?php echo ($Country == 'Bahamas') ? 'selected' : ''; ?>>Bahamas</option>
    <option value="Bahrain" <?php echo ($Country == 'Bahrain') ? 'selected' : ''; ?>>Bahrain</option>
    <option value="Bangladesh" <?php echo ($Country == 'Bangladesh') ? 'selected' : ''; ?>>Bangladesh</option>
    <option value="Barbados" <?php echo ($Country == 'Barbados') ? 'selected' : ''; ?>>Barbados</option>
    <option value="Belarus" <?php echo ($Country == 'Belarus') ? 'selected' : ''; ?>>Belarus</option>
    <option value="Belgium" <?php echo ($Country == 'Belgium') ? 'selected' : ''; ?>>Belgium</option>
    <option value="Belize" <?php echo ($Country == 'Belize') ? 'selected' : ''; ?>>Belize</option>
    <option value="Benin" <?php echo ($Country == 'Benin') ? 'selected' : ''; ?>>Benin</option>
    <option value="Bhutan" <?php echo ($Country == 'Bhutan') ? 'selected' : ''; ?>>Bhutan</option>
    <option value="Bolivia" <?php echo ($Country == 'Bolivia') ? 'selected' : ''; ?>>Bolivia</option>
    <option value="Bosnia and Herzegovina" <?php echo ($Country == 'Bosnia and Herzegovina') ? 'selected' : ''; ?>>Bosnia and Herzegovina</option>
    <option value="Botswana" <?php echo ($Country == 'Botswana') ? 'selected' : ''; ?>>Botswana</option>
    <option value="Brazil" <?php echo ($Country == 'Brazil') ? 'selected' : ''; ?>>Brazil</option>
    <option value="Brunei" <?php echo ($Country == 'Brunei') ? 'selected' : ''; ?>>Brunei</option>
    <option value="Bulgaria" <?php echo ($Country == 'Bulgaria') ? 'selected' : ''; ?>>Bulgaria</option>
    <option value="Burkina Faso" <?php echo ($Country == 'Burkina Faso') ? 'selected' : ''; ?>>Burkina Faso</option>
    <option value="Burundi" <?php echo ($Country == 'Burundi') ? 'selected' : ''; ?>>Burundi</option>
    <option value="Cambodia" <?php echo ($Country == 'Cambodia') ? 'selected' : ''; ?>>Cambodia</option>
    <option value="Cameroon" <?php echo ($Country == 'Cameroon') ? 'selected' : ''; ?>>Cameroon</option>
    <option value="Canada" <?php echo ($Country == 'Canada') ? 'selected' : ''; ?>>Canada</option>
    <option value="Cape Verde" <?php echo ($Country == 'Cape Verde') ? 'selected' : ''; ?>>Cape Verde</option>
    <option value="Central African Republic" <?php echo ($Country == 'Central African Republic') ? 'selected' : ''; ?>>Central African Republic</option>
    <option value="Chad" <?php echo ($Country == 'Chad') ? 'selected' : ''; ?>>Chad</option>
    <option value="Chile" <?php echo ($Country == 'Chile') ? 'selected' : ''; ?>>Chile</option>
    <option value="China" <?php echo ($Country == 'China') ? 'selected' : ''; ?>>China</option>
    <option value="Colombia" <?php echo ($Country == 'Colombia') ? 'selected' : ''; ?>>Colombia</option>
    <option value="Comoros" <?php echo ($Country == 'Comoros') ? 'selected' : ''; ?>>Comoros</option>
    <option value="Congo (Brazzaville)" <?php echo ($Country == 'Congo (Brazzaville)') ? 'selected' : ''; ?>>Congo (Brazzaville)</option>
    <option value="Congo (Kinshasa)" <?php echo ($Country == 'Congo (Kinshasa)') ? 'selected' : ''; ?>>Congo (Kinshasa)</option>
    <option value="Costa Rica" <?php echo ($Country == 'Costa Rica') ? 'selected' : ''; ?>>Costa Rica</option>
    <option value="Croatia" <?php echo ($Country == 'Croatia') ? 'selected' : ''; ?>>Croatia</option>
    <option value="Cuba" <?php echo ($Country == 'Cuba') ? 'selected' : ''; ?>>Cuba</option>
    <option value="Cyprus" <?php echo ($Country == 'Cyprus') ? 'selected' : ''; ?>>Cyprus</option>
    <option value="Czech Republic" <?php echo ($Country == 'Czech Republic') ? 'selected' : ''; ?>>Czech Republic</option>
    <option value="Denmark" <?php echo ($Country == 'Denmark') ? 'selected' : ''; ?>>Denmark</option>
    <option value="Djibouti" <?php echo ($Country == 'Djibouti') ? 'selected' : ''; ?>>Djibouti</option>
    <option value="Dominica" <?php echo ($Country == 'Dominica') ? 'selected' : ''; ?>>Dominica</option>
    <option value="Dominican Republic" <?php echo ($Country == 'Dominican Republic') ? 'selected' : ''; ?>>Dominican Republic</option>
    <option value="Ecuador" <?php echo ($Country == 'Ecuador') ? 'selected' : ''; ?>>Ecuador</option>
    <option value="Egypt" <?php echo ($Country == 'Egypt') ? 'selected' : ''; ?>>Egypt</option>
    <option value="El Salvador" <?php echo ($Country == 'El Salvador') ? 'selected' : ''; ?>>El Salvador</option>
    <option value="Estonia" <?php echo ($Country == 'Estonia') ? 'selected' : ''; ?>>Estonia</option>
    <option value="Ethiopia" <?php echo ($Country == 'Ethiopia') ? 'selected' : ''; ?>>Ethiopia</option>
    <option value="Fiji" <?php echo ($Country == 'Fiji') ? 'selected' : ''; ?>>Fiji</option>
    <option value="Finland" <?php echo ($Country == 'Finland') ? 'selected' : ''; ?>>Finland</option>
    <option value="France" <?php echo ($Country == 'France') ? 'selected' : ''; ?>>France</option>
    <option value="Gabon" <?php echo ($Country == 'Gabon') ? 'selected' : ''; ?>>Gabon</option>
    <option value="Gambia" <?php echo ($Country == 'Gambia') ? 'selected' : ''; ?>>Gambia</option>
    <option value="Georgia" <?php echo ($Country == 'Georgia') ? 'selected' : ''; ?>>Georgia</option>
    <option value="Germany" <?php echo ($Country == 'Germany') ? 'selected' : ''; ?>>Germany</option>
    <option value="Ghana" <?php echo ($Country == 'Ghana') ? 'selected' : ''; ?>>Ghana</option>
    <option value="Greece" <?php echo ($Country == 'Greece') ? 'selected' : ''; ?>>Greece</option>
    <option value="Greenland" <?php echo ($Country == 'Greenland') ? 'selected' : ''; ?>>Greenland</option>
    <option value="Grenada" <?php echo ($Country == 'Grenada') ? 'selected' : ''; ?>>Grenada</option>
    <option value="Guatemala" <?php echo ($Country == 'Guatemala') ? 'selected' : ''; ?>>Guatemala</option>
    <option value="Guinea" <?php echo ($Country == 'Guinea') ? 'selected' : ''; ?>>Guinea</option>
    <option value="Haiti" <?php echo ($Country == 'Haiti') ? 'selected' : ''; ?>>Haiti</option>
    <option value="Honduras" <?php echo ($Country == 'Honduras') ? 'selected' : ''; ?>>Honduras</option>
    <option value="Hungary" <?php echo ($Country == 'Hungary') ? 'selected' : ''; ?>>Hungary</option>
    <option value="Iceland" <?php echo ($Country == 'Iceland') ? 'selected' : ''; ?>>Iceland</option>
    <option value="India" <?php echo ($Country == 'India') ? 'selected' : ''; ?>>India</option>
    <option value="Indonesia" <?php echo ($Country == 'Indonesia') ? 'selected' : ''; ?>>Indonesia</option>
    <option value="Iran" <?php echo ($Country == 'Iran') ? 'selected' : ''; ?>>Iran</option>
    <option value="Iraq" <?php echo ($Country == 'Iraq') ? 'selected' : ''; ?>>Iraq</option>
    <option value="Ireland" <?php echo ($Country == 'Ireland') ? 'selected' : ''; ?>>Ireland</option>
    <option value="Israel" <?php echo ($Country == 'Israel') ? 'selected' : ''; ?>>Israel</option>
    <option value="Italy" <?php echo ($Country == 'Italy') ? 'selected' : ''; ?>>Italy</option>
    <option value="Jamaica" <?php echo ($Country == 'Jamaica') ? 'selected' : ''; ?>>Jamaica</option>
    <option value="Japan" <?php echo ($Country == 'Japan') ? 'selected' : ''; ?>>Japan</option>
    <option value="Jordan" <?php echo ($Country == 'Jordan') ? 'selected' : ''; ?>>Jordan</option>
    <option value="Kazakhstan" <?php echo ($Country == 'Kazakhstan') ? 'selected' : ''; ?>>Kazakhstan</option>
    <option value="Kenya" <?php echo ($Country == 'Kenya') ? 'selected' : ''; ?>>Kenya</option>
    <option value="Kuwait" <?php echo ($Country == 'Kuwait') ? 'selected' : ''; ?>>Kuwait</option>
    <option value="Lebanon" <?php echo ($Country == 'Lebanon') ? 'selected' : ''; ?>>Lebanon</option>
    <option value="Libya" <?php echo ($Country == 'Libya') ? 'selected' : ''; ?>>Libya</option>
    <option value="Morocco" <?php echo ($Country == 'Morocco') ? 'selected' : ''; ?>>Morocco</option>
    <option value="Oman" <?php echo ($Country == 'Oman') ? 'selected' : ''; ?>>Oman</option>
    <option value="Palestine" <?php echo ($Country == 'Palestine') ? 'selected' : ''; ?>>Palestine</option>
    <option value="Qatar" <?php echo ($Country == 'Qatar') ? 'selected' : ''; ?>>Qatar</option>
    <option value="Saudi Arabia" <?php echo ($Country == 'Saudi Arabia') ? 'selected' : ''; ?>>Saudi Arabia</option>
    <option value="Sudan" <?php echo ($Country == 'Sudan') ? 'selected' : ''; ?>>Sudan</option>
    <option value="Syria" <?php echo ($Country == 'Syria') ? 'selected' : ''; ?>>Syria</option>
    <option value="Tunisia" <?php echo ($Country == 'Tunisia') ? 'selected' : ''; ?>>Tunisia</option>
    <option value="Turkey" <?php echo ($Country == 'Turkey') ? 'selected' : ''; ?>>Turkey</option>
    <option value="United Arab Emirates" <?php echo ($Country == 'United Arab Emirates') ? 'selected' : ''; ?>>United Arab Emirates</option>
    <option value="United Kingdom" <?php echo ($Country == 'United Kingdom') ? 'selected' : ''; ?>>United Kingdom</option>
    <option value="United States" <?php echo ($Country == 'United States') ? 'selected' : ''; ?>>United States</option>
    <option value="Yemen" <?php echo ($Country == 'Yemen') ? 'selected' : ''; ?>>Yemen</option>
    <option value="Other" <?php echo ($Country == 'Other') ? 'selected' : ''; ?>>Other</option>

            </select>
        </div>
        
        <div>
            <label for="City">City</label>
            <input type="text" id="City" name="City" value="<?php echo htmlspecialchars($City); ?>" required>
        </div>
        
        <button type="submit" name="submit">Sign up</button>
        <a href="login.php" class="button">Log in</a>
    </form>
</body>
</html>