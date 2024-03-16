<?php
#*******************************************************************************************#


				#*************************************#
				#********** INTERFACE USER ***********#
				#*************************************#

				
#*******************************************************************************************#

				
				interface UserInterface {
					

					
					#***********************************************************#
					
					
					#*********************************#
					#********** KONSTRUKTOR **********#
					#*********************************#
					
					public function __construct ($usr_firstName=NULL, $usr_lastName=NULL, $usr_email=NULL, $usr_city=NULL, $usr_password=NULL, $usr_id=NULL);

					
					
					#********** DESTRUCTOR **********#

					public function __destruct();
					
					
					#***********************************************************#
					
					/* 
						Type Hinting
						Man kann den Datentyp einer Variablen bzw. eines Rückgabewertes
						mittels Type Hinting vorbestimmen. Für eine Variable wird der 
						Datentyp DAVOR notiert (string $variable), für einen Rückgabewert
						erfolgt die Notation hinter der Funktionsdeklaration und wird mittels 
						einem : ausgewiesen (function() : string)
						Um alternativ zum vorgegebenen Datentyp auch NULL zurückgeben zu können,
						wird vor den Datentyp ein ? (nullable return type) notiert. 
						Das bedeutet: return spezifizierter Datentyp oder NULL
					*/
					
					
					#*************************************#
					#********** GETTER & SETTER **********#
					#*************************************#
				
					#********** USR_ID **********#
					public function getUsr_id() : ?string;
					public function setUsr_id(string $value) : void;
						
					#********** USR_FIRSTNAME **********#
					public function getUsr_firstName() : ?string;
					public function setUsr_firstName(string $value) : void;
						
					#********** USR_LASTNAME **********#
					public function getUsr_lastName() : ?string;
					public function setUsr_lastName(string $value) : void;
					
					#********** USR_EMAIL **********#
					public function getUsr_email() : ?string;
					public function setUsr_email(string $value) : void;
					
					#********** USR_CITY **********#
					public function getUsr_city() : ?string;
					public function setUsr_city(string $value) : void;
					
					#********** USR_PASSWORD **********#
					public function getUsr_password() : ?string;
					public function setUsr_password(string $value) : void;
					
					
					#********** VIRTUAL ATTRIBUTES **********#
					// public function getFullName() : ?string;
									
					
					#***********************************************************#
					

					#******************************#
					#********** METHODEN **********#
					#******************************#
					


					
					#***********************************************************#
					
				}
				
				
#*******************************************************************************************#
?>


















