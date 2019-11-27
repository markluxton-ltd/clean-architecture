<?php
/**
 * This is the interactor for the Create user feature.
 *
 * @see core\classes\Presenter.php for more information
 * @see core\interfaces\boundaries\InteractorInterface.php for more information
 */

namespace core\interactors\userManagement\listUsers;

use core\entities\UserEntity;
use core\interactors\Interactor;
use core\interfaces\repositories\UserRepositoryInterface;

/**
 * @property ListUsersResponse $response
 */
class ListUsers extends Interactor
{
    
    /**
     * @var UserRepositoryInterface|null
     */
    private $userRepository;
    
    /**
     * @var UserEntity[]|null
     */
    private $users;
    
    /*
     * @see core\interfaces\boundaries\InteractorInterface.php::execute() for more information
     */
    public function execute(): void
    {
        $this->fetchUsers();
        
        $this->createResponse();
        $this->sendResponse();
    }
    
    
    private function fetchUsers(): void
    {
        $this->users = $this->userRepository->listUsers();
    }
    
    private function createResponse(): void
    {
        $this->response = new ListUsersResponse();
        $this->response->setUsers($this->users);
    }
    
    
    public function setUserRepository(UserRepositoryInterface $userRepository): void
    {
        $this->userRepository = $userRepository;
    }
}