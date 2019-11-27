<?php

namespace core\interfaces\factories\repositories;


/**
 * When using other classes, there should be **no** classes outside core.
 */
use core\interfaces\repositories\UserRepositoryInterface;

interface UserRepositoryFactoryInterface
{
    public function create(): UserRepositoryInterface;
}