<?php

namespace App\Libraries;

use App\Models\Users_model;
use App\Models\Appearance_model;

use App\Models\MenuModel;
use App\Models\CustomSubMenu;


use App\Models\SliderModel;
use App\Models\SliderSectionModel;

use App\Models\CustomSectionModel;

use App\Models\ServicesModel;
use App\Models\ServiceSectionModel;

use App\Models\ProductsModel;
use App\Models\ProductsSectionModel;

use App\Models\PostsModel;
use App\Models\PostSectionModel;

use App\Models\GallerySection;
use App\Models\ImagesGallary;

use App\Models\VideoModel;
use App\Models\VideoGallerySection;

use App\Models\Testimonial;
use App\Models\TestimonialSection;

use App\Models\FaqModel;
use App\Models\FaqSectionModel;

use App\Models\ArrangeSection;



class User_details{

    /**
     * Making menu list
     *
     * @return void
     */
    public function menuLists(){
        
        //Get all menu list  
        $this->menu = new MenuModel();
        $this->menu->select(['id', 'menu_name','menu_link']);
        $this->menu->where(['sub_menu' => '0', 'footer_menu' => '0']);
        $this->menu->orderBy('sorting_order', 'asc');
        $menus =  $this->menu->findAll();

        //Make final menu array for view page
        $final_menu = [];
        foreach($menus as $menu){
            $sub = [];

            if($menu['menu_name']=="Services"){
                $this->services = new ServicesModel();
                $this->services->select(['id', 'menu_link', 'service']);
                $services = $this->services->where('menu_id',$menu['id'])->findAll();
                if(!empty($services)){
                    foreach($services as $service){
                        $sub[] = ['menu_name'=>$service['service'], "menu_link"=> 'services/'.$service['menu_link'],
                        "sub_menu"=> $service['id']
                        ];
                    }
                }
                
                //Check custom menu exit or not
                $this->custom = new CustomSubMenu();
                $custom_submenus = $this->custom->select(['id','sub_menu','sub_menu_link'])
                                ->where('menu_id',$menu['id'])
                        ->orderBy('id','desc')
                        ->findAll();
                
                if(!empty($custom_submenus)){
                    foreach($custom_submenus as $custom_submenu){
                        $sub[] = ['menu_name'=> $custom_submenu['sub_menu'], "menu_link"=> 'custom/'.$custom_submenu['sub_menu_link'],
                        "sub_menu"=> $custom_submenu['id']
                        ];
                    }
                }
                $menu['sub_menu'] = $sub;
                $final_menu[] = $menu;

            }else if($menu['menu_name']=="Products"){
                $this->product = new ProductsModel();
                $this->product->select(['id','product_name','menu_link']);
                $product = $this->product->where('menu_id',$menu['id'])->findAll();
                if(!empty($product)){
                    foreach($product as $prod){
                        $sub[] = ['menu_name'=>$prod['product_name'], "menu_link"=> 'products/'.$prod['menu_link'],
                        "sub_menu"=> $prod['id']        
                        ];
                    }
                }

                //Check custom menu exit or not
                $this->custom = new CustomSubMenu();
                $custom_submenus = $this->custom->select(['id', 'sub_menu','sub_menu_link'])
                                ->where('menu_id',$menu['id'])
                        ->orderBy('id','desc')
                        ->findAll();
                
                if(!empty($custom_submenus)){
                    foreach($custom_submenus as $custom_submenu){
                        $sub[] = ['menu_name'=> $custom_submenu['sub_menu'], "menu_link"=> 'custom/'.$custom_submenu['sub_menu_link'],  
                        "sub_menu"=> $custom_submenu['id']    
                        ];
                    }
                }

                $menu['sub_menu'] = $sub;
                $final_menu[] = $menu;
            }else if($menu['menu_name']=="Updates"){
                $user = $this->getUserDetails();
                $this->post = new PostsModel();
                $this->post->select(['id','title','slug']);
                $posts = $this->post
                        ->where(['created_by' => $user['id'], 'status' => 'published'])
                        ->orderBy('id','desc')
                        ->findAll(5);
                
                if(!empty($posts)){
                    foreach($posts as $post){
                        $sub[] = ['menu_name'=>$post['title'], "menu_link"=> 'updates/'.$post['slug'],
                        "sub_menu"=> $post['id']
                        ];
                    }
                }

                //Check custom menu exit or not
                $this->custom = new CustomSubMenu();
                $custom_submenus = $this->custom->select(['id','sub_menu','sub_menu_link'])
                                ->where('menu_id',$menu['id'])
                        ->orderBy('id','desc')
                        ->findAll();
                
                if(!empty($custom_submenus)){
                    foreach($custom_submenus as $custom_submenu){
                        $sub[] = ['menu_name'=> $custom_submenu['sub_menu'], "menu_link"=> 'custom/'.$custom_submenu['sub_menu_link'],
                        "sub_menu"=> $custom_submenu['id']
                        ];
                    }
                }
                $menu['sub_menu'] = $sub;
                $final_menu[] = $menu;
            }else{
                //Check custom menu exit or not
                $user = $this->getUserDetails();
                $this->custom = new CustomSubMenu();
                $custom_submenus = $this->custom->select(['id','sub_menu','sub_menu_link'])
                                ->where(['created_by' => $user['id'], 
                                'menu_id' => $menu['id']])
                        ->orderBy('id','desc')
                        ->findAll();
                
                if(!empty($custom_submenus)){
                    foreach($custom_submenus as $custom_submenu){
                        $sub[] = ['menu_name'=> $custom_submenu['sub_menu'], "menu_link"=> 'custom/'.$custom_submenu['sub_menu_link'],
                        "sub_menu"=> $custom_submenu['id']
                        ];
                    }
                }
                $menu['sub_menu'] = $sub;
                $final_menu[] = $menu;
            }   
        }

        //bb_print_r($final_menu);
        //$menu = $this->getPagesSlider($final_menu);
        return $final_menu;

    }


