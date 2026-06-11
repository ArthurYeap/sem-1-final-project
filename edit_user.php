<?php
session_start();
require 'required files/admin.php';
require 'required files/db.php';
require 'required files/tailwind-cdn.php';

$id = $_GET['id'];
if (empty($id)) {
    header("Location: manage-players.php");
    exit();
}


$stmt = $db->prepare("
    SELECT *
    FROM users
    WHERE id = ?
");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    header("Location: manage-players.php");
    exit();
}

if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $role = $_POST["role"];

    if (empty($username) || empty($email) || empty($role)) {
        echo "<script>alert('All fields are required');</script>";
    }
    else {
        // Check if username or email is already taken by ANOTHER user account (excluding this user's own ID)
        $stmt = $db->prepare("SELECT * FROM users WHERE (username = ? OR email = ?) AND id != ?");
        $stmt->execute([$username, $email, $id]);
        $duplicate = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($duplicate) {
            if ($duplicate['username'] == $username) {
                $_SESSION['error_message'] = "Username is already taken by another user";
            } else if ($duplicate['email'] == $email) {
                $_SESSION['error_message'] = "Email is already taken by another user";
            }

        }
        else {
            // No duplicates found! Safely update the database record
            $stmt = $db->prepare("
                UPDATE users
                SET username = ?, email = ?, role = ?
                WHERE id = ?
            ");

            $success = $stmt->execute([$username, $email, $role, $id]);

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
<body class="bg-green-900">
<form action="" method="POST" class="mx-auto mt-16 max-w-xl sm:mt-20">
    <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">


        <div class="sm:col-span-2">
            <label for="company" class="block text-sm/6 font-semibold text-white">Username</label>
            <div class="mt-2.5">
                <input id="username" type="text" name="username" value="<?=$user['username'] ?>" autocomplete="organization" class="block w-full rounded-md bg-white/5 px-3.5 py-2 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500" />
            </div>
        </div>

        <div class="sm:col-span-2">
            <label for="company" class="block text-sm/6 font-semibold text-white">Email</label>
            <div class="mt-2.5">
                <input id="email" type="email" name="email" value="<?=$user['email'] ?>" autocomplete="organization" class="block w-full rounded-md bg-white/5 px-3.5 py-2 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500" />
            </div>
            <div class="mb-3">
                <label for="role" class="form-label text-white">Role:</label>
                <select class="form-control text-white bg-black" id="role" name="role" >
                    <option value="player"  <?= $user['role'] == "player" ? "selected" : "" ?>>Player</option>
                    <option value="admin" <?= $user['role'] == "admin" ? "selected" : "" ?>>Admin</option>
                </select>
            </div>
        </div>



    </div>
    <div class="mt-10">
        <button type="submit" class="block w-full rounded-md bg-indigo-500 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500" name="submit">Save Changes</button>
    </div>
    <div class="mt-10">
        <a href="manage-players.php" class="block w-full rounded-md bg-indigo-500 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
            Go back
        </a>
    </div>
</form>
</body>
</html>
