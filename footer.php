<?php
/**
 * @link Kaddora 
 *
 * @package Kaddora tech
 */
?>

<footer class="py-5" style="background-color: #f4f4f4;">
    <div class="container-lg">
        <div class="row">

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="footer-menu">
                    <!-- <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logos.png" alt="logo" class="img-fluid" style="width:80px; height:80px;"> -->
                    <h5>Kaddora Organic</h5>   
                    <div class="social-links mt-3">
                        <ul class="d-flex list-unstyled gap-2">
                            <li><a href="#" class="btn btn-outline-light"><svg width="16" height="16"><use xlink:href="#facebook"></use></svg></a></li>
                            <li><a href="#" class="btn btn-outline-light"><svg width="16" height="16"><use xlink:href="#twitter"></use></svg></a></li>
                            <li><a href="#" class="btn btn-outline-light"><svg width="16" height="16"><use xlink:href="#youtube"></use></svg></a></li>
                            <li><a href="#" class="btn btn-outline-light"><svg width="16" height="16"><use xlink:href="#instagram"></use></svg></a></li>
                            <li><a href="#" class="btn btn-outline-light"><svg width="16" height="16"><use xlink:href="#amazon"></use></svg></a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-2 col-sm-6">
                <div class="footer-menu">
                    <h5 class="widget-title">Organic</h5>
                    <ul class="menu-list list-unstyled">
                        <?php
                        if (has_nav_menu('footerLocationTwo')) {
                            wp_nav_menu([
                                'theme_location' => 'footerLocationTwo',
                                'container' => false,
                                'menu_class' => '',
                                'items_wrap' => '%3$s', // Removed <ul> wrapper since we already have it
                                'depth' => 1,
                                'fallback_cb' => false
                            ]);
                        } else {
                            echo '<li><a href="' . esc_url(home_url('/')) . '">' . esc_html__('Service 1', 'kaddora') . '</a></li>';
                            echo '<li><a href="' . esc_url(admin_url('nav-menus.php')) . '">' . esc_html__('Add Services', 'kaddora') . '</a></li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>

            <div class="col-md-2 col-sm-6">
                <div class="footer-menu">
                    <h5 class="widget-title">Quick Links</h5>
                    <ul class="menu-list list-unstyled">
                        <li><a href="#" class="nav-link">Offers</a></li>
                        <li><a href="#" class="nav-link">Discount Coupons</a></li>
                        <li><a href="#" class="nav-link">Stores</a></li>
                        <li><a href="#" class="nav-link">Track Order</a></li>
                        <li><a href="#" class="nav-link">Shop</a></li>
                        <li><a href="#" class="nav-link">Info</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-2 col-sm-6">
                <div class="footer-menu">
                    <h5 class="widget-title">Customer Service</h5>
                    <ul class="menu-list list-unstyled">
                        <li><a href="#" class="nav-link">FAQ</a></li>
                        <li><a href="#" class="nav-link">Contact</a></li>
                        <li><a href="#" class="nav-link">Privacy Policy</a></li>
                        <li><a href="#" class="nav-link">Returns & Refunds</a></li>
                        <li><a href="#" class="nav-link">Cookie Guidelines</a></li>
                        <li><a href="#" class="nav-link">Delivery Information</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="footer-menu">
                    <h5 class="widget-title">Subscribe Us</h5>
                    <p>Subscribe to our newsletter to get updates about our grand offers.</p>
                    <form class="d-flex mt-3 gap-0" action="#" method="post">
                        <input class="form-control rounded-start rounded-0 bg-light" type="email" placeholder="Email Address" aria-label="Email Address" name="email" required>
                        <button class="btn btn-dark rounded-end rounded-0" type="submit">Subscribe</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</footer>

<div id="footer-bottom" style="background-color: #f4f4f4; color: black; border-top: 1px solid #ddd;">
    <div class="container-lg">
        <div class="row align-items-center">
            <div class="col-md-6 copyright">
                <p class="mb-0">© <?php echo date('Y'); ?> Organic. All rights reserved.</p>
            </div>
            <div class="col-md-6 credit-link text-start text-md-end">
                <p class="mb-0">Designed & Developed by <a style="text-decoration: none;" href="https://kaddora.com/"><strong>Kaddora Tech</strong></a> | Distributed By <a style="text-decoration: none;" href="https://kaddora.com"><strong>ThemeKaddora</strong></a></p>
            </div>
        </div>
    </div>
</div>

<?php wp_footer(); ?>

</body>
</html>