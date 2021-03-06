# Content decryptor microservice
This microservice decrypts provided content after authentication by access token.

## Why?

In a serverless architecture there's no server to password protect content.  
Using this microservice you can add the encrypted content to the HTML output without anyone being able to read it.  
A small Javascript-enhanced form allows you to accept the password from a user, and use this microservice to decrypt it.

----------------------------------

## Context and flow
The service can be used in an architecture as described below.

### Site generator
This process uses the following data:
- The unencrypted content
- The `password` that should grant access to the content
- A secret `salt`, only known by the site generator and the decryptor

It then generates the page frontend, containing:
- The encrypted content
- The `hashed password`: the `password` hashed with the secret `salt`

### Client (html + js)
- Has the encrypted content in the source
- Has the `hashed password`

It enables a user to fill in their `password`, which should grant access to the encrypted content. After user input, it sends to the decryptor:
- The encrypted content
- The `hashed password` (using a salt kept secret from the user)
- The unencrypted `password` from the user

### Decryptor microservice
The decryptor doesn't know anything about the content, except for how to decrypt it. After authentication, the decrypted content is returned to the client.
The decryptor knows the secret `salt`, but not the correct password.

Authentication happens if the user-sent `hashed password` matches `hash (` user-sent `password + salt )`

__________________________________

## Installation

Install dependencies:

```bash
$ composer install
$ yarn install
```

Create a `.env` file, based on `.env.example`.

__________________________________

## Usage

### Decryption
Decryption will take place when this input is provided:

- `password` (Provided by the user)
- `password_hashed` (Predetermined and salted)
- `content` (The encrypted content)


### Encrypting your content

Use the [Defuse](https://github.com/defuse/php-encryption) library to encrypt content:

```php
$key = Key::createNewRandomKey();
$encrypted = Crypto::encrypt($content, $key);
```

Save the key and share with this microservice:

```php
$key->saveToAsciiSafeString(); // <-- save this output in your .env 
```

If the ascii key is added to the `.env` file of this microservice, it will be able to decrypt the content.

### Creating the hashed password

Create a hashed password using `password_hash`, and make sure to include the salt:

```php
$salt = 'salty_dog';
$passwordPlain = 'bunnywabbit';
$passwordHashed = password_hash($passwordPlain . $salt, PASSWORD_BCRYPT);
```

If the salt is added to the `.env` file of this microservice, it will be able to verify the user-provided password.

__________________________________

## API

Run a local server using

```bash
$ php -S localhost:8000 -t public
```
__________________________________

## Deploy

You can use stages to deploy to `development`, `staging` and `production` (default: `development`).

### Prerequisites

1. You have the AWS cli tool installed.
2. You have configured a profile for this service.
3. You have created `.env.staging` and `.env.production` files, based on `.env.example`.
4. Make sure the value for `AWS_PROFILE` in the applicable `.env` file corresponds to the profile you created in step 2.

### Deploy staging

```bash
$ npx serverless deploy --stage staging --env staging 
```

### Deploy production

```bash
$ npx serverless deploy --stage production --env production 
```

Serverless will print the HTTP endpoints to the screen.


## Stack

Built on [Lumen](https://lumen.laravel.com), deployed using [Serverless framework](http://serverless.com/).


