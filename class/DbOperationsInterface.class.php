<?php
#*******************************************************************************************#


				#**********************************************#
				#********** INTERFACE DB OPERATIONS ***********#
				#**********************************************#

				/*
					So wie eine Klasse quasi eine Blaupause für alle später aus ihr zu erstellenden Objekte/Instanzen
					darstellt, kann man ein Interface quasi als eine Blaupause für eine später zu erstellende Klasse
					ansehen.	Hierzu wird ein Interface definiert, das später in die entsprechende Klasse implementiert 
					wird. Der Sinn des Interfaces besteht darin, dass innerhalb des Interfaces sämtliche später 
					innerhalb der Klasse zu erstellende Methoden bereits vordeklariert werden.
					Die Klasse muss dann zwingend sämtliche im Interface deklarierten Methoden enthalten.
					
					Ein Interface darf keinerlei Attribute beinhalten.
					Die im Interface definierten Methoden müssen public sein und dürfen über keinen 
					Methodenrumpf {...} verfügen.
					An die Methode zu übergebende Parameter müssen im Interface vordefiniert sein ($value).
				*/

				
#*******************************************************************************************#


				interface DbOperationsInterface {
					
					/*
						Ein Interface darf keinerlei Attribute beinhalten.
					*/

					
					#***********************************************************#
					
					
					#*********************************#
					#********** KONSTRUKTOR **********#
					#*********************************#
					
					/*
						Der Konstruktor ist eine magische Methode und wird automatisch aufgerufen,
						sobald mittels des new-Befehls ein neues Objekt erstellt wird.
						Der Konstruktor erstellt eine neue Klasseninstanz/Objekt.
						Soll ein Objekt beim Erstellen bereits mit Attributwerten versehen werden,
						muss ein eigener Konstruktor geschrieben werden. Dieser nimmt die Werte in 
						Form von Parametern (genau wie bei Funktionen) entgegen und ruft seinerseits 
						die entsprechenden Setter auf, um die Werte zuzuweisen.					
					*/
					
					
					
					
					
					#********** DESTRUCTOR **********#
					/*
						Der Destruktor ist eine magische Methode und wird automatisch aufgerufen,
						sobald ein Objekt mittels unset() gelöscht wird, oder sobald das Skript beendet ist.
						Der Destructor gibt den vom gelöschten Objekt belegten Speicherplatz wieder frei.
					*/
					
					
					
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
				
					#********** ATTRIBUTSNAME **********#
					
					
					
					
					
					#***********************************************************#
					

					#******************************#
					#********** METHODEN **********#
					#******************************#

					public function saveToDb(PDO $pdo);
					
					public function fetchFromDb(PDO $pdo);
					
					public static function fetchAllFromDb(PDO $pdo);
					
					public function updateToDb(PDO $pdo);
					
					public function deleteFromDb(PDO $pdo);
					
					public function checkIfExists(PDO $pdo);
					
					public function fetchNumberOfEntries(PDO $pdo);

					
					#***********************************************************#
					
				}
				
				
#*******************************************************************************************#
?>


















