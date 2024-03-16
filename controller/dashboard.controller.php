<?php
#***************************************************************************************#
			
				#*********************************#
				#********** SECURE PAGE **********#
				#*********************************#
				
				#********** INITIALIZE SESSION **********#
				session_name("blogProject");
				session_start();
				
				#********** CHECK FOR VALID LOGIN **********#
				if( !isset($_SESSION['usr_id']) ) {
					session_destroy();
					header("Location: index.php");
					exit();
					
				} else {
					$usrId 			= $_SESSION['usr_id'];
					$usrFirstname 	= $_SESSION['usr_firstname'];
					$usrLastname	= $_SESSION['usr_lastname'];
				}
					
#***************************************************************************************#
		
				#***********************************#
				#********** CONFIGURATION **********#
				#***********************************#
				
				require_once("include/config.inc.php");
				require_once("include/db.inc.php");
				require_once("include/form.inc.php");
				include_once("include/dateTime.inc.php");

 				#********** INCLUDE CLASSES ********#
                require_once("class/DbOperationsInterface.class.php");
                require_once("class/UserInterface.class.php");
                require_once("class/User.class.php");
                require_once("class/CategoryInterface.class.php");
                require_once("class/Category.class.php");	
                require_once("class/BlogInterface.class.php");
                require_once("class/Blog.class.php");
				
#***************************************************************************************#

				#***********************************************#
				#********** ACTIVATE OUTPUT BUFFERING **********#
				#***********************************************#
				
				ob_start();
				if( !ob_start() ) {
					// Fehlerfall
if(DEBUG)		    echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: FEHLER beim Starten des Output Bufferings! <i>(" . basename(__FILE__) . ")</i></p>\r\n";				
					
				} 
                else {
					// Erfolgsfall
if(DEBUG)		    echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Output Buffering erfolgreich gestartet. <i>(" . basename(__FILE__) . ")</i></p>\r\n";									
				}
			
#***************************************************************************************#
		
				#******************************************#
				#********** INITIALIZE VARIABLES **********#
				#******************************************#

				#*** ESTABLISH DB CONNECTION ***#
				$pdo = dbConnect();

				#*** OBJECTS ***#
                $newBlog = new Blog();
                $newCategory = new Category();
				
				$errorCatName 			= NULL;
				$errorHeadline 		= NULL;
				$errorImageUpload 	= NULL;
				$errorContent 			= NULL;
				
				$catErrorMessage		= NULL;
				$catSuccessMessage	= NULL;
				$blogMessage 			= NULL;

#***************************************************************************************#
	
				#********************************************#
				#********** PROCESS URL PARAMETERS **********#
				#********************************************#
				
				// Schritt 1 URL: Prüfen, ob Parameter übergeben wurde
				if( isset($_GET['action']) ) {
if(DEBUG)		echo "<p class='debug hint'>Line <b>" . __LINE__ . "</b>: URL-Parameter 'action' wurde übergeben... <i>(" . basename(__FILE__) . ")</i></p>";	
			
					// Schritt 2 URL: Werte auslesen, entschärfen, DEBUG-Ausgabe
					$action = cleanString($_GET['action']);
if(DEBUG)		echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: \$action = $action <i>(" . basename(__FILE__) . ")</i></p>";
		
					// Schritt 3 URL: ggf. Verzweigung
					
					
					#********** LOGOUT **********#
					if( $_GET['action'] == "logout" ) {
if(DEBUG)			echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: 'Logout' wird durchgeführt... <i>(" . basename(__FILE__) . ")</i></p>";	

						session_destroy();
						header("Location: index.php");
						exit();
					}
					
				} // URL-PARAMETERVERARBEITUNG ENDE

		
