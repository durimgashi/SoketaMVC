<div>
<!--    <form action="--><?//= route('/Test/1/2') ?><!--" method="GET">-->
<!--        <input type="text" name="" id="" value="--><?//= $variables['var1'] ?><!--"><br>-->
<!--        <input type="text" name="" id="" value="--><?//= $variables['var2'] ?><!--"><br>-->
<!---->
<!--        <button type="submit">Login</button>-->
<!--    </form>-->

    <p>Name: <?= $name ?></p>
    <p>Surname: <?= $surname ?></p>
    <p>Age: <?= $age ?></p>
    <p>Uni: <?= $university ?></p>
    <p>Work: <?= $work ?></p>
    <p>Experience: <?= json_encode($experience) ?></p>
    <p>Array 1: <?= json_encode($frontend) ?></p>
    <p>Array 2: <?= json_encode($backend) ?></p>


<!--    <a href="--><?//= route('/Test/1/2') ?><!--">aaaaaaaaa</a>-->
</div>