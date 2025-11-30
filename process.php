<?php
// process.php
// This page receives POST data, validates, sanitizes and displays a nice formatted output.
// IMPORTANT: keep this file in the same folder as index.html, style.css and script.js.

// helper: sanitize text for HTML output
function h($s){
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // If user opens process.php directly, redirect to form
    header('Location: index.html');
    exit;
}

// Collect and sanitize inputs
$firstname = isset($_POST['firstname']) ? trim($_POST['firstname']) : '';
$lastname  = isset($_POST['lastname']) ? trim($_POST['lastname']) : '';
$email     = isset($_POST['email']) ? trim($_POST['email']) : '';
$password  = isset($_POST['password']) ? $_POST['password'] : ''; // do not print raw password
$gender    = isset($_POST['gender']) ? trim($_POST['gender']) : '';
$dob       = isset($_POST['dob']) ? trim($_POST['dob']) : '';
$education = isset($_POST['education']) ? trim($_POST['education']) : '';
$skills    = isset($_POST['skills']) ? trim($_POST['skills']) : '';
$message   = isset($_POST['message']) ? trim($_POST['message']) : '';
$hobbies   = isset($_POST['hobbies']) ? $_POST['hobbies'] : [];

// server-side validation (basic)
$errors = [];
if ($firstname === '') $errors[] = 'First name is required.';
if ($lastname === '') $errors[] = 'Last name is required.';
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'A valid email is required.';

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Application Submitted</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
<?php if (!empty($errors)): ?>
    <div id="formMessage" class="error">
      <strong>There were errors with your submission:</strong>
      <ul>
        <?php foreach ($errors as $err): ?>
          <li><?php echo h($err); ?></li>
        <?php endforeach; ?>
      </ul>
      <p><a href="index.html">Go back to the form</a> and fix the errors.</p>
    </div>
<?php else: ?>
    <div class="result-card">
      <h2>Application Received</h2>
      <p class="small">Thank you — the details you submitted are shown below in a readable format.</p>

      <div class="result-row">
        <div class="label">Full Name</div>
        <div class="value"><?php echo h($firstname . ' ' . $lastname); ?></div>
      </div>

      <div class="result-row">
        <div class="label">Email</div>
        <div class="value"><?php echo h($email); ?></div>
      </div>

      <div class="result-row">
        <div class="label">Gender</div>
        <div class="value"><?php echo h($gender ?: 'Not specified'); ?></div>
      </div>

      <div class="result-row">
        <div class="label">Date of Birth</div>
        <div class="value"><?php echo h($dob ?: 'Not specified'); ?></div>
      </div>

      <div class="result-row">
        <div class="label">Education</div>
        <div class="value"><?php echo h($education ?: 'Not specified'); ?></div>
      </div>

      <div class="result-row">
        <div class="label">Hobbies</div>
        <div class="value">
          <?php
            if (empty($hobbies)) {
              echo '<span class="small">None selected</span>';
            } else {
              foreach ($hobbies as $hb) {
                echo '<span class="badge">' . h($hb) . '</span>';
              }
            }
          ?>
        </div>
      </div>

      <div class="result-row">
        <div class="label">Technical Skills</div>
        <div class="value">
          <?php
            $skillsArr = array_filter(array_map('trim', explode(',', $skills)));
            if (count($skillsArr) === 0) {
              echo '<span class="small">No technical skills provided</span>';
            } else {
              foreach ($skillsArr as $sk) {
                echo '<span class="badge">' . h($sk) . '</span>';
              }
            }
          ?>
        </div>
      </div>

      <div class="result-row">
        <div class="label">Additional Info</div>
        <div class="value"><?php echo nl2br(h($message ?: '—')); ?></div>
      </div>

      <footer class="note">
        <p>Return to <a href="index.html">application form</a></p>
      </footer>
    </div>
<?php endif; ?>
  </div>
</body>
</html>
