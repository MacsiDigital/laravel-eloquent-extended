<?php

namespace EloquentPlus\Traits;

use Illuminate\Support\Str;

trait HasMeta
{
    protected $language;

    public function isMetaAttribute($key) 
    {
        return in_array($key, $this->getMetaAttributes());
    }

    public function getMetaAttributes()
    {
        return is_array($this->metaAttributes) ? $this->metaAttributes : [];
    }

    public function setMetaTranslation($key, $language, $value)
    {
        if($this->isMetaAttribute($key)){
            if ($this->hasSetMutator($key)) {
                $method = 'set'.Str::studly($key).'Attribute';
                $this->{$method}($value);
                $value = $this->attributes[$key];
                unset($this->attributes[$key]);
            }
            if(!isset($this->attributes['extended'])){
                $this->extended = [];
            }
            $this->updateMetaTranslation($key, $language, $value);
        }
        return $this;
    }

    public function updateMetaTranslation($key, $language, $value) 
    {
        $extended = $this->extended;
        if(!isset($extended[$key])){
            $extended[$key] = [];
        }
        $extended[$key][$language] = $value;
        $this->extended = $extended;
    }

    public function hasMeta($key, $language="") 
    {
        if($language == ''){
            $language = $this->getMetaLanguage();
        }
        $extended = $this->extended;
        if(isset($extended[$key]) && is_array($extended[$key]) && array_key_exists($language, $extended[$key])){
            return true;
        }
        return false;
    }

    public function setMeta($key, $value, $language="")
    {
         if($language == ''){
            $language = $this->getMetaLanguage();
        }
        return $this->setMetaTranslation($key, $language, $value);  
    }

    public function getMeta($key, $language="") 
    {
        if($language == ''){
            $language = $this->getMetaLanguage();
        }
        if($this->isMetaAttribute($key) && $this->hasMeta($key, $language)){
            if(isset($this->extended[$key])){
                $extended = $this->extended[$key][$language];
                if ($this->hasGetMutator($key)) {
                    return $this->mutateAttribute($key, $extended);
                }
                return $extended;
            }
        }
        return;
    }

    public function getMetas() 
    {
        return $this->extended;
    }

    public function getMetaTranslations($key) 
    {
        return $this->isMetaAttribute($key) ? $this->extended['$key'] : [] ;
    }

    public function forgetMetaTranslation($key, $language) 
    {
        if($this->isMetaAttribute($key) && $this->hasMeta($key, $language)){
            $extended = $this->extended;
            unset($extended[$key][$language]);
            $this->extended = $extended;
        }
        return $this;
    }

    public function forgetMetaTranslations($language) 
    {
        foreach($this->getMetaAttributes() as $key){
            $this->forgetMetaTranslation($key, $language);
        }
        return $this;
    }

    public function setMetaTranslations($key, array $values) 
    {
        if($this->isMetaAttribute($key)){
            foreach($values as $language => $value){
                $this->setMeta($key, $language, $value);
            }     
        }
        return $this;
    }

    public function getMetaLanguage(){
        return $this->language != '' ? $this->language : \App::getLocale();
    }

    public function setMetaLanguage($language)
    {
        $this->language = $language;
    }

    public function resetMetaLanguage($language)
    {
        $this->language = '';
    }

}