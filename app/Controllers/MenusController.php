<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\Menus_model;
use App\Models\MenuModel;

use App\Models\ServicesModel;
use App\Models\ProductsModel;
use App\Models\PostsModel;
use App\Models\CustomSubMenu;



class MenusController extends BaseController
{
    protected $menu_model;
    protected $custom_submenu;
    public function __construct()
    {
        $request = \Config\Services::request();
        $session = \Config\Services::session();
        $this->session = $session;
        $this->request = $request;
        $model = new Menus_model();
        $this->menus = $model;
        $this->menu_model = new MenuModel();
        $this->custom_submenu = new CustomSubMenu();
        helper("general");
        login_redirect();
    }

    public function index()
    {          
        if($this->session->has('login_user')){
            $user_data = $this->session->get('login_user');
        }  
        $data['menus'] =  $this->menus->get_all_menus_bysorting($user_data["user_id"]);    
        $data['default'] =  $this->menus->get_default_menu($user_data["user_id"]);   
        $data['un_default'] =  $this->menus->get_undefault_menu($user_data["user_id"]);
        
        $data['color'] =  getThemeColor($user_data["user_id"]);       
        $data['title'] = "Menus";  
        return view('menus/menus',$data);
    }

    public function sub_menus()
    {      
        if($this->session->has('login_user')){
            $user_data = $this->session->get('login_user');
        }  
        //$data['menus'] =  $this->menus->get_all_menus($user_data["user_id"]);  
        $data['menus'] =  $this->menus->getAllMenus($user_data["user_id"]);    
        $data['default'] =  $this->menus->get_default_menulist($user_data["user_id"]);  
        $data['color'] =  getThemeColor($user_data["user_id"]);  
        $data['title'] = "Sub Menus";
        return view('menus/sub_menus',$data);
    }


    function footer_menus(){ 
        if($this->session->has('login_user')){
            $user_data = $this->session->get('login_user');
        } 
        $data['color'] =  getThemeColor($user_data["user_id"]);  
        $data['title'] = "Footer Menus";
        $data['footer_menu'] = $this->menu_model->where(['footer_menu'=>'1'])->findAll();
        return view('menus/footer_menus',$data);
    }

    function save_menus(){            
        if($this->session->has('login_user')){
            $user_data = $this->session->get('login_user');
        }  
        $menu = xss_clean($this->request->getvar('menu_name'));
        $menu = ltrim($menu," ");
        $menu_link = str_replace(" ", '_', $menu);
        $menu_link = strtolower($menu_link);
        $data = [
            'menu_name' => $menu,
            'created_by' => $user_data["user_id"],
            'menu_link' => $menu_link,
        ];
        
        $return = $this->menus->save_menus($data);     
        if($return == 'exists'){
            echo json_encode(['status'=>false,'message'=>'Menu name must be unique.']);
        } 
        else if($return == 'save'){
            echo json_encode(['status'=>true,'message'=>'Menu record saved successfully.']);
        }else{
            echo json_encode(['status'=>false,'message'=>'Menu record save unsuccessfully. Please try again.']);
        }      
    }

    function save_default_menus(){
        if($this->session->has('login_user')){
            $user_data = $this->session->get('login_user');
        }    
        $id = ucfirst(xss_clean($this->request->getvar('menu_name')));      
        $data = array('default_menu' => 1,
            'update_by' => $user_data["user_id"],
            'updated_at' => date("Y-m-d H:i:s")
        );
        $return = $this->menus->save_default_menus($data, $id);         
        if($return){
            echo json_encode(['status'=>true,'message'=>'Default menu updated successfully.']);
        }else{
            echo json_encode(['status'=>false,'message'=>'Their is some problem. Please try again.']);
        }  
    }    

    function save_undefault_menus(){
        if($this->session->has('login_user')){
            $user_data = $this->session->get('login_user');
        }    
        $id = ucfirst(xss_clean($this->request->getvar('menu_name')));      
        $data = array('default_menu' => 0,
            'update_by' => $user_data["user_id"],
            'updated_at' => date("Y-m-d H:i:s")
        );
        $return = $this->menus->save_default_menus($data, $id);         
        if($return){
            echo json_encode(['status'=>true,'message'=>'Default menu updated successfully.']);
        }else{
            echo json_encode(['status'=>false,'message'=>'Their is some problem. Please try again.']);
        }  
    }    
 

