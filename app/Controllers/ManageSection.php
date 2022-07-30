<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Manage_model;
use App\Models\ProductsModel;
use App\Models\SeoProductImages;
use App\Models\ImagesGallary;
use App\Models\MetaKeywordModel;
use App\Models\PostsModel;
use App\Models\ArrangeSection;
use App\Models\ArrangeCustomSection;

class ManageSection extends BaseController
{
    protected $manage;
    protected $product_model;
    protected $arrange_section_model;
    protected $custom_arrange_model;
    public function __construct()
    {
        $request = \Config\Services::request();
        $session = \Config\Services::session();
        $validation =  \Config\Services::validation();  
        $this->session = $session;
        $this->request = $request;
        $this->product_model = new ProductsModel();
        $model =  $this->manage = new Manage_model();
        $this->images_model = new ImagesGallary();
        $this->product_images = new SeoProductImages();
        $this->meta_keywords = new MetaKeywordModel();
        $this->arrange_section_model = new ArrangeSection();
        $this->custom_arrange_model = new ArrangeCustomSection();
        helper(["general", "arrange"]);
        login_redirect();
    }

    public function index()
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }

        $data['pages'] =  $this->manage->get_menu_pages($user_data["user_id"]);
        
        //bb_print_r($data['pages']);
        $data['data'] =   $this->manage->get_all_sliders($user_data["user_id"]);
        $data['slider'] =  $this->manage->all_slider($user_data["user_id"]);
        $data['color'] =  getThemeColor($user_data["user_id"]);
        $data['title'] = "Sliders Section";
        return view('manage/slider', $data);
    }

    public function all_slider()
    {

        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $data['data'] =  $this->manage->all_slider($user_data["user_id"]);
        $data['color'] =  getThemeColor($user_data["user_id"]);
        $data['title'] = "All Sliders";
        return view('manage/slider_images', $data);
    }

    public function add_slider()
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $data['color'] =  getThemeColor($user_data["user_id"]);
        $data['title'] = "Add New Sliders";
        return view('manage/new_slider', $data);
    }

    public function save_slider()
    {

        if (!$this->validate([
            'name' => 'required|is_unique[seo_slider.name]',

        ])) {
            echo json_encode(['status' => false, 'validation' => true, 'message' => 'This name is already exist.']);
        } else {

            if ($this->session->has('login_user')) {
                $user_data = $this->session->get('login_user');
            }

            $file_name = NULL;
            $file = $this->request->getFile('slider_image');
            if ($file->isValid()) {
                $file_name = $file->getRandomName();
                $file->move('public/uploads/slider_images/', $file_name);
            }

            $data = array(
                'text_color' => xss_clean($this->request->getVar('text_color')),
                'heading_color' => xss_clean($this->request->getVar('heading_color')),
                'name' => xss_clean($this->request->getVar('name')),
                'title' => xss_clean($this->request->getVar('title')),
                'description' => xss_clean($this->request->getVar('description')),
                'title_font_family' => xss_clean($this->request->getVar('fontStyle')),
                'desc_font_family' => xss_clean($this->request->getVar('descFontStyle')),
                'slider_image' => $file_name,
                'created_by' => $user_data["user_id"]
            );
            $return = $this->manage->save_slider($data);
            if ($return) {
                echo json_encode(['status' => true, 'message' => 'Slider record saved successfully.']);
            } else {
                echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
            }
        }
    }

    public function edit_slider($id)
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $data['slider_data'] = $this->manage->edit_slider($user_data["user_id"], $id);
        $data['color'] =  getThemeColor($user_data["user_id"]);
        $data['title'] = "Edit Sliders";
        return view('manage/edit_slider', $data);
    }

    public function update_slider($id)
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $file_name = "";
        $file = $this->request->getFile('slider_image');
        if ($file->isValid()) {
            $file_name = $file->getRandomName();
            $file->move("public/uploads/slider_images", $file_name);
        }

        $data = array(
            'text_color' => xss_clean($this->request->getVar('text_color')),
            'heading_color' => xss_clean($this->request->getVar('heading_color')),
            'name' => xss_clean($this->request->getVar('name')),
            'title' => xss_clean($this->request->getVar('title')),
            'description' => xss_clean($this->request->getVar('description')),
            'title_font_family' => xss_clean($this->request->getVar('fontStyle')),
            'desc_font_family' => xss_clean($this->request->getVar('descFontStyle')),
            'slider_image' => $file_name,
            'update_by' => $user_data["user_id"],
            'updated_at' => date("Y-m-d H:i:s")
        );

        //$data = array_filter($data);    
        if (empty($data['slider_image'])) {
            unset($data['slider_image']);
        }

        $return = $this->manage->update_slider($data, $id);
        if ($return) {
            echo json_encode(['status' => true, 'message' => 'Slider record updated successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function delete_slider($id)
    {
        $return = $this->manage->delete_slider($id);
        if ($return) {
            echo json_encode(['status' => true, 'message' => 'Slider record deleted successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function allslider_get()
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $data =  $this->manage->all_slider($user_data["user_id"]);
        if ($data) {
            echo json_encode(['status' => true, 'data' => $data]);
        }
    }

    public function add_slider_section()
    {
        $validation =  \Config\Services::validation();
        if (!$this->validate([
            'section_name' => 'required|is_unique[seo_slider_section.section_name]',
        ])) {
            echo json_encode(['status' => false, 'validation' => true, 'message' => 'This section name is already exist.']);
        } else {

            if ($this->session->has('login_user')) {
                $user_data = $this->session->get('login_user');
            }

            $page_id = $this->request->getVar('page_id');
            $slider =  $this->request->getVar('slider');
            $slider = json_encode($slider);
            $arr = [];
            
            foreach ($page_id as $value) {
                $testarr = explode(",", $value);
                $sub_menu_title = $this->manage->get_menuName($testarr[0]);
                $arr[] = [
                    "menu" => $testarr[0],
                    "sub_menu" => $testarr[2],
                    "sub_menu_title" => $sub_menu_title,
                ];
            }

            $data = array(
                'section_name' => xss_clean($this->request->getVar('section_name')),
                'page_id' => json_encode($arr),
                'slider' => $slider,
                'created_by' => $user_data["user_id"]
            );

            $db = db_connect();
            $return = $this->manage->add_slider($data);
            $last_id = $db->insertID();
            if ($return) {
                
                //Insert slider data information in arrange section table for showing by default in arrange section side bar menus
                foreach ($page_id as $p_id) {
                    $var = explode(",", $p_id);
                    $menu_title = getMenuTitleName($var[0]);
                   
                    if ($p_id[0] == 1 || $p_id[0] == 2 ||  $menu_title == "Contact") {
                        $result = $this->arrange_section_model->select('max(soroting_order) as sorting_order')->first();
                        $sorting_order = $result['sorting_order'];

                        //Make arrage section data
                        $arrange_section_data = [
                            'section_title' => 'Slider Section',
                            'section_id'    => $last_id,
                            'menu_id'       => $var[0],
                            'submenu_id'    => 0,
                            'title'         => xss_clean($this->request->getVar('section_name')),
                            'url_val'       => 'slider',
                            'soroting_order' => $sorting_order + 1,
                            'created_by' => $user_data["user_id"]
                        ];
                        //Save arrage section in arrange section table for shorting
                        $this->arrange_section_model->insert($arrange_section_data);
                    }
                }
                echo json_encode(['status' => true, 'message' => 'Slider saved successfully.']);
            } else {
                echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
            }
        }
    }

    public function all_slider_section()
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $data['pages'] =  $this->manage->get_menu_pages($user_data["user_id"]);
        $data['slider_section'] =  $this->manage->get_all_sliders($user_data["user_id"]);
        $data['slider'] =  $this->manage->all_slider($user_data["user_id"]);
        if ($data) {
            echo json_encode(['status' => true, 'data' => $data]);
        }
    }

    public function delete_slider_section($id)
    {
        $return = $this->manage->delete_slider_section($id);
        if ($return) {
            $arrange_section_id = $this->arrange_section_model->select('id')->where(['section_id' => $id, 'url_val' => 'slider'])->first();
            if (isset($arrange_section_id['id']) && !empty($arrange_section_id['id'])) {
                $this->arrange_section_model->delete($arrange_section_id['id']);
            }
            echo json_encode(['status' => true, 'message' => 'Slider record deleted successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function edit_slider_section($id)
    {
        $return = $this->manage->edit_slider_section($id);
        if ($return) {
            echo json_encode(['status' => true, 'data' => $return]);
        } else {
            echo json_encode(['status' => false, 'message' => 'No data found']);
        }
    }

    public function update_slider_section($id)
    {

        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $page_id = $this->request->getVar('page_id');
        $slider =  $this->request->getVar('slider');
        $slider = json_encode($slider);
        $arr = [];

        foreach ($page_id as $value) {
            $testarr = explode(",", $value);
            $sub_menu_title = $this->manage->get_menuName($testarr[0]);
            // if ($testarr[0] == 3) {
            //     $sub_menu_title = $this->manage->get_serviceName($testarr[1]);
            //     $sub_menu_title = "Service -" . $sub_menu_title;
            // } else if ($testarr[0] == 4) {
            //     $sub_menu_title = $this->manage->get_productName($testarr[1]);
            //     $sub_menu_title = "Products -" . $sub_menu_title;
            // } else {
            //     $sub_menu_title = $this->manage->get_menuName($testarr[0]);
            // }
            $arr[] = [
                "menu" => $testarr[0],
                "sub_menu" => $testarr[2],
                "sub_menu_title" => $sub_menu_title,
            ];
        }

        $data = array(
            'section_name' => xss_clean($this->request->getVar('section_name')),
            'page_id' => json_encode($arr),
            'slider' => $slider,
            'update_by' => $user_data["user_id"],
            'updated_at' => date("Y-m-d H:i:s")
        );

        $return = $this->manage->update_slider_section($data, $id);

        if ($return) {

            $arrange_section_id = $this->arrange_section_model->select('id')->where(['section_id' => $id,   'url_val' => 'slider'])->findAll();
            if (sizeof($arrange_section_id) > 0) {
                $arrange_section_data = [
                    'title'      => xss_clean($this->request->getVar('section_name')),
                    'updated_by' => $user_data["user_id"]
                ];
                foreach ($arrange_section_id as $k => $a_s_id) {
                    $r = $this->arrange_section_model->update($a_s_id['id'], $arrange_section_data);
                }
            }

            echo json_encode(['status' => true, 'message' => 'Slider record updated successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function custom_section()
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $data['pages'] =  $this->manage->get_menu_pages($user_data["user_id"]);
        $data['data'] =  $this->manage->get_all_custom_section($user_data["user_id"]);
        $data['color'] =  getThemeColor($user_data["user_id"]);
        $data['title'] = "Custom Section";
        return view('manage/custom_section', $data);
    }

    public function save_custom_section()
    {

        $validation =  \Config\Services::validation();
        if (!$this->validate([
            'heading' => 'required|is_unique[seo_custom_section.heading]',
        ])) {
            echo json_encode(['status' => false, 'validation' => true, 'message' => $validation->getError()]);
        } else {

            if ($this->session->has('login_user')) {
                $user_data = $this->session->get('login_user');
            }


            $file_name = NULL;
            $file = $this->request->getFile('upload_image');
            if ($file->isValid()) {
                $file_name = $file->getRandomName();
                $file->move('public/uploads/custom_images/', $file_name);
            }

            $page_id = $this->request->getVar('page_id');
            // foreach ($page_id as $value) {
            //     $testarr = explode(",", $value);
            //     if ($testarr[0] == 3) {
            //         $sub_menu_title = $this->manage->get_serviceName($testarr[1]);
            //         $sub_menu_title = "Service -" . $sub_menu_title;
            //     } else if ($testarr[0] == 4) {
            //         $sub_menu_title = $this->manage->get_productName($testarr[1]);
            //         $sub_menu_title = "Products -" . $sub_menu_title;
            //     } else {
            //         $sub_menu_title = $this->manage->get_menuName($testarr[0]);
            //     }
            //     $arr[] = [
            //         "menu" => $testarr[0],
            //         "sub_menu" => $testarr[1],
            //         "sub_menu_title" => $sub_menu_title,
            //     ];
            // }

            $testarr = explode(",", $page_id);
            $sub_menu_title = $this->manage->get_menuName($testarr[0]);
            $arr[] = [
                "menu" => $testarr[0],
                "sub_menu" => $testarr[2],
                "sub_menu_title" => $sub_menu_title,
            ];

            $data = array(
                //'page_id' => ltrim($page_id),
                'page_id' => json_encode($arr),
                'position' => xss_clean($this->request->getVar('position')),
                'heading' => xss_clean($this->request->getVar('heading')),
                'description' => $this->request->getVar('des'),
                'upload_image' => $file_name,
                'created_by' => $user_data["user_id"]
            );

            $return = $this->manage->save_custom_section($data);

            $return = true;
            $db = db_connect();
            $last_id = $db->insertID();
            if ($return) {
                if ($testarr[0] == 1 || $testarr[0] == 2) {
                    $p_id = 1;
                    if ($testarr[0] == 2) {
                        $p_id = 2;
                    }

                    $result = $this->arrange_section_model->select('max(soroting_order) as sorting_order')->first();
                    $sorting_order = $result['sorting_order'];
                    
                    //Make arrage section data
                    $arrange_section_data = [
                        'section_title' => 'Custom Section',
                        'section_id'    => $last_id,
                        'menu_id'       => $p_id,
                        'submenu_id'    => 0,
                        'title'         => xss_clean($this->request->getVar('heading')),
                        'url_val'       => 'custom',
                        'soroting_order' => $sorting_order + 1,
                        'created_by' => $user_data["user_id"]
                    ];
                    //Save arrage section in arrange section table for shorting
                    $this->arrange_section_model->insert($arrange_section_data);
                }
                echo json_encode(['status' => true, 'message' => 'Custom section saved successfully.']);
            } else {
                echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
            }
        }
    }

    public function edit_custom_section($id){
        $return = $this->manage->edit_custom_section($id);
        if ($return) {
            echo json_encode(['status' => true, 'data' => $return]);
        } else {
            echo json_encode(['status' => false, 'message' => 'No data found']);
        }
    }

    public function delete_custom_section($id)
    {
        $return = $this->manage->delete_custom_section($id);
        if ($return) {

            $arrange_section_id = $this->arrange_section_model->select('id')->where(['section_id' => $id, 'url_val' => 'custom'])->first();
            if (isset($arrange_section_id['id']) && !empty($arrange_section_id['id'])) {
                $this->arrange_section_model->delete($arrange_section_id['id']);
            }

            echo json_encode(['status' => true, 'message' => 'Record deleted successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function update_custom_section($id)
    {

        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }

        $page_id = $this->request->getVar('page_id');
        // foreach ($page_id as $value) {
        //     $testarr = explode(",", $value);
        //     if ($testarr[0] == 3) {
        //         $sub_menu_title = $this->manage->get_serviceName($testarr[1]);
        //         $sub_menu_title = "Service -" . $sub_menu_title;
        //     } else if ($testarr[0] == 4) {
        //         $sub_menu_title = $this->manage->get_productName($testarr[1]);
        //         $sub_menu_title = "Products -" . $sub_menu_title;
        //     } else {
        //         $sub_menu_title = $this->manage->get_menuName($testarr[0]);
        //     }
        //     $arr[] = [
        //         "menu" => $testarr[0],
        //         "sub_menu" => $testarr[1],
        //         "sub_menu_title" => $sub_menu_title,
        //     ];
        // }
        $testarr = explode(",", $page_id);
        $sub_menu_title = $this->manage->get_menuName($testarr[0]);
        $arr[] = [
            "menu" => $testarr[0],
            "sub_menu" => $testarr[2],
            "sub_menu_title" => $sub_menu_title,
        ];


        $file_name = NULL;
        $file = $this->request->getFile('upload_image');
        if ($file->isValid()) {
            $file_name = $file->getRandomName();
            $file->move('public/uploads/custom_images/', $file_name);
        }

        if (!empty($file_name)) {
            $data = array(
                //'page_id' => ltrim($page_id),
                'page_id' => json_encode($arr),
                'position' => xss_clean($this->request->getVar('position')),
                'heading' => xss_clean($this->request->getVar('heading')),
                'description' => $this->request->getVar('des'),
                'upload_image' => $file_name,
                'update_by' => $user_data["user_id"],
                'updated_at' =>  date("Y-m-d H:i:s")
            );
        } else {
            $data = array(
                //'page_id' => ltrim($page_id),
                'page_id' => json_encode($arr),
                'position' => xss_clean($this->request->getVar('position')),
                'heading' => xss_clean($this->request->getVar('heading')),
                'description' => $this->request->getVar('des'),
                'update_by' => $user_data["user_id"],
                'updated_at' =>  date("Y-m-d H:i:s")
            );
        }


        $return = $this->manage->update_custom_section($data, $id);
        if ($return) {

            $arrange_section_id = $this->arrange_section_model->select('id')->where(['section_id' => $id,   'url_val' => 'custom'])->first();

            if (isset($arrange_section_id['id']) && !empty($arrange_section_id['id'])) {
                
                if ($testarr[0] == 1) {
                    $p_id = 1;
                }
                if ($testarr[2] == 1) {
                    $p_id = 2;
                }

                $arrange_section_data = [
                    'title'      => xss_clean($this->request->getVar('heading')),
                    'updated_by' => $user_data["user_id"],
                    'menu_id'    => $p_id,
                ];
                //update slider title value for arrange section
                $r = $this->arrange_section_model->update($arrange_section_id['id'], $arrange_section_data);                
            }
            echo json_encode(['status' => true, 'message' => 'Custom section updated successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function allslider_custom()
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $data =  $this->manage->allslider_custom($user_data["user_id"]);
        if ($data) {
            echo json_encode(['status' => true, 'data' => $data]);
        }
    }

    public function services()
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        // $data['pages'] =  $this->manage->get_menu_pages($user_data["user_id"]); 
        $data['data'] =  $this->manage->all_services($user_data["user_id"]);
        $data['color'] =  getThemeColor($user_data["user_id"]);
        $data['title'] = "Services";
        return view('manage/services', $data);
    }

    public function add_services()
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $data['services'] =  $this->manage->all_services($user_data["user_id"]);
        $data['color'] =  getThemeColor($user_data["user_id"]);
        $data['title'] = "Add Services";
        return view('manage/add_services', $data);
    }

    public function save_services()
    {
        $validation =  \Config\Services::validation();
        if (!$this->validate([
            'service' => 'required|is_unique[seo_service.service]'
        ])) {
            echo json_encode(['status' => false, 'validation' => true, 'message' => 'This name is already exist.']);
        } else {

            $banner_image = NULL;
            $servic_image = NULL;
            $banner_image_file = $this->request->getFile('service_image');
            $servic_image_file = $this->request->getFile('service_banner');

            if ($banner_image_file->isValid()) {
                $banner_image = $banner_image_file->getRandomName();
                $banner_image_file->move('public/uploads/service_banners', $banner_image);
            }

            if ($servic_image_file->isValid()) {
                $servic_image = $servic_image_file->getRandomName();
                $servic_image_file->move('public/uploads/service_images', $servic_image);
            }

            $slug = "";
            $Services_id = '';
            if ($this->session->has('login_user')) {
                $user_data = $this->session->get('login_user');
            }
            $Services_id = $this->manage->get_servicesID($user_data["user_id"]);
            $related =  $this->request->getVar('related_services');
            $related = json_encode($related);
            if (!empty($this->request->getVar('slug'))) {
                $slug = $this->request->getVar('slug');
                $slug = ltrim($slug);
                $slug = preg_replace('/[^0-9a-zA-Z ]/', '', $slug);
                $slug = strtolower(str_replace(" ", "-", ltrim($slug)));
            } else {
                $slug = $this->request->getVar('service');
                $slug = preg_replace('/[^0-9a-zA-Z ]/', '', $slug);
                $slug = strtolower(str_replace(" ", "-", ltrim($slug)));
            }
            $service_name = xss_clean($this->request->getVar('service'));
            $data = array(
                'service' => $service_name,
                "menu_link" => $slug,
                'slug' => $slug,
                'content' => $this->request->getVar('content2'),
                'menu_id'  => $Services_id,
                'related_services' => $related,
                'image' => $servic_image,
                'banner' => $banner_image,
                'created_by' => $user_data["user_id"]
            );

            $return = $this->manage->save_services($data);
            if ($return) {
                echo json_encode(['status' => true, 'message' => 'Service record saved successfully.']);
            } else {
                echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
            }
        }
    }

    public function edit_services($id)
    {
        $id = !empty($id) ? base64_decode($id) : 0;

        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $data['services'] =  $this->manage->all_services($user_data["user_id"]);
        $data['data'] =  $this->manage->edit_services($id);
        $data['color'] =  getThemeColor($user_data["user_id"]);
        $data['title'] = "Edit Services";
        return view('manage/edit_service', $data);
    }

    public function update_services($id)
    {

        $slug = "";
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $related =  $this->request->getVar('related_services');
        $related = json_encode($related);

        $banner_image = NULL;
        $servic_image = NULL;

        $banner_image_file = $this->request->getFile('service_banner');
        $servic_image_file = $this->request->getFile('service_image');

        if (!empty($banner_image_file) && $banner_image_file->isValid()) {
            $banner_image = $banner_image_file->getRandomName();
            $banner_image_file->move('public/uploads/service_banners', $banner_image);
        }

        if (!empty($servic_image_file) &&  $servic_image_file->isValid()) {
            $servic_image = $servic_image_file->getRandomName();
            $servic_image_file->move('public/uploads/service_images', $servic_image);
        }

        if (!empty($this->request->getVar('slug'))) {
            $slug = $this->request->getVar('slug');
            $slug = ltrim($slug);
            $slug = preg_replace('/[^0-9a-zA-Z ]/', '', $slug);
            $slug = strtolower(str_replace(" ", "-", ltrim($slug)));
        } else {
            $slug = $this->request->getVar('service');
            $slug = preg_replace('/[^0-9a-zA-Z ]/', '', $slug);
            $slug = strtolower(str_replace(" ", "-", ltrim($slug)));
        }

        $Services_id = $this->manage->get_servicesID($user_data["user_id"]);
        $data = array(
            'service' => xss_clean($this->request->getVar('service')),
            'slug' => $slug,
            'menu_link' => $slug,
            'content' => $this->request->getVar('content2'),
            'related_services' => $related,
            'menu_id'  => $Services_id,
            'image' => $servic_image,
            'banner' => $banner_image,
            'updated_by' => $user_data["user_id"],
            'updated_at' => date("Y-m-d H:i:s")
        );
        $data = array_filter($data);
        $return = $this->manage->update_services($id, $data);
        if ($return) {
            echo json_encode(['status' => true, 'message' => 'Service record updated successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function delete_services($id)
    {
        $return = $this->manage->delete_services($id);
        if ($return) {
            echo json_encode(['status' => true, 'message' => 'Service record deleted successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function services_section()
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $data['pages'] =  $this->manage->get_menu_pages($user_data["user_id"]);
        $data['services'] =  $this->manage->all_services($user_data["user_id"]);
        $data['data'] =  $this->manage->all_services_section($user_data["user_id"]);
        $data['color'] =  getThemeColor($user_data["user_id"]);
        $data['title'] = "Services Section";
        return view('manage/services_section', $data);
    }
    public function save_services_section()
    {
        $validation =  \Config\Services::validation();
        if (!$this->validate([
            'heading' => 'is_unique[seo_services_section.heading]',
        ])) {
            echo json_encode(['status' => false, 'validation' => true, 'message' => $validation->getError()]);
        } else {
            if ($this->session->has('login_user')) {
                $user_data = $this->session->get('login_user');
            }
            $services =  $this->request->getVar('services');
            $services = json_encode($services);
            $pages =  $this->request->getVar('pages');

            foreach ($pages as $value) {
                $testarr = explode(",", $value);

                if ($testarr[0] == 3) {
                    $sub_menu_title = $this->manage->get_serviceName($testarr[1]);
                    $sub_menu_title = "Service -" . $sub_menu_title;
                } else if ($testarr[0] == 4) {
                    $sub_menu_title = $this->manage->get_productName($testarr[1]);
                    $sub_menu_title = "Products -" . $sub_menu_title;
                } else {
                    $sub_menu_title = $this->manage->get_menuName($testarr[0]);
                }
                $arr[] = [
                    "menu" => $testarr[0],
                    "sub_menu" => $testarr[1],
                    "sub_menu_title" => $sub_menu_title,
                ];
            }

            $data = array(
                'heading' => xss_clean($this->request->getVar('heading')),
                'discription' => xss_clean($this->request->getVar('discription')),
                'services' => $services,
                'pages' => json_encode($arr),
                'created_by' => $user_data["user_id"]
            );

            $return = $this->manage->save_services_section($data);
            if ($return) {
                echo json_encode(['status' => true, 'message' => 'Service section saved successfully.']);
            } else {
                echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
            }
        }
    }

    public function edit_services_section($id)
    {
        $return = $this->manage->edit_services_section($id);
        if ($return) {
            echo json_encode(['status' => true, 'data' => $return]);
        } else {
            echo json_encode(['status' => false, 'message' => 'No data found']);
        }
    }

    public function update_services_section($id)
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $services =  $this->request->getVar('services');
        $services = json_encode($services);
        $pages =  $this->request->getVar('pages');
        foreach ($pages as $value) {
            $testarr = explode(",", $value);
            if ($testarr[0] == 3) {
                $sub_menu_title = $this->manage->get_serviceName($testarr[1]);
                $sub_menu_title = "Service -" . $sub_menu_title;
            } else if ($testarr[0] == 4) {
                $sub_menu_title = $this->manage->get_productName($testarr[1]);
                $sub_menu_title = "Products -" . $sub_menu_title;
            } else {
                $sub_menu_title = $this->manage->get_menuName($testarr[0]);
            }
            $arr[] = [
                "menu" => $testarr[0],
                "sub_menu" => $testarr[1],
                "sub_menu_title" => $sub_menu_title
            ];
        }

        $data = array(
            'heading' => xss_clean($this->request->getVar('heading')),
            'discription' => xss_clean($this->request->getVar('discription')),
            'services' => $services,
            'pages' => json_encode($arr),
            'updated_by' => $user_data["user_id"],
            'updated_at' =>  date("Y-m-d H:i:s")
        );
        $return = $this->manage->update_services_section($data, $id);
        if ($return) {
            echo json_encode(['status' => true, 'message' => 'Service section updated successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function delete_services_section($id)
    {
        $return = $this->manage->delete_services_section($id);
        if ($return) {
            echo json_encode(['status' => true, 'message' => 'Record deleted successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function products()
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $data['data'] =  $this->manage->all_Products($user_data["user_id"]);
        $data['color'] =  getThemeColor($user_data["user_id"]);
        $data['title'] = "Products";
        return view('manage/products', $data);
    }

    public function add_products()
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $data['products'] =  $this->manage->all_Products($user_data["user_id"]);
        $data['color'] =  getThemeColor($user_data["user_id"]);
        $data['title'] = "Add Products";
        return view('manage/add_products', $data);
    }

    public function save_products()
    {
        $validation =  \Config\Services::validation();
        if (!$this->validate([
            'product_name' => 'is_unique[seo_products.product_name]',
            'product_name' => 'uploaded[product_main_image]',
        ])) {
            echo json_encode(['status' => false, 'validation' => true, 'message' => $validation->getError()]);
        } else {
            if ($this->session->has('login_user')) {
                $user_data = $this->session->get('login_user');
            }
            $product_banner = NULL;
            //$banner_file   = $this->request->getFile('product_banner');

            $product_image = [];
            $image_file    = $this->request->getFiles('product_main_image');
            foreach ($image_file['product_main_image'] as $img) {
                if ($img->isValid() && !$img->hasMoved()) {
                    $new_name = $img->getRandomName();
                    $product_image[] = $new_name;
                    $img->move('public/uploads/product_images', $new_name);
                }
            }

            // if(!empty($banner_file) && $banner_file->isValid() ){
            //     $product_banner = $banner_file->getRandomName();
            //     $banner_file->move('public/uploads/product_banners', $product_banner);
            // }

            $product_id = '';
            $product_id = $this->manage->get_ProductID($user_data["user_id"]);

            $related_product =  $this->request->getVar('related_product');
            $related_product = json_encode($related_product);

            $product_name = xss_clean($this->request->getVar('product_name'));
            $product_name = ltrim($product_name);
            $product_name = preg_replace('/[^0-9a-zA-Z ]/', '', $product_name);
            $slug    = strtolower(str_replace(" ", "-", $product_name));

            $data = array(
                'product_name' => $product_name,
                "menu_link"    => $slug,
                'menu_id'  => $product_id,
                'total_inventry' => xss_clean($this->request->getVar('total_inventry')),
                'mrp' => xss_clean($this->request->getVar('mrp')),
                'discount' => xss_clean($this->request->getVar('discount')),
                'short_description' => $this->request->getVar('short'),
                'long_description' => $this->request->getVar('long'),
                'specification' => $this->request->getVar('specifi'),
                'main_image' => $product_image[0],
                'banner' => $product_banner,
                'related_product' => $related_product,
                'created_by' => $user_data["user_id"]
            );

            $return = $this->manage->save_products($data);
            if ($return) {
                if (!empty($product_image)) {
                    foreach ($product_image as $pi) {
                        $p_data[] = [
                            'product_image' => $pi,
                            'product_id'    => $return,
                            'created_by'    => $user_data["user_id"],
                        ];
                    }
                    $this->product_images->insertBatch($p_data);
                }
                echo json_encode(['status' => true, 'message' => 'Product record saved successfully.']);
            } else {
                echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
            }
        }
    }

    public function get_products()
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $data =  $this->manage->all_Products($user_data["user_id"]);
        if ($data) {
            echo json_encode(['status' => true, 'data' => $data]);
        }
    }

    public function delete_products($id)
    {
        $return = $this->manage->delete_products($id);
        if ($return) {
            echo json_encode(['status' => true, 'message' => 'Product record deleted successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function edit_products($id)
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $id = base64_decode($id);
        $data['product_images'] = $this->product_images->select(['id', 'product_image'])->where('product_id', $id)->findAll();
        $data['products'] =  $this->manage->all_Products($user_data["user_id"]);
        $data['data'] =  $this->manage->edit_products($id);
        $data['color'] =  getThemeColor($user_data["user_id"]);
        $data['title'] = "Edit Product";
        return view('manage/edit_product', $data);
    }

    public function removeImg($id)
    {
        $old_image = $this->product_images->where('id', $id)->first();
        $path = "public/uploads/product_images/" . $old_image['product_image'];
        if (file_exists($path)) {
            $image = $this->manage->getMainImages($old_image['product_image']);
            if ($image['main_image'] != $old_image['product_image']) {
                unlink($path);
            }
            $this->product_images->delete($id);
            echo "Yes";
            exit;
        }
        echo "No";
        exit;
    }

    public function update_products($id)
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }

        $banner_file   = NULL;
        $product_image = [];
        $image_file    = $this->request->getFiles('product_main_image');

        foreach ($image_file['product_main_image'] as $img) {
            if ($img->isValid() && !$img->hasMoved()) {
                $new_name = $img->getRandomName();
                $product_image[] = $new_name;
                $img->move('public/uploads/product_images', $new_name);
            }
        }

        if (count($product_image) > 0) {
            $product_img = $product_image[0];
        } else {
            $product_img = "";
        }

        $product_id = '';
        $product_id = $this->manage->get_ProductID($user_data["user_id"]);

        $related_product =  $this->request->getVar('related_product');
        $related_product = json_encode($related_product);

        $product_name = xss_clean($this->request->getVar('product_name'));
        $product_name = ltrim($product_name);
        $product_name = preg_replace('/[^0-9a-zA-Z ]/', '', $product_name);
        $slug    = strtolower(str_replace(" ", "-", $product_name));

        $data = array(
            'product_name' => $product_name,
            "menu_link"    => $slug,
            'menu_id'  => $product_id,
            'total_inventry' => xss_clean($this->request->getVar('total_inventry')),
            'mrp' => xss_clean($this->request->getVar('mrp')),
            'discount' => xss_clean($this->request->getVar('discount')),
            'short_description' => $this->request->getVar('short'),
            'long_description' => $this->request->getVar('long'),
            'specification' => $this->request->getVar('specifi'),
            'related_product' => $related_product,
            'main_image' => $product_img,
            'banner' => $banner_file,
            'update_by' => $user_data["user_id"],
            'updated_at' =>  date("Y-m-d H:i:s")
        );
        $data = array_filter($data);
        $return = $this->manage->update_products($data, $id);
        if ($return) {
            if (!empty($product_image)) {
                foreach ($product_image as $pi) {
                    $p_data[] = [
                        'product_image' => $pi,
                        'product_id'    => $return,
                        'created_by'    => $user_data["user_id"],
                    ];
                }
                $this->product_images->insertBatch($p_data);
            }

            echo json_encode(['status' => true, 'message' => 'Product record updated successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function update_galleryimages($id)
    {

        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }

        $image = NULL;
        $image_file    = $this->request->getFile('gallery_image');

        $old_img = $this->manage->getImageName($id);

        if (!empty($image_file) && $image_file->isValid()) {

            $image = $image_file->getRandomName();
            $image_file->move('public/uploads/gallery_images', $image);
            if (!empty($old_img)) {
                $path = base_url() . "/public/uploads/gallery_images/" . $old_img;
                if (file_exists($path)) {
                    unlink($path);
                }
            }
        }

        $title =  $this->request->getVar('title');
        $data = array(
            'image' => $image,
            'title'  => $title,
            'updated_by' => $user_data['user_id'],
        );
        $data = array_filter($data);
        $return = $this->manage->update_image_gallery($data, $id);
        if ($return) {
            echo json_encode(['status' => true, 'message' => 'Gallery image updated successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function product_section()
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $data['data'] =  $this->manage->all_products_section($user_data["user_id"]);
        $data['pages'] =  $this->manage->get_menu_pages($user_data["user_id"]);
        $data['products'] =  $this->manage->all_Products($user_data["user_id"]);
        $data['color'] =  getThemeColor($user_data["user_id"]);
        $data['title'] = "Product Section";
        return view('manage/product_section', $data);
    }

    public function save_product_section()
    {

        $validation =  \Config\Services::validation();
        if (!$this->validate([
            'heading' => 'is_unique[seo_products_section.heading]',
        ])) {
            echo json_encode(['status' => false, 'validation' => true, 'message' => $validation->getError()]);
        } else {
            if ($this->session->has('login_user')) {
                $user_data = $this->session->get('login_user');
            }
            $products =  $this->request->getVar('products');
            $products = json_encode($products);

            $pages =  $this->request->getVar('pages');
            foreach ($pages as $value) {
                $testarr = explode(",", $value);
                if ($testarr[0] == 3) {
                    $sub_menu_title = $this->manage->get_serviceName($testarr[1]);
                    $sub_menu_title = "Service -" . $sub_menu_title;
                } else if ($testarr[0] == 4) {
                    $sub_menu_title = $this->manage->get_productName($testarr[1]);
                    $sub_menu_title = "Products -" . $sub_menu_title;
                } else {
                    $sub_menu_title = $this->manage->get_menuName($testarr[0]);
                }
                $arr[] = [
                    "menu" => $testarr[0],
                    "sub_menu" => $testarr[1],
                    "sub_menu_title" => $sub_menu_title
                ];
            }

            $data = array(
                'heading' => xss_clean($this->request->getVar('heading')),
                'pages' => json_encode($arr),
                'products' => $products,
                'created_by' => $user_data["user_id"]
            );
            $return = $this->manage->save_product_section($data);
            if ($return) {
                echo json_encode(['status' => true, 'message' => 'Product section saved successfully.']);
            } else {
                echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
            }
        }
    }

    public function delete_product_section($id)
    {
        $return = $this->manage->delete_product_section($id);
        if ($return) {
            echo json_encode(['status' => true, 'message' => 'Product section deleted successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function edit_product_section($id)
    {
        $return = $this->manage->edit_product_section($id);
        if ($return) {
            echo json_encode(['status' => true, 'data' => $return]);
        } else {
            echo json_encode(['status' => false, 'message' => 'No data found']);
        }
    }

    public function update_product_section($id)
    {

        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $products =  $this->request->getVar('products');
        $products = json_encode($products);
        $pages =  $this->request->getVar('pages');
        foreach ($pages as $value) {
            $testarr = explode(",", $value);

            if ($testarr[0] == 3) {
                $sub_menu_title = $this->manage->get_serviceName($testarr[1]);
                $sub_menu_title = "Service -" . $sub_menu_title;
            } else if ($testarr[0] == 4) {
                $sub_menu_title = $this->manage->get_productName($testarr[1]);
                $sub_menu_title = "Products -" . $sub_menu_title;
            } else {
                $sub_menu_title = $this->manage->get_menuName($testarr[0]);
            }
            $arr[] = [
                "menu" => $testarr[0],
                "sub_menu" => $testarr[1],
                "sub_menu_title" => $sub_menu_title
            ];
        }

        $data = array(
            'heading' => xss_clean($this->request->getVar('heading')),
            'pages' => json_encode($arr),
            'products' => $products,
            'update_by' => $user_data["user_id"],
            'updated_at' => date("Y-m-d H:i:s")
        );
        $return = $this->manage->update_product_section($data, $id);
        if ($return) {
            echo json_encode(['status' => true, 'message' => 'Product section updated successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function getproduct_section()
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $pages =  $this->manage->get_menu_pages($user_data["user_id"]);
        $products =  $this->manage->all_Products($user_data["user_id"]);
        $data =  $this->manage->all_products_section($user_data["user_id"]);
        if ($data) {
            echo json_encode(['status' => true, 'data' => $data, 'pages' => $pages, 'products' => $products]);
        }
    }

    public function tags_keywords()
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        //$data['data'] =  $this->manage->all_tags_keywords($user_data["user_id"]);
        $data['data']  = $this->meta_keywords->orderBy('id', 'desc')->findAll();
        //$data['pages'] =  $this->manage->get_menu_pages($user_data["user_id"]);
        $data['pages'] =  $this->manage->all_menus_submenus($user_data["user_id"]);
        $data['color'] =  getThemeColor($user_data["user_id"]);
        $data['title'] = "Tags & Keywords";
        return view('manage/tags_keywords', $data);
    }

    public function save_keywords()
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $page =  $this->request->getVar('pages');
        foreach ($page as $p) {
            $pag = [
                'keyword' => xss_clean($this->request->getVar('keyword')),
                'pages' => $p,
                'page_url' => base_url() . '/' . $p,
                'created_by' => $user_data["user_id"]
            ];
            $data[] = $pag;
        }

        $return = $this->meta_keywords->insertBatch($data);

        if ($return) {
            echo json_encode(['status' => true, 'message' => 'Keyword record saved successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function delete_keyword($id)
    {
        $return = $this->manage->delete_keywords($id);
        if ($return) {
            echo json_encode(['status' => true, 'message' => 'Keyword record deleted successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function delete_keywords()
    {
        $id = $this->request->getPost('id');
        if ($this->meta_keywords->delete($id)) {
            echo json_encode(['status' => true, 'message' => 'Selected keyword record deleted successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function gets_keywords()
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        //$pages =  $this->manage->get_menu_pages($user_data["user_id"]);
        $pages  = $this->meta_keywords->findAll();
        $data =  $this->manage->all_tags_keywords($user_data["user_id"]);
        if ($data) {
            echo json_encode(['status' => true, 'data' => $data, 'pages' => $pages]);
        }
    }

    public function posts()
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $data['data'] =  $this->manage->all_posts($user_data["user_id"]);
        $data['color'] =  getThemeColor($user_data["user_id"]);
        $data['title'] = "All Posts";
        return view('manage/posts', $data);
    }

    public function add_posts()
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $data['color'] =  getThemeColor($user_data["user_id"]);
        $data['title'] = "Add Posts";
        return view('manage/add_posts', $data);
    }

    public function save_posts()
    {

        $validation =  \Config\Services::validation();

        if (!$this->validate([
            'title' => 'is_unique[seo_posts.title]',
        ])) {
            echo json_encode(['status' => false, 'validation' => true, 'message' => $validation->getError()]);
        } else {
            if ($this->session->has('login_user')) {
                $user_data = $this->session->get('login_user');
            }
            $slug = "";

            $post_images = "";
            $file = $this->request->getFile('postUpdatesImg');
            if ($file->getName() != "" && $file->isValid()) {
                $post_images = $file->getRandomName();
                $file->move("public/uploads/post_updates_images/", $post_images);
            }

            if (!empty($this->request->getVar('slug'))) {
                $slug = $this->request->getVar('slug');
                $slug = ltrim($slug);
                $slug = preg_replace('/[^0-9a-zA-Z ]/', '', $slug);
                $slug = strtolower(str_replace(" ", "-", ltrim($slug)));
            } else {
                $slug = $this->request->getVar('title');
                $slug = preg_replace('/[^0-9a-zA-Z ]/', '', $slug);
                $slug = strtolower(str_replace(" ", "-", ltrim($slug)));
            }

            $data = array(
                'title' => xss_clean($this->request->getVar('title')),
                'slug' => $slug,
                'image' => $post_images,
                'status' => xss_clean($this->request->getVar('status')),
                'featured' => xss_clean($this->request->getVar('featured')),
                'description' => $this->request->getVar('content'),
                'created_by' => $user_data["user_id"]
            );

            $return = $this->manage->save_posts($data);
            if ($return) {
                echo json_encode(['status' => true, 'message' => 'Post record saved successfully.']);
            } else {
                echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
            }
        }
    }

    public function edit_posts($id)
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $data['data'] =  $this->manage->edit_posts($id);
        $data['color'] =  getThemeColor($user_data["user_id"]);
        $data['title'] = "Edit Posts";
        return view('manage/edit_posts', $data);
    }

    public function update_posts($id)
    {

        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }

        $post_images = "";
        $file = $this->request->getFile('editPostImage');
        if ($file->getName() != "" && $file->isValid()) {
            $post_images = $file->getRandomName();
            $file->move("public/uploads/post_updates_images/", $post_images);
        }

        if (!empty($this->request->getVar('slug'))) {
            $slug = $this->request->getVar('slug');
            $slug = ltrim($slug);
            $slug = preg_replace('/[^0-9a-zA-Z ]/', '', $slug);
            $slug = strtolower(str_replace(" ", "-", ltrim($slug)));
        } else {
            $slug = $this->request->getVar('title');
            $slug = preg_replace('/[^0-9a-zA-Z ]/', '', $slug);
            $slug = strtolower(str_replace(" ", "-", ltrim($slug)));
        }



        $data = array(
            'title' => xss_clean($this->request->getVar('title')),
            'slug' => $slug,
            'image' => $post_images,
            'status' => xss_clean($this->request->getVar('status')),
            'featured' => xss_clean($this->request->getVar('featured')),
            'description' => $this->request->getVar('content'),
            'update_by' => $user_data["user_id"],
            'updated_at' => date("Y-m-d H:i:s")
        );
        $data = array_filter($data);

        $return = $this->manage->update_posts($data, $id);
        if ($return) {
            echo json_encode(['status' => true, 'message' => 'Post record updated successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function delete_posts($id)
    {
        $return = $this->manage->delete_posts($id);
        if ($return) {
            echo json_encode(['status' => true, 'message' => 'Post record deleted successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function custom_insert()
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $data['data'] =  $this->manage->custom_insert($user_data["user_id"]);
        $data['color'] =  getThemeColor($user_data["user_id"]);
        $data['title'] = "Default Meta";
        return view('manage/custom_insert', $data);
    }

    public function save_custom()
    {
        if ($this->request->getVar('head') != '' || $this->request->getVar('foot') != '') {
            if ($this->session->has('login_user')) {
                $user_data = $this->session->get('login_user');
            }
            $data = array(
                'head' => xss_clean($this->request->getVar('head')),
                'foot' => xss_clean($this->request->getVar('foot')),
                'created_by' => $user_data["user_id"]
            );
            $return = $this->manage->save_custom($data);
            if ($return) {
                echo json_encode(['status' => true, 'message' => 'Default Meta Save Successfully.']);
            } else {
                echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
            }
        }
    }

    public function update_custom($id)
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $data = array(
            'head' => xss_clean($this->request->getVar('head')),
            'foot' => xss_clean($this->request->getVar('foot')),
            'updated_by' => $user_data["user_id"],
            'updated_at' => date("Y-m-d H:i:s")
        );
        $return = $this->manage->update_custom($data, $id);
        if ($return) {
            echo json_encode(['status' => true, 'message' => 'Default Meta Update Successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function get_default_meta()
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $data =  $this->manage->custom_insert($user_data["user_id"]);
        if ($data) {
            echo json_encode(['status' => true, 'data' => $data]);
        }
    }

    public function images_gallery()
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $data['data'] =  $this->manage->images_gallery($user_data["user_id"]);
        $data['color'] =  getThemeColor($user_data["user_id"]);
        $data['title'] = "Images Gallery";
        return view('manage/images_gallery', $data);
    }

    public function add_images_gallery()
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $data['color'] =  getThemeColor($user_data["user_id"]);
        $data['title'] = "Upload Gallery Image ";
        return view('manage/add_images', $data);
    }

    public function save_galleryimages()
    {
        $validation =  \Config\Services::validation();
        if (!$this->validate([
            'title' => 'is_unique[seo_images_gallery.title]',
        ])) {
            echo json_encode(['status' => false, 'validation' => true, 'message' => $validation->getError()]);
        } else {
            $image_name = NULL;
            $file = $this->request->getFile('gallery_image');
            if (!empty($file) && $file->isValid()) {
                $image_name = $file->getRandomName();
                $file->move("public/uploads/gallery_images/", $image_name);
            }

            if ($this->session->has('login_user')) {
                $user_data = $this->session->get('login_user');
            }
            $data = array(
                'title' => xss_clean($this->request->getVar('title')),
                'image' => $image_name,
                'created_by' => $user_data["user_id"]
            );
            $return = $this->manage->save_galleryimages($data);
            if ($return) {
                echo json_encode(['status' => true, 'message' => 'Gallery image saved successfully.']);
            } else {
                echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
            }
        }
    }

    public function edit_images_gallery($id)
    {
        $id = base64_decode($id);
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $data['data'] =  $this->manage->edit_images_gallery($id);
        $data['color'] =  getThemeColor($user_data["user_id"]);
        $data['title'] = "Edit image gallery";
        return view('manage/edit_image', $data);
    }

    public function update_images_gallery($id = null)
    {

        $validation =  \Config\Services::validation();
        if (!$this->validate([
            //'title' => 'required',
            //'title' => 'required|is_unique[seo_images_gallery.title]',
            'title' => 'required|is_unique[seo_images_gallery.title,id,{id}]',
            //'gallery_image' => 'uploaded[gallery_image]|mime_in[userfile,image/jpg,image/jpeg,image/gif,image/png,image/webp]',            
        ])) {
            echo json_encode(['status' => false, 'validation' => true, 'message' => $validation->getError()]);
        } else {
            $image_name = NULL;
            $file = $this->request->getFile('gallery_image');
            if (!empty($file) && $file->isValid()) {
                $image_name = $file->getRandomName();
                $file->move("public/uploads/gallery_images/", $image_name);
            }

            if ($this->session->has('login_user')) {
                $user_data = $this->session->get('login_user');
            }

            $data = array(
                'title' => xss_clean($this->request->getVar('title')),
                'image' => $image_name,
                'created_by' => $user_data["user_id"]
            );
            $data = array_filter($data);
            $return = $this->images_model->update($id, $data);

            if ($return) {
                echo json_encode(['status' => true, 'message' => 'Gallery image updated successfully.']);
            } else {
                echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
            }
        }
    }

    function check_title($title = null, $id = null)
    {
        echo 1;
        exit;
    }



    public function delete_galleryimages($id)
    {
        $return = $this->manage->delete_galleryimages($id);
        if ($return) {
            echo json_encode(['status' => true, 'message' => 'Gallery image details deleted successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function video_gallery()
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $data['data'] =  $this->manage->video_gallery($user_data["user_id"]);
        $data['color'] =  getThemeColor($user_data["user_id"]);
        $data['title'] = "Video Gallery";
        return view('manage/video_gallery', $data);
    }

    public function add_video_gallery()
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $data['color'] =  getThemeColor($user_data["user_id"]);
        $data['title'] = "Upload Gallery Video ";
        return view('manage/add_video', $data);
    }

    public function save_galleryvideo()
    {
        $validation =  \Config\Services::validation();

        if (!$this->validate([
            'title' => 'is_unique[seo_videos_gallery.title]',
        ])) {
            echo json_encode(['status' => false, 'validation' => true, 'message' => $validation->getError()]);
        } else {

            if ($this->session->has('login_user')) {
                $user_data = $this->session->get('login_user');
            }

            $image_name = null;
            $file = $this->request->getFile('thumbnail');
            if (!empty($file) && $file->isValid()) {
                $image_name = $file->getRandomName();
                $file->move("public/uploads/thumbnail_images/", $image_name);
            }

            $data = array(
                'title' => xss_clean($this->request->getVar('title')),
                'url' => xss_clean($this->request->getVar('videoUrl')),
                'created_by' => $user_data["user_id"],
                'thumbnail_images' => $image_name
            );
            $return = $this->manage->save_galleryvideo($data);
            if ($return) {
                echo json_encode(['status' => true, 'message' => 'Gallery video saved successfully.']);
            } else {
                echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
            }
        }
    }

    public function delete_galleryvideo($id)
    {
        $return = $this->manage->delete_galleryvideo($id);
        if ($return) {
            echo json_encode(['status' => true, 'message' => 'Video record deleted successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function testimonials()
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $data['data'] =  $this->manage->testimonials($user_data["user_id"]);
        $data['color'] =  getThemeColor($user_data["user_id"]);
        $data['title'] = "Testimonials";
        return view('manage/testimonials', $data);
    }

    public function add_testimonials()
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $data['color'] =  getThemeColor($user_data["user_id"]);
        $data['title'] = "Add Testimonials";
        return view('manage/add_testimonials', $data);
    }

    public function save_testimonials()
    {
        $validation =  \Config\Services::validation();

        if (!$this->validate([
            'name' => 'required|is_unique[seo_testimonial.name]',
        ])) {
            echo json_encode(['status' => false, 'validation' => true, 'message' => $validation->getErrors()]);
        } else {
            if ($this->session->has('login_user')) {
                $user_data = $this->session->get('login_user');
            }

            $image_name = null;
            $file = $this->request->getFile('testimonials_image');
            if (!empty($file) && $file->isValid()) {
                $image_name = $file->getRandomName();
                $file->move("public/uploads/testimonial_images/", $image_name);
            }

            $data = array(
                'name' => xss_clean($this->request->getVar('name')),
                'description' => xss_clean($this->request->getVar('description')),
                'image' => $image_name,
                'created_by' => $user_data["user_id"]
            );

            $return = $this->manage->save_testimonials($data);
            if ($return) {
                echo json_encode(['status' => true, 'message' => 'Testimonial saved successfully.']);
            } else {
                echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
            }
        }
    }

    public function edit_testimonials($id)
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $data['data'] =  $this->manage->edit_testimonials($id);
        $data['color'] =  getThemeColor($user_data["user_id"]);
        $data['title'] = "Edit Testimonials";
        return view('manage/edit_testimonials', $data);
    }

    public function update_testimonials($id)
    {
        $validation =  \Config\Services::validation();
        if (!$this->validate([
            'name' => 'required|is_unique[seo_testimonial.name,id,{id}]',
        ])) {
            echo json_encode(['status' => false, 'validation' => true, 'message' => $validation->getError()]);
        } else {

            if ($this->session->has('login_user')) {
                $user_data = $this->session->get('login_user');
            }

            $image_name = null;
            $file = $this->request->getFile('testimonials_image');
            if (!empty($file) && $file->isValid()) {
                $image_name = $file->getRandomName();
                $file->move("public/uploads/testimonial_images/", $image_name);
            }

            $data = array(
                'name' => xss_clean($this->request->getVar('name')),
                'description' => xss_clean($this->request->getVar('description')),
                'image' => $image_name,
                'update_by' => $user_data["user_id"],
                'updated_at' => date("Y-m-d H:i:s")
            );
            $data = array_filter($data);
            $return = $this->manage->update_testimonials($data, $id);
            if ($return) {
                echo json_encode(['status' => true, 'message' => 'Testimonial updated successfully.']);
            } else {
                echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
            }
        }
    }

    public function delete_testimonials($id)
    {
        $return = $this->manage->delete_testimonials($id);
        if ($return) {
            echo json_encode(['status' => true, 'message' => 'Testimonial deleted successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function faqs()
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $data['data'] =  $this->manage->faqs($user_data["user_id"]);
        $data['color'] =  getThemeColor($user_data["user_id"]);
        $data['title'] = "Faq's";
        return view('manage/faqs', $data);
    }

    public function add_faqs()
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $data['data'] =  $this->manage->faqs($user_data["user_id"]);
        $data['color'] =  getThemeColor($user_data["user_id"]);
        $data['title'] = "Add Faq's";
        return view('manage/add_faqs', $data);
    }

    public function save_faqs()
    {
        $validation =  \Config\Services::validation();
        if (!$this->validate([
            'title' => 'is_unique[seo_faqs.title]',
        ])) {
            echo json_encode(['status' => false, 'validation' => true, 'message' => $validation->getError()]);
        } else {
            if ($this->session->has('login_user')) {
                $user_data = $this->session->get('login_user');
            }

            $data = array(
                'title' => xss_clean($this->request->getVar('title')),
                'content' => xss_clean($this->request->getVar('content')),
                'created_by' => $user_data["user_id"]
            );
            $return = $this->manage->save_faqs($data);
            if ($return) {
                echo json_encode(['status' => true, 'message' => 'Faqs saved successfully.']);
            } else {
                echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
            }
        }
    }

    public function delete_faqs($id)
    {
        $return = $this->manage->delete_faqs($id);
        if ($return) {
            echo json_encode(['status' => true, 'message' => 'Faqs deleted successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function edit_faqs($id)
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $data['data'] =  $this->manage->edit_faqs($id);
        $data['color'] =  getThemeColor($user_data["user_id"]);
        $data['title'] = "Edit Faq's";
        return view('manage/edit_faqs', $data);
    }

    public function update_faqs($id)
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $data = array(
            'title' => xss_clean($this->request->getVar('title')),
            'content' => xss_clean($this->request->getVar('content')),
            'updated_by' => $user_data["user_id"],
            'updated_at' => date("Y-m-d H:i:s")
        );
        $return = $this->manage->update_faqs($data, $id);
        if ($return) {
            echo json_encode(['status' => true, 'message' => 'Faqs updated successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function images_section()
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $data['data'] =  $this->manage->images_section($user_data["user_id"]);
        $data['pages'] =  $this->manage->get_menu_pages($user_data["user_id"]);
        $data['images'] =  $this->manage->images_gallery($user_data["user_id"]);
        $data['color'] =  getThemeColor($user_data["user_id"]);
        $data['title'] = "Image Gallery Section";
        return view('manage/images_section', $data);
    }

    public function save_image_section()
    {
        $validation =  \Config\Services::validation();
        if (!$this->validate([
            'heading' => 'is_unique[seo_images_section.heading]',
        ])) {
            echo json_encode(['status' => false, 'validation' => true, 'message' => $validation->getError()]);
        } else {
            if ($this->session->has('login_user')) {
                $user_data = $this->session->get('login_user');
            }

            $images =  $this->request->getVar('images');
            $images = json_encode($images);
            $pages =  $this->request->getVar('pages');
            foreach ($pages as $value) {
                $testarr = explode(",", $value);
                if ($testarr[0] == 3) {
                    $sub_menu_title = $this->manage->get_serviceName($testarr[1]);
                    $sub_menu_title = "Service -" . $sub_menu_title;
                } else if ($testarr[0] == 4) {
                    $sub_menu_title = $this->manage->get_productName($testarr[1]);
                    $sub_menu_title = "Products -" . $sub_menu_title;
                } else {
                    $sub_menu_title = $this->manage->get_menuName($testarr[0]);
                }
                $arr[] = [
                    "menu" => $testarr[0],
                    "sub_menu" => $testarr[1],
                    "sub_menu_title" => $sub_menu_title
                ];
            }

            $data = array(
                'heading' => xss_clean($this->request->getVar('heading')),
                'images' => $images,
                'pages' =>  json_encode($arr),
                'created_by' => $user_data["user_id"]
            );
            $return = $this->manage->save_image_section($data);
            if ($return) {
                echo json_encode(['status' => true, 'message' => 'Image gallery section saved successfully.']);
            } else {
                echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
            }
        }
    }

    public function edit_image_section($id)
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $data = $this->manage->edit_image_section($id);
        if ($data) {
            echo json_encode(['status' => true, 'data' => $data]);
        } else {
            echo json_encode(['status' => false, 'message' => 'No data found']);
        }
    }

    public function update_image_section($id)
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }

        $images =  $this->request->getVar('images');
        $images = json_encode($images);
        $pages =  $this->request->getVar('pages');
        foreach ($pages as $value) {
            $testarr = explode(",", $value);
            if ($testarr[0] == 3) {
                $sub_menu_title = $this->manage->get_serviceName($testarr[1]);
                $sub_menu_title = "Service -" . $sub_menu_title;
            } else if ($testarr[0] == 4) {
                $sub_menu_title = $this->manage->get_productName($testarr[1]);
                $sub_menu_title = "Products -" . $sub_menu_title;
            } else {
                $sub_menu_title = $this->manage->get_menuName($testarr[0]);
            }
            $arr[] = [
                "menu" => $testarr[0],
                "sub_menu" => $testarr[1],
                "sub_menu_title" => $sub_menu_title
            ];
        }

        $data = array(
            'heading' => xss_clean($this->request->getVar('heading')),
            'images' => $images,
            'pages' =>  json_encode($arr),
            'update_by' => $user_data["user_id"],
            'updated_at' => date("Y-m-d H:i:s")
        );
        $return = $this->manage->update_image_section($data, $id);
        if ($return) {
            echo json_encode(['status' => true, 'message' => 'Image fallery section updated successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function delete_image_section($id)
    {
        $return = $this->manage->delete_image_section($id);
        if ($return) {
            echo json_encode(['status' => true, 'message' => 'Record deleted successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function get_image_section()
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $data['data'] =  $this->manage->images_section($user_data["user_id"]);
        $data['pages'] =  $this->manage->get_menu_pages($user_data["user_id"]);
        $data['images'] =  $this->manage->images_gallery($user_data["user_id"]);
        if ($data) {
            echo json_encode(['status' => true, 'return' => $data]);
        } else {
            echo json_encode(['status' => false, 'message' => 'No data found']);
        }
    }

    public function video_section()
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $data['data'] =  $this->manage->video_section($user_data["user_id"]);
        $data['pages'] =  $this->manage->get_menu_pages($user_data["user_id"]);
        $data['video'] =  $this->manage->video_gallery($user_data["user_id"]);
        $data['color'] =  getThemeColor($user_data["user_id"]);
        $data['title'] = "Video Gallery Section";
        return view('manage/video_section', $data);
    }

    public function save_video_section()
    {
        $validation =  \Config\Services::validation();
        if (!$this->validate([
            'heading' => 'is_unique[seo_video_section.heading]',
        ])) {
            echo json_encode(['status' => false, 'validation' => true, 'message' => $validation->getError()]);
        } else {
            if ($this->session->has('login_user')) {
                $user_data = $this->session->get('login_user');
            }

            $videos =  $this->request->getVar('videos');
            $videos = json_encode($videos);
            $pages =  $this->request->getVar('pages');
            foreach ($pages as $value) {
                $testarr = explode(",", $value);
                if ($testarr[0] == 3) {
                    $sub_menu_title = $this->manage->get_serviceName($testarr[1]);
                    $sub_menu_title = "Service -" . $sub_menu_title;
                } else if ($testarr[0] == 4) {
                    $sub_menu_title = $this->manage->get_productName($testarr[1]);
                    $sub_menu_title = "Products -" . $sub_menu_title;
                } else {
                    $sub_menu_title = $this->manage->get_menuName($testarr[0]);
                }
                $arr[] = [
                    "menu" => $testarr[0],
                    "sub_menu" => $testarr[1],
                    "sub_menu_title" => $sub_menu_title
                ];
            }

            $data = array(
                'heading' => xss_clean($this->request->getVar('heading')),
                'videos' => $videos,
                'pages' =>  json_encode($arr),
                'created_by' => $user_data["user_id"]
            );
            $return = $this->manage->save_video_section($data);
            if ($return) {
                echo json_encode(['status' => true, 'message' => 'Videos gallery section saved successfully.']);
            } else {
                echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
            }
        }
    }

    public function delete_video_section($id)
    {
        $return = $this->manage->delete_video_section($id);
        if ($return) {
            echo json_encode(['status' => true, 'message' => 'Video deleted successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function edit_video_section($id)
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $data = $this->manage->edit_video_section($id);
        if ($data) {
            echo json_encode(['status' => true, 'data' => $data]);
        } else {
            echo json_encode(['status' => false, 'message' => 'No data found']);
        }
    }

    public function update_video_section($id)
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }

        $videos =  $this->request->getVar('videos');
        $videos = json_encode($videos);
        $pages =  $this->request->getVar('pages');
        foreach ($pages as $value) {
            $testarr = explode(",", $value);
            if ($testarr[0] == 3) {
                $sub_menu_title = $this->manage->get_serviceName($testarr[1]);
                $sub_menu_title = "Service -" . $sub_menu_title;
            } else if ($testarr[0] == 4) {
                $sub_menu_title = $this->manage->get_productName($testarr[1]);
                $sub_menu_title = "Products -" . $sub_menu_title;
            } else {
                $sub_menu_title = $this->manage->get_menuName($testarr[0]);
            }
            $arr[] = [
                "menu" => $testarr[0],
                "sub_menu" => $testarr[1],
                "sub_menu_title" => $sub_menu_title
            ];
        }

        $data = array(
            'heading' => xss_clean($this->request->getVar('heading')),
            'videos' => $videos,
            'pages' =>  json_encode($arr),
            'update_by' => $user_data["user_id"],
            'updated_at' => date("Y-m-d H:i:s")
        );
        $return = $this->manage->update_video_section($data, $id);
        if ($return) {
            echo json_encode(['status' => true, 'message' => 'Videos gallery section updated successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function banner_section()
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $data['data'] =  $this->manage->banner_section($user_data["user_id"]);
        $data['pages'] =  $this->manage->get_menu_pages($user_data["user_id"]);
        $data['color'] =  getThemeColor($user_data["user_id"]);
        $data['title'] = "Update Banner";
        return view('manage/banner_section', $data);
    }

    public function save_banner_section()
    {
        $validation =  \Config\Services::validation();
        if (!$this->validate([
            'banner_image' => 'uploaded[banner_image]',
        ])) {
            echo json_encode(['status' => false, 'validation' => true, 'message' => $validation->getError()]);
        } else {
            $file_name = NULL;
            $file = $this->request->getFile('banner_image');
            if ($file->isValid()) {
                $file_name = $file->getRandomName();
                $file->move("public/uploads/banner_images", $file_name);
            }
            if ($this->session->has('login_user')) {
                $user_data = $this->session->get('login_user');
            }
            $pages =  $this->request->getVar('page_id');
            foreach ($pages as $value) {
                $testarr = explode(",", $value);
                if ($testarr[0] == 3) {
                    $sub_menu_title = $this->manage->get_serviceName($testarr[1]);
                    $sub_menu_title = "Service -" . $sub_menu_title;
                } else if ($testarr[0] == 4) {
                    $sub_menu_title = $this->manage->get_productName($testarr[1]);
                    $sub_menu_title = "Products -" . $sub_menu_title;
                } else {
                    $sub_menu_title = $this->manage->get_menuName($testarr[0]);
                }
                $arr[] = [
                    "menu" => $testarr[0],
                    "sub_menu" => $testarr[1],
                    "sub_menu_title" => $sub_menu_title
                ];
            }


            $data = array(
                'banner_name' => xss_clean($this->request->getVar('banner_name')),
                'content' => xss_clean($this->request->getVar('content')),
                'page_id' =>  json_encode($arr),
                'banner_image' => $file_name,
                'created_by' => $user_data["user_id"]
            );
            $return = $this->manage->save_banner_section($data);
            if ($return) {
                echo json_encode(['status' => true, 'message' => 'Banner record saved successfully.']);
            } else {
                echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
            }
        }
    }

    public function edit_banner_section($id)
    {
        $data = $this->manage->edit_banner_section($id);
        if ($data) {
            echo json_encode(['status' => true, 'data' => $data]);
        } else {
            echo json_encode(['status' => false, 'message' => 'No data found']);
        }
    }

    public function update_banner_section($id)
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }

        $pages =  $this->request->getVar('page_id');
        foreach ($pages as $value) {
            $testarr = explode(",", $value);
            if ($testarr[0] == 3) {
                $sub_menu_title = $this->manage->get_serviceName($testarr[1]);
                $sub_menu_title = "Service -" . $sub_menu_title;
            } else if ($testarr[0] == 4) {
                $sub_menu_title = $this->manage->get_productName($testarr[1]);
                $sub_menu_title = "Products -" . $sub_menu_title;
            } else {
                $sub_menu_title = $this->manage->get_menuName($testarr[0]);
            }
            $arr[] = [
                "menu" => $testarr[0],
                "sub_menu" => $testarr[1],
                "sub_menu_title" => $sub_menu_title
            ];
        }

        $file_name = NULL;
        $file = $this->request->getFile('banner_image');
        if ($file->isValid()) {
            $file_name = $file->getRandomName();
            $file->move("public/uploads/banner_images", $file_name);
        }

        $data = array(
            'banner_name' => xss_clean($this->request->getVar('banner_name')),
            'content' => xss_clean($this->request->getVar('content')),
            'page_id' =>  json_encode($arr),
            'banner_image' => $file_name,
            'updated_by' => $user_data["user_id"],
            'updated_at' => date("Y-m-d H:i:s")
        );

        if (empty($data['banner_image'])) {
            unset($data['banner_image']);
        }

        $return = $this->manage->update_banner_section($data, $id);
        if ($return) {
            echo json_encode(['status' => true, 'message' => 'Banner updated successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function delete_banner_section($id)
    {
        $return = $this->manage->delete_banner_section($id);
        if ($return) {
            echo json_encode(['status' => true, 'message' => 'Banner record deleted successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function getbanner_section()
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $data =  $this->manage->banner_section($user_data["user_id"]);
        if ($data) {
            echo json_encode(['status' => true, 'data' => $data]);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function testimonials_section()
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $data['data'] =  $this->manage->testimonials_section($user_data["user_id"]);
        $data['pages'] =  $this->manage->get_menu_pages($user_data["user_id"]);
        $data['testimonials'] =  $this->manage->testimonials($user_data["user_id"]);
        $data['color'] =  getThemeColor($user_data["user_id"]);
        $data['title'] = "Testimonials Section";
        return view('manage/testimonials_section', $data);
    }

    public function save_testimonials_section()
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $testimonials =  $this->request->getVar('testimonials');
        $testimonials = json_encode($testimonials);

        $pages =  $this->request->getVar('pages_ids');
        foreach ($pages as $value) {
            $testarr = explode(",", $value);
            if ($testarr[0] == 3) {
                $sub_menu_title = $this->manage->get_serviceName($testarr[1]);
                $sub_menu_title = "Service -" . $sub_menu_title;
            } else if ($testarr[0] == 4) {
                $sub_menu_title = $this->manage->get_productName($testarr[1]);
                $sub_menu_title = "Products -" . $sub_menu_title;
            } else {
                $sub_menu_title = $this->manage->get_menuName($testarr[0]);
            }
            $arr[] = [
                "menu" => $testarr[0],
                "sub_menu" => $testarr[1],
                "sub_menu_title" => $sub_menu_title
            ];
        }


        $data = array(
            'heading' => xss_clean($this->request->getVar('heading')),
            'testimonials' => $testimonials,
            'pages_ids' =>  json_encode($arr),
            'created_by' => $user_data["user_id"]
        );
        $return = $this->manage->save_testimonials_section($data);
        if ($return) {
            echo json_encode(['status' => true, 'message' => 'Testimonials section record saved successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function edit_testimonials_section($id)
    {
        $data = $this->manage->edit_testimonials_section($id);
        if ($data) {
            echo json_encode(['status' => true, 'data' => $data]);
        } else {
            echo json_encode(['status' => false, 'message' => 'No data found']);
        }
    }

    public function update_testimonials_section($id)
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $testimonials =  $this->request->getVar('testimonials');
        $testimonials = json_encode($testimonials);

        $pages =  $this->request->getVar('pages_ids');
        foreach ($pages as $value) {
            $testarr = explode(",", $value);
            if ($testarr[0] == 3) {
                $sub_menu_title = $this->manage->get_serviceName($testarr[1]);
                $sub_menu_title = "Service -" . $sub_menu_title;
            } else if ($testarr[0] == 4) {
                $sub_menu_title = $this->manage->get_productName($testarr[1]);
                $sub_menu_title = "Products -" . $sub_menu_title;
            } else {
                $sub_menu_title = $this->manage->get_menuName($testarr[0]);
            }
            $arr[] = [
                "menu" => $testarr[0],
                "sub_menu" => $testarr[1],
                "sub_menu_title" => $sub_menu_title
            ];
        }
        $data = array(
            'heading' => xss_clean($this->request->getVar('heading')),
            'testimonials' => $testimonials,
            'pages_ids' =>  json_encode($arr),
            'update_by' => $user_data["user_id"],
            'updated_at' => date("Y-m-d H:i:s")
        );
        $return = $this->manage->update_testimonials_section($data, $id);
        if ($return) {
            echo json_encode(['status' => true, 'message' => 'Testimonials record updated successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function delete_testimonials_section($id)
    {
        $return = $this->manage->delete_testimonials_section($id);
        if ($return) {
            echo json_encode(['status' => true, 'message' => 'Testimonials record deleted successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function faqs_section()
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $data['data'] =  $this->manage->faqs_section($user_data["user_id"]);
        $data['pages'] =  $this->manage->get_menu_pages($user_data["user_id"]);
        $data['faqs'] =  $this->manage->faqs($user_data["user_id"]);
        $data['color'] =  getThemeColor($user_data["user_id"]);
        $data['title'] = "Faqs Section";
        return view('manage/faqs_section', $data);
    }

    public function save_faqs_section()
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $faqs_ids =  $this->request->getVar('faqs_ids');
        $faqs_ids = json_encode($faqs_ids);

        $pages =  $this->request->getVar('pages_id');
        foreach ($pages as $value) {
            $testarr = explode(",", $value);
            if ($testarr[0] == 3) {
                $sub_menu_title = $this->manage->get_serviceName($testarr[1]);
                $sub_menu_title = "Service -" . $sub_menu_title;
            } else if ($testarr[0] == 4) {
                $sub_menu_title = $this->manage->get_productName($testarr[1]);
                $sub_menu_title = "Products -" . $sub_menu_title;
            } else {
                $sub_menu_title = $this->manage->get_menuName($testarr[0]);
            }
            $arr[] = [
                "menu" => $testarr[0],
                "sub_menu" => $testarr[1],
                "sub_menu_title" => $sub_menu_title
            ];
        }

        $data = array(
            'heading' => xss_clean($this->request->getVar('heading')),
            'faqs_ids' => $faqs_ids,
            'pages_id' =>  json_encode($arr),
            'created_by' => $user_data["user_id"]
        );
        $return = $this->manage->save_faqs_section($data);
        if ($return) {
            echo json_encode(['status' => true, 'message' => 'Faqs record saved successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function edit_faqs_section($id)
    {
        $data = $this->manage->edit_faqs_section($id);
        if ($data) {
            echo json_encode(['status' => true, 'data' => $data]);
        } else {
            echo json_encode(['status' => false, 'message' => 'No data found']);
        }
    }

    public function update_faqs_section($id)
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $faqs_ids =  $this->request->getVar('faqs_ids');
        $faqs_ids = json_encode($faqs_ids);
        $pages =  $this->request->getVar('pages_id');
        foreach ($pages as $value) {
            $testarr = explode(",", $value);
            if ($testarr[0] == 3) {
                $sub_menu_title = $this->manage->get_serviceName($testarr[1]);
                $sub_menu_title = "Service -" . $sub_menu_title;
            } else if ($testarr[0] == 4) {
                $sub_menu_title = $this->manage->get_productName($testarr[1]);
                $sub_menu_title = "Products -" . $sub_menu_title;
            } else {
                $sub_menu_title = $this->manage->get_menuName($testarr[0]);
            }
            $arr[] = [
                "menu" => $testarr[0],
                "sub_menu" => $testarr[1],
                "sub_menu_title" => $sub_menu_title
            ];
        }

        $data = array(
            'heading' => xss_clean($this->request->getVar('heading')),
            'faqs_ids' => $faqs_ids,
            'pages_id' =>  json_encode($arr),
            'update_by' => $user_data["user_id"],
            'updated_at' => date("Y-m-d H:i:s")
        );
        $return = $this->manage->update_faqs_section($data, $id);
        if ($return) {
            echo json_encode(['status' => true, 'message' => 'Faqs record updated successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function delete_faqs_section($id)
    {
        $return = $this->manage->delete_faqs_section($id);
        if ($return) {
            echo json_encode(['status' => true, 'message' => 'Faqs record deleted successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function post_section()
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $post_model = new PostsModel();
        $data['data'] =  $this->manage->post_section($user_data["user_id"]);
        $data['pages'] =  $this->manage->get_menu_pages($user_data["user_id"]);
        $data['posts_updates'] = $post_model->select(['id', 'title'])->findAll();
        $data['color'] =  getThemeColor($user_data["user_id"]);
        $data['title'] = "Posts Section";
        return view('manage/post_section', $data);
    }

    public function save_post_section()
    {

        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }

        $pages =  $this->request->getVar('pages_id');
        foreach ($pages as $value) {
            $testarr = explode(",", $value);
            if ($testarr[0] == 3) {
                $sub_menu_title = $this->manage->get_serviceName($testarr[1]);
                $sub_menu_title = "Service -" . $sub_menu_title;
            } else if ($testarr[0] == 4) {
                $sub_menu_title = $this->manage->get_productName($testarr[1]);
                $sub_menu_title = "Products -" . $sub_menu_title;
            } else {
                $sub_menu_title = $this->manage->get_menuName($testarr[0]);
            }
            $arr[] = [
                "menu" => $testarr[0],
                "sub_menu" => $testarr[1],
                "sub_menu_title" => $sub_menu_title
            ];
        }

        $post_ids =  $this->request->getVar('postIds');
        $post_ids = json_encode($post_ids);

        $data = array(
            'heading' => xss_clean($this->request->getVar('heading')),
            'pages_id' => json_encode($arr),
            'post_id'  => $post_ids,
            'created_by' => $user_data["user_id"]
        );
        $return = $this->manage->save_post_section($data);
        if ($return) {
            echo json_encode(['status' => true, 'message' => 'Post record saved successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function edit_post_section($id)
    {

        $data = $this->manage->edit_post_section($id);
        if ($data) {
            echo json_encode(['status' => true, 'data' => $data]);
        } else {
            echo json_encode(['status' => false, 'message' => 'No data found']);
        }
    }

    public function update_post_section($id)
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }

        $pages =  $this->request->getVar('pages_id');
        foreach ($pages as $value) {
            $testarr = explode(",", $value);
            if ($testarr[0] == 3) {
                $sub_menu_title = $this->manage->get_serviceName($testarr[1]);
                $sub_menu_title = "Service -" . $sub_menu_title;
            } else if ($testarr[0] == 4) {
                $sub_menu_title = $this->manage->get_productName($testarr[1]);
                $sub_menu_title = "Products -" . $sub_menu_title;
            } else {
                $sub_menu_title = $this->manage->get_menuName($testarr[0]);
            }
            $arr[] = [
                "menu" => $testarr[0],
                "sub_menu" => $testarr[1],
                "sub_menu_title" => $sub_menu_title
            ];
        }

        $post_ids =  $this->request->getVar('postIds');
        $post_ids = json_encode($post_ids);

        $data = array(
            'heading' => xss_clean($this->request->getVar('heading')),
            'post_id'  => $post_ids,
            'pages_id' => json_encode($arr),
            'updated_by' => $user_data["user_id"],
            'updated_at' => date("Y-m-d H:i:s")
        );
        $return = $this->manage->update_post_section($data, $id);
        if ($return) {
            echo json_encode(['status' => true, 'message' => 'Post record updated successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function delete_post_section($id)
    {
        $return = $this->manage->delete_post_section($id);
        if ($return) {
            echo json_encode(['status' => true, 'message' => 'Post record deleted successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function mlc_section()
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $data['data'] =  $this->manage->mlc_section($user_data["user_id"]);
        $data['mcl'] =  $this->manage->mlc($user_data["user_id"]);
        $data['pages'] =  $this->manage->get_menu_pages($user_data["user_id"]);
        $data['color'] =  getThemeColor($user_data["user_id"]);
        $data['title'] = "MLC Section";
        return view('manage/mlc_section', $data);
    }

    public function save_mlc_section()
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $mlc_ids =  $this->request->getVar('mlc_ids');
        $mlc_ids = json_encode($mlc_ids);
        $pages =  $this->request->getVar('pages');
        foreach ($pages as $value) {
            $testarr = explode(",", $value);
            if ($testarr[0] == 3) {
                $sub_menu_title = $this->manage->get_serviceName($testarr[1]);
                $sub_menu_title = "Service -" . $sub_menu_title;
            } else if ($testarr[0] == 4) {
                $sub_menu_title = $this->manage->get_productName($testarr[1]);
                $sub_menu_title = "Products -" . $sub_menu_title;
            } else {
                $sub_menu_title = $this->manage->get_menuName($testarr[0]);
            }
            $arr[] = [
                "menu" => $testarr[0],
                "sub_menu" => $testarr[1],
                "sub_menu_title" => $sub_menu_title
            ];
        }
        $data = array(
            'heading' => xss_clean($this->request->getVar('heading')),
            'mlc_ids' =>  $mlc_ids,
            'pages' =>  json_encode($arr),
            'created_by' => $user_data["user_id"]
        );
        $return = $this->manage->save_mlc_section($data);
        if ($return) {
            echo json_encode(['status' => true, 'message' => 'MLC record saved successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function delete_mlc_section($id)
    {
        $return = $this->manage->delete_mlc_section($id);
        if ($return) {
            echo json_encode(['status' => true, 'message' => 'MLC record deleted successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function edit_mlc_section($id)
    {
        $data = $this->manage->edit_mlc_section($id);
        if ($data) {
            echo json_encode(['status' => true, 'data' => $data]);
        } else {
            echo json_encode(['status' => false, 'message' => 'No data found']);
        }
    }

    public function update_mlc_section($id)
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }

        $mlc_ids =  $this->request->getVar('mlc_ids');
        $mlc_ids = json_encode($mlc_ids);
        $pages =  $this->request->getVar('pages');
        foreach ($pages as $value) {
            $testarr = explode(",", $value);
            if ($testarr[0] == 3) {
                $sub_menu_title = $this->manage->get_serviceName($testarr[1]);
                $sub_menu_title = "Service -" . $sub_menu_title;
            } else if ($testarr[0] == 4) {
                $sub_menu_title = $this->manage->get_productName($testarr[1]);
                $sub_menu_title = "Products -" . $sub_menu_title;
            } else {
                $sub_menu_title = $this->manage->get_menuName($testarr[0]);
            }
            $arr[] = [
                "menu" => $testarr[0],
                "sub_menu" => $testarr[1],
                "sub_menu_title" => $sub_menu_title
            ];
        }

        $data = array(
            'heading' => xss_clean($this->request->getVar('heading')),
            'mlc_ids' =>  $mlc_ids,
            'pages' =>  json_encode($arr),
            'update_by' => $user_data["user_id"],
            'updated_at' => date("Y-m-d H:i:s")
        );
        $return = $this->manage->update_mlc_section($data, $id);
        if ($return) {
            echo json_encode(['status' => true, 'message' => 'MLC record updated successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function business_section()
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $data['data'] =  $this->manage->business_section($user_data["user_id"]);
        $data['pages'] =  $this->manage->get_menu_pages($user_data["user_id"]);
        $data['color'] =  getThemeColor($user_data["user_id"]);
        $data['title'] = "Business Query Section";
        return view('manage/business_section', $data);
    }

    public function save_business_section()
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $pages =  $this->request->getVar('pages_id');
        foreach ($pages as $value) {
            $testarr = explode(",", $value);
            if ($testarr[0] == 3) {
                $sub_menu_title = $this->manage->get_serviceName($testarr[1]);
                $sub_menu_title = "Service -" . $sub_menu_title;
            } else if ($testarr[0] == 4) {
                $sub_menu_title = $this->manage->get_productName($testarr[1]);
                $sub_menu_title = "Products -" . $sub_menu_title;
            } else {
                $sub_menu_title = $this->manage->get_menuName($testarr[0]);
            }
            $arr[] = [
                "menu" => $testarr[0],
                "sub_menu" => $testarr[1],
                "sub_menu_title" => $sub_menu_title
            ];
        }

        $data = array(
            'heading' => xss_clean($this->request->getVar('heading')),
            'pages_id' =>  json_encode($arr),
            'created_by' => $user_data["user_id"]
        );
        $return = $this->manage->save_business_section($data);
        if ($return) {
            echo json_encode(['status' => true, 'message' => 'Business query record saved successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function edit_business_section($id)
    {
        $data = $this->manage->edit_business_section($id);
        if ($data) {
            echo json_encode(['status' => true, 'data' => $data]);
        } else {
            echo json_encode(['status' => false, 'message' => 'No data found']);
        }
    }

    public function update_business_section($id)
    {
        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        $pages =  $this->request->getVar('pages_id');
        foreach ($pages as $value) {
            $testarr = explode(",", $value);
            if ($testarr[0] == 3) {
                $sub_menu_title = $this->manage->get_serviceName($testarr[1]);
                $sub_menu_title = "Service -" . $sub_menu_title;
            } else if ($testarr[0] == 4) {
                $sub_menu_title = $this->manage->get_productName($testarr[1]);
                $sub_menu_title = "Products -" . $sub_menu_title;
            } else {
                $sub_menu_title = $this->manage->get_menuName($testarr[0]);
            }
            $arr[] = [
                "menu" => $testarr[0],
                "sub_menu" => $testarr[1],
                "sub_menu_title" => $sub_menu_title
            ];
        }
        $data = array(
            'heading' => xss_clean($this->request->getVar('heading')),
            'pages_id' =>  json_encode($arr),
            'updated_by' => $user_data["user_id"],
            'updated_at' => date("Y-m-d H:i:s")
        );
        $return = $this->manage->update_business_section($data, $id);
        if ($return) {
            echo json_encode(['status' => true, 'message' => 'Business Query record updated successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function delete_business_section($id)
    {
        $return = $this->manage->delete_business_section($id);
        if ($return) {
            echo json_encode(['status' => true, 'message' => 'Business Query record deleted successfully.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Their is some problem. Please try again.']);
        }
    }

    public function get_arrange_section($menuid = 0, $second_id = 0, $fetch_by_submenu="N") {

        if ($this->session->has('login_user')) {
            $user_data = $this->session->get('login_user');
        }
        if($fetch_by_submenu=="N"){
            $old_arrange = $this->manage->get_arranged_section($menuid, $second_id, $user_data["user_id"]);
        }else{

            $final_results = [];
            //Get slider data form custom arrange table
            $results = $this->custom_arrange_model
            ->select(['title', 'section_id', 'menu_id', 'submenu_id', 'section_title'])
            ->where(['menu_id' => $menuid, 'submenu_id' => $second_id])
            ->findAll();

            $final_results = $results;
           

            //Get New slider data in get slider section tables
            $page_arranges = getPageSlider($menuid, $second_id);
            
            $custom_page_data = getPageCustomSection($menuid, $second_id);
            if(!empty($custom_page_data)){
                $page_arranges = array_merge($page_arranges, $custom_page_data);
            }

            $old_arrange = $page_arranges;
            if(count($final_results)>0){
                $final_results = array_merge($final_results, $page_arranges);
                $final_results = array_values(array_column($final_results , null, 'section_id'));
                $old_arrange = $final_results;
            }
            
            //Return data for view 
            $old_arrange = json_decode(json_encode($old_arrange), false);        
        }

        
        if($old_arrange){
            echo json_encode(['status' => true, 'old_arrange' => $old_arrange]);
        } else {
            echo json_encode(['status' => false, 'message' => 'No data found']);
        }
    }

    public function custom_section_upload_image()
    {

        $file_name = NULL;
        $file = $this->request->getFile('upload_image');
        if (!empty($_FILES['upload_image']['name'])) {
            $file_name = $file->getRandomName();
            $file->move('public/uploads/custom_images', $file_name);
        }
        echo json_encode(['status' => true, 'path' => $file_name]);
    }

    public function banner_image_upload()
    {
        $validation =  \Config\Services::validation();
        if (!$this->validate([
            'banner_image' => 'uploaded[banner_image]|max_dims[banner_image,1200,350]',
        ])) {
            echo json_encode(['status' => true, 'path' => "Banner Image width and height is more than required."]);
        } else {
            $file_name = rand() . $_FILES['banner_image']['name'];
            $filewithpath = "/assets/img/banner_image/" . $file_name;
            $file = $this->request->getFile('banner_image');
            $file->move('./assets/img/banner_image', $file_name);
            echo json_encode(['status' => true, 'path' => $filewithpath]);
        }
    }


    public function slider_image_upload()
    {
        $file_name = rand() . $_FILES['slider_image']['name'];
        $filewithpath = "/assets/img/slider_image/" . $file_name;
        $file = $this->request->getFile('slider_image');
        $file->move('./assets/img/slider_image', $file_name);
        echo json_encode(['status' => true, 'path' => $filewithpath]);
    }

    public function service_image_upload()
    {
        $file_name = rand() . $_FILES['service_image']['name'];
        $filewithpath = "/assets/img/service_image/" . $file_name;
        $file = $this->request->getFile('service_image');
        $file->move('./assets/img/service_image', $file_name);
        echo json_encode(['status' => true, 'path' => $filewithpath]);
    }

    public function service_banner_upload()
    {
        $file_name = rand() . $_FILES['service_banner']['name'];
        $filewithpath = "/assets/img/service_banner/" . $file_name;
        $file = $this->request->getFile('service_banner');
        $file->move('./assets/img/service_banner', $file_name);
        echo json_encode(['status' => true, 'path' => $filewithpath]);
    }

    public function product_image_upload()
    {
        $file_name = rand() . $_FILES['product_main_image']['name'];
        $filewithpath = "/assets/img/product_image/" . $file_name;
        $file = $this->request->getFile('product_main_image');
        $file->move('./assets/img/product_image', $file_name);
        echo json_encode(['status' => true, 'path' => $filewithpath]);
    }

    public function product_banner_upload()
    {
        $file_name = rand() . $_FILES['product_banner']['name'];
        $filewithpath = "/assets/img/product_banner/" . $file_name;
        $file = $this->request->getFile('product_banner');
        $file->move('./assets/img/product_banner', $file_name);
        echo json_encode(['status' => true, 'path' => $filewithpath]);
    }

    public function gallery_image_upload()
    {
        $file_name = rand() . $_FILES['gallery_image']['name'];
        $filewithpath = "/assets/img/gallery_image/" . $file_name;
        $file = $this->request->getFile('gallery_image');
        $file->move('./assets/img/gallery_image', $file_name);
        echo json_encode(['status' => true, 'path' => $filewithpath]);
    }

    public function testimonials_image_upload()
    {
        $file_name = rand() . $_FILES['testimonials_image']['name'];
        $filewithpath = "/assets/img/testimonials_image/" . $file_name;
        $file = $this->request->getFile('testimonials_image');
        $file->move('./assets/img/testimonials_image', $file_name);
        echo json_encode(['status' => true, 'path' => $filewithpath]);
    }
}
