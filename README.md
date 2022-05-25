# VCodeFullStack
Full Stack Laravel Vue JS For Pet Store

## Run Laravel Backend Project

Clone the project

```bash
  git clone https://github.com/jhoncolocolo/VCodeFullStack.git
```

Go to the project directory

```bash
  cd VCPetsBackend
```

Install dependencies

```bash
  composer install
```

## Environment Variables
For this example, the database name is: pet_vinixcode but if you want to change the name, put the name of your preference in the correct parameter of the .(env) file

In the environment (.env) file, update these variables, remember you need to rename the file in the root folder .env.example to .env



`DB_CONNECT=mysql`

`DB_HOST=127.0.0.1`

`DB_PORT=3306`

`DB_DATABASE=pet_vinixcode`

`DB_USERNAME=YOUR_USER`


After running these migrations:

```bash
php artisan migrate:refresh --seed
```

Start the server

```bash
  php artisan serve
```

Execution Of Testings

```bash
php artisan test
```

With this command we are execute 25 Test

  PASS  Tests\Feature\PetVinixcode\CategoryTest CRUD 5 Test
  
  ✓ categories

   PASS  Tests\Feature\PetVinixcode\PetTest
  ✓ pets get all
  
  ✓ pets get by id with nonexistent model //Test Validator
  
  ✓ pets get by id with invalid parameter //Test Validator
  
  ✓ pets get by id
  
  ✓ pets get by status with invalid status //Test Validator
  
  ✓ pets get by status
  
  ✓ pets create with validation exception //Test Validator
  
  ✓ pets create
  
  ✓ pets udpate with nonexistent model //Test Validator
  
  ✓ pets update with invalid parameter //Test Validator
  
  ✓ pets update with validation exception //Test Validator
  
  ✓ pets update
  
  ✓ pets delete with nonexistent model //Test Validator
  
  ✓ pets delete with invalid parameter //Test Validator
  
  ✓ pets delete
  

   PASS  Tests\Feature\PetVinixcode\TagTest CRUD 5 Test
  ✓ tags
  
  
  ## Explanation Backend Code

[Basic explanation of Backend Code](https://1drv.ms/v/s!Al167hgOrzsSglzeuv4h6-eUrwcU?e=hTAqng)

  

/***********************************************************************************/


## Run Vue Frontend Project

In the same folder that we already downloaded called VCodeFullStack, we will now navigate to the subfolder called VCPetsFrontend

```bash
  cd VCPetsFrontend
```

Install dependencies

```bash
  npm install
```

Start the server

```bash
  npm run serve
```

## Explanation Frontend Code

[Basic explanation of Frontend Code](https://1drv.ms/v/s!Al167hgOrzsSglt2mD_nVD8KEQ01?e=oaVGg1)


## Tech Stack

**Client:** Vue 3, Boostrap 5

**Server:** PHP (LARAVEL)


## Authors

- [@jhoncolocolo](https://github.com/jhoncolocolo)

## Acknowledgements
- [@vinixcode](https://github.com/vinixcode)
- For challenging me to grow as a developer 