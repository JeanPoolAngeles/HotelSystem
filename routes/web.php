<?php

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\ApisController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\CajaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CompaniaController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\DatatableController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\FormaController;
use App\Http\Controllers\GastoController;
use App\Http\Controllers\HabitacionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\MovimientoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ReservasController;
use App\Http\Controllers\VentaController;
use App\Livewire\ProductList;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Rutas públicas
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest');
Route::get('/401', fn() => view('pages.401'))->name('error.401');
Route::get('/404', fn() => view('pages.404'))->name('error.404');
Route::get('/500', fn() => view('pages.500'))->name('error.500');

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('panel');
    Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');

    Route::resource('usuarios', UsuarioController::class)->only(['index', 'edit', 'update'])->names('usuarios');
    Route::resource('roles', RoleController::class)->names('roles');
    Route::resource('profile', ProfileController::class)->only(['index', 'update']);

    Route::get('/backup', [BackupController::class, 'backup'])->name('admin.backup');
    Route::post('/backup', [BackupController::class, 'index'])->name('admin.index');
    Route::post('/restore', [BackupController::class, 'restore'])->name('admin.restore');

    Route::resource('productos', ProductoController::class)->except('show')->names('admin.productos');
    Route::resource('categorias', CategoriaController::class)->except('show')->names('admin.categorias');
    Route::resource('formas', FormaController::class)->except('show')->names('admin.formas');
    Route::resource('clientes', ClienteController::class)->except('show')->names('admin.clientes');
    Route::resource('empleados', EmpleadoController::class)->except('show')->names('admin.empleados');
    Route::resource('gastos', GastoController::class)->except('show')->names('admin.gastos');

    Route::get('/listarProductos', [DatatableController::class, 'products'])->middleware('can:admin.productos.index')->name('admin.products.list');
    Route::get('/listarClientes', [DatatableController::class, 'clients'])->middleware('can:admin.clientes.index')->name('admin.clients.list');
    Route::get('/listarEmpleados', [DatatableController::class, 'empleados'])->middleware('can:admin.empleados.index')->name('admin.empleado.list');
    Route::get('/listarProveedores', [DatatableController::class, 'proveedors'])->middleware('can:admin.proveedores.index')->name('admin.proveedors.list');
    Route::get('/listarPlatos', [DatatableController::class, 'platos'])->middleware('can:admin.platos.index')->name('admin.platos.list');
    Route::get('/listarCompras', [DatatableController::class, 'compras'])->middleware('can:admin.compra.index')->name('admin.compras.list');
    Route::get('/listarCajas', [DatatableController::class, 'cajas'])->middleware('can:admin.cajas.index')->name('admin.cajas.list');
    Route::get('/listarCategorias', [DatatableController::class, 'categories'])->middleware('can:admin.categorias.index')->name('admin.categories.list');
    Route::get('/listarGastos', [DatatableController::class, 'gastos'])->middleware('can:admin.gastos.index')->name('admin.gastos.list');
    Route::get('/listarVentas', [DatatableController::class, 'sales'])->middleware('can:admin.venta.index')->name('admin.sales.list');
    Route::get('/listarFormas', [DatatableController::class, 'formas'])->middleware('can:admin.formas-pago.index')->name('admin.formas.list');
    Route::get('/listarCreditoventas', [DatatableController::class, 'creditoventas'])->middleware('can:admin.creditoventa.index')->name('admin.creditoventas.list');
    Route::get('/listarSalas', [DatatableController::class, 'salas'])->middleware('can:admin.salas.index')->name('admin.salas.list');

    Route::get('/compania', [CompaniaController::class, 'index'])->middleware('can:admin.compania.index')->name('admin.compania.index');
    Route::put('/compania/{compania}', [CompaniaController::class, 'update'])->middleware('can:admin.compania.update')->name('admin.compania.update');

    Route::get('/venta', [VentaController::class, 'index'])->middleware('can:admin.venta.index')->name('admin.venta.index');
    Route::get('/venta/show', [VentaController::class, 'show'])->middleware('can:admin.venta.show')->name('admin.venta.show');
    Route::get('/venta/cliente', [VentaController::class, 'cliente'])->middleware('can:admin.venta.index')->name('admin.venta.cliente');
    Route::post('/venta', [VentaController::class, 'store'])->middleware('can:admin.venta.store')->name('admin.venta.store');
    Route::put('/venta/{id}/anular', [VentaController::class, 'anular'])->middleware('can:admin.venta.anular')->name('admin.venta.anular');
    Route::get('/venta/{id}/ticket', [VentaController::class, 'ticket'])->middleware('can:admin.venta.ticket')->name('admin.venta.ticket');
    Route::get('/venta/{id}/cocina', [VentaController::class, 'cocina'])->middleware('can:admin.venta.cocina')->name('admin.venta.cocina');
    Route::get('/venta-report-excel', [VentaController::class, 'generateExcelReport'])->middleware('can:admin.venta.reportes')->name('admin.venta.reportExcel');
    Route::get('/venta-report-pdf', [VentaController::class, 'generatePdfReport'])->middleware('can:admin.venta.reportes')->name('admin.venta.reportPdf');

    Route::get('/reservas', [ReservasController::class, 'index'])->middleware('can:admin.reservas.index')->name('admin.reservas.index');
    Route::get('/reservas/show', [ReservasController::class, 'show'])->middleware('can:admin.reservas.show')->name('admin.reservas.show');
    Route::get('/reservas/cliente', [ReservasController::class, 'cliente'])->middleware('can:admin.reservas.index')->name('admin.reservas.cliente');
    Route::post('/reservas', [ReservasController::class, 'store'])->middleware('can:admin.reservas.store')->name('admin.reservas.store');
    Route::put('/reservas/{id}/anular', [ReservasController::class, 'anular'])->middleware('can:admin.reservas.anular')->name('admin.reservas.anular');
    Route::get('/reservas/{id}/ticket', [ReservasController::class, 'ticket'])->middleware('can:admin.reservas.ticket')->name('admin.reservas.ticket');
    Route::get('/reservas/{id}/cocina', [ReservasController::class, 'cocina'])->middleware('can:admin.reservas.cocina')->name('admin.reservas.cocina');
    Route::get('/reservas-report-excel', [ReservasController::class, 'generateExcelReport'])->middleware('can:admin.reservas.reportes')->name('admin.reservas.reportExcel');
    Route::get('/reservas-report-pdf', [ReservasController::class, 'generatePdfReport'])->middleware('can:admin.reservas.reportes')->name('admin.reservas.reportPdf');

    Route::get('/compra', [CompraController::class, 'index'])->middleware('can:admin.compra.index')->name('admin.compra.index');
    Route::get('/compra/show', [CompraController::class, 'show'])->middleware('can:admin.compra.show')->name('admin.compra.show');
    Route::get('/compra/proveedor', [CompraController::class, 'proveedor'])->middleware('can:admin.compra.index')->name('admin.compra.proveedor');
    Route::post('/compra', [CompraController::class, 'store'])->middleware('can:admin.compra.store')->name('admin.compra.store');
    Route::put('/compra/{id}/anular', [CompraController::class, 'anular'])->middleware('can:admin.compra.anular')->name('admin.compra.anular');
    Route::get('/compra/{id}/ticket', [CompraController::class, 'ticket'])->middleware('can:admin.compra.ticket')->name('admin.compra.ticket');
    Route::get('/compra-report-excel', [CompraController::class, 'generateExcelReport'])->middleware('can:admin.compra.reportes')->name('admin.compra.reportExcel');
    Route::get('/compra-report-pdf', [CompraController::class, 'generatePdfReport'])->middleware('can:admin.compra.reportes')->name('admin.compra.reportPdf');

    Route::get('/cajas', [CajaController::class, 'index'])->middleware('can:admin.cajas.index')->name('admin.cajas.index');
    Route::get('/cajas/create', [CajaController::class, 'create'])->middleware('can:admin.cajas.create')->name('admin.cajas.create');
    Route::post('/cajas', [CajaController::class, 'store'])->middleware('can:admin.cajas.create')->name('admin.cajas.store');
    Route::put('/cajas', [CajaController::class, 'update'])->middleware('can:admin.cajas.update')->name('admin.cajas.update');

    Route::get('/movimientos', [MovimientoController::class, 'index'])->middleware('can:admin.movimientos.index')->name('admin.movimientos.index');

    Route::get('/habitacion', [HabitacionController::class, 'index'])->middleware('can:admin.reservas.habitacion')->name('admin.reservas.habitacion');

    Route::get('/pdf/productos', [ReporteController::class, 'pdfProducto'])->middleware('can:admin.productos.reportes')->name('admin.productos.pdf');
    Route::get('/excel/productos', [ReporteController::class, 'excelProducto'])->middleware('can:admin.productos.reportes')->name('admin.productos.excel');
    Route::get('/barcode/productos', [ReporteController::class, 'barcodeProducto'])->middleware('can:admin.productos.reportes')->name('admin.productos.barcode');

    Route::get('/pdf/platos', [ReporteController::class, 'pdfPlato'])->middleware('can:admin.platos.reportes')->name('admin.platos.pdf');
    Route::get('/excel/platos', [ReporteController::class, 'excelPlato'])->middleware('can:admin.platos.reportes')->name('admin.platos.excel');
    Route::get('/barcode/platos', [ReporteController::class, 'barcodePlato'])->middleware('can:admin.platos.reportes')->name('admin.platos.barcode');

    Route::get('/pdf/proveedores', [ReporteController::class, 'pdfProveedor'])->middleware('can:admin.proveedores.reportes')->name('admin.proveedores.pdf');
    Route::get('/excel/proveedores', [ReporteController::class, 'excelProveedor'])->middleware('can:admin.proveedores.reportes')->name('admin.proveedores.excel');

    Route::get('/pdf/clientes', [ReporteController::class, 'pdfCliente'])->middleware('can:admin.clientes.reportes')->name('admin.clientes.pdf');
    Route::get('/excel/clientes', [ReporteController::class, 'excelCliente'])->middleware('can:admin.clientes.reportes')->name('admin.clientes.excel');

    Route::get('/pdf/empleados', [ReporteController::class, 'pdfEmpleado'])->middleware('can:admin.empleados.reportes')->name('admin.empleados.pdf');
    Route::get('/excel/empleados', [ReporteController::class, 'excelEmpleado'])->middleware('can:admin.empleados.reportes')->name('admin.empleados.excel');

    Route::get('/pdf/cajas', [ReporteController::class, 'pdfCaja'])->middleware('can:admin.cajas.reportes')->name('admin.cajas.pdf');
    Route::get('/excel/cajas', [ReporteController::class, 'excelCaja'])->middleware('can:admin.cajas.reportes')->name('admin.cajas.excel');

    Route::get('/pdf/gastos', [ReporteController::class, 'pdfGasto'])->middleware('can:admin.gastos.reportes')->name('admin.gastos.pdf');
    Route::get('/excel/gastos', [ReporteController::class, 'excelGasto'])->middleware('can:admin.gastos.reportes')->name('admin.gastos.excel');


    Route::post('/consulta-dni', [ApisController::class, 'consultaDni'])->name('consulta.dni');
    Route::post('/consulta-ruc', [ApisController::class, 'consultaRuc'])->name('consulta.ruc');
});

// Redirigir rutas no autenticadas
Route::fallback(function () {
    return redirect()->route('login');
});