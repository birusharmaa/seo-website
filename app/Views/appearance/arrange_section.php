<?= $this->extend('template/main');?>
<?= $this->section('script');?>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<style>
  /* #arrange_section_1 { list-style-type: none; margin: 0; padding: 0; width: 60%; } */
  #arrange_section_1 li { margin: 0 5px 5px 5px; padding: 5px; font-size: 1.2em; }
  #arrange_section_1 li:hover{
    cursor: all-scroll;
  }
  #arrange_section_1 li:active{
    cursor: grabbing;
  }
  html>body #arrange_section_1 li { line-height: 1.2em; }
  .ui-state-highlight { height: 1.5em; line-height: 1.2em; }
  </style>
<?= $this->endSection();?>
<?= $this->section('content');?>
<?php $session = \Config\Services::session()?>
      <!-- Page Header -->
      <div class="page-header">
        <div>
            <h2 class="main-content-title tx-24 mg-b-5">
               <?=$title;?>
            </h2> 
            <ol class="breadcrumb mt-4">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                <?=$title;?>
                </li>
            </ol>
        </div>
    </div>
    <!-- End Page Header -->
    <style>
        .arrange_box {
            padding-left: 20px;
            padding-top: 3px;
            padding-bottom: 3px;
            /* border: 1px solid #c4bfd6; */
            /* margin: 9px; */
            margin: 9px 0px 9px 0px;
        }

        .arrange_box_after {
            padding-left: 20px;
            padding-top: 3px;
            padding-bottom: 3px;
            /* border: 1px solid #c4bfd6; */
            margin: 9px 0px 9px 0px;
            background-color:#4680ff;
            color: white;
            border-radius: 8px;
        }
        ul {
           list-style-type: none;
         }

         .custom_arrange {
            padding-top: 3px;
            padding-bottom: 6px;
            border: 1px solid #a8afc7;
            border-top: 0px;
            border-left: 0px;
            border-right: 0px;
            margin: 9px;
            }
    </style>
    <!--Row-->
    <section>
        <div class="containre-fluid">
            <div class="row">
                <div class="col-md-4 shadow-lg p-3 mb-5 bg-white rounded">
                    <?php $first=1; ?>
                    
                    <?php $menuId = 0;  $second_id = 0; if($pages): foreach($pages as $value):
                        $sub_menu = "Y";
                        if($first == "1" || $first == "2" || $first == count($pages)){
                            $sub_menu = "N";
                        }
                        
                        $ids = $value->menu_id.","; 
                        $optiontext = $value->menu_name;
                        $second_id = $value->sub_menu;
                        $menuId = $value->menu_id;
                    ?>
                           
                    <div class="arrange_box" id="arrange_box<?=$menuId?><?=$second_id?>"        onclick="get_arrange_section(<?=$menuId?>,<?=$second_id?>,'<?=$sub_menu ?>');">
                            <?php
                                echo "<div class='row'>".$optiontext."</div></div>";
                                $first++;
                            ?>
                    
                    <?php endforeach; endif; ?>
                </div>
                <div class="col-md-8">
                    <div class="card shadow-lg p-3 mb-5 bg-white rounded-lg border-0">
                        <div class="card-content">
                            <div class="card-body">
                                    <form id="arrange_list">
                                       
                                    </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Row end -->

<?= $this->endSection();?>
<?= $this->section('script');?>
<!-- <script src="<?php //echo base_url('public/assets/sortable/Sortable.min.js')?>"></script> -->
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="<?php echo base_url('public/assets/js/othercustomscripts.js')?>"></script>

	<script>
        $(document).ready(function () { 
            get_arrange_section(1,0,'N');
        });		
	</script>
<?= $this->endSection();?>
