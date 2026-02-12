<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BackupController extends Controller
{
    public function index()
    {
        return view('admin.backup.backup');
    }

    public function backup(Request $request)
    {
        try {
            $tables = DB::select('SHOW TABLES');
            $backupSql = '';

            foreach ($tables as $table) {
                foreach ($table as $tableName) {
                    $backupSql .= "DROP TABLE IF EXISTS $tableName;";
                    $createTable = DB::selectOne("SHOW CREATE TABLE $tableName");
                    $backupSql .= "\n\n" . $createTable->{'Create Table'} . ";\n\n";
                    $rows = DB::table($tableName)->get();
                    foreach ($rows as $row) {
                        $row = (array) $row;
                        $row = array_map('addslashes', $row);
                        $row = array_map('htmlspecialchars', $row);
                        $backupSql .= "INSERT INTO $tableName VALUES ('" . implode("', '", $row) . "');\n";
                    }
                    $backupSql .= "\n\n\n";
                }
            }

            // Guardar el archivo de copia de seguridad en storage/app/backup
            $fileName = 'NovoBD_BackUp_' . date('Ymd_His') . '.sql';
            Storage::disk('backup')->put($fileName, $backupSql);


            // Mensaje de éxito
            return view('admin.backup.backup')->with('success', '');
        } catch (\Exception $e) {
            // Mensaje de error
            return view('admin.backup.backup')->with('error', 'Error al realizar la copia de seguridad: ' . $e->getMessage());
        }
    }

    public function restore(Request $request)
    {

        // Validar que se haya enviado un archivo y que cumpla con los requisitos
        $validator = Validator::make($request->all(), [
            'sqlFile' => 'required|mimes:sql|max:2048', // máximo 2MB
        ]);

        // Comprobar si la validación falla
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            // Obtener el archivo .sql
            $sqlFile = $request->file('sqlFile');

            // Leer el contenido del archivo .sql
            $sqlContent = file_get_contents($sqlFile->getPathname());

            // Ejecutar el contenido del archivo .sql en la base de datos
            DB::unprepared($sqlContent);

            // Redireccionar con un mensaje de éxito
            return view('admin.backup.backup')->with('success', '');
        } catch (\Exception $e) {
            // Mensaje de error
            return view('admin.backup.backup')->with('error', 'Error al realizar la copia de seguridad: ' . $e->getMessage());
        }
    }
}
