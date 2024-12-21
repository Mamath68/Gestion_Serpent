<?php

namespace App\Config;

/**
 * Interface ControllerInterface
 *
 * Décrit le contrat de base pour tous les contrôleurs de l’application.
 */
interface ControllerInterface
{
    /**
     * Méthode par défaut pour afficher une liste ou un accueil.
     *
     * @return mixed
     */
    public function index(): mixed;
}
