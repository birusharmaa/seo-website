<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <title>
        <?php 
            if(isset($meta_keywords) && !empty($meta_keywords)){
                $i = 0;
                $total = count($meta_keywords)-1;
                $comm = ", ";
                if($i==$total){
                    $comm = "";
                }
                foreach($meta_keywords as $keyword){
                    if($i==$total){
                        $comm = "";
                    }
                    echo $keyword['keyword'].$comm;
                    $i++;
                }
            }else{
                echo $title;
            }
        ?>
    </title>
    <?php 
        if(isset($meta_keywords) && !empty($meta_keywords)){
            $i = 0;
            $total = count($meta_keywords)-1;
            $final_data ="";
            $comm = "";
            $comm = ", ";
            if($i==$total){
                $comm = "";
            }
            foreach($meta_keywords as $keyword){
                if($i==$total){
                    $comm = "";
                }
                $final_data .= $keyword['keyword'].$comm;
                $i++;
            }
            echo '<meta name="keywords" content="'.$final_data.'">';
        }else{
            echo '<meta name="keywords" content="'.$keywords.'" >';
        }
    ?>
    <meta name='description' content='<?= $description ?>'>
    <?= $this->include('theme3/frontend/layout/cssLinks') ?>
    <?= $this->renderSection('customCss'); ?>
    <style>
        :root {
            --header_background: <?= $colors['header_background']; ?>;
            --header_text: <?= $colors['header_text']; ?>;
            --navbar_background: <?= $colors['navbar_background']; ?>;
            --navbar_text: <?= $colors['navbar_text']; ?>;
            --searchbar_color: <?= $colors['searchbar_color']; ?>;
            --footer_background: <?= $colors['footer_background']; ?>;
            --footer_text_color: <?= $colors['footer_text_color']; ?>;
            --copyright_background: <?= $colors['copyright_background']; ?>;
            --copyright_text_color: <?= $colors['copyright_text_color']; ?>;
        }
        body.theme-custom {
        --bs-orange-100: <?= $user_details['custom_color']; ?>;
        --bs-primary-rgb: <?= $user_details['rbg_custom_color']; ?>;
        }
        .custom-text-color p,
        .custom-text-color {
            color: <?= $user_details['custom_text_color']; ?> !important;
        }
    </style>
</head>
<body class="theme-<?= $user_details['theme_color'];?>">
<!-- <div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v14.0" nonce="DGzegwJp"></script> -->

    <!-- <div class="hero_area"> -->
    <?= $this->include('theme3/frontend/layout/header') ?>
    <!-- </div> -->
    <div class="content-wrap">
        <?= $this->renderSection('contentTheme3'); ?>
    </div>

    <?= $this->include('theme3/frontend/layout/footer') ?>
    <?= $this->include('theme3/frontend/layout/jsLinks') ?>
    <?= $this->renderSection('customScripts'); ?>
    <script>
        var eppathurl = window.location.origin + window.location.pathname;
        var eptagmanage = new XMLHttpRequest();
        var getDataUrl = "<?= base_url();?>"+'/posts/getAllData/';
        var currentUrl = "<?= site_url(uri_string());?>";
        getDataUrl = btoa(getDataUrl);
        eptagmanage.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (this.response !== 0) {
                    var temp = new Array();
                    var mystr = this.response;
                    temp = mystr.split("||||||||||");
                    $("head").find("title").remove();
                    $('head').append(temp[0]); 
                    $('body').append(temp[1]); 
                }
            }
        };
        eptagmanage.open("POST", atob(getDataUrl)+ btoa(currentUrl) );
        eptagmanage.send();
    </script>
</body>
</html>