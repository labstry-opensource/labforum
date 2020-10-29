<?php
include dirname(__FILE__) . '/autoload.php';

?>

<form action="/forum/api/admin/user-search.php" method="POST">
    <input type="text" name="username">
    <input type="submit" name="Submit" value="Submit">
</form>
