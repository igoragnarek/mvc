<?php include ROOT . '/views/layouts/header.php'; ?>

<section>
    <div class="container">
        <div class="row">

            <div class="col-sm-4 col-sm-offset-4 padding-right">
                
                <?php if ($result): ?>
                    <p>Вы зарегистрированы!</p>
                <?php else: ?>
                    <?php if (isset($errors) && is_array($errors)): ?>
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <?php if($error != false): ?>
                                    <li> <?php echo $error; ?></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <div class="signup-form">
                        <h2>Регистрация на сайте</h2>
                        <form action="#" method="post">
                            <input type="text" name="name" placeholder="Имя"/>
                            <input type="email" name="email" placeholder="E-mail"/>
                            <input type="password" name="password" placeholder="Пароль"/>
                            <input type="submit" name="submit" class="btn btn-default" value="Регистрация" />
                        </form>
                    </div>
                
                <?php endif; ?>
                <br/>
                <br/>
            </div>
        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer.php'; ?>