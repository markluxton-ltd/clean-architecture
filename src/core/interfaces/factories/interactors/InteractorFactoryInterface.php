<?php
/**
 * This is implemented by all factories that create an Interactor.  It is used to allow
 * the delivery layer to create the Interactor object without having to deal with having
 * to add the required repositories.
 *
 * There should be one factory for each Interactor.
 */

namespace core\interfaces\factories\interactors;


use core\classes\Request;
use core\interfaces\boundaries\InteractorInterface;
use core\interfaces\boundaries\PresenterInterface;

interface InteractorFactoryInterface
{
    public function create(PresenterInterface $presenter, Request $request = null): InteractorInterface;
}