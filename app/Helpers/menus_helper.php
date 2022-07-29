<?php

use App\Models\ServicesModel;
use App\Models\CustomSubMenu;
use App\Models\ProductsModel;
use App\Models\PostsModel;

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

function arrayInsert($array, $position, $insertArray){
    $ret = [];
    if ($position == count($array)) {
        $ret = $array + $insertArray;
    }
    else {
        $i = 0;
        foreach ($array as $key => $value) {
            if ($position == $i++) {
                $ret += $insertArray;
            }

            $ret[$key] = $value;
        }
    }
    return $ret;
}