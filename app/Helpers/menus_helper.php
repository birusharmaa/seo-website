<?php

use App\Models\ServicesModel;
use App\Models\CustomSubMenu;
use App\Models\ProductsModel;
use App\Models\PostsModel;
use App\Models\MenuModel;

/**
 * Get all services 
 */
if (!function_exists('getAllServices')) {
    function getAllServices() {
        $service_model = new ServicesModel();
        return $service_model
                ->select(['id', 'service'])
                ->where('status' , 1)
                ->findAll();
    }
}


/**
 * Get all Products 
 */
if (!function_exists('getAllProducts')) {
    function getAllProducts() {
        $products_model = new ProductsModel();
        return $products_model
                ->select(['id', 'product_name as service'])
                ->where('status' , 1)
                ->findAll();
    }
}

/**
 * Get all post and updates 
 */
if (!function_exists('getAllPostAndUpdates')) {
    function getAllPostAndUpdates() {
        $products_model = new PostsModel();
        return $products_model
                ->select(['id', 'title as service'])
                ->where('status' , 'published')
                ->findAll();
    }
}

/**
 * get custom sub menu
 */
if (!function_exists('getCustomSubmenu')) {
    function getCustomSubmenu($id = 0) {
        $custom_sub_menu = new CustomSubMenu();
        return $custom_sub_menu
                ->select(['id', 'sub_menu as service'])
                ->where('menu_id' , $id)
                ->findAll();
    }
}


/**
 * get sub menu page name
 */
if (!function_exists('getSubMenuPageName')) {
    function getSubMenuPageName($menu_id = 0, $submenu = 0) {
        $menu_model = new MenuModel();
        if($submenu==0){
            $menu_name = $menu_model->select('menu_name')->where('id', $menu_id)->first();
            return $menu_name['menu_name'];
        }else{
            $menu_name = $menu_model->select('menu_name')->where('id', $menu_id)->first();
            
            if($menu_name['menu_name']=="Services"){
                $service_model = new ServicesModel();
                $res =  $service_model
                ->select('service')
                ->where(['status'=>1, 'id'=>$submenu])
                ->first();
                return "Services- ".$res['service'];
            }
            else if($menu_name['menu_name']=="Products"){
                $products_model = new ProductsModel();
                $res =  $products_model
                ->select('product_name as service')
                ->where(['status'=>1, 'id'=>$submenu])
                ->first();
                return "Products- ".$res['service'];
                
            }
            else if($menu_name['menu_name']=="Updates"){
                $products_model = new PostsModel();
                $res = $products_model
                ->select('title as service')
                ->where(['status'=>'published', 'id'=>$submenu])
                ->first();
                return "Updates- ".$res['service'];
            }
            else{
                $menu_name = $menu_model->select('menu_name')->where('id', $menu_id)->first();
                $menu = $menu_name['menu_name'];

                $custom_sub_menu = new CustomSubMenu();
                $res = $custom_sub_menu
                ->select('sub_menu as service')
                ->where(['menu_id'=>$menu_id, 'id'=>$submenu])
                ->first();
                return $menu."- ".$res['service'];
            }
        }
    }
}

function arrayInsert($array, $position, $insertArray){
    $ret = [];
    // if ($position == count($array)) {
    //     $ret = $array + $insertArray;
    // }
    // else {
    //     $i = 0;
    //     foreach ($array as $key => $value) {
    //         if ($position == $i++) {
    //             $ret += $insertArray;
    //         }

    //         $ret[$key] = $value;
    //     }
    // }
    return $ret;
}