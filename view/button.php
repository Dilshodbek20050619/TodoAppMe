<?php require 'view/components/header.php' ?>
<?php require 'view/components/navbar.php' ?>
    <style>
        body {
            background: linear-gradient(135deg, #1f4037, #99f2c8);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Arial', sans-serif;
            color: white;
        }

        .custom-button-but {
            position: relative;
            background: linear-gradient(90deg, #7ef0ff, #17565e);
            color: #fff;
            padding: 15px 30px;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.4s ease;
            box-shadow: 0 8px 15px rgba(117, 255, 149, 0.4);
            text-decoration: none;
            overflow: hidden;
            margin: 10px;
        }

        .custom-button-but:hover {
            background: linear-gradient(90deg, #8eff75, #39fd3d);
            box-shadow: 0 12px 20px rgba(85, 204, 81, 0.6);
            transform: translateY(-3px);
        }

        .custom-button-but::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.3);
            transform: skewX(-30deg);
            transition: all 0.5s ease;
        }

        .custom-button-but:hover::before {
            left: 100%;
        }
    </style>
    <a href="/todos" class="custom-button-but">Go to Todo</a>
    <a href="/telegram" class="custom-button-but">Telegram</a>
<?php require 'view/components/footer.php' ?>