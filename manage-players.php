<?php
require 'tailwind-cdn.php';
require 'db.php';


session_start();
if(isset($_SESSION['role'])){
    if($_SESSION['role'] !== "admin"){
        header("Location:main.php"); exit();
    }}

$stmt = $db->query("SELECT id, username, email, role FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
<div class="mt-10">
    <a href="regristration.php" class="block w-full rounded-md bg-yellow-500 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
Add New Player    </a>
</div>
<table class="table-auto">
    <thead>
    <tr class=>
        <th  class=" px-6">ID</th>
        <th>Username</th>
        <th>Gmail</th>
        <th>Role</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($users as $user): ?>
        <tr>
            <td><?= htmlspecialchars($user['id']) ?></td>
            <td><?= htmlspecialchars($user['username']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td class=" px-6"><?= htmlspecialchars($user['role']) ?></td>
            <td class=" px-6">     <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                    Edit
                </button></td>
            <td class=" px-6">     <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                    Change Password
                </button></td>
            <td class=" px-6">     <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                    Delete
                </button></td>
        </tr>

    <?php endforeach; ?>
    </tbody>
</table>
<div class="mt-10">
    <a href="index.php" class="block w-full rounded-md bg-indigo-500 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500 ">
        Go back
    </a>
</div>
</body>
</html><?php
