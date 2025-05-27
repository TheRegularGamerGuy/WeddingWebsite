<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Justin & Sydney Wedding</title>
        <link rel="stylesheet" href="css/style.css" type="text/css"/>
        <script src="scripts/rsvp.js"></script>
        <script>
            const form = document.getElementById("form");
            form.addEventListener("submit", checkForm);
        </script>
        <?php
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $attendance = $_POST['attendance'];
        $numKids = $_POST['kids'];
        $numAdults = $_POST['adults'];
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
        <h2>Wedding RSVP</h2>
        <form action="rsvp.php" method="post">
            <label for="firstname">First Name:</label><br>
            <input type="text" id="firstname" name="firstname" required><br><br>
    
            <label for="lastname">Last Name:</label><br>
            <input type="text" id="lastname" name="lastname" required><br><br>
    
            <label for="attendance">Will you be attending?</label><br>
            <input type="radio" id="yes" name="attendance" value="yes" required>
            <label for="yes">Yes</label><br>
            <input type="radio" id="no" name="attendance" value="no">
            <label for="no">No</label><br><br>
    
            <label for="kids">How many kids are you bringing?</label><br>
            <input type="number" id="kids" name="kids" min="0" value="0"><br><br>
    
            <label for="adults">How many adults are you bringing (including yourself)?</label><br>
            <input type="number" id="adults" name="adults" min="1" value="1"><br><br>
    
            <input type="submit" value="Submit RSVP">
        </form>
        <?php
        }
        ?>

        <footer>
            <p>Saturday, August 9<sup>th</sup>, 2025 | Omaha, NE</p>
        </footer>
    </body>
</html>
