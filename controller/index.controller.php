<?php
#***************************************************************************************#

				#********** INITIALIZE SESSION **********#		
				session_name("blogProject");
				session_start();
				
				if( !isset($_SESSION['usr_id']) ) {
					// delete empty session
					session_destroy();
					$showLoginForm = true;
				
				} else {
					$showLoginForm = false;					
				}
				
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

				#***********************************************#
				#********** INITIALIZE VARIABLES etc. **********#
				#***********************************************#

				#*** ESTABLISH DB CONNECTION ***#				
				$pdo = dbConnect();
				
				$loginMessage 			= NULL;
				$currentPage 			= $_SERVER['QUERY_STRING'];

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
		
					// Schritt 3 URL: Verzweigung
														
					#********** LOGOUT **********#					
					if( $_GET['action'] == "logout" ) {
if(DEBUG)			echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: 'Logout' wird durchgeführt... <i>(" . basename(__FILE__) . ")</i></p>";	
						
						session_destroy();
						header("Location: index.php");
						exit();
						
					#********** KATEGORIENFILTER **********#					
					} elseif( $action == "showCategory" ) {
if(DEBUG)			echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: Kategoriefilter aktiv... <i>(" . basename(__FILE__) . ")</i></p>";				
						
						// 2. URL-Parameter auslesen
						if(isset($_GET['id'])) {
							$categoryFilterId = cleanString($_GET['id']);
						}
					}
					
				} // URL-PARAMETERVERARBEITUNG ENDE
			

#***************************************************************************************#

				#****************************************#
				#********** PROCESS FORM LOGIN **********#
				#****************************************#
						
				// Schritt 1 FORM: Prüfen, ob Formular abgeschickt wurde
				if( isset($_POST['formsentLogin']) ) {
if(DEBUG)		echo "<p class='debug hint'>Line <b>" . __LINE__ . "</b>: Formular 'Login' wurde abgeschickt... <i>(" . basename(__FILE__) . ")</i></p>";	

					// Schritt 2 FORM: Werte auslesen, entschärfen, DEBUG-Ausgabe
					$loginName 		= cleanString($_POST['loginName']);
					$loginPassword = cleanString($_POST['loginPassword']);
if(DEBUG)		echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: \$loginName: $loginName <i>(" . basename(__FILE__) . ")</i></p>";
if(DEBUG)		echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: \$loginPassword: $loginPassword <i>(" . basename(__FILE__) . ")</i></p>";

					// Schritt 3 FORM: ggf. Werte validieren
					$errorLoginName 		= checkEmail($loginName);
					$errorLoginPassword 	= checkInputString($loginPassword);
										
					#********** FINAL FORM VALIDATION **********#					
					if( $errorLoginName OR $errorLoginPassword ) {
						// Fehlerfall
if(DEBUG)			echo "<p class='debug err'>Line <b>" . __LINE__ . "</b>: Formular enthält noch Fehler! <i>(" . basename(__FILE__) . ")</i></p>";						
						$loginMessage = "<p class='error'>Benutzername oder Passwort falsch!</p>";
						
					} else {
						// Erfolgsfall
if(DEBUG)			echo "<p class='debug ok'>Line <b>" . __LINE__ . "</b>: Formular ist fehlerfrei und wird nun verarbeitet... <i>(" . basename(__FILE__) . ")</i></p>";						
									
						// Schritt 4 FORM: Daten weiterverarbeiten
						
                    $user = new USER('','',$loginName,'');

					#********** FETCH USER DATA FROM DB BY LOGIN NAME **********#						

						#********** VERIFY LOGIN NAME **********#						

                        if( !$user->fetchFromDb($pdo) ) {

							// Fehlerfall:
if(DEBUG)				echo "<p class='debug err'>Line <b>" . __LINE__ . "</b>: FEHLER: Benutzername wurde nicht in DB gefunden! <i>(" . basename(__FILE__) . ")</i></p>";
							$loginMessage = "<p class='error'>Benutzername oder Passwort falsch!!!</p>";

						} else {
							// Erfolgsfall
if(DEBUG)				    echo "<p class='debug ok'>Line <b>" . __LINE__ . "</b>: Benutzername wurde in DB gefunden. <i>(" . basename(__FILE__) . ")</i></p>";
						
							#********** VERIFY PASSWORD **********#							
							if( !password_verify( $loginPassword,$user->getUsr_password()) ) {
								// Fehlerfall
if(DEBUG)					    echo "<p class='debug err'>Line <b>" . __LINE__ . "</b>: FEHLER: Passwort stimmt nicht mit DB überein! <i>(" . basename(__FILE__) . ")</i></p>";
								$loginMessage = "<p class='error'>Benutzername oder Passwort falsch!</p>";
							
							} else {
								// Erfolgsfall
if(DEBUG)					echo "<p class='debug ok'>Line <b>" . __LINE__ . "</b>: Passwort stimmt mit DB überein. LOGIN OK. <i>(" . basename(__FILE__) . ")</i></p>";
if(DEBUG)					echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: Userdaten werden in Session geschrieben... <i>(" . basename(__FILE__) . ")</i></p>";
                            								
								#********** SAVE USER DATA INTO SESSION **********#								
								session_start();
								
								$_SESSION['usr_id'] 	   = $user->getUsr_id();
								$_SESSION['usr_firstname'] = $user->getUsr_firstname();
								$_SESSION['usr_lastname']  = $user->getUsr_lastname();
																
								#********** REDIRECT TO DASHBOARD **********#								
								header("Location: dashboard.php");
								exit;
							
							} // VERIFY PASSWORD END
							
						} // VERIFY LOGIN NAME END
						
					} // FINAL FORM VALIDATION END

				} // PROCESS FORM LOGIN END
			
#***************************************************************************************#

				#************************************************#
				#********** FETCH BLOG ENTRIES FORM DB **********#
				#************************************************#
								
				#********** FETCH ALL BLOG ENTRIES **********#
				if( !isset( $categoryFilterId ) ) {
                    
                    $blogEntriesArray = Blog::fetchAllFromDb($pdo);

				#********** FILTER BLOG ENTRIES BY CATEGORY **********#				
				} else {	

                    $blogEntriesArray = Blog::fetchAllFromDbByCategory($pdo,$categoryFilterId);

				}
							
#***************************************************************************************#

				#**********************************************#
				#********** FETCH CATEGORIES FROM DB **********#
				#**********************************************#

if(DEBUG)	echo "<p class='debug hint'>Line <b>" . __LINE__ . "</b>: Lade Kategorien... <i>(" . basename(__FILE__) . ")</i></p>";	

$categoriesArray =  Category::fetchAllFromDb($pdo);
			
#***************************************************************************************#
?>