<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Driving License Registration</title>
    <link rel="stylesheet" href="styles.css" />
    <script src="script.js"></script>
  </head>
  <body>
  <?php include 'nav.html'; ?>
    <div class="container">
      <h1>Driving License Registration</h1>
      <form
        action="register_license.php"
        method="post"
        onsubmit="return validateForm()"
      >
        <div id="formAlert" class="alert" style="display: none"></div>
        <label for="name"><strong>Full Name:</strong></label>
        <input type="text" id="name" name="name" required />

        <label for="dob"><strong>Date of Birth:</strong></label>
        <input type="date" id="dob" name="dob" required />

        <label for="address"><strong>Address:</strong></label>
        <textarea id="address" name="address" required></textarea>

        <label for="email"><strong>Email:</strong></label>
        <input type="email" id="email" name="email" required />

        <label for="phone"><strong>Phone Number:</strong></label>
        <input type="tel" id="phone" name="phone" maxlength="10" required />

        <div class="gender-container">
          <label for="gender"><strong>Gender:</strong></label>
          <div class="gender-options">
            <input type="radio" id="male" name="gender" value="male" />
            <label for="male">Male</label>
            <input type="radio" id="female" name="gender" value="female" />
            <label for="female">Female</label>
          </div>
        </div>

        <label for="citizen"><strong>CitizenShip No:</strong></label>
        <input
          type="text"
          id="citizen"
          name="citizen"
          pattern="\d{3}-\d{4}-\d{3}"
          required
        />

        <div class="license-type">
          <label for="license"><strong>License Type:</strong></label>
          <select name="license" id="license">
            <option value="Bike">Bike</option>
            <option value="Car">Car</option>
            <option value="Scooter">Scooter</option>
            <option value="Bus">Bus</option>
            <option value="Truck">Truck</option>
          </select>
        </div>

        <div class="file-photo">
          <label for="photo"><strong>Photo of Citizenship Card:</strong></label>
          <input type="file" id="photo" name="photo" required />
        </div>

        <label for="trial"><strong>Date for Trial:</strong></label>
        <input type="date" id="trial" name="trial" required />

        <button type="submit">Register</button>
      </form>
    </div>
  </body>
</html>
