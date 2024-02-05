## Get Started

This guide will walk you through the steps needed to get this project up and running on your local machine.

### Prerequisites

Before you begin, ensure you have the following installed:

- Docker
- Docker Compose

### Building the Docker Environment

Build and start the containers:

```
docker-compose up -d --build
```

### Installing Dependencies

```
docker-compose exec app sh
composer install
```

### Database Setup

Set up the database:

```
bin/cake migrations migrate
```

### Accessing the Application

The application should now be accessible at http://localhost:34251

## How to check

### Authentication

TODO:
- I use cakephp/authentication plugin to implement authentication behavior
- AuthenticationMiddleware will call a hook method on the application when it starts handling the request.
- Authentication Component is combined with User Model to authenticate user.
### Article Management

TODO: I made some article feature like below:
- Every logged in User can get all articles
- Only people creating article can edit their articles

### Like Feature

TODO:
- Every logged in User can like article
- People can not unlike article
- I create an table called article_likes to store like actions of User, 1 Article can have many Likes.
  I count article like number base on this table