#***************************************************************************************#			
	
				#*************************************************#
				#********** PROCESS FORM 'NEW CATEGORY' **********#
				#*************************************************#
				
				// Schritt 1 FORM: Prüfen, ob Formular abgeschickt wurde
				if( isset($_POST['formsentNewCategory']) ) {
if(DEBUG)		echo "<p class='debug hint'>Line <b>" . __LINE__ . "</b>: Formular 'New Category' wurde abgeschickt... <i>(" . basename(__FILE__) . ")</i></p>";	
		
					// Schritt 2+3 FORM: Werte auslesen, entschärfen, validieren (.. mal etwas anders als Übungsbeispiel ..), DEBUG-Ausgaben
					$errorCatName = $newCategory->setCat_name($_POST['cat_name']);
if(DEBUG)		echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: Kategorie-Name: ".$newCategory->getCat_name()." <i>(" . basename(__FILE__) . ")</i></p>";
														
					#********** FINAL FORM VALIDATION **********#
					if( $errorCatName ) {
if(DEBUG)				echo "<p class='debug err'>Line <b>" . __LINE__ . "</b>: Formular enthält noch Fehler! <i>(" . basename(__FILE__) . ")</i></p>";												
					} else {
if(DEBUG)				echo "<p class='debug ok'>Line <b>" . __LINE__ . "</b>: Formular ist fehlerfrei und wird nun verarbeitet... <i>(" . basename(__FILE__) . ")</i></p>";						
						
						// Schritt 4 FORM: Daten weiterverarbeiten
						
						#********** CHECK IF CATEGORY NAME ALREADY EXISTS **********#

                        $categoryExists = $newCategory->checkIfExists($pdo);

						if( $categoryExists ) {
							// Fehlerfall
							echo "<p class='debug err'>Line <b>" . __LINE__ . "</b>: Kategorie <b> ".$newCategory->getCat_name()."</b> existiert bereits! <i>(" . basename(__FILE__) . ")</i></p>";
							$catErrorMessage = "<p class='error'>Es existiert bereits eine Kategorie mit diesem Namen!</p>"; 
						} 
                        else {
							// Erfolgsfall
if(DEBUG)				    echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: Neue Kategorie <b> ".$newCategory->getCat_name()."</b> wird gespeichert... <i>(" . basename(__FILE__) . ")</i></p>";	


							#********** SAVE CATEGORY INTO DB **********#

                            if( !$newCategory->saveToDb($pdo) ) {
								// Fehlerfall
if(DEBUG)					    echo "<p class='debug err'>Line <b>" . __LINE__ . "</b>: FEHLER beim Speichern der neuen Kategorie! <i>(" . basename(__FILE__) . ")</i></p>";
								$catErrorMessage = "<p class='error'>Fehler beim Speichern der neuen Kategorie!</p>";
																	
							} else {
								// Erfolgsfall															
if(DEBUG)					    echo "<p class='debug ok'>Line <b>" . __LINE__ . "</b>: Kategorie <b>'".$newCategory->getCat_name()."'</b> wurde erfolgreich unter der ID ".$newCategory->getCat_id()." in der DB gespeichert. <i>(" . basename(__FILE__) . ")</i></p>";								
								$catSuccessMessage = "<p class='success'>Die neue Kategorie mit dem Namen <b>'".$newCategory->getCat_name()."'</b> wurde erfolgreich gespeichert.</p>";
									
								// neues leeres Category-Object / Felder aus Formular wieder leer
								$newCategory = new Category();								
							}

                             // SAVE CATEGORY INTO DB END
							 
						} // CHECK IF CATEGORY NAME ALREADY EXISTS END
						
					} // FINAL FORM VALIDATION END

				} // PROCESS FORM 'NEW CATEGORY' END
			
