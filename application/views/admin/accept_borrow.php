<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">List of Borrow Book</h1>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List Borrow Book</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Borrow ID</th>
                            <th>Book Title</th>
                            <th>Username</th>
                            <th>Borrow Date</th>
                            <th>Due Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($borrow as $b): ?>
                            <tr>
                                <td><?= $b['borrow_id']; ?></td>
                                <td><?= $b['Book_title']; ?></td>
                                <td><?= $b['username']; ?></td>
                                <td><?= $b['borrow_date']; ?></td>
                                <td><?= $b['due_date']; ?></td>
                                <td>
                                    <button class="btn btn-success" id="accept_borrow" data-id="<?= $b['borrow_id'] ?>" data-user="<?= $user['id']?>"><i class="fas fa-check"></i> Accept</button>
                                    <button class="btn btn-danger" id="decline_borrow" data-id="<?= $b['borrow_id'] ?>" data-user="<?= $user['id']?>" data-book="<?= $b['Book_id']?>"><i class="fas fa-times"></i> Decline</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>

<?php $this->load->view('templates/footer'); ?>
<script>
    $(document).ready(function() {
        $(".btn-success").click(function() {
            var id = $(this).data('id')
            var user_id = $(this).data('user')
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>admin/accepting_borrow',
                data: {
                    id: id,
                    user: user_id
                },
                success: function(data){
                    location.reload();
                }
            })
        })
        $(".btn-danger").click(function() {
            var id = $(this).data('id')
            var user_id = $(this).data('user')
            var book = $(this).data('book')
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>admin/declining_borrow',
                data: {
                    id: id,
                    user: user_id,
                    book: book
                },
                success: function(data){
                    location.reload();
                }
            })
        })
    })
</script>