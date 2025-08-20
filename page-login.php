<?php
/*
Template Name: Custom Login Page
*/
get_header();

handle_custom_user_login();
?>

<!-- <style>
    body {
        background: url('<?php echo get_template_directory_uri(); ?>/assets/images/kdr2.png') no-repeat center center fixed;
        background-size: cover;
        overflow-x: hidden;
    }
</style> -->

<div class="pagelogin container py-5">
    <div class="row auth-container">
        <div class="col-md-6 p-5">
            <h3 class="mb-4">Login</h3>
            <form method="post" action="">
                <?php wp_nonce_field('custom_login', 'custom_login_nonce'); ?>
                <div class="mb-3">
                    <label>Email address</label>
                    <input type="email" name="email" class="form-control" placeholder="you@example.com" required>
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" placeholder="********" required>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <div><input type="checkbox" name="remember"> Remember me</div>
                    <a href="<?php echo wp_lostpassword_url(); ?>">Forgot password?</a>
                </div>
                <button type="submit" name="submit_login" class="btn btn-primary w-100">Login</button>
            </form>

            <hr />
            <p class="text-center">Or sign in with</p>
            <div class="d-flex gap-2 justify-content-center">
                <button class="btn btn-outline-secondary">Google</button>
                <button class="btn btn-outline-secondary">Facebook</button>
            </div>
            <p class="text-center mt-3">Don't have an account? <a href="<?php echo site_url('/sign-up') ?>">Sign Up</a>
            </p>
        </div>
        <div class="col-md-6 illustration d-flex align-items-center justify-content-center">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/login.png" alt="login-illustration"
                class="img-fluid auth-image">
        </div>
    </div>
</div>

<?php
get_footer();
?>