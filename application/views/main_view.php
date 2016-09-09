<div class="container">
    <?php if (count($data['posts']) == 0): ?>
        <h2>No posts</h2>
    <?php else: ?>
        <?php for ($i = 0; $i < count($data['posts']); ++$i): ?>
        <div>
            <hr>
            <a href="/main/view/?id=<?php echo $data['posts'][$i]['id'];?>"><h2><?php echo $data['posts'][$i]['title']; ?></h2></a>
            <?php echo $data['posts'][$i]['short_message']; ?>
            <hr>
            <div class="row">
                <div class="col-sm-6">
                    <i>Views: <?= $data['posts'][$i]['views'] ?> | Comments: <?= Tools::getCommentCount($data['posts'][$i]['id']) ?> | Posted: <?= $data['posts'][$i]['time'] ?></i>
                </div>
                <div class="col-sm-6 text-right">
                    <?php if (Route::checkAuth()): ?>
                        <p>
                            <a href="/main/edit/?id=<?php echo $data['posts'][$i]['id'];?>" style="display: inline;">[Edit post]</a>
                            <a href="/main/delete/?id=<?php echo $data['posts'][$i]['id'];?>" style="display: inline;">[Delete post]</a>
                        </p>
                    <?php endif;?>
                </div>
            </div>
        </div>
        <?php endfor; ?>
        <?php include 'paginator_view.php'; ?>
    <?php endif; ?>
</div>
