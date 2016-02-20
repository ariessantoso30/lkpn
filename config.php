<?php
/**
* CONSTANT VAR - define lokasi direktori
* @author Rachmat Maulana 
*/
define('LIBS_DIR', '../etc/libs/');//MODULS APPS DIR
define('MODUL_DIR', '../etc/modul/');//MODULS APPS DIR
define('BASE_DIR', '../etc/modul/default/');//BASE APPS DIR
define('MODELS_DIR', '../etc/modul/default/models/');//MODELS DIR 
define('CONTROLLERS_DIR', '../etc/modul/default/controllers/');//CONTROLLERS DIR
define('VIEWS_DIR', '../etc/modul/default/views/');//VIEWS DIR
define('CAS_ENABLE', false);
define('CAS_LOGIN', 'https://aplikasi.bumn.go.id/cas/login');
define('CAS_AUTH', 'http://fisbaru.local/auth.php');
define('CAS_VALIDATE', 'https://aplikasi.bumn.go.id/cas/validate');
define('CAS_LOGOUT', 'https://aplikasi.bumn.go.id/cas/logout?url=https://aplikasi.bumn.go.id/cas/login?service=http://fisbaru.local/auth.php');
//define('CAS_START', 'http://eis.bumn.go.id/index.php');
define('SSO_PID', 'eis');
define('SSO_PPWD', '639ad44b57ae969480a1a57fd42689da');
define('SSO_SERVICEFILE', 'http://ldap.bumn.go.id/services.php');
define('SERVICES_PKBL',"http://pkbl.bumn.go.id/services/index/keuangan/tahun/");