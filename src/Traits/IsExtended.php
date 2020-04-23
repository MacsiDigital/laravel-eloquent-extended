<?php

namespace Extended\Traits;

use Illuminate\Support\Str;

trait IsExtended
{

    public function getAttribute($key)
    {
        if(method_exists($this, 'isContentAttribute') && $this->isContentAttribute($key)){
            return $this->getContent($key);
        } else if ($this->isExtendedAttribute($key)) {
            return $this->getExtended($key);    
        }
        return parent::getAttribute($key);
        
    }

    public function setAttribute($key, $value)
    {
        if(method_exists($this, 'isContentAttribute') && $this->isContentAttribute($key) && !is_array($value)){
            return $this->setContent($key, $value);
        } else if ($this->isExtendedAttribute($key) && !is_array($value)) {
            return $this->setExtended($key, $value);
        }
        return parent::setAttribute($key, $value);
    }

    public function isExtendedAttribute($key) 
    {
    	return in_array($key, $this->getExtendedAttributes());
    }

    public function getExtendedAttributes()
    {
    	return isset($this->extendedAttributes) && is_array($this->extendedAttributes) ? $this->extendedAttributes : [];
    }

    public function setExtended($key, $value)
    {
        if($this->isExtendedAttribute($key)){
            if ($this->hasSetMutator($key)) {
	            $method = 'set'.Str::studly($key).'Attribute';
	            $this->{$method}($value);
	            $value = $this->attributes[$key];
	            unset($this->attributes[$key]);
	        }
            if(!isset($this->attributes['extended'])){
                $this->extended = [];
            }
	        $extended = $this->extended;
            $extended[$key] = $value;
            $this->extended = $extended;
        }
        return $this;
    }

    public function getExtended($key) 
    {
        if($this->isExtendedAttribute($key)){
            if(isset($this->extended[$key])){
            	$extended = $this->extended[$key];
            	if ($this->hasGetMutator($key)) {
		            return $this->mutateAttribute($key, $extended);
		        }
                return $extended;
            }
        }
        return;
    }

    public function hasExtended($key)
    {
        return isset($this->extended[$key]) ? true : false ;
    }

    public function getExtendeds() 
    {
        return $this->extended;
    }

    public function getCasts() : array
    {
        return array_merge(
            parent::getCasts(),
            ['extended' => 'array']
        );
    }

}