<?php

/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see https://robo.li/
 */

use Robo\ResultData;
use Robo\Tasks;

/**
 * Robo commands.
 */
class RoboFile extends Tasks {

  /**
   * Perform a Code sniffer test, and fix when applicable.
   *
   * @return \Robo\ResultData|null
   *   If there was an error a result data object is returned. Or null if
   *   successful.
   */
  public function phpcs(): ?ResultData {
    $standards = [
      'Drupal',
      'DrupalPractice',
    ];

    $commands = [
      'phpcbf',
      'phpcs',
    ];

    $directories = [
      'modules/custom',
      'themes/custom',
      '../RoboFile.php',
    ];

    $error_code = NULL;

    foreach ($directories as $directory) {
      if (!file_exists('web/' . $directory)) {
        continue;
      }
      foreach ($standards as $standard) {
        $arguments = "--parallel=8 --standard=$standard -p --ignore=server_theme/dist,node_modules,.parcel-cache --colors --extensions=php,module,inc,install,test,profile,theme,yaml,txt,md";

        foreach ($commands as $command) {
          $result = $this->_exec("cd web && ../vendor/bin/$command $directory $arguments");
          if (empty($error_code) && !$result->wasSuccessful()) {
            $error_code = $result->getExitCode();
          }
        }
      }
    }

    if (!empty($error_code)) {
      return new ResultData($error_code, 'PHPCS found some issues');
    }
    return NULL;
  }

  /**
   * Install npm packages in themes.
   */
  public function themeInstall() {
    $this->say("\e[1;34m=========================\e[0m");
    $this->say("\e[1;34mInstalling theme packages\e[0m");
    $this->say("\e[1;34m=========================\e[0m");
    $this->taskNpmInstall()->dir('web/themes/custom/camp')->run()->stopOnFail();
  }

  /**
   * Build css assets in themes.
   */
  public function themeBuild() {
    $this->say("\e[1;34m==================\e[0m");
    $this->say("\e[1;34mBuilding theme\e[0m");
    $this->say("\e[1;34m==================\e[0m");
    $this->taskGulpRun('sass')->dir('web/themes/custom/camp')->run()->stopOnFail();
  }

}
