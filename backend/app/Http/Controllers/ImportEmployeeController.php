<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Log;

class ImportEmployeeController extends Controller
{
    public function import(Request $request)
{
    try {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();

        if (($handle = fopen($path, 'r')) !== false) {
            $header = fgetcsv($handle);

            $expectedHeader = ['name', 'position'];
            if ($header !== $expectedHeader) {
                return response()->json(['error' => 'CSVヘッダーが正しくありません'], 400);
            }

            while (($data = fgetcsv($handle)) !== false) {
                Log::info('CSV行データ:', $data); 

                Employee::create([
                    'name'     => $data[0] ?? '',
                    'position' => $data[1] ?? '',
                ]);
            }

            fclose($handle);
        }

        return response()->json(['message' => 'CSV imported successfully']);
    } catch (\Throwable $e) {
        Log::error('CSVインポート中にエラー:', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);

        return response()->json(['error' => 'サーバー内部エラー'], 500);
    }
}
}