#***************************************************************************************#

				#***************************************************#
				#********** PROCESS FORM 'NEW BLOG ENTRY' **********#
				#***************************************************#
				
				// Schritt 1 FORM: Prüfen, ob Formular abgeschickt wurde
				if( isset($_POST['formsentNewBlogEntry']) ) {			
if(DEBUG)		    echo "<p class='debug hint'>Line <b>" . __LINE__ . "</b>: Formular 'New Blog Entry' wurde abgeschickt... <i>(" . basename(__FILE__) . ")</i></p>";	

                    // $newBlog = new Blog();
                    $newBlog->setUser(new User ('','','','','', $_SESSION['usr_id']) );

					// Schritt 2 FORM: Daten auslesen, entschärfen, DEBUG-Ausgabe
					$newBlog->setCategory(new Category ('',$_POST['cat_id']) );
					$newBlog->setBlog_headline          ($_POST['blog_headline']);
					$newBlog->setBlog_content           ($_POST['blog_content']);
					$newBlog->setBlog_imageAlignment    ($_POST['blog_imageAlignment']);

if(DEBUG)  		echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: cat_id: ".$newBlog->getCategory()->getCat_id()."  <i>(" . basename(__FILE__) . ")</i></p>";
if(DEBUG)  		echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: blog_headline: ".$newBlog->getBlog_headline()." <i>(" . basename(__FILE__) . ")</i></p>";
if(DEBUG)  		echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: blog_imageAlignment: ".$newBlog->getBlog_content()." <i>(" . basename(__FILE__) . ")</i></p>";
if(DEBUG)  		echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: blog_content: ".$newBlog->getBlog_imageAlignment()." <i>(" . basename(__FILE__) . ")</i></p>";

					// Schritt 3 FORM: ggf. Werte validieren
					$errorHeadline = checkInputString($newBlog->getBlog_headline());
					$errorContent 	= checkInputString($newBlog->getBlog_content(), 5, 64000);


					#********** FINAL FORM VALIDATION PART I (FIELDS VALIDATION) **********#					
					if( $errorHeadline OR $errorContent) {
						// Fehlerfall
if(DEBUG)			echo "<p class='debug err'>Line <b>" . __LINE__ . "</b>: Formular enthält noch Fehler! <i>(" . basename(__FILE__) . ")</i></p>";
						
					} else {
if(DEBUG)			echo "<p class='debug ok'>Line <b>" . __LINE__ . "</b>: Formular ist fehlerfrei. Bildupload wird geprüft... <i>(" . basename(__FILE__) . ")</i></p>";

						#********** FILE UPLOAD **********#					
						// Prüfen, ob eine Datei hochgeladen wurde
						if( $_FILES['blog_image']['tmp_name'] !=  "") {
if(DEBUG)				    echo "<p class='debug hint'>Line <b>" . __LINE__ . "</b>: Bild Upload aktiv... <i>(" . basename(__FILE__) . ")</i></p>";

							// imageUpload() liefert ein Array zurück, das eine Fehlermeldung (String oder NULL) enthält
							// sowie den Pfad zum gespeicherten Bild
							$imageUploadResultArray = imageUpload($_FILES['blog_image']);
					
							// Wenn Fehler:
							if( $imageUploadResultArray['imageError'] ) {
								$errorImageUpload = $imageUploadResultArray['imageError'];
								
							// Wenn kein Fehler:
							} else {
if(DEBUG)					echo "<p class='debug ok'>Line <b>" . __LINE__ . "</b>: Bild wurde erfolgreich unter <i>" . $imageUploadResultArray['imagePath'] . "</i> gespeichert. <i>(" . basename(__FILE__) . ")</i></p>";
								// Pfad zum Bild speichern
								$newBlog->setBlog_image($imageUploadResultArray['imagePath']);
							}
						} else {
if(DEBUG)				    echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: Es wurde kein Bild hochgeladen. <i>(" . basename(__FILE__) . ")</i></p>";
							
						} // FILE UPLOAD END

						#********** FINAL FORM VALIDATION PART II (IMAGE UPLOAD) **********#					
						if( $errorImageUpload ) {
							// Fehlerfall
if(DEBUG)				    echo "<p class='debug err'>Line <b>" . __LINE__ . "</b>: Formular enthält noch Fehler (Bildupload)! <i>(" . basename(__FILE__) . ")</i></p>";
							
						} else {
if(DEBUG)				    echo "<p class='debug ok'>Line <b>" . __LINE__ . "</b>: Formular ist fehlerfrei. Blogeintrag wird in DB gespeichert... <i>(" . basename(__FILE__) . ")</i></p>";


							#********** SAVE BLOG ENTRY INTO DB **********#
			
							if( !$newBlog->saveToDb($pdo) ) {
								// Fehlerfall
if(DEBUG)					    echo "<p class='debug err'>Line <b>" . __LINE__ . "</b>: FEHLER beim Speichern des neuen Beitrags! <i>(" . basename(__FILE__) . ")</i></p>";
								$blogmessage = "<p class='error'>Fehler beim Speichern des Beitrags!</p>";
							
							} else {
								// Erfolgsfall
								
if(DEBUG)					    echo "<p class='debug ok'>Line <b>" . __LINE__ . "</b>: Neuer Beitrag erfolgreich mit der ID ".$newBlog->getBlog_id()." gespeichert. <i>(" . basename(__FILE__) . ")</i></p>";
								$blogMessage = "<p class='success'>Der Beitrag '".$newBlog->getBlog_headline()."' wurde erfolgreich gespeichert.</p>";
								
								// neuer leerer Blogeintrag / Felder aus Formular wieder leer
                                $newBlog = new Blog();
								
							} // SAVE BLOG ENTRY INTO DB END
							
						} // FINAL FORM VALIDATION PART II (IMAGE UPLOAD) END
							
					} // FINAL FORM VALIDATION PART I (FIELDS VALIDATION) END
					
				} // PROCESS FORM 'NEW BLOG ENTRY' END
			

#***************************************************************************************#
					
				#**********************************************#
				#********** FETCH CATEGORIES FROM DB **********#
				#**********************************************#

                if(DEBUG)	echo "<p class='debug hint'>Line <b>" . __LINE__ . "</b>: Lade Kategorien... <i>(" . basename(__FILE__) . ")</i></p>";	

                $categoriesArray =  Category::fetchAllFromDb($pdo);

#***************************************************************************************#			
?>