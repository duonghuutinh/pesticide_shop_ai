<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('init_pagination')) {
    function init_pagination($base_url, $total_rows, $per_page = 10, $uri_segment = 3)
    {
        $CI = &get_instance(); // để dùng pagination

        $config['base_url']           = $base_url;
        $config['total_rows']         = $total_rows;
        $config['per_page']           = $per_page;
        $config['uri_segment']        = $uri_segment;
        $config['use_page_numbers']   = TRUE;
        $config['reuse_query_string'] = TRUE;

        // Bootstrap pagination UI
        $config['full_tag_open']   = '<ul class="pagination">';
        $config['full_tag_close']  = '</ul>';
        $config['first_tag_open']  = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open']   = '<li>';
        $config['last_tag_close']  = '</li>';
        $config['next_tag_open']   = '<li>';
        $config['next_tag_close']  = '</li>';
        $config['prev_tag_open']   = '<li>';
        $config['prev_tag_close']  = '</li>';
        $config['cur_tag_open']    = '<li class="active"><a>';
        $config['cur_tag_close']   = '</a></li>';
        $config['num_tag_open']    = '<li>';
        $config['num_tag_close']   = '</li>';
        
        $CI->pagination->initialize($config);

        return $CI->pagination->create_links();
    }
}
