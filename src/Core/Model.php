
<?php

abstract class Model
{
    public function loadData(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }

        return $this;
    }

    public function writeModel()
    {

    }

    private function validate()
    {

    }
}