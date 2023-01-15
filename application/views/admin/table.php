<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Update and Delete Book</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ISBN</th>
                            <th>Book Title</th>
                            <th>Author</th>
                            <th>Publication Year</th>
                            <th>Quantity</th>
                            <th>Image</th>
                            <th>Rating</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($table as $t): ?>
                            <?php if($t['is_active'] == 1): ?>
                                <tr>
                                    <td><?= $t['isbn']; ?></td>
                                    <td><?= $t['Book_title']; ?></td>
                                    <td><?= $t['Book_author']; ?></td>
                                    <td><?= $t['original-publication_year']; ?></td>
                                    <td><?= $t['Book_qty']; ?></td>
                                    <?php if(empty($t['image'])): ?>
                                        <td>
                                            <img src="<?= $t['link_image']?>" alt="" style="width: 8rem;height: 250px;object-fit: contain;">
                                        </td>
                                    <?php else: ?>
                                        <td>
                                            <img src="<?= base_url() ?>assets/img/book_img/<?= $t['image']?>" alt="" style="width: 8rem;height: 250px;object-fit: contain;">
                                        </td>
                                    <?php endif; ?>
                                    <td style="color: #FFCB42;">
                                        <?php $i = 0; for($i; $i < intval($t['average_rating']); $i++): ?>
                                            <span class="fas fa-star"></span>
                                        <?php endfor; ?>
                                        <?php for($j = 5; $j > $i; $j--): ?>
                                            <span class="far fa-star"></span>
                                        <?php endfor; ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-warning update_button" id="update_button" data-toggle="modal" data-target="#updateModal" 
                                        data-id="<?= $t['Book_id']?>" data-isbn="<?= $t['isbn']?>" data-title="<?= $t['Book_title']?>" 
                                        data-author="<?= $t['Book_author']?>" data-year="<?= $t['original-publication_year']?>" 
                                        data-qty="<?= $t['Book_qty']?>"><i class="fas fa-pen"></i>Update</button>
                                        <br>
                                        <a class="btn btn-danger" style="margin-top: 4px" href="<?= base_url()?>admin/delete/<?= $t['Book_id']?>"><i class="fas fa-trash-alt"></i>Delete</a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?= $this->pagination->create_links(); ?>
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
                <h5 class="modal-title" id="exampleModalLabel">Update Book Form</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <form method="POST" id="form_id">
                            <div class="form-group">
                                <label for="">ISBN</label>
                                <input type="text" name="isbn" id="isbn" class="form-control" value="">
                            </div>
                            <div class="form-group">
                                <label for="">Book Title</label>
                                <input type="text" name="book_title" id="book_title" class="form-control" value="">
                            </div>
                            <div class="form-group">
                                <label for="">Author</label>
                                <input type="text" name="book_author" id="book_author" class="form-control" value="">
                            </div>
                            <div class="form-group">
                                <label for="">Publication Year</label>
                                <input type="text" name="year" id="year" class="form-control" value="">
                            </div>
                            <div class="form-group">
                                <label for="">Quantity</label>
                                <input type="text" name="qty" id="qty" class="form-control" value="">
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary btn-user btn-block">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.update_button').click(function() {
            var book_id = $(this).data('id');
            $('#form_id').attr("action", "<?= base_url()?>admin/update/"+book_id);
            $('#isbn').val($(this).data('isbn'));
            $('#book_author').val($(this).data('author'));
            $('#book_title').val($(this).data('title'));
            $('#year').val($(this).data('year'));
            $('#qty').val($(this).data('qty'));
        })
    })
</script>