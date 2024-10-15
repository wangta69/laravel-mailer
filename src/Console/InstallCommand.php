<?php

namespace Pondol\Mailer\Console;

use Illuminate\Console\Command;
// use Illuminate\Filesystem\Filesystem;
// use Illuminate\Support\Str;
// use Symfony\Component\Process\PhpExecutableFinder;
// use Symfony\Component\Process\Process;

class InstallCommand extends Command
{
  // use InstallsBladeStack;

  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'pondol:install-mailer {type=full}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Install the Laravel Mailer controllers and resources';


  public function __construct()
  {
    parent::__construct();
  }

  public function handle()
  {
    $type = $this->argument('type');
    return $this->installLaravelMailer($type);
  }


  private function installLaravelMailer()
  {

    if($type === 'full') {
      // editor
      $this->call('pondol:install-editor');
    }

    $this->info("The pondol's laravel mailer installed successfully.");
  }


}
