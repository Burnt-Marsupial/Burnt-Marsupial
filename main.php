<?php
    require_once("include.php");
    require_once("imdb.php");
    session_start();

    $sql = createConnectionObject();
    $tableName = "watchList";

    if (isset($_POST["next"]))
    {
        $position = $_SESSION['position'];
    }
    else
    {
        $position = 0;
    }

    $_SESSION['position'] = $position + 1;
    $position = $_SESSION['position'];


    if($_POST["yesNo"] == "yes")
    {
        update($sql, $tableName, $position - 1);
        $match = matchCheck($sql, $tableName);
        $_POST["yesNo"] = " ";
    }

    if ($match != NULL)
    {
        echo "<h1>Match found: $match</h1>";
    }

    

    
    
    $query = "SELECT * FROM $tableName WHERE position=$position";
    

    $statement = $sql->prepare($query);
    $statement->execute();
    $statement->bind_result
    (
        $dbPosition,
        $likes,
        $created,
        $modified,
        $description,
        $title,
        $url,
        $titleType,
        $rating,
        $runtime,
        $year,
        $genres,
        $numVotes,
        $releaseDate,
        $directors,
        $yourRating,
        $dateRated
    );
    $statement->fetch();

    writeHeaders($title, "Movie Matcher");
    echo "<p>Runtime: $runtime minutes</p>";
    echo "<p>IMDB Rating: $rating</p>";
    echo "<p>Genres: $genres</p>";

    form("open");

    div("open");
    label("Thumbs Up");
    input("yesNo", 1, "yes", "radio");
    div("close");

    div("open");
    label("Thumbs Down");
    input("yesNo", 1, "no", "radio");
    div("close");

    button("next", "Next");
    form("close");
    writeFooters();
?>