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
                                <th class="d-none">Office Section Division ID</th>
                                <th class="d-none">Ticket Category ID</th>
                                <th class="d-none">Ticket State ID</th>
                                <th class="d-none">Created By</th>
                                <th class="d-none">Remarks</th>
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
                        <!-- Get the ID of the ticket state 'Pending' -->
                        <input type="hidden" name="CurrentUserID" id="CurrentUserID" value="<?= $_SESSION['user']['id']; ?>" />
                        <?php 
                            $ticket_state_id = "";
                            foreach ($ticket_states as $ticket_state) {
                                if ($ticket_state['state'] == "Pending") {
                                    $ticket_state_id =  $ticket_state['id'];
                                }
                            }
                        ?>
                        <input type="hidden" name="AddTicketStateID" id="AddTicketStateID" value="<?=$ticket_state_id?>"/>
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
                            <select class="form-control" name="AddOfficeSectionDivisionID" id="AddOfficeSectionDivisionID" required>
                                <option value="">Select Office/Section/Division</option>
                                <?php foreach ($offices as $office) : ?>
                                    <option value="<?= $office['id']?>"><?= $office['office_section_division'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="AddOfficeSectionDivisionFeedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="description">Severity *</label>
                            <select class="form-control" name="AddTicketCategoryID" id="AddTicketCategoryID" required>
                                <option value="">Select Severity</option>
                                <?php foreach ($ticket_categories as $ticket_category) : ?>
                                    <option value="<?= $ticket_category['id']?>"><?= $ticket_category['ticket_category'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="AddTicketCategoryIDFeedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="description">Description *</label>
                            <textarea class="form-control" name="AddDescription" id="AddDescription" placeholder="Description" required rows="5"></textarea>
                            <div id="AddDescriptionFeedback"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary" id="btnAddTicket">
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
    <div class="modal fade" id="modalEditTicket" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Ticket</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formEdit">
                        <!-- Get the ID of the ticket state 'Pending' -->
                        <input type="hidden" name="EditCurrentUserID" id="EditCurrentUserID" value="<?= $_SESSION['user']['id']; ?>" />
                        <input type="hidden" name="EditTicketID" id="EditTicketID" />
                        <div class="form-group">
                            <label for="EditTicketStateID">State *</label>
                            <select class="form-control" name="EditTicketStateID" id="EditTicketStateID" required>
                                <?php foreach ($ticket_states as $ticket_state) : ?>
                                    <option value="<?= $ticket_state['id']?>"><?= $ticket_state['state'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="EditTicketStateFeedback"></div>    
                        </div>
                        <div class="form-group">
                            <label for="EditRemarks">Remarks *</label>
                            <textarea class="form-control" name="EditRemarks" id="EditRemarks" placeholder="Remarks" required rows="5"></textarea>
                            <div id="EditRemarksFeedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="title">First Name</label>
                            <input type="text" class="form-control" name="EditFirstName" id="EditFirstName" placeholder="First Name" readonly />    
                            <div id="EditFirstNameFeedback"></div>
                        </div>    
                        <div class="form-group">
                            <label for="title">Last Name</label>
                            <input type="text" class="form-control" name="EditLastName" id="EditLastName" placeholder="Last Name" readonly />
                            <div id="EditLastNameFeedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="title">Email</label>
                            <input type="text" class="form-control" name="EditEmail" id="EditEmail" placeholder="Email" readonly />
                            <div id="EditEmailFeedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="description">Office/Section/Division *</label>
                            <select class="form-control" name="EditOfficeSectionDivisionIDDisabled" id="EditOfficeSectionDivisionIDDisabled" disabled>
                                <?php foreach ($offices as $office) : ?>
                                    <option value="<?= $office['id']?>"><?= $office['office_section_division'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <select class="form-control" name="EditOfficeSectionDivisionID" id="EditOfficeSectionDivisionID" hidden>
                                <?php foreach ($offices as $office) : ?>
                                    <option value="<?= $office['id']?>"><?= $office['office_section_division'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="EditOfficeSectionDivisionIDFeedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="description">Severity *</label>
                            <select class="form-control" name="EditTicketCategoryIDDisabled" id="EditTicketCategoryIDDisabled" disabled>
                                <?php foreach ($ticket_categories as $ticket_category) : ?>
                                    <option value="<?= $ticket_category['id']?>"><?= $ticket_category['ticket_category'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <select class="form-control" name="EditTicketCategoryID" id="EditTicketCategoryID" hidden>
                                <?php foreach ($ticket_categories as $ticket_category) : ?>
                                    <option value="<?= $ticket_category['id']?>"><?= $ticket_category['ticket_category'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="EditTicketCategoryIDFeedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="description">Description *</label>
                            <textarea class="form-control" name="EditDescription" id="EditDescription" placeholder="Description" readonly rows="5"></textarea>
                            <div id="EditDescription"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary" id="btnEditTicket">
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
       var ticketsTable = $("#ticketsTable").DataTable({
            responsive: true,
            processing: true,
            ajax: {
                url: "<?=base_url()?>tickets/list",
                method: "GET",
                dataSrc: function (json) {
                    return json.data;
                }
            },
            columns: [{
                data: "id"
            },
            {
                data: "first_name"
            },
            {
                data: "last_name"
            },
            {
                data: "email"
            },
            {
                data: "office_section_division"
            },
            {
                data: "ticket_category", 
                render: function(data, type, row) {
                    if (row.ticket_category == "Low") {
                        return '<div class="text-white bg-info">' + (row.ticket_category).charAt(0).toUpperCase() + '</div>';
                    } else if (row.ticket_category == "Medium") {
                        return '<div class="text-white bg-warning">' + (row.ticket_category).charAt(0).toUpperCase() + '</div>';
                    } else if (row.ticket_category == "High") {
                        return '<div class="text-white" style="background: #FF8800;">' + (row.ticket_category).charAt(0).toUpperCase() + '</div>';
                    } else if (row.ticket_category == "Critical") {
                        return '<div class="text-white bg-danger">' + (row.ticket_category).charAt(0).toUpperCase() + '</div>';
                    }
                }
            },
            {
                data: "description"
            },
            {
                data: null,
                render: function(data, type, row) {
                    if (row.ticket_state == "Resolved") {
                        return 'NO ACTION REQUIRED';
                    } else {
                        if ('<?=$current_user_group[0]?>' == 'admin'){
                          return `
                            <button class="btn btn-primary" id="editRow">Edit</button>
                            <button class="btn btn-danger" data-toggle="modal" id="deleteRow">Delete</button>
                          `;
                      } else {
                        if (row.ticket_state == "Pending"){
                            return ` <button class="btn btn-danger" data-toggle="modal" id="deleteRow">Delete</button>`;
                        } else {
                            return 'N/A';
                        }
                      }
                    }
                }
            },
            {
                data: "office_section_division_id", class:"d-none"
            },
            {
                data: "ticket_category_id", class:"d-none"
            },
            {
                data: "ticket_state_id", class:"d-none"
            },
            {
                data: "created_by", class:"d-none"
            },
            {
                data: "remarks", class:"d-none"
            }
            ],
            paging: true,
            lengthChange: true,
            searching: true,
            ordering: false,
            info: true,
            autoWidth: true,
            lengthMenu: [10, 20, 50, 100],
            "rowCallback": function (row, data) {
                if (data.ticket_state == "Resolved") {
                    $(row).addClass('bg-success');
                } else {
                  if (data.ticket_category == "Low") {
                      $(row).addClass('bg-info');
                  } else if (data.ticket_category == "Medium") {
                      $(row).addClass('bg-warning');
                  } else if (data.ticket_category == "High") {
                      // $(row).addClass('highseverity');
                      $(row).css("background", "#FF8800");
                  } else if (data.ticket_category == "Critical") {
                      $(row).addClass('bg-danger');
                  }
                }
            }
        });

        $("#btn-add-ticket").on("click", function() {
            $("#modalAddTicket").modal("show");
        });

        $("#ticketsTable tbody").on("click", "#editRow", function() {
            var data = ticketsTable.row($(this).parents("tr")).data();
            $("#EditTicketID").val(data.id);
            $("#EditFirstName").val(data.first_name);
            $("#EditLastName").val(data.last_name);
            $("#EditEmail").val(data.email);
            $("#EditDescription").val(data.description);
            $("#EditRemarks").val(data.remarks);
            // Select the option from EditOfficeSectionDivisionID with a value of data.office_section_division_id
            $("#EditOfficeSectionDivisionID option[value='" + data.office_section_division_id + "']").attr('selected', 'selected');
            $("#EditOfficeSectionDivisionIDDisabled option[value='" + data.office_section_division_id + "']").attr('selected', 'selected');
            $("#EditTicketCategoryIDDisabled option[value='" + data.ticket_category_id + "']").attr('selected', 'selected');
            $("#EditTicketCategoryID option[value='" + data.ticket_category_id + "']").attr('selected', 'selected');
            $("#EditTicketStateID option[value='" + data.ticket_state_id + "']").attr('selected', 'selected');
            $("#modalEditTicket").modal("show");
        });

        $("#ticketsTable tbody").on("click", "#deleteRow", function() {
            var data = ticketsTable.row($(this).parents("tr")).data();
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
                        url: "<?= base_url() ?>tickets/" + data.id,
                        success: function(response) {
                            if (response.status == "success") {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Records Deleted Successfuly.',
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                                ticketsTable.ajax.reload();
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
            console.log(jsondata);
            if (this.checkValidity()) {
                //create
                $.ajax({
                    method: "POST",
                    url: "<?= base_url() ?>tickets",
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
                            clearformAddTicket();
                            ticketsTable.ajax.reload();
                            $("#modalAddTicket").modal("hide");
                        }          
                    },
                    error: function(response) {
                        //trigger validations   
                        let errors = response.responseJSON.data;
                        // Check if AddFirstName has error message 
                        if (errors.first_name) {
                            $("#AddFirstName").addClass("border border-danger");
                            $("#AddFirstNameFeedback").html('<small class="text text-danger">' + errors.first_name + "</small>");
                        } else {
                            $("#AddFirstName").removeClass("border border-danger");
                            $("#AddFirstNameFeedback").html("");
                        }
                        // Check if AddLastName has error message
                        if (errors.last_name) {
                            $("#AddLastName").addClass("border border-danger");
                            $("#AddLastNameFeedback").html('<small class="text text-danger">' + errors.last_name + "</small>");
                        } else {
                            $("#AddLastName").removeClass("border border-danger");
                            $("#AddLastNameFeedback").html("");
                        }
                        // Check if AddEmail has error message
                        if (errors.email) {
                            $("#AddEmail").addClass("border border-danger");
                            $("#AddEmailFeedback").html('<small class="text text-danger">' + errors.email + "</small>");
                        } else {
                            $("#AddEmail").removeClass("border border-danger");
                            $("#AddEmailFeedback").html("");
                        }
                        // Check if AddOfficeSectionDivision has error message
                        if (errors.office_section_division_id) {
                            $("#AddOfficeSectionDivision").addClass("border border-danger");
                            $("#AddOfficeSectionDivisionFeedback").html('<small class="text text-danger">' + errors.office_section_division_id + "</small>");
                        } else {
                            $("#AddOfficeSectionDivision").removeClass("border border-danger");
                            $("#AddOfficeSectionDivisionFeedback").html("");
                        }
                        // Check if AddTicketCategory has error message
                        if (errors.ticket_category_id) {
                            $("#AddTicketCategory").addClass("border border-danger");
                            $("#AddTicketCategoryFeedback").html('<small class="text text-danger">' + errors.ticket_category_id + "</small>");
                        } else {
                            $("#AddTicketCategory").removeClass("border border-danger");
                            $("#AddTicketCategoryFeedback").html("");
                        }
                        // Check if AddDescription has error message
                        if (errors.description) {
                            $("#AddDescription").addClass("border border-danger");
                            $("#AddDescriptionFeedback").html('<small class="text text-danger">' + errors.description + "</small>");
                        } else {
                            $("#AddDescription").removeClass("border border-danger");
                            $("#AddDescriptionFeedback").html("");
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
                    url: "<?= base_url() ?>tickets",
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
                            removeValidationEditTicket();
                            ticketsTable.ajax.reload();
                            $("#modalEditTicket").modal("hide");
                        }          
                    },
                    error: function(response) {
                        let errors = response.responseJSON.data;
                        // Check if AddFirstName has error message 
                        if (errors.first_name) {
                            $("#EditFirstName").addClass("border border-danger");
                            $("#EditFirstNameFeedback").html('<small class="text text-danger">' + errors.first_name + "</small>");
                        } else {
                            $("#EditFirstName").removeClass("border border-danger");
                            $("#EditFirstNameFeedback").html("");
                        }
                        // Check if AddLastName has error message
                        if (errors.last_name) {
                            $("#EditLastName").addClass("border border-danger");
                            $("#EditLastNameFeedback").html('<small class="text text-danger">' + errors.last_name + "</small>");
                        } else {
                            $("#EditLastName").removeClass("border border-danger");
                            $("#EditLastNameFeedback").html("");
                        }
                        // Check if AddEmail has error message
                        if (errors.email) {
                            $("#EditEmail").addClass("border border-danger");
                            $("#EditEmailFeedback").html('<small class="text text-danger">' + errors.email + "</small>");
                        } else {
                            $("#EditEmail").removeClass("border border-danger");
                            $("#EditEmailFeedback").html("");
                        }
                        // Check if AddOfficeSectionDivision has error message
                        if (errors.office_section_division_id) {
                            $("#EditOfficeSectionDivision").addClass("border border-danger");
                            $("#EditOfficeSectionDivisionFeedback").html('<small class="text text-danger">' + errors.office_section_division_id + "</small>");
                        } else {
                            $("#EditOfficeSectionDivision").removeClass("border border-danger");
                            $("#EditOfficeSectionDivisionFeedback").html("");
                        }
                        // Check if AddTicketCategory has error message
                        if (errors.ticket_category_id) {
                            $("#EditTicketCategory").addClass("border border-danger");
                            $("#EditTicketCategoryFeedback").html('<small class="text text-danger">' + errors.ticket_category_id + "</small>");
                        } else {
                            $("#EditTicketCategory").removeClass("border border-danger");
                            $("#EditTicketCategoryFeedback").html("");
                        }
                        // Check if AddDescription has error message
                        if (errors.description) {
                            $("#EditDescription").addClass("border border-danger");
                            $("#EditDescriptionFeedback").html('<small class="text text-danger">' + errors.description + "</small>");
                        } else {
                            $("#EditDescription").removeClass("border border-danger");
                            $("#EditDescriptionFeedback").html("");
                        }
                    },
                });
                $(this).addClass("was-validated");
            }
        });

        
    });

    function clearformAddTicket() {
        $("#AddFirstName").val("");
        $("#AddLastName").val("");
        $("#AddEmail").val("");
        //select first option in dropdown list AddOfficeSectionDivision 
        $("#AddOfficeSectionDivisionID option:first").attr("selected", "selected");
        //select first option in dropdown list AddTicketCateory
        $("#AddTicketCategoryID option:first").attr("selected", "selected");
        $("#AddDescription").val("");
        removeValidationAddTicket();
    }

    function removeValidationAddTicket() {
        $("#AddFirstName").removeClass("border border-danger");
        $("#AddFirstNameFeedback").html("");
        $("#AddLastName").removeClass("border border-danger");
        $("#AddLastNameFeedback").html("");
        $("#AddEmail").removeClass("border border-danger");
        $("#AddEmailFeedback").html("");
        $("#AddOfficeSectionDivision").removeClass("border border-danger");
        $("#AddOfficeSectionDivisionFeedback").html("");
        $("#AddTicketCategory").removeClass("border border-danger");
        $("#AddTicketCategoryFeedback").html("");
        $("#AddDescription").removeClass("border border-danger");
        $("#AddDescriptionFeedback").html("");
    }

    function removeValidationEditTicket() {
        $("#EditFirstName").removeClass("border border-danger");
        $("#EditFirstNameFeedback").html("");
        $("#EditLastName").removeClass("border border-danger");
        $("#EditLastNameFeedback").html("");
        $("#EditEmail").removeClass("border border-danger");
        $("#EditEmailFeedback").html("");
        $("#EditOfficeSectionDivision").removeClass("border border-danger");
        $("#EditOfficeSectionDivisionFeedback").html("");
        $("#EditTicketCategory").removeClass("border border-danger");
        $("#EditTicketCategoryFeedback").html("");
        $("#EditDescription").removeClass("border border-danger");
        $("#EditDescriptionFeedback").html("");
        $("#EditTicketState").removeClass("border border-danger");
        $("#EditTicketStateFeedback").html("");
        $("#EditRemarks").removeClass("border border-danger");
        $("#EditRemarksFeedback").html("");
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