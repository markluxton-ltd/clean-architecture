<?php

namespace implementation\factories\interactors;


use core\classes\Request;
use core\interactors\userManagement\createUser\CreateUser;
use core\interactors\userManagement\createUser\ListUsers;
use core\interfaces\boundaries\InteractorInterface;
use core\interfaces\boundaries\PresenterInterface;
use core\interfaces\factories\interactors\InteractorFactoryInterface;
use implementation\factories\repositories\UserRepositoryFactory;

class CreateUserFactory implements InteractorFactoryInterface
{
    
    public function create(PresenterInterface $presenter, Request $request = null): InteractorInterface
    {
        $interactor = new CreateUser();
        $interactor->setRequest($request);
        $interactor->setPresenter($presenter);
        $interactor->setUserRepository((new UserRepositoryFactory())->create());
        
        return $interactor;
    }
}