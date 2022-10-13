<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Borrow Book</h1>
    </div>
    <!-- Basic Card Example -->
    <div class="row justify-content-center">
        <div class="card shadow mb-4">
            <?php if(empty($book['image'])): ?>
                <center><img src="<?= $book['link_image']?>" alt="" style="width: 8rem;height: 250px;object-fit: contain; margin-top:5px"></center>
            <?php else: ?>
                <center><img src="<?= base_url()?>/assets/img/book_img/<?= $book['image']?>" alt="" style="width: 8rem;height: 250px;object-fit: contain;margin-top:5px"></center>
            <?php endif; ?>
            <div class="card-body">
                <h6 class="m-0 font-weight-bold text-primary"><?= $book['Book_title']; ?></h6>
                <br>
                <h6 class="">ISBN&nbsp;: <?= $book['isbn']; ?></h6>
                <h6 class="">Author&nbsp;: <?= $book['Book_author']; ?></h6>
                <h6 class="">Publication Year&nbsp;: <?= $book['original-publication_year']; ?></h6>
                <h6 class="">Quantity&nbsp;: <?= $book['Book_qty']; ?></h6>
                <button class="btn btn-primary btn-user btn-block" data-toggle="modal" data-target="#borrowModal">Borrow This Book !</button>
            </div>
        </div>
    </div>
</div>
</div>
<?php $this->load->view('templates/footer'); ?>
<!-- Borrow Modal-->
<div class="modal fade" id="borrowModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Borrow Book Form</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <form action="<?= base_url()?>user/borrow_book/<?= $book['Book_id']?>" method="POST">
                            <input type="text" name="userid" value="<?= $user['id']?>" hidden>
                            <input type="text" name="bookid" value="<?= $book['Book_id']?>" hidden>
                            <div class="form-group">
                                <label for="">Username:</label>
                                <input type="text" name="username" id="username" class="form-control" value="<?= $user['username']?>" disabled>
                            </div>
                            <div class="row">
                                <div class="form-group mr-2 ml-2">
                                    <label for="">Borrow Date:</label>
                                    <input type="text" name="date" id="date" class="form-control" value="<?= Date("Y-m-d");?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="">How many day</label>
                                    <select class="form-control" name="days" id="days">
                                        <option value="3">3 Days</option>
                                        <option value="5">5 Days</option>
                                        <option value="7">7 Days</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Due Date:</label>
                                <input type="text" name="due_date" id="due_date" class="form-control" value="" disabled>
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
        $('#days').change(function() {
            if($(this).val() == "3") {
                $('#due_date').val("<?= date('Y-m-d', (strtotime('3 day', strtotime(Date("Y-m-d")))))?>");
            }else if($(this).val() == "5") {
                $('#due_date').val("<?= date('Y-m-d', (strtotime('5 day', strtotime(Date("Y-m-d")))))?>");
            }else{
                $('#due_date').val("<?= date('Y-m-d', (strtotime('7 day', strtotime(Date("Y-m-d")))))?>");
            }
        })
    });
</script>