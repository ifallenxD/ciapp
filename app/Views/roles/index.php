<?= $this->extend('template/admin_template'); ?>

<?= $this->section('content'); ?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Users</h1>
                
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<section class="content">
    <div class="container-fluid"></div>
        <!-- generate large card -->
        <div class="small-box bg-gradient-muted">
            <div class="card-header">
                <h3 class="card-title">Roles</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="m-3">
                    <table id="rolesTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Role</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($roles as $role) { 
                                if ($role['title'] == 'User' || $role['title'] == 'Admin' ) {
                                    echo '<tr>';
                                    echo '<td>' . $role['title'] . '</td>';
                                    echo '<td>' . $role['description'] . '</td>';
                                    echo '</tr>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="m3">
                    <table id="usersTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Active</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        
    </div>

    <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
</section>
<?= $this->endSection(); ?>


<?= $this->section('pagescripts'); ?>
<script>
    // var data =  < ?=json_encode($users) ?>;
    $(function() {
       var usersTable = $("#usersTable").DataTable({
            responsive: true,
            processing: true,
            ajax: {
                url: "<?=base_url()?>users/list",
                method: "GET",
                dataSrc: function (json) {
                    return json.data;
                }
            },
            columns: [{
                data: "id"
            },
            {
                data: "username"
            },
            {
                data: "email"
            },
            {
                data: "group"
            },
            {
                data: "active",
                render: function(data, type, row) {
                    if (data == 1) {
                        return '<span class="badge badge-success">Active</span>';
                    } else {
                        return '<span class="badge badge-danger">Inactive</span>';
                    }
                }
            },
            {
                data: null,
                render: function(data, type, row) {
                    if (data.group == 'user') {
                        return `
                            <button class="btn btn-success" id="makeAdminRow">Make Admin</button>
                        `;
                    } else if (data.group = 'admin') {
                        return `
                            <button class="btn btn-info" id="makeUserRow">Make User</button>
                        `;
                    }
                },
            },
            ],
            paging: true,
            lengthChange: true,
            searching: true,
            ordering: false,
            info: true,
            autoWidth: false,
            lengthMenu: [5, 10, 25, 50],
        });

        $("#usersTable tbody").on("click", "#makeAdminRow", function() {
            var data = usersTable.row($(this).parents("tr")).data();

            let $role = JSON.stringify({
                group: 'admin'
            });  

            //Swal fire confirm box to confirm the delete action 
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, make admin!",
                cancelButtonText: "No, cancel!",
                confirmButtonClass: "btn btn-success",
                cancelButtonClass: "btn btn-danger",
                buttonsStyling: false,
            }).then(function(result) {
                if (result.value) {
                    //If user clicks on confirm button execute the following code 
                    $.ajax({
                        method: "PUT",
                        url: "<?=base_url()?>roles/" + data.id,
                        data: $role,
                        success: function(data) {
                            //If the request is successfull reload the datatable 
                            usersTable.ajax.reload();
                            //Show a success toast 
                            Swal.fire({
                                title: "Success!",
                                text: "User has been made user.",
                                icon: "success",
                                showCancelButton: false,
                            });
                        },
                        error: function(data) {
                            //If the request is successfull reload the datatable 
                            usersTable.ajax.reload();
                            //Show a success toast 
                            Swal.fire({
                                title: "Error!",
                                text: "Something went wrong.",
                                icon: "error",
                                showCancelButton: false,
                            });
                        }
                    });
                }
            });
        });

        $("#usersTable tbody").on("click", "#makeUserRow", function() {
            var data = usersTable.row($(this).parents("tr")).data();

            let $role = JSON.stringify({
                group: 'user'
            });  

            //Swal fire confirm box to confirm the delete action 
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, make user!",
                cancelButtonText: "No, cancel!",
                confirmButtonClass: "btn btn-success",
                cancelButtonClass: "btn btn-danger",
                buttonsStyling: false,
            }).then(function(result) {
                if (result.value) {
                    //If user clicks on confirm button execute the following code 
                    $.ajax({
                        method: "PUT",
                        url: "<?=base_url()?>roles/" + data.id,
                        data: $role,
                        success: function(data) {
                            console.log(data);
                            //If the request is successfull reload the datatable 
                            usersTable.ajax.reload();
                            //Show a success toast 
                            Swal.fire({
                                title: "Success!",
                                text: "User has been made admin.",
                                icon: "success",
                                showCancelButton: false,
                            });
                        },
                        error: function(data) {
                            //If the request is successfull reload the datatable 
                            usersTable.ajax.reload();
                            //Show a success toast 
                            Swal.fire({
                                title: "Error!",
                                text: "Something went wrong.",
                                icon: "error",
                                showCancelButton: false,
                            });
                        }
                    });
                }
            });
        });
    });
</script>
<?= $this->endSection(); ?>