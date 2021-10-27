<?php

namespace App\Custom\Tools\HtmlParser;

class Link
{

    protected $href;
    protected $title;
    protected $target;
    protected $rel;
    protected $text;
    protected $type;
    protected $count;

    public function __construct($data)
    {
        if (!empty($data)) {
            $this->hydrate($data);
        }
    }


    public function hydrate(array $data)
    {
        $this->setHref(isset($data['href']) ? $data['href'] : null);
        $this->setTitle(isset($data['title']) ? $data['title'] : null);
        $this->setTarget(isset($data['target']) ? $data['target'] : null);
        $this->setRel(isset($data['rel']) ? $data['rel'] : null);
        $this->setText(isset($data['text']) ? $data['text'] : null);
        $this->setType(isset($data['type']) ? $data['type'] : null);
        $this->setCount(isset($data['count']) ? $data['count'] : null);
//        foreach ($data as $attribut => $value) {
//            $method = 'set'.str_replace(' ', '', ucwords(str_replace('_', ' ', $attribut)));
//            if (is_callable(array($this, $method))) {
//                $this->$method($value);
//            }
//        }
    }

    public function toArray()
    {
        return [
            'href' => $this->getHref(),
            'title' => $this->getTitle(),
            'target' => $this->getTarget(),
            'rel' => $this->getRel(),
            'text' => $this->getText(),
            'type' => $this->getType(),
            'count' => $this->getCount()
        ];
    }

    /**
     * @return mixed
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * @param mixed $href
     */
    public function setHref($href): void
    {
        $this->href = $href;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @param mixed $target
     */
    public function setTarget($target): void
    {
        $this->target = $target;
    }

    /**
     * @return mixed
     */
    public function getRel()
    {
        return $this->rel;
    }

    /**
     * @param mixed $rel
     */
    public function setRel($rel): void
    {
        $this->rel = $rel;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text): void
    {
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param mixed $count
     */
    public function setCount($count): void
    {
        $this->count = $count;
    }
}
