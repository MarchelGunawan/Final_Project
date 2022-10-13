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
                                            <th>Status</th>
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
                                                <?php if($h['staff_id'] != 0 && $h['is_active'] == 1):?>
                                                    <button class="btn btn-success">Borrowed</button>
                                                <?php elseif($h['staff_id'] != 0 && $h['is_active'] != 1): ?>
                                                    <button class="btn btn-danger">Decline</button>
                                                <?php else: ?>
                                                    <button class="btn btn-warning">Pending</button>
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