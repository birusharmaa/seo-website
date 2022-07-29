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
    <?= $this->include('theme2/frontend/layout/cssLinks') ?>
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
        .navbar-dropdown .dropdown-menu .nav-link{
            mix-blend-mode: difference;
        }
        
    </style>
</head>
<body class="has-topbar theme-<?= $user_details['theme_color'];?>">
    <?= $this->include('theme2/frontend/layout/header') ?>
    <div class="content-wrap">
        <?= $this->renderSection('contentTheme2'); ?>
    </div>
    <?= $this->include('theme2/frontend/layout/footer') ?>
    
    <?= $this->include('theme2/frontend/layout/jsLinks') ?>
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
                    $("body").append(temp[1]);
                }
            }
        };
        eptagmanage.open("POST", atob(getDataUrl)+ btoa(currentUrl) );
        eptagmanage.send();
    </script>

    <!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/62bd5221b0d10b6f3e7a162c/1g6pohlhq';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
</body>
</html>
