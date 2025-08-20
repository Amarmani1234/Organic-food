<?php get_header();

?>




<!-- Same structure as login.html with changes in form fields -->

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
            <h3 class="mb-4">Sign UP</h3>
            <form method="post">
                <div class="mb-3">
                    <label>First Name</label>
                    <input type="text" class="form-control" name="first_name">
                </div>
                <div class="mb-3">
                    <label>Last Name</label>
                    <input type="text" class="form-control" name="last_name">
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email">
                </div>
                <div class="mb-3">
                    <label>Phone</label>
                    <input type="tel" class="form-control" name="phone">
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <div class="mb-3">
                    <input type="checkbox" name="terms"> I agree to Terms
                </div>
                <input class="btn btn-primary w-100" type="submit" name="submit_signup" value="Create Account">

            </form>

            <p class="text-center mt-3">Already have an account? <a href="<?php echo site_url('/login') ?>">Login</a>
            </p>
            <hr />
            <p class="text-center">Or Login with</p>
            <div class="d-flex gap-2 justify-content-center">
                <button class="btn btn-outline-secondary">Google</button>
                <button class="btn btn-outline-secondary">Facebook</button>
            </div>
        </div>
        <div class="col-md-6 illustration d-flex align-items-center justify-content-center">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/sign-up.png" alt="login-illustration"
                class="img-fluid auth-image-signup">
        </div>
    </div>
</div>


<?php 
handle_custom_user_signup();

get_footer() ?>