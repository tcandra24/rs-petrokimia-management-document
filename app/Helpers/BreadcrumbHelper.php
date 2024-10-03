<?php

namespace App\Helpers;

class BreadcrumbHelper
{
    protected $breadcrumbs = [];
    protected $titleMenu = '';

    public function __construct($titleMenu) {
        $this->titleMenu = $titleMenu;
    }

    public function add($title, $url = null)
    {
        $this->breadcrumbs[] = [
            'title' => $title,
            'url' => $url,
        ];

        return $this;
    }

    public function get()
    {
        return [
            'title' => $this->titleMenu,
            'list' => $this->breadcrumbs
        ];
    }
}
