<?php

namespace modules\Stock;

use application\AbstractRepository;

class StockRepository extends AbstractRepository
{
    public function increaseEntityReservation(
        int $fkEntity,
        string $entityType
    ) {
        $sql = sprintf(
            'UPDATE %sStock SET `reserved` = `reserved` + 1 WHERE fk_%s = %d',
            $entityType,
            $entityType,
            $fkEntity
        );

        $this->getDatabase()->query($sql);

        if ($this->getDatabase()->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function decreaseEntityReservation(
        int $fkEntity,
        string $entityType
    ) {
        var_dump($entityType);
        $sql = sprintf(
            'UPDATE %sStock SET `reserved` = `reserved` - 1 WHERE fk_%s = %d',
            $entityType,
            $entityType,
            $fkEntity
        );

        $this->getDatabase()->query($sql);

        if ($this->getDatabase()->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getAttributesValues($attribute) {
        $sql = sprintf('
            SELECT id_%s, designation
            FROM %s; 
        ', $attribute, $attribute);

        $this->getDatabase()->query($sql);
        $results = $this->getDatabase()->resultSet();

        return $results;
    }

    public function getQuantity($idItem, $tableName) {
        $sql = sprintf('
            SELECT stock, reserved FROM %sStock WHERE fk_%s = :fk_item ORDER BY fk_%s ASC; 
        ', $tableName, $tableName, $tableName, $tableName);

        $this->getDatabase()->query($sql);

        $this->getDatabase()->bind(':fk_item', $idItem);

        $row = $this->getDatabase()->resultSet();

        if(empty($row)) {
            $row = null;
        }

        return $row;
    }

    public function insertStockValue($fkEntity, $stock, $tableName, $reserved = 0):bool {
        $sql = sprintf('INSERT INTO %sStock (`id_%sStock`, `fk_%s`, `stock`, `reserved`) 
            VALUES (NULL, %d, %d, %d);', $tableName, $tableName, $tableName, $fkEntity, $stock, $reserved);

        $this->getDatabase()->query($sql);

        if ($this->getDatabase()->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateStockValue($fkEntity, $stock, $tableName, $reserved): bool {
        $sql = sprintf('UPDATE %sStock SET fk_%s = %d, stock = %d, reserved = %d WHERE %sStock.fk_%s = %d',$tableName, $tableName, $fkEntity, $stock, $reserved, $tableName, $tableName, $fkEntity);

        $this->getDatabase()->query($sql);

        if ($this->getDatabase()->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
