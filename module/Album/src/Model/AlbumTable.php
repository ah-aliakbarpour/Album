<?php

namespace Album\Model;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Query\QueryBuilder;
use RuntimeException;

class AlbumTable
{
    public const TABLE_NAME = 'album';
    protected QueryBuilder $query;

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

        $albums = [];
        foreach ($result as $data) {
            $album =new Album();
            $album->exchangeArray($data);
            $albums[] = $album;
        }

        return $albums;
    }

    public function find($id)
    {
        $id = (int) $id;

        $this->query->select('*')
            ->from(self::TABLE_NAME)
            ->where('id = :id');
        $this->query->setParameter('id', $id);
        $result = $this->query->fetchAssociative();

        if (! $result) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        $album =new Album();
        $album->exchangeArray($result);

        return $album;
    }

    public function save(Album $album)
    {
        $id = (int) $album->id;

        if ($id === 0) {
            return $this->query
                ->insert(self::TABLE_NAME)
                ->setValue('artist', ':artist')
                ->setValue('title', ':title')
                ->setParameter('artist', $album->artist)
                ->setParameter('title', $album->title)
                ->executeStatement();
        }

        try {
            $this->find($id);
        } catch (RuntimeException $e) {
            throw new RuntimeException(sprintf(
                'Cannot update album with identifier %d; does not exist',
                $id
            ));
        }

        return $this->query
            ->update(self::TABLE_NAME)
            ->set('artist', ':artist')
            ->set('title', ':title')
            ->setParameter('artist', $album->artist)
            ->setParameter('title', $album->title)
            ->where('id = '.$id)
            ->executeStatement();
    }

    public function delete($id)
    {
        return $this->query
            ->delete(self::TABLE_NAME)
            ->where('id = '.$id)
            ->executeStatement();
    }
}