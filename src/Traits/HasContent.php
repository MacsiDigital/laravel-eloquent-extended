<?php

namespace Extended\Traits;

use Illuminate\Support\Str;

trait HasContent
{
    public function isContentAttribute($key)
    {
        return in_array($key, $this->getContentAttributes());
    }

    public function getContentAttributes()
    {
        return is_array($this->contentAttributes) ? $this->contentAttributes : [];
    }

    public function setContentTranslation($key, $language, $value)
    {
        if ($this->isContentAttribute($key)) {
            if ($this->hasSetMutator($key)) {
                $method = 'set'.Str::studly($key).'Attribute';
                $this->{$method}($value);
                $value = $this->attributes[$key];
                unset($this->attributes[$key]);
            }
            if (! isset($this->attributes['extended'])) {
                $this->extended = [];
            }
            $this->updateContentTranslation($key, $language, $value);
        }

        return $this;
    }

    public function updateContentTranslation($key, $language, $value)
    {
        $extended = $this->extended;
        if (! isset($extended[$key])) {
            $extended[$key] = [];
        }
        $extended[$key][$language] = $value;
        $this->extended = $extended;
    }

    public function hasContent($key, $language = "")
    {
        if ($language == '') {
            $language = $this->getContentLanguage();
        }
        $extended = $this->extended;
        if (isset($extended[$key]) && is_array($extended[$key]) && array_key_exists($language, $extended[$key])) {
            return true;
        }

        return false;
    }

    public function getContent($key, $language = "")
    {
        if ($language == '') {
            $language = $this->getContentLanguage();
        }
        if ($this->isContentAttribute($key) && $this->hasContent($key, $language)) {
            if (isset($this->extended[$key])) {
                $extended = $this->extended[$key][$language];
                if ($this->hasGetMutator($key)) {
                    return $this->mutateAttribute($key, $extended);
                }

                return $extended;
            }
        }

        return;
    }

    public function setContent($key, $value, $language = "")
    {
        if ($language == '') {
            $language = $this->getContentLanguage();
        }

        return $this->setContentTranslation($key, $language, $value);
    }

    public function getContents()
    {
        return $this->extended;
    }

    public function getContentTranslations($key)
    {
        return $this->isContentAttribute($key) ? $this->extended[$key] : [] ;
    }

    public function forgetContentTranslation($key, $language)
    {
        if ($this->isContentAttribute($key) && $this->hasContent($key, $language)) {
            $extended = $this->extended;
            unset($extended[$key][$language]);
            $this->extended = $extended;
        }

        return $this;
    }

    public function forgetContentTranslations($language)
    {
        foreach ($this->getContentAttributes() as $key) {
            $this->forgetContentTranslation($key, $language);
        }

        return $this;
    }

    public function setContentTranslations($key, array $values)
    {
        if ($this->isContentAttribute($key)) {
            foreach ($values as $language => $value) {
                $this->setContent($key, $language, $value);
            }
        }

        return $this;
    }

    public function getContentLanguage()
    {
        return \App::getLocale();
    }

    public function setContentLanguage($language)
    {
        \App::setLocale($language);
    }

    public function resetContentLanguage($language)
    {
        \App::setLocale(config('app.locale', config('app.fallback_locale')));
    }
}
