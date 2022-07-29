<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Users_model;
use CodeIgniter\API\ResponseTrait;
use mysqli;

class UserController extends BaseController
{
    protected $user;
    use ResponseTrait;
    public function __construct(){
        $this->user = new Users_model();    
    }

    public function index(){
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL,'http://localhost:8080/user/all');
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Length: ' . strlen($fields)));
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        //     'email: user.varification@gmail.com',
        //     'password: $2y$10$2VeStUYwYZsGy06ibDGHp.JaZroqVuak2O/KBkeBNelOYLYU5bvsi'
        // ));
        // $response = curl_exec($ch);
        // curl_close($ch); // Close the connection
        // echo $response;
        // exit;
        $user = $this->user->getUsers();
        if($user){
            $data = [
                'status' => true,
                'error'  => false,
                'data'   => $user
            ];
            return $this->respond($data);
        }else{
            $data = [
                'data'   => "No record found."
            ];
            return $this->fail($data);
        }
    }

    public function all(){
        $user = $this->user->getUsers();
        if($user){
            $data = [
                'status' => true,
                'error'  => false,
                'data'   => $user
            ];
            return $this->respond($data);
        }else{
            $data = [
                'data'   => "No record found."
            ];
            return $this->fail($data);
        }
    }

    public function update(){
        $password = $this->request->getVar('password');
        $email = '';
        if(!$password){
            $data = [
                'data'   => "No password found, please insert your password."
            ];
            return $this->fail($data);
        }

        $user = $this->user->updateUserPassword($email, $password);
        if($user){
            $data = [
                'status' => true,
                'error'  => false,
                'data'   => 'Password updated successfully.'
            ];
            return $this->respond($data);
        }else{
            $data = [
                'data'   => 'No record found.'
            ];
            return $this->fail($data);
        }
    }


    public function changeStatus(){
        
        $db = db_connect();

        $sql = "UPDATE `seo_users` SET `user_status`= case when user_status = 1 then 0 else 1 end";
        $result = $db->query($sql);
        if($result){
            $sql = "SELECT `user_status` FROM `seo_users` WHERE `id` =1 ";
            $result = $db->query($sql);
            $status = $result->getRowArray();
            $val = "Deactivated";
            if($status['user_status']==1){
                $val ="Activated";
            }

            $data = [
                'status' => true,
                'error'  => false,
                'data'   => "User ".$val." successfully."
            ];
            return $this->respond($data);
        }else{
            $data = [
                'status' => false,
                'error'  => true,
                'data'   => 'Status update unsuccessfully.'
            ];
            return $this->fail($data);
        }
    }
}
