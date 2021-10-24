<?php
function update($sql, $tableName, $position)
{
    $query = "
    UPDATE $tableName
    SET Likes = Likes + 1
    WHERE Position = $position
    ";

    $statement = $sql->prepare($query);
    $statement->execute();
}

function matchCheck($sql, $tableName)
{
    $query = "SELECT * FROM $tableName";

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

    while ($statement->fetch())
    {
        if ($likes == 2)
        {
            return($title);
        }
        else
        {
            return(null);
        }
    }
}

function clearLikes($sql, $tableName)
{
    $query = "UPDATE $tablename SET Likes = 0";
    $statement = $sql->prepare($query);
    $statement->execute();
}
?>