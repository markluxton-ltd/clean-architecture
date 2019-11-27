<?php

use core\classes\Response;
use core\interactors\userManagement\listUsers\ListUsersResponse;
use core\interfaces\boundaries\PresenterInterface;
use implementation\factories\interactors\ListUsersFactory;

require_once('../../vendor/autoload.php');

$presenter = new class implements PresenterInterface
{
    
    /**
     * @var ListUsersResponse|null
     */
    private $response;
    
    
    public function send(Response $response = null)
    {
        $this->response = $response;
    }
    
    
    public function getUsers(): array
    {
        $users = [];
        
        foreach ($this->response->getUsers() as $user) {
            $users[] = [
              'display' => $user->getFirstName() . ' ' . $user->getLastName(),
              'email' => $user->getEmail(),
            ];
        }
        
        return $users;
    }
};

$useCase = (new ListUsersFactory())->create($presenter);

$useCase->execute();

$users = $presenter->getUsers();
?>
<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css" integrity="sha384-SI27wrMjH3ZZ89r4o+fGIJtnzkAnFs3E4qz9DIYioCQ5l9Rd/7UAa8DHcaL8jkWt" crossorigin="anonymous">

  <title>Hello, world!</title>
</head>
<body>
<div class="container">
  <div class="row">
    <div class="col">
      <h1 class="text-center">Users</h1>
    </div>
  </div>
  <br />
  <div class="row">
    <div class="col">
      <a href="./create.php" class="btn btn-primary">Create</a>
    </div>
  </div>
  <br />
  <div class="row">
    <div class="col">
      <table class="table">
        <thead>
          <tr>
            <th>Display Name</th>
            <th>Email</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach( $users as $user ): ?>
          <tr>
            <td><?= $user['display'] ?></td>
            <td><?= $user['email'] ?></td>
          </tr>
        <?php endforeach ?>
        </tbody>
        
      </table>
    </div>
  </div>
</div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/js/bootstrap.min.js" integrity="sha384-3qaqj0lc6sV/qpzrc1N5DC6i1VRn/HyX4qdPaiEFbn54VjQBEU341pvjz7Dv3n6P" crossorigin="anonymous"></script>
</body>
</html>