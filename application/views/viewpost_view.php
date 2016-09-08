<div class="container">
    <h2><?php echo $data['post']['title']; ?></h2>
    <?php echo $data['post']['message']; ?>
    <hr>
    <i>Posted: <?php echo $data['post']['time']; ?> | Views: <?php echo $data['post']['views']; ?></i>
    <hr>
    <?php if (Route::checkAuth()): ?>
        <p>
            <a href="/main/edit/?id=<?php echo $data['post']['id'];?>">Edit post</a> |
            <a href="/main/delete/?id=<?php echo $data['post']['id'];?>">Delete post</a>
        </p>
    <?php endif;?>
</div>
