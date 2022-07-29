<?php

namespace App\Controllers;
use App\Models\Users_model;
use App\Models\ServicesModel;
use App\Libraries\User_details;
use App\Libraries\Meta_keywords;
use App\Models\ArrangeCustomSection;
use App\Models\SliderModel;
use App\Models\SliderSectionModel;



class Services extends UiController { 
   
    protected $custom_arrange;
    protected $slider_images;
    protected $slider_section;
    public function __construct(){
        parent::__construct();

        $this->custom_arrange = new ArrangeCustomSection();
        $this->user_slider = new User_details();
        $meta_lib = new Meta_keywords();
        $this->meta_lib_data = $meta_lib->getMetaKeywords($this->user['id']);

        $this->slider_images  = new SliderModel();
        $this->slider_section = new SliderSectionModel();
    } 

    public function services_details(){
        $slider = $this->user_slider->getSlider('Service -');
    
        /**
         * Make gallery images array
         */
        $images = $this->user_slider->galleryImages('Service -');
        
         /**
         * Make video gallery array
         */
        $video =  $this->user_slider->getVideoLists('Service -');
        
        /**
         * Make custom section array data
         */
        $custom =  $this->user_slider->getCustomSectionData('Services');

        /**
         * Make testimonial data section array data
         */
        $testimonial =  $this->user_slider->getTestimonialData('Service -');

        /**
         * Make faq list section array data
        */
        $fq_lists =  $this->user_slider->getFaqLists('Service -');

        /** 
         * Make faq list section array data
        */
        $services =  $this->user_slider->getServiesLists('Service -');
        /**
         * Make products list section array data
        */
        $products =  $this->user_slider->getProductsLists('Service -');


        /**
         * Make products list section array data
        */
        $post_updates =  $this->user_slider->getUpdateLists('Service -');     

        $slugs = ""; 
        $menu_sub_menu_id = "";
        if ($this->request->uri->getTotalSegments() >= 2 && $this->request->uri->getSegment(2)){
            $slugs = $this->request->uri->getSegment(2);
            $menu_sub_menu_id = $this->request->uri->getSegment(3);
        }
        $res = [];
        $page_slider = "";
        $final_slider = [];

        if(!empty($menu_sub_menu_id)){
            
            $menu_sub_menu_id = base64_decode($menu_sub_menu_id);
            $arr = explode("/", $menu_sub_menu_id);
            $menu_id  = $arr[0];
            $sub_menu = $arr[1];
            $custom_slider = $this->custom_arrange->select('section_id')->where(['section_title' => 'Slider Section', 'menu_id' =>$menu_id, 'submenu_id' =>$sub_menu ])->orderBy('soroting_order')->findAll();

            $final_slider = [];
            foreach($custom_slider as $cs){
                $slider = $this->slider_section->select('slider')->where('id', $cs['section_id'])->first();
                $slider = $slider['slider'];
                $slider = json_decode($slider);
                $slider_image_list = [];
                foreach($slider as $s){
                    $this->slider_images->select(['title_font_family', 'desc_font_family', 'slider_image', 'title', 'description', 'text_color', 'heading_color']);
                    $image = $this->slider_images->find($s);
                    $img   = $image['slider_image'];
                    $title = $image['title'];
                    $desc  = $image['description'];
                    $text  = $image['text_color'];
                    $head  = $image['heading_color']; 
                    $title_style  = $image['title_font_family']; 
                    $desc_style   = $image['desc_font_family'];            
                    $arr = ['title_style' => $title_style, 'desc_style' => $desc_style, "image"=>$img, "title"=>$title, "desc"=>$desc, "text_color"=>$text, 'heading_color'=>$head] ;
                    $slider_image_list[] = $arr;
                }
                $final_slider[] = $slider_image_list;
            }
        }
        
        if(!empty($slugs)){
            $this->services = new ServicesModel();
            $service = $this->services->where('slug', $slugs)->first();
            //$this->services->select(['slug', 'service', 'menu_link']);
            $all_services = $this->services->findAll();
            $pageData = [
                'title' => 'Services | '.$slugs,
                'description' => 'This is the Services Detail page',
                'keywords' => 'Healthcare',
                'slug' => $slugs,
                'user_details'  => $this->user,
                'menu_lists'    => $this->final_menu,
                'service'       => $service,
                'all_services'  => $all_services,

                'cart'          => cart_history(),
                'colors'        => $this->colors,
                'meta_keywords' => $this->meta_lib_data,

                'sliders'       => $final_slider,
                'services'      => $services,
                'products'      => $products,
                'posts'         => $post_updates,
                'videoes'       => $video,
                'gallery_images'=> $images,
                'custom_section'=> $custom,
                'testimonials'  => $testimonial,
                'fq_lists'      => $fq_lists,
            ];
            return view($this->user['theme_name'].'/'.'frontend/service_detail', $pageData);
        }
        $this->services = new ServicesModel();
        $all_services = $this->services->findAll();

        $pageData = [
            'title' => 'Services details',
            'description' => 'This is the Services Detail page',
            'keywords' => 'Healthcare',
            'slug' => empty($slugs)?"Services Section":$slugs,
            'user_details'  => $this->user,
            'menu_lists'    => $this->final_menu,
            'all_services'  => $all_services,
            'cart'          => cart_history(),
            'colors'        => $this->colors,
            'meta_keywords' => $this->meta_lib_data,
            
            'sliders'       => $slider,
            'products'      => $products,
            'services'      => $services,
            'posts'         => $post_updates,
            'videoes'       => $video,
            'gallery_images'=> $images,
            'custom_section'=> $custom,
            'testimonials'  => $testimonial,
            'fq_lists'      => $fq_lists,
        ];
        return view($this->user['theme_name'].'/'.'frontend/services_details', $pageData);
    }

    public function search(){
        return redirect()->to(base_url());
    }

    /**
     * Services filter function
     *
     * @return void
     */
    public function serviceSearch(){
        $slugs = "";
        if ($this->request->uri->getTotalSegments() >= 2 && $this->request->uri->getSegment(2)){
            $slugs = $this->request->uri->getSegment(2);
        }

        $this->services = new ServicesModel();
        $val = $this->request->getPost("form1");
        $service = $this->services->like('service', $val)->first();

        // $this->services->select(['slug', 'service', 'menu_link']);
        // $all_services = $this->services->findAll();
        if(!empty($service)){
            return redirect()->to(base_url().'/'.'services/'.$service['slug']);
        }
        return redirect()->to(base_url());
    }
}


