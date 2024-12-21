<?php

namespace App\Controller;

use App\Config\AbstractController;
use App\Config\ControllerInterface;

class HomeController extends AbstractController implements ControllerInterface
{

    /**
     * @return array
     */
    public function index(): array
    {
        return $this->render("home", [
            "meta_description" => "Page d'accueil du framework",
            "title" => "Accueil",
        ]);
    }
}
