<?php
#*******************************************************************************************#


				#*************************************#
				#********** INTERFACE Category ***********#
				#*************************************#

				
#*******************************************************************************************#

				
				interface CategoryInterface {
					

					
					#***********************************************************#
					
					
					#*********************************#
					#********** KONSTRUKTOR **********#
					#*********************************#
					

					
					public function __construct( $cat_name=NULL, $cat_id=NULL );
					
					
					
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
				
					#********** CAT_ID **********#
					public function getCat_id() : ?string;
					public function setCat_id(string $value) : void;
						
					#********** CAT_NAME **********#
					public function getCat_name() : ?string;
					public function setCat_name(string $value) : ?string;

					
					
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


















