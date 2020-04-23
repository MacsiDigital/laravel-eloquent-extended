<?php

namespace Extended\Traits;

use Extended\Traits\HasContent;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

trait HasSlug
{

	protected function generateSlug($toSlug) 
    {
    	$slug = Str::slug($toSlug);
    	if(self::withSlug($slug)->count() > 0){
            $slug = $this->generateSlug($slug.'-'.Str::random(4));
        }
        return $slug;
    }

    public function createSlug($toSlug, $language = '') 
    {
    	$field = $this->getSlugField($language);
    	$this->$field = $this->generateSlug($toSlug);
        return $this;
    }

    public function scopeWithSlug($query, $slug, $language="")
    {
    	return $query->where($this->getFindSlugField($language), $slug);
    }

    public function scopeWithoutSlug($query, $slug, $language="")
    {
        return $query->where($this->getFindSlugField($language), '!=', $slug);
    }

    protected function utilisesContentInterface()
    {
    	if(Arr::has(class_uses($this), HasContent::class)){
    		return true;
    	}
    	return false;
    }

    protected function getFindSlugField($language="")
    {
        if($this->utilisesContentInterface()){
            if($language == ''){
                $language = $this->getContentLanguage();
            }
            if(isset($this->findSlugField) && $this->findSlugField != null && Str::contains($this->findSlugField, '->')){
                $field = $this->findSlugField.'->'.$language;
            } elseif(isset($this->findSlugField) && $this->findSlugField != null){
                $field = $this->findSlugField.'->'.$language;
            } else {
                $field = 'extended->uri->'.$language;
            }
        } else {
            if(isset($this->findSlugField) && $this->findSlugField != null){
                $field = $this->findSlugField;
            } else {
                $field = 'uri';
            }
        }
        return $field;
    }

    protected function getSlugField($language="")
    {
        if(isset($this->slugField) && $this->slugField != null){
            $field = $this->slugField;
        } else {
            $field = 'uri';
        }
        return $field;
    }

}