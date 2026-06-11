<?php
session_start();
require 'required files/admin.php';
require 'required files/db.php';
require 'required files/tailwind-cdn.php';


if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Check that all required inputs are populated
    if (empty($username) || empty($email) ||  empty($password) || empty($confirm_password)) {
        echo "<script>alert('All fields are required');</script>";
    }
    // Verify both entered passwords match perfectly
    elseif ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match');</script>";
    }
    else {
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?  AND email = ?");
        $stmt->execute([$username, $email, ]);
        $duplicate = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$duplicate) {
            echo "<script>alert('User Not Found , Please try again');</script>";

        }
        else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Safely update the database record including the newly encrypted password
            $stmt = $db->prepare("
                UPDATE users
                SET  password = ?
                WHERE username = ?
            ");

            $success = $stmt->execute([ $hashed_password, $username]);

            if ($success) {


                header("Location: manage-players.php");
                exit();
            } else {
                echo "error";
            }
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible"
          content="ie=edge">
    <title>Document</title>
</head>
<body class="bg-purple-900">
<form action="" method="POST" class="mx-auto mt-16 max-w-xl sm:mt-20">
    <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">


        <div class="sm:col-span-2">
            <label for="company" class="block text-sm/6 font-semibold text-white">Username</label>
            <div class="mt-2.5">
                <input id="username" type="text" name="username" autocomplete="organization" class="block w-full rounded-md bg-white/5 px-3.5 py-2 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500" />
            </div>
        </div>
        <div class="sm:col-span-2">
            <label for="email" class="block text-sm/6 font-semibold text-white">Email</label>
            <div class="mt-2.5">
                <input id="email" type="email" name="email" autocomplete="email" class="block w-full rounded-md bg-white/5 px-3.5 py-2 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500" />
            </div>
        </div>
        <div class="sm:col-span-2">
            <label for="company" class="block text-sm/6 font-semibold text-white">Password</label>
            <div class="mt-2.5">
                <input id="password" type="password" name="password" autocomplete="organization" class="block w-full rounded-md bg-white/5 px-3.5 py-2 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500" />
            </div>
        </div>
        <div class="sm:col-span-2">
            <label for="company" class="block text-sm/6 font-semibold text-white">Confirm Password</label>
            <div class="mt-2.5">
                <input id="confirm_password" type="password" name="confirm_password" autocomplete="organization" class="block w-full rounded-md bg-white/5 px-3.5 py-2 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500" />
            </div>
        </div>


    </div>
    <div class="mt-10">
        <button type="submit" class="block w-full rounded-md bg-indigo-500 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500" name="submit">Let's talk</button>
    </div>
    <div class="mt-10">
        <a href="login.php" class="block w-full rounded-md bg-indigo-500 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
            Go back
        </a>
    </div>

    <div> <input type="hidden" name="role" value="player"></div>
</form>
</body>
</html>