<section class="info_section footer-background">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="info_contact">
                    <h5>
                        <a class="footer-text" href="<?= base_url();?>" class="navbar-brand footer-text">
                            <?= $user_details['business_name']; ?>
                        </a>
                    </h5>
                    <p class="footer-text">
                        <i class="fas fa-location-arrow footer-text" aria-hidden="true"></i>
                        <?= $user_details['business_address']; ?>
                    </p>
                    <p>
                        <i class="fas fa-phone-alt footer-text" aria-hidden="true"></i>
                        <a class="footer-text" href="tel:<?= $user_details['user_phone']; ?>">
                            +91 <?= $user_details['user_phone']; ?>
                        </a>
                    </p>
                    <p>
                        <i class="fas fa-phone-alt footer-text" aria-hidden="true"></i>
                        <a class="footer-text" href="tel:<?= $user_details['company_phone_no']; ?>">
                            +91 <?= $user_details['company_phone_no']; ?>
                        </a>
                    </p>
                    <p>
                        <i class="footer-text fas fa-envelope" aria-hidden="true"></i>
                        <a class="footer-text" href="mailto:<?= $user_details['user_email']; ?>"><?= $user_details['user_email']; ?></a>
                    </p>
                    <p class="social_box">
                        <a target="_blank" href="<?= !empty($user_details['twitter_page']) ? $user_details['twitter_page'] : "https://twitter.com"; ?>" class="footer-text twitter text-light me-1 rounded text-center fs-6">
                            <i class="footer-text fab fa-twitter"></i>
                        </a>
                        <a target="_blank" href="<?= !empty($user_details['facebook_page']) ? $user_details['facebook_page'] : "https://www.facebook.com"; ?>" class="footer-text facebook text-light me-1 rounded text-center fs-6">
                            <i class="footer-text fab fa-facebook"></i>
                        </a>
                        <a target="_blank" href="<?= !empty($user_details['instagram_page']) ? $user_details['instagram_page'] : "https://www.instagram.com"; ?>" class="footer-text instagram text-light me-1 rounded text-center fs-6">
                            <i class="footer-text fab fa-instagram"></i>
                        </a>
                        <a target="_blank" href="<?= !empty($user_details['linkedin_page']) ? $user_details['linkedin_page'] : "https://www.linkedin.com"; ?>" class="footer-text linkedin text-light me-1 rounded text-center fs-6">
                            <i class="footer-text fab fa-linkedin"></i>
                        </a>
                    </p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info_info">
                    <h5 class="footer-text">Information</h5>
                    <p class="footer-text">
                        <?= $user_details['company_profile']; ?>
                    </p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info_links">
                    <h5 class="footer-text">Useful Link</h5>

                    <ul>
                        <?php
                        foreach ($menu_lists as $menu_list) {
                            echo '<li class="nav-item"><a class="nav-link footer-text" href="' . base_url() . '/' . $menu_list['menu_link'] . '""><span>' . ucfirst($menu_list['menu_name']) . '</span></a></li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="product_section info_form">
                    <h5 class="footer-text">Newsletter</h5>
                    <form action="">
                        <input type="email" class="w-100 footer-text searchbar_color" placeholder="Enter your email" />
                        <div class="m-0 mt-2 btn_box">
                            <button class="nebtn w-100 m-0 ne footer-text footer-background">Subscribe</button>
                        </div>
                    </form>
                    <iframe src="https://www.facebook.com/plugins/page.php?href=<?= !empty($user_details['facebook_page']) ? $user_details['facebook_page'] : 'https://www.facebook.com'; ?>&tabs=timeline&width=270&height=300&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" width="270" height="300" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- end info_section -->

<!-- footer section -->
<footer class="footer_section bg-primary copyright-background">
    <div class="container copyright-text">
        <p class="copyright-text">© <?= date("Y"); ?> <?= $colors['copyright_text'];?>
        </p>
    </div>
</footer>