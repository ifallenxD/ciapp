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
                        <h3><?= $totalusers ?></h3>

                        <p>Total Users</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="<?= base_url() ?>user" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-gradient-success">
                    <div class="inner">
                        <h3><?= $totalactiveusers ?></h3>

                        <p>Total Active Users</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="<?= base_url() ?>user" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
                            <th>Status</th>
                            <th>Status Message</th>
                            <th>Active</th>
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
</section>
<?= $this->endSection(); ?>


<?= $this->section('pagescripts'); ?>
<script>
    $(function() {
       var usersTable = $("#usersTable").DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?= base_url() ?>users/list",
                type: "POST",
            },
            columns: [{
                data: "id"
            },
            {
                data: "username"
            },
            {
                data: "status"
            },
            {
                data: "status_message"
            },
            {
                data: "active"
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
            autoWidth: false,
            lengthMenu: [5, 10, 25, 50],
        });
    });
</script>
<?= $this->endSection(); ?>