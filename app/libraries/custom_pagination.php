<?php
/* 
 * 关于 页码有效性的判断需要加在 控制器中判断，即当页码数<1或者>总页数
 *
 */
 
class custom_pagination
{
    var $page_url = ''; //分页目标URL
    var $page_size = 10; //每一页行数
    var $page_num = 1;//页码
    var $rows_num= '';//数据总行数
    var $links_num= 3;//选中链接前后的链接数，必须大于等于1

    var $anchor_class= '';//链接样式类
    var $current_class= 'info_page_num_current';//当前页样式类
    var $full_tag_open= '';//分页开始标签
    var $full_tag_close= '';//分页结束标签
    var $info_tag_open= '';
    var $info_tag_close= ' ';
    var $first_tag_open= '';
    var $first_tag_close= ' ';
    var $last_tag_open= ' ';
    var $last_tag_close= '';
    var $cur_tag_open= ' <strong>';
    var $cur_tag_close= '</strong>';
    var $next_tag_open= ' ';
    var $next_tag_close= ' ';
    var $prev_tag_open= ' ';
    var $prev_tag_close= '';
    var $num_tag_open= ' ';
    var $num_tag_close= '';

    public function __construct($params = array())
    {
        if (count($params) > 0)
        {
            $this->init($params);
        }
    }
 
    function init($params = array()) //初始化数据
    {
        if (count($params) > 0)
        {
            foreach ($params as $key => $val)
            {
                if (isset($this->$key))
                {
                    $this->$key = $val;
                }
            }
        }
    }
 
    function create_links()
    {
        ///////////////////////////////////////////////////////
        //准备数据
        ///////////////////////////////////////////////////////
        $page_url = $this->page_url;
        $rows_num = $this->rows_num;
        $page_size = $this->page_size;
        $links_num = $this->links_num;

        if ($rows_num == 0 OR $page_size == 0)
        {
            return '';
        }

        $pages = intval($rows_num/$page_size);
        if ($rows_num % $page_size)
        {
            //有余数pages+1
            $pages++;
        };
        $page_num = $this->page_num < 1 ? '1' : $this->page_num;

        $anchor_class = '';
        if($this->anchor_class !== '')
        {
            $anchor_class = 'class="'.$this->anchor_class.'" ';
        }

        $current_class = '';
        if($this->current_class !== '')
        {
            $current_class = 'class="'.$this->current_class.'" ';
        }
        if($pages == 1)
        {
            return '';
        }
        if($links_num < 0)
        {
            return '- -！links_num必须大于等于0';
        }
        ////////////////////////////////////////////////////////
        //创建链接开始
        ////////////////////////////////////////////////////////
        $output = $this->full_tag_open;
        $output .= $this->info_tag_open.'共'.$rows_num.'条数据  第 '.$page_num.'/'.$pages.' 页'.$this->info_tag_close;
        //首页
        if($page_num > 1)
        {
            $output .= $this->first_tag_open.'<a '.$anchor_class.' href="'.site_url($page_url.'/1').'" >首页</a>'.$this->first_tag_close;
        }
        //上一页
        if($page_num > 1)
        {
            $n = $page_num - 1;
            $output .= $this->prev_tag_open.'<a '.$anchor_class.' href="'.site_url($page_url.'/'.$n).'" >上一页</a>'.$this->prev_tag_close;
        }
        //pages
        for($i=1;$i<=$pages;$i++)
        {
            $pl = $page_num - $links_num < 0 ? 0 : $page_num - $links_num;
            $pr = $page_num + $links_num > $pages ? $pages : $page_num + $links_num;
            //判断链接个数是否太少，举例，假设links_num = 2，则链接个数不可少于 5 个，主要是 当page_num 等于 1， 2 和 n，n-1的时候
            if($pr < 2 * $links_num + 1)
            {
                $pr = 2 * $links_num + 1;
            }
            if($pl > $pages-2 * $links_num)
            {
                $pl = $pages - 2 * $links_num;
            }
            if($i == $page_num)
            {   //current page
                $output .= $this->cur_tag_open.'<a '.$current_class.' >'.$i.'</a>'.$this->cur_tag_close;
            }else if($i >= $pl && $i <= $pr)
            {
                $output .= $this->num_tag_open.'<a '.$anchor_class.' href="'.site_url($page_url.'/'.$i).'" >'.$i.'</a>'.$this->num_tag_close;
            }
        }
        //下一页
        if($page_num < $pages)
        {
            $n = $page_num + 1;
            $output .= $this->next_tag_open.'<a '.$anchor_class.' href="'.site_url($page_url.'/'.$n).'" >下一页</a>'.$this->next_tag_close;
        }
        //末页
        if($page_num < $pages)
        {
            $output .= $this->last_tag_open.'<a '.$anchor_class.' href="'.site_url($page_url.'/'.$pages).'" >末页</a>'.$this->last_tag_close;
        }

        $output.=$this->full_tag_close;
        return $output;
    }
}