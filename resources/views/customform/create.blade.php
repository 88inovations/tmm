@extends('backend.layouts.app')
@section('title',$page_name)

@section('content')
<div class="container">
    <h2>Create Custom Table</h2>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

    <form action="{{ route('customform.store') }}" method="POST">
    @csrf
    <div>
        <label>Table Name:</label>
        <input type="text" name="table_name" required>
    </div>

    <hr>
    <h4>Fields:</h4>
    <div class="table-responsive">
        <table class="table" id="fields-table">
        <thead>
            <tr>
                <th>Name</th><th>Type</th><th>Size</th><th>Child Table</th><th>Option Field</th>
                <th>Group</th><th>Default</th><th>Tabs</th><th>Serial</th>
                <th>Unique</th><th>List</th><th>Required</th><th>Readonly</th>
                <th>Ext Search</th><th>Add</th><th>Edit</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><input name="fields[0][name]" required></td>
                <td>
                    <select name="fields[0][type]" class="field-type" data-index="0">
                        <option value="string">String</option>
                        <option value="int">Number</option>
                        <option value="date">Date</option>
                        <option value="boolean">boolean</option>
                        <option value="select">Select</option>
                    </select>
                </td>
                <td><input name="fields[0][size]" value="255"></td>
                <td><input name="fields[0][childtable]" class="child-table" data-index="0"></td>
                <td><input name="fields[0][option]" class="child-option" data-index="0"></td>
                <td><input name="fields[0][group]"></td>
                <td><input name="fields[0][default]"></td>
                <td><input name="fields[0][tabs]"></td>
                <td><input name="fields[0][serial]" value="1"></td>

                <td><input type="checkbox" name="fields[0][unique]" value="1"></td>
                <td><input type="checkbox" name="fields[0][list]" value="1" checked></td>
                <td><input type="checkbox" name="fields[0][required]" value="1"></td>
                <td><input type="checkbox" name="fields[0][readonly]" value="1"></td>
                <td><input type="checkbox" name="fields[0][extsearch]" value="1"></td>
                <td><input type="checkbox" name="fields[0][add]" value="1" checked></td>
                <td><input type="checkbox" name="fields[0][edit]" value="1" checked></td>
            </tr>
        </tbody>
    </table>
    </div>
    

    <button type="button" onclick="addRow()">+ Add Field</button>
    <button type="submit">Save</button>
</form>

<script>
let rowIndex = 1;
function addRow() {
    const row = document.querySelector('#fields-table tbody tr').cloneNode(true);
    const inputs = row.querySelectorAll('input, select');

    inputs.forEach(input => {
        if (input.name) {
            input.name = input.name.replace(/\[0\]/, `[${rowIndex}]`);
        }
        if (input.type === 'checkbox') input.checked = false;
        else input.value = '';
    });

    document.querySelector('#fields-table tbody').appendChild(row);
    rowIndex++;
}
</script>
@endsection
