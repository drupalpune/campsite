<?php

// Override default database with dcp23 database settings.
if (file_exists('/var/www/site-php')) {
  require '/var/www/site-php/drupalcamppune/dcp23-settings.inc';
}

// Override default config directory to be ../config.
$blt_override_config_directories = FALSE;
$settings['config_sync_directory'] = '../config';