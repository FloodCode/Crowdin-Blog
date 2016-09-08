<?php if (!is_null($data['paginator'])): ?>
<div style="text-align: center;">
    <ul class="pagination">
        <?php foreach ($data['paginator'] as $pg_item): ?>
        <?php if ($pg_item['url'] == 'none'): ?>
            <li class="active"><a><?php echo $pg_item['text'] ?></a></li>
        <?php else: ?>
            <li><a href="<?php echo $pg_item['url'] ?>"><?php echo $pg_item['text'] ?></a></li>
        <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>
