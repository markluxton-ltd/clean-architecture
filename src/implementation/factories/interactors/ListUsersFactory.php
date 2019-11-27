<?php

namespace implementation\factories\interactors;


use core\classes\Request;
use core\interactors\userManagement\listUsers\ListUsers;
use core\interfaces\boundaries\InteractorInterface;
use core\interfaces\boundaries\PresenterInterface;
use core\interfaces\factories\interactors\InteractorFactoryInterface;
use implementation\factories\repositories\UserRepositoryFactory;

class ListUsersFactory implements InteractorFactoryInterface
{
    
    public function create(PresenterInterface $presenter, Request $request = null): InteractorInterface
    {
        $interactor = new ListUsers();
        $interactor->setPresenter($presenter);
        $interactor->setUserRepository((new UserRepositoryFactory())->create());
        
        return $interactor;
    }
}