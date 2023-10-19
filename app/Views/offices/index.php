<?= $this->extend('template/admin_template'); ?>

<?= $this->section('content'); ?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<section class="content">
    <div class="container-fluid">
        <!-- card -->
        <!-- generate large card -->
        <div class="small-box bg-gradient-light">
            <div class="card-header">
                <!-- <h1 class="m-0"></h1> -->
                <h3 class="card-title">Manage Offices</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row d-flex justify-content-end">
                    <button class="btn btn-primary" id="btn-add-office">Add Office</button>
                </div>
                <br>
                <!-- <div class="row"> -->
                    <table id="officesTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Office</th>
                                <th>Code</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                <!-- </div> -->
            </div>
            <!-- /.card-body -->
        </div>
        
    </div>

    <!-- /.row (main row) -->
    <div class="modal fade" id="modalAddOffice" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Office</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" novalidate>
                        <input type="hidden" name="OfficeID" id="OfficeID" />
                        <div class="form-group">
                            <label for="title">Office Name *</label>
                            <input type="text" class="form-control" name="OfficeName" id="OfficeName" placeholder="Name" required />
                            <div class="valid-feedback">Looks good!</div>
                            <div class="invalid-feedback">Please enter an Office.</div>
                        </div>
                        <div class="form-group">
                            <label for="title">Office Code *</label>
                            <input type="text" class="form-control" name="OfficeCode" id="OfficeCode" placeholder="Code" required />
                            <div class="valid-feedback">Looks good!</div>
                            <div class="invalid-feedback">Please enter an Office.</div>
                        </div>
                        <div class="form-group">
                            <label for="description">Description *</label>
                            <input type="text" class="form-control" name="OfficeDescription" id="OfficeDescription" placeholder="Description" required />
                            <div class="valid-feedback">Looks good!</div>
                            <div class="invalid-feedback">Please enter a Description.</div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary" id="btnAddOffice">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>
<?= $this->section('pagescripts'); ?>
<script>
    $(function() {
       var usersTable = $("#officesTable").DataTable({
            responsive: true,
            processing: true,
            ajax: {
                url: "<?=base_url()?>offices/list",
                method: "GET",
                dataSrc: function (json) {
                    return json.data;
                }
            },
            columns: [{
                data: "id"
            },
            {
                data: "office_section_division"
            },
            {
                data: "code"
            },
            {
                data: "description"
            },
            {
                data: null,
                defaultContent: `<td>
                <button class="btn btn-primary" id="editRow">Edit</button>
                <button class="btn btn-danger" data-toggle="modal" id="deleteRow">Delete</button>
              </td>`,
            },
            ],
            paging: true,
            lengthChange: true,
            searching: true,
            ordering: false,
            info: true,
            autoWidth: true,
            lengthMenu: [5, 10, 25, 50],
        });

        $("#btn-add-office").on("click", function() {
            $("#modalAddOffice").modal("show");
        });

        $("form").submit(function(event) {
            event.preventDefault();
            let formdata = $(this).serializeArray().reduce(function(obj, item) {
                obj[item.name] = item.value;
                return obj;
            }, {});

            let jsondata = JSON.stringify(formdata);

            if (this.checkValidity()) {
                if (!formdata.id) {
                    //create
                    $.ajax({
                        method: "POST",
                        url: "<?= base_url() ?>offices",
                        data: jsondata,
                        success: function(result, textStatus, jqXHR) {
                            console.log(textStatus + ": " + jqXHR.status);
                            $(document).Toasts("create", {
                                class: "bg-success",
                                title: "Success",
                                body: "Records Created Successfuly.",
                                autohide: true,
                                delay: 3000,
                            });
                            clearform();
                            usersTable.ajax.reload();
                            $("#modalAddOffice").modal("hide");
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(textStatus + ": " + jqXHR.status + " " + errorThrown);
                            $(document).Toasts("create", {
                                class: "bg-danger",
                                title: "Error",
                                body: "Records Was Not Created.",
                                autohide: false,
                                delay: 3000,
                            });
                        },
                    });
                } else {
                    //update
                    $.ajax({
                        method: "PUT",
                        url: "<?= base_url() ?>posts/" + formdata.id,
                        data: jsondata,
                        success: function(result, textStatus, jqXHR) {
                            console.log(textStatus + ": " + jqXHR.status);
                            $(document).Toasts("create", {
                                class: "bg-success",
                                title: "Success",
                                body: "Records Updated Successfuly.",
                                autohide: true,
                                delay: 3000,
                            });
                            clearform();
                            table.ajax.reload();
                            $("#modelId").modal("hide");

                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(textStatus + ": " + jqXHR.status + " " + errorThrown);
                            $(document).Toasts("create", {
                                class: "bg-danger",
                                title: "Error",
                                body: "Records Was Not Updated.",
                                autohide: true,
                                delay: 3000,
                            });
                        },
                    });
                }
                $(this).addClass("was-validated");
            }
        });
    });

    function clearform() {
        $("#OfficeID").val("");
        $("#OfficeName").val("");
        $("#OfficeCode").val("");
        $("#OfficeDescription").val("");
    }


    $(document).ready(function() {
        'use strict';
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = $('.needs-validation');
        // Loop over them and prevent submission
        forms.each(function() {
            $(this).on('submit', function(event) {
                if (this.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                $(this).addClass('was-validated');
            });
        });
    });
</script>
<?= $this->endSection(); ?>