<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Returning Book page</h1>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List Returning Book</h6>
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
                        <?php foreach($return as $r): ?>
                            <tr>
                                <td><?= $r['borrow_id']; ?></td>
                                <td><?= $r['Book_title']; ?></td>
                                <td><?= $r['username']; ?></td>
                                <td><?= $r['borrow_date']; ?></td>
                                <td><?= $r['due_date']; ?></td>
                                <?php if(empty($r['return_date'])): ?>
                                    <td>
                                        <button class="btn btn-primary returnBook" id="return_book" data-id="<?= $r['borrow_id']; ?>" data-user="<?= $user['id']?>" data-book="<?= $r['Book_id']?>"><i class="fas fa-fw fa-dolly"></i> Return Book</button>
                                    </td>
                                <?php else: ?>
                                    <td>
                                        <button class="btn btn-success" id="return_book" disabled><i class="fas fa-fw fa-dolly"></i> Returned</button>
                                    </td> 
                                <?php endif; ?>
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
        $('.returnBook').click(function() {
            var id = $(this).data('id');
            var user = $(this).data('user');
            var book = $(this).data('book');
            $.ajax({
                type: 'POST',
                url: '<?= base_url()?>admin/accept_return_book',
                data: {
                    id: id,
                    user: user,
                    book: book
                },
                success: function(data) {
                    location.reload();
                }
            })
        })
    })
</script>