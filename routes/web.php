<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\adminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\GestionController;
use App\Http\Controllers\LogisticaController;
use App\Http\Controllers\GestionventasController;
use App\Http\Controllers\FacturacionController;
use App\Http\Controllers\ReporteController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});
route::get('/phpinfo', function(){
    phpinfo();
});

route::get('/',[InicioController::class ,'inicio'])->name('inicio.inicio');
Route::prefix('inicio')->group(function () {
    route::get('/login_',[InicioController::class ,'login_'])->name('inicio.login_');
});

route::get('admin',[adminController::class ,'inicio'])->name('admin')->middleware('auth');
route::get('video_en_vivo',[adminController::class ,'video_en_vivo'])->name('video_en_vivo');
route::get('login',[LoginController::class ,'login'])->name('login');
route::post('Login-in',[LoginController::class ,'iniciar_sesion'])->name('iniciar_sesion');
route::get('Sign-off',[LoginController::class ,'cerrar_session'])->name('cerrar_session')->middleware('auth');

route::post('admin/aperturar_caja',[adminController::class ,'aperturar_caja'])->name('admin.aperturar_caja');
route::post('admin/cerrar_caja',[adminController::class ,'cerrar_caja'])->name('admin.cerrar_caja');
route::post('admin/informacionusuario',[adminController::class ,'informacionusuario'])->name('admin.informacionusuario');
route::post('admin/modificarInformacionusuarioLogueado',[adminController::class ,'modificarInformacionusuarioLogueado'])->name('admin.modificarInformacionusuarioLogueado');


