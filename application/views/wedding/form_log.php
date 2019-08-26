<h2>Log Aktifitas</h2>
<hr>
<table class="table table-responsive-sm table-hover table-outline mb-0"id="table-log">
    <thead class="thead-light " >
        <tr>
            <th>No</th>
            <th>Date Time</th>
            <th>Aktifitas</th>
            <th>User</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        if (!empty($log)) {
            foreach ($log as $val) {
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= DateToIndo($val->datetime) ?></td>
                    <td><?= $val->deskripsi ?></td>
                    <td><?= $val->user_real_name ?></td>
                </tr>
                <?php
            }
        } else {
            echo "<tr><td colspan='7'>Data Log Aktifitas Masih Kosong</td></tr>";
        }
        ?>
    </tbody>
</table>
<script>
    $("#table-log").DataTable();
</script>