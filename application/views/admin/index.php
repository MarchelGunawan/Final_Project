<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['bar']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
    var data = google.visualization.arrayToDataTable([
        ['Date', 'Borrowed Book'],
        <?php foreach($statistic as $s):?>
            <?= "['".$s['borrow_date']."', '".$s['borrowbook']."'],"; ?>
        <?php endforeach; ?>
    ]);

    var options = {
        width: 300,
        legend: { position: 'none' },
        chart: {
        title: 'Statistic of Borrowed Book',
        subtitle: 'Statistic' },
        axes: {
        x: {
            0: { side: 'top', label: 'Date'} // Top x-axis.
        }
        },
        bar: { groupWidth: "90%" }
    };

    var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
    // Convert the Classic options to Material options.
    chart.draw(data, google.charts.Bar.convertOptions(options));
    };
</script>
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Top 5 Book by rating</h1>

        <div class="row">
            <?php foreach($top5 as $r): ?>
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
        <br>
        <center>
            <h1 class="h3 mb-4 text-gray-800">Statistic In This Week</h1>
            <div id="columnchart_material" style="width: 800px; height: 500px;"></div>
        </center>
    </div>
    <br>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
