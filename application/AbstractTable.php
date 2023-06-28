<?php

namespace application;

use application\Traits\URLGeneratorTrait;

abstract class AbstractTable extends AbstractView
{
    use URLGeneratorTrait;
    abstract function prepareSql();
    abstract function configure(TableConfig $tableConfig): TableConfig;
    abstract function getTableName();

    private AbstractRepository $abstractRepository;
    private AbstractController $abstractController;

    private const QUERY_PARAM_SORT_COLUMN = 'sortColumn';
    private const QUERY_PARAM_SORT_DIRECTION = 'sortDirection';
    private const QUERY_PARAM_SEARCH = 'searchKeyword';
    private const DEFAULT_SORT_DIRECTION = 'ASC';

    public function __construct(
        AbstractRepository $repository,
        AbstractController $abstractController
    ) {
        $this->abstractController = $abstractController;

        $this->abstractRepository = $repository;
        $this->init();
    }

    protected TableConfig $tableConfig;

    public function init() {
        $tableConfig = new TableConfig();
        $this->tableConfig = $this->configure($tableConfig);
    }

    public function getViewData() {
        return [
            'menu' => $this->getMenuItem(),
            'tableHead' => $this->getTableHead(),
            'tableContent' => $this->getTableContent(),
            'showSearch' => count($this->tableConfig->search) > 0,
        ];
    }

    public function getActions() {
        $controllerMethods = get_class_methods($this->abstractController);
        $actions = [];
        foreach ($controllerMethods as $action) {
            $actions[] = $action;
        }
        return $actions;
    }

    public function getTableSearchAttributes() {
        $params = $this->getAssocQueryParams();
        if (isset($params['searchKeyword'])) {
            unset($params['searchKeyword']);
        }

        $hiddenInput = '';
        foreach($params as $name => $value) {
            $name = htmlspecialchars($name);
            $value = htmlspecialchars($value);
            $hiddenInput .= '<input type="hidden" name="'. $name .'" value="'. $value .'">';
        }

        return [
            'hiddenInput' => $hiddenInput,
            'currentURL' => $this->generateURL(),
            'resetUrl' => $this->generateURL(['searchKeyword' => ''])
        ];
    }

    /**
     * @return array
     */
    public function getTableHead(): array {
        $tableHead = [];

        foreach($this->tableConfig->header as $headerKey => $headerLabel) {
            $tableHead[$headerKey] = $this->getHeaderLabel($headerKey, $headerLabel);
        }

        return $tableHead;
    }

    private function getTableContent() {
        $controllerActions = $this->getActions();
        $moduleName = $this->getModuleName();

        $sql = $this->prepareSql();

        $search = [];
        if($searchParam = $this->getAssocQueryParams()[self::QUERY_PARAM_SEARCH] ?? false) {
            foreach($this->tableConfig->search as $searchKey) {
                $search[] = sprintf("%s LIKE '%s' ", $searchKey, $searchParam);
            }
        }

        if(count($search) !== 0) {
            //var_dump($search);
            $lastFilter = end($search);
            $sql.=" WHERE ";
            foreach($search as $filter) {
                $sql.= $filter;
                if($filter !== $lastFilter) {
                    $sql.=' OR ';
                }
            }
        }

        $sql .= sprintf(' GROUP by id_%s', $this->getTableName());

        if($sortColumn = $this->getAssocQueryParams()[self::QUERY_PARAM_SORT_COLUMN] ?? false) {
            $sql .= ' ORDER BY ' . $sortColumn . ' ' .$this->getAssocQueryParams()[self::QUERY_PARAM_SORT_DIRECTION] ?? self::DEFAULT_SORT_DIRECTION;
        }


        $result = [];
        foreach($this->abstractRepository->getDatabase()->query($sql)->resultSet() as $resultSet) {
            $tableMenuItems = [];

            foreach ($this->tableConfig->tableMenu as $key => $tableMenu) {
                //var_dump($key);
                if (in_array($key, $controllerActions)) {
                    $tableMenu['menuURL'] = $this->createUrl([], $tableMenu['menuPoint'], $moduleName);
                    $tableMenuItems[] = $tableMenu;
                }

                //var_dump($tableMenu);
            }
            $result[] = (array) $resultSet + ['tableMenu' => $tableMenuItems];
        }

        return $result;
    }

    /**
     * @return array
     */
    private function getMenuItem() {
        $moduleName = $this->getModuleName();
        $menuItems = [];

        foreach ($this->tableConfig->menu as $key => $menu) {
            //var_dump($key);
            $menu['menuURL'] = $this->createUrl([], $menu['menuPoint'], $moduleName);
            $menuItems[] = $menu;

            //var_dump($tableMenu);
        }

        return $menuItems;
    }

    /**
     * @param string $headerKey
     * @param string $headerLabel
     * @return string
     */
    private function getHeaderLabel(string $headerKey, string $headerLabel): string {
        if(!in_array($headerKey, $this->tableConfig->sortable)) {
            return $headerLabel;
        }

        $sortDirection = self::DEFAULT_SORT_DIRECTION;

        if($this->getAssocQueryParams()[self::QUERY_PARAM_SORT_COLUMN] ?? '' === $headerKey) {
            $direction = $this->getAssocQueryParams()[self::QUERY_PARAM_SORT_DIRECTION];
            $sortDirection = ($direction === 'ASC') ? 'DESC' : 'ASC';
        }

        return sprintf(
            "<a href='%s'>%s</a>",
            $this->generateURL(
                [
                    self::QUERY_PARAM_SORT_COLUMN => $headerKey,
                    self::QUERY_PARAM_SORT_DIRECTION => $sortDirection
                ]),
            $headerLabel
        );

    }

}
