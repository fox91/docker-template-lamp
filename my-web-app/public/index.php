<?php
declare(strict_types=1);

require_once __DIR__.'/../vendor/autoload.php';

function getMovies(
  PDO $dbh
) {
  $movies = null;

  try {
    $sth = $dbh->prepare("SELECT `id`, `title` FROM `movies`");
    $sth->execute();
    foreach ($sth->fetchAll(PDO::FETCH_ASSOC) as $row) {
      $movies[] = $row;
    }
  } catch(PDOException $e) {
    echo $e->getMessage().PHP_EOL;
  }

  return $movies;
}

$dbh = new PDO(
  'mysql:dbname='.getenv('MYSQL_ENV_MYSQL_DATABASE').';host='.getenv('MYSQL_PORT_3306_TCP_ADDR').';port='.getenv('MYSQL_PORT_3306_TCP_PORT'),
  getenv('MYSQL_ENV_MYSQL_USER'),
  getenv('MYSQL_ENV_MYSQL_PASSWORD')
);

$movies = getMovies($dbh);

$dbh = null;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 101 Template</title>

    <link href="/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <h1>Hello, world!</h1>

    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Title</th>
        </tr>
      </thead>
      <tbody>
<?php
foreach ($movies as $movie) {
?>
        <tr>
          <td><?php echo $movie['id']; ?></td>
          <td><?php echo $movie['title']; ?></td>
        </tr>
<?php
}
?>
      </tbody>
    </table>

    <script src="/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  </body>
</html>
