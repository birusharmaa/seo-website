<?php

use App\Models\SliderModel;
use App\Models\SliderSectionModel;

/**
 * Get all services 
 */
if (!function_exists('getPageSlider')) {
    function getPageSlider($menu_id = 0, $sub_menu = 0)
    {
       

        $slider_images = new SliderModel();
        $slider_model  = new SliderSectionModel();

        $slider_model->select(['id', 'page_id', 'slider']);
        $slider_details = $slider_model->findAll();

        $final_slider = [];

        if (!empty($slider_details)) {

            foreach ($slider_details as $slider_detail) {
                $slider_image_list = [];
                $slider_page = json_decode($slider_detail['page_id']);
                foreach ($slider_page as $sp) {
                    if ($sp->menu == $menu_id && $sp->sub_menu == $sub_menu) {
                        $slider = json_decode($slider_detail['slider']);
                        foreach ($slider as $v) {
                            $slider_images->select(['title_font_family', 'desc_font_family', 'slider_image', 'title', 'description', 'text_color', 'heading_color']);
                            $image = $slider_images->find($v);
                            $img   = $image['slider_image'];
                            $title = $image['title'];
                            $desc  = $image['description'];
                            $text  = $image['text_color'];
                            $head  = $image['heading_color'];
                            $title_style  = $image['title_font_family'];
                            $desc_style   = $image['desc_font_family'];
                            $arr = ['title_style' => $title_style, 'desc_style' => $desc_style, "image" => $img, "title" => $title, "desc" => $desc, "text_color" => $text, 'heading_color' => $head];
                            $slider_image_list[] = $arr;
                        }
                        $final_slider[] = $slider_image_list;
                    }
                }
            }
        }
        //bb_print_r($final_slider);
        return $final_slider;
    }
}
