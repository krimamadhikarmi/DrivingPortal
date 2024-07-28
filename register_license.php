<?php

$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "driving_license";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$name = $_POST['name'];
$dob = $_POST['dob'];
$address = $_POST['address'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$gender = isset($_POST['gender']) ? $_POST['gender'] : "";
$citizen = $_POST['citizen'];
$license_type = $_POST['license'];
$trial_date = $_POST['trial'];

function generateRegistrationNumber() {
    $prefix = "D-";
    $length=3;
    $characters = '0123456789';
    $registrationNumber = '';
    
    for ($i = 0; $i < $length; $i++) {
        $registrationNumber .= $characters[rand(0, strlen($characters) - 1)];
    }
    
    return $prefix.$registrationNumber;
}
$registration_number = generateRegistrationNumber();


$checkCitizenStmt = $conn->prepare("SELECT COUNT(*) FROM registrations WHERE citizenship_no = ?");
$checkCitizenStmt->bind_param("s", $citizen);
$checkCitizenStmt->execute();
$checkCitizenStmt->bind_result($count);
$checkCitizenStmt->fetch();
$checkCitizenStmt->close();

if ($count > 0) {
    $message = "<div class='error-message'>You cannot register. Your Citizenship number already exists.</div>";
} else {
    $stmt = $conn->prepare("INSERT INTO registrations (name, dob, address, email, phone, gender, citizenship_no, license_type, trial_date, registration_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $name, $dob, $address, $email, $phone, $gender, $citizen, $license_type, $trial_date, $registration_number);

    if ($stmt->execute()) {
        $message = "
        <div class='success-message'>
            <h2>Driving Licensce Registration</h2>
            <p><strong>Registration Number:</strong> {$registration_number}</p>
            <p><strong>Full Name:</strong> {$name}</p>
            <p><strong>Date of Birth:</strong> {$dob}</p>
            <p><strong>Address:</strong> {$address}</p>
            <p><strong>Email:</strong> {$email}</p>
            <p><strong>Phone Number:</strong> {$phone}</p>
            <p><strong>Gender:</strong> {$gender}</p>
            <p><strong>Citizenship No:</strong> {$citizen}</p>
            <p><strong>License Type:</strong> {$license_type}</p>
            <p><strong>Date for Trial:</strong> {$trial_date}</p>
             <div class='notice'>
                <h3>Important Notice for Applicants:</h3>
                <ul>
                    <li>Please bring a printed copy of your registration confirmation when you come for the trial.</li>
                    <li>Ensure that all the documents are original and valid.</li>
                    <li>Arrive at the trial location at least 30 minutes before your scheduled time.</li>
                    <li>If you need to reschedule your trial, contact our office at least 48 hours in advance.</li>
                    <li>For any further assistance, reach out to our support team at support@drivinglicense.com or call us at (123) 456-7890.</li>
                </ul>
            </div>
        </div>";
    } else {
        $message = "<div class='error-message'>Error: {$stmt->error}</div>";
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            /* padding: 20px; */
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 80px;
        }
        .success-message {
            color: black;
        }
        .error-message {
            color: red;
            text-align: center;
            font-size: 20px;
        }
        h2 {
            color: green;
            text-align:center;
        }
        p {
            line-height: 1.6;
        }
        .notice {
            margin-top: 20px;
            padding: 20px;
            background-color: #e9f5e9;
            /* border-left: 6px solid green; */
        }
        .notice h3 {
            margin-top: 0;
            color: black;
        }
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            background-color: #333;
            padding: 10px 0;
            /* box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); */
            z-index: 1000;
            height: 40px;
        }

        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            background-color: #333;
            margin-top: 8px;
        }

        .nav-brand {
            font-size: 28px;
            color: white;
            text-decoration: none;
        }

        .nav-links {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .nav-links li {
             margin-left: 20px;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: #ffcc00;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: #5cb85c; 
            border: none;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #4cae4c; 
        }

        .option-back {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <?php include 'nav.html'; ?>
    <div class="container">
        <?php echo $message; ?>
        <div class="option-back" id="option-back">
          <a href="index.php" class="button">Back to Home</a>
        </div>
    </div>

</body>
</html>
