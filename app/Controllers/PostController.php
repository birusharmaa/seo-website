<?php

namespace App\Controllers;

use App\Models\PostsModel;
use App\Models\Users_model;
use App\Models\MetaKeywordModel;
use App\Models\Enquiry_model;

use CodeIgniter\API\ResponseTrait;

class PostController extends AppController
{
    use ResponseTrait;
    public function __construct()
    {
        parent::__construct();
    }



    public function getMetaData($url = null)
    {
        $current_url = base64_decode($url);
        $user_model     = new Users_model();
        $update_model   = new PostsModel();
        //$k_url_model    = new KeywordUrlModel();
        //////////////////
        $user_data = $user_model->getUserData();
        $user_id        = $user_data['id'];
        
        $this->meta_keywords = new MetaKeywordModel();
        $this->meta_keywords->select(['keyword', 'page_url']);
        $this->meta_keywords->where(['page_url'=> $current_url, 'status' => '1', 'created_by' => $user_id]);
        $this->meta_keywords->orderBy('id', 'asc');
        $meta_keywords =  $this->meta_keywords->findAll();

        $update_data = $update_model->orderBy('id', 'desc')->findAll(10);
        $title = "";
        if (!isset($meta_keywords) && !empty($meta_keywords)) {
            $title = $user_data['company_name'] . ' | +91-' . $user_data['company_phone_no'];
            foreach ($meta_keywords as $keyword) {
                $title .= ", ".$keyword['keyword'];
            }
        } else {
            $title = $user_data['company_name'] . '| +91-' . $user_data['company_phone_no'];
        }

       
        $pluginsupdates = "";
        if (!empty($update_data) && count($update_data) > 0) {
            foreach ($update_data as $newdata) {
                $pluginsupdates .= '<div class="plugin-card my-2">
                          <div class="plugin-card-body">
                            <p>
                              ' . $newdata['description'] . '
                            </p>
                            <a href="'.base_url().'/updates'.'/'.$newdata['slug'] . '" >
                            <button class="read-more-button" type="button">
                              Read More
                            </button> 
                            </a>
                          </div>
                        </div>';
            }
        }
        
        // end plugins

        //////////////////////////////////////
        //$siteurl        ='https://plugins.thewingshield.com/';
        // $condition      = ['keywordUrl' => $siteurl];
        // $keyword_model->select('keywords');
        // $keywords_data = $keyword_model->where($condition)->findAll();
        
        $final = "";
        // foreach ($keywords_data as $keyword) {
        //     $final .= $keyword['keywords'] . ", ";
        // }
        // if ($final == "") {
        //     $final = "welcome";
        // } else {
        //     $final = rtrim($final, ', ');
        // }
        
        $headData = '<title>'. $title . '</title>
              <link rel="canonical" href="https://www.' . $user_data['website_URL'] . '/" />
              <meta name="document-type" content="Public" />
              <meta name="document-rating" content="Safe for Kids" />
              <meta name="robots" content="ALL, INDEX, FOLLOW" />
              <meta name="googlebot" content="index, follow" />
              <meta name="Expires" content="never" />
              <meta name="coverage" content="Worldwide" />
              <meta name="distribution" content="Global" />
              <meta name="rating" content="General" />
              <meta name="target" content="all" />
              <meta name="HandheldFriendly" content="True" />
              <meta http-equiv="content-language" content="en" />
              <meta name="YahooSeeker" content="Index,Follow" />
              <meta property="og:locale" content="en_US" />
              <meta content="Yes" name="allow-search" />
              <meta name="Content-Language" content="EN" />
              <meta name="geo.region" content="IN" />
              <meta content="global" name="distribution" />
              <meta name="Copyright" content="© 2022 ' . $user_data['company_name'] . '" />
              <meta
                name="classification"
                content="' . $final . '"
              />
              <meta name="address" content="' . $user_data['company_name'] . '" />
              <script type="application/ld+json">
                {
                  "@context": "https://schema.org",
                  "@type": "LocalBusiness",
                  "paymentAccepted": "Cash, Credit Card",
                  "priceRange": "14999",
                  "address": {
                    "@type": "PostalAddress",
                    "streetAddress": "' . $user_data['company_name'] . '",
                    "addressLocality": "",
                    "addressRegion": "",
                    "postalCode": "",
                    "addressCountry": "India",
                    "areaServed": ["", "", "0"]
                  },
                  "aggregateRating": {
                    "@type": "AggregateRating",
                    "ratingValue": "4",
                    "reviewCount": "167639"
                  },
                  "name": "' . $user_data['company_name'] . '",
                  "image": [
                    "' . base_url() . '/public/uploads/img/business_logo/' . $user_data['business_logo'] . '"
                  ],
                  "telephone": "+91-' . $user_data['company_phone_no'] . '",
                  "url": "https://www.' . $user_data['website_URL'] . '"
                }
              </script>
              <script type="application/ld+json">
                {
                  "@context": "https://schema.org",
                  "@type": "WebSite",
                  "@id": "#website",
                  "url": "https://www.' . $user_data['website_URL'] . '/",
                  "name": "' . $user_data['company_name'] . '",
                  "potentialAction": {
                    "@type": "SearchAction",
                    "target": "https://www.' . $user_data['website_URL'] . '//?s={search_term_string}",
                    "query-input": "required name=search_term_string"
                  }
                }
              </script>
                    
              <meta property="og:type" content="' . $user_data['company_name'] . '" />
              <meta property="og:title" content="' . $user_data['company_name'] . '" />
              <meta
                property="og:image"
                content="' . base_url() . '/public/uploads/img/business_logo/' . $user_data['business_logo'] . '"
              />
              <meta
                property="og:description"
                content="' . $user_data['company_profile'] . '"
              />
              <meta property="og:url" content="https://www.' . $user_data['website_URL'] . '/" />
              <meta name="twitter:card" content="summary" />
              <meta
                name="twitter:description"
                content="' . $user_data['company_profile'] . '"
              />
              <meta name="twitter:title" content="' . $user_data['company_name'] . '" />
              <meta
                property="twitter:image"
                content="' . base_url() . '/public/uploads/img/business_logo/' . $user_data['business_logo'] . '"
              />
              <meta name="twitter:site" content="@' . $user_data['company_name'] . '" />
              <meta name="twitter:domain" content="' . $user_data['company_name'] . '" />
              <meta
                name="keywords"
                content="' . $final . '"
              />
              <meta 
                name="description"
                content="' . $user_data['company_profile'] . '"
              />
              <link
                rel="shortcut icon"
                href="' . base_url() . '/public/uploads/img/business_logo/' . $user_data['business_logo'] . '"
              />
              <meta charset="utf-8" />
              <meta
                name="viewport"
                content="width=device-width, initial-scale=1, shrink-to-fit=no"
              />
            <style>
                * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                }
            
