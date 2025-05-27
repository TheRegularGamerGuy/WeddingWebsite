<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Justin & Sydney Wedding</title>
        <link rel="stylesheet" href="css/style.css" type="text/css"/>
        <?php
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $attendance = $_POST['attendance'];
        ?>
    </head>
    <body>
        <header>
            <nav>
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="rsvp.php">RSVP</a></li>
                    <li><a href="info.html">Info</a></li>
                    <li><a href="registry.html">Registry</a></li>
                    <li><a href="our-story.html">Our Story</a></li>
                    <li><a href="wedding-party.html">Wedding Party</a></li>
                </ul>
            </nav>
        </header>

        <?php
        if (isset($firstname) && isset($lastname) && isset($attendance)) {
            $file = fopen("../responses.csv", "r") or die("Unable to process response. Try again later.");
            $text = fread($file, filesize("../responses.csv"));
            fclose($file);

            $responses = explode("\n", $text);
            $foundname = false;
            foreach ($responses as $response) {
                $name = $firstname.','.$lastname;
                if (!strncasecmp($response, $name, strlen($name))) {
                    $foundname = true;
                    break;
                }
            }
            if (!$foundname) {
                $file = fopen("../responses.csv", "a") or die("Unable to process response. Try again later.");
                $bytes = fwrite($file, $firstname.','.$lastname.','.$attendance.PHP_EOL);
                fclose($file);

                // for error checking
                if (!$bytes) {
                    echo 'Had some trouble sending your response to the server';
                }
            } else {
                // needs work
                echo '<script>alert("You already submitted a response. Would you like to update it?");</script>';
            }

            echo "<h1>Thank you for RSVPing!</h1>";
        } else {
        ?>
            <form action="rsvp.php" method="post" id="form">
                <input type="text" name="firstname" id="firstname">
                <label for="firstname">First Name</label><br>
                <input type="text" name="lastname" id="lastname">
                <label for="lastname">Last Name</label><br>
                <p>Are you attending?</p><br>
                <input type="radio" name="attendance" id="yes" value="yes">
                <label for="yes">Yes</label><br>
                <input type="radio" name="attendance" id="no" value="no">
                <label for="no">No</label><br>
                <input type="submit" value="RSVP">
            </form>
            <script src="scripts/rsvp.js"></script>
        <?php
        }
        ?>

        <footer>
            <p>Saturday, August 9<sup>th</sup>, 2025 | Omaha, NE</p>
        </footer>
    </body>
</html>
