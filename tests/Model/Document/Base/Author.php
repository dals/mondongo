<?php

namespace Model\Document\Base;

abstract class Author extends \Mondongo\Document\Document
{

    protected $data = array (
  'fields' => 
  array (
    'name' => NULL,
  ),
);

    protected $fieldsModified = array (
);

    public function getMondongo()
    {
        return \Mondongo\Container::getForDocumentClass('Model\Document\Author');
    }

    public function getRepository()
    {
        return $this->getMondongo()->getRepository('Model\Document\Author');
    }

    public function setDocumentData($data)
    {
        $this->id = $data['_id'];

        if (isset($data['name'])) {
            $this->data['fields']['name'] = (string) $data['name'];
        }


        
    }

    public function fieldsToMongo($fields)
    {
        if (isset($fields['name'])) {
            $fields['name'] = (string) $fields['name'];
        }


        return $fields;
    }

    public function setName($value)
    {
        if (!array_key_exists('name', $this->fieldsModified)) {
            $this->fieldsModified['name'] = $this->data['fields']['name'];
        } elseif ($value === $this->fieldsModified['name']) {
            unset($this->fieldsModified['name']);
        }

        $this->data['fields']['name'] = $value;
    }

    public function getName()
    {
        return $this->data['fields']['name'];
    }
}