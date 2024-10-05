<?php require "./includes/header.php"; ?>

<div class="min-h-screen pt-8 bg-white container mx-auto">
    <div class="overflow-x-scroll">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-center">Manage Banners</h2>
            <span id="form_error" class="text-red-500 font-bold text-center my-3"></span>
            <span id="form_success" class="text-green-500 font-bold text-center my-3"></span>
            <a href="./create-banner.php"
                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors disabled:bg-blue-200 w-fit">Create
                Banner</a>
        </div>
        <table class="min-w-full bg-white rounded-lg shadow-md mx-auto mt-5">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">ID</th>
                    <th class="py-3 px-6 text-left">Heading 1</th>
                    <th class="py-3 px-6 text-left">Heading 2</th>
                    <th class="py-3 px-6 text-left">Button Text</th>
                    <th class="py-3 px-6 text-left">Button Link</th>
                    <th class="py-3 px-6 text-left">Image</th>
                    <th class="py-3 px-6 text-left">Order No</th>
                    <th class="py-3 px-6 text-left">Status</th>
                    <th class="py-3 px-6 text-left">Created At</th>
                    <th class="py-3 px-6 text-left">Updated At</th>
                    <th class="py-3 px-6 text-left">Actions</th>
                </tr>
            </thead>
            <tbody id="banners"></tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
        function fetchBanners() {
            $.ajax({
                url: "http://localhost:3000/admin/includes/banner.php?admin=true",
                type: "get",
                success: function (result) {
                    let banners = $.parseJSON(result);

                    $("#banners").html("");

                    banners.forEach(banner => {
                        $("#banners").append(`
                            <tr>
                                <td class="py-3 px-6 text-left">${banner.id}</td>
                                <td class="py-3 px-6 text-left">${banner.heading1}</td>
                                <td class="py-3 px-6 text-left">${banner.heading2}</td>
                                <td class="py-3 px-6 text-left">${banner.btn_txt}</td>
                                <td class="py-3 px-6 text-left">${banner.btn_link}</td>
                                <td class="py-3 px-6 text-left">
                                    <img src="../uploads/${banner.image}" alt="banner" class="w-12 h-12 rounded-full" />
                                </td>
                                <td class="py-3 px-6 text-left">${banner.order_no}</td>
                                <td class="py-3 px-6 text-left">${banner.status == "1" ? "Active" : "Deactive"}</td>
                                <td class="py-3 px-6 text-left">${banner.createdAt}</td>
                                <td class="py-3 px-6 text-left">${banner.updatedAt}</td>
                                <td class="py-3 px-6 text-left flex items-center gap-3">
                                    <a href="./update-banner.php?id=${banner.id}" class="w-fit bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition-colors disabled:bg-green-200">Update</a>
                                    <form class="banner_delete_form">
                                        <button type="submit" class="w-fit bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition-colors disabled:bg-red-200">Delete</button>
                                        <input type="hidden" name="id" value="${banner.id}" />
                                        <input type="hidden" name="action" value="delete" />
                                    </form>
                                </td>
                            </tr>
                        `);
                    })
                }
            })
        }

        fetchBanners()

        $(document).on("submit", ".banner_delete_form", function (e) {
            e.preventDefault();

            let form = $(this);
            let button = form.find("button[type='submit']");

            $("#form_error").html("");
            $("#form_success").html("");
            button.attr("disabled", true).text("Processing...");

            $.ajax({
                url: "http://localhost:3000/admin/includes/banner.php",
                type: "post",
                data: form.serialize(),
                success: function (result) {
                    button.attr("disabled", false).text("Delete");

                    var data = $.parseJSON(result);

                    if (data.status === "error") {
                        $("#form_error").html(data.msg);
                    }

                    if (data.status === "success") {
                        $("#form_success").html(data.msg);
                        fetchBanners();
                    }
                }
            });
        });
    })
</script>

<?php require "./includes/footer.php"; ?>