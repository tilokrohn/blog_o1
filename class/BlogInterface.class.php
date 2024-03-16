<?php
#*******************************************************************************************#


				#*************************************#
				#********** INTERFACE BLOG ***********#
				#*************************************#

				
#*******************************************************************************************#

				
				interface BlogInterface {
					

					
					#***********************************************************#
					
					
					#*********************************#
					#********** KONSTRUKTOR **********#
					#*********************************#
					
					public function __construct ( $category=NULL, $user=NULL, $blog_headline=NULL, $blog_image=NULL, $blog_imageAlignment=NULL, $blog_content=NULL, $blog_date=NULL, $blog_id=NULL);
									
					
					
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
				
					#********** BLOG_ID **********#
					public function getBlog_id() : ?string;
					public function setBlog_id(string $value) : void;
						
					#********** BLOG_HEADLINE **********#
					public function getBlog_headline() : ?string;
					public function setBlog_headline(string $value) : void;
						
					#********** BLOG_IMAGE **********#
					public function getBlog_image() : ?string;
					public function setBlog_image(string $value) : void;
					
					#********** BLOG_IMAGEALIGNMENT **********#
					public function getBlog_imageAlignment() : ?string;
					public function setBlog_imageAlignment(string $value) : void;
					
					#********** BLOG_CONTENT **********#
					public function getBlog_content () : ?string;
					public function setBlog_content(string $value) : void;
					
					#********** BLOG_DATE **********#
					public function getBlog_date() : ?string;
					public function setBlog_date(string $value) : void;

					#********** CATEGORY **********#
					public function getCategory() : ?Category;
					public function setCategory( Category $value ) : void;
					
					#********** USER **********#
					public function getUser() : ?User;
					public function setUser( User $value ) : void;
					
					
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


















