<div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800"><?= $title; ?></h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Return History</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Return Id</th>
                                            <th>Book Title</th>
                                            <th>Return Date</th>
                                            <th>Due Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($history as $h): ?>
                                            <?php if($h['staff_id'] != 0): ?>
                                                <tr>
                                                    <td><?= $h['return_id']; ?></td>
                                                    <td><?= $h['Book_title']; ?></td>
                                                    <td><?= $h['return_date']; ?></td>
                                                    <td><?= $h['due_date']; ?></td>
                                                    <td>
                                                        <?php if($h['return_date'] == null):?>
                                                            <button class="btn btn-warning">Borrowed</button>
                                                        <?php elseif($h['return_date'] > $h['due_date']):?>
                                                            <button class="btn btn-danger">Overdue</button>
                                                        <?php else: ?>
                                                            <button class="btn btn-success">Returned</button>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>

                </div>