    function get_default_menu(){
        if($this->session->has('login_user')){
            $user_data = $this->session->get('login_user');
        }    
        $data =  $this->menus->get_default_menu($user_data["user_id"]); 
        if($data){
            echo json_encode(['status'=>true, 'data'=>  $data]);
        }else{
            echo json_encode(['status'=>false]);
        }
    }

    function save_sub_menus(){
        
        if($this->session->has('login_user')){
            $user_data = $this->session->get('login_user');
        }        
        $sub_menu = ucfirst(xss_clean($this->request->getvar('sub_menu')));
        $sub_menu = ltrim($sub_menu, ' ');
        $sub_link = str_replace(' ', '_',$sub_menu);
        $sub_link = strtolower($sub_link);

        $data = array(
            'menu_id' => xss_clean($this->request->getvar('parent_menu_name')),
            'sub_menu' => $sub_menu,
            'sub_menu_link' => $sub_link,
            'created_by' => $user_data["user_id"]
        );
        //$return = $this->menus->save_sub_menus($data);  
        $return = $this->custom_submenu->save_record($data);   
        
        if($return >= 1){
            echo json_encode(['status'=>false,'message'=>'Sub menu must be unique.']);
        }else {
            $this->custom_submenu->insert($data);
            echo json_encode(['status'=>true,'message'=>'Sub menu saved successfully.']);
        }
    }

    function save_footer_menus(){
        if($this->session->has('login_user')){
            $user_data = $this->session->get('login_user');
        }        
        $data = array('footer_menu' => 1,
        'menu_name' => ucfirst(xss_clean($this->request->getvar('menu_name'))),
        'created_by' => $user_data["user_id"]
        );
        $return = $this->menus->save_footer_menus($data);         
        if($return){
            echo json_encode(['status'=>true,'message'=>'Footer menu saved successfully.']);
        }else{
            echo json_encode(['status'=>false,'message'=>'Their is some problem. Please try again.']);
        } 
    }

    function save_menus_sortings(){

        if($this->session->has('login_user')){
            $user_data = $this->session->get('login_user');
        }   

        $order = $_POST['sorting_order'];
        $count =count($order);
        $num = 1;
        
        foreach( $order as $value){             
            $this->menus->save_menus_sortings($value,$num, $user_data["user_id"]); 
            $num++;   
        }
        if($count == --$num){
            echo json_encode(['status'=>true,'message'=>'Sorting order updated successfully.']);
        }else{
            echo json_encode(['status'=>false,'message'=>'Their is some problem. Please try again.']);
        }
    }

    public function removeMenu($id=null){
        $res = $this->menu_model->find($id);
        if(!empty($res)){
            if($res['menu_name']=='Home' || $res['menu_name']=='About Us'|| $res['menu_name']=='Contact'){
                echo json_encode(['status'=>false,'message'=>'Your can\'t delete '.$res['menu_name']." menu."]);
            }else{
                $this->menu_model->delete($id);
                echo json_encode(['status'=>true,'message'=>'Your '.$res['menu_name'].' menu deleted successfully.']);
            }
        }else{
            echo json_encode(['status'=>false,'message'=>'No Menu found.']);
        }
    }
 
    public function getSubMenu($id = null, $type = null){
        $this->service = new ServicesModel();
        $this->product = new ProductsModel();
        $this->posts   = new PostsModel();

        $res     = [];

        if(empty($res) && $type == "Services"){
            $res = $this->service
                    ->select('service as menu_name')
                    ->where(['menu_id'=>$id])
                    ->findAll();
        }


        if(empty($res) && $type == "Products"){
            $res = $this->product
                    ->select('product_name as menu_name')
                    ->where(['menu_id'=>$id])
                    ->findAll();
        }

        if(empty($res) && $type == "Updates"){
            $res = $this->posts
                    ->select('title as menu_name')
                    ->findAll();
        }
        //get all custom sub menu
        $sub_menu = $this->custom_submenu->
                    select('sub_menu as menu_name, id')->
                    where(['menu_id'=>$id])->
                    findAll();

        if(!empty($sub_menu)){
            $res = array_merge($res, $sub_menu);
        }
       
        return json_encode($res);
    }


  

}
