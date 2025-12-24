  <?php
  include "db.php";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

      $name = mysqli_real_escape_string($conn, $_POST['name']);
      $email = mysqli_real_escape_string($conn, $_POST['email']);
      $raw_password = $_POST['password'];
      $role = mysqli_real_escape_string($conn, $_POST['role']);

      if (empty($name) || empty($email) || empty($raw_password) || empty($role)) {
          echo "<script>alert('Please fill in all fields');</script>";
      } else {
        $password = password_hash($raw_password, PASSWORD_DEFAULT);

        if ($role === 'admin') {
              $check_admin = "SELECT * FROM students WHERE role='admin'";
              $result = mysqli_query($conn, $check_admin);
              if (mysqli_num_rows($result) > 3) {
                  echo "<script>alert('Admin already exists');</script>";
                  exit;
              }
          }

          $insert = "INSERT INTO students(name, email, password, role) 
                    VALUES ('$name', '$email', '$password', '$role')";
          $exec = mysqli_query($conn, $insert);

          if ($exec) {
              header("Location: Login.php");
              exit;
          } else {
              echo "Error: " . mysqli_error($conn);
          }
      }
  }
  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Signup Page</title>
    <style>
      body {
        font-family: Arial;
        background-color:rgb(9, 6, 6);
        color: #222;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
      }
      form {
        background: #e9f1f8;
        padding: 20px 30px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.2);
        width: 450px;
      }
      h1 {
        text-align: center;
        color: #0066cc;
      }
      input, select {
        width: 100%;
        padding: 10px;
        margin-top: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
      }
      input[type="submit"] {
        background-color: #0066cc;
        color: white;
        border: none;
        cursor: pointer;
        transition: 0.3s;
      }
      input[type="submit"]:hover {
        background-color: #004d99;
      }
    </style>
  </head>
  <body>
    <form action="signup.php" method="POST">
      <h1>Create an Account</h1>
      <input type="text" name="name" placeholder="Enter Name" required />
      <input type="email" name="email" placeholder="Enter Email" required />
      <input type="password" name="password" placeholder="Enter Password" required />
      <select name="role" required>
        <option value="">-- Select Role --</option>
        <option value="admin">Admin</option>
        <option value="teacher">Teacher</option>
        <option value="student">Student</option>
      </select>
      <input type="submit" name="submit" value="Sign Up" />
      <p>No account? <a href="login.php">login here</a></p>
    </form>
  </body>
  </html>
  