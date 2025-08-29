<?php

namespace App\Service;

use App\Models\SkillCategory;

class SkillService
{
    public function getCategoriesWithSkills(): array
    {
        return $this->fetchCategoriesWithSkills();
    }

    private function fetchCategoriesWithSkills(): array
    {
        $categories = SkillCategory::all();

        return $categories->map(function (SkillCategory $category) {
            return [
                'id' => $category->getAttribute('id'),
                'name' => is_array($category->name) ?
                    $category->getTranslation('name', app()->getLocale()) :
                    $category->getAttribute('name'),
                'logo' => $category->getAttribute('logo') ? [
                    'id' => $category->getAttribute('logo')->id,
                    'filename' => $category->getAttribute('logo')->filename,
                    'url' => $category->getAttribute('logo')->getUrlAttribute(),
                    'mime_type' => $category->getAttribute('logo')->mime_type,
                ] : null,
                'skills' => $category->getSkillsName(),
            ];
        })->toArray();
    }

}
