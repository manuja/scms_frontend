<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class CI_Breadcrumb {

    private $breadcrumbs = array();
    private $tags = array();

    function __construct()
    {
        $this->tags['open'] = "<ul class='angled-breadcrumbs'>";
        $this->tags['close'] = "</ul>";
        $this->tags['itemOpen'] = "<li>";
        $this->tags['itemClose'] = "</li>";
    }

    function add($title, $href)
    {
        if (!$title OR ! $href)
            return;
        $this->breadcrumbs[] = array('title' => $title, 'href' => $href);
    }

    function openTag($tags = "")
    {
        if (empty($tags)) {
            return $this->tags['open'];
        } else {
            $this->tags['open'] = $tags;
        }
    }

    function closeTag($tags = "")
    {
        if (empty($tags)) {
            return $this->tags['close'];
        } else {
            $this->tags['close'] = $tags;
        }
    }

    function itemOpenTag($tags = "")
    {
        if (empty($tags)) {
            return $this->tags['itemOpen'];
        } else {
            $this->tags['itemOpen'] = $tags;
        }
    }

    function itemCloseTage($tags = "")
    {
        if (empty($tags)) {
            return $this->tags['itemClose'];
        } else {
            $this->tags['itemClose'] = $tags;
        }
    }

    function render()
    {

        if (!empty($this->tags['open'])) {
            $output = $this->tags['open'];
        } else {
            $output = '<ul class="angled-breadcrumbs">';
        }

        $count = count($this->breadcrumbs) - 1;
        foreach ($this->breadcrumbs as $index => $breadcrumb)
        {
//		echo $index.'__________'.$count;
//                exit;
            if ($index == $count) {

                if ($breadcrumb['title'] == 'Home') {
                    $output .= '<li>';
                    $output .= '<a href="">';
                    $output .= '<i class="fa fa-home"></i> ';
                    $output .= $breadcrumb['title'];
                    $output .= '</a>';
                    $output .= '</li>';
                } else {
                    $output .= '<li>';


                    if ($breadcrumb['href'] != site_url()) {
                        $output .= '<a href="' . $breadcrumb['href'] . '">';
                    } else {
                        $output .= '<a href="">';
                    }
                    $output .= $breadcrumb['title'];
                    $output .= '</a>';
                    $output .= '</li>';
                }
            } else {
                $output .= '<li>';
                $output .= '<a href="' . $breadcrumb['href'] . '">';

                if ($breadcrumb['title'] == 'Home') {
                    $output .= '<i class="fa fa-home"></i>';
                }

                $output .= $breadcrumb['title'];
                $output .= '</a>';
                $output .= '</li>';
            }
        }

        if (!empty($this->tags['open'])) {
            $output .= $this->tags['close'];
        } else {
            $output .= "</ul>";
        }


        return $output;
    }

}
