<?php require "./includes/header.php"; ?>

<div class="min-h-screen pt-8 bg-white container mx-auto">
    <div class="overflow-x-scroll">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-center">Manage Product Reviews</h2>
            <span id="form_error" class="text-red-500 font-bold text-center my-3"></span>
            <span id="form_success" class="text-green-500 font-bold text-center my-3"></span>
        </div>
        <table class="min-w-full bg-white rounded-lg shadow-md mx-auto mt-5">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">ID</th>
                    <th class="py-3 px-6 text-left">Name</th>
                    <th class="py-3 px-6 text-left">Email</th>
                    <th class="py-3 px-6 text-left">Product Name</th>
                    <th class="py-3 px-6 text-left">Rating</th>
                    <th class="py-3 px-6 text-left">Review</th>
                    <th class="py-3 px-6 text-left">Created At</th>
                    <th class="py-3 px-6 text-left">Updated At</th>
                    <th class="py-3 px-6 text-left">Actions</th>
                </tr>
            </thead>
            <tbody id="reviews"></tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
        function fetchReviews() {
            $.ajax({
                url: "http://localhost:3000/admin/includes/review.php?admin=true",
                type: "get",
                success: function (result) {
                    let reviews = $.parseJSON(result);

                    $("#reviews").html("");

                    reviews.forEach(review => {
                        $("#reviews").append(`
                            <tr>
                                <td class="py-3 px-6 text-left">${review.id}</td>
                                <td class="py-3 px-6 text-left">${review.name}</td>
                                <td class="py-3 px-6 text-left">${review.email}</td>
                                <td class="py-3 px-6 text-left">${review.pname}</td>
                                <td class="py-3 px-6 text-left">${review.rating}</td>
                                <td class="py-3 px-6 text-left">${review.review}</td>
                                <td class="py-3 px-6 text-left">${review.createdAt}</td>
                                <td class="py-3 px-6 text-left">${review.updatedAt}</td>
                                <td class="py-3 px-6 text-left flex items-center gap-3">
                                    <form class="review_delete_form">
                                        <button type="submit" class="w-fit bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition-colors disabled:bg-red-200">Delete</button>
                                        <input type="hidden" name="id" value="${review.id}" />
                                        <input type="hidden" name="action" value="delete" />
                                    </form>
                                </td>
                            </tr>
                        `);
                    })
                }
            })
        }

        fetchReviews();

        $(document).on("submit", ".review_delete_form", function (e) {
            e.preventDefault();

            let form = $(this);
            let button = form.find("button[type='submit']");

            $("#form_error").html("");
            $("#form_success").html("");
            button.attr("disabled", true).text("Processing...");

            $.ajax({
                url: "http://localhost:3000/admin/includes/review.php",
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
                        fetchReviews();
                    }
                }
            });
        });
    })
</script>

<?php require "./includes/footer.php"; ?>