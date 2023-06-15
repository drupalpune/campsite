<?php

/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see https://robo.li/
 */

use Robo\ResultData;
use Robo\Tasks;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Robo commands.
 */
class RoboFile extends Tasks {
  /**
   * The Symfony filesystem service.
   *
   * @var \Symfony\Component\Filesystem\Filesystem
   */
  protected $fs;

  /**
   * {@inheritdoc}
   */
  public function __construct() {
    $this->fs = new Filesystem();
  }

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

  /**
   * Build css assets in themes.
   */
  public function themeWatch() {
    $this->say("\e[1;34m==================\e[0m");
    $this->say("\e[1;34mBuilding theme\e[0m");
    $this->say("\e[1;34m==================\e[0m");
    $this->taskGulpRun('watch')->dir('web/themes/custom/camp')->run()->stopOnFail();
  }

  /**
   * Create local settings github actions.
   */
  public function actionsSetup() {
    // Adding config to settings.php.
    $this->say("\e[;32mAdding config to settings.php\e[0m");
    $appendContent = file_get_contents('ci-scripts/settings-additions.txt');
    $this->fs->appendToFile('web/sites/default/settings.php', $appendContent);
  }

}
