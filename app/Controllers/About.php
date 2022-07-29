<?php

namespace App\Controllers;
use App\Libraries\User_details;
use App\Libraries\Meta_keywords;


class About extends UiController { 
    
    protected $meta_lib_data;

    public function __construct(){
        parent::__construct();
        $this->user_slider = new User_details();
        $meta_lib = new Meta_keywords();
        $this->meta_lib_data = $meta_lib->getMetaKeywords($this->user['id']);
    } 

    public function about(){
        $slider = $this->user_slider->getSlider('About Us');

        /**
         * Make gallery images array
         */
        $images = $this->user_slider->galleryImages('About Us');
        
         /**
         * Make video gallery array
         */
        $video =  $this->user_slider->getVideoLists('About Us');

        /**
         * Make custom section array data
         */
        $custom =  $this->user_slider->getCustomSectionData('About Us');

        /**
         * Make testimonial data section array data
         */
        $testimonial =  $this->user_slider->getTestimonialData('About Us');

        /**
         * Make faq list section array data
        */
        $fq_lists =  $this->user_slider->getFaqLists('About Us');

        /** 
         * Make faq list section array data
        */
        $services =  $this->user_slider->getServiesLists('About Us');

        /**
         * Make products list section array data
        */
        $products =  $this->user_slider->getProductsLists('About Us');


        /**
         * Make products list section array data
        */
        $post_updates =  $this->user_slider->getUpdateLists('About Us');  

        $sort_order =  $this->user_slider->getSortOrder('About Us');


        $pageData = [
            'title' => 'About Us',
            'description' => 'This is the about page',
            'keywords' => 'Healthcare',

            'user_details'  => $this->user,
            'menu_lists'    => $this->final_menu,
            'colors'        => $this->colors,
            'cart'          => cart_history(),
            'meta_keywords' => $this->meta_lib_data,
            
            'sliders'       => $slider,
            'services'      => $services,
            'products'      => $products,
            'posts'         => $post_updates,
            'videoes'       => $video,
            'gallery_images'=> $images,
            'custom_section'=> $custom,
            'testimonials'  => $testimonial,
            'fq_lists'      => $fq_lists,
            'sort_order'    => $sort_order,
        ];
        return view($this->user['theme_name'].'/'.'frontend/about', $pageData);
    }

    public function search(){
        
        return redirect()->to(base_url());
    }

    
}


