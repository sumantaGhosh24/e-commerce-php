<?php require "./includes/header.php"; ?>

<div class="flex justify-center items-center h-screen bg-white">
    <div class="bg-white rounded-lg shadow-md p-8 shadow-black w-[60%]">
        <h1 class="text-3xl font-semibold mb-4">Contact Us</h1>
        <h2 class="text-gray-600 mb-6">Share your thought with developers</h2>
        <span id="form_error" class="text-red-500 font-bold text-center my-3"></span>
        <span id="form_success" class="text-green-500 font-bold text-center my-3"></span>
        <form class="mb-6" id="contact_form">
            <div class="mb-4">
                <input type="text" class="w-full px-4 py-2 rounded-md border border-gray-300"
                    placeholder="Enter your name" name="name" />
            </div>
            <div class="mb-4">
                <input type="email" class="w-full px-4 py-2 rounded-md border border-gray-300"
                    placeholder="Enter your email address" name="email" />
            </div>
            <div class="mb-4">
                <input type="text" class="w-full px-4 py-2 rounded-md border border-gray-300"
                    placeholder="Enter your mobile number" name="mobile" />
            </div>
            <div class="mb-4">
                <textarea class="w-full px-4 py-2 rounded-md border border-gray-300" placeholder="Enter your message"
                    name="message"></textarea>
            </div>
            <button type="submit" id="contact_submit"
                class="w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors disabled:bg-blue-200">Send
                Message</button>
        </form>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#contact_form").on("submit", function (e) {
            $("#contact_submit").attr("disabled", true);
            $("#contact_submit").text("Processing...");

            $.ajax({
                url: "http://localhost:3000/includes/contact_us.php",
                type: "post",
                data: $("#contact_form").serialize(),
                success: function (result) {
                    $("#contact_submit").attr("disabled", false);
                    $("#contact_submit").text("Send Message");

                    var data = $.parseJSON(result);

                    if (data.status === "error") {
                        $("#form_error").html(data.msg);
                    }

                    if (data.status === "success") {
                        $("#form_success").html(data.msg);
                        $("#contact_form")[0].reset();
                    }
                }
            })

            e.preventDefault();
        })
    })
</script>

<?php require "./includes/footer.php"; ?>