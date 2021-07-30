<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php include("includes/header.php"); ?>

<?php
find_selected_page();
?>

<table id="structure">
    <tr>
        <td id="navigation">
            <?php echo navigation($subject, $page); ?>
            <br>
            <a href="/new_subject.php">+ Add a new subject</a>
        </td>
        <td id="page">
            <h2><?php echo $page_heading; ?></h2>
            <br>
            <div class="page-content">
                <?php echo $page_content; ?>
            </div>
        </td>
    </tr>
</table>

<?php require("includes/footer.php"); ?>