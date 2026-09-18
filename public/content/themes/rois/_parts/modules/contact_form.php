<!-- DEMO FORM -->
<div class="container">
    <div class="row">
        <div class="col-12 col-md-6 col-lg-5">
        
            <form id="demo-form" class="row form-spacer" action="<?php bloginfo('url');?>/wp-admin/admin-post.php" method="post">

                
                <input type="hidden" name="action" value="catch_submission"><!-- Catches submission *REQUIRED* -->
                <input type="hidden" name="table_name" value="example"><!-- Specifies table name *REQUIRED* -->

                
                <div class="col-12 col-xl-6"><label class="text-uppercase text-xs font--colour_gray-400">First name *<input type="text" placeholder="Jo" required name="fname" class="d-block w-100 mt-2"></label></div>

                <div class="col-12 col-xl-6"><label class="text-uppercase text-xs font--colour_gray-400">Last name *<input type="text" name="sname" placeholder="Bloggs" required class="d-block w-100 mt-2"></label></div>

                <div class="col-12"><label class="text-uppercase text-xs font--colour_gray-400">Email address *<input type="email" name="email" placeholder="jo@bloggs.com" required class="d-block w-100 mt-2"></label></div>

                <div class="col-12"><label class="text-uppercase text-xs font--colour_gray-400">Company *<input type="text" name="company" placeholder="Bloggs LTD" required class="d-block w-100 mt-2"></label></div>

                <div class="col-12"><label class="text-uppercase text-xs font--colour_gray-400">Position<input type="text" name="position" placeholder="Owner" class="d-block w-100 mt-2"></label></div>
                

                <div class="col-12"><label class="text-uppercase text-xs font--colour_gray-400">How can we help?<textarea name="position" placeholder="I'd like some help with..." class="d-block w-100 mt-2" rows="8"></textarea></label></div>
                
                <div class="col-12"><label class="text-xs font--colour_black d-flex align-items-start"><input type="checkbox" name="terms-accept" class="mr-2"><span>By submitting this form you accept our <a href="./terms-conditions" target="_blank">Terms & Conditions</a>, <a href="./privacy-policy" target="_blank">Privacy Policy</a> & <a href="./cookie-policy" target="_blank">Cookie Policy.</a></span></label></div>

                <?php $recaptcha_keys = (new submissionHandling)->getRecaptchaKeys(); ?>
                <div class="col-12">
                    <button class="g-recaptcha"
                    data-sitekey="<?php echo esc_attr($recaptcha_keys['site_key'] ?? ''); ?>"
                    data-callback='onSubmit'
                    data-action='submit'>Send</button>
                </div>
                

            </form>
        </div>
    </div>
</div>


<script>
    function onSubmit(token) {
        document.getElementById("demo-form").submit();
    }
</script>