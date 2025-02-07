<?php

namespace Isync\Demo;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Isync\Demo\ControllerGenerator;

class Demo
{
    // Define a property to hold the database name
    protected $databaseName;
    protected $request;
    // Constructor to initialize the database name
    public function __construct(Request $request)
    {
        $this->request = $request;
        // Retrieve the database name from the .env file
        $this->databaseName = config('database.connections.mysql.database'); // Fallback to 'default_database_name' if not set
    }

   

    public function index()
    {
        // Using Laravel's Eloquent to get the table names
        $tables = DB::select('SHOW TABLES');
        
        // Directly passing the table names to the view
        $data = [
            'data' => array_map(fn ($table) => array_values((array) $table)[0], $tables),
        ];

        return view('demo::table')->with($data);
    }

    public function table_fields(Request $request)
    {
        // Using the class property to reference the database name
        $columns = DB::table('INFORMATION_SCHEMA.COLUMNS')
            ->select('COLUMN_NAME')
            ->where('TABLE_SCHEMA', $this->databaseName) // Use $this->databaseName here
            ->where('TABLE_NAME', $request->table)
            ->orderBy('ORDINAL_POSITION')
            ->get();

        // Return response as JSON
        return response()->json($columns);
    }

    public function create(Request $request)
    {
        // Ensure the ControllerGenerator is being used correctly
        $path = new ControllerGenerator($request);
        $path->create($request); // Process request through the controller generator
    }
}