// backend para configuracion
Route::prefix('configuracion')->middleware('auth')->group(function () {
    // Rutas del grupo
    route::get('/menus',[ConfiguracionController::class ,'menus'])->name('configuracion.menus')->middleware('role:superadmin')->middleware('can:menus');
    route::get('/submenu/{menu}',[ConfiguracionController::class ,'submenus'])->name('configuracion.submenu')->middleware('role:superadmin')->middleware('can:submenu');
    route::get('/opciones/{menu}',[ConfiguracionController::class ,'opciones'])->name('configuracion.opciones')->middleware('role:superadmin')->middleware('can:opciones');
    route::get('/usuarios',[ConfiguracionController::class ,'usuarios'])->name('configuracion.usuarios')->middleware('can:usuarios');
    route::get('/roles',[ConfiguracionController::class ,'roles'])->name('configuracion.roles')->middleware('role:superadmin')->middleware('can:roles');
    route::get('/permisos',[ConfiguracionController::class ,'permisos'])->name('configuracion.permisos')->middleware('role:superadmin')->middleware('can:permisos');
    route::get('/iconos',[ConfiguracionController::class ,'iconos'])->name('configuracion.iconos')->middleware('can:iconos');

    route::post('/crear_menu',[ConfiguracionController::class ,'crear_menu'])->name('configuracion.crear_menu')->middleware('role:superadmin')->middleware('can:crear_menu');
    route::post('/crear_submenu',[ConfiguracionController::class ,'crear_submenu'])->name('configuracion.crear_submenu')->middleware('role:superadmin')->middleware('can:crear_submenu');
    route::post('/crear_opciones',[ConfiguracionController::class ,'crear_opciones'])->name('configuracion.crear_opciones')->middleware('role:superadmin')->middleware('can:crear_opciones');
    route::post('/crear_permisos_opciones',[ConfiguracionController::class ,'crear_permisos_opciones'])->name('configuracion.crear_permisos_opciones')->middleware('role:superadmin')->middleware('can:crear_permisos_opciones');
    route::post('/crear_usuarios',[ConfiguracionController::class ,'crear_usuarios'])->name('configuracion.crear_usuarios')->middleware('can:crear_usuarios');
    route::post('/crear_rol',[ConfiguracionController::class ,'crear_rol'])->name('configuracion.crear_rol')->middleware('role:superadmin')->middleware('can:crear_rol');
    route::post('/crear_permisos_rol',[ConfiguracionController::class ,'crear_permisos_rol'])->name('configuracion.crear_permisos_rol')->middleware('role:superadmin')->middleware('can:crear_permisos_rol');
    route::post('/crear_permisos',[ConfiguracionController::class ,'crear_permisos'])->name('configuracion.crear_permisos')->middleware('role:superadmin')->middleware('can:crear_permisos');

    route::post('/listar_datos_menu',[ConfiguracionController::class ,'listar_datos_menu'])->name('configuracion.listar_datos_menu')->middleware('can:listar_datos_menu');
    route::post('/listar_datos_submenu',[ConfiguracionController::class ,'listar_datos_submenu'])->name('configuracion.listar_datos_submenu')->middleware('can:listar_datos_submenu');
    route::post('/listar_datos_opciones',[ConfiguracionController::class ,'listar_datos_opciones'])->name('configuracion.listar_datos_opciones')->middleware('can:listar_datos_opciones');
    route::post('/listar_acciones_opciones',[ConfiguracionController::class ,'listar_acciones_opciones'])->name('configuracion.listar_acciones_opciones')->middleware('can:listar_acciones_opciones');
    route::post('/listar_datos_usuario',[ConfiguracionController::class ,'listar_datos_usuario'])->name('configuracion.listar_datos_usuario')->middleware('can:listar_datos_usuario');
    route::post('/listar_datos_rol',[ConfiguracionController::class ,'listar_datos_rol'])->name('configuracion.listar_datos_rol')->middleware('can:listar_datos_rol');
    route::post('/listar_datos_permisos_por_rol',[ConfiguracionController::class ,'listar_datos_permisos_por_rol'])->name('configuracion.listar_datos_permisos_por_rol')->middleware('can:listar_datos_permisos_por_rol');


    route::post('/deshabilitar_opcion',[ConfiguracionController::class ,'deshabilitar_opcion'])->name('configuracion.deshabilitar_opcion')->middleware('can:deshabilitar_opcion');
    route::post('/deshabilitar_submenu',[ConfiguracionController::class ,'deshabilitar_submenu'])->name('configuracion.deshabilitar_submenu')->middleware('can:deshabilitar_submenu');
    route::post('/deshabilitar_menu',[ConfiguracionController::class ,'deshabilitar_menu'])->name('configuracion.deshabilitar_menu')->middleware('can:deshabilitar_menu');
    route::post('/deshabilitar_usuario',[ConfiguracionController::class ,'deshabilitar_usuario'])->name('configuracion.deshabilitar_usuario')->middleware('can:deshabilitar_usuario');
    route::post('/deshabilitar_rol',[ConfiguracionController::class ,'deshabilitar_rol'])->name('configuracion.deshabilitar_rol')->middleware('can:deshabilitar_rol');
    route::post('/deshabilitar_permiso',[ConfiguracionController::class ,'deshabilitar_permiso'])->name('configuracion.deshabilitar_permiso')->middleware('can:deshabilitar_permiso');
    route::post('/eliminar_permiso',[ConfiguracionController::class ,'eliminar_permiso'])->name('configuracion.eliminar_permiso')->middleware('can:eliminar_permiso');

});



Route::prefix('Gestion')->middleware('auth')->group(function () {
    // Rutas del grupo

    route::get('/proveedores',[GestionController::class ,'proveedores'])->name('Gestion.proveedores')->middleware('can:proveedores');
    route::get('/familias',[GestionController::class ,'familias'])->name('Gestion.familias')->middleware('can:familias');
    route::get('/clientes',[GestionController::class ,'clientes'])->name('Gestion.clientes')->middleware('can:clientes');
    route::get('/categoria',[GestionController::class ,'categoria'])->name('Gestion.categoria')->middleware('can:categoria');
    route::get('/proveedores_excel',[GestionController::class ,'proveedores_excel'])->name('Gestion.proveedores_excel')->middleware('can:proveedores_excel');

    route::post('/guardar_proveedor',[GestionController::class ,'guardar_proveedor'])->name('Gestion.guardar_proveedor')->middleware('can:guardar_proveedor');
    route::post('/guardar_familia',[GestionController::class ,'guardar_familia'])->name('Gestion.guardar_familia')->middleware('can:guardar_familia');
    route::post('/guardar_cliente',[GestionController::class ,'guardar_cliente'])->name('Gestion.guardar_cliente')->middleware('can:guardar_cliente');
    route::post('/guardar_categoria',[GestionController::class ,'guardar_categoria'])->name('Gestion.guardar_categoria')->middleware('can:guardar_categoria');

    route::post('/listar_datos_proveedor',[GestionController::class ,'listar_datos_proveedor'])->name('Gestion.listar_datos_proveedor')->middleware('can:listar_datos_proveedor');
    route::post('/listarCliente',[GestionController::class ,'listarCliente'])->name('Gestion.listarCliente')->middleware('can:listarCliente');
});


