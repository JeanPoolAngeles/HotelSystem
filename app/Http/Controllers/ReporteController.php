<?php

namespace App\Http\Controllers;

use App\Exports\CajasExport;
use App\Exports\ClientsExport;
use App\Exports\PlatosExport;
use App\Exports\GastosExport;
use App\Exports\ProductsExport;
use App\Exports\ProveedorsExport;
use App\Models\Caja;
use App\Models\Cliente;
use App\Models\Cotizacion;
use App\Models\Gasto;
use App\Models\Plato;
use App\Models\Producto;
use App\Models\Proveedor;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use Milon\Barcode\Facades\DNS1DFacade;

class ReporteController extends Controller
{
    public function barcodeProducto()
    {
        $productos = Producto::all();
        $barcodes = [];
        foreach ($productos as $product) {
            $barcode = DNS1DFacade::getBarcodeHTML($product->codigo, 'C128');
            $barcodes[] = ['codigo' => $product->codigo, 'barcode' => $barcode];
        }

        // Crear el PDF y pasar las rutas de las imágenes a la vista
        $html = View::make('admin.producto.barcode', compact('barcodes'))->render();
        $pdf = PDF::loadHTML($html)->setPaper('a4', 'portrait')->setWarnings(false);

        // Devolver el PDF al navegador
        return $pdf->stream('reporte.pdf');
    }
    public function excelProducto()
    {
        return Excel::download(new ProductsExport, 'productos.xlsx');
    }

    public function pdfProducto()
    {
        $productos = Producto::with(['categoria'])->get();
        // Generar el contenido del ticket en HTML
        $html = View::make('admin.producto.reporte', compact('productos'))->render();

        // Generar el PDF utilizando laravel-dompdf con orientación horizontal
        $pdf = Pdf::loadHTML($html)->setPaper('a4', 'landscape')->setWarnings(false);

        return $pdf->stream('reporte.pdf');
    }

    public function barcodePlato()
    {
        $platos = Plato::all();
        $barcodes = [];
        foreach ($platos as $plato) {
            $barcode = DNS1DFacade::getBarcodeHTML($plato->codigo, 'C128');
            $barcodes[] = ['codigo' => $plato->codigo, 'barcode' => $barcode];
        }

        // Crear el PDF y pasar las rutas de las imágenes a la vista
        $html = View::make('admin.plato.barcode', compact('barcodes'))->render();
        $pdf = PDF::loadHTML($html)->setPaper('a4', 'portrait')->setWarnings(false);

        // Devolver el PDF al navegador
        return $pdf->stream('reporte.pdf');
    }
    public function excelPlato()
    {
        return Excel::download(new PlatosExport, 'platos.xlsx');
    }

    public function pdfPlato()
    {
        $platos = Plato::with(['categoria'])->get();
        // Generar el contenido del ticket en HTML
        $html = View::make('admin.plato.reporte', compact('platos'))->render();

        // Generar el PDF utilizando laravel-dompdf con orientación horizontal
        $pdf = Pdf::loadHTML($html)->setPaper('a4', 'landscape')->setWarnings(false);

        return $pdf->stream('reporte.pdf');
    }

    public function excelProveedor()
    {
        return Excel::download(new ProveedorsExport, 'proveedores.xlsx');
    }

    public function pdfProveedor()
    {
        $proveedores = Proveedor::get();
        // Generar el contenido del ticket en HTML
        $html = View::make('admin.proveedor.reporte', compact('proveedores'))->render();

        // Generar el PDF utilizando laravel-dompdf con orientación horizontal
        $pdf = Pdf::loadHTML($html)->setPaper('a4', 'landscape')->setWarnings(false);

        return $pdf->stream('reporte.pdf');
    }

    public function excelCliente()
    {
        return Excel::download(new ClientsExport, 'clientes.xlsx');
    }

    public function pdfCliente()
    {
        $clientes = Cliente::get();
        // Generar el contenido del ticket en HTML
        $html = View::make('admin.cliente.reporte', compact('clientes'))->render();

        // Generar el PDF utilizando laravel-dompdf con orientación horizontal
        $pdf = Pdf::loadHTML($html)->setPaper('a4', 'landscape')->setWarnings(false);

        return $pdf->stream('reporte.pdf');
    }

    public function excelEmpleado()
    {
        return Excel::download(new EmpleadosExport, 'empleados.xlsx');
    }

    public function pdfEmpleado()
    {
        $empleados = Empleado::get();
        // Generar el contenido del ticket en HTML
        $html = View::make('admin.empleados.reporte', compact('empleados'))->render();

        // Generar el PDF utilizando laravel-dompdf con orientación horizontal
        $pdf = Pdf::loadHTML($html)->setPaper('a4', 'landscape')->setWarnings(false);

        return $pdf->stream('reporte.pdf');
    }


    public function excelCaja()
    {
        return Excel::download(new CajasExport, 'cajas.xlsx');
    }

    public function pdfCaja()
    {
        $cajas = Caja::get();
        // Generar el contenido del ticket en HTML
        $html = View::make('admin.caja.reporte', compact('cajas'))->render();

        // Generar el PDF utilizando laravel-dompdf con orientación horizontal
        $pdf = Pdf::loadHTML($html)->setPaper('a4', 'landscape')->setWarnings(false);

        return $pdf->stream('reporte.pdf');
    }

    public function excelGasto()
    {
        return Excel::download(new GastosExport, 'gastos.xlsx');
    }

    public function pdfGasto()
    {
        $userId = Auth::id();
        $gastos = Gasto::with(['usuario'])->where('id_usuario', $userId)->get();
        // Generar el contenido del ticket en HTML
        $html = View::make('admin.gastos.reporte', compact('gastos'))->render();

        // Generar el PDF utilizando laravel-dompdf con orientación horizontal
        $pdf = Pdf::loadHTML($html)->setPaper('a4', 'landscape')->setWarnings(false);

        return $pdf->stream('reporte.pdf');
    }
}
