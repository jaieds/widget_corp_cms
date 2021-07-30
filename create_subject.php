<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>

<?php
global $connection;
$errors = [];
$field_names = ['menu_name', 'position', 'visible'];

foreach ($field_names as $filed_name) {
    if (!isset($_POST[$filed_name]) || empty($_POST[$filed_name])) {
        $errors[] = $filed_name;
    }
}

$filed_name_lengths = array('menu_name' => 30);

foreach ($filed_name_length as $filed_name => $mx_length) {
    if (strlen(trim(mysqli_real_escape_string($connection, $_POST[$filed_name]))) > $mx_length) {
        $errors[] = $filed_name_length;
    }
}

if (!empty($errors)) {
    redirect_to("new_subject.php");
}
?>

<?php
$menu_name = mysqli_real_escape_string($connection, $_POST['menu_name']);
$position = mysqli_real_escape_string($connection, $_POST['position']);
$visible = mysqli_real_escape_string($connection, $_POST['visible']);
?>
<?php
$query = "INSERT INTO subjects (
            menu_name, position, visible
        ) VALUES (
            '{$menu_name}', {$position}, {$visible}
        )";
$result = mysqli_query($connection, $query);
if ($result) {
    header("Location: content.php");
    exit;
} else {
    echo "<p>Subject creation failed.</p>";
    echo "<p>" . mysqli_error($connection) . "</p>";
}
?>

<?php mysqli_close($connection); ?>