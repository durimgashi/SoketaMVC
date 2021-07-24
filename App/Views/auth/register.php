<!--<div>-->
<!--    <form action="--><?//= route('/Test/1/2') ?><!--" method="GET">-->
<!--        <input type="text" name=""><br>-->
<!--        <input type="text" name=""><br>-->
<!---->
<!--        <button type="submit">Login</button>-->
<!--    </form>-->
<!---->
<!--    <a href="--><?//= route('/Test/1/2') ?><!--">aaaaaaaaa</a>-->
<!--</div>-->


<div class="container w-30">
    <form action="<?= route('/register') ?>" method="POST" class="register-form">
        <div class="form-group">
            <label for="firstName">First Name</label><br>
            <input type="text" name="firstName" id="firstName" class="form-control">
        </div>
        <div class="form-group">
            <label for="lastName">Last Name</label><br>
            <input type="text" name="lastName" id="lastName" class="form-control">
        </div>
        <div class="form-group">
            <label for="email">Email</label><br>
            <input type="text" name="email" id="email" class="form-control">
        </div>
        <div class="form-group">
            <label for="password">Password</label><br>
            <input type="text" name="password" id="password" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>