<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
if (intval($_GET['subj']) == 0) {
    redirect_to('content.php');
}
if (isset($_POST['submit'])) {
    global $connection;
    $errors = [];
    $field_names = ['menu_name', 'position', 'visible'];

    foreach ($field_names as $field_name) {
        if (!isset($_POST[$field_name]) || (empty($_POST[$field_name]) && ($_POST[$field_name] == ''))) {
            $errors[] = $field_name;
        }
    }

    $field_name_lengths = array('menu_name' => 30);

    foreach ($field_name_lengths as $field_name => $mx_length) {
        if (strlen(trim(mysqli_real_escape_string($connection, $_POST[$field_name]))) > $mx_length) {
            $errors[] = $field_name_length;
        }
    }

    if (!empty($errors)) {
        $message = "There were " . count($errors) . " errors in the form!";
    } else {
        $id = mysqli_real_escape_string($connection, $_GET['subj']);
        $menu_name = mysqli_real_escape_string($connection, $_POST['menu_name']);
        $position = mysqli_real_escape_string($connection, $_POST['position']);
        $visible = mysqli_real_escape_string($connection, $_POST['visible']);

        $query = "UPDATE subjects SET
                    menu_name='{$menu_name}',
                    position='{$position}',
                    visible='{$visible}'
                WHERE id={$id}";
        $result = mysqli_query($connection, $query);
        if (mysqli_affected_rows($connection) == 1) {
            $message = "The subject was successfully updated!";
        } else {
            $message = "The subject update failed!";
        }
    }
}
?>

<?php include("includes/header.php"); ?>
<?php find_selected_page(); ?>

<table id="structure">
    <tr>
        <td id="navigation">
            <?php echo navigation($subject, $page); ?>
        </td>
        <td id="page">
            <h2>Edit Subject: <?php echo $subject['menu_name']; ?></h2>
            <?php
            if (!empty($message)) {
                echo "<p class=\"message\">{$message}</p>";
            }

            if (!empty($errors)) {
                echo "<p class=\"errors\">
                    Please review the following fields: <br>";
                foreach ($errors as $error) {
                    echo " - " . $error . "<br>";
                }
                echo "<p>";
            }
            ?>
            <form action="edit_subject.php?subj=<?php echo urlencode($subject['id']); ?>" method="post">
                <p>Subject name:
                    <input type="text" name="menu_name" value="<?php echo $subject['menu_name']; ?>" id="menu_name" />
                </p>
                <p>Position:
                    <select name="position">
                        <?php
                        $subject_set = get_all_subjects();
                        $subject_count = mysqli_num_rows($subject_set);

                        for ($count = 1; $count <= $subject_count + 1; $count++) {
                            echo "<option value=\"{$count}\"" . ($subject['id'] == $count ? "selected" : NULL) . ">
                                {$count}</option>";
                        }
                        ?>
                    </select>
                </p>
                <p>Visible:
                    <input type="radio" name="visible" value="0" <?php echo $subject['visible'] == 0 ? "checked" : NULL; ?> /> No
                    &nbsp;
                    <input type="radio" name="visible" value="1" <?php echo $subject['visible'] == 1 ? "checked" : NULL; ?> /> Yes
                </p>
                <input type="submit" value="Edit Subject" name="submit" />
                &nbsp;&nbsp;
                &nbsp;&nbsp;
                <a href="delete_subject.php?subj=<?php echo urlencode($subject['id']) ?>" onclick="return confirm('Are you sure?')">Delete Subject</a>
            </form>
            <br />
            <a href="content.php">Cancel</a>
        </td>
    </tr>
</table>

<?php require("includes/footer.php"); ?>