<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class ImportEmployeeController extends Controller
{
    public function import(Request $request)
    {
        // バリデーション（CSVファイルのみ受け付け）
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();

        // CSVを開いて読み込み
        if (($handle = fopen($path, 'r')) !== false) {
            // ヘッダー行を読み飛ばす（例: name,position）
            $header = fgetcsv($handle);

            while (($data = fgetcsv($handle)) !== false) {
                // カラム順に合わせて登録
                Employee::create([
                    'name'     => $data[0] ?? '',
                    'position' => $data[1] ?? '',
                ]);
            }

            fclose($handle);
        }

        return response()->json(['message' => 'CSV imported successfully']);
    }
}
