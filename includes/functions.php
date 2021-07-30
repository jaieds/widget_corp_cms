<?php

function confirm_query($reqult_set)
{
    global $connection;
    if (!$reqult_set) {
        die('Database query failed! ' . mysqli_error($connection) . '<br>');
    }
}

function get_all_subjects()
{
    global $connection;
    $subjects_query = "SELECT *
                    FROM subjects
                    ORDER BY position ASC";

    $subjects_results = mysqli_query($connection, $subjects_query);

    return $subjects_results;
}

function get_all_pages_by_sub($sub_id)
{
    global $connection;
    $pages_query = "SELECT *
                    FROM pages WHERE subject_id={$sub_id}
                    ORDER BY position ASC";

    $pages_results = mysqli_query($connection, $pages_query);

    return $pages_results;
}
