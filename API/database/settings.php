<?php

define("DB_PREFIX","house_");
define("DB_NAME",getenv("DB_NAME"));
define("DB_USER",getenv("DB_USER"));
define("DB_PWD",fread(fopen(getenv("DB_PASSWORD_FILE"), "r"), filesize(getenv("DB_PASSWORD_FILE"))));
define("DB_PORT","3306");
define("DB_HOST","127.0.0.1");