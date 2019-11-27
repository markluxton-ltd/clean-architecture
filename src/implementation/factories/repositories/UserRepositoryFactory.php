<?php
namespace implementation\factories\repositories;


use core\interfaces\factories\repositories\UserRepositoryFactoryInterface;
use core\interfaces\repositories\UserRepositoryInterface;
use implementation\repositories\FileStore\UserFileStore;

class UserRepositoryFactory implements UserRepositoryFactoryInterface
{
    public function create(): UserRepositoryInterface
    {
        return new UserFileStore();
    }
}