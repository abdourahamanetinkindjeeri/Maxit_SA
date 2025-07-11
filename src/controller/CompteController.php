<?php

namespace App\Controller;

use App\Config\Abstract\AbstractController;

class CompteController extends AbstractController
{

    public function index(): void
    {
        // TODO: Implement index() method.
    }

    public function create(): void
    {
        // TODO: Implement create() method.
    }

    public function show(): void
    {
        parent::renderHTML('compte/list_compte.html.php');
    }

    public function edit(): void
    {
        // TODO: Implement edit() method.
    }

    public function destroy(): void
    {
        // TODO: Implement destroy() method.
    }

    public function store(): void
    {
        // TODO: Implement store() method.
    }
}