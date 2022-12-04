<?php

namespace Model;

use Common\CommonTrait;

class Pagination
{
    use CommonTrait;

    const TABLE = 'sensor';

    /**
     * Получаем сколько всего страниц
     * @param int $limit
     * @return int
     */
    public function getPagesCount(int $limit): int
    {
        $mysqliResult = $this->db->query(
            sprintf('SELECT COUNT(*) FROM %s', self::TABLE)
        );

        // Получаем сколько всего в таблице sensor записей
        $count = intval($mysqliResult->fetch_array()[0]);

        // Возвращаем количество на одной стр
        return intval(ceil($count / $limit));
    }

    /**
     * Получаем на n-ой стр ($pageNum) нужные данные
     * @param int $pageNum
     * @param int $limit
     * @return array
     */
    public function getPage(int $pageNum, int $limit): array
    {
        $mysqliResult = $this->db->query(
            sprintf(
                'SELECT * FROM `%s` LIMIT %d OFFSET %d;',
                self::TABLE,
                $limit,
                ($pageNum - 1) * $limit
            )
        );

        $data = [];
        while ($item = $mysqliResult->fetch_assoc()) {
            $data[] = $item;
        }

        return $data;
    }
}