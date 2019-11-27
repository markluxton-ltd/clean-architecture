<?php
/**
 * This is the interactor for the Create user feature.
 *
 * @see core\classes\Presenter.php for more information
 * @see core\interfaces\boundaries\InteractorInterface.php for more information
 */

namespace core\interactors\userManagement\createUser;

use core\entities\UserEntity;
use core\interactors\Interactor;
use core\interfaces\repositories\UserRepositoryInterface;

/**
 * @property CreateUserRequest $request
 * @property CreateUserResponse $response
 */
class CreateUser extends Interactor
{
    /**
     * @var UserEntity|null
     */
    private $user;
    
    /**
     * @var UserRepositoryInterface|null
     */
    private $userRepository;
    
    
    /*
     * @see core\interfaces\boundaries\InteractorInterface.php::execute() for more information
     */
    public function execute(): void
    {
        $this->createResponse();
        $this->checkUserDoesNotExist();
        $this->createUserEntity();
        $this->createUser();
        
        $this->sendResponse();
    }
    
    
    private function createResponse(): void
    {
        $this->response = new CreateUserResponse();
    }
    
    
    private function checkUserDoesNotExist(): void
    {
        $this->userRepository->doesUserExist($this->request->getEmail());
    }
    
    
    private function createUserEntity(): void
    {
        $this->user = new UserEntity();
        $this->user->setFirstName($this->request->getFirstName());
        $this->user->setLastName($this->request->getLastName());
        $this->user->setEmail($this->request->getEmail());
    }
    
    
    private function createUser(): void
    {
        $this->userRepository->createUser($this->user);
        $this->response->setMessage('User Created');
    }
    
    
    public function setUserRepository(UserRepositoryInterface $userRepository): void
    {
        $this->userRepository = $userRepository;
    }
}