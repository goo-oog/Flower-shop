<?php
declare(strict_types=1);

namespace Flowershop;

use PDO;
use PDOException;

class Warehouse6_SQL implements Warehouse
{
    /**@var Flower[] */
    private array $inventory;

    public function __construct()
    {
        $host = 'localhost';
        $db = 'flower_shop';
        $user = 'gints';
        $password = '';
        $charset = 'utf8mb4';
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
        try {
            $pdo = new PDO($dsn, $user, $password, $options);
        } catch (PDOException $exception) {
            throw new PDOException($exception->getMessage(), (int)$exception->getCode());
        }
        $this->inventory = $pdo->query('SELECT name,amount FROM warehouse6')
            ->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Flower::class, ['name', (int)'amount']);
    }

    /**@return Flower[] */
    public function inventory(): array
    {
        return $this->inventory;
    }
}