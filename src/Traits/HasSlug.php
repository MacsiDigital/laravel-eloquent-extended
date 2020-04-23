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

    public function createSlug($toSlug) 
    {
    	$field = $this->slugField;
    	$this->$field = $this->generateSlug($toSlug);
        return $this;
    }

    public function scopeWithSlug($query, $slug, $language="")
    {
    	if($this->utilisesContentInterface()){
    		if($language == ''){
	            $language = $this->getContentLanguage();
	        }
	        $field = $this->findSlugField.'->'.$language;
	        return $query->where($field, $slug);
    	} else {
        	return $query->where($this->findSlugField, $slug);
    	}
    }

    public function scopeWithoutSlug($query, $slug, $language="")
    {
        if($this->utilisesContentInterface()){
    		if($language == ''){
	            $language = $this->getContentLanguage();
	        }
	        $field = $this->findSlugField.'->'.$language;
	        return $query->where($field, '!=', $slug);
    	} else {
        	return $query->where($this->findSlugField, '!=', $slug);
    	}
    }

    protected function utilisesContentInterface(){
    	if(Arr::has(class_uses($this), HasContent::class) && Str::Contains($this->findSlugField, '->')){
    		return true;
    	}
    	return false;
    }

}