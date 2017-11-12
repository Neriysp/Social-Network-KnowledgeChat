<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <?php include 'css/css.html'; ?>
</head>

<body>
    <div class="form">

        <h1>Welcome
            <?php echo $firstName.' '.$lastName ?>
        </h1>

        <p>
            <?php 
          echo
            "<p>
            Confirmation link has been sent to $email, please verify your account by clicking on the link in the message!
            </p>";
          ?>
        </p>

        <?php
          
            echo
            '<div class="info">
            Account is unverified, please confirm your email by clinking on the email link!
            </div>';
          ?>

            <h2>
                <?= $firstName.' '.$lastName; ?>
            </h2>
            <p>
                <?=$email ?>
            </p>

            <a href="logout.php"><button class="button button-block" name="logout" />Log Out</button>
            </a>

    </div>

    <script src='js/jquery-3.2.1.min.js'></script>
    <script src="js/index.js"></script>

</body>

</html>