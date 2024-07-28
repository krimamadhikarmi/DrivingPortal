function validateForm() {
  var dob = document.getElementById("dob").value;
  var trial = document.getElementById("trial").value;
  var today = new Date();

  var trial_date = new Date(trial);
  var birthDate = new Date(dob);

  var age = today.getFullYear() - birthDate.getFullYear();
  var m = today.getMonth() - birthDate.getMonth();
  if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
    age--;
  }
  if (age < 18) {
    formAlert.innerHTML = "**You must be 18 years old to apply**";
    formAlert.style.display = "block";
    formAlert.style.color = "red";
    return false;
  }

  var timeDiff = trial_date.getTime() - today.getTime();
  var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

  if (trial_date <= today || diffDays <= 10) {
    formAlert.innerHTML =
      "**Select a future date at least 10 days from today to apply**";
    formAlert.style.display = "block";
    formAlert.style.color = "red";
    return false;
  }
  return true;
}
