<?php

class Controller_Main extends Controller
{
    function __construct()
    {
        $this->model = new Model_Main();
        $this->view = new View();
    }

    function action_index()
    {
        $data = $this->model->get_data();

        $this->view->title = 'Main';
        $this->view->generate('main_view.php', 'template_view.php', $data);
    }

    function action_view()
    {
        if (!isset($_GET['id']))
        {
            Route::errorPage404();
        }

        $stmt = $GLOBALS['DB']->prepare('SELECT * FROM posts WHERE `id` = :id;');
        $res = $stmt->execute(array(
            ':id' => $_GET['id']
        ));

        if ($res != true)
        {
            Route::errorPage404();
        }

        $post = $stmt->fetch(PDO::FETCH_NAMED);

        if ($post == false)
        {
            Route::errorPage404();
        }

        $stmt_comments = $GLOBALS['DB']->prepare('SELECT * FROM comments WHERE `post_id` = :post_id;');
        $res = $stmt_comments->execute(array(':post_id' => $_GET['id']));

        $comments = false;

        if ($res === true)
        {
            $comments = $stmt_comments->fetchAll(PDO::FETCH_NAMED);
        }

        $data = array(
            'post' => $post,
            'comments' => $comments
        );

        $stmt_view = $GLOBALS['DB']->prepare('UPDATE posts SET `views` = `views` + 1 WHERE `id` = :id;');
        $stmt_view->execute(array(
            ':id' => $_GET['id']
        ));

        $this->view->title = $post['title'];
        $this->view->generate('viewpost_view.php', 'template_view.php', $data);
    }

    function action_add()
    {
        Route::authRequired();

        if (isset($_POST['title']) && isset($_POST['short_message']) && isset($_POST['message']))
        {
            $stmt = $GLOBALS['DB']->prepare('INSERT INTO posts (`title`, `short_message`, `message`, `views`) VALUES (:title, :short_message, :message, 0);');
            $res = $stmt->execute(array(
                ':title' => $_POST['title'],
                ':short_message' => $_POST['short_message'],
                ':message' => $_POST['message']
            ));

            if ($res == true)
            {
                header('Location:/main/view/?id=' . $GLOBALS['DB']->lastInsertId());
                return;
            }
        }

        $this->view->title = 'Add post';
        $this->view->generate('addpost_view.php', 'template_view.php');
    }

    function action_delete()
    {
        Route::authRequired();

        if (!isset($_GET['id']))
        {
            Route::errorPage404();
        }

        $stmt = $GLOBALS['DB']->prepare('DELETE FROM posts WHERE `id` = :id;');
        $res = $stmt->execute(array(
            ':id' => $_GET['id']
        ));

        if (res == true)
        {
            header('Location:/');
        }
        else
        {
            // Can't delete post.
            header('Location:/message/index/?type=2&code=1');
        }
    }

    function action_edit()
    {
        Route::authRequired();

        $data = array();

        if (!isset($_GET['id']))
        {
            Route::errorPage404();
        }

        $stmt_post = $GLOBALS['DB']->prepare('SELECT * FROM posts WHERE `id` = :id');
        $res = $stmt_post->execute(array(
            ':id' => $_GET['id']
        ));
        if ($res != true)
        {
            Route::errorPage404();
        }

        $post = $stmt_post->fetch(PDO::FETCH_NAMED);

        if ($post == false)
        {
            Route::errorPage404();
        }

        $data['post'] = $post;

        if (isset($_POST['title']) && isset($_POST['short_message']) && isset($_POST['message']))
        {
            $stmt = $GLOBALS['DB']->prepare('UPDATE posts SET `title`=:title, `short_message`=:short_message, `message`=:message WHERE `id`=:id;');
            $res = $stmt->execute(array(
                ':title' => $_POST['title'],
                ':short_message' => $_POST['short_message'],
                ':message' => $_POST['message'],
                ':id' => $_GET['id']
            ));

            if ($res == true)
            {
                header('Location:/main/post/?id=' . $_POST['id']);
            }
            else
            {
                $data['error'] = "Can't edit post. Check all fields.";
            }
        }

        $this->view->title = 'Edit post';
        $this->view->generate('editpost_view.php', 'template_view.php', $data);
    }

    function action_addcomment()
    {
        if (!isset($_POST['post_id']) || !isset($_POST['username']) || !isset($_POST['comment']))
        {
            // Please fill out all fields.
            header('Location:/message/index/?type=2&code=4');
            return;
        }

        $stmt_post = $GLOBALS['DB']->prepare('SELECT COUNT(*) FROM posts WHERE `id` = :id;');
        $res = $stmt_post->execute(array(
            ':id' => $_POST['post_id']
        ));

        if ($res == false)
        {
            // The post you are trying to comment is not exist.
            header('Location:/message/index/?type=2&code=7');
            return;
        }

        $post_count = $stmt_post->fetch(PDO::FETCH_COLUMN);

        if ($post_count == false || $post_count == 0)
        {
            // The post you are trying to comment is not exist.
            header('Location:/message/index/?type=2&code=7');
            return;
        }

        $stmt_insert = $GLOBALS['DB']->prepare('INSERT INTO comments (`post_id`, `username`, `comment`) VALUES (:post_id, :username, :comment);');
        $res = $stmt_insert->execute(array(
            ':post_id' => $_POST['post_id'],
            ':username' => $_POST['username'],
            ':comment' => $_POST['comment']
        ));

        if ($res == false)
        {
            // An error occured while posting the comment.
            header('Location:/message/index/?type=2&code=6');
            return;
        }
        else
        {
            header('Location:/main/view/?id=' . $_POST['post_id'] . '#comments');
            return;
        }
    }

    function action_deletecomment()
    {
        if (!isset($_GET['id']))
        {
            Route::errorPage404();
        }

        $stmt_count = $GLOBALS['DB']->prepare('SELECT COUNT(*) FROM comments WHERE `id` = :id;');
        $res = $stmt_count->execute(array(
            ':id' => $_GET['id']
        ));

        if ($res == false)
        {
            // The comment you are trying to delete is not exist.
            header('Location:/message/index/?type=2&code=8');
            return;
        }

        $comment_count = $stmt_count->fetch(PDO::FETCH_COLUMN);

        if ($comment_count == false || $comment_count == 0)
        {
            // The comment you are trying to delete is not exist.
            header('Location:/message/index/?type=2&code=8');
            return;
        }

        $stmt_delete = $GLOBALS['DB']->prepare('DELETE FROM comments WHERE `id` = :id;');
        $res = $stmt_delete->execute(array(
            ':id' => $_GET['id']
        ));

        if ($res == false)
        {
            // An error occured while removing the comment.
            header('Location:/message/index/?type=2&code=9');
            return;
        }
        else
        {
            // Comment was successfully deleted!
            header('Location:/message/index/?type=1&code=2');
            return;
        }
    }
}
