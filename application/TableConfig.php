<?php

namespace application;

class TableConfig
{
    private $config = [];

    public const KEY_HEADER = 'header';
    public const KEY_SORT = 'sortable';
    public const KEY_SEARCH = 'search';
    public const KEY_TABLE_MENU = 'tableMenu';
    public const KEY_MENU = 'menu';

    /**
     * @param array $tableHeader
     * @return void
     */
    public function setHeader(array $tableHeader): void {
        $this->config[self::KEY_HEADER] = $tableHeader;
    }

    /**
     * @param array $menu
     * @return void
     */
    public function setMenu(array $menu): void {
        $this->config[self::KEY_MENU] = $menu;
    }

    /**
     * @param array $sortable
     * @return void
     */
    public function setSortable(array $sortable): void {
        $this->config[self::KEY_SORT] = $sortable;
    }

    /**
     * @param array $searchable
     * @return void
     */
    public function setSearchable(array $searchable): void {
        $this->config[self::KEY_SEARCH] = $searchable;
    }

    /**
     * @param array $tableMenu
     * @return void
     */
    public function setTableMenu(array $tableMenu): void {
        $this->config[self::KEY_TABLE_MENU] = $tableMenu;
    }

    /**
     * @param string $key
     * @return array
     */
    public function __get(string $key): array {
        return $this->config[$key] ?? [];
    }
}
