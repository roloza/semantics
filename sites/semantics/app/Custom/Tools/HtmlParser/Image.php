<?php

namespace App\Custom\Tools\HtmlParser;

class Image
{

    protected $src;
    protected $name;
    protected $count;

    public function __construct($data)
    {
        if (!empty($data)) {
            $this->hydrate($data);
        }
    }


    public function hydrate(array $data)
    {
        $this->setSrc(isset($data['src']) ? $data['src'] : null);
        $this->setName(isset($data['name']) ? $data['name'] : null);
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
            'src' => $this->getSrc(),
            'name' => $this->getName(),

            'count' => $this->getCount()
        ];
    }

    /**
     * @return mixed
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * @param mixed $src
     */
    public function setSrc($src): void
    {
        $this->src = $src;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
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