Route::prefix('logistica')->middleware('auth')->group(function () {
    // Rutas del grupo

    route::get('/gestionar_productos',[LogisticaController::class ,'gestionar_productos'])->name('logistica.gestionar_productos')->middleware('can:gestionar_productos');
    route::get('/compras',[LogisticaController::class ,'compras'])->name('logistica.compras')->middleware('can:compras');
    route::get('/ordenCompraDetalle',[LogisticaController::class ,'ordenCompraDetalle'])->name('logistica.ordenCompraDetalle')->middleware('can:ordenCompraDetalle');
    route::get('/compras_pdf',[LogisticaController::class ,'compras_pdf'])->name('logistica.compras_pdf')->middleware('can:compras_pdf');

    route::post('/guardar_producto',[LogisticaController::class ,'guardar_producto'])->name('logistica.guardar_producto')->middleware('can:guardar_producto');
    route::post('/crear_orden_compra',[LogisticaController::class ,'crear_orden_compra'])->name('logistica.crear_orden_compra')->middleware('can:crear_orden_compra');
    route::post('/eliminar_orden_compra',[LogisticaController::class ,'eliminar_orden_compra'])->name('logistica.eliminar_orden_compra')->middleware('can:eliminar_orden_compra');

    route::post('/listar_datos_productos',[LogisticaController::class ,'listar_datos_productos'])->name('logistica.listar_datos_productos')->middleware('can:listar_datos_productos');
    route::post('/buscador_productos',[LogisticaController::class ,'buscador_productos'])->name('logistica.buscador_productos')->middleware('can:buscador_productos');
    route::post('/historial_orden_compra',[LogisticaController::class ,'historial_orden_compra'])->name('logistica.historial_orden_compra')->middleware('can:historial_orden_compra');
    route::get('/orden_compra_historial_excel/{proveedor}/{inicio}/{final}',[LogisticaController::class ,'orden_compra_historial_excel'])->name('logistica.orden_compra_historial_excel')->middleware('can:orden_compra_historial_excel');

    // Guías de remisión
    route::get('/guias_remision',[LogisticaController::class ,'guias_remision'])->name('logistica.guias_remision');
    route::get('/generar_guia',[LogisticaController::class ,'generar_guia'])->name('logistica.generar_guia');
    route::match(['GET','POST'],'/pendientes_guia',[LogisticaController::class ,'pendientes_guia'])->name('logistica.pendientes_guia');
    route::match(['GET','POST'],'/historial_guia',[LogisticaController::class ,'historial_guia'])->name('logistica.historial_guia');
    route::post('/guardar_guia',[LogisticaController::class ,'guardar_guia'])->name('logistica.guardar_guia');
    route::post('/enviar_guia_sunat',[LogisticaController::class ,'enviar_guia_sunat'])->name('logistica.enviar_guia_sunat');
    route::post('/eliminar_guia',[LogisticaController::class ,'eliminar_guia'])->name('logistica.eliminar_guia');
});
Route::prefix('Gestionventas')->middleware('auth')->group(function () {
    // Rutas del grupo

    route::get('/movimientos',[GestionventasController::class ,'movimientos'])->name('Gestionventas.movimientos')->middleware('can:movimientos');
    route::get('/realizar_ventas',[GestionventasController::class ,'realizar_ventas'])->name('Gestionventas.realizar_ventas')->middleware('can:realizar_ventas');
    route::get('/venta_detalle',[GestionventasController::class ,'venta_detalle'])->name('Gestionventas.venta_detalle')->middleware('can:venta_detalle');
    route::match(['GET', 'POST'],'/proformas',[GestionventasController::class ,'proformas'])->name('Gestionventas.proformas')->middleware('can:proformas');
    route::get('/gestion_proforma',[GestionventasController::class ,'gestion_proforma'])->name('Gestionventas.gestion_proforma')->middleware('can:gestion_proforma');
    route::get('/edit_proforma',[GestionventasController::class ,'edit_proforma'])->name('Gestionventas.edit_proforma')->middleware('can:edit_proforma  ');

    route::get('/imprimir_proforma',[GestionventasController::class ,'imprimir_proforma'])->name('Gestionventas.imprimir_proforma');
    //    route::get('/compras',[LogisticaController::class ,'compras'])->name('logistica.compras')->middleware('can:compras');
//    route::get('/ordenCompraDetalle',[LogisticaController::class ,'ordenCompraDetalle'])->name('logistica.ordenCompraDetalle')->middleware('can:ordenCompraDetalle');
    route::get('/imprimir_ticket_pdf',[GestionventasController::class ,'imprimir_ticket_pdf'])->name('Gestionventas.imprimir_ticket_pdf')->middleware('can:imprimir_ticket_pdf');
    route::get('/imprimir_ticketera_venta',[GestionventasController::class ,'imprimir_ticketera_venta'])->name('Gestionventas.imprimir_ticketera_venta')->middleware('can:imprimir_ticket_pdf');
    route::post('/enviarComprobanteporCorreo',[GestionventasController::class ,'enviarComprobanteporCorreo'])->name('Gestionventas.enviarComprobanteporCorreo')->middleware('can:enviarComprobanteporCorreo');

//    route::post('/guardar_producto',[LogisticaController::class ,'guardar_producto'])->name('logistica.guardar_producto')->middleware('can:guardar_producto');
//    route::post('/crear_orden_compra',[LogisticaController::class ,'crear_orden_compra'])->name('logistica.crear_orden_compra')->middleware('can:crear_orden_compra');

    route::post('/detalle_movimientos_productos',[GestionventasController::class ,'detalle_movimientos_productos'])->name('Gestionventas.detalle_movimientos_productos')->middleware('can:detalle_movimientos_productos');
    route::post('/realizar_movimientos',[GestionventasController::class ,'realizar_movimientos'])->name('Gestionventas.realizar_movimientos')->middleware('can:realizar_movimientos');
    route::post('/realizar_proforma',[GestionventasController::class ,'realizar_proforma'])->name('Gestionventas.realizar_proforma')->middleware('can:realizar_proforma');
    route::post('/listarInformacionProforma',[GestionventasController::class ,'listarInformacionProforma'])->name('Gestionventas.listarInformacionProforma')->middleware('can:listarInformacionProforma');
    route::post('/buscar_movimientos_productos',[GestionventasController::class ,'buscar_movimientos_productos'])->name('Gestionventas.buscar_movimientos_productos')->middleware('can:buscar_movimientos_productos');
    route::post('/buscar_productos',[GestionventasController::class ,'buscar_productos'])->name('Gestionventas.buscar_productos')->middleware('can:buscar_productos');
    route::post('/consultar_serie',[GestionventasController::class ,'consultar_serie'])->name('Gestionventas.consultar_serie')->middleware('can:consultar_serie');
    route::post('/generar_venta',[GestionventasController::class ,'generar_venta'])->name('Gestionventas.generar_venta')->middleware('can:generar_venta');
//    route::post('/historial_orden_compra',[LogisticaController::class ,'historial_orden_compra'])->name('logistica.historial_orden_compra')->middleware('can:historial_orden_compra');

});


