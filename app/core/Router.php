<?php


namespace App\Core;

class Router
{
  static public function getURI(): ?string
  {
    $uri = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
    return $uri ?: null;
  }

  static public function findURIToArray(array $routes): bool|array
  {
    $uri = static::getURI();
    return array_key_exists($uri, $routes) ? $routes[$uri] : false;
  }

  public static function resolve(array $routes): void
  {
    $route = static::findURIToArray($routes);
    if ($route) {
      error_log("Route trouvée : " . print_r($route, true));

      if (!empty($route['middleware'])) {
        foreach ($route['middleware'] as $middlewareClass) {

          $middleware = new $middlewareClass();
          if (method_exists($middleware, 'handle')) {
            $middleware->handle();
          } else {
            throw new \Exception("Le middleware $middlewareClass doit implémenter la méthode handle.");
          }
        }
      }

      $class = $route['controller'] ?? null;
      $action = $route['method'] ?? null;


      $controller = new $class();
      if (!method_exists($controller, $action)) {
        throw new \Exception("La méthode $action n'existe pas dans le contrôleur $class.");
      }

      $controller->$action();
    } else {
      error_log("Route non trouvée pour : " . static::getURI());
      die('Route non trouvée');
    }
  }
}


// namespace App\Core;

// class Router
// {
//     public function __construct()
//     {
//         echo "Router instancié avec succès!<br>";
//     }

//     public function route()
//     {
//         return "Routing...";
//     }
// }