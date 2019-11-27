<?php

namespace core\exceptions\repositories;


/**
 * A generic repository exception. It should not indicate the underlying storage
 * used (no Sql for example). In other word, (as a developer) by looking at the
 * exception below, I should not know that the application is using a database
 */
class RepositoryNotAccessible extends \Exception
{
    protected $code = 100; // Use generic codes - **NO** reference to HTTP codes here.
}