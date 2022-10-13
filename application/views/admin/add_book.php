<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title?></h1>
    </div>
    <!-- Basic Card Example -->
    <div class="row justify-content-center">
        <div class="card shadow mb-4" style="width: 24rem">
            <form action="<?= base_url()?>admin/add_book" method="POST" enctype="multipart/form-data">
                <center><img id="image_show" src="<?= base_url()?>assets/img/book_img/default.png" class="card-img-top" style="width: 8rem;height:250px;object-fit: contain"></center>
                <div class="card-body">
                    <div class="form-group col">
                        <div class="col-xs-3 mb-2">
                            <label for="">ISBN</label>
                            <input type="text" name="isbn" id="isbn" class="form-control">
                        </div>
                        <div class="col-xs-3 mb-2">
                            <label for="">Book Title</label>
                            <input type="text" name="book_title" id="book_title" class="form-control">
                        </div>
                        <div class="col-xs-3 mb-2">
                            <label for="">Book Author</label>
                            <input type="text" name="book_author" id="book_author" class="form-control">
                        </div>
                        <div class="col-xs-3 mb-2">
                            <label for="">Publication Year</label>
                            <input type="text" name="year" id="year" class="form-control">
                        </div>
                        <div class="col-xs-3 mb-2">
                            <label for="">Quantity</label>
                            <input type="text" name="qty" id="qty" class="form-control">
                        </div>
                        <div class="col-xs-3 mb-2">
                            <label for="">Upload Image</label>
                            <input type="file" accept="image/*" name="image" id="image" onchange="loadFile(event)" class="form-control-file">
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary">Upload Book</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<?php $this->load->view('templates/footer'); ?>
<script>
    var loadFile = function(event){
        var image = document.getElementById('image_show');
        image.src = URL.createObjectURL(event.target.files[0]);
    }
</script>