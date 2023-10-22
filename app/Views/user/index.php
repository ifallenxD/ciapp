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
    <div class="container-fluid">
        <!-- card -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-gradient-info">
                    <div class="inner">
                        <h3 id="totalusers"></h3>
                        <p>Total Users</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="<?= base_url() ?>users" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-gradient-success">
                    <div class="inner">
                        <h3 id="totalactiveusers"></h3>
                        <p>Total Active Users</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="<?= base_url() ?>users" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-gradient-danger">
                    <div class="inner">
                        <h3 id="totalinactiveusers"></h3>
                        <p>Total Inactive Users</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="<?= base_url() ?>users" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- generate large card -->
        <div class="small-box bg-gradient-muted">
            <div class="card-header">
                <h3 class="card-title">Users</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="usersTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Active</th>
                            <th>Status</th>
                            <th>Status Message</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
            
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        
    </div>

    <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
    <!-- Modal Edit User Details -->
    <div class="modal fade" id="modalEditUser" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formEdit">
                        <!-- Get the ID of the user to be edited -->
                        <input type="hidden" name="EditUserID" id="EditUserID" />
                        <div class="form-group">
                            <label for="EditUsername">Username *</label>
                            <input type="text" class="form-control" name="EditUsername" id="EditUsername" placeholder="Username" required/>
                            <div id="EditUsernameFeedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="title">Email *</label>
                            <input type="text" class="form-control" name="EditEmail" id="EditEmail" placeholder="Email" required />
                            <div id="EditEmailFeedback"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary" id="btnEditUser">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Modal Edit User Details -->
    <!-- Modal Edit Password -->
    <div class="modal fade" id="modalEditPassword" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Change Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formEditPassword">
                        <!-- Get the ID of the user to be edited -->
                        <input type="hidden" name="EditPasswordUserID" id="EditPasswordUserID" />
                        <div class="form-group">
                            <label for="EditPassword">Password *</label>
                            <input type="text" class="form-control" name="EditPassword" id="EditPassword" placeholder="Password" required/>
                            <div id="EditPasswordFeedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="EditConfirmPassword">Confirm Password *</label>
                            <input type="text" class="form-control" name="EditConfirmPassword" id="EditConfirmPassword" placeholder="Confirm Password" required />
                            <div id="EditConfirmPasswordFeedback"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary" id="btnEditPassword">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Modal Edit Password -->
</section>
<?= $this->endSection(); ?>


