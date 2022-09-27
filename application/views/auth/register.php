<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5 col-lg-7 mx-auto">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">SignUp</h1>
                        </div>
                        <form class="user" method="POST" action="<?= base_url()?>auth/register">
                            <div class="form-group">
                                <small class="text-danger"><?= form_error('username'); ?></small>
                                <input type="text" class="form-control form-control-user" id="username"
                                placeholder="Username" name="username" value="<?= set_value('username');?>">
                            </div>
                            <div class="form-group">
                                <small class="text-danger"><?= form_error('email'); ?></small>
                                <input type="text" class="form-control form-control-user" id="email"
                                placeholder="Email Address" name="email" value="<?= set_value('email'); ?>">
                            </div>
                            <small class="text-danger"><?= form_error('password'); ?></small>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="password" class="form-control form-control-user"
                                    id="password" placeholder="Password" name="password">
                                </div>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control form-control-user"
                                        id="repeatpassword" placeholder="Repeat Password" name="repeatpassword">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Register Account
                            </button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="<?= base_url()?>auth/login">Already have an account? Login!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>