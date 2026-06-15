<?php
session_start();
if(isset($_SESSION['user_id'] )){
    header("Location:main.php");exit();}

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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bungee&family=VT323&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Bungee&family=VT323&display=swap');
    </style>
    <?php require 'required files/tailwind-cdn.php';?>
    <link rel="stylesheet" href="main.css">
    <style>


        /* Center card panel */
        .dangan-landing-card {
            background: rgba(0, 0, 0, 0.95);
            border: 3px solid #ff007f;
            padding: 3.5rem 2.5rem;
            max-width: 700px;
            width: 100%;
            position: relative;
            z-index: 10;
            text-align: center;
        }



        /* Title block */
        .dangan-title {
            font-family: 'Syncopate', sans-serif;
            font-weight: 900;
            text-transform: uppercase;
            color: #ffffff;
            line-height: 1;
            margin-bottom: 1rem;
            font-size: clamp(1.5rem, 8vw, 5.5rem);
            font-family: VT323;

        ;
        }
        .dangan-title span {
            color: #FF0000;
            font-style: italic;
            font-family: VT323
        ;
        }

        /* Subtitle */
        .dangan-subtitle {
            font-family: 'Share Tech Mono', monospace;
            font-size: 1.05rem;
            color: #a1a1aa;
            letter-spacing: 0.05em;
            margin-bottom: 2.5rem;

        }

        /* Slashed navigation buttons */
        .dangan-btn-green {
            background: #3ABA4B;
            color: #000000;
            font-family: 'Syncopate', sans-serif;
            font-weight: 900;
            font-size: 0.8rem;
            letter-spacing: 0.2em;
            padding: 1rem 2.5rem;
            display: inline-block;
            transition: all 0.2s ease;
            font-family: Bungee;
        }
        .dangan-btn-green:hover {
            background: #A3FFBF;
            color: #000000;
            box-shadow: 0 0 15px rgba(0, 240, 255, 0.6);
            transform: scale(1.05) skewX(-4deg);
        }

        .dangan-btn-cyan {
            background: transparent;
            border: 1px solid #FBFF69;
            color: #FBFF69;
            font-family: 'Syncopate', sans-serif;
            font-weight: 900;
            font-size: 0.8rem;
            letter-spacing: 0.2em;
            padding: 1rem 2.5rem;
            display: inline-block;
            transition: all 0.2s ease;
            font-family: Bungee;
        }
        .dangan-btn-cyan:hover {
            background: #FBFF69;
            color: #000000;
            box-shadow: 0 0 15px rgba(0, 240, 255, 0.4);
            transform: scale(1.05) skewX(-4deg);</style>
</head>

<body class="dangan-bg-grid min-h-screen flex flex-col items-center justify-center p-4 ">

<!-- Central HUD module -->
<div class="dangan-landing-card relative md:scale-140">
    <img src="sprites/Danganronpa_V3_Monokuma_Bonus_Mode_Pixel_Icon_29.webp" class="absolute scale-80 top-0 left-0">
    <img src="sprites/Danganronpa_2_Monokuma_Pet_05.webp" class="absolute scale-80 top-0 right-0">
    <img src="sprites/Danganronpa_V3_Monomi_Pixel_Sprites_29.webp" class="absolute scale-80 bottom-0 right-0">
    <img src="sprites/Monokid_Bonus_Mode_Pixel_Icon_29.webp" class="absolute scale-80 bottom-0 left-0">

    <h2 class="dangan-title mt-5">Danguess<span>ronpa</span></h2>
    <p class="dangan-subtitle font-mono scale-110">A Danganronpa-inspired, Wordle-style guessing game.</p>

    <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-3">
        <a href="regristration.php" class="dangan-btn-green rounded-xl">Sign Up</a>
        <a href="login.php" class="dangan-btn-cyan rounded-xl">Login</a>
    </div>
</div> <!-- Added missing closing div -->
<audio src="voice_line/1-02 Danganronpa!.mp3" autoplay loop hidden  ></audio>

</body>
</html>
<?php

