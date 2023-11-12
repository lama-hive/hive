<?php

declare(strict_types=1);

namespace Lamahive\Hive\Framework\Db;

use Exception;
use PDO;
use PDOException;
use PDOStatement;
use function implode;
use function sprintf;

class Db
{
    protected PDO $pdo;

    /**
     * @throws Exception
     */
    public function __construct(
        protected readonly string $host,
        protected readonly int $port,
        protected readonly string $name,
        protected readonly string $username,
        protected readonly string $password,
        protected readonly string $charset
    )
    {
        $this->connect();
    }

    /**
     * @throws Exception
     */
    public function getConnection(): PDO
    {
        try {
            $statement = $this->pdo->prepare('SELECT DATETIME()');
            $statement->execute();
        } catch (PDOException $e) {
            $this->connect();
        }

        return $this->pdo;
    }

    public function tableExists(string $name): bool
    {
        $sql = sprintf('SELECT COUNT(*) FROM information_schema.tables  WHERE table_schema = DATABASE() AND table_name = "%s"', $name);

        return ((int) $this->queryValue($sql)) === 1;
    }

    /**
     * @throws Exception
     */
    public function createTable(string $name, array $columns): bool
    {
        $sql = sprintf(
            'CREATE TABLE `%s` (%s)',
            implode(',', $columns),
            $name
        );

        $this->queryValueThrow($sql);
    }

    public function query($sql, ...$params): bool
    {
        $result = true;

        try {
            $this->querySql($sql, $params);
        } catch (Exception $e) {
            $result = false;
        }

        return $result;
    }

    /**
     * @throws Exception
     */
    public function queryThrow($sql, ...$params): void
    {
        $this->querySql($sql, $params);
    }

    public function queryValue($sql, ...$params): string
    {
        $result = '';

        try {
            $result = $this->queryValueThrow($sql, ...$params);
        } catch (Exception $e) {}

        return $result;
    }

    /**
     * @throws Exception
     */
    public function queryValueThrow($sql, ...$params): string
    {
        $statement = $this->querySql($sql, $params);

        return (string) $statement->fetchColumn();
    }

    /**
     * @throws Exception
     */
    public function queryRow($sql, ...$params): array
    {
        $result = [];

        try {
            $statement = $this->querySql($sql, $params);

            $result = $statement->fetch();
        } catch (Exception $e) {
            return [];
        }

        return $result;
    }

    public function queryColumn($sql, ...$params): array
    {
        $dbAll = $this->queryAll($sql, ...$params);

        $result = [];
        foreach ($dbAll as $row) {
            foreach ($row as $key => $value) {
                $result[] = $value;
            }
        }

        return $result;
    }

    public function queryAll($sql, ...$params): array
    {
        try {
            $result = $this->queryAllThrow($sql, ...$params);
        } catch (Exception $e) {
            $result = [];
        }

        return $result;
    }

    /**
     * @throws Exception
     */
    public function queryAllThrow($sql, ...$params): array
    {
        $statement = $this->querySql($sql, $params);

        return $statement->fetchAll();
    }

    /**
     * @throws Exception
     */
    protected function querySql($sql, array $params): PDOStatement
    {
        $statement = $this->getConnection()->prepare($sql);
        $statement->execute($params);

        return $statement;
    }

    /**
     * @throws Exception
     */
    protected function connect(): void
    {
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        try {
            $this->pdo = new PDO($this->buildDsn(), $this->username, $this->password, $options);
        } catch (PDOException $e) {
            // @todo custom exception
            throw new Exception('Database connection failed due: ' . $e->getMessage());
        }
    }

    protected function buildDsn(): string
    {
        return sprintf('mysql:host=%s;dbname=%s;charset=%s', $this->host, $this->name, $this->charset);
    }
}
