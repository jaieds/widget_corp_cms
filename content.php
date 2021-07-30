<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php include("includes/header.php"); ?>

<?php
$sel_subject = NULL;
$sel_page = NULL;

if (isset($_GET['subj'])) {
    $sel_subject = $_GET['subj'];
} else if (isset($_GET['page'])) {
    $sel_page = $_GET['page'];
}
?>

<table id="structure">
    <tr>
        <td id="navigation">
            <ul class="subjects">
                <?php
                $subjects_results = get_all_subjects();
                confirm_query($subjects_results);

                while ($row = mysqli_fetch_assoc($subjects_results)) {
                    echo "<li " . ($row['id'] === $sel_subject ? "class=\"selected\"" : NULL) . ">
                        <a href=\"content.php?subj=" . urlencode($row['id']) . "\">
                        {$row['menu_name']}</a></li>";

                    $pages_results = get_all_pages_by_sub($row['id']);
                    confirm_query($pages_results, $connection);

                    echo "<ul class=\"pages\">";
                    while ($row_pages = mysqli_fetch_assoc($pages_results)) {
                        echo "<li " . ($row_pages['id'] === $sel_page ? "class=\"selected\"" : NULL) . ">
                            <a href=\"content.php?page=" . urlencode($row_pages['id']) . "\">
                            {$row_pages['menu_name']}</a></li>";
                    }
                    echo "</ul>";
                }
                ?>
            </ul>
        </td>
        <td id="page">
            <h2>Content Area</h2>
            <?php echo $sel_subject . "<br>"; ?>
            <?php echo $sel_page . "<br>"; ?>
        </td>
    </tr>
</table>

<?php require("includes/footer.php"); ?>