<?php
    function WriteHeaders($Heading = "Welcome", $TitleBar = "MySite")
    {
        echo "
        <!doctype html> 
        <html lang=\"en\"> 
        <head> 
            <meta charset = \"UTF-8\"> 
            <title>$TitleBar</title> 
            <link rel =\"stylesheet\" type = \"text/css\" href=\"style.css\"/>
        <head> 
        <body> 
        <h1>$Heading</h1>";

        return(0);
    }

    function label($Prompt)
    {
        echo "
        <label>$Prompt</label>";

        return(0);
    }

    function input($Name, $Size, $Value = "", $type)
    {
        echo "
        <input type=$type name=$Name size=$Size value=$Value>";

        return(0);
    }

    function WriteFooters()
    {
        echo "
        </body>
        </html>";

        return(0);
    }

    function DisplayContactInfo()
    {
        echo "
        <footer>
            <span>Questions? Comments?</span>
            <a href=\"mailto:Shane.Granger@student.sl.on.ca\">Shane.Granger@student.sl.on.ca</a>
        </footer>";

        return(0);
    }

    function DisplayImage($FileName, $Alt, $Height, $Width)
    {
        echo "
        <img src=$FileName alt=$Alt height=$Height width=$Width >";

        return(0);
    }

    function button($Name, $Text, $FileName = NULL, $Alt = NULL)
    {
        if ($FileName == NULL)
        {
            echo "
            <button type=submit name=$Name>$Text</button>";
        }
        else
        {
            echo "
            <button type=submit name=$Name>";
            DisplayImage($FileName, $Alt, 30, 30);
            echo "
            </button>";
        }

        return(0);
    }

    function form($open)
    {
        switch ($open)
        {
            case "open":
                echo "<form action=? method=post>";
                break;
            case "close":
                echo "</form>";
                break;
            default:
                echo "<form action=? method=post>";
                break;
        }
    }

    function div($open, $class = "")
    {
        switch ($open)
        {
            case "open":
                echo "<div class=$class>";
                break;
            case "close":
                echo "</div>";
                break;
        }
    }

    function CreateConnectionObject()
    {
        $fh = fopen('auth.txt','r');
        $Host =  trim(fgets($fh));
        $UserName = trim(fgets($fh));
        $Password = trim(fgets($fh));
        $Database = trim(fgets($fh));
        $Port = trim(fgets($fh)); 

        fclose($fh);

        $mysqlObj = new mysqli($Host, $UserName, $Password,$Database,$Port);
        if ($mysqlObj->connect_errno != 0) 
        {
            echo "<p>Connection failed. Unable to open database $Database. Error: "
            . $mysqlObj->connect_error . "</p>";
            exit;
        }
        
        return ($mysqlObj);
    }
?>