<div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800"><?= $title; ?></h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Book</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ISBN</th>
                                            <th>Book Title</th>
                                            <th>Book Author</th>
                                            <th>Qty</th>
                                            <th>Image</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($table as $t): ?>
                                        <tr>
                                            <td><?= $t['isbn']; ?></td>
                                            <td><?= $t['Book_title']; ?></td>
                                            <td><?= $t['Book_author']; ?></td>
                                            <td><?= $t['Book_qty']; ?></td>
                                            <td><img src="<?= $t['link_image']?>"></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>