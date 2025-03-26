<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DatasetController extends Controller

{
    public function showCsvData()
    {
        $file = storage_path('app/Datasets/elections_dataset.csv');
        
        if (!file_exists($file)) {
            return redirect()->back()->with('error', 'CSV file not found');
        }
        
        $csvData = [];
        
        if (($handle = fopen($file, "r")) !== FALSE) {
            $headers = fgetcsv($handle, 1000, ",");
            
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $row = array_combine($headers, $data);
                
                // Parse any JSON columns (assuming a column named 'dictionary_data')
                if (isset($row['2023'])) {
                    $row['2023'] = json_decode($row['2023'], true);
                }
                
                $csvData[] = $row;
            }
            
            fclose($handle);
        }
        
        return view('resultados', ['csvData' => $csvData]);
    }
}