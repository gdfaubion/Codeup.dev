<?php

echo "<p>POST:</p>";
var_dump($_POST);

echo "<p>GET:</p>";
var_dump($_GET);

?>
<!DOCTYPE html>
<html>
<head>
	<title>My first first forms</title>
</head>
<body>
    <h2>User Login</h2>
	<form method="POST" action="">
    <p>
        <label for="username">Username</label>
        <input id="username" name="username" placeholder="username" type="text">
    </p>
    <p>
        <label for="password">Password</label>
        <input id="password" name="password" placeholder="password" type="password">
    </p>
    <p>
        <button type="submit">Login</button>
    </p>
	</form>
    <hr>
    <h2>Compose an email</h2>
    <form method="POST" action="">
    <p>
        <label for="username">Send email to:</label>
        <input type="text" id="email address" name="email address" value="" placeholder="username@email.com">
    </p>
    <p>
        <label for="">From:</label>
        <input type="text" id="return address" name="return address" placeholder="yourusername@emai.com">
    </p>
    <p>
        <label for="">Subject:</label>
        <input type="text" name="subject" id="subject" placeholder="subject">
    </p>
    <p>
        <textarea id="email body" name="email body" rows="15" cols="30">Your message here</textarea>
    </p>
    <p>
        <label>
            <input type="checkbox" id="save a copy" name="save a copy" value="yes" checked> Save a copy to your sent folder
        </label>
    </p>    
    <p>
        <button type="send">Send</button>
    </p>

    </form>
    <hr>
    <h2>Multiple Choice Questionnaire</h2>
    <form method="GET" action="">
        <p>What is my favorite color?</p>
        <p>
            <label for="q1a">
                <input type="radio" id="q1a" name="q1" value="Blue">
                Blue
            </label>
            <label for="q1b">
                <input type="radio" id="q1b" name="q1" value="Green">
                Green
            </label>
            <label for="q1c">
                <input type="radio" id="q1c" name="q1" value="Purple">
                Purple
            </label>
            <label for="q1d">
                <input type="radio" id="q1d" name="q1" value="Orange">
                Orange
            </label>
        </p>
        <p>What is my dogs name?</p>
        <p>
            <label for="q2a">
                <input type="radio" id="q2a" name="q2" value="Coco">
                Coco
            </label>
            <label for="q2b">
                <input type="radio" id="q2b" name="q2" value="Maggie">
                Maggie
            </label>
            <label for="q2c">
                <input type="radio" id="q2c" name="q2" value="Molly">
                Molly
            </label>
            <label for="q2d">
                <input type="radio" id="q2d" name="q2" value="Gretchen">
                Gretchen
            </label>
        </p>
        <p>
            <label>What are your top 3 favorite fruits?</label>
            <select id="fruit" name="fruit[]" multiple>
                <option value="Orange">Orange</option>
                <option value="Banana">Banana</option>
                <option value="Strawberry">Strawberry</option>
                <option value="Apple">Apple</option>
                <option value="Kiwi">Kiwi</option>
                <option value="Grape">Grape</option>
            </select>

        </p>
        <p>
            <button type="Submit">Submit</button>
        </p>
    </form>
    <hr>
    <h2>Select Testing</h2>
    <form method="GET" action="">
        <p>
        <label for="">Do you like chocolate?</label>
            <select id="chocolate" name="chocolate">
                <option value="1" selected>Yes</option>
                <option value="0">No</option>
            </select>
        </p>
        <p>
            <button type="Submit">Submit</button>
        </p>
    </form>    
</body>
</html>
<p></p>














