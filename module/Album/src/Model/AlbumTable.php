<?php

namespace Album\Model;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\FetchMode;
use RuntimeException;

class AlbumTable
{
    public const TABLE_NAME = 'album';
    protected \Doctrine\DBAL\Query\QueryBuilder $query;

    public function __construct()
    {
        $connectionParams = (require 'config/autoload/global.php')['db_doctrine'];

        $conn = DriverManager::getConnection($connectionParams);
        $this->query = $conn->createQueryBuilder();
    }

    public function getAll()
    {
        $this->query->select('*')
            ->from(self::TABLE_NAME);

        $result = $this->query->fetchAllAssociative();

        var_dump($result);
        return $result;
    }

    public function find($id)
    {
        $id = (int) $id;

        $this->query->select('*')
            ->from(self::TABLE_NAME)
            ->where('id = :id');

        $this->query->setParameter('id', $id);

        $result = $this->query->fetchAssociative();
        var_dump($result);

        if (! $result) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        $resultObj = new \stdClass();
        foreach ($result as $key => $value)
            $resultObj->$key = $value;

        return $resultObj;
    }

    public function save(Album $album)
    {
        $data = [
            'artist' => $album->artist,
            'title'  => $album->title,
        ];

        $id = (int) $album->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        try {
            $this->find($id);
        } catch (RuntimeException $e) {
            throw new RuntimeException(sprintf(
                'Cannot update album with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function delete($id)
    {
        //$this->tableGateway->delete(['id' => (int) $id]);
    }
}