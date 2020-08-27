<?php

namespace Samrat131\ColumnSortable;

class SortColumn
{

    protected $sort = null;

    protected $order = null;

    protected $links = [];

    protected $request;

    protected $defaultOrder = 'desc';

	function __construct() {

        $this->request = request();

        $this->setSortOrder();
    }

    public function getLinks()
    {
        return $this->links;
    }

	protected function flipSort($order)
    {
        return ($order=='asc') ? 'desc' : 'asc';
    }

    protected function getDir($order)
    {
    	return ($order=='asc') ? 'fa fa-arrow-circle-up' : 'fa fa-arrow-circle-down';
    }

    protected function setSortOrder()
    {
        $this->sort = $this->request->has('sort') ? $this->request->sort : null;
        $this->order = $this->request->has('order') ? $this->request->order : null;
    }

    public function sortColumn(array $column=[])
    {

        foreach ($column as $key => $name) {

            if ($key == $this->sort) {
                $sortOrder = $this->flipSort($this->order);
            } else {
                $sortOrder = $this->defaultOrder;
            }

            $queryParams[$key] = [
            	'sort' => $key,
            	'order' => $sortOrder,
            ];

            $this->links[$key] = $this->generatelink($queryParams, $key, $name);
        }

        return $this->getLinks();
    }

    protected function arrowDir(array $column=[], $sort='', $order='')
    {
    	foreach ($column as $key) {
    		if ($key==$sort) {
            	$arrowDir[$key] = $this->getDir($order);
            } else {
            	$arrowDir[$key] = null;
            }
        }
        return $arrowDir;
    }

    protected function generatelink(array $params, $key, $name='')
    {
        if (empty($params) || $key=='') {
            return null;
        }

        $arrowDir = $this->getArrowDirection($key);

        $params = $this->addRouteParam($params, $key);
        // dd($this->request->route()->getUri());

        return '<a href="'.url($this->request->route()->getUri(), $params[$key]).'"> '.$name.' <i class="fa '.$arrowDir.'"></i></a>';
    }

    protected function addRouteParam(array $params, $key)
    {
        // add route params
        $routeParams = $this->request->route()->parameterNames();

        foreach ($routeParams as $value) {
            $params[$key][$value] = $this->request->route($value);
        }

        // add filter params
        $ignore = ['sort','order'];

        if (!empty($this->request->all())) {
            foreach ($this->request->except($ignore) as $key2 => $value2) {
                if ($value2) {
                    $params[$key][$key2] = $value2;
                }
            }
        }

        return $params;
    }

    protected function getArrowDirection($key)
    {
        return ($this->sort==$key) ? $this->getDir($this->order) : null;
    }
}