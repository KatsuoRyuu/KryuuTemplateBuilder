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
use KryuuTemplateBuilder\Entity\Template\GroupInterface;
use KryuuTemplateBuilder\Entity\Template\FileInterface;
use KryuuTemplateBuilder\Entity\Template\VariableInterface;
use KryuuTemplateBuilder\Entity\Template\QuestionInterface;
use KryuuTemplateBuilder\Entity\Template\ShellInterface;

/**
 * @project Ryuu-ZF2
 * @authors spawn
 * @encoding UTF-8
 * @date Apr 29, 2016 - 2:55:11 AM
 * @package *
 * @todo *
 * @depends *
 * @note *
 */

class Template Implements TemplateInterface
{
    private $id;
    private $name;
    private $files;
    private $variables;
    private $groups;
    private $questions;
    private $shellCommands;
    
    public function __construct($name = null, $contents = null)
    {
        $this->variables = new Collection();
        $this->files = new Collection();
        $this->groups = new Collection();
        $this->questions = new Collection();
        $this->shellCommands = new Collection();
        if ($name != null) {
            $this->setName($name);
        }
        if (!is_array($contents)) {
            throw new \Exception();
        }
        if (!is_array($contents)) {
            $contents = func_get_args();
        }
        foreach ($contents as $content) {
            if ($content instanceof GroupInterface) {
                $this->addGroup($content);
            } elseif ($content instanceof FileInterface) {
                $this->addFile($content);
            } elseif ($content instanceof VariableInterface) {
                $this->addVariable($content);
            } elseif ($content instanceof QuestionInterface) {
                $this->addQuestion($content);
            } elseif ($content instanceof ShellInterface) {
                $this->addShellCommand($content);
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

    public function getFiles()
    {
        return $this->files;
    }
    
    public function getVariables()
    {
        return $this->variables;
    }
    
    public function getGroups()
    {
        return $this->groups;
    }
    
    public function getQuestions()
    {
        return $this->questions;
    }
    
    public function getShellCommands()
    {
        return $this->shellCommands;
    }
    
    public function getAll()
    {
        $groups   = $this->getGroups()->toArray();
        $question = $this->getQuestions()->toArray();
        $vars     = $this->getVariables()->toArray();
        $files    = $this->getFiles()->toArray();
        $shell    = $this->getShellCommands()->toArray();
        
        $combined = array_merge($groups, array_merge($question, 
                array_merge($vars, array_merge($files, $shell))));
        
        return $combined;
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

    public function setFiles($files)
    {
        $this->files = $files;
        return $this;
    }
    
    public function addFile($file)
    {
        foreach (func_get_args() as $file) {
            $this->files->add($file);
        }
        return $this;
    }

    public function setVariables($variables)
    {
        $this->variables = $variables;
        return $this;
    }
    
    public function addVariable($variables = null, $key = null)
    {
        if (is_array($variables)) {
            foreach ($variables as $v) {
                if ($key != null) {
                    if ($this->variables->containsKey($key) && $delimiter != '\R') {
                        $this->variables->set($key, $this->variables->get($key)
                                . $this->variables->get($key)->getDelimiter() . $v);
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
                            . $this->variables->get($key)->getDelimiter() . $v);
                } else {
                    $this->variables->set($key, $variables);
                }
            } else {
                $this->variables->add($variables);
            }
        }
    }

    public function setGroups($groups)
    {
        $this->groups = $groups;
        return $this;
    }
    
    public function addGroup($group = null)
    {
        foreach (func_get_args() as $group) {
            $this->groups->add($group);
        }
        return $this;
    }

    public function setQuestions($questions)
    {
        $this->questions = $questions;
        return $this;
    }
    
    public function addQuestion($questions = null)
    {
        if (!is_array($questions)) {
            $questions = func_get_args();
        }
        foreach ($questions as $question) {
            $this->questions->add($question);
        }
        return $this;
    }

    public function setShellCommands($commands)
    {
        $this->shellCommands = $commands;
        return $this;
    }
    
    public function addShellCommand($commands = null)
    {
        if (!is_array($commands)) {
            $commands = func_get_args();
        }
        foreach ($commands as $command) {
            $this->shellCommands->add($command);
        }
        return $this;
    }

}
