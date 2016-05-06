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

namespace KryuuTemplateBuilder\Entity\Template;

use Doctrine\Common\Collections\ArrayCollection as Collection;
use Exception;

/**
 * @project Ryuu-ZF2
 * @authors spawn
 * @encoding UTF-8
 * @date Apr 7, 2016 - 12:23:55 AM
 * @package *
 * @todo *
 * @depends *
 * @note *
 */

class File Implements FileInterface
{
    private $id;
    private $name = null;
    private $path = null;    
    private $content = null;
    private $variables = null;
    
    public function __construct($name = null, $path = null, $content = null, $variables = null)
    {
        $this->variables = new Collection;
        $variables = isset($variables) ? func_get_args() : [];
        unset($variables[0],$variables[1],$variables[2]);
        
        $this->setName($name)
                ->setPath($path);
        if (file_exists($content)) {
            $this->setContent(file_get_contents($content));
        } else {
            $this->setContent($content);
        }
        foreach ($variables as $variable) {
            if ($variable instanceof VariableInterface || $variable instanceof QuestionInterface) {
                $this->addVariable($variable);
            } else {
                throw new Exception('You need to parse a instance of VariableInterface as variable or a Question');
            }
        }
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getName()
    {
        return $this->name;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getVariables()
    {
        return $this->variables;
    }
    
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    public function setVariables($variables)
    {
        $this->variables = $variables;
        return $this;
    }

    public function addVariable($variables = null, $key = null, $delimiter = null)
    {
        if (is_array($variables)) {
            foreach ($variables as $v) {
                if ($key != null) {
                    if ($this->variables->containsKey($key) && $delimiter != '\R') {
                        $this->variables->set($key, $this->variables->get($key)
                                . $delimiter . $v);
                    } else {
                        $this->variables->set($key, $v);
                    }
                } else {
                    $this->variables->add($v);
                }
            }
        } else {
            if ($key != null) {
                if ($this->variables->containsKey($key) && $delimiter != '\R') {
                    $this->variables->set($key, $this->variables->get($key)
                            . $delimiter . $variables);
                } else {
                    $this->variables->set($key, $variables);
                }
            } else {
                $this->variables->add($variables);
            }
        }
    }
}
