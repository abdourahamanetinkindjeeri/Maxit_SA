<?php

namespace App\Core\Middlewares;

class CryptPassword
{
  public function handle()
  {
    error_log("Middleware CryptPassword exécuté");
    if (isset($_POST['password']) && !empty($_POST['password'])) {
      error_log("Mot de passe original : " . $_POST['password']);
      $_POST['password'] = $this->toCryptPassword($_POST['password']);
      error_log("Mot de passe crypté : " . $_POST['password']);
    } else {
      error_log("Aucun mot de passe fourni dans \$_POST['password']");
    }
  }

  public function toCryptPassword(string $password): string
  {
    return password_hash($password, PASSWORD_DEFAULT);
  }

  public function toVerifyPassword(string $password, string $hash): bool
  {
    return password_verify($password, $hash);
  }
}
