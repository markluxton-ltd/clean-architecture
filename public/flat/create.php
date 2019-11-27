<?php

require_once('../../vendor/autoload.php');

use core\classes\Response;
use core\interactors\userManagement\createUser\CreateUserRequest;
use core\interactors\userManagement\createUser\ListUsersResponse;
use core\interfaces\boundaries\PresenterInterface;
use implementation\factories\interactors\CreateUserFactory;

$message = null;

if (!empty($_POST)) {
    $request = new CreateUserRequest();
    $request->setEmail($_POST[ 'email' ]);
    $request->setFirstName($_POST[ 'firstName' ]);
    $request->setLastName($_POST[ 'lastName' ]);
    
    $presenter = new class implements PresenterInterface
    {
        
        /**
         * @var ListUsersResponse|null
         */
        private $response;
        
        
        public function send(Response $response = null): void
        {
            $this->response = $response;
        }
    
    
        public function getMessage(): string
        {
            return $this->response->getMessage();
        }
    };
    
    $useCase = (new CreateUserFactory())->create($presenter, $request);
    
    try
    {
        $useCase->execute();
        $message = $presenter->getMessage();
    } catch( Exception $e ) {
      
        $message = $e->getMessage();
    }
    
}
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
      <h1 class="text-center">Create User</h1>
    </div>
  </div>
  <?php if($message !== null ): ?>
    <div class="alert alert-primary" role="alert">
      <?= $message; ?>
    </div>
  <?php endif ?>
  <div class="row">
    <div class="col">
      <form action="" method="post">
        <div class="form-group">
          <label for="firstName">First Name</label>
          <input type="text" name="firstName" class="form-control" id="firstName" aria-describedby="firstNameHelp">
          <small id="firstNameHelp" class="form-text text-muted">Enter your first name</small>
        </div>
        <div class="form-group">
          <label for="lastName">Last Name</label>
          <input type="text" name="lastName" class="form-control" id="lastName" aria-describedby="lastNameHelp">
          <small id="lastNameHelp" class="form-text text-muted">Enter your last name</small>
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp">
          <small id="emailHelp" class="form-text text-muted">Enter your email</small>
        </div>
        <a href="index.php" class="btn btn-link">Cancel</a>
        <button class="btn btn-primary">Create user</button>
      </form>
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