<?php

namespace App\Libraries;

// $url = $_SERVER['HTTP_REFERER'];
// $data_url  = explode("/", $url);


class Paginator
{
    public $itemsPerPage;
    public $range;
    public $currentPage;
    public $total;
    public $textNav;
    private $_navigation;
    private $_link;
    private $_pageNumHtml;
    private $_itemHtml;

    public $is_ajax = false;

    public function __construct($page = 1)
    {  
        $this->itemsPerPage = 15;
        $this->range = 15;
        $this->currentPage = $page;
        $this->total = 0;
        $this->textNav = true;

        $this->_navigation  = array(
            'next'=>' &raquo;',
            'prev' =>'&laquo;',
            'first' =>'&laquo;',
            'last' =>' &raquo;',
            'ipp' =>'Item per page'
        );
    $this->_navigation = array(
    'next'=>' &raquo;',
    'prev' =>'&laquo;',
    'first' =>" <i class='fa fa-angle-double-left'></i>",
    'last' =>"<i class='fa fa-angle-double-right'></i>",
    'ipp' =>'Item per page'
    );

        $this->_link = filter_var($_SERVER['PHP_SELF'], FILTER_SANITIZE_STRING);
        $this->_pageNumHtml = '';
        $this->_itemHtml = '';
    }

    public function paginate()
    {
        if(isset($_POST['current']))
        {
            $this->currentPage = $_POST['current'];
        }

        if(isset($_GET['item'])){
            $this->itemsPerPage = $_GET['item'];
        }

        $this->_pageNumHtml = $this->_getPageNumbers();
        return $this->_pageNumHtml;
    }


    public function pageNumbers()
    {
        if(empty($this->_pageNumHtml))
        {
            exit('Please call function paginate() first.');
        }
        return $this->_pageNumHtml;
    }


    public function itemsPerPage()
    {
        if(empty($this->_itemHtml))
        {
            exit('Please call function paginate() first.');
        }
        return $this->_itemHtml;
    }


    private function _getPageNumbers()
    {
        $html = '<div class="pagination-wrapper col-lg-12 col-sm-12 col-xs-12 p-0">';
        $html .= '<ul class="pagination d-flex justify-content-center p-0 m-0">';

        $query_string = $_GET;
        $str = array();

        if(count($query_string) > 0)
        {
            foreach ($query_string as $key => $value)
            {
                if($key != 'pages'){
                    $str[] = "$key=$value";
                }
            }
        }

        if($this->currentPage > 1)
        {

            $first = $str;
            $first[] = "pages=1";

            if($this->is_ajax == false)
            {
                $string = $this->_link."?".implode("&", $first);
            } else {
                $string = 'javascript:void(0)';
            }


        }

        if(($this->currentPage>1))
        {
            $page_step = $this->currentPage-1;
            $prev = $str;
            $prev[] = "pages=".($this->currentPage-1);

            if($this->is_ajax == false)
            {
                $string = $this->_link."?".implode("&", $prev);
            } else {
                $string = 'javascript:void(0)';

            }
            $html .= '<li class="">';
            $html .= '<a class="prev_button ajax_page_copy ajax_page" href="'.$string.'" data-pages="'.$page_step.'" >'.$this->_navigation['first'].'</a></li>';
        }

        $last = ceil($this->total/$this->itemsPerPage);

        if($this->total > $this->range)
        {
            if($this->currentPage <= $this->range)
            {
                $start = 1;
            } else {
                $start = $this->currentPage - $this->range;
            }

            if($this->currentPage+$this->range > $last)
            {
                $end = $last;
            } else if ($this->currentPage+$this->range <= $last) {
                $end = $this->currentPage+$this->range;
            }
        } else {
            if($this->total > $this->itemsPerPage)
            {
                $start = 1;
                $end = $this->total;
            } else {
                $start = 1;
                $end = 1;
            }
        }


        for($i = $start; $i <= $end; $i++)
        {
            $p = $str;
            $p[] = "pages=".$i;

            if($this->is_ajax == false)
            {
                $string = $this->_link."?".implode("&", $p);
            } else {
                $string = 'javascript:void(0)';
            }



            if($i==$this->currentPage) {
                $html .= '<li class="active">';
                $html .= '<a href="'.$string.'" data-pages="'.$i.'"';
                $html .= ' class="current_page page-link current"';
            }else{
                $html .= '<li class="">';
                $html .= '<a href="'.$string.'" data-pages="'.$i.'"';
                $html .= ' class="ajax_page ajax_page_'.$i.'"';
            }
            $html .= '>'.$i.'</a>';
            $html .= '</li>';
        }

        if(($this->currentPage < ($this->total/$this->itemsPerPage)))
        {
            $p = $this->currentPage+1;
            $next = $str;
            $next[] = "pages=".($this->currentPage+1);

            if($this->is_ajax == false)
            {
                $string = $this->_link."?".implode("&", $next);
            } else {
                $string = 'javascript:void(0)';
            }
        }

        if($this->currentPage < $last)
        {
            $end = $str;
            $end[] = "pages=".$last;

            if($this->is_ajax == false)
            {
                $string = $this->_link."?".implode("&", $end);
            } else {
                $string = 'javascript:void(0)';
            }

            $html .= '<li class="">';
            $html .= '<a class="next_button ajax_page" href="'.$string.'" data-pages="'.$p.'">'.$this->_navigation['last'].'</a></li>';
        }
        // next ajax_page
        $html .= '</ul>';
        $html .= '</div>';

        return $html;
    }
}

?>