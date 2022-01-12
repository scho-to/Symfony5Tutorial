<?php

namespace App\Utils;

use App\Twig\AppExtension;
use App\Utils\AbstractClasses\CategoryTreeAbstract;

class CategoryTreeFrontPage extends CategoryTreeAbstract {

    public string $html_1 = '<ul>';
    public string $html_2 = '<li>';
    public string $html_3 = '<a href="';
    public string $html_4 = '">';
    public string $html_5 = '</a>';
    public string $html_6 = '</li>';
    public string $html_7 = '</ul>';

    public function getCategoryListAndParent(int $id): string
    {
        $this->slugger = new AppExtension(); // Twig extension to slugify url's for categories
        $parentData = $this->getMainParent($id); // main parent of subcategory
        $this->mainParentName = $parentData['name']; // for accessing in view
        $this->mainParentId = $parentData['id'];
        $key = array_search($id, array_column($this->categoriesArrayFromDb, 'id'));
        $this->currentCategoryName = $this->categoriesArrayFromDb[$key]['name']; // for accessing in view

        $categories_array = $this->buildTree($parentData['id']); // builds areay for generating nested html list
        return $this->getCategoryList($categories_array);
    }

    public function getCategoryList(array $categories_array)
    {
        $this->categorielist .= $this->html_1;
        foreach($categories_array as $value)
        {
            $catName = $this->slugger->slugify($value['name']);
            $url = $this->urlgenerator->generate('video_list', ['categoryname' => $catName, 'id' => $value['id']]);
            $this->categorielist .= $this->html_2.$this->html_3.$url.$this->html_4.$catName.$this->html_5;
            if (!empty($value['children']))
            {
                $this->getCategoryList($value['children']);
            }
            $this->categorielist .= $this->html_6;
        }
        $this->categorielist .= $this->html_7;
        return $this->categorielist;
    }

    public function getMainParent(int $id): array
    {
        $key = array_search($id, array_column($this->categoriesArrayFromDb, 'id'));
        if ($this->categoriesArrayFromDb[$key]['parent_id'] != null)
        {
            return $this->getMainParent($this->categoriesArrayFromDb[$key]['parent_id']);
        }
        else {
            return [
                'id' => $this->categoriesArrayFromDb[$key]['id'],
                'name' => $this->categoriesArrayFromDb[$key]['name']
            ];
        }
    }
}