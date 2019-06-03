<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Adteam\Core\Motivale\DoctrineExtensions;

/**
 * Description of TablePrefix
 *
 * @author dev
 */
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Mapping\ClassMetadataInfo;

class TablePrefix {
    protected $prefix = '';

    public function __construct($prefix)
    {
        $this->prefix = (string) $prefix;
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        $classMetadata = $eventArgs->getClassMetadata();
        $classMetadata->setTableName(
                $this->prefix . $classMetadata->getTableName());
        foreach (
          $classMetadata->getAssociationMappings() as $fieldName => $mapping) {
            if ($mapping['type'] == ClassMetadataInfo::MANY_TO_MANY) {
                $mappedTableName = $classMetadata
                        ->associationMappings[$fieldName]['joinTable']['name'];
                $classMetadata
                        ->associationMappings[$fieldName]['joinTable']['name'] 
                        = $this->prefix . $mappedTableName;
            }
        }
    }
}
