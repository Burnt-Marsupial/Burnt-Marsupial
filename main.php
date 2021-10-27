<?php
    require_once("movie.php");
    require_once("include.php");

    session_start();
    
    if (isset($_POST['movie']))
    {
        $_SESSION['medium'] = "movie";
        initialiseSession("movie");
    }
    else if (isset($_POST['tvSeries']))
    {
        $_SESSION['medium'] = "tvSeries";
        initialiseSession("tvSeries");
    }
    else if (isset($_POST['up']))
    {
        if (matchCheck())
        {
            displayMatch();
        }
        else
        {
            matcher("up");
        }
    }
    else if (isset($_POST['down']))
    {
        if (matchCheck())
        {
            displayMatch();
        }
        else
        {
            matcher("down");
        }
    }
    else
    {
        homePage();
    }

    function homePage()
    {
        headers("Movie Matcher", "style.css");
        
        h1("Movie Matcher");

        openForm();

        label("Clear Database");
        input("checkbox", "clear");
        br();
        label("Number of users:");
        input("number", "numUsers", "1", "2");
        br();
        button("movie", "Movies");
        button("tvSeries", "Shows");

        closeForm();

        footers();
    }

    function initialiseSession($type)
    {
        $tableName = "watchList";
        $sql = createConnectionObject();

        $_SESSION['numUsers'] = $_POST['numUsers'];

        if (isset($_POST['clear']))
        {
            $query = "UPDATE $tableName SET Likes = 0";

            $statement = $sql->prepare($query);
            $statement->execute();
        }

        $entries = array();
        $index = 0;

        $query = "SELECT * FROM $tableName WHERE `Title Type` =  \"$type\"";

        $statement = $sql->prepare($query);
        $statement->execute();

        $statement->bind_result(
            $title,
            $url,
            $titleType,
            $rating,
            $runtime,
            $genre,
            $releaseDate,
            $directors,
            $position,
            $likes
        );

        while ($statement->fetch())
        {
            $entry = new Movie();

            $entry->title = $title;
            $entry->url = $url;
            $entry->titleType = $titleType;
            $entry->rating = $rating;
            $entry->runtime = $runtime;
            $entry->genre = $genre;
            $entry->releaseDate = $releaseDate;
            $entry->directors = $directors;
            $entry->position = $position;
            $entry->likes = $likes;

            array_push($entries, $entry);
        }

        $movie = $entries[$index];

        $_SESSION['entries'] = $entries;

        movie($movie);

        $_SESSION['index'] = $index;
    }

    function matcher($result)
    {
        $index = $_SESSION['index'];
        $movie = $_SESSION['entries'][$index];

        if ($result == "up")
        {
            $position = $movie->position;
            $tableName = "watchlist";
            $query = "UPDATE $tableName SET Likes = Likes + 1 WHERE Position = $position";

            $sql = createConnectionObject();
            $statement = $sql->prepare($query);
            $statement->execute();
        }

        $index++;
        $movie = $_SESSION['entries'][$index];

        movie($movie);

        $_SESSION['index'] = $index;
    }

    function movie($movie)
    {
        headers("Movie Matcher", "style.css");

        h1($movie->title);
        a($movie->url);
        br();

        p("Rating: " . $movie->rating);
        p("Runtime: " . $movie->runtime . " minutes");
        p("Genre: " . $movie->genre);
        p("Release Date: " . $movie->releaseDate);
        p("Director: " . $movie->directors);

        openForm();
        button("up", "Thumbs Up");
        button("down", "Thumbs Down");
        closeForm();

        footers();
    }

    function matchCheck()
    {
        $_SESSION['match'] = "blank";
        $result = false;
        $tableName = "watchlist";
        $sql = createConnectionObject();
        $query = "SELECT * FROM $tableName";

        $statement = $sql->prepare($query);
        $statement->execute();
        
        $statement->bind_result(
            $title,
            $url,
            $titleType,
            $rating,
            $runtime,
            $genre,
            $releaseDate,
            $directors,
            $position,
            $likes
        );

        while ($statement->fetch())
        {
            if ($likes >= $_SESSION['numUsers'])
            {
                $result = true;
                $_SESSION['match'] = $title;
                break;
            }
        }

        return($result);
    }

    function displayMatch()
    {
        headers("Movie Matcher", "style.css");

        h1("Match Found:");
        h1($_SESSION['match']);

        footers();
    }
?>