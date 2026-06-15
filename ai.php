<?php
session_start();
require 'required files/tailwind-cdn.php';

require 'required files/db.php';

if (isset($_POST['back'])) {
    if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
        header("Location: manage-players.php");
    } else {
        header("Location: index.php");
    }
    exit();
}

// Registration
if (isset($_POST['submit'])) {

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];

// Check empty fields
    if (
            empty($username) ||
            empty($email) ||
            empty($password) ||
            empty($confirm_password) ||
            empty($role)
    ) {

        echo "<script>alert('All fields are required');</script>";

    }

// Check password confirmation
    else if ($password != $confirm_password) {

        echo "<script>alert('Passwords do not match');</script>";

    }

    else {

        // Check if username or email already exists
        $stmt = $db->prepare("
            SELECT *
            FROM users
            WHERE username = ? OR email = ?
        ");

        $stmt->execute([$username, $email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {

            if ($user['username'] == $username) {

                echo "<script>alert('Username is already taken');</script>";

            }
            else if ($user['email'] == $email) {

                echo "<script>alert('Email is already taken');</script>";

            }

        }
        else {

            // Hash password
            $hashedPassword = password_hash(
                    $password,
                    PASSWORD_ARGON2ID
            );

            // Insert user
            $stmt = $db->prepare("
                INSERT INTO users
                (username, email, password, role)
                VALUES
                (?, ?, ?, ?)
            ");

            $success = $stmt->execute([
                    $username,
                    $email,
                    $hashedPassword,
                    $role
            ]);

            if($success){
                if($_SESSION['role'] == 'admin'){
                    header("Location:manage-players.php");
                    exit();
                }else{
                    header("Location:login.php " );
                    exit();
                }}}}}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible"
          content="ie=edge">
    <title>Danganronpa // ENROLLMENT</title>
    <!-- Google Fonts for Tactical UI & Gaming HUD -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Space+Grotesk:wght@400;700;900&family=Syncopate:wght@700;900&display=swap" rel="stylesheet">

    <!-- Minimal Custom CSS -->
    <style>
        body {
            font-family: 'Space Grotesk', sans-serif;
        }
        .dangan-bg-grid {
            background-color: #0e0e11;
            background-image:
                    linear-gradient(45deg, #000000 25%, transparent 25%, transparent 75%, #000000 75%, #000000),
                    linear-gradient(45deg, #000000 25%, transparent 25%, transparent 75%, #000000 75%, #000000);
            background-size: 60px 60px;
            background-position: 0 0, 30px 30px;
        }
    </style>
</head>
<body class="dangan-bg-grid min-h-screen flex items-center justify-center py-12 px-4 relative overflow-x-hidden">

<!-- Screen Scanline Overlay Layer -->
<div class="pointer-events-none fixed inset-0 z-50 bg-[linear-gradient(rgba(18,16,16,0)_50%,rgba(0,0,0,0.25)_50%),linear-gradient(90deg,rgba(255,0,107,0.02),rgba(0,240,255,0.02))] bg-[size:100%_4px,6px_100%]"></div>

<!-- Background Decorative Caution Tape -->
<div class="absolute w-[150%] h-[120px] rotate-[-12deg] opacity-15 pointer-events-none z-0 bg-repeat-x bg-[size:40px_40px]" style="background-image: linear-gradient(45deg, #ff007f 25%, transparent 25%, transparent 50%, #ff007f 50%, #ff007f 75%, transparent 75%, transparent);"></div>

<div class="relative z-10 w-full max-w-xl bg-black border-4 border-[#ff007f] p-8 md:p-12 shadow-[0_0_30px_rgba(255,0,127,0.35)] [clip-path:polygon(0_0,100%_0,calc(100%-25px)_100%,0_100%)] mx-4">
    <!-- Floating Top Badge -->
    <div class="absolute top-[-14px] left-8 bg-[#ff007f] text-black font-['Syncopate'] text-[9px] font-black py-1 px-3.5 tracking-[0.25em] z-20">SUSPECT REGISTER</div>

    <div class="mx-auto max-w-md text-center mb-10">
        <h2 class="font-['Syncopate'] font-black text-3xl md:text-4xl uppercase tracking-tighter text-white leading-none">SUSPECT <span class="text-[#ff007f] italic">ENROLLMENT</span></h2>
        <p class="font-['Share_Tech_Mono'] text-[#a1a1aa] tracking-widest text-[11px] uppercase mt-2">Initialize new credentials in the Hope's Peak database.</p>
    </div>

    <form action="" method="POST" class="mx-auto max-w-md space-y-6">
        <div class="space-y-4">
            <div>
                <label for="company" class="block text-xs font-['Share_Tech_Mono'] font-bold tracking-widest text-[#00f0ff] uppercase mb-1.5">Username</label>
                <input id="username" type="text" name="username" autocomplete="organization" placeholder="ENTER SUSPECT USERNAME..." class="block w-full rounded-none bg-[#0e0e11] border border-[#ff007f]/40 px-4 py-3 text-sm text-white font-mono uppercase tracking-wider focus:border-[#00f0ff] focus:ring-1 focus:ring-[#00f0ff] focus:outline-none transition-all duration-150" />
            </div>

            <div>
                <label for="email" class="block text-xs font-['Share_Tech_Mono'] font-bold tracking-widest text-[#00f0ff] uppercase mb-1.5">Email</label>
                <input id="email" type="email" name="email" autocomplete="email" placeholder="ENTER SUSPECT EMAIL..." class="block w-full rounded-none bg-[#0e0e11] border border-[#ff007f]/40 px-4 py-3 text-sm text-white font-mono uppercase tracking-wider focus:border-[#00f0ff] focus:ring-1 focus:ring-[#00f0ff] focus:outline-none transition-all duration-150" />
            </div>

            <div>
                <label for="company" class="block text-xs font-['Share_Tech_Mono'] font-bold tracking-widest text-[#00f0ff] uppercase mb-1.5">Password</label>
                <input id="password" type="password" name="password" autocomplete="organization" placeholder="ENTER ENCRYPTED PASSWORD..." class="block w-full rounded-none bg-[#0e0e11] border border-[#ff007f]/40 px-4 py-3 text-sm text-white font-mono tracking-wider focus:border-[#00f0ff] focus:ring-1 focus:ring-[#00f0ff] focus:outline-none transition-all duration-150" />
            </div>

            <div>
                <label for="company" class="block text-xs font-['Share_Tech_Mono'] font-bold tracking-widest text-[#00f0ff] uppercase mb-1.5">Confirm Password</label>
                <input id="confirm_password" type="password" name="confirm_password" autocomplete="organization" placeholder="CONFIRM PASSWORD..." class="block w-full rounded-none bg-[#0e0e11] border border-[#ff007f]/40 px-4 py-3 text-sm text-white font-mono tracking-wider focus:border-[#00f0ff] focus:ring-1 focus:ring-[#00f0ff] focus:outline-none transition-all duration-150" />
            </div>
        </div>

        <div class="mt-8 space-y-4">
            <button type="submit" class="block w-full bg-[#ff007f] text-black font-['Syncopate'] font-black text-xs tracking-[0.2em] uppercase py-4 transition-all duration-150 [clip-path:polygon(0_0,100%_0,90%_100%,10%_100%)] hover:bg-[#00f0ff] hover:shadow-[0_0_15px_rgba(0,240,255,0.6)] hover:scale-105 hover:-skew-x-3 active:scale-95 cursor-pointer text-center" name="submit">REGISTER SUSPECT</button>

            <button type="submit" class="block w-full bg-transparent border border-[#00f0ff] text-[#00f0ff] font-['Syncopate'] font-black text-xs tracking-[0.2em] uppercase py-4 transition-all duration-150 [clip-path:polygon(0_0,100%_0,90%_100%,10%_100%)] hover:bg-[#00f0ff] hover:text-black hover:shadow-[0_0_15px_rgba(0,240,255,0.4)] hover:scale-105 hover:-skew-x-3 active:scale-95 cursor-pointer text-center" name="back">Go back</button>
        </div>

        <div> <input type="hidden" name="role" value="player"></div>
    </form>
</div>
</body>
</html>