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
                case '4': $data['message'] = 'Please fill all fields.'; break;
                case '5': $data['message'] = 'Telegram api error.'; break;
                default: Route::errorPage404(); break;
            }
        }

        return $data;
    }

}