                  .plugin-box {
                    position: fixed;
                    bottom: 10px;
                    z-index: 99999; 
                  }
                  .plugin-box.right {
                    right: 10px;
                  }
                  .plugin-box.left {
                    left: 10px;
                  }
                  .plugin-box .plugin__open-btn {
                    width: 50px;
                    height: 50px;
                    border: 0;
                    border-radius: 50%;
                    font-size: 30px;
                  }
                  .plugin-box .plugin__open-btn .plugin__chat-icon {
                    width: 100%;
                    height: 100%;
                    transition-duration: 0.3s;
                  }
                  .plugin-box .plugin__open-btn .plugin__chat-icon:hover {
                    transform: rotate(360deg);
                  }
                  .plugin-box .plugins {
                    transition-duration: 0.3;
                    transform: scale(0);
                    position: absolute;
                    top: -320%;
                    left: 0px;
                    display: flex;
                    align-items: center;
                    flex-direction: column;
                    gap: 5px;
                  }
                  .plugin-box .plugins .icons {
                    width: 50px;
                    height: 50px;
                    border-radius: 50%;
                    position: relative;
                  }
                  .plugin-box .plugins .icons img {
                    width: 100%;
                    height: 100%;
                  }
                  .plugin-box .plugins .icons span {
                    position: absolute;
                    display: inline-block;
                    right: -220%;
                    width: 100px;
                    background-color: rgba(0, 0, 0, 0.5);
                    color: white;
                    padding: 5px 10px;
                    border-radius: 10px;
                    opacity: 0;
                    transform: scale(0);
                    transition-duration: 0.3s;
                  }
                  .plugin-box.right .plugins .icons span {
                    left: -220%;
                    width: 100px;
                  }
                  .plugin-box .plugins .icons:hover span {
                    opacity: 1;
                    transform: scale(1);
                  }
                  .plugin-box .plugins.active {
                    transform: scale(1);
                  }
                  .plugin__modal {
    				display: none; 
    				position: fixed; 
    				z-index: 99999; 
    				padding-top: 100px; 
    				left: 0;
    				top: 0;
    				width: 100%; 
    				height: 100%; 
    				overflow: auto; 
    				background-color: rgb(0, 0, 0); 
    				background-color: rgba(0, 0, 0, 0.4); 
        			}
        			.plugin__modal.active {
        				display: block;
        			}
    			    .singin > form > div > input{
                          background: #edf2f6 none repeat scroll 0 0;
                            border: medium none;
                            font-size: 13px;
                            margin-bottom: 5px;
                            padding: 10px 20px;
                            width: 100%;
                      }
    
