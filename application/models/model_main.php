<?php

class Model_Main extends Model
{

    public function get_data()
    {
        $limit = 4;
        if (isset($_GET['limit']))
        {
            $limit = $_GET['limit'];
        }

        $page = 1;
        if (isset($_GET['page']))
        {
            $page = $_GET['page'];
        }

        $offset = $limit * ($page - 1);

        $sqlFilters = array();
        $getParams = array();
        $params = array();

        $stmt = $GLOBALS['DB']->prepare('SELECT * FROM posts ORDER BY id DESC LIMIT :limit OFFSET :offset;');
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $res = $stmt->execute();

        $data = array();

        $data['posts'] = $stmt->fetchAll(PDO::FETCH_NAMED);

        $paginator = new Paginator('main', 'posts', $page, $limit, $sqlFilters, $getParams);
        $data['paginator'] = $paginator->get_paginator();

        return $data;
    }

}
