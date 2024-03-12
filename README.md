# Meczyki Symfony - Recruitment Task

## Live Version
Check out the live version of this project on [https://meczyki.pysznykod.pl](https://meczyki.pysznykod.pl).

## API Endpoints
- **/api/top-authors** Get the top 3 authors of the week.
- **/api/author/{id}/articles** Get articles by an author.
- **/api/article/{id}** Get an article by its id.
- **/api/article/add** Add an article (POST request, with title and text values).
- **/api/article/{id}/edit** Edit an article (PATCH request, with title and text values).

## Installation
1. Clone the repository: `git clone https://github.com/danielnatuniewicz/meczyki.git`
2. Navigate to the meczyki folder: `cd meczyki`
3. Install dependencies: `composer install`
4. Generate a migration: `php bin/console make:migration`
5. Apply the migration: `php bin/console doctrine:migrations:migrate`
6. Start the Symfony server: `symfony server:start`

## Login/Registration Paths
- `/login`
- `/register`

## Adding/Editing Paths
- `/article/add`
- `/article/{id}/edit`
