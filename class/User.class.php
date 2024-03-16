<?php
#*******************************************************************************************#

	#**********************************#
	#********** CLASS USER **********#
	#**********************************#
			
#*******************************************************************************************#
				/**
				*
				*	Class represents a user
				*
				*/
				class User implements UserInterface, DbOperationsInterface {
					
					#*******************************#
					#********** ATTRIBUTE **********#
					#*******************************#

					private $usr_id;
					private $usr_firstName;
					private $usr_lastName;
					private $usr_email;
					private $usr_city;					
					private $usr_password;

					
					#*********************************#
					#********** KONSTRUKTOR **********#
					#*********************************#					

					/**
					*
					*	@construct
					*	@param	String	$usr_firstName=NULL			Firstname of user
					*	@param	String	$usr_lastName=NULL			Lastname of user
					*	@param	String	$usr_email=NULL				Email of user
					*	@param	String	$usr_city=NULL				City of user
					*	@param	String	$usr_password=NULL			Password of user
					*	@param	String	$usr_id=NULL				Record-ID given by database
					*
					*	@return	void
					*
					*/
					public function __construct ($usr_firstName=NULL, $usr_lastName=NULL, $usr_email=NULL, $usr_city=NULL, $usr_password=NULL, $usr_id=NULL) {

if(DEBUG_CC)			echo "<h3 class='debugClass hint'><b>Line " . __LINE__ .  "</b>: Aufruf " . __METHOD__ . "()  (<i>" . basename(__FILE__) . "</i>)</h3>\n";						

						// Setter nur aufrufen, wenn der jeweilige Parameter über einen Wert verfügt
						if( $usr_id !== NULL AND $usr_id !== '' ) $this->setUsr_id($usr_id);
						if( $usr_firstName !== NULL AND $usr_firstName !== '' ) $this->setUsr_firstName($usr_firstName);
						if( $usr_lastName !== NULL AND $usr_lastName !== '' ) $this->setUsr_lastName($usr_lastName);
						if( $usr_email !== NULL AND $usr_email !== '' ) $this->setUsr_email($usr_email);
						if( $usr_city !== NULL AND $usr_city !== '' ) $this->setUsr_city($usr_city);
						if( $usr_password !== NULL AND $usr_password !== '' ) $this->setUsr_password($usr_password);

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
	
					#********** USR_ID **********#
					public function getUsr_id() : ?string {
						return $this->usr_id;
					}
					public function setUsr_id(string $value) : void {
						$this->usr_id = cleanString($value);
					}
										
					#********** USR_FIRSTNAME **********#
					public function getUsr_firstName() : ?string {
						return $this->usr_firstName;
					}
					public function setUsr_firstName(string $value) : void {
						$this->usr_firstName = cleanString($value);
					}
										
					#********** USR_LASTNAME **********#
					public function getUsr_lastName() : ?string {
						return $this->usr_lastName;
					}
					public function setUsr_lastName(string $value) : void {
						$this->usr_lastName = cleanString($value);
					}
										
					#********** USR_EMAIL **********#
					public function getUsr_email() : ?string {
						return $this->usr_email;
					}
					public function setUsr_email(string $value) : void {
						$this->usr_email = cleanString($value);
					}
														
					#********** USR_CITY **********#
					public function getUsr_city() : ?string {
						return $this->usr_city;
					}
					public function setUsr_city(string $value) : void {
						$this->usr_city = cleanString($value);
					}

					#********** USR_PASSWORD **********#
					public function getUsr_password() : ?string {
						return $this->usr_password;
					}
					public function setUsr_password(string $value) : void {
						$this->usr_password = cleanString($value);
					}
					
					#*******************************************************************************************#

					#****************************************#
					#********** DATENBANK-METHODEN **********#
					#****************************************#

					#********** FETCHES PROFILE DATA FROM DB **********#					
					/**
					*
					*	Fetches user object's data and related object's data from DB
					*	Writes all object's data into corresponding objects
					*
					*	@param	PDO			$pdo		DB-connection object
					*
					*	@return	Boolean					true if dataset was found, else false
					*
					*/
					public function fetchFromDb(PDO $pdo) : bool{
						
if(DEBUG_C)				echo "<h3 class='debugClass hint'><b>Line " . __LINE__ .  "</b>: Aufruf " . __METHOD__ . "() (<i>" . basename(__FILE__) . "</i>)</h3>\n";						
                        
						$sql 		= 	"SELECT usr_id, usr_firstname, usr_lastname, usr_city, usr_password FROM ".TABLE_USER."
										WHERE usr_email = :ph_usr_email";
						
						$params 	= array( "ph_usr_email" => $this->usr_email );
						
						// Schritt 2 DB: SQL-Statement vorbereiten
						$statement = $pdo->prepare($sql);
						
						// Schritt 3 DB: SQL-Statement ausführen und ggf. Platzhalter füllen
						try {	
							$statement->execute($params);								
						} catch(PDOException $error) {
if(DEBUG_DB)				echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: FEHLER: " . $error->GetMessage() . "<i>(" . basename(__FILE__) . ")</i></p>\n";										
							$dbMessage = "<h3 class='error'>Fehler beim Zugriff auf die Datenbank!</h3>";
						}

						if( !$row = $statement->fetch() ) {
if(DEBUG_DB)				echo "<p class='debug err'>Line <b>" . __LINE__ . "</b>: FEHLER: Benutzername/Mailadresse nicht gefunden<i>(" . basename(__FILE__) . ")</i></p>";
							return false;
						}
						else {
if(DEBUG_DB)				echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: Benutzername/Mailadresse GEFUNDEN <i>(" . basename(__FILE__) . ")</i></p>";

							$this->setUsr_id($row['usr_id']);
							$this->setUsr_firstName($row['usr_firstname']);
							$this->setUsr_lastName($row['usr_lastname']);
							$this->setUsr_city($row['usr_city']);
							$this->setUsr_password($row['usr_password']);

							return true;
						}							
					}

					#*******************************************************************************************#

					public function saveToDb(PDO $pdo) {
if(DEBUG_C)				echo "<h3 class='debugClass hint'><b>Line " . __LINE__ .  "</b>: Aufruf " . __METHOD__ . "() (<i>" . basename(__FILE__) . "</i>)</h3>\n";
					}					
					public static function fetchAllFromDb(PDO $pdo){						
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
		
				} // Ende Klasse User
							
#*******************************************************************************************#
?>

