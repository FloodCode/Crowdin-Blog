<div class="container">
    <?php if (count($data['posts']) == 0): ?>
        <h2>No posts</h2>
    <?php else: ?>
        <?php for ($i = 0; $i < count($data['posts']); ++$i): ?>
        <div>
            <hr>
            <a href="/main/view/?id=<?php echo $data['posts'][$i]['id'];?>"><h2><?php echo $data['posts'][$i]['title']; ?></h2></a>
            <?php echo $data['posts'][$i]['short_message']; ?>
            <?php if (Route::checkAuth()): ?>
                <p>
                    <a href="/main/edit/?id=<?php echo $data['posts'][$i]['id'];?>" style="display: inline;">Edit post</a> |
                    <a href="/main/delete/?id=<?php echo $data['posts'][$i]['id'];?>" style="display: inline;">Delete post</a>
                </p>
            <?php endif;?>
            <hr>
            <i>Posted: <?php echo $data['posts'][$i]['time']; ?> | Views: <?php echo $data['posts'][$i]['views']; ?></i>
        </div>
        <?php endfor; ?>
        <?php include 'paginator_view.php'; ?>
    <?php endif; ?>
</div>
