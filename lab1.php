<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dressabel</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            line-height: 1.6;
            color: #333;
            background: linear-gradient(to bottom right, #F4E1D2, #D3B89B);
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .header {
        display: flex;
        justify-content: center; /* Centers content horizontally */
        align-items: center; /* Centers content vertically */
        padding: 1rem 2rem;
        background: rgba(255, 255, 255, 0.9);
        position: relative; /* Allows absolute positioning of the logo */
    }

    .header .logo {
        position: absolute; /* Positions the logo without affecting the title */
        left: 1rem; /* Keeps the logo on the left side */
        height: 80px;
        width: auto;
    }

    .header .title {
        font-size: 2rem;
        font-weight: bold;
        color: #5D4037;
    }
        .main {
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 1;
            padding: 2rem;
        }

        .image-section {
            flex: 1;
            display: flex;
            justify-content: center;
        }

        .image-section img {
            width: 60%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .text-section {
            flex: 1;
            text-align: left;
            padding: 1rem;
        }

        .text-section .brief {
            font-size: 1.5rem;
            color: #5D4037;
            margin-bottom: 1rem;
        }

        .text-section .statement {
            font-size: 1.2rem;
            color: #7B5C47;
            margin-bottom: 2rem;
            font-style: italic;
        }

        .text-section .btn-action {
            background: #5D4037;
            color: #fff;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 5px;
            font-size: 1.2rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .text-section .btn-action:hover {
            background: #D3B89B;
            color: #fff;
        }
    </style>
   </head>
<body>
    <header class="header">
        <img class="logo" src="07Oct24_Anis_Free_Upload___1_-removebg-preview.png" alt="Dressabel logo">

        <div class="title">Welcome To Dressabel</div>
    </header>

    <main class="main">
        <div class="image-section">
            <img src="https://i.pinimg.com/736x/f9/ee/a4/f9eea44bc57a701e00775bf43988118b.jpg" alt="Fashion designer at work">
        </div>
        <div class="text-section">
            <div class="brief">Bringing creativity and style together. Connect with designers to craft your unique look.</div>
            <div class="statement">"Fashion Designer Connection Platform"</div>
           <a href="http://localhost/siri/logo4.php" class="btn-action">Get Started</a>
        </div>
    </main>
</body>
</html>