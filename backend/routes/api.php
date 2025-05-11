use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImportEmployeeController;

Route::post('/import-employees', [ImportEmployeeController::class, 'import']);
