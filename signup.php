<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Sign Up</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Comfortaa';
        }

        body {
            height: 100vh;
            background-color: #2f3542;
        }

        .login {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 350px;
            padding: 40px;
            text-align: center;
            border-radius: 10px;
            box-shadow: -5px -5px 10px #ffffff10, 5px 5px 15px #00000066;
            background-color: white;
        }

        h1 {
            color: black;
            font-weight: lighter;
            text-transform: uppercase;
            letter-spacing: 5px;
        }

        .username, .password {
            margin: 25px 0;
            width: 100%;
            text-align: center;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            height: 50px;
            padding: 25px;
            background: transparent;
            border: 1px solid black;
            outline: none;
            border-radius: 50px;
            color: black;
        }

        input[type="text"]:focus, input[type="password"]:focus {
            box-shadow: inset -1.8px -1.8px 7px #ffffff10, inset 1.8px 1.8px 10px #00000077;
        }

        input[type="text"]::placeholder, input[type="password"]::placeholder {
            color: black;
        }

        input[type="submit"] {
            width: 100%;
            height: 50px;
            background: black;
            border: 1px solid black;
            border-radius:  15px;
            outline: none;
            color: white;
            cursor: pointer;
            font-size: 20px;
            transition: transform .2s linear;
        }

        input[type="submit"]:hover {
            transform: scale(1.25);
        }

        p {
            margin: 20px 0 50px;
            color: black;
            font-size: 18px;
            
        }

        a {
            color: #5352ed;
            text-decoration: none;
            transition: color .1s linear;
        }

        a:hover {
            color: #3742fa;
        }

    </style>
</head>
<body>
    <div class="login">
        <h1>Sign Up</h1>
        <form method="POST" action="signup_process.php">
            <div class="username">
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="password">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <input type="submit" value="Sign Up">
        </form>
        <p>Already have an account ? <a href="Login.php">Log in</a></p>
    </div>
</body>
</html>
