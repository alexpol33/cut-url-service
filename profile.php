<?php
include 'includes/functions.php';

if (isset($_POST['post_id']) && !empty($_POST['post_id'])){
    delete_link($_POST['post_id']);
}

include 'includes/profile_header.php';
?>
<main class="container">
    <?php if(!empty($success)){ ?>
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            <?php echo $success?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php }?>
    <?php if(!empty($error)){ ?>
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            <?php echo $error?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php }?>
		<div class="row mt-5">
			<table class="table table-striped">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Ссылка</th>
						<th scope="col">Сокращение</th>
						<th scope="col">Переходы</th>
						<th scope="col">Действия</th>
					</tr>
				</thead>
				<tbody>
                <?php $i = 1; foreach ($links as $link){ $id = $link['id'] ?>
					<tr>
						<th scope="row"><?php echo $i?></th>
						<td><a href="<?php echo $link['long_link']?>" target="_blank"><?php echo $link['long_link']?></a></td>
						<td class="short-link"><?php echo HOST . '/' . $link['short_link']?></td>
						<td><?php echo $link['views']?></td>
						<td>
                            <form action="" method="post">
                                <input name="post_id" value="<?php echo $id?>" class="d-none">
                                <a href="#" class="btn btn-primary btn-sm copy-btn" title="Скопировать в буфер" data-clipboard-text="<?php echo HOST . '/' . $link['short_link']?>"><i class="bi bi-files"></i></a>
							    <button type="submit" class="btn btn-danger btn-sm" title="Удалить"><i class="bi bi-trash"></i></button>
                            </form>
						</td>
					</tr>
                <?php $i++; } ?>
				</tbody>
			</table>
		</div>
	</main>
	<div aria-live="polite" aria-atomic="true" class="position-relative">
		<div class="toast-container position-absolute top-0 start-50 translate-middle-x">
			<div class="toast align-items-center text-white bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
				<div class="d-flex">
					<div class="toast-body">
						Ссылка скопирована в буфер
					</div>
					<button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
				</div>
			</div>
		</div>
	</div>
<?php include 'includes/profile_footer.php'; ?>
