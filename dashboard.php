<?php
								
				/**
				*
				* 	@file 				View for dashboard-page
				* 	@author 			Tilo Krohn <tilo@dieFirma.de>
				* 	@copyright 			dieFirma
				* 	@lastmodifydate 	
				*
				*/
								
#*****************************************************************************#

				#***********************************#
				#********** CONFIGURATION **********#
				#***********************************#
				
				require_once('controller/dashboard.controller.php');
								
#**********************************************************************************#
?>

<!doctype html>

<html>

	<head>
		<meta charset="utf-8">
		<title>PHP-Projekt Blog</title>
		<link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" href="css/debug.css">
	</head>

	<body class="dashboard">

		<!--------------------------------- HEADER ----------------------------------------->
	
		<header class="fright">
			<a href="?action=logout">Logout</a><br>
			<a href="index.php"><< zum Frontend</a>
		</header>
		<div class="clearer"></div>

		<br>
		<hr>
		<br>
		
		<!-------------------------------------------------------------------------------->
		
		<h1 class="dashboard">PHP-Projekt Blog - Dashboard</h1>
		<p class="name">Aktiver Benutzer: <?= "$_SESSION[usr_firstname] $_SESSION[usr_lastname]" ?></p>
		
		<?php if( $blogMessage OR $catSuccessMessage ): ?>
		<popupBox>
			<?= $blogMessage ?>
			<?= $catSuccessMessage ?>
			<a class="button" onclick="document.getElementsByTagName('popupBox')[0].style.display = 'none'">Schließen</a>
		</popupBox>		
		<?php endif ?>
		
		<div class="fleft">			
			
			<!--------------------------- NEW BLOG ENTRY FORM -------------------------------->
			
			<h2 class="dashboard">Neuen Blog-Eintrag verfassen</h2>
			
			<!-- Form Blog-Eintrag erstellen -->
			<form action="" method="POST" enctype="multipart/form-data">
				<input class="dashboard" type="hidden" name="formsentNewBlogEntry">
				
				<br>
				<select class="dashboard bold" name="cat_id">
				<?php foreach($categoriesArray AS $category): ?>

					<?php if($newBlog->getCategory()->getCat_id() == $category->getCat_id()): ?> 
						<option value='<?= $category->getCat_id() ?>' selected><?= $category->getCat_name() ?></option>
					<?php else: ?>
						<option value='<?= $category->getCat_id() ?>'><?= $category->getCat_name() ?></option>
					<?php endif ?>
				<?php endforeach ?>
				</select>
				
				<br>
				
				<span class="error"><?= $errorHeadline ?></span><br>
				<input class="dashboard" type="text" name="blog_headline" placeholder="Überschrift" value="<?= $newBlog->getBlog_headline() ?>"><br>
				
				<label>Bild hochladen:</label><br>
				<span class="error"><?= $errorImageUpload ?></span><br>
				<input type="file" name="blog_image">
				<select class="alignment" name="blog_imageAlignment">
					<option value="fleft" <?php if($newBlog->getBlog_imageAlignment() == "fleft") echo "selected"?>>align left</option>
					<option value="fright" <?php if($newBlog->getBlog_imageAlignment() == "fright") echo "selected"?>>align right</option>
				</select>
				
				<br>
				<br>
				
				<span class="error"><?= $errorContent ?></span><br>
				<textarea class="dashboard" name="blog_content" placeholder="Text..."><?= $newBlog->getBlog_content() ?></textarea><br>
				
				<div class="clearer"></div>
				
				<input class="dashboard" type="submit" value="Veröffentlichen">
			</form>
			
			<!-------------------------------------------------------------------------------->
			
		</div>
		
		<div class="fright">
		
			<h2 class="dashboard">Neue Kategorie anlegen</h2>
			<?= $catErrorMessage ?>
			
			<!------------------------------ NEW CATEGORY FORM --------------------------------->
			
			<form class="dashboard" action="" method="POST">
				<input class="dashboard" type="hidden" name="formsentNewCategory">
				<span class="error"><?= $errorCatName ?></span><br>
				<input class="dashboard" type="text" name="cat_name" placeholder="Name der Kategorie" value="<?= $newCategory->getCat_name() ?>"><br>

				<input class="dashboard" type="submit" value="Neue Kategorie anlegen">
			</form>
		
			<!-------------------------------------------------------------------------------->
		
		</div>

		<div class="clearer"></div>
		
	</body>
</html>






