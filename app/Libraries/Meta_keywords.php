<?php

namespace App\Libraries;
use App\Models\MetaKeywordModel;
class Meta_keywords{

    /**
     * Making menu list
     *
     * @return void
     */
    public function getMetaKeywords($id = 0){
        $full_url = site_url(uri_string());
        //Get all menu list  
       
        $this->meta_keywords = new MetaKeywordModel();
        $this->meta_keywords->select(['keyword', 'page_url']);
        $this->meta_keywords->where(['page_url'=> $full_url, 'status' => '1', 'created_by' => $id]);
        $this->meta_keywords->orderBy('id', 'asc');
        $meta_keywords =  $this->meta_keywords->findAll();
        return $meta_keywords;
    }
}
