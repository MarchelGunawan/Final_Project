<!-- Begin Page Content -->
<div class="container-fluid">
        <?php if($user['role_id'] != 2): ?>

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"><?= $title?></h1>
        </div>

        <h1 class="h4 mb-0 text-gray-800">Recommendation for today</h1>
        <div class="row">
            <?php foreach($response as $r): ?>
                <div class="col-sm">
                    <a href="<?= base_url()?>user/borrow_book/<?= $r['Book_id']?>" style="text-decoration: none">
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
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
            You don't have permission to access this menu
    </div>
    <!-- the end of container fluid -->
    <?php endif; ?>
</div>
</div>
<!-- End of Main Content -->
            