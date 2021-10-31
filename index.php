<?php
include 'includes/functions.php';
if(isset($_GET['url']) && !empty($_GET['url'])) {
    $url = strtolower(trim($_GET['url']));


    $link = db_query("SELECT * FROM links WHERE short_link = '$url'")->fetch();
    if (empty($link)) {
        include '404.php';
        die();
    }

    db_exec("UPDATE links SET views = views + 1 WHERE short_link = '$url'");
    header('Location: ' . $link['long_link']);
    exit();

}


?>
<?php include 'includes/header.php'; ?>
	<main class="container">
		<div class="row mt-5">
			<div class="col">
				<h2 class="text-center">Необходимо <a href="<?php echo get_url('register.php'); ?>">зарегистрироваться</a> или <a href="login.php">войти</a> под своей учетной записью</h2>
			</div>
		</div>
		<div class="row mt-5">
			<div class="col">
				<h2 class="text-center">Пользователей в системе: <?php echo $users_count?></h2>
			</div>
		</div>
		<div class="row mt-5">
			<div class="col">
				<h2 class="text-center">Ссылок в системе: <?php echo $links_count?></h2>
			</div>
		</div>
		<div class="row mt-5">
			<div class="col">
				<h2 class="text-center">Всего переходов по ссылкам: <?php echo $links_views?></h2>
			</div>
		</div>
	</main>
<?php include 'includes/footer.php' ?>