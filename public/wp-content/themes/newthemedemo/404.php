<?php wp_head(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-color: rgba(58, 59, 60, 1);
            padding: 20% 0 20% 0;
            background-image: url(<?php echo get_theme_file_uri('images/error-img.png') ?>);
            background-size: 60%;
            background-repeat: no-repeat;
            background-position-x: 80%;
        }

        h1 {
            color: white;
            font-size: 60px;
            font-family: 'Montserrat', sans-serif;
        }

        button {
            width: 34%;
            font-size: 16px;
            font-family: 'Montserrat';
            font-weight: bold;
            margin: -1rem 0 0 0;
            padding: 0.6rem 0 0.6rem 0;
            border-radius: 18px;
            transition: background-color 0.5s ease-out 50ms;
            border-color: rgba(255, 255, 255, 0.0);
        }

        button:hover {
            background-color: #ffdd1a;
        }

        div {
            margin: -2rem 0 0 6rem;
            width: 30%;
            text-align: center;
        }
    </style>
</head>

<body>
    <div>
        <h1>PAGE NOT FOUND</h1>
        <a href="index.php">
            <button type="button">GO TO HOMEPAGE</button>
        </a>
    </div>


</body>

</html>