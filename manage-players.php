<?php
require 'tailwind-cdn.php';
require 'db.php';

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
<table class="table-auto">
    <thead>
    <tr>
        <th>Username</th>
        <th>Gmail</th>
        <th>Role</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>The Sliding Mr. Bones (Next Stop, Pottersville)</td>
        <td>Malcolm Lockyer</td>
        <td>1961</td>
    </tr>
    <tr>
        <td>Witchy Woman</td>
        <td>The Eagles</td>
        <td>1972</td>
    </tr>
    <tr>
        <td>Shining Star</td>
        <td>Earth, Wind, and Fire</td>
        <td>1975</td>
    </tr>
    </tbody>
</table>
<div class="mt-10">
    <a href="index.php" class="block w-full rounded-md bg-indigo-500 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500 ">
        Go back
    </a>
</div>
</body>
</html><?php
