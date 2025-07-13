<?php

namespace App\Config;

use App\Repository\UtilisateurRepository;
use App\Repository\CompteRepository;
use App\Service\SecurityService;
use App\Config\middlewares\CryptPassword;
use App\Config\Validator;
use App\Config\Session;
use App\Repository\TransactionRepository;
use App\Service\CompteService;
use App\Service\TransactionService;

class App
{
  private static array $dependencies = [];
  private static bool $initialized = false;

  public static function init(): void
  {
    if (self::$initialized) return;

    self::$dependencies = [
      'core' => [
        'database' => fn() => Database::getInstance()->getConnection(),
        'session' => fn() => Session::getInstance(),
        'router' => fn() => new Router(),
      ],
      'repositories' => [
        'utilisateurRepository' => fn() => UtilisateurRepository::getInstance(),
        'compteRepository' => fn() => CompteRepository::getInstance(),
        'transactionRepository' => fn() => TransactionRepository::getInstance()
      ],
      'services' => [
        'securityService' => fn() => SecurityService::getInstance(),
        'compteService' => fn() => CompteService::getInstance(),
        'transactionService' => fn() => TransactionService::getInstance()
      ],
      'middlewares' => [
        'cryptPassword' => fn() => new CryptPassword(),
      ],
      'validators' => [
        'validator' => fn() => new Validator(),
      ],
    ];

    self::$initialized = true;
  }

  public static function getDependency(string $key): mixed
  {
    self::init();

    foreach (self::$dependencies as $group) {
      if (isset($group[$key])) {
        return $group[$key]();
      }
    }

    throw new \Exception("Dependency '{$key}' not found");
  }
}

//
//
//namespace App\Config;
//
//use App\Config\Database;
//use App\Repository\UtilisateurRepository;
//
//class App
//{
//    private static array $dependencies = [];
//
//    public static function init(): void
//    {
//        if (!empty(self::$dependencies)) return;
//
//        self::$dependencies = [
//            'core' => [
//                'database' => Database::getInstance()->getConnection(),
//            ],
//            'services' => [],
//            'repositories' => [
//                'utilisateurRepository' => UtilisateurRepository::getInstance(),
//            ],
//        ];
//    }
//
//    public static function getDependency(string $key)
//    {
//        self::init();
//
//        foreach (self::$dependencies as $group) {
//            if (isset($group[$key])) {
//                return $group[$key];
//            }
//        }
//
//        throw new \Exception("Dependency '{$key}' not found");
//    }
//}

//
//namespace App\Config;
//
//use App\Config\Database;
//
//$dependencies =[
//    'core'=>[
////        'router'=> new Router(),
//        'database'=> Database::getInstance(),
//    ],
//    'services'=>[
//    ],
//    'reporitories'=>[
//    ],
//
//
//];
//class App
//{
//
//    public static function getDependency(string $key)
//    {
//        global $dependencies;
//
//        dump($dependencies);
//        foreach ($dependencies as $group) {
//            if (isset($group[$key])) {
//                return $group[$key];
//            }
//        }
//
//        throw new \Exception("Dependency '{$key}' not found");
//    }
//
//}

//
//App{
//
//    $dependencies =[
//        “core”=>[
//            “router”=> new Router(),
//            “database”=> Database::getIntance(),
//        ],
//        “services”=>[
//        ],
//        “reporitories”=>[
//        ],
//
//
//    ];
//
//    public function static getDependencie(string){
//
//    }
//
//}
//
////Récupération du Router
//App::getDependencie(“router”);
//App::getDependencie(“database”);
