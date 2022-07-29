<?php

namespace App\Controllers;
use App\Libraries\User_details;
use App\Libraries\Meta_keywords;
use App\Models\CustomSubMenu;
use App\Models\CustomPageData;

class Custom extends UiController { 
    protected $custom_page_data;
    protected $sub_menu_model;
    public function __construct(){
        parent::__construct();
        $this->user_slider = new User_details();
        $meta_lib = new Meta_keywords();
        $this->meta_lib_data = $meta_lib->getMetaKeywords($this->user['id']);
        $this->custom_page_data = new CustomPageData();
        $this->sub_menu_model = new CustomSubMenu();
    } 
  
    public function custom(){   
        
        $custom = $this->request->uri->getSegment(2);

        $custom_data = $this->custom_page_data->select(['heading', 'image', 'content'])->where('menu_link', $custom)->first();        
        
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
        $custom_section =  $this->user_slider->getCustomSectionData('Updates');
        
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


       
        $pageData = [
            'title' => $custom,
            'description' => 'This is the '.$custom.' page',
            'keywords' => 'Healthcare',
            'slug' => empty($custom)?"Page Section":$custom,

            'user_details'  => $this->user,
            'menu_lists'    => $this->final_menu,
            'cart'          => cart_history(),
            'colors'        => $this->colors,

            'meta_keywords' => $this->meta_lib_data,
            'custom_data'   => $custom_data,
            
            'sliders'       => $slider,
            'services'      => $services,
            'products'      => $products,
            'posts'         => $post_updates,
            'videoes'       => $video,
            'gallery_images'=> $images,
            'custom_section'=> $custom_section,
            'testimonials'  => $testimonial,
            'fq_lists'      => $fq_lists,
            
        ];
        return view($this->user['theme_name'].'/'.'frontend/custom_page', $pageData);
    }

    public function saveSubMenuData(){
        
        $sub_id = $this->request->getPost('sub_id');
        $page_id = $this->request->getPost('page_id');
        $heading = $this->request->getPost('heading');
        $image   = $this->request->getFile('image');
        $content = $this->request->getPost('content');

        $this->session = \Config\Services::session();
        
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }

        $page_data = $this->sub_menu_model->where('id', $sub_id)->first();
        $file_name = NULL;

        if(isset($page_data['sub_menu_link']) || !empty($page_id)){
            
            if(empty($page_id)){
                if(!empty($image) && $image->isValid()){
                    $file_name = $image->getRandomName();
                    $image->move('public/uploads/custom_pages_image/', $file_name);
                }
    
                $data = [
                    'custom_sub_menu_id' => $sub_id,
                    'menu_link'          => $page_data['sub_menu_link'],
                    'created_by'         => $user_data['user_id'],
                    'heading'            => $heading,
                    'image'              => $file_name,
                    'content'            => $content,
                ];
    
                $res = $this->custom_page_data->insert($data);
                if ($res) {
                    echo json_encode(['status' => true, 'message' => 'Page content created successfully.']);
                } else {
                    echo json_encode(['status' => false, 'message' => 'Page content create unsuccessfully.']);
                }
                exit;
            }else{
                
                $result = $this->custom_page_data->select('image')->find($page_id);
                if(!empty($image) && $image->isValid()){
                    if(!empty($result['image'])){
                        $path  = "public/uploads/custom_pages_image/".$result['image'];
                        if(file_exists($path)){
                            unlink($path);
                        }
                    }
                    $file_name = $image->getRandomName();
                    $image->move('public/uploads/custom_pages_image/', $file_name);
                }
    
                $data = [
                    'heading'            => $heading,
                    'image'              => $file_name,
                    'content'            => $content,
                ];

                $data = array_filter($data);
                $res = $this->custom_page_data->update($page_id, $data);
                if ($res) {
                    echo json_encode(['status' => true, 'message' => 'Page content updated successfully.']);
                } else {
                    echo json_encode(['status' => false, 'message' => 'Page content create unsuccessfully.']);
                }
                exit;
            }
        }
    }

    public function getSubMenuData($id= null){
        $res = $this->custom_page_data->where('custom_sub_menu_id', $id)->first();
        if ($res) {
            echo json_encode(['status' => true, 'data' => $res ]);
        } else {
            echo json_encode(['status' => false]);
        }
        //echo json_encode($res);
        exit;
    }

    public function deleteSubmenu($id){
        $res = $this->sub_menu_model->find($id);
        if(!empty($res)){
            if(!empty($result['image'])){
                $path  = "public/uploads/custom_pages_image/".$result['image'];
                if(file_exists($path)){
                    unlink($path);
                }
            }
            $this->sub_menu_model->delete($id);
            echo json_encode(['status' => true, 'message' => 'Sub menu deleted successfully.' ]);
        }else{
            echo json_encode(['status' => true, 'message' => 'No sub menu unsuccessfully.' ]);
        }
    }

    

    public function search(){
        return redirect()->to(base_url());
    }
}


