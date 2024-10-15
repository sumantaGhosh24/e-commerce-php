<?php require "./includes/header.php"; ?>

<?php
if (!isset($_SESSION["USER_ID"])) {
    header("Location: login.php");
    die();
}
?>

<div class="bg-white min-h-screen my-20">
    <div class="container mx-auto">
        <div class="bg-white shadow-md shadow-black p-5 rounded">
            <h1 class="text-2xl font-semibold mb-4">Update User</h1>
            <span id="form_msg" class="text-green-500 font-bold text-center my-3"></span>
            <form id="update_form" class="p-4">
                <div class="mb-4">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name"
                        class="mb-2 w-full px-4 py-2 rounded-md border border-gray-300"
                        placeholder="Enter your first name" />
                    <span id="name_error" class="text-red-500 font-bold error_field"></span>
                </div>
                <div class="mb-4">
                    <label>Email Address:</label>
                    <h3 id="email" class="text-xl font-bold"></h3>
                </div>
                <div class="mb-4">
                    <label>Mobile Number:</label>
                    <h3 id="mobile" class="text-xl font-bold"></h3>
                </div>
                <input type="hidden" name="action" value="update" />
                <button type="submit" id="update_form_submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors">Update
                    User</button>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        function fetchUser() {
            $.ajax({
                url: "http://localhost:3000/includes/user.php?my=true",
                type: "get",
                success: function (result) {
                    var data = $.parseJSON(result);

                    $("#name").val(data.name);
                    $("#email").html(data.email);
                    $("#mobile").html(data.mobile);
                }
            })
        }

        fetchUser();

        $("#update_form").on("submit", function (e) {
            $(".error_field").html("");
            $("#update_form_submit").attr("disabled", true);
            $("#update_form_submit").text("Processing...");

            $.ajax({
                url: "http://localhost:3000/includes/user.php",
                type: "post",
                data: $("#update_form").serialize(),
                success: function (result) {
                    $("#update_form_submit").attr("disabled", false);
                    $("#update_form_submit").text("Update User Data");

                    var data = $.parseJSON(result);

                    if (data.status === "error") {
                        $("#" + data.field).html(data.msg);
                    }

                    if (data.status === "success") {
                        $("#" + data.field).html(data.msg);
                        $("#update_form")[0].reset();
                        fetchUser()
                    }
                }
            })

            e.preventDefault()
        })
    })
</script>

<?php require "./includes/footer.php"; ?>