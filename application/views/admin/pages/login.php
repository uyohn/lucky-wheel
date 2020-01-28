<div class="row mt-5">
    <div class="container">
        <form style="background: #eee; padding: 20px 30px 30px;-webkit-box-shadow: 0px 0px 17px 0px rgba(130,130,130,1);-moz-box-shadow: 0px 0px 17px 0px rgba(130,130,130,1);box-shadow: 0px 0px 17px 0px rgba(130,130,130,1);" class="col-md-6 offset-md-3" method="post"
              action="<?php echo base_url('admin/login'); ?>">

            <?php if (isset($errors)): ?>
                <?php foreach ($errors as $error): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <div class="form-group">
                <label for="admin_name">Meno</label>
                <input name="name" type="text" class="form-control" id="admin_name">
            </div>
            <div class="form-group">
                <label for="admin_password">Heslo</label>
                <input name="password" type="password" class="form-control" id="admin_password">
            </div>
            <button type="submit" class="btn btn-block btn-primary">Prihlásiť</button>
        </form>
    </div>
</div>