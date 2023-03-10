<?php require('top.php'); ?>

<!-- start contact form section -->
<div class="container">
    <div class="row">
        <div class="col-8 offset-2">
            <h2 class="text-center mb-4">Contact Us</h2>
            <form id="contact-form" method="post">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter your name" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="email" class="from-label">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email address" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="mobile" class="form-label">Mobile</label>
                    <input type="text" id="mobile" name="mobile" placeholder="Enter your mobile number" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea name="message" id="message" placeholder="Enter your message"></textarea>
                </div>
                <button type="button" onclick="send_message()" class="btn btn-lg btn-success">Send Message</button>
            </form>
        </div>
    </div>
</div>
<!-- end contact form section -->

<?php require('footer.php')?>        