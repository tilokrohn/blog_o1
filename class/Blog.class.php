<?php
#*******************************************************************************************#

	#**********************************#
	#********** CLASS Blog **********#
	#**********************************#
			
#*******************************************************************************************#
				/** 
				* 	 
				*	Class representing an Blog including an category object and a user object.			
				*
				*/
				class Blog implements BlogInterface, DbOperationsInterface {
					
					#*******************************#
					#********** ATTRIBUTE **********#
					#*******************************#

					private $blog_id;
					private $blog_headline;
					private $blog_image;
					private $blog_imageAlignment;
					private $blog_content;					
					private $blog_date;

					#*** CATEGORY OBJECT ***#
					private $category;
					
					#*** USER OBJECT *******#
					private $user;
				
					#*********************************#
					#********** KONSTRUKTOR **********#
					#*********************************#

					/**
					*
					*	@construct
					*   @param	Category	$category					Category object owning blog object
					*   @param	User		$user						User object owning blog object
					*	@param	String		$blog_headline=NULL			Headline of blog entry
					*	@param	String		$blog_image=NULL			Image of blog entry
					*	@param	String		$blog_imageAlignment=NULL	Image alignment of blog entry
					*	@param	String		$blog_content=NULL			Content of blog entry
					*	@param	String		$blog_date=NULL				Date of blog entry
					*	@param	String		$$blog_id=NULL				Record-ID given by database
					*
					*	@return	void
					*
					*/
					public function __construct ( $category=NULL, $user=NULL, $blog_headline=NULL, $blog_image=NULL, $blog_imageAlignment=NULL, $blog_content=NULL, $blog_date=NULL, $blog_id=NULL) {

if(DEBUG_CC)			echo "<h3 class='debugClass hint'><b>Line " . __LINE__ .  "</b>: Aufruf " . __METHOD__ . "()  (<i>" . basename(__FILE__) . "</i>)</h3>\n";						

						if( $blog_id !== NULL AND $blog_id !== '' ) $this->setBlog_id($blog_id);
						if( $blog_headline !== NULL AND $blog_headline !== '' ) $this->setBlog_headline($blog_headline);
						if( $blog_image !== NULL AND $blog_image !== '' ) $this->setBlog_image($blog_image);
						if( $blog_imageAlignment !== NULL AND $blog_imageAlignment !== '' ) $this->setBlog_imageAlignment($blog_imageAlignment);
						if( $blog_content !== NULL AND $blog_content !== '' ) $this->setBlog_content($blog_content);
						if( $blog_date !== NULL AND $blog_date !== '' ) $this->setBlog_date($blog_date);
						if( $category !== NULL AND $category !== '' ) $this->setCategory($category);
							else $this->setCategory(new Category); // categorie-objekt soll nicht null, sondern vorhanden sein (sonst fehlermeldung in dashboard.php) 
						if( $user !== NULL AND $user !== '' ) $this->setUser($user);
					}
					
					#********** DESTRUCTOR **********#

					/**
					*
					*	@destruct
					*
					*	@return	void
					*
					*/
					public function __destruct() {
if(DEBUG_CD)			echo "<h3 class='debugClass hint'><b>Line " . __LINE__ .  "</b>: Aufruf " . __METHOD__ . "()  (<i>" . basename(__FILE__) . "</i>)</h3>\n";												
					}
		
					#*******************************************************************************************#

					#*************************************#
					#********** GETTER & SETTER **********#
					#*************************************#
	
					#********** BLOG_ID **********#
					public function getBlog_id() : ?string {
						return $this->blog_id;
					}
					public function setBlog_id(string $value) : void {
						$this->blog_id = cleanString($value);
					}
										
					#********** BLOG_HEADLINE **********#
					public function getBlog_headline() : ?string {
						return $this->blog_headline;
					}
					public function setBlog_headline(string $value) : void {
						$this->blog_headline = cleanString($value);
					}
										
					#********** BLOG_IMAGE **********#
					public function getBlog_image() : ?string {
						return $this->blog_image;
					}
					public function setBlog_image(string $value) : void {
						$this->blog_image = cleanString($value);
					}
										
					#********** BLOG_IMAGEALIGNMENT **********#
					public function getBlog_imageAlignment() : ?string {
						return $this->blog_imageAlignment;
					}
					public function setBlog_imageAlignment(string $value) : void {
						$this->blog_imageAlignment = cleanString($value);
					}
														
					#********** BLOG_CONTENT **********#
					public function getBlog_content() : ?string {
						return $this->blog_content;
					}
					public function setBlog_content(string $value) : void {
						$this->blog_content = cleanString($value);
					}

					#********** BLOG_DATE **********#
					public function getBlog_date() : ?string {
						return $this->blog_date;
					}
					public function setBlog_date(string $value) : void {
						$this->blog_date = cleanString($value);
					}

					#********** CATEGORY **********#
					public function getCategory() : ?Category {
						return $this->category;
					}
					public function setCategory( Category $value ) : void {
						$this->category = $value;
					}		
					
					#********** USER **********#
					public function getUser() : ?User {
						return $this->user;
					}
					public function setUser( User $value ) : void {
						$this->user = $value;
					}		
					
					#*******************************************************************************************#
		
					#****************************************#
					#********** DATENBANK-METHODEN **********#
					#****************************************#

					#********** SAVE ACCOUNT DATA INTO DB **********#
					/**
					*
					*	Saves new dataset of blog object attributes data into DB
					*	Writes the DB insert ID into calling blog object
					*
					*	@param	PDO			$pdo		DB-connection object
					*
					*	@return	Boolean					true if writing was successful, else false
					*
					*/
					public function saveToDb(PDO $pdo) {

if(DEBUG_C)				echo "<h3 class='debugClass hint'><b>Line " . __LINE__ .  "</b>: Aufruf " . __METHOD__ . "() (<i>" . basename(__FILE__) . "</i>)</h3>\n";

						$sql 		= 	"INSERT INTO ".TABLE_BLOG." (blog_headline, blog_image, blog_imageAlignment, blog_content, cat_id, usr_id)
										VALUES (:ph_headline, :ph_image, :ph_alignment, :ph_content, :ph_cat_id, :ph_usr_id) ";
						
						$params 	= array("ph_headline"	=>$this->getBlog_headline(),
											"ph_image"		=>$this->getBlog_image(),
											"ph_alignment"	=>$this->getBlog_imageAlignment(),
											"ph_content"	=>$this->getBlog_content(),
											"ph_cat_id"		=>$this->getCategory()->getCat_id(),
											"ph_usr_id"		=>$this->getUser()->getUsr_id()
											);
						
						// Schritt 2 DB: SQL-Statement vorbereiten
						$statement = $pdo->prepare($sql);
						
						// Schritt 3 DB: SQL-Statement ausführen und ggf. Platzhalter füllen
						try {	
							$statement->execute($params);								
						} catch(PDOException $error) {
if(DEBUG_DB)					echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: FEHLER: " . $error->GetMessage() . "<i>(" . basename(__FILE__) . ")</i></p>\n";										
							$dbMessage = "<h3 class='error'>Fehler beim Zugriff auf die Datenbank!</h3>";
						}
						
						// Schritt 4 DB: Schreiberfolg prüfen
						$rowCount = $statement->rowCount();							
if(DEBUG_DB)				echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: \$rowCount: $rowCount <i>(" . basename(__FILE__) . ")</i></p>";						

						if( !$rowCount ) {
							// Fehlerfall
							return false;
						
						} else {
							// Erfolgsfall
							$this->setBlog_id( $pdo->lastInsertId() );
							return true;
						}	
					}

					#*******************************************************************************************#

					#********** FETCHES BLOG ENTRYS FROM DB **********#
					/**
					*
					*	Fetches all blog object's data and related object's data from DB
					*	Writes all object's data into object
					*	Calling blog object must contain user object and categorie object
					*
					*	@param	PDO		$pdo		DB-connection object
					*
					*	@return	Array				blog objects
					*
					*/
					public static function fetchAllFromDb(PDO $pdo){
						
if(DEBUG_C)				echo "<h3 class='debugClass hint'><b>Line " . __LINE__ .  "</b>: Aufruf static " . __METHOD__ . "() (<i>" . basename(__FILE__) . "</i>)</h3>\n";

						$sql 		= 	"SELECT * FROM ".TABLE_BLOG."
						INNER JOIN ".TABLE_USER." USING(usr_id)
						INNER JOIN ".TABLE_CATEGORY." USING(cat_id)
						ORDER BY blog_date DESC
						";

						$params 	= NULL;

						// Schritt 2 DB: SQL-Statement vorbereiten
				    	$statement = $pdo->prepare($sql);

						// Schritt 3 DB: SQL-Statement ausführen und ggf. Platzhalter füllen
						try {	
							$statement->execute($params);								
						} catch(PDOException $error) {
if(DEBUG_DB)				echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: FEHLER: " . $error->GetMessage() . "<i>(" . basename(__FILE__) . ")</i></p>\n";										
							$dbMessage = "<h3 class='error'>Fehler beim Zugriff auf die Datenbank!</h3>";
						}

						$blogEntriesArray = NULL;
						
						while( $row = $statement->fetch(PDO::FETCH_ASSOC) ) {
							// Je Schleifendurchlauf ein Objekt aus dem Array $row erstellen
							// und das Objekt in ein Array schreiben
							
							$blogEntriesArray[] = new Blog ( 
								new Category(
									$row['cat_name'],
									$row['cat_id']
								),
								new User(
									$row['usr_firstname'],
									$row['usr_lastname'],
									$row['usr_email'],
									$row['usr_city'],
									$row['usr_password'],
									$row['usr_id']
								),
								$row['blog_headline'],
								$row['blog_image'],
								$row['blog_imageAlignment'],
								$row['blog_content'],
								$row['blog_date'],
								$row['blog_id']		
							);
						}

						// Array zurückgeben
						return $blogEntriesArray;

					}

					##*******************************************************************************************#

					#********** FETCHES BLOG ENTRYS BY CATEGORIE FROM DB **********#
					/**
					*
					*	Fetches blog object's data from one category (and related object's data) from DB
					*	Writes these blog object's data into objects
					*	Calling blog object must contain user object and categorie object
					*
					*	@param	PDO				$pdo				DB-connection object
					*   @param  Int|String		$categoryFilterId	category id
					*
					*	@return	Array								blog objects
					*
					*/
					public static function fetchAllFromDbByCategory(PDO $pdo,$categoryFilterId){
	
if(DEBUG_C)				echo "<p class='debug hint'>Line <b>" . __LINE__ . "</b>: Lade Blog-Einträge nach Kategorie... <i>(" . basename(__FILE__) . ")</i></p>";					
				
						$sql 		= 	"SELECT * FROM ".TABLE_BLOG."
										INNER JOIN ".TABLE_USER." USING(usr_id)
										INNER JOIN ".TABLE_CATEGORY." USING(cat_id)
										WHERE cat_id = :ph_cat_id
										ORDER BY blog_date DESC
										";
							
						$params = array( "ph_cat_id" => $categoryFilterId );

						// Schritt 2 DB: SQL-Statement vorbereiten
						$statement = $pdo->prepare($sql);

						// Schritt 3 DB: SQL-Statement ausführen und ggf. Platzhalter füllen
						try {	
							$statement->execute($params);								
						} catch(PDOException $error) {
if(DEBUG_DB)				echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: FEHLER: " . $error->GetMessage() . "<i>(" . basename(__FILE__) . ")</i></p>\n";										
							$dbMessage = "<h3 class='error'>Fehler beim Zugriff auf die Datenbank!</h3>";
						}

						$blogEntriesArray = NULL;
						
						while( $row = $statement->fetch(PDO::FETCH_ASSOC) ) {
							// Je Schleifendurchlauf ein Objekt aus dem Array $row erstellen
							// und das Objekt in ein Array schreiben
							
							$blogEntriesArray[] = new Blog ( 
								new Category(
									$row['cat_name'],
									$row['cat_id']
								),
								new User(
									$row['usr_firstname'],
									$row['usr_lastname'],
									$row['usr_email'],
									$row['usr_city'],
									$row['usr_password'],
									$row['usr_id']
								),
								$row['blog_headline'],
								$row['blog_image'],
								$row['blog_imageAlignment'],
								$row['blog_content'],
								$row['blog_date'],
								$row['blog_id']		
							);
						}

						// Array zurückgeben
						return $blogEntriesArray;

					}

					#*******************************************************************************************#
					
					public function fetchFromDb(PDO $pdo){						
if(DEBUG_C)				echo "<h3 class='debugClass hint'><b>Line " . __LINE__ .  "</b>: Aufruf " . __METHOD__ . "() (<i>" . basename(__FILE__) . "</i>)</h3>\n";											
					}					
					public function updateToDb(PDO $pdo){						
if(DEBUG_C)				echo "<h3 class='debugClass hint'><b>Line " . __LINE__ .  "</b>: Aufruf " . __METHOD__ . "() (<i>" . basename(__FILE__) . "</i>)</h3>\n";						
					}
					public function deleteFromDb(PDO $pdo){						
if(DEBUG_C)				echo "<h3 class='debugClass hint'><b>Line " . __LINE__ .  "</b>: Aufruf " . __METHOD__ . "() (<i>" . basename(__FILE__) . "</i>)</h3>\n";												
					}
					public function checkIfExists(PDO $pdo){						
if(DEBUG_C)				echo "<h3 class='debugClass hint'><b>Line " . __LINE__ .  "</b>: Aufruf " . __METHOD__ . "() (<i>" . basename(__FILE__) . "</i>)</h3>\n";						
					}
					public function fetchNumberOfEntries(PDO $pdo){
if(DEBUG_C)				echo "<h3 class='debugClass hint'><b>Line " . __LINE__ .  "</b>: Aufruf " . __METHOD__ . "() (<i>" . basename(__FILE__) . "</i>)</h3>\n";		
					}
		
				} // Ende Klasse Blog
							
#*******************************************************************************************#
?>

