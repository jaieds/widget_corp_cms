<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>

<?php
if (intval($_GET['subj']) == 0) {
    redirect_to('content.php');
}

$id = mysqli_real_escape_string($connection, $_GET['subj']);
$query = "DELETE FROM subjects WHERE id={$id} LIMIT 1";

if ($subject = get_subject_by_id($id)) {
    mysqli_query($connection, $query);
    if (mysqli_affected_rows($connection) == 1) {
        redirect_to('content.php');
    } else {
        echo "<p>Subject delete failed!</p>";
        echo "<p>Error:" . mysqli_error($connection) . " </p><br>";
        echo "<a href=\"content.php\">Return to Main page</p>";
    }
} else {
    redirect_to('content.php');
}


mysqli_close($connection);
?>