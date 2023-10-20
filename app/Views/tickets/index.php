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
                <h3 class="card-title">Manage Support Tickets</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row d-flex justify-content-end">
                    <button class="btn btn-primary" id="btn-add-ticket">Add Ticket</button>
                </div>
                <br>
                <!-- <div class="row"> -->
                    <table id="ticketsTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Office/Section/Division</th>
                                <th>Severity</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
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
    <!-- Modal Add Office -->
    <div class="modal fade" id="modalAddTicket" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ticket Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formAdd">

                        <div class="form-group">
                            <label for="title">First Name *</label>
                            <input type="text" class="form-control" name="AddFirstName" id="AddFirstName" placeholder="First Name" required />
                            <div id="AddFirstNameFeedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="title">Last Name *</label>
                            <input type="text" class="form-control" name="AddLastName" id="AddLastName" placeholder="Last Name" required />
                            <div id="AddLastNameFeedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="title">Email*</label>
                            <input type="text" class="form-control" name="AddEmail" id="AddEmail" placeholder="Email" required />
                            <div id="AddEmailFeedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="description">Office/Section/Division *</label>
                            <select class="form-control" name="AddOfficeSectionDivision" id="AddOfficeSectionDivision" required>
                                <option value="">Select Office/Section/Division</option>
                                <?php foreach ($offices as $office) : ?>
                                    <option value="<?= $office['id']?>"><?= $office['office_section_division'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="OfficeSectionDivisionFeedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="description">Description *</label>
                            <input type="text" class="form-control" name="AddOfficeDescription" id="AddOfficeDescription" placeholder="Description" required />
                            <div id="OfficeDescriptionFeedback"></div>
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
    <!-- End of Modal Add Office -->
    <!-- Modal Edit Office -->
    <div class="modal fade" id="modalEditOffice" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Office</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formEdit">
                        <input type="text" name="EditOfficeID" id="EditOfficeID" />
                        <div class="form-group">
                            <label for="title">Office Name *</label>
                            <input type="text" class="form-control" name="EditOfficeName" id="EditOfficeName" placeholder="Name" required />
                            <div id="OfficeNameFeedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="title">Office Code *</label>
                            <input type="text" class="form-control" name="EditOfficeCode" id="EditOfficeCode" placeholder="Code" required />
                            <div id="OfficeCodeFeedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="description">Description *</label>
                            <input type="text" class="form-control" name="EditOfficeDescription" id="EditOfficeDescription" placeholder="Description" required />
                            <div id="OfficeDescriptionFeedback"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary" id="btnEditOffice">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Modal Edit Office -->
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
            lengthMenu: [10, 20, 50, 100],
        });

        $("#btn-add-ticket").on("click", function() {
            $("#modalAddTicket").modal("show");
        });

        $("#officesTable tbody").on("click", "#editRow", function() {
            var data = usersTable.row($(this).parents("tr")).data();
            $("#EditOfficeID").val(data.id);
            $("#EditOfficeName").val(data.office_section_division);
            $("#EditOfficeCode").val(data.code);
            $("#EditOfficeDescription").val(data.description);
            $("#modalEditOffice").modal("show");
        });

        $("#officesTable tbody").on("click", "#deleteRow", function() {
            var data = usersTable.row($(this).parents("tr")).data();
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: "DELETE",
                        url: "<?= base_url() ?>offices/" + data.id,
                        success: function(response) {
                            if (response.status == "success") {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Records Deleted Successfuly.',
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                                usersTable.ajax.reload();
                            }
                        },
                    });
                }
            });
        });

        $("#formAdd").submit(function(event) {
            event.preventDefault();
            let formdata = $(this).serializeArray().reduce(function(obj, item) {
                obj[item.name] = item.value;
                return obj;
            }, {});

            let jsondata = JSON.stringify(formdata);

            if (this.checkValidity()) {
                //create
                $.ajax({
                    method: "POST",
                    url: "<?= base_url() ?>offices",
                    data: jsondata,
                    success: function(response) {
                        if (response.status == "success") {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Records Added Successfuly.',
                                showConfirmButton: false,
                                timer: 3000
                            });
                            clearformAddOffice();
                            usersTable.ajax.reload();
                            $("#modalAddTicket").modal("hide");
                        }          
                    },
                    error: function(response) {
                        //trigger validations
                        let errors = response.responseJSON.data;
                        // check if OfficeName has error message 
                        if (errors.office_section_division) {
                            //replace Office Section Division with Office Name 
                            let error = errors.office_section_division.replace(/Office Section Division/g, "Office Name");
                            $("#AddOfficeName").addClass("border border-danger");
                            $("#AddOfficeNameFeedback").html('<small class="text text-danger">' + error + "</small>");
                        } else {
                            $("#AddOfficeName").removeClass("border border-danger");
                            $("#AddOfficeNameFeedback").html("");
                        }
                        // check if OfficeCode has error message
                        if (errors.code) {
                            let error = errors.code.replace(/code/g, "Office Code");
                            $("#AddOfficeCode").addClass("border border-danger");
                            $("#AddOfficeCodeFeedback").html('<small class="text text-danger">' + error + "</small>");
                        } else {
                            $("#AddOfficeCode").removeClass("border border-danger");
                            $("#AddOfficeCodeFeedback").html("");
                        }
                        // check if OfficeDescription has error message
                        if (errors.description) {
                            let error =  errors.description.replace(/description/g, "Office Description");
                            $("#AddOfficeDescription").addClass("border border-danger");
                            $("#AddOfficeDescriptionFeedback").html('<small class="text text-danger">' + error + "</small>");
                        } else {
                            $("#AddOfficeDescription").removeClass("border border-danger");
                            $("#AddOfficeDescriptionFeedback").html("");
                        }
                    },
                });
                $(this).addClass("was-validated");
            }
        });

        $("#formEdit").submit(function(event) {
            event.preventDefault();
            let formdata = $(this).serializeArray().reduce(function(obj, item) {
                obj[item.name] = item.value;
                return obj;
            }, {});

            let jsondata = JSON.stringify(formdata);
            
            if (this.checkValidity()) {
                //create
                $.ajax({
                    method: "PUT",
                    url: "<?= base_url() ?>offices",
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
                            removeValidationEditOffice();
                            usersTable.ajax.reload();
                            $("#modalEditOffice").modal("hide");
                        }          
                    },
                    error: function(response) {
                        //trigger validations
                        let errors = response.responseJSON.data;
                        // check if OfficeName has error message 
                        if (errors.office_section_division) {
                            //replace Office Section Division with Office Name 
                            let error = errors.office_section_division.replace(/Office Section Division/g, "Office Name");
                            $("#EditOfficeName").addClass("border border-danger");
                            $("#EditOfficeNameFeedback").html('<small class="text text-danger">' + error + "</small>");
                        } else {
                            $("#EditOfficeName").removeClass("border border-danger");
                            $("#EditOfficeNameFeedback").html("");
                        }
                        // check if OfficeCode has error message
                        if (errors.code) {
                            let error = errors.code.replace(/code/g, "Office Code");
                            $("#EditOfficeCode").addClass("border border-danger");
                            $("#EditOfficeCodeFeedback").html('<small class="text text-danger">' + error + "</small>");
                        } else {
                            $("#EditOfficeCode").removeClass("border border-danger");
                            $("#EditOfficeCodeFeedback").html("");
                        }
                        // check if OfficeDescription has error message
                        if (errors.description) {
                            let error =  errors.description.replace(/description/g, "Office Description");
                            $("#EditOfficeDescription").addClass("border border-danger");
                            $("#EditOfficeDescriptionFeedback").html('<small class="text text-danger">' + error + "</small>");
                        } else {
                            $("#EditOfficeDescription").removeClass("border border-danger");
                            $("#EditOfficeDescriptionFeedback").html("");
                        }
                    },
                });
                $(this).addClass("was-validated");
            }
        });

        
    });

    function clearformAddOffice() {
        $("#AddOfficeName").val("");
        $("#AddOfficeCode").val("");
        $("#AddOfficeDescription").val("");
        removeValidationAddOffice();
    }

    function removeValidationAddOffice() {
        $("#AddOfficeName").removeClass("border border-danger");
        $("#AddOfficeNameFeedback").html("");
        $("#AddOfficeCode").removeClass("border border-danger");
        $("#AddOfficeCodeFeedback").html("");
        $("#AddOfficeDescription").removeClass("border border-danger");
        $("#AddOfficeDescriptionFeedback").html("");
    }

    function removeValidationEditOffice() {
        $("#EditOfficeName").removeClass("border border-danger");
        $("#EditOfficeNameFeedback").html("");
        $("#EditOfficeCode").removeClass("border border-danger");
        $("#EditOfficeCodeFeedback").html("");
        $("#EditOfficeDescription").removeClass("border border-danger");
        $("#EditOfficeDescriptionFeedback").html("");
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