<?php

/* 
 * @license The Ryuu Technology License
 * 
 * Copyright 2014 Ryuu Technology by
 * KatsuoRyuu <anders-github@drake-development.org>.
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * Ryuu Technology shall be visible and readable to anyone using the software
 * and shall be written in one of the following ways: 竜技術, Ryuu Technology
 * or by using the company logo.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 * 
 * 
 * @link https://github.com/KatsuoRyuu/
 */

namespace KryuuTemplateBuilder\Service;

use KryuuTemplateBuilder\Entity\Template\TemplateInterface;
use KryuuTemplateBuilder\Template\Builder;
use KryuuTemplateBuilder\Template\Installer;

/**
 * 
 */
Class TemplateService Implements TemplateServiceInterface
{
    private $templates = null;
    private $templatePaths = null;
    private $templateBuilder = null;
    private $installer = null;
    
    public function setTemplatePaths($paths)
    {
        $this->templatePaths = $paths;
        return $this;
    }
    
    public function getTemplateList()
    {
        $templatesList = [];
        foreach ($this->getTemplates() as $template) {
            $templatesList[] = $template->getName();
        }
        return $templatesList;
    }
    
    public function getTemplate($name)
    {
        foreach ($this->getTemplates() as $template) {
            if ($template->getName() == $name) {
                return $template;
            }
        }
        return false;
    }
    
    public function build(TemplateInterface $template)
    {
        $builder = $this->getTemplateBuilder();
        $package = $builder->build($template);
        return $package;
    }
    
    /**
     * This needs removal but is here for backward compatibility
     * @param TemplateInterface $template
     */
    public function buildTemplate(TemplateInterface $template)
    {
        return $this->build($template);
    }
    
    public function install($package, $path = null)
    {
        if ($package->getPath() == null) {
            $package->setPath($path);
        }
        $this->getInstaller()->install($package);
    }
    
    private function getTemplates()
    {
        if ($this->templates == null) {
            $templates = [];
            foreach ($this->getTemplatePaths() as $path) {
                $tmp = include $path;
                if (is_array($tmp)) {
                    $templates = array_merge($templates, $tmp);
                } else {
                    $templates[] = $tmp;
                }
            }
            $this->templates = $templates;
        }
        return $this->templates;
    }
    
    private function getTemplatePaths()
    {
        if ($this->templatePaths == null) {
            throw new \Exception('The paths for the templatefiles has not been set');
        }
        
        return $this->templatePaths;
    }
    
    /**
     * 
     * @return KryuuTemplateBuilder\Template\Builder
     */
    private function getTemplateBuilder()
    {
        if ($this->templateBuilder == null) {
            $this->templateBuilder = new Builder();
        }
        
        return $this->templateBuilder;
    }
    
    /**
     * 
     * @return KryuuTemplateBuilder\Template\Installer
     */
    private function getInstaller()
    {
        if ($this->installer == null) {
            $this->installer = new Installer();
        }
        
        return $this->installer;
    }
}
