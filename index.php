<?php
								
				/**
				*
				* 	@file 				View for index-page
				* 	@author 			Tilo Krohn <tilo@dieFirma.de>
				* 	@copyright 			dieFirma
				* 	@lastmodifydate 	2021-09-24
				*
				*/
							
#*****************************************************************************#

				#***********************************#
				#********** CONFIGURATION **********#
				#***********************************#
				
				require_once('controller/index.controller.php');
							
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

	<body>

		<!-- ---------------------------------- HEADER ---------------------------------- -->

		<header class="fright">
		
			<?php if( $showLoginForm == true ): ?>
				<?= $loginMessage ?>
				
				<!-- -------- Login Form -------- -->
				<form action="" method="POST">
					<input type="hidden" name="formsentLogin">
					<input type="text" name="loginName" placeholder="Email">
					<input type="password" name="loginPassword" placeholder="Password">
					<input type="submit" value="Login">
				</form>
			
			<?php else: ?>
				<!-- -------- Links -------- -->
				<a href="?action=logout">Logout</a><br>
				<a href='dashboard.php'>zum Dashboard >></a>
			<?php endif ?>
		
		</header>
		
		<div class="clearer"></div>
		
		<br>
		<hr>
		<br>
		
		<!-- ------------------------------- HEADER ENDE --------------------------------- -->
		
		<h1>PHP-Projekt Blog</h1>
		<p><a href='<?= $_SERVER['SCRIPT_NAME'] ?>'>Alle Einträge anzeigen</a></p>
		
		<!-- ------------------------------- BLOG ENTRIES --------------------------------- -->
		
		<main class='blogs fleft'>
			
			<?php if( $blogEntriesArray ): ?>
			
				<?php foreach( $blogEntriesArray AS $blogEntry ): ?>

					<?php $dateTime = isoToEuDateTime($blogEntry->getBlog_date()) ?>
					
					<article class='blogEntry'>
					
						<a name='entry<?= $blogEntry->getBlog_id() ?>'></a>
						
						<p class='fright'><a href='?action=showCategory&id=<?= $blogEntry->getCategory()->getCat_id() ?>'>Kategorie: <?= $blogEntry->getCategory()->getCat_name() ?></a></p>
						<h2 class='clearer'><?= $blogEntry->getBlog_headline() ?></h2>

						<p class='author'><?= $blogEntry->getUser()->getUsr_firstname() ?> <?= $blogEntry->getUser()->getUsr_lastname() ?> (<?= $blogEntry->getUser()->getUsr_city() ?>) schrieb am <?= $dateTime['date'] ?> um <?= $dateTime['time'] ?> Uhr:</p>
						
						<p class='blogContent'>
						
							<?php if($blogEntry->getBlog_image()): ?>
								<img class='<?= $blogEntry->getBlog_imageAlignment() ?>' src='<?= $blogEntry->getBlog_image() ?>' alt='' title=''>
							<?php endif ?>
							
							<?= nl2br( $blogEntry->getBlog_content() ) ?>
						</p>
						
						<div class='clearer'></div>
						
						<br>
						<hr>
						
					</article>
					
				<?php endforeach ?>
				
			<?php else: ?>
				<p class="info">Noch keine Blogeinträge vorhanden.</p>
			<?php endif ?>
			
		</main>
		
		<!-- ---------------------------- BLOG ENTRIES ENDE ------------------------------- -->
		
		
		<!-- ----------------------------- CATEGORIES ------------------------------------- -->
		
		<nav class="categories fright">

			<?php if( $categoriesArray ): ?>
			
				<?php foreach( $categoriesArray AS $category ): ?>

					<?php $urlParams = "action=showCategory&id=" . $category->getCat_id() ?>

					<?php if( $currentPage == $urlParams ): ?>
						<p><a href="?<?= $urlParams ?>" class="active"><?= $category->getCat_name() ?></a></p>
					<?php else: ?>
						<p><a href="?<?= $urlParams ?>"><?= $category->getCat_name() ?></a></p>
					<?php endif ?>
				<?php endforeach ?>
				
			<?php else: ?>
				<p class="info">Noch keine Kategorien vorhanden.</p>
			<?php endif ?>
		</nav>
		
		<!-- --------------------------- CATEGORIES ENDE ---------------------------------- -->
		
		<div class="clearer"></div>

	</body>

</html>







