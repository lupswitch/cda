<?php

/*
 * The MIT License
 *
 * Copyright 2016 Julien Fastré <julien.fastre@champs-libres.coop>.
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
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace PHPHealth\CDA\Component;

use PHPHealth\CDA\DataType\TextAndMultimedia\EncapsuledData;
use PHPHealth\CDA\ClinicalDocument as CD;

/**
 * Component which contains unstructured content
 * 
 * 
 *
 * @author Julien Fastré <julien.fastre@champs-libres.coop>
 */
class NonXMLBodyComponent extends AbstractComponent
{
    /**
     *
     * @var EncapsuledData
     */
    private $content;
    
    public function getContent()
    {
        return $this->content;
    }

    public function setContent(EncapsuledData $content)
    {
        $this->content = $content;
        
        return $this;
    }

        
    public function toDOMElement(\DOMDocument $doc)
    {
        $component = $doc->createElement(CD::NS_CDA.'nonXMLBody');
        $text = $doc->createElement(CD::NS_CDA.'text');
        $text->setAttribute(CD::NS_CDA.'mediaType', $this->content->getMediaType());
        
        if ($this->content->getMediaType() == 'text/plain') {
            $content = new \DOMCdataSection($this->content->getContent());
        } else {
            $content = new \DOMText($this->content->getContent());
        }

        $text->appendChild($content);
        $component->appendChild($text);
        
        return $component;
    }

}
