<div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800"><?= $title; ?></h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Borrow History</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Borrow Id</th>
                                            <th>Book Title</th>
                                            <th>Borrow Date</th>
                                            <th>Due Date</th>
                                            <th>Status Borrow</th>
                                            <th>Status Return</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($history as $h): ?>
                                        <tr>
                                            <td><?= $h['borrow_id']; ?></td>
                                            <td><?= $h['Book_title']; ?></td>
                                            <td><?= $h['borrow_date']; ?></td>
                                            <td><?= $h['due_date']; ?></td>
                                            <td>
                                                <?php if($h['staff_id'] != 0 && $h['is_active'] >= 1):?>
                                                    <button class="btn btn-success">Accepted</button>
                                                <?php elseif($h['staff_id'] != 0 && $h['is_active'] == 0): ?>
                                                    <button class="btn btn-danger">Decline</button>
                                                <?php else: ?>
                                                    <button class="btn btn-warning">Pending</button>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if(empty($h['return_date']) && $h['is_active'] == 1): ?>
                                                    <button class="btn btn-warning">Borrowed</button>
                                                <?php elseif(!empty($h['return_date']) && $h['is_active'] == 1): ?>
                                                    <button class="btn btn-primary btnupdate" data-toggle="modal" data-target="#updateModal" data-bookid="<?= $h['book_id']?>" data-borrowid="<?= $h['borrow_id']?>">Give Rating</button>
                                                <?php else: ?>
                                                    <button class="btn btn-success">Returned</button>
                                                <?php endif; ?>
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
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Give us Rating</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <form method="POST" id="form_id" class="rating">
                        <input type="hidden" value="" id="book_id">
                        <input type="hidden" value="" id="borrow_id">
                        <label>
                            <input type="radio" name="stars" value="1" />
                            <span class="icon">★</span>
                        </label>
                        <label>
                            <input type="radio" name="stars" value="2" />
                            <span class="icon">★</span>
                            <span class="icon">★</span>
                        </label>
                        <label>
                            <input type="radio" name="stars" value="3" />
                            <span class="icon">★</span>
                            <span class="icon">★</span>
                            <span class="icon">★</span>   
                        </label>
                        <label>
                            <input type="radio" name="stars" value="4" />
                            <span class="icon">★</span>
                            <span class="icon">★</span>
                            <span class="icon">★</span>
                            <span class="icon">★</span>
                        </label>
                        <label>
                            <input type="radio" name="stars" value="5" />
                            <span class="icon">★</span>
                            <span class="icon">★</span>
                            <span class="icon">★</span>
                            <span class="icon">★</span>
                            <span class="icon">★</span>
                        </label>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(".btnupdate").on("click", function() {
        var book_id = $(this).data('bookid');
        $("#book_id").val(book_id);
        var borrow_id = $(this).data('borrowid');
        $("#borrow_id").val(borrow_id);
    });
    $(':radio').change(function() {
        var rating = this.value;
        var user_id = "<?= $user["id"]; ?>";
        var book_id = $("#book_id").val();
        var borrow_id = $("#borrow_id").val();
        $.ajax({
            url: "<?= base_url('User/rating'); ?>",
            type: "POST",
            data: {
                rating: rating,
                user_id: user_id,
                book_id: book_id,
                borrow_id: borrow_id
            },
            success: function(data) {
                location.reload()
            },
            error: function(data) {
                console.log(data);
            }
        })
    });
</script>