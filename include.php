<?php
    function headers($title, $css)
    {
        echo "
        <!DOCTYPE html>
        <html lang=\"en\">
        <head>
            <meta charset=\"UTF-8\">
            <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
            <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
            <link rel=\"stylesheet\" href=$css>
            <title>$title</title>
        </head>
        <body>";
    }

    function footers()
    {
        echo "
        </body>
        </html>";
    }

    function button($name, $text)
    {
        echo "
        <button type=submit name=$name>$text</button>";
    }

    function openForm()
    {
        echo "
        <form method=\"post\" action=\"?\">";
    }

    function closeForm()
    {
        echo "
        </form>";
    }

    function h1($text)
    {
        echo "
        <h1>$text</h1>";
    }

    function createConnectionObject()
    {
        $fh = fopen('auth.txt','r');
        $Host =  trim(fgets($fh));
        $UserName = trim(fgets($fh));
        $Password = trim(fgets($fh));
        $Database = trim(fgets($fh));
        $Port = trim(fgets($fh)); 

        fclose($fh);

        $sql = new mysqli($Host, $UserName, $Password,$Database,$Port);
        if ($sql->connect_errno != 0) 
        {
            echo "<p>Connection failed. Unable to open database $Database. Error: "
            . $sql->connect_error . "</p>";
            exit;
        }
        
        return ($sql);
    }

    function p($text)
    {
        echo "
        <p>$text</p>";
    }

    function br()
    {
        echo "<br>";
    }

    function input($type, $name, $size = "", $value = "")
    {
        echo "
        <input type=\"$type\" name=\"$name\" size=\"$size\" value=\"$value\">";
    }

    function label($text)
    {
        echo "
        <label>$text</label>";
    }

    function a($link)
    {
        echo "
        <a href=\"$link\" target=\"_blank\">$link</a>";
    }
?>