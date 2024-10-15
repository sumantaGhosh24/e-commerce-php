<?php require "./includes/header.php"; ?>

<?php
if (isset($_SESSION["USER_ID"])) {
    header("Location: index.php");
    die();
}
?>

<div class="flex justify-center items-center h-screen bg-white">
    <div class="bg-white rounded-lg shadow-md p-8 shadow-black w-[60%]">
        <h1 class="text-3xl font-semibold mb-4">User Registration</h1>
        <h2 class="text-gray-600 mb-6">Register to access our website</h2>
        <span id="form_msg" class="text-green-500 font-bold text-center my-3"></span>
        <form class="mb-6" id="register_form">
            <div class="mb-4">
                <input type="text" class="w-full px-4 py-2 rounded-md border border-gray-300"
                    placeholder="Enter your name" name="name" />
                <span id="name_error" class="text-red-500 font-bold error_field"></span>
            </div>
            <div class="mb-4">
                <input type="email" class="w-full px-4 py-2 rounded-md border border-gray-300"
                    placeholder="Enter your email" name="email" />
                <span id="email_error" class="text-red-500 font-bold error_field"></span>
            </div>
            <div class="mb-4">
                <input type="text" class="w-full px-4 py-2 rounded-md border border-gray-300"
                    placeholder="Enter your mobile number" name="mobile" />
                <span id="mobile_error" class="text-red-500 font-bold error_field"></span>
            </div>
            <div class="mb-4">
                <input type="password" class="w-full px-4 py-2 rounded-md border border-gray-300"
                    placeholder="Enter your password" name="password" />
                <span id="password_error" class="text-red-500 font-bold error_field"></span>
            </div>
            <div class="mb-4">
                <input type="password" class="w-full px-4 py-2 rounded-md border border-gray-300"
                    placeholder="Enter your confirm password" name="cf_password" />
                <span id="cf_password_error" class="text-red-500 font-bold error_field"></span>
            </div>
            <input type="hidden" name="action" value="register" />
            <button type="submit" id="register_submit"
                class="w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors disabled:bg-blue-200">Register</button>
        </form>
        <div class="text-center">
            Already have an account?<a href="login.php" class="text-blue-500 ml-2 hover:underline">login</a>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#register_form").on("submit", function (e) {
            $(".error_field").html("");
            $("#register_submit").attr("disabled", true);
            $("#register_submit").text("Processing...");

            $.ajax({
                url: "http://localhost:3000/includes/auth.php",
                type: "post",
                data: $("#register_form").serialize(),
                success: function (result) {
                    $("#register_submit").attr("disabled", false);
                    $("#register_submit").text("Register");

                    var data = $.parseJSON(result);

                    if (data.status === "error") {
                        $("#" + data.field).html(data.msg);
                    }

                    if (data.status === "success") {
                        $("#" + data.field).html(data.msg);
                        $("#register_form")[0].reset();
                        window.location.href = "login.php";
                    }
                }
            })

            e.preventDefault()
        })
    });
</script>

<?php require "./includes/footer.php"; ?>