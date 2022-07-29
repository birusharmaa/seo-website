<?php

namespace App\Controllers;
use App\Libraries\User_details;
use App\Models\PostsModel;
use App\Libraries\Meta_keywords;

class Update extends UiController { 
    public function __construct(){
        parent::__construct();
        $this->user_slider = new User_details();
        $meta_lib = new Meta_keywords();
        $this->meta_lib_data = $meta_lib->getMetaKeywords($this->user['id']);
    } 
  
    public function update_details(){   
        $update = $this->request->uri->getSegment(2);
        $slider = $this->user_slider->getSlider('Updates');

        /**
         * Make gallery images array
         */
        $images = $this->user_slider->galleryImages('Updates');
        
         /**
         * Make video gallery array
         */
        $video =  $this->user_slider->getVideoLists('Updates');

        /**
         * Make custom section array data
         */
        $custom =  $this->user_slider->getCustomSectionData('Updates');
        
        /**
         * Make testimonial data section array data
         */
        $testimonial =  $this->user_slider->getTestimonialData('About Us');

                /**
         * Make faq list section array data
        */
        $fq_lists =  $this->user_slider->getFaqLists('Updates');

        /** 
         * Make faq list section array data
        */
        $services =  $this->user_slider->getServiesLists('Updates');

        /**
         * Make products list section array data
        */
        $products =  $this->user_slider->getProductsLists('Updates');


        /**
         * Make products list section array data
        */
        $post_updates =  $this->user_slider->getUpdateLists('Updates');


        if(!empty($update)){
            $this->post = new PostsModel();
            $post = $this->post->where('slug', $update)->first();
            $all_posts = $this->post->findAll();
            $pageData = [
                'title' => 'Updates | '.$update,
                'description' => 'This is the Product Detail page',
                'keywords' => 'Healthcare',

                'slugs' => empty($update)?"Products Section":$update,

                'user_details'  => $this->user,
                'menu_lists'    => $this->final_menu,
                'cart'          => cart_history(),
                'colors'        => $this->colors,
                'post'          => $post,
                'all_post'      => $all_posts,

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
                
            ];
            return view($this->user['theme_name'].'/'.'frontend/update_detail', $pageData);
        }

        $this->post = new PostsModel();
        $all_posts = $this->post->findAll();
        $pageData = [
            'title' => 'Update details',
            'description' => 'This is the Update Detail page',
            'keywords' => 'Healthcare',
            'update' => !empty($update)?$update:"Update section",
            'user_details'  => $this->user,
            'menu_lists'    => $this->final_menu,
            
            'cart'          => cart_history(),
            'colors'        => $this->colors,
            'all_post'      => $all_posts,
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
        ];

        return view($this->user['theme_name'].'/'.'frontend/update_details', $pageData);
    }

    public function search(){
        return redirect()->to(base_url());
    }
}


