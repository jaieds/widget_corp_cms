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

function get_subject_by_id($sub_id)
{
    global $connection;
    $query = "SELECT *
             FROM subjects
             WHERE id=" . $sub_id . "
             LIMIT 1";
    $reqult_set = mysqli_query($connection, $query);
    confirm_query($reqult_set);
    $subject = mysqli_fetch_assoc($reqult_set);

    if (!$subject) {
        return NULL;
    }

    return $subject;
}

function get_page_by_id($page_id)
{
    global $connection;
    $query = "SELECT *
             FROM pages
             WHERE id=" . $page_id . "
             LIMIT 1";
    $reqult_set = mysqli_query($connection, $query);
    confirm_query($reqult_set);
    $page = mysqli_fetch_assoc($reqult_set);

    if (!$page) {
        return NULL;
    }

    return $page;
}

function find_selected_page()
{
    global $subject;
    global $page;
    global $page_heading;
    global $page_content;

    if (isset($_GET['subj'])) {
        $subject = get_subject_by_id($_GET['subj']);
        $page_heading = $subject['menu_name'];
        $page = NULL;
    } else if (isset($_GET['page'])) {
        $page = get_page_by_id($_GET['page']);
        $page_heading = $page['menu_name'];
        $page_content = $page['content'];
        $subject = NULL;
    } else {
        $page_heading = "Content Area";
        $page_content = NULL;
    }
}

function navigation($subject, $page)
{
    global $connection;

    $output = "<ul class=\"subjects\">";
    $subjects_results = get_all_subjects();
    confirm_query($subjects_results);

    while ($row = mysqli_fetch_assoc($subjects_results)) {
        $output .= "<li " . ($row['id'] == (isset($subject['id']) ? $subject['id'] : NULL) ? "class=\"selected\"" : NULL) . ">
                        <a href=\"edit_subject.php?subj=" . urlencode($row['id']) . "\">
                        {$row['menu_name']}</a></li>";

        if ($row['id'] == $subject['id']) {
            $pages_results = get_all_pages_by_sub($row['id']);
            confirm_query($pages_results, $connection);

            $output .= "<ul class=\"pages\">";
            while ($row_pages = mysqli_fetch_assoc($pages_results)) {
                $output .= "<li " . ($row_pages['id'] == (isset($page['id']) ? $page['id'] : NULL) ? "class=\"selected\"" : NULL) . ">
                            <a href=\"content.php?page=" . urlencode($row_pages['id']) . "\">
                            {$row_pages['menu_name']}</a></li>";
            }
            $output .= "</ul>";
        }
    }
    $output .= "</ul>";

    return $output;
}

function redirect_to($location = NULL)
{
    if ($location != NULL) {
        header("Location: {$location}");
        exit;
    }
}