Route::prefix('facturacion')->middleware('auth')->group(function () {
    // Rutas del grupo
    route::match(['GET', 'POST'],'/pendiente_declarar',[FacturacionController::class ,'pendiente_declarar'])->name('facturacion.pendiente_declarar')->middleware('can:pendiente_declarar')->middleware('verifyUserStatus');
    route::match(['GET', 'POST'],'/historial_envios',[FacturacionController::class ,'historial_envios'])->name('facturacion.historial_envios')->middleware('can:historial_envios')->middleware('verifyUserStatus');
    route::get('/cajas',[FacturacionController::class ,'cajas'])->name('facturacion.cajas')->middleware('can:cajas')->middleware('verifyUserStatus');
    route::get('/ventas',[FacturacionController::class ,'ventas'])->name('facturacion.ventas')->middleware('can:ventas')->middleware('verifyUserStatus');
    route::get('/detalle_resumen/{id}',[FacturacionController::class ,'detalle_resumen'])->name('facturacion.detalle_resumen')->middleware('can:detalle_resumen')->middleware('verifyUserStatus');
    route::get('/generar_nota/{id}',[FacturacionController::class ,'generar_nota'])->name('facturacion.generar_nota')->middleware('can:generar_nota')->middleware('verifyUserStatus');

    route::post('/crear_xml_enviar_sunat',[FacturacionController::class ,'crear_xml_enviar_sunat'])->name('facturacion.crear_xml_enviar_sunat')->middleware('can:crear_xml_enviar_sunat')->middleware('verifyUserStatus');
    route::post('/crear_xml_enviar_sunatPri',[FacturacionController::class ,'crear_xml_enviar_sunatPri'])->name('facturacion.crear_xml_enviar_sunatPri')->middleware('can:crear_xml_enviar_sunatPri')->middleware('verifyUserStatus');
    route::post('/crear_enviar_resumen_sunat',[FacturacionController::class ,'crear_enviar_resumen_sunat'])->name('facturacion.crear_enviar_resumen_sunat')->middleware('can:crear_enviar_resumen_sunat')->middleware('verifyUserStatus');
    route::post('/crear_enviar_resumen_sunatPri',[FacturacionController::class ,'crear_enviar_resumen_sunatPri'])->name('facturacion.crear_enviar_resumen_sunatPri')->middleware('can:crear_enviar_resumen_sunatPri')->middleware('verifyUserStatus');
    route::post('/tipo_nota_descripcion',[FacturacionController::class ,'tipo_nota_descripcion'])->name('facturacion.tipo_nota_descripcion')->middleware('can:tipo_nota_descripcion')->middleware('verifyUserStatus');
    route::post('/comunicacion_baja',[FacturacionController::class ,'comunicacion_baja'])->name('facturacion.comunicacion_baja')->middleware('can:comunicacion_baja')->middleware('verifyUserStatus');
    route::post('/consultar_serie',[FacturacionController::class ,'consultar_serie'])->name('facturacion.consultar_serie')->middleware('can:consultar_serie')->middleware('verifyUserStatus');
    route::post('/generar_nota_re',[FacturacionController::class ,'generar_nota_re'])->name('facturacion.generar_nota_re')->middleware('can:generar_nota_re')->middleware('verifyUserStatus');
    route::post('/anular_boleta_cambiarestado',[FacturacionController::class ,'anular_boleta_cambiarestado'])->name('facturacion.anular_boleta_cambiarestado')->middleware('can:anular_boleta_cambiarestado')->middleware('verifyUserStatus');
    route::post('/cambiarestado_enviado',[FacturacionController::class ,'cambiarestado_enviado'])->name('facturacion.cambiarestado_enviado')->middleware('can:cambiarestado_enviado')->middleware('verifyUserStatus');
    route::post('/buscar_productos',[FacturacionController::class ,'buscar_productos'])->name('facturacion.buscar_productos')->middleware('verifyUserStatus');


    route::get('/excel_ventas_enviadas',[FacturacionController::class ,'excel_ventas_enviadas'])->name('facturacion.excel_ventas_enviadas')->middleware('can:excel_ventas_enviadas')->middleware('verifyUserStatus');

    route::post('/consultar_ticket_resumen',[FacturacionController::class ,'consultar_ticket_resumen'])->name('facturacion.consultar_ticket_resumen')->middleware('can:consultar_ticket_resumen')->middleware('verifyUserStatus');
    route::post('/enviarComprobanteporCorreo',[FacturacionController::class ,'enviarComprobanteporCorreo'])->name('facturacion.enviarComprobanteporCorreo')->middleware('can:enviarComprobanteporCorreo')->middleware('verifyUserStatus');
});


