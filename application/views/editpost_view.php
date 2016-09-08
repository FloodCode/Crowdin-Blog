<div class="container">
    <h2>Edit post</h2>
    <form action="/main/edit/?id=<?php echo $_GET['id']; ?>" method="post">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($data['post']['title']); ?>" required>
        </div>
        <div class="form-group">
            <label for="title">Short message:</label>
            <textarea name="short_message"><?php echo htmlspecialchars($data['post']['short_message']); ?></textarea>
            <script>
                CKEDITOR.replace('short_message');
            </script>
        </div>
        <div class="form-group">
            <label for="title">Message:</label>
            <textarea name="message"><?php echo htmlspecialchars($data['post']['message']); ?></textarea>
            <script>
                CKEDITOR.replace('message');
            </script>
        </div>
        <button type="submit" class="btn btn-primary">Save changes</button>
    </form>
</div>
