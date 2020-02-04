<?php include ROOT . '/views/layouts/header.php'; ?>

<section>
    <div class="container">
        <div class="row">

            <h3>Кабинет пользователя</h3>
            
            <h4>Привет, <?php echo $userData['name'];?>!</h4>
            <ul>
                <li><a href="/cabinet/edit">Редактировать данные</a></li>
                <?php echo $admin; ?> 
            </ul>
            
        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer.php'; ?>