    /**
     * Get user all infomation
     *
     * @return void
     */
    public function getUserDetails(){
        $this->user = new Users_model();
        $user  = $this->user->getUserDetails();
        return $user;
    } 

    /**
     * Get page slider
     *
     * @param [type] $data
     * @return void
     */
    public function getPagesSlider($data){
        $this->slider_model  = new SliderSectionModel();
        $this->slider_images = new SliderModel();
        
        $this->slider_model->select(['page_id', 'slider']);
        $slider_details = $this->slider_model->findAll();
        $slider_page = json_decode($slider_details[0]['page_id']);
        // echo "<pre>";
        // print_r($slider_page);
        $slider =json_decode($slider_details[0]['slider']);        
        $slider_image_list = [];
        foreach($slider as $v){
            $this->slider_images->select(['slider_image', 'title', 'description', 'text_color', 'heading_color']);
            $image = $this->slider_images->find($v);
            
            $img   = $image['slider_image'];
            $title = $image['title'];
            $desc  = $image['description'];
            $text  = $image['text_color'];
            $head  = $image['heading_color'];            
            $arr = [ "image"=>$img, "title"=>$title, "desc"=>$desc, "text_color"=>$text, 'heading_color'=>$head] ;
            $slider_image_list[] = $arr;
        }
        
        $slider_page = json_decode(json_encode($slider_page), true);
        $final_slider = [];
        foreach($slider_page as $sp){
           $sp['slider_image'] = $slider_image_list;
           $final_slider[] = $sp;
        }
        
        $final_menu_slider = [];
        foreach($data as $key=>$d){
            $final_s_img = $this->setSliderInMenu($slider_page, $d['id'], $final_slider);
            $d['slider_images'] = (is_array($final_s_img) && !empty($final_s_img))?$final_s_img:[];
            $final_menu_slider[] = $d;
        }
    
        return $final_menu_slider;
    }

    /**
     * Make submenu list
     *
     * @param array $slider_page
     * @param integer $menu_id
     * @param array $slider_images
     * @return void
     */
    private function setSliderInMenu($slider_page = [], $menu_id = 0, $slider_images = []){
        foreach($slider_page as $k=>$sp){
            if($sp['menu']===$menu_id){
                return $slider_images[$k]['slider_image'];
            }
        }
    }
    
