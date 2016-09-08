<div class="container">
    <h2>Add new post</h2>
    <form action="/main/add/" method="post">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="title">Short message:</label>
            <textarea name="short_message"></textarea>
            <script>
                CKEDITOR.replace('short_message');
            </script>
        </div>
        <div class="form-group">
            <label for="title">Message:</label>
            <textarea name="message"></textarea>
            <script>
                CKEDITOR.replace('message');
            </script>
        </div>
        <button type="submit" class="btn btn-primary">Add post</button>
    </form>
</div>
