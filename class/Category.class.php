<?php
#*******************************************************************************************#

	#**********************************#
	#********** CLASS Category **********#
	#**********************************#
			
#*******************************************************************************************#
				/**
				*
				*	Class represents a Category
				*
				*/
				class Category implements CategoryInterface, DbOperationsInterface {
					
					#*******************************#
					#********** ATTRIBUTE **********#
					#*******************************#

					private $cat_id;
					private $cat_name;
					
					#*********************************#
					#********** KONSTRUKTOR **********#
					#*********************************#

					/**
					*
					*	@construct
					*	@param	String		$cat_name=NULL		Name of User
					*	@param	String		$cat_id=NULL		Record-ID given by database
					*
					*	@return	void
					*
					*/
					public function __construct ( $cat_name=NULL, $cat_id=NULL ) {

if(DEBUG_CC)			echo "<h3 class='debugClass hint'><b>Line " . __LINE__ .  "</b>: Aufruf " . __METHOD__ . "()  (<i>" . basename(__FILE__) . "</i>)</h3>\n";						

						if( $cat_id !== NULL AND $cat_id !== '' ) $this->setCat_id($cat_id);
							else $this->setCat_id(-1); // braucht anderen Wert, als NULL für Vergleich
						if( $cat_name !== NULL AND $cat_name !== '' ) $this->setCat_name($cat_name);

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
	
					#********** CAT_ID **********#
					public function getCat_id() : ?string {
						return $this->cat_id;
					}
					public function setCat_id(string $value) : void {
						$this->cat_id = cleanString($value);
					}
										
					#********** CAT_NAME **********#
					public function getCat_name() : ?string {
						return $this->cat_name;
					}
					public function setCat_name(string $value) : ?string {
						//entschärfen
						$value = cleanString($value);
						$this->cat_name = $value;
						//validieren
						$errorCatName = checkInputString($value);
						if ($errorCatName) {						
							return $errorCatName;
						} else {
							return NULL;					
						}											
					}

					#*******************************************************************************************#
										
					#****************************************#
					#********** DATENBANK-METHODEN **********#
					#****************************************#

					#********** SAVE CATEGORY DATA INTO DB **********#
					/**
					*
					*	Saves new category data into DB
					*	Writes the DB insert ID into calling categorie object
					*
					*	@param	PDO		$pdo		DB-connection object
					*
					*	@return	Boolean				true if writing was successful, else false
					*
					*/
					public function saveToDb(PDO $pdo) {

if(DEBUG_C)				echo "<h3 class='debugClass hint'><b>Line " . __LINE__ .  "</b>: Aufruf " . __METHOD__ . "() (<i>" . basename(__FILE__) . "</i>)</h3>\n";

							$sql 		= "INSERT INTO ".TABLE_CATEGORY." (cat_name) VALUES (:ph_cat_name)";
							$params 	= array("ph_cat_name" => $this->getCat_name());
							
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
if(DEBUG_DB)					echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: \$rowCount: $rowCount <i>(" . basename(__FILE__) . ")</i></p>";

							if( !$rowCount ) {
								// Fehlerfall
								return false;
							
							} else {
								// Erfolgsfall
								$this->setCat_id( $pdo->lastInsertId() );
								return true;
							}	
					}

					#*******************************************************************************************#
	
					#********** FETCHES CATEGORIES FROM DB **********#
					/**
					*
					*	Fetches all category object's data from DB
					*	Writes all object's data into objects
					*
					*	@param	PDO		$pdo		DB-connection object
					*
					*	@return	Array				blog objects
					*
					*/
					public static function fetchAllFromDb(PDO $pdo){						
						
if(DEBUG_C)				echo "<h3 class='debugClass hint'><b>Line " . __LINE__ .  "</b>: Aufruf " . __METHOD__ . "() (<i>" . basename(__FILE__) . "</i>)</h3>\n";

						$sql = "SELECT * FROM ".TABLE_CATEGORY;
						
						$params = NULL;
						
						// Schritt 2 DB: SQL-Statement vorbereiten
						$statement = $pdo->prepare($sql);
						
						// Schritt 3 DB: SQL-Statement ausführen und ggf. Platzhalter füllen
						try {	
							$statement->execute($params);								
						} catch(PDOException $error) {
if(DEBUG_DB)				echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: FEHLER: " . $error->GetMessage() . "<i>(" . basename(__FILE__) . ")</i></p>\n";										
							$dbMessage = "<h3 class='error'>Fehler beim Zugriff auf die Datenbank!</h3>";
						}

						$categoriesArray = NULL;
						
						while( $row = $statement->fetch(PDO::FETCH_ASSOC) ) {	
							//Je Schleifendurchlauf ein CategoryObjekt erstellen
							// und das Objekt in ein Array schreiben

							$categoriesArray[] = new Category (
								$row['cat_name'],
								$row['cat_id']
							);
						}

						return $categoriesArray;
					}

					#**************************************************************************************#

					#********** CHECK IF CATEGORY NAME ALREADY EXISTS IN DB **********#
					/**
					*
					*	Checks if category name already exists in Database
					*
					*	@param	PDO	$pdo		DB-connection object
					*
					*	@return	Int				Number of matching categories entries
					*
					*/

					public function checkIfExists(PDO $pdo){
						
if(DEBUG_C)				echo "<h3 class='debugClass hint'><b>Line " . __LINE__ .  "</b>: Aufruf " . __METHOD__ . "() (<i>" . basename(__FILE__) . "</i>)</h3>\n";

						$sql = "SELECT COUNT(*) FROM ".TABLE_CATEGORY." WHERE cat_name = :ph_cat_name";
						$params = array( "ph_cat_name" => $this->getCat_name() );
						
						// Schritt 2 DB: SQL-Statement vorbereiten
						$statement = $pdo->prepare($sql);
						
						// Schritt 3 DB: SQL-Statement ausführen und ggf. Platzhalter füllen
						try {	
							$statement->execute($params);								
						} catch(PDOException $error) {
if(DEBUG_DB)				echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: FEHLER: " . $error->GetMessage() . "<i>(" . basename(__FILE__) . ")</i></p>\n";										
							$dbMessage = "<h3 class='error'>Fehler beim Zugriff auf die Datenbank!</h3>";
						}
						
						$categoryExists = $statement->fetchColumn();

if(DEBUG_DB)			echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: \$categoryExists: $categoryExists <i>(" . basename(__FILE__) . ")</i></p>";
						
						return $categoryExists;

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
					public function fetchNumberOfEntries(PDO $pdo){						
if(DEBUG_C)				echo "<h3 class='debugClass hint'><b>Line " . __LINE__ .  "</b>: Aufruf " . __METHOD__ . "() (<i>" . basename(__FILE__) . "</i>)</h3>\n";						
					}
		
				} // Ende Klasse Category
							
#*******************************************************************************************#
?>

