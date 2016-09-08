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
}

?>
