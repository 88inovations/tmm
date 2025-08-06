<?php

namespace App\Http\Controllers;

use App\Models\SysCustomForm;
use App\Models\SysCustomFormField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class CustomFormController extends Controller
{
    public function createForm()
    {
        $page_name  = __('customform');
        return view('customform.create',compact('page_name'));
    }

    public function storeForm(Request $request)
{
    $request->validate([
        'table_name' => 'required|string',
        'fields.*.name' => 'required|string',
        'fields.*.type' => 'required|string',
    ]);

    // Convert to lowercase and replace spaces
    $tableName = strtolower(str_replace(' ', '_', $request->table_name));

    // Save the form metadata
    $form = SysCustomForm::create([
        '_table' => $tableName,
        '_name' => $tableName,
    ]);

    // Save each field
    foreach ($request->fields as $field) {
        SysCustomFormField::create([
                '_tableid' => $form->_id,
                '_field' => strtolower(str_replace(' ', '_', $field['name'])),
                '_name' => $field['name'],
                '_datatype' => $field['type'],
                '_size' => isset($field['size']) && is_numeric($field['size']) ? $field['size'] : null,
            ]);
    }

    // Create the dynamic table
    Schema::create($tableName, function (Blueprint $table) use ($request) {
        $table->bigIncrements('id'); // Add a primary key

        foreach ($request->fields as $field) {
            $fieldName = strtolower(str_replace(' ', '_', $field['name']));
            $fieldType = $field['type'];
            $size = $field['size'] ?? null;

            // Handle type and size
            switch ($fieldType) {
                case 'string':
                    $table->string($fieldName, $size ?? 255)->nullable();
                    break;
                case 'integer':
                    $table->integer($fieldName)->nullable();
                    break;
                case 'text':
                    $table->text($fieldName)->nullable();
                    break;
                case 'boolean':
                    $table->boolean($fieldName)->nullable();
                    break;
                case 'date':
                    $table->date($fieldName)->nullable();
                    break;
                case 'datetime':
                    $table->dateTime($fieldName)->nullable();
                    break;
                // Add more types as needed
                default:
                    $table->string($fieldName)->nullable();
                    break;
            }
        }

        // Add timestamps (important for Eloquent)
        $table->timestamps();
    });

    return redirect()->back()->with('success', 'Form and table created successfully!');
}


}