<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Recommendation Book</h1>
    </div>
    <div class="row">
        <?php foreach($response as $r): ?>
            <!-- Basic Card Example -->
            <a href="<?= base_url()?>user/borrow_book/<?= $r['Book_id']?>">
                <div class="col">
                    <div class="card shadow mb-4" style="width: 14rem;height: 26rem;">
                        <center><img src="<?= $r['link_image']?>" class="card-img-top" style="width: 8rem;height: 250px;object-fit: contain"></center>
                        <div class="card-body">
                            <h6 class="m-0 font-weight-bold text-primary"><?= $r['Book_title']; ?></h6>
                            <p>Author: <?= $r['Book_author']; ?></p>
                        </div>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>
</div>
