<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Recommendation Book for <?= $user['username']; ?></h1>
    </div>
    <div class="row justify-content-center">
        <?php foreach($response as $r): ?>
            <!-- Basic Card Example -->
            <a href="<?= base_url()?>user/borrow_book/<?= $r['Book_id']?>" style="text-decoration: none">
                <div class="col">
                    <div class="card shadow mb-4" style="width: 16rem;height: 30rem;">
                        <center><img src="<?= $r['link_image']?>" class="card-img-top" style="width: 8rem;height: 250px;object-fit: contain"></center>
                        <div class="card-body">
                            <h6 class="m-0 font-weight-bold text-primary"><?= $r['Book_title']; ?></h6>
                            <p style="color: grey;">Author: <?= $r['Book_author']; ?></p>
                        </div>
                        <div class="card-footer justify-content-center" style="color: #FFCB42;">
                            <?php $i = 0; for($i; $i < intval($r['average_rating']); $i++): ?>
                                <span class="fas fa-star"></span>
                            <?php endfor; ?>
                            <?php for($j = 5; $j > $i; $j--): ?>
                                <span class="far fa-star"></span>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>
</div>
