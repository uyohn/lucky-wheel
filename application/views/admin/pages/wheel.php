<div class="container" id="kolesa">

    <br>
    <h2>Koleso <?php echo $wheel; ?></h2>
    <br>

    <a class="btn btn-primary btn-sm btn-block" target="_blank" href="<?php echo base_url('admin/export/wheel/' . $wheel_id); ?>">
        Export kontaktov
    </a>

    <br>

    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">Výherca</th>
            <th scope="col">Výhra</th>
            <th scope="col">Dátum</th>
            <th scope="col">Zmazať</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($winners as $winner): ?>
            <tr>
                <th><?php echo $winner->winner_mail; ?></th>
                <th><?php echo $winner->option_name; ?></th>
                <th><?php echo $winner->created; ?></th>
                <th>
                    <a href="<?php echo base_url('admin/wheel/' . $wheel . '/delete/winner/' . $winner->id); ?>">X</a>
                </th>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>


</div>