    /**
     * Fetch data from custom section 
     *
     * @return void
     */
    public function getCustomSectionData($data = null){
        $this->custom_section = new CustomSectionModel();
        $custom = $this->custom_section->select(['id','upload_image', 'position', 'heading', 'description'])->where('page_id', $data)->findAll();
        return $custom;
    }

    /**
     * Get services data and all details
     *
     * @return void
     */
    public function getServicesData(){
        $this->services = new ServicesModel();
        $services = $this->services->where('status', '1')->findAll();  
        return $services;
    }

    /**
     * Get all product list and return 
     *
     * @return void
     */
    public function getAllProductsList(){
        $this->product = new ProductsModel();
        $all_products = $this->product->findAll();
        return $all_products;
    }
    
    /**
     * Get Video lists
     *
     * @return void
     */
    public function getVideoLists($data = null){
        $this->video_link    = new VideoModel();
        $this->video_section = new VideoGallerySection();
        $video_section = $this->video_section->select(['videos', 'pages'])->findAll();
        if(empty($video_section))
        {
            return [];
        }
        $videos = json_decode($video_section[0]['videos']);
        $video_section_pages = json_decode($video_section[0]['pages']);        
        
        $video_lists = [];
        foreach($videos as $v){
            $this->video_link ->select(['url', 'title', 'thumbnail_images']);
            $video = $this->video_link->find($v);
            $url   = $video['url'];
            $title = $video['title'];
            $arr = [ "url"=>$url, "title"=>$title, 'thumbnail_images' => $video['thumbnail_images']];
            $video_lists[] = $arr;
        }
        $final_video_lists = [];
        foreach($video_section_pages as $v){
            if($v->sub_menu_title == $data){
                $final_video_lists = $video_lists;
            }
        }
        return $final_video_lists;
    }

    public function getAllPostLists(){
        $this->posts = new PostsModel();
        $all_posts = $this->posts->findAll();
        return $all_posts;
    }

