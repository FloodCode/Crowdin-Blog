<?php

class Model_Message extends Model
{

    public function get_data()
    {
        if (!isset($_GET['type']) || !isset($_GET['code']))
        {
            Route::errorPage404();
        }

        $data = [];
        if ($_GET['type'] == '1')
        {
            $data['type'] = 'success';
            $data['title'] = 'Success!';
            switch ($_GET['code'])
            {
                case '1': $data['message'] = 'Message was successfully sent!'; break;
                case '2': $data['message'] = 'Comment was successfully deleted!'; break;
                default: Route::errorPage404(); break;
            }
        }
        else if ($_GET['type'] == '2')
        {
            $data['type'] = 'danger';
            $data['title'] = 'Error:';
            switch ($_GET['code'])
            {
                case '1': $data['message'] = 'Can\'t delete post.'; break;
                case '2': $data['message'] = 'ReCaptcha error.'; break;
                case '3': $data['message'] = 'Wrong email or password.'; break;
                case '4': $data['message'] = 'Please fill out all fields.'; break;
                case '5': $data['message'] = 'Telegram api error.'; break;
                case '6': $data['message'] = 'An error occured while posting the comment.'; break;
                case '7': $data['message'] = 'The post you are trying to comment is not exist.'; break;
                case '8': $data['message'] = 'The comment you are trying to delete is not exist.'; break;
                case '9': $data['message'] = 'An error occured while removing the comment.'; break;
                default: Route::errorPage404(); break;
            }
        }

        return $data;
    }

}
