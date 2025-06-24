<?php
// 1. Set your database credentials
$servername = "localhost";
$username = "root"; // badilisha kama una username tofauti
$password = "";     // badilisha kama una password
$database = "shindabet"; // jina la database yako

// 2. Connect to database
$conn = mysqli_connect($servername, $username, $password, $database);

// 3. Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// 4. Get form data (sanitize for security)
$username = mysqli_real_escape_string($conn, $_POST['username']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$countryCode = mysqli_real_escape_string($conn, $_POST['countryCode']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// 5. Hash password before saving
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// 6. Combine country code and phone
$fullPhone = $countryCode . $phone;

// 7. Insert data into users table
$sql = "INSERT INTO users (username, email, phone, password) VALUES ('$username', '$email', '$fullPhone', '$hashedPassword')";

if (mysqli_query($conn, $sql)) {
    echo "Umesajiliwa vizuri! <a href='home .html'>Rudi Nyumbani</a>";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>