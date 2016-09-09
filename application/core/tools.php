<?php

class Tools
{
    static function getModuleName($content_view)
    {
        $module_name = 'none';
        $pos1 = strpos($content_view, '_');
        if ($pos1 != FALSE)
        {
            $module_name = substr($content_view, 0, $pos1);
            $pos2 = strpos($module_name, '_');
            if ($pos2 != FALSE)
            {
                $module_name = substr($module_name, 0, $pos2);
            }
        }
        return $module_name;
    }

    static function getCommentCount($post_id)
    {
        $stmt = $GLOBALS['DB']->prepare('SELECT COUNT(*) FROM comments WHERE `post_id` = :post_id;');
        $res = $stmt->execute(array(
            ':post_id' => $post_id
        ));

        if ($res == false)
        {
            return 0;
        }

        $comments_count = $stmt->fetch(PDO::FETCH_COLUMN);

        if ($comments_count == false)
        {
            return 0;
        }

        return $comments_count;
    }
}

?>
