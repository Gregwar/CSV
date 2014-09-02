<?php

namespace Gregwar\CSV;

/**
 * A CSV file reader
 */
class CSVFile
{
    protected $columns;
    protected $columnsFlipped;

    /**
     * Sets the column names to use
     */
    public function setColumns(array $columns)
    {
        $this->columns = $columns;
        $this->columnsFlipped = array_flip($columns);
    }
    
    protected function applyNames(array $row) {
        $data = array();

        foreach ($row as $idx => $value) {
            if (isset($this->columns[$idx])) {
                $data[$this->columns[$idx]] = $value;
            }
        }

        return $data;
    }

    protected function removeNames(array $row) {
        $data = array();

        foreach ($row as $idx => $value) {
            if (isset($this->columnsFlipped[$idx])) {
                $data[$this->columnsFlipped[$idx]] = $value;
            }
        }

        ksort($data);
        return $data;
    }

    /**
     * Loads data from a CSV file and replace indexes with names
     */
    public function load($filename)
    {
        $data = array();
        $file = @fopen($filename, 'r');

        if ($file) {
            while ($row = fgetcsv($file)) {
                $data[] = $this->applyNames($row);
            }
            fclose($file);
        }

        return $data;
    }

    /**
     * Save data to a CSV file, will replace the indexes with numbers to
     * give it to fputcsv
     */
    public function save($filename, array $data)
    {
        $file = @fopen($filename, 'w');

        if ($file) {
            foreach ($data as $row) {
                $row = $this->removeNames($row);
                fputcsv($file, $row);
            }
            fclose($file);
        }
    }
}
