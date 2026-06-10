<?php
session_start();
require 'tailwind-cdn.php';

require 'db.php';

if(isset($_POST['submit']) && $_POST['password'] == $_POST['confirm_password'] && isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['role'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $query = "INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)";
    $stmt = $db->prepare($query);
    $success=$stmt->execute(array(
        ':username'=>$username,
        ':email'=>$email,
        ':password'=>password_hash($password, PASSWORD_ARGON2ID),
        ':role'=>$role
    ));
    if($success){
        if($_SESSION['role'] == 'admin'){
            header("Location:manage-players.php");
        }else{
            header("Location:login.php");
        }
    }else{echo"error";}}

    if (isset($_POST['back'])){
        if($_SESSION['role'] == 'admin'){header("Location:manage-players.php");}else{header("Location:index.php");}
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
<body>
<div class="isolate bg-gray-900 px-6 py-24 sm:py-32 lg:px-8">
    <div aria-hidden="true" class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80">
        <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" class="relative left-1/2 -z-10 aspect-1155/678 w-144.5 max-w-none -translate-x-1/2 rotate-30 bg-linear-to-tr from-[#ff80b5] to-[#9089fc] opacity-20 sm:left-[calc(50%-40rem)] sm:w-288.75"></div>
    </div>
    <div class="mx-auto max-w-2xl text-center">
        <h2 class="text-4xl font-semibold tracking-tight text-balance text-white sm:text-5xl">Contact sales</h2>
        <p class="mt-2 text-lg/8 text-gray-400">Aute magna irure deserunt veniam aliqua magna enim voluptate.</p>
    </div>
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
                    <input id="password" type="text" name="password" autocomplete="organization" class="block w-full rounded-md bg-white/5 px-3.5 py-2 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500" />
                </div>
            </div>
            <div class="sm:col-span-2">
                <label for="company" class="block text-sm/6 font-semibold text-white">Confirm Password</label>
                <div class="mt-2.5">
                    <input id="confirm_password" type="text" name="confirm_password" autocomplete="organization" class="block w-full rounded-md bg-white/5 px-3.5 py-2 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500" />
                </div>
            </div>


        </div>
        <div class="mt-10">
            <button type="submit" class="block w-full rounded-md bg-indigo-500 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500" name="submit">Let's talk</button>
        </div>
        <div class="mt-10">
            <button type="submit" class="block w-full rounded-md bg-indigo-500 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500" name="back">Go back</button>
        </div>

        <div> <input type="hidden" name="role" value="player"></div>
    </form>
</div>
</body>
</html>
