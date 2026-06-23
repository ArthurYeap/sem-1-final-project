<?php
session_start();
require 'required files/admin.php';
require 'required files/db.php';
require 'required files/tailwind-cdn.php';
//!back button
if (isset($_POST['back'])){
    header('location: index.php');
    exit();
}


if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

//   !checking for empty field
    if (empty($username) || empty($email) ||  empty($password) || empty($confirm_password)) {
        echo "<script>alert('All fields are required');</script>";
    }
//    !checking if password match
    elseif ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match');</script>";
    }
    else {
//        !fetching data
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?  AND email = ?");
        $stmt->execute([$username, $email, ]);
        $duplicate = $stmt->fetch(PDO::FETCH_ASSOC);

//        !invalid user
        if (!$duplicate) {
            echo "<script>alert('User Not Found , Please try again');</script>";
        }

//        !no errors
        else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

//            !updating user password
            $stmt = $db->prepare("
                UPDATE users
                SET  password = ?
                WHERE username = ?
            ");
            $success = $stmt->execute([ $hashed_password, $username]);

//            !redirecting if successful
            if ($success) {
                header("Location: login.php");
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
    <title>Reset Password Page</title>
    <link rel="stylesheet" href="main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Black+Ops+One&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Orbitron:wght@400..900&family=Tektur:wght@400..900&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Black+Ops+One&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Orbitron:wght@400..900&family=Tektur:wght@400..900&display=swap');
    </style>
</head>
<body class="dangan-bg-grid min-h-screen flex items-center justify-center py-12 px-4 relative overflow-x-hidden">
<!--!Title-->
<div class="relative z-10 w-full max-w-xl bg-black border-4 border-[#FF7B00] p-8 md:p-12[clip-path:polygon(0_0,100%_0,calc(100%-25px)_100%,0_100%)] mx-4">
    <div class="mx-auto max-w-md text-center mb-10">
        <h2 class="font-['Syncopate'] font-black text-3xl md:text-4xl uppercase tracking-tighter text-white leading-none" style="font-family: Orbitron">RESET PASSWORD</h2>
    </div>

    <!--    !form input-->
    <form action="" method="POST" class="mx-auto max-w-md space-y-6">
        <div class="space-y-4">
            <!--            !username-->
            <div>
                <label  class="block text-xs font-['Share_Tech_Mono'] font-bold tracking-widest text-White uppercase mb-1.5" style="font-family: Tektur">Username</label>
                <input id="username" type="text" name="username" autocomplete="organization" placeholder="ENTER YOUR USERNAME" class="block w-full rounded-none bg-[#0e0e11] border border-[#ff007f]/40 px-4 py-3 text-sm text-white font-mono  tracking-wider focus:border-[#F74040] focus:ring-1 focus:ring-[#F74040] focus:outline-none transition-all duration-150" />
            </div>

            <!--            !email-->
            <div>
                <label for="email" class="block text-xs font-['Share_Tech_Mono'] font-bold tracking-widest text-White uppercase mb-1.5" style="font-family: Tektur">Email</label>
                <input id="email" type="email" name="email" autocomplete="email" placeholder="ENTER YOUR EMAIL" class="block w-full rounded-none bg-[#0e0e11] border border-[#ff007f]/40 px-4 py-3 text-sm text-white font-mono  tracking-wider focus:border-[#F74040] focus:ring-1 focus:ring-[#F74040] focus:outline-none transition-all duration-150" />
            </div>

            <!--            !password-->
            <div>
                <label for="company" class="block text-xs font-['Share_Tech_Mono'] font-bold tracking-widest text-White uppercase mb-1.5" style="font-family: Tektur">Password</label>
                <input id="password" type="password" name="password" autocomplete="organization" placeholder="ENTER ENCRYPTED PASSWORD" class="block w-full rounded-none bg-[#0e0e11] border border-[#ff007f]/40 px-4 py-3 text-sm text-white font-mono  tracking-wider focus:border-[#F74040] focus:ring-1 focus:ring-[#F74040] focus:outline-none transition-all duration-150" />
            </div>

            <!--          ! confirm password-->

            <div>
                <label for="company" class="block text-xs font-['Share_Tech_Mono'] font-bold tracking-widest text-White uppercase mb-1.5" style="font-family: Tektur">Confirm Password</label>
                <input id="confirm_password" type="password" name="confirm_password" autocomplete="organization" placeholder="CONFIRM PASSWORD" class="block w-full rounded-none bg-[#0e0e11] border border-[#ff007f]/40 px-4 py-3 text-sm text-white font-mono  tracking-wider focus:border-[#F74040] focus:ring-1 focus:ring-[#F74040] focus:outline-none transition-all duration-150" />
            </div>
        </div>

        <!--        !register button-->
        <div class="mt-8 space-y-4">
            <button type="submit" class="block w-full bg-[#3823CF] text-black font-['Syncopate'] font-black text-xs tracking-[0.2em] uppercase py-4 transition-all duration-150 hover:bg-[#7D14FF] hover:shadow-[0_0_15px_rgba(0,240,255,0.6)] hover:scale-105 hover:-skew-x-3 active:scale-95 cursor-pointer text-center" name="submit" style="font-family: Tektur">RESET </button>

            <!--            !go back button-->
            <button type="submit" class="block w-full bg-transparent border border-[#FFE414] text-[#FFE414] font-['Syncopate'] font-black text-xs tracking-[0.2em] uppercase py-4 transition-all duration-150  hover:bg-[#FFE414] hover:text-black hover:shadow-[0_0_15px_rgba(0,240,255,0.4)] hover:scale-105 hover:-skew-x-3 active:scale-95 cursor-pointer text-center" name="back" style="font-family: Tektur">Go back</button>
        </div>

        <div> <input type="hidden" name="role" value="player"></div>
    </form>
</div>
</body>
</html>