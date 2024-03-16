<?php
#**********************************************************************#


				#******************************************#
				#********** GLOBAL CONFIGURATION **********#
				#******************************************#
				
				/*
					Konstanten werden in PHP mittels der Funktion define() oder über 
					das Schlüsselwort const (const DEBUG = true;) definiert. Seit PHP7
					ist der Unterschied zwischen den beiden Varianten, dass über 
					const definierte Konstanten nicht innerhalb von Funktionen, Schleifen, 
					if-Statements oder try/catch-Blöcken definiert werden können. Außerdem
					können mittels const definierte Konstanten keine komplexen Datentypen enthalten.
					Konstanten besitzen im Gegensatz zu Variablen kein $-Präfix
					Üblicherweise werden Konstanten komplett GROSS geschrieben.
				*/
				
				#********** DATABASE CONFIGURATION **********#
				define('DB_SYSTEM',								'mysql');
				define('DB_HOST',								'localhost');
				define('DB_NAME',								'blog_oop');
				define('DB_USER',								'root');
				define('DB_PWD',								'');

				define('TABLE_USER',							'user');
				define('TABLE_BLOG',							'blog');
				define('TABLE_CATEGORY',						'category');
				
				
				#********** FORM CONFIGURATION **********#
				define('INPUT_MIN_LENGTH',					2);
				define('INPUT_MAX_LENGTH',					256);
				
				
				#********** IMAGE UPLOAD CONFIGURATION **********#
				define('IMAGE_MAX_WIDTH',					800);
				define('IMAGE_MAX_HEIGHT',					800);
				define('IMAGE_MAX_SIZE',					128*1024);				
				define('IMAGE_ALLOWED_MIME_TYPES',		array('image/jpg', 'image/jpeg', 'image/gif', 'image/png'));
				define('IMAGE_MAX_NAME_LENGTH',			256);
				
				
				#********** STANDARD PATHS CONFIGURATION **********#
				define('IMAGE_UPLOAD_PATH',				'images/uploads/');
				define('AVATAR_DUMMY_PATH',				'images/avatar_dummy.png');
				
				
				#********** DEBUGGING **********#
				define('DEBUG', 						true);		// Debugging for main document
				define('DEBUG_F', 						true);		// Debugging for functions
				define('DEBUG_DB', 						true);		// Debugging for db functions
				define('DEBUG_C', 						true);		// Debugging for classes
				define('DEBUG_CC', 						true);		// Debugging for class constructors
				define("DEBUG_CD",						false);		// Debugging for class deconstructors


#**********************************************************************#