Route::prefix('reporte')->middleware('auth')->group(function () {
    // Rutas del grupo
    route::match(['GET', 'POST'],'/ventas_por_caja',[ReporteController::class ,'ventas_por_caja'])->name('reporte.ventas_por_caja')->middleware('can:ventas_por_caja')->middleware('verifyUserStatus');
    route::match(['GET', 'POST'],'/reporte_de_productos',[ReporteController::class ,'reporte_de_productos'])->name('reporte.reporte_de_productos')->middleware('can:reporte_de_productos')->middleware('verifyUserStatus');
    route::match(['GET', 'POST'],'/reporte_de_ventas',[ReporteController::class ,'reporte_de_ventas'])->name('reporte.reporte_de_ventas')->middleware('can:reporte_de_ventas')->middleware('verifyUserStatus');
    route::get('/buscar_clientes_reporte',[ReporteController::class ,'buscar_clientes_reporte'])->name('reporte.buscar_clientes_reporte')->middleware('verifyUserStatus');
    route::match(['GET', 'POST'],'/proveedores_reporte',[ReporteController::class ,'proveedores_reporte'])->name('reporte.proveedores_reporte')->middleware('can:proveedores_reporte')->middleware('verifyUserStatus');

    route::get('/reporteCitas_excel',[ReporteController::class ,'reporteCitas_excel'])->name('reporte.reporteCitas_excel')->middleware('can:reporteCitas_excel')->middleware('verifyUserStatus');
    route::get('/reporteCitasMedico_excel',[ReporteController::class ,'reporteCitasMedico_excel'])->name('reporte.reporteCitasMedico_excel')->middleware('can:reporteCitasMedico_excel')->middleware('verifyUserStatus');

    route::get('/pdf_report_caja',[ReporteController::class ,'pdf_report_caja'])->name('reporte.pdf_report_caja')->middleware('verifyUserStatus');
    route::post('/listar_citas_paciente',[ReporteController::class ,'listar_citas_paciente'])->name('reporte.listar_citas_paciente')->middleware('can:listar_citas_paciente')->middleware('verifyUserStatus');

    // Nuevos reportes
    route::match(['GET','POST'],'/reporte_inventario',[ReporteController::class,'reporte_inventario'])->name('reporte.reporte_inventario')->middleware('verifyUserStatus');
    route::get('/reporte_inventario_excel',[ReporteController::class,'reporte_inventario_excel'])->name('reporte.reporte_inventario_excel')->middleware('verifyUserStatus');
    route::get('/reporte_inventario_pdf',[ReporteController::class,'reporte_inventario_pdf'])->name('reporte.reporte_inventario_pdf')->middleware('verifyUserStatus');
    route::match(['GET','POST'],'/reporte_clientes_proveedores',[ReporteController::class,'reporte_clientes_proveedores'])->name('reporte.reporte_clientes_proveedores')->middleware('verifyUserStatus');
    route::get('/reporte_clientes_proveedores_excel',[ReporteController::class,'reporte_clientes_proveedores_excel'])->name('reporte.reporte_clientes_proveedores_excel')->middleware('verifyUserStatus');
    route::get('/reporte_clientes_proveedores_pdf',[ReporteController::class,'reporte_clientes_proveedores_pdf'])->name('reporte.reporte_clientes_proveedores_pdf')->middleware('verifyUserStatus');

    // Exports de reportes existentes
    route::get('/reporte_ventas_excel',[ReporteController::class,'reporte_ventas_excel'])->name('reporte.reporte_ventas_excel')->middleware('verifyUserStatus');
    route::get('/reporte_ventas_pdf',[ReporteController::class,'reporte_ventas_pdf'])->name('reporte.reporte_ventas_pdf')->middleware('verifyUserStatus');
    route::get('/reporte_productos_excel',[ReporteController::class,'reporte_productos_excel'])->name('reporte.reporte_productos_excel')->middleware('verifyUserStatus');
    route::get('/reporte_productos_pdf',[ReporteController::class,'reporte_productos_pdf'])->name('reporte.reporte_productos_pdf')->middleware('verifyUserStatus');
    route::get('/ventas_caja_excel',[ReporteController::class,'ventas_caja_excel'])->name('reporte.ventas_caja_excel')->middleware('verifyUserStatus');
    route::get('/proveedores_excel',[ReporteController::class,'proveedores_excel'])->name('reporte.proveedores_excel')->middleware('verifyUserStatus');
    route::get('/proveedores_pdf',[ReporteController::class,'proveedores_pdf'])->name('reporte.proveedores_pdf')->middleware('verifyUserStatus');


});
