<?php
if (!isset($data))
{
    Route::errorPage404();
}
?>

<div class="container">
    <div class="alert alert-<?php echo $data['type']; ?>">
        <strong><?php echo $data['title'] ;?></strong> <?php echo $data['message'] ;?>
    </div>
    <a href="/">Go to main page</a>
</div>
