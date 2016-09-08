<?php

class Paginator
{
    private $module;
    private $table;
    private $pages;
    private $page;
    private $limit;
    private $result;
    private $sqlFilters;
    private $getParams;

    function __construct($module, $table, $page, $limit, $sqlFilters, $getParams)
    {
        $this->module = $module;
        $this->table = $table;
        $this->limit = $limit;
        $this->page = $page;

        $this->sqlFilters = '';
        $this->getParams = '';

        if (count($sqlFilters) > 0)
        {
            $this->sqlFilters = ' WHERE ' . implode(' AND ', $sqlFilters);
        }

        if (count($getParams) > 0)
        {
            $this->getParams .= '&' . implode('&', $getParams);
        }

        $this->result = array();

        $sqlQuery = 'SELECT COUNT(*) FROM ' . $table . $this->sqlFilters;
        $stmt = $GLOBALS['DB']->prepare('SELECT COUNT(*) FROM ' . $table . $this->sqlFilters);
        $stmt->execute();

        $items = $stmt->fetchColumn();
        $this->pages = ceil($items / $limit);
    }

    private function generate_link($page, $text)
    {
        if ($this->page == $page || $page == 'none')
        {
            array_push($this->result, array('text' => $text, 'url' => 'none'));
        }
        else
        {
            $pg_ulr = '/' . $this->module . '/index/?page=' . $page . '&limit=' . $this->limit . $this->getParams;
            array_push($this->result, array('text' => $text, 'url' => $pg_ulr));
        }
    }

    private function generate_by_range($from, $to)
    {
        for ($i = $from; $i <= $to; $i++)
        {
            $this->generate_link($i, $i);
        }
    }

    public function get_paginator()
    {
        $page = $this->page;
        $pages = $this->pages;

        if ($pages == 1)
        {
            return NULL;
        }

        // Previous page
        if ($page != 1)
        {
            $this->generate_link($page - 1, '&lsaquo;');
        }

        // Inner pages
        if ($pages <= 10)
        {
            $this->generate_by_range(1, $pages);
        }
        else
        {
            if ($page < 6)
            {
                $this->generate_by_range(1, $page + 2);
            }
            else
            {
                $this->generate_by_range(1, 2);
                $this->generate_link('none', '..');
            }

            if ($page >= 6 && $page <= $pages - 6)
            {
                $this->generate_by_range($page - 2, $page + 2);
            }

            if ($page > $pages - 6)
            {
                $this->generate_by_range($page - 2, $pages);
            }
            else
            {
                $this->generate_link('none', '..');
                $this->generate_by_range($pages - 1, $pages);
            }
        }

        // Next page
        if ($page != $pages)
        {
            $this->generate_link($page + 1, '&rsaquo;');
        }

        return $this->result;
    }
}
