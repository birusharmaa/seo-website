<?php

use App\Models\SliderModel;
use App\Models\SliderSectionModel;

/**
 * Get all services 
 */
if (!function_exists('getPageSlider')) {
    function getPageSlider($menu_id = 0, $sub_menu = 0)
    {
       
        $slider_model  = new SliderSectionModel();
        $slider_model->select(['id', 'page_id', 'slider', 'section_name']);
        $slider_details = $slider_model->findAll();
        $final_slider = [];
       
        if (!empty($slider_details)) {
            foreach ($slider_details as $slider_detail) {
                $slider_page = json_decode($slider_detail['page_id']);
                foreach ($slider_page as $sp) {
                    $temp = [];
                    if ($sp->menu == $menu_id && $sp->sub_menu == $sub_menu) {
                        $temp['title'] = $slider_detail['section_name'];
                        $temp['section_id'] = $slider_detail['id'];
                        $temp['menu_id'] = $menu_id;
                        $temp['submenu_id'] = $sub_menu;
                        $temp['section_title'] = 'Slider Section';
                        $final_slider[] = $temp;
                    }
                }
            }
        }
        return $final_slider;
    }
}
