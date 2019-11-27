<?php


namespace implementation\repositories\FileStore;


use core\exceptions\repositories\RepositoryNotAccessible;
use core\exceptions\repositories\RepositoryNotWritable;

class FileStore
{
    
    public function save(array $data, string $filePath ): void
    {
        if( ! is_writable($filePath) )
        {
            throw new RepositoryNotWritable('The path "' . $filePath . '" is not writeable');
        }
    
        file_put_contents($filePath, json_encode($data, JSON_THROW_ON_ERROR, 512));
    }
    
    
    public function load(string $filePath ): array
    {
        if(! file_exists($filePath) || ! is_readable($filePath))
        {
            throw new RepositoryNotAccessible('The path "' . $filePath . '" is not accessible');
        }
        
        return json_decode(file_get_contents($filePath), true, 512, JSON_THROW_ON_ERROR);
    }
}