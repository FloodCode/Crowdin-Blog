<?php

class Controller_Contact extends Controller
{
    function action_index()
    {
        $this->view->title = 'Contacts';
        $this->view->generate('contact_view.php', 'template_view.php');
    }

    function action_send()
    {
        if (!isset($_POST['subject']) || !isset($_POST['email']) || !isset($_POST['message']))
        {
            header('Location:/message/index/?type=2&code=4');
            return;
        }

        $message =
        "*E-mail:*\n`" . $_POST['email'] . "`\n" .
        "*IP:*\n`" . $_SERVER['REMOTE_ADDR'] . "`\n" .
        "*Subject:*\n" . $_POST['subject'] . "\n" .
        "*Message:*\n" . $_POST['message'];

        $headers = array("Content-Type:multipart/form-data");
        $postfields = array(
            "chat_id" => "@Crowdin",
            "text" => $message,
            "parse_mode" => "Markdown"
        );

        $ch = curl_init();
        $options = array(
            CURLOPT_URL => "https://api.telegram.org/bot266551430:AAEihr601NRjlLwS4qFuhglQgC6LibX62ts/sendMessage",
            CURLOPT_HEADER => true,
            CURLOPT_POST => 1,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POSTFIELDS => $postfields,
            CURLOPT_RETURNTRANSFER => true
        );
        curl_setopt_array($ch, $options);
        curl_exec($ch);

        if(!curl_errno($ch))
        {
            $info = curl_getinfo($ch);
            if ($info['http_code'] == 200)
            {
                header('Location:/message/index/?type=1&code=1');
                return;
            }
            else
            {
                header('Location:/message/index/?type=2&code=5');
                return;
            }
            curl_close($ch);
        }
        else
        {
            header('Location:/message/index/?type=2&code=5');
            return;
        }
    }
}
