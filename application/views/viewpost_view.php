<div class="container">
    <h2><?= $data['post']['title'] ?></h2>
    <?= $data['post']['message'] ?>
    <hr>
    <div class="row">
        <div class="col-sm-6">
            <i>Posted: <?= $data['post']['time'] ?> | Views: <?= $data['post']['views'] ?></i>
        </div>
        <div class="col-sm-6 text-right">
            <?php if (Route::checkAuth()): ?>
                <p>
                    <a href="/main/edit/?id=<?php echo $data['post']['id'];?>">[Edit post]</a>
                    <a href="/main/delete/?id=<?php echo $data['post']['id'];?>">[Delete post]</a>
                </p>
            <?php endif;?>
        </div>
    </div>
    <h3 id="comments">Add comment</h3>
    <form method="post" action="/main/addcomment/">
        <input type="hidden" name="post_id" value="<?= $data['post']['id'] ?>">
        <div class="form-group">
            <label for="username">Name:</label>
            <input type="text" class="form-control" id="username" name="username" required="">
        </div>
        <div class="form-group">
            <label for="comment">Comment:</label>
            <textarea class="form-control" rows="7" id="comment" name="comment" required=""></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Add comment</button>
        <button type="reset" class="btn btn-default">Clear</button>
    </form>
    <hr>
    <?php if ($data['comments'] == false): ?>
        <h3>No comments</h3>
    <?php else: ?>
        <h3><?= count($data['comments']) ?> comment<?= count($data['comments']) != 1 ? 's' : '' ?>:</h3>
        <hr>
    <?php foreach ($data['comments'] as $comment): ?>
        <h4><strong><?= htmlspecialchars($comment['username']) ?></strong></h4>
        <p><?= htmlspecialchars($comment['comment']) ?></p>
        <div class="row">
            <div class="col-sm-6">
                <h5><small>Posted: <?= $comment['time'] ?></small></h5>
            </div>
            <div class="col-sm-6 text-right">
                <?php if (Route::checkAuth()): ?>
                    <h5><small><a href="/main/deletecomment/?id=<?= $comment['id'] ?>">Delete</a></small></h5>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
    <?php endif; ?>
</div>
