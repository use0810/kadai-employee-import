<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Log;

use App\Imports\EmployeesImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportEmployeeController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xlsx',
        ], [
            'file.required' => 'ファイルを選択してください。',
            'file.file' => 'アップロードされたデータが正しいファイルではありません。',
            'file.mimes' => 'CSV、TXT、またはExcelファイル（.xlsx）をアップロードしてください。',
        ]);

        try {
            Log::info('アップロードされたファイル名: ' . $request->file('file')->getClientOriginalName());
            Excel::import(new EmployeesImport, $request->file('file'));

            return response()->json(['message' => 'CSVのインポートが完了しました。']);
        } catch (\Throwable $e) {
            Log::error('CSVインポート中にエラー:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json(['error' => 'サーバー内部でエラーが発生しました。'], 500);
        }
    }
}
