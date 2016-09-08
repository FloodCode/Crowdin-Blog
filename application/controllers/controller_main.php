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
        $res = $stmt->execute(array(':id' => $_GET['id']));

        if ($res !== true)
        {
            Route::errorPage404();
        }

        $post = $stmt->fetch(PDO::FETCH_NAMED);

        if ($post === false)
        {
            Route::errorPage404();
        }

        $data = array('post' => $post);

        $stmt_view = $GLOBALS['DB']->prepare('UPDATE posts SET `views` = `views` + 1 WHERE `id` = :id;');
        $stmt_view->execute(array(':id' => $_GET['id']));

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

            if ($res === true)
            {
                header('Location:/main/view/?id=' . $GLOBALS['DB']->lastInsertId());
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
        $res = $stmt->execute(array(':id' => $_GET['id']));

        if (res == true)
        {
            header('Location:/');
        }
        else
        {
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
        $res = $stmt_post->execute(array(':id' => $_GET['id']));
        if ($res !== true)
        {
            Route::errorPage404();
        }

        $post = $stmt_post->fetch(PDO::FETCH_NAMED);

        if ($post === false)
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

            if ($res === true)
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
}
