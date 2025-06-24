<?php
<?php
// Database connection settings
$host = "localhost";
$dbname = "shindabet";
$user = "root"; // badilisha kama si root
$pass = "";     // weka password yako hapa kama ipo

// Connect to database
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Receive and sanitize form data
$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$countryCode = $_POST['countryCode'] ?? '';
$phone = trim($_POST['phone'] ?? '');
$password = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirmPassword'] ?? '';
$terms = isset($_POST['terms']);

// Basic validation
$errors = [];
if ($username == "") $errors[] = "Username is required.";
if ($email == "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
if ($phone == "" || !preg_match('/^\d{6,15}$/', $phone)) $errors[] = "Valid phone number is required.";
if (strlen($password) < 6) $errors[] = "Password must be at least 6 characters.";
if ($password !== $confirmPassword) $errors[] = "Passwords do not match.";
if (!$terms) $errors[] = "You must agree to the terms and conditions.";

if (empty($errors)) {
    // Hash password before saving
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO users (username, email, country_code, phone, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $username, $email, $countryCode, $phone, $hashedPassword);

    if ($stmt->execute()) {
        echo "<h2>Registration successful!</h2>";
        echo "<p>Welcome, " . htmlspecialchars($username) . ".</p>";
    } else {
        echo "<h3>Error: " . $stmt->error . "</h3>";
    }
    $stmt->close();
} else {
    echo "<h3>There were errors:</h3><ul>";
    foreach ($errors as $error) {
        echo "<li>" . htmlspecialchars($error) . "</li>";
    }
    echo "</ul>";
    echo '<a href="jisajili.html">Go back</a>';
}

$conn->close();
?>