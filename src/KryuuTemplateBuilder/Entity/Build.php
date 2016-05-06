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

namespace KryuuTemplateBuilder\Entity;

use Doctrine\Common\Collections\ArrayCollection as Collection;
use KryuuTemplateBuilder\Entity\Template\FileInterface;

/**
 * Description of Build
 *
 * @author spawn
 */
class Build
{
    private $id = null;
    private $name = null;
    private $files = null;
    private $variables = null;
    private $shellCommands = null;
    
    public function __construct($files = null, $variables = null, $shellCommands = null)
    {
        $this->files = new Collection();
        $this->variables = new Collection();
        $this->shellCommands = new Collection();
        if ($files != null) {
            foreach ($files as $file) {
                $this->addFile($file);
            }
        }
        if ($variables != null) {
            foreach ($variables as $variable) {
                $this->addVariable($variable);
            }
        }
        if ($shellCommands != null) {
            foreach ($shellCommands as $command) {
                $this->addShellCommand($command);
            }
        }
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getFiles()
    {
        return $this->files;
    }
    
    public function getVariables()
    {
        return $this->variables;
    }
    
    public function getVariable($key)
    {
        return $this->variables->get($key);
    }
    
    public function getShellCommands()
    {
        return $this->shellCommands;
    }
    
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    
    public function setFiles($files)
    {
        $this->files = $files;
        return $this;
    }
    
    public function addFile($file)
    {
        if ($file instanceof FileInterface) {
            $this->files->add($file);
        } elseif (is_array($file)) {
            foreach ($file as $f) {
                if ($f instanceof $f) {
                    $this->files->add($f);
                }
            }
        }
    }
    
    public function setVariables($files)
    {
        $this->files = $files;
        return $this;
    }
    
    public function addVariable($variables, $key=null)
    {
        if (is_array($variables)) {
            foreach ($variables as $v) {
                if ($key != null) {
                    if ($this->variables->containsKey($key)) {
                        $this->variables->set($key, $this->variables->get($key)
                                . PHP_EOL . $v);
                    } else {
                        $this->variables->set($key, $v);
                    }
                } else {
                    $this->variables->add($v);
                }
            }
        } else {
            if ($key != null) {
                $this->variables->set($key, $variables);
            } else {
                $this->variables->add($variables);
            }
        }
    }
    
    public function setShellCommands($files)
    {
        $this->files = $files;
        return $this;
    }
    
    public function addShellCommand($command, $key=null)
    {
        if (is_array($command)) {
            foreach ($command as $v) {
                if ($key != null) {
                    $this->shellCommands->set($key, $v);
                } else {
                    $this->shellCommands->add($v);
                }
            }
        } else {
            if ($key != null) {
                $this->shellCommands->set($key, $command);
            } else {
                $this->shellCommands->add($command);
            }
        }
    }
}
