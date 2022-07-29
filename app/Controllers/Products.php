<?php

namespace App\Controllers;
use App\Models\ProductsModel;
use App\Libraries\User_details;
use App\Models\CartHistoryModel;
use App\Models\SeoProductImages;
use App\Libraries\Meta_keywords;

class Products extends UiController { 
    public function __construct(){
        parent::__construct();
        $this->user_slider = new User_details();
        $this->cart_history = new CartHistoryModel();
        $this->product_images = new SeoProductImages();
        $meta_lib = new Meta_keywords();
        $this->meta_lib_data = $meta_lib->getMetaKeywords($this->user['id']);
    } 
    
    
    public function product_details(){
        $slug = $this->request->uri->getSegment(2);
        $slider = $this->user_slider->getSlider('Products -');
        /**
         * Make gallery images array
         */
        $images = $this->user_slider->galleryImages('Products -');
        
         /**
         * Make video gallery array
         */
        $video =  $this->user_slider->getVideoLists('Products -');

        /**
         * Make custom section array data
         */
        $custom =  $this->user_slider->getCustomSectionData('Products');

        /**
         * Make testimonial data section array data
         */
        $testimonial =  $this->user_slider->getTestimonialData('Products -');

        /**
         * Make faq list section array data
        */
        $fq_lists =  $this->user_slider->getFaqLists('Products -');

        /** 
         * Make faq list section array data
        */
        $services =  $this->user_slider->getServiesLists('Products -');

        /**
         * Make products list section array data
        */
        $products =  $this->user_slider->getProductsLists('Products -');


        /**
         * Make products list section array data
        */
        $post_updates =  $this->user_slider->getUpdateLists('Products -'); 
        
        if(!empty($slug)){
            $this->product = new ProductsModel();
            $product = $this->product->where('menu_link', $slug)->first();
            $product_images = $this->product_images->where('product_id', $product['id'])->orderBY('id', 'desc')->findAll();
            $all_products = $this->product->findAll();
            $pageData = [
                'title' => 'Product | '.$slug,
                'description' => 'This is the Product Detail page',
                'keywords' => 'Healthcare',
                'slugs' => empty($slug)?"Products Section":$slug,
                'user_details'  => $this->user,
                'menu_lists'    => $this->final_menu,

                'product'       => $product,
                'all_products'  => $all_products,

                'cart'          => cart_history(),
                'colors'        => $this->colors,
                'meta_keywords' => $this->meta_lib_data,

                'product_images'=> $product_images,
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
            return view($this->user['theme_name'].'/'.'frontend/product_detail', $pageData);
        }
        $this->product = new ProductsModel();
        $all_products = $this->product->findAll();
        $pageData = [
            'title' => 'Product details',
            'description' => 'This is the Product Detail page',
            'keywords' => 'Healthcare',
            'slugs' => empty($slug)?"Products Section":$slug,
            'user_details'  => $this->user,
            'menu_lists'    => $this->final_menu,
            'all_products'  => $all_products,
            'cart'          => cart_history(),
            'colors'        => $this->colors,
            'meta_keywords' => $this->meta_lib_data,
            
            'services'      => $services,
            'products'      => $products,
            'posts'         => $post_updates,
            'videoes'       => $video,
            'gallery_images'=> $images,
            'custom_section'=> $custom,
            'testimonials'  => $testimonial,
            'fq_lists'      => $fq_lists,

        ];
        return view($this->user['theme_name'].'/'.'frontend/product_details', $pageData);
    }

    public function search(){
        return redirect()->to(base_url());
    }
}