<?= $this->section('pagescripts'); ?>
<script>
    $(function() {
        displayInfo();
        //reload every 5 seconds
        setInterval(function() {
            displayInfo();
            usersTable.ajax.reload();
        }, 5000);

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
                data: "status",
                render: function(data, type, row) {
                    if (data == 'banned') {
                        return '<span class="badge badge-danger">Banned</span>';
                    } else {
                        return '<span class="badge badge-info">None</span>';
                    }
                }
            },
            {
                data:"status_message",
                render: function(data, type, row) {
                    if (data == null) {
                        return '<span> <i>None</i></span>';
                    } else {
                        return data;
                    }
                }
            },
            {
                data: null,
                render: function(data, type, row) {
                    let html = `
                        <button class="btn btn-primary" id="editRow">Edit</button>
                        <button class="btn btn-info" id="editPasswordRow">Change Password</button>
                    `;

                    if (data.active == 1) {
                        html += `
                            <button class="btn btn-danger" id="toggleUserActivityStatusRow">Make Inactive</button>
                        `;
                    } else if (data.active == 0) {
                        html += `
                            <button class="btn btn-success" id="toggleUserActivityStatusRow">Make Active</button>
                        `;
                    }

                    if (data.status == 'banned') {
                        html += `
                            <button class="btn btn-success" id="toggleUserStatusRow">Unban</button>
                        `;
                    } else {
                        html += `
                            <button class="btn btn-danger" id="toggleUserStatusRow">Ban</button>
                        `;
                    }
                    
                    return html;
                }

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

        $("#usersTable tbody").on("click", "#editRow", function() {
            var data = usersTable.row($(this).parents("tr")).data();
            $("#EditUserID").val(data.id);
            $("#EditUsername").val(data.username);
            $("#EditEmail").val(data.email);
            $("#modalEditUser").modal("show");
        });

        $("#usersTable tbody").on("click", "#editPasswordRow", function() {
            var data = usersTable.row($(this).parents("tr")).data();
            $("#EditPasswordUserID").val(data.id);
            $("#EditPassword").val('');
            $("#EditConfirmPassword").val('');
            removeValidationEditPassword();

            $("#modalEditPassword").modal("show");
        });

        $("#formEdit").submit(function(event) {
            
            event.preventDefault();
            let formdata = $(this).serializeArray().reduce(function(obj, item) {
                obj[item.name] = item.value;
                return obj;
            }, {});

            let jsondata = JSON.stringify(formdata);
            console.log(jsondata);
            if (this.checkValidity()) {
                //create
                $.ajax({
                    method: "PUT",
                    url: "<?= base_url() ?>users",
                    data: jsondata,
                    success: function(response) {
                        console.log(response);
                        if (response.status == "success") {
                           
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Records Updated Successfuly.',
                                showConfirmButton: false,
                                timer: 3000
                            });
                            removeValidationEditUser();
                            usersTable.ajax.reload();
                            $("#modalEditUser").modal("hide");
                        }          
                    },
                    error: function(response) {
                        console.log(response);
                        let errors = response.responseJSON.data;
                        // Check if AddFirstName has error message 
                        if (errors.username) {
                            $("#EditUsername").addClass("border border-danger");
                            $("#EditUsernameFeedback").html('<small class="text text-danger">' + errors.username + "</small>");
                        } else {
                            $("#EditUsername").removeClass("border border-danger");
                            $("#EditUsernameFeedback").html("");
                        }
                        // Check if AddEmail has error message
                        if (errors.email) {
                            $("#EditEmail").addClass("border border-danger");
                            $("#EditEmailFeedback").html('<small class="text text-danger">' + errors.email + "</small>");
                        } else {
                            $("#EditEmail").removeClass("border border-danger");
                            $("#EditEmailFeedback").html("");
                        }
                    },
                });
                $(this).addClass("was-validated");
            }
        });

        $("#formEditPassword").submit(function(event) {
            
            event.preventDefault();
            let formdata = $(this).serializeArray().reduce(function(obj, item) {
                obj[item.name] = item.value;
                return obj;
            }, {});


            if (formdata.EditPassword != formdata.EditConfirmPassword) {
                $("#EditPassword").addClass("border border-danger");
                $("#EditConfirmPassword").addClass("border border-danger");
                $("#EditConfirmPasswordFeedback").html('<small class="text text-danger">Password does not match.</small>');
                return false;
            } else {
                removeValidationEditPassword();
            }

            let jsondata = JSON.stringify(formdata);
            console.log(jsondata);
            if (this.checkValidity()) {
                //create
                $.ajax({
                    method: "PUT",
                    url: "<?= base_url() ?>users/changepassword",
                    data: jsondata,
                    success: function(response) {
                        if (response.status == "success") {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Records Updated Successfuly.',
                                showConfirmButton: false,
                                timer: 3000
                            });
                            removeValidationEditPassword();
                            usersTable.ajax.reload();
                            $("#modalEditPassword").modal("hide");
                        }          
                    },
                    error: function(response) {
                        let errors = response.responseJSON.data;
                        // Check if AddFirstName has error message 
                        if (errors.username) {
                            $("#EditUsername").addClass("border border-danger");
                            $("#EditUsernameFeedback").html('<small class="text text-danger">' + errors.username + "</small>");
                        } else {
                            $("#EditUsername").removeClass("border border-danger");
                            $("#EditUsernameFeedback").html("");
                        }
                        // Check if AddEmail has error message
                        if (errors.email) {
                            $("#EditEmail").addClass("border border-danger");
                            $("#EditEmailFeedback").html('<small class="text text-danger">' + errors.email + "</small>");
                        } else {
                            $("#EditEmail").removeClass("border border-danger");
                            $("#EditEmailFeedback").html("");
                        }
                    },
                });
                $(this).addClass("was-validated");
            }
        });


        $("#usersTable tbody").on("click", "#toggleUserActivityStatusRow", function() {
            var data = usersTable.row($(this).parents("tr")).data();

            let $active = 0;
            if (data.active == 0) {
                $active = 1;
            }

            let $user = JSON.stringify({
                active: $active
            });

            //swal confirmation modal 
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to change the user's activity status",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33', 
                confirmButtonText: 'Yes, change it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?=base_url()?>users/" + data.id,
                        method: "PUT",
                        data: $user,
                        dataType: "JSON",
                        success: function(response) {
                            if (response.status == "success") {
                                displayInfo();
                                usersTable.ajax.reload();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message,
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message,
                                });
                            }
                        }
                    });
                }
            });
        });

        $("#usersTable tbody").on("click", "#toggleUserStatusRow", function() {
            var data = usersTable.row($(this).parents("tr")).data();

            //swal confirmation modal 
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to change the user's activity status",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33', 
                confirmButtonText: 'Yes, change it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    if (data.status == 'banned') {
                        let user = JSON.stringify({
                            EditBanUserID: data.id,
                            EditBanMessage: null
                        });

                        $.ajax({
                            url: "<?=base_url()?>users/toggleUserStatus",
                            method: "PUT",
                            data: user,
                            dataType: "JSON",
                            success: function(response) {
                                console.log(response);
                                if (response.status == "success") {
                                    displayInfo();
                                    usersTable.ajax.reload();
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: response.message,
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: response.message,
                                    });
                                }
                            },
                            error: function(response) {
                                console.log(response);
                            }
                        });
                    } else {
                        getBanMessage().then(function(message){
                            let user = JSON.stringify({
                                EditBanUserID: data.id,
                                EditBanMessage: message
                            });

                            $.ajax({
                                url: "<?=base_url()?>users/toggleUserStatus",
                                method: "PUT",
                                data: user,
                                dataType: "JSON",
                                success: function(response) {
                                    console.log(response);
                                    if (response.status == "success") {
                                        displayInfo();
                                        usersTable.ajax.reload();
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Success',
                                            text: response.message,
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: response.message,
                                        });
                                    }
                                },
                                error: function(response) {
                                    console.log(response);
                                }
                            });
                        });
                    }
                }
            });
        });
    });

    function displayInfo(){
        //ajax 
        $.ajax({
            url: "<?=base_url()?>users/allinfo",
            method: "GET",
            dataType: "JSON",
            success: function(response) {
                $("#totalusers").html(response.totalusers);
                $("#totalactiveusers").html(response.totalactiveusers);
                $("#totalinactiveusers").html(response.totalinactiveusers);
            }
        });
    }

    function removeValidationEditUser() {
        $("#EditUsername").removeClass("border border-danger");
        $("#EditUsernameFeedback").html("");
        $("#EditEmail").removeClass("border border-danger");
        $("#EditEmailFeedback").html("");
    }

    function removeValidationEditPassword() {
        $("#EditPassword").removeClass("border border-danger");
        $("#EditPasswordFeedback").html("");
        $("#EditConfirmPassword").removeClass("border border-danger");
        $("#EditConfirmPasswordFeedback").html("");
    }

    async function getBanMessage() {
        try {
            const { value: message } = await Swal.fire({
                input: 'textarea',
                inputLabel: 'Message',
                inputPlaceholder: 'Type your message here...',
                inputAttributes: {
                    'aria-label': 'Type your message here'
                },
                showCancelButton: true,
                inputValidator: (value) => {
                    return new Promise((resolve) => {
                        value = value.trim();
                        resolve(); // validation passes
                    });
                },
            });

            return message;
        
        } catch (error) {
        // Handle the error here
        console.error('An error occurred:', error);
        }
    }


</script>
<?= $this->endSection(); ?>