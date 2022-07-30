<?php

namespace App\Controllers;
use App\Models\Enquiry_model;
use App\Libraries\User_details;
use App\Libraries\Meta_keywords;

class Contact extends UiController { 
    
    protected $validation; 
    protected $enquiry_model; 

    public function __construct(){
        parent::__construct();
        $this->validation    = \Config\Services::validation();
        $this->enquiry_model = new Enquiry_model();
        helper('form');
        $this->user_slider = new User_details();
        $meta_lib = new Meta_keywords();
        $this->meta_lib_data = $meta_lib->getMetaKeywords($this->user['id']);
        
    }

    public function contact(){
        $slider = $this->user_slider->getSlider('Contact');
         /**
         * Make gallery images array
         */
        $images = $this->user_slider->galleryImages('Contact');
        
         /**
         * Make video gallery array
         */
        $video =  $this->user_slider->getVideoLists('Contact');
        
        /**
         * Make custom section array data
         */
        $custom =  $this->user_slider->getCustomSectionData('Contact');
        
        /**
         * Make testimonial data section array data
         */
        $testimonial =  $this->user_slider->getTestimonialData('Contact');

        /**
         * Make faq list section array data
        */
        $fq_lists =  $this->user_slider->getFaqLists('Contact');

        /** 
         * Make faq list section array data
        */
        $services =  $this->user_slider->getServiesLists('Contact');

        /**
         * Make products list section array data
        */
        $products =  $this->user_slider->getProductsLists('Contact');


        /**
         * Make products list section array data
        */
        $post_updates =  $this->user_slider->getUpdateLists('Contact');  

        
        $sort_order =  $this->user_slider->getSortOrder('Contact');
        
        $pageData = [
            'title' => 'Contact Us',
            'description' => 'This is the contact page',
            'keywords' => 'Contact',
            'user_details'  => $this->user,
            'menu_lists'    => $this->final_menu,

            'cart'          => cart_history(),
            'colors'        => $this->colors,
            'meta_keywords' => $this->meta_lib_data,

            'sliders'        => $slider,
            
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
        return view($this->user['theme_name']."/".'frontend/contact', $pageData);
    }


    //Save inquiry modal data
    public function saveInquiry(){
        $this->validation->setRules([
            'name'   => ["label" => "name", 'rules' => 'required'],
            'number' => ["label" => 'number', 'rules' => 'required|min_length[10]|max_length[10]'],
            'message'=> ["label" => 'message', 'rules' => 'required'],
        ]);

        if($this->validation->withRequest($this->request)->run()){
            $data = [
                "name"    => $this->request->getPost("name"),
                "phone"   => $this->request->getPost("number"),
                "email"   => $this->request->getPost("email"),
                'source'  => 'e-plugin',
                'status'  => "1",
                "message" => $this->request->getPost("message"),
            ];

            $res = $this->enquiry_model->save($data);
            if($res){
                $message = [
                    'status' => true,
                    'msg'    => "Message sent successfully, we will contact your soon!",
                ];
                echo json_encode($message);
                exit; 
            }

        }else{
            $errors = [
                'status' => false,
                'msg'    => $this->validation->getErrors(),
            ];
            echo json_encode($errors);
            exit; 
        }
    }

    //Save inquiry modal data
    public function inquiry(){
        
        $this->validation->setRules([
            'name'   => ["label" => "name", 'rules' => 'required'],
            'email'   => ["label" => "email", 'rules' => 'required|valid_email'],
            'number' => ["label" => 'number', 'rules' => 'required|min_length[10]|max_length[10]'],
            'message'=> ["label" => 'message', 'rules' => 'required'],
        ]);

        if($this->validation->withRequest($this->request)->run()){
            
            $data = [
                "name"    => $this->request->getPost("name"),
                "email"    => $this->request->getPost("email"),
                "phone"   => $this->request->getPost("number"),
                'source'  => 'e-plugin',
                'status'  => "1",
                "message" => $this->request->getPost("message"),
            ];

            $res = $this->enquiry_model->save($data);
            if($res){
                $message = [
                    'status' => true,
                    'msg'    => "Message sent successfully, we will contact your soon!",
                ];
                echo json_encode($message);
                exit; 
            }

        }else{
            $errors = [
                'status' => false,
                'msg'    => $this->validation->getErrors(),
            ];
            echo json_encode($errors);
            exit; 
        }
    }

    public function search(){
        
        return redirect()->to(base_url());
    }


}


