<?php require "./includes/header.php"; ?>

<div class="min-h-screen pt-8 bg-white container mx-auto">
    <div class="overflow-x-scroll">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-center">Manage Users</h2>
            <span id="form_error" class="text-red-500 font-bold text-center my-3"></span>
            <span id="form_success" class="text-green-500 font-bold text-center my-3"></span>
        </div>
        <table class="min-w-full bg-white rounded-lg shadow-md mx-auto mt-5">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">ID</th>
                    <th class="py-3 px-6 text-left">Name</th>
                    <th class="py-3 px-6 text-left">Email</th>
                    <th class="py-3 px-6 text-left">Mobile</th>
                    <th class="py-3 px-6 text-left">Created At</th>
                    <th class="py-3 px-6 text-left">Updated At</th>
                </tr>
            </thead>
            <tbody id="users"></tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
        function fetchUsers() {
            $.ajax({
                url: "http://localhost:3000/admin/includes/user.php?admin=true",
                type: "get",
                success: function (result) {
                    let users = $.parseJSON(result);

                    $("#users").html("");

                    users.forEach(user => {
                        $("#users").append(`
                            <tr>
                                <td class="py-3 px-6 text-left">${user.id}</td>
                                <td class="py-3 px-6 text-left">${user.name}</td>
                                <td class="py-3 px-6 text-left">${user.email}</td>
                                <td class="py-3 px-6 text-left">${user.mobile}</td>
                                <td class="py-3 px-6 text-left">${user.createdAt}</td>
                                <td class="py-3 px-6 text-left">${user.updatedAt}</td>
                            </tr>
                        `);
                    })
                }
            })
        }

        fetchUsers();
    })
</script>

<?php require "./includes/footer.php"; ?>