    /**
     * get Page sider for single page;
     *
     * @param [type] $data
     * @return void
     */
    public function getSlider($data = null){
        $this->slider_model  = new SliderSectionModel();
        $this->slider_images = new SliderModel();
        
        $this->slider_model->select(['id','page_id', 'slider']);
        $slider_details = $this->slider_model->findAll();
        $final_slider = [];
        if(!empty($slider_details)){
            foreach($slider_details as $slider_detail){
                
                $slider_page = json_decode($slider_detail['page_id']); 
                $slider = json_decode($slider_detail['slider']);
               
                $slider_image_list = [];
                foreach($slider as $v){
                    $this->slider_images->select(['title_font_family', 'desc_font_family', 'slider_image', 'title', 'description', 'text_color', 'heading_color']);
                    $image = $this->slider_images->find($v);
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
                
                $slider_page = json_decode(json_encode($slider_page), true);
                
                foreach($slider_page as $sp){
                    if($sp['sub_menu_title'] == $data){
                        //$sp['slider_image'] = $slider_image_list;
                        $slider_image_list['section_id'] = $slider_detail['id'];
                        $final_slider[] = $slider_image_list;
                    }
                }
                
                //return $final_slider;
            }
        }
        //bb_print_r($final_slider);
        return $final_slider;
    }

    /**
     * Find all color 
     *
     * @return void
     */
    public function getColors(){
        $appearance =new Appearance_model();
        return $appearance->findAllData();
    }

    /**
     * Make gallery images add data
     *
     * @param [type] $data
     * @return void
     */
    public function galleryImages($data){
        $this->gallery_section  = new GallerySection();
        $this->gallery_images   = new ImagesGallary();
        
        $this->gallery_section->select(['pages', 'images']);
        $gallery_section_details = $this->gallery_section->findAll();
        if(empty($gallery_section_details))
        {
            return [];
        }
       
        $gallery_section_pages = json_decode($gallery_section_details[0]['pages']);        
        
        $images = json_decode($gallery_section_details[0]['images']);
        // $images = str_replace('"',"", $images);
        // $images = str_replace('[',"", $images);
        // $images = str_replace(']',"", $images);
        // $images = str_replace("" ,"", $images);
        // $images = explode(",", $images);
        // $images_list = [];
        foreach($images as $v){
            $this->gallery_images->select(['image', 'title']);
            $image = $this->gallery_images->find($v);
            $img   = $image['image'];
            $title = $image['title'];
            $arr = [ "image"=>$img, "title"=>$title ];
            $images_list[] = $arr;
        }
        $final_images_list = [];
        foreach($gallery_section_pages as $gi){
            if($gi->sub_menu_title == $data){
                $final_images_list = $images_list;
            }
        }
        return $final_images_list;
    }

    /**
     * Make Testimonial data
     *
     * @param [type] $data
     * @return void
     */
    public function getTestimonialData($data = null){
        $this->testimonial    = new Testimonial();
        $this->test_section = new TestimonialSection();
        $test_section = $this->test_section->select(['testimonials', 'pages_ids'])->findAll();
        if(empty($test_section))
        {
            return [];
        }
        $testimonial = json_decode($test_section[0]['testimonials']);
        $test_section_pages = json_decode($test_section[0]['pages_ids']);        
        $testimonial_lists = [];
        foreach($testimonial as $v){
            $this->testimonial->select('seo_testimonial.name, seo_testimonial.image, seo_testimonial.description, seo_testimonial.created_at,seo_users.user_name, seo_users.business_logo');
            $this->testimonial->join('seo_users', 'seo_users.id=seo_testimonial.created_by');
            $testimo = $this->testimonial->find($v);
            $arr = [ "name"=>$testimo['name'], 
                    "image"=>$testimo['image'], 
                    'description' => $testimo['description'],
                    'created_at' => $testimo['created_at'],
                    'user_name' => $testimo['user_name'],
                    'business_logo' => $testimo['business_logo']
                ];
            $testimonial_lists[] = $arr;
        }
        $final_testimonials = [];
        foreach($test_section_pages as $v){
            if($v->sub_menu_title == $data){
                $final_testimonials = $testimonial_lists;
            }
        }
        //bb_print_r($final_testimonials);
        return $final_testimonials;
    }

    /**
     * Faq list
     *
     * @param [type] $data
     * @return void
     */
    public function getFaqLists($data = null){
        $this->faq_model  = new FaqModel();
        $this->faq_section_model = new FaqSectionModel();
        
        $this->faq_section_model->select(['pages_id', 'faqs_ids']);
        $faq_section_details = $this->faq_section_model->findAll();
        $final_faqs = [];
        if(!empty($faq_section_details)){
            foreach($faq_section_details as $faq_section_detail){
                
                $faq_pages = json_decode($faq_section_detail['pages_id']); 
                $faqs      = json_decode($faq_section_detail['faqs_ids']);
               
                $faqs_list = [];
                foreach($faqs as $v){
                    $this->faq_model->select(['id','title', 'content', 'created_at', 'updated_at']);
                    $faq = $this->faq_model->find($v);
                    if(!empty($faq))
                    {       
                        $arr = ['id'=>$faq['id'], 'title' => $faq['title'], 'content' => $faq['content'], "created_at"=> $faq['created_at'], "updated_at"=>$faq['updated_at'] ] ;
                        $faqs_list[] = $arr;
                    }
                }
                
                $faq_pages = json_decode(json_encode($faq_pages), true);
                foreach($faq_pages as $sp){
                    if($sp['sub_menu_title'] == $data){
                        $final_faqs[] = $faqs_list;
                    }
                }
            }
        }
        //bb_print_r($final_faqs);
        return $final_faqs;
    }

    /**
     * Faq list
     *
     * @param [type] $data
     * @return void
     */
    public function getServiesLists($data = null){
        $this->services        = new ServicesModel();
        $this->service_section = new ServiceSectionModel();
        
        $this->service_section->select(['services', 'pages']);
        $service_details = $this->service_section->findAll();
        
        $final_services = [];
        if(!empty($service_details)){
            foreach($service_details as $service_detail){
                
                $service_pages = json_decode($service_detail['pages']); 
                $services    = json_decode($service_detail['services']);
               
                $service_list = [];
                foreach($services as $v){
                    $this->services->select(['service', 'menu_link', 'slug', 'image', 'banner', 'content', 'short_description']);
                    $faq = $this->services->find($v);        
                    $arr = [
                        'service'          => $faq['service'], 
                        'menu_link'        => $faq['menu_link'], 
                        "slug"             => $faq['slug'], 
                        "image"            =>$faq['image'],
                        'banner'           => $faq['banner'], 
                        "content"          => $faq['content'], 
                        "short_description"=>$faq['short_description'] 
                    ] ;
                    $service_list[] = $arr;
                }
                
                $service_pages = json_decode(json_encode($service_pages), true);
                foreach($service_pages as $sp){
                    if($sp['sub_menu_title'] == $data){
                        $final_services[] = $service_list;
                    }
                }
            }
        }
        return $final_services;
    }

     /**
     * Get all product list and return 
     *
     * @return void
     */
    public function getProductsLists($data = null){
        $this->product = new ProductsModel();
        $this->product_section = new ProductsSectionModel();
        
        $this->product_section->select(['products', 'pages']);
        $product_details = $this->product_section->findAll();
        
        $final_products = [];
        if(!empty($product_details)){

            foreach($product_details as $product_detail){
                
                $product_pages = json_decode($product_detail['pages']); 

                $products      = json_decode($product_detail['products']);
               
                $product_list = [];
                foreach($products as $v){
                    $this->product->select(['product_name', 'menu_link', 'total_inventry', 'mrp', 
                    'discount', 'extra_charge', 'main_image', 'related_product', 
                    'short_description', 'long_description', 'specification']);
                    $prod = $this->product->find($v);        
                    $arr = [
                        'product_name'     => $prod['product_name'], 
                        'id'               => $v,
                        'menu_link'        => $prod['menu_link'], 
                        "total_inventry"   => $prod['total_inventry'], 
                        "mrp"              => $prod['mrp'],
                        'discount'         => $prod['discount'], 
                        "extra_charge"     => $prod['extra_charge'], 
                        "main_image"       => $prod['main_image'],
                        "related_product"  => $prod['related_product'],
                        'short_description'=> $prod['short_description'], 
                        "long_description" => $prod['long_description'], 
                        "specification"    => $prod['specification'] 
                    ] ;
                    $product_list[] = $arr;
                }
                
                $product_pages = json_decode(json_encode($product_pages), true);
                foreach($product_pages as $sp){
                    if($sp['sub_menu_title'] == $data){
                        $final_products[] = $product_list;
                    }
                }
            }
        }
        return $final_products;
    }

     /**
     * Get all product list and return 
     *
     * @return void
     */
    public function getUpdateLists($data = null){
        $this->posts = new PostsModel();
        $this->posts_section = new PostSectionModel();
        
        $this->posts_section->select(['post_id', 'pages_id']);
        $posts_details = $this->posts_section->findAll();
        
        $final_posts = [];
        if(!empty($posts_details)){
            foreach($posts_details as $posts_detail){
                
                $post_pages = json_decode($posts_detail['pages_id']); 
                $posts      = json_decode($posts_detail['post_id']);
                $product_list = [];
                foreach($posts as $v){
                    $this->posts->select(['title', 'slug', 'image', 'description', 
                    'status', 'created_at']);
                    $update = $this->posts->find($v);
                    $arr = [
                        'title'      => $update['title'], 
                        'slug'       => $update['slug'], 
                        "image"      => $update['image'], 
                        "description"=> $update['description'],
                        'created_at' => $update['created_at']
                    ];
                    $product_list[] = $arr;
                }
                
                $post_pages = json_decode(json_encode($post_pages), true);
                foreach($post_pages as $sp){
                    if($sp['sub_menu_title'] == $data){
                        $final_posts[] = $product_list;
                    }
                }
            }
        }
        return $final_posts;
    }

    public function getSortOrder($data = null)
    {
        $this->arrange_section = new ArrangeSection();
        if($data == "Home"){
            $menu_id = 1;
            $custom = $this->arrange_section->select(['section_title','menu_id','section_id','soroting_order','url_val'])->where(['menu_id' => $menu_id,'status' => 1])->orderby('soroting_order')->findAll();
            return $custom;
        }

        if($data == "About Us"){
            $menu_id = 2;
            $custom = $this->arrange_section->select(['section_title','menu_id','section_id','soroting_order','url_val'])->where(['menu_id' => $menu_id,'status' => 1])->orderby('soroting_order')->findAll();
            return $custom;
        }
    }
}
