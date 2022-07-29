<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\AppointmentBookingModel;
use CodeIgniter\API\ResponseTrait;
use phpDocumentor\Reflection\DocBlock\Tags\Formatter;
use App\Models\Users_model;


class AppointmentBooking extends BaseController
{
    use ResponseTrait;
    protected $validation;
    protected $session;
    protected $appointment_model;
    public function __construct()
    {
        helper(array('url', 'file', 'form', 'language', 'general'));
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
        $this->appointment_model = new AppointmentBookingModel();
        require_once APPPATH . 'ThirdParty/ssp.class.php';
        $this->db = db_connect();
        
    }
    public function index()
    {
        if($this->session->has('login_user')){
            $user_data = $this->session->get('login_user');
        }  
        $this->user = new Users_model();
        $userinfo =  $this->user->getUserInfoId($user_data['user_id']);
        
        $data['color'] =  getThemeColor($user_data["user_id"]);     
        $data['topbar'] = $userinfo->appointment_booking;
        $data['title'] = "Appointments History";  
        return view('appointments/appointments', $data);   
    }

    public function getAllAppoinments(){
        // $data = $this->appointment_model->findAll();        
        // $response = [
        //     'status'   => true,
        //     'error'    => false,
        //     'data' => $data
        // ];
        // echo json_encode($data);
        // exit;
        $dbDetails = array(
            "host" => $this->db->hostname,
            "user" => $this->db->username,
            "pass" => $this->db->password,
            "db" => $this->db->database,
        );

        $table = "appointment_booking";

        //primary key
        $primaryKey = "id";
        $columns = array(
            array(
                "db" => "id",
                "dt" => 0,
            ),
            array(
                "db" => "name",
                "dt" => 1,
            ),
            array(
                "db" => "email",
                "dt" => 2,
            ),
            array(
                "db" => "phone",
                "dt" => 3,
            ),
            array(
                "db" => "booking_date",
                "dt" => 4,
                // "formatter" => function($val){
                //     return date("d-M-Y", strtotime($val));
                // }
            ),
            array(
                "db" => "booking_time",
                "dt" => 5,
                "formatter" => function($val){
                    $value = "";
                    if(strlen($val)==1 && $val<12){
                        $value = "0".$val.":00 Am";
                    }else{
                        $value = $val." Pm";
                    }
                    return $value;
                }
            ),
            array(
                "db" => "query",
                "dt" => 6,
            ),
            array(
                "db" => "id",
                "dt" => 7,
                "formatter" => function ($value, $row) {
                    return '<button class="btn btn-warning" onclick="deleteAppointment('.$value.')"><i class="fa fa-trash text-danger"></i></button>';
                },
            )
        );

        echo json_encode(
            \SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns)
        );
        // return $this->respond($response,200);
    }

    public function submitQuery(){
        
        $this->validation->setRules(
            [
                'bookingName'   => ['label' => 'booking name', 'rules' => 'required'],
                'bookingEmail'  => ['label' => 'booking email', 'rules' => 'required|valid_email'],
                'bookingPhone'  => ['label' => 'booking phone', 'rules' => 'required|max_length[10]|min_length[10]'],
                'bookingDate'   => ['label' => 'booking date', 'rules' => 'required'],
                'bookingTime'   => ['label' => 'booking time', 'rules' => 'required'],
                //'bookingQuery'  => ['label' => 'booking query', 'rules' => 'required|min_length[5]'],
            ]
            // ,
            // [   // Errors
            //     'bookingName' => [
            //         'required' => 'Booking name field is required.',
            //     ],
            //     'bookingEmail' => [
            //         'required' => 'Booking email field is required.',
            //     ],
            //     'bookingName' => [
            //         'required' => 'Booking name field is required.',
            //     ],
            //     'bookingPhone' => [
            //         'required' => 'Booking phone field is required.',
            //     ],
            //     'bookinDateTime' => [
            //         'required' => 'Booking date and time field is required.',
            //     ],
            //     'bookingQuery' => [
            //         'required' => 'Booking query field is required.',
            //     ],
        );
        if($this->validation->withRequest($this->request)->run()){
            $name    = $this->request->getPost('bookingName');
            $email   = $this->request->getPost('bookingEmail');
            $phone   = $this->request->getPost('bookingPhone');
            $booking_date= $this->request->getPost('bookingDate');
            $booking_time= $this->request->getPost('bookingTime');
            $booking_time = str_replace(" ",'', $booking_time);
            $query   = $this->request->getPost('bookingQuery');
            $data = [
                'name' => $name,
                'email' => $email,
                'booking_date' => $booking_date,
                'booking_time' => $booking_time,
                'phone' => $phone,
                'query' => $query,
            ];

            $old_record = $this->appointment_model->where(['booking_date'=>$booking_date, "booking_time" => $booking_time])->first();
            if(!empty($old_record)){
                $this->session->setFlashdata('error','This appointment slot is already booked, please choose diffrent date or time.');
                return redirect()->back()->withInput();
            }
            $res = $this->appointment_model->insert($data);
            if($res){
                $this->session->setFlashdata('message','Your appointment booking query submitted successfully!');
                return redirect()->back();
            }
        }else{
            return redirect()->back()->withInput();
        }
    }

    public function deleteAppoinment($id){
        $data = $this->appointment_model->find($id);
        if(!empty($data)){
            if($this->appointment_model->delete($id)){
                echo json_encode(['status'=>true, 'message'=>'Appointment booking query deleted successfully.']);
                exit;
            }
            else{
                echo json_encode(['status'=>false, 'message'=>'Appointment booking query delete unsuccessfully.']);
                exit;
            }
        }else{
            echo json_encode(['status'=>false, 'message'=>'Record not found.']);
            exit;
        }
    }

    function topbarAppoinment(){
        if($this->session->has('login_user')){
            $user_data = $this->session->get('login_user');
        }
        $user_id = $user_data['user_id'];  
        $status = $this->request->getPost('status');
        $this->user = new Users_model();
        $res = $this->user->updateBookingForm($status, $user_id);
        if($res){
            echo json_encode(['status'=>true, 'message'=>'']);
            exit;
        }
        else{
            echo json_encode(['status'=>false, 'message'=>'']);
            exit;
        }
    }
}
