<?php

class Database
{
    public function __construct()
    {
        $this->basePath = "database/";
    }

    public function modelExists($model): bool
    {
        $modelName = get_class($model);
        $modelFilename = $this->getModelFilename($model);

        $xml = simplexml_load_file($this->basePath . $modelFilename);
        
        foreach ($xml->{$modelName} as $modelXml) {
            if ($modelXml->id == $model->getId()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get all key-value pair matches 
     * 
     * @param Object $model
     * @param string $key
     * @param string $value
     */
    public function findBy($modelObject, $key, $value): array
    {
        $models = [];
        $modelName = get_class($modelObject);
        $modelFilename = $this->getModelFilename($modelObject);

        $xml = simplexml_load_file($this->basePath . $modelFilename);

        foreach ($xml->{$modelName} as $xmlModel) {
            if ($xmlModel->{$key} == $value) {
                $models[] = $xmlModel;
            }
        }

        if (empty($models)) {
            return [];
        }

        foreach ($models as $key => $model) {
            $newModel = (clone $modelObject);
            
            foreach ($model->children() as $column) {
                if (property_exists($modelObject, $column->getName())) {
                    $newModel->{$column->getName()} = strval($column);
                }
            }

            $models[$key] = $newModel;
        }

        return $models;
    }

    /**
     * Get the first key-value pair match
     * 
     * @param Object $model
     * @param string $key
     * @param string $value
     */
    public function findOneBy($model, $key, $value)
    {
        $modelFound = null;
        $modelName = get_class($model);
        $modelFilename = $this->getModelFilename($model);

        $xml = simplexml_load_file($this->basePath . $modelFilename);

        foreach ($xml->{$modelName} as $xmlModel) {
            if ($xmlModel->{$key} == $value) {
                $modelFound = $xmlModel;
            }
        }

        if (!$modelFound) {
            return null;
        }

        foreach ($modelFound->children() as $column) {
            if (property_exists($model, $column->getName())) {
                $model->{$column->getName()} = strval($column);
            }
        }

        return $model;
    }

    public function writeModel($model) 
    {
        if (isset($model->id) == false) {
            $model->id = uniqid();

            return $this->createModel($model);
        }

        return $this->updateModel($model);
    }

    private function createModel($model)
    {
        $modelName = get_class($model);
        $modelsXml = $this->loadModelFile($model);
        if (false === $modelsXml) {
            throw new \Exception('invalid XML');
        }
        $modelXml = $modelsXml->addChild($modelName);

        foreach (get_object_vars($model) as $property => $value) {
            if (isset($value)) {
                $modelXml->addChild($property, $value);
            }
        }

        file_put_contents($this->basePath . $modelName . '.xml', $modelsXml->asXML());
    }

    private function updateModel($model)
    {
        $modelName = get_class($model);
        $modelsXml = $this->loadModelFile($model);

        foreach($modelsXml->{$modelName} as $modelXml){
            if($modelXml->id == $model->id){
                foreach (get_object_vars($model) as $property => $value) {
                    $modelXml->{$property} = $value;
                }
            }
        }

        file_put_contents($this->basePath . $modelName . '.xml', $modelsXml->asXML());
    }

    private function getModelFilename($model)
    {
        $modelName = get_class($model);

        return "$modelName.xml";
    }

    private function loadModelFile($model)
    {
        $modelFilename = $this->getModelFilename($model);

        return simplexml_load_file($this->basePath . $modelFilename);
    }
}