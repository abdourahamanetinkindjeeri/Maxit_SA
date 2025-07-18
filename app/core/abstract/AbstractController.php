<?php

namespace App\Core\Abstract;

use App\Core\App;
use App\Core\Session;

abstract class AbstractController
{
  protected Session $session;
  protected string $layout = 'base';

  public function __construct()
  {
    $this->session = App::get('App\\Core\\Session');
  }

  protected function renderHTML(string $template, array $data = []): void
  {
    extract($data);

    // Définir le contenu dans une variable pour le layout
    ob_start();
    require_once __DIR__ . "/../../../templates/{$template}";
    $content = ob_get_clean();

    // Inclure le layout approprié
    require_once __DIR__ . "/../../../templates/layout/{$this->layout}.layout.php";
  }
}
