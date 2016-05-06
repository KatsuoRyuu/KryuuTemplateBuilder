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

/**
 * @project Ryuu-ZF2
 * @authors spawn
 * @encoding UTF-8
 * @date Apr 7, 2016 - 8:16:11 PM
 * @package *
 * @todo *
 * @depends *
 * @note *
 */

class Variable Implements VariableInterface
{
    private $id;
    
    private $name = null;
    
    private $content = null;
    
    private $pattern = null;
    
    private $alter = [];
    
    private $delimiter = null;
    
    public function __construct($name, $content = null, $pattern = null, $alter = null, $delimiter = null)
    {
        $this->setName($name);
        $this->setContent($content);
        $this->setPattern($pattern);
        $this->setAlter($alter);
        $this->setDelimiter($delimiter);
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getName()
    {
        return $this->name;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getPattern()
    {
        return $this->pattern;
    }

    public function getAlter()
    {
        return $this->alter;
    }

    public function getDelimiter()
    {
        return $this->delimiter;
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

    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    public function setPattern($pattern)
    {
        $this->pattern = $pattern;
        return $this;
    }

    public function setAlter($alter)
    {
        $this->alter = $alter;
        return $this;
    }

    public function setDelimiter($delimiter)
    {
        $this->delimiter = $delimiter;
        return $this;
    }
}
