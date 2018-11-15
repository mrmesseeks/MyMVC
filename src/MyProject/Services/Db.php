<?php

namespace MyProject\Services;

class Db
{
    private $pdo;

    private static $instance;

    private function __construct()
    {
        $dbOptions = (require __DIR__ . '/../../settings.php')['db'];

        $dns ='mysql:host='.$dbOptions['host'].'; dbname='.$dbOptions['dbname'];


          $this->pdo = new \PDO(
          $dns,
          $dbOptions['user'],
          $dbOptions['password']
        );
          $this->pdo->exec('SET NAMES UTF8');
    }

    public function query (string $sql, $params = [],$className = 'stdClass'): ?array
    {
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute($params);

        if (false === $result){
            return null;
        }
        return $sth->fetchAll(\PDO::FETCH_CLASS, $className);
    }

    public function getInstance(): self
    {
        if (self::$instance === null){
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function getLastInsertId(): int
    {
        return (int) $this->pdo->lastInsertId();
    }
}