        			.plugin__modal-content {
        				background-color: #fefefe;
        				margin: auto;
        				padding: 20px;
        				border: 1px solid #888;
        				width: 100%;
        				max-width: 500px;
        				    border-radius: 10px;
        			}
        			.plugin__modal-header {
        				display: flex;
        				justify-content: space-between;
        				align-items: center;
        			}
        			.plugin__modal-header .plugin__close {
        				width: 30px;
        				height: 30px;
        				border: 1px solid #fefefe;
        				color: #fefefe;
        				font-weight: bolder;
        				border-radius: 10px;
        				position: relative;
        				background-color: red;
        				cursor: pointer;
        			}
        			.plugin__modal-header .plugin__close::after {
        				content: "X";
        			}
        			.plugin__modal-header h5 {
        				font-weight: bolder;
        				font-size: 24px;
        			}
        			.my-2 {
        				margin-top: 10px;
        				margin-bottom: 10px;
        			}
        			.form-input{
        			    text-align: left;
        			}
        			.form-input input {
        				width: 100%;
        				height: 40px;
        				border: 1px solid #333;
        				border-radius: 5px;
        				padding: 0 10px;
        				font-size: 16px;
        				color: #333;
        				background-color: #fefefe;
        			}
        			.submit-button {
        				width: 100%;
        				height: 40px;
        				border: 1px solid #333;
        				border-radius: 5px;
        				padding: 0 10px;
        				font-size: 16px;
        				color: #333;
        				background-color: #fefefe;
        				cursor: pointer;
        			}
        			.submit-button:hover {
        				background-color: #333;
        				color: #fefefe;
        			}
        			input.is-invalid {
        				border-color: red;
        			}
        			label.is-invalid,
        			span.is-invalid {
        				color: red;
        			}
        			.plugin-card {
        				position: relative;
        				display: flex;
        				flex-direction: column;
        				min-width: 0;
        				word-wrap: break-word;
        				background-color: #fff;
        				background-clip: border-box;
        				border: 1px solid rgba(0, 0, 0, 0.125);
        				border-radius: 0.25rem rem;
        			}
        			.plugin-card-body {
        				padding: 10px;
        			}
        			.read-more-button {
        				margin-top: 10px;
        				height: 30px;
        				border: 1px solid rgb(87, 124, 234);
        				border-radius: 5px;
        				padding: 0 10px;
        				font-size: 16px;
        				color: #333;
        				background-color: #fefefe;
        				cursor: pointer;
        			}
        			.read-more-button:hover {
        				background-color: rgb(87, 124, 234);
        				color: #fefefe;
        			}
        			.text-danger{
        			    color:red;
        			}
                </style>
                                <script async>
                                $(document).on("click", ".plugin__open-btn", function() {
                                    $(".plugins").toggleClass("active");
                                    if ($(".plugins").hasClass("active")) {
                                        $(this)
                                            .children("img")
                                            .attr(
                                                "src",
                                                "' . base_url() . '/public/uploads/plugins.io/close-button.png"
                                            );
                                    } else {
                                        $(this)
                                            .children("img")
                                            .attr(
                                                "src",
                                                "https://plugins.thewingshield.com/public/uploads/plugins.io/IMG-20220422-WA0006-removebg-preview.png"
                                            );
                                    }
                                });
                                $(document).on("click", ".plugin-modal-open", function () {
                    					const target = $(this).attr("href" || "data-target");
                    					$(target).toggleClass("active");
                    				});
                    				';

        $PluginAddonData = '
            <div class="plugin-box left">
              <button type="button" class="plugin__open-btn">
                <img
                  src="https://plugins.thewingshield.com/public/uploads/plugins.io/IMG-20220422-WA0006-removebg-preview.png"
                  alt=""
                  class="plugin__chat-icon"
                />
              </button>
              <div class="plugins">
                <a href="https://wa.me/' . $user_data["company_phone_no"].'?text=hello%20.." target="_blank" class="icons">
                  <img
                    src="https://plugins.thewingshield.com/public/uploads/plugins.io/whataapp.png"
                    alt=""
                  />
                  <span>Whatsapp</span>
                </a>
                <a href="tel:' . $user_data["company_phone_no"] . '" class="icons">
                  <img
                    src="https://plugins.thewingshield.com/public/uploads/plugins.io/callicon.png"
                    alt=""
                  />
                  <span>Call</span>
                </a>
                <a href="#" class="icons" >
                  <img 
                    src="https://cdn-icons-png.flaticon.com/512/14/14558.png"
                    alt=""
                  />
                </a>
              </div>
            </div>';

        echo $headData . "||||||||||" . $PluginAddonData;
        //echo $headData;
        exit;
    }

    public function postEnquiry(){
      $name    = $this->request->getPost('name');
      $phone   = $this->request->getPost('phone');
      $email   = $this->request->getPost('email');
      $message = $this->request->getPost('message');
      $data = [
        'name'     => $name,
        'email'    => $email,
        'phone'    => $phone,
        'message'  => $message
      ];

      $post_enquiry = new Enquiry_model();

      $res = $post_enquiry->insert($data);
      if($res){
          $data = [
              'status' => true,
              'error'  => false,
              'msg'    => 'Your enquiry is submitted. We will contact you soon.'
          ];
      } else {
          $data = [
              'status' => false,
              'error'  => true,
              'msg'    => 'No user found'
          ];
      }
      return $this->respond($data, 200);

    }

}
