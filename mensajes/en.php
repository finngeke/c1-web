<?php

return array(
    'alerta_tecnico' => array(
        'head' => 'Tareas asignadas pendientes',
        'msg' => 'tareas pendientes.',
        'icon' => 'warning',
        'color' => 'yellow'
    ),
    'alerta_soporte' => array(
        'head' => 'Existen solicitudes por asignar',
        'msg' => 'solicitudes sin asignar a un técnico.',
        'icon' => 'info',
        'color' => 'blue'
    ),
    'error_formulario' => array(
        'head' => ' ERROR en el formulario',
        'msg' => '',
        'icon' => 'danger',
        'color' => 'yellow'
    ),
    'error_reg_correo' => array(
        'head' => 'CORREO NO REGISTRADO',
        'msg' => 'Debe ingresar el correo del manualmente, solicitelo al area comercial CRS.HELPDESK.',
        'icon' => 'danger',
        'color' => 'blue'
    ), 
      'error_form_incompleto' => array(
        'head' => 'ERROR en el formulario',
        'msg' => 'Debe ingresar todos los datos del formulario.',
        'icon' => 'danger',
        'color' => 'blue'
    ),   
      'encuesta_cumplida' => array(
        'head' => 'META CUMPLIDA',
        'msg' => 'Para realizar otra campaña de encuesta debe agendar una nueva programación.',
        'icon' => 'warning',
        'color' => 'blue'
    ),  
     'error_duplicado' => array(
        'head' => 'ERROR registro ya se encuentra Insertado.',
        'msg' => '',
        'icon' => 'danger',
        'color' => 'yellow'
    ),
     'error_carga_bmt' => array(
        'head' => 'ERROR',
        'msg' => 'El archivo BMT ya fue cargado.',
        'icon' => 'danger',
        'color' => 'yellow'
    ),
    'error_reporte' => array(
        'head' => 'Error con los filtros ingresados',
        'msg' => '',
        'icon' => 'warning',
        'color' => 'yellow'
    ),
    'exito_formulario' => array(
        'head' => 'NUEVO',
        'msg' => ' Registro ingresado exitosamente.',
        'icon' => 'info',
        'color' => 'blue'
    ),
    'exito_modificacion' => array(
        'head' => 'MODIFICACIÓN',
        'msg' => 'Realizada exitosamente.',
        'icon' => 'warning',
        'color' => 'blue'
    ),
    'activar' => array(
        'head' => 'ACTIVACIÓN',
        'msg' => 'Realizada exitosamente.',
        'icon' => 'success',
        'color' => 'blue'
    ),
    'desactivar' => array(
        'head' => 'DESACTIVACIÓN',
        'msg' => 'Realizada exitosamente.',
        'icon' => 'danger',
        'color' => 'blue'
    ),    
    'bienvenida' => array(
        'head' => 'Estimado Usuario',
        'msg' => 'Recuerde que sus credenciales de acceso son personal, confidencial e intransferible.',
        'icon' => 'fa-info-circle',
        'color' => 'info'),
    'error_login' => array(
        'head' => 'Error en el ingreso',
        'msg' => '',
        'icon' => 'fa-warning',
        'color' => 'danger'),
    'errores' => array(
        'no_rut' => 'No hemos encontrado tu RUT en la base de datos',
        'no_data_login' => 'Error en tu acceso. Comprueba que tu usuario y contraseña esten correctos e intenta nuevamente',
        'fecha_nacimiento' => 'Error en la fecha de nacimiento, por favor confirma que has ingresado una fecha válida',
        'correo' => 'El correo electrónico entregado no existe, por favor verifica que sea una dirección válida'
    ),
    
    'errores_crear_usuario' => array(
        'existe' => 'El rut ingresado ya esta asociado a un usuario de helpdesk'
        
    ),
    'errores_ver_ticket' => array(
        'existe' => 'El Ticket no existe en los registros...'
        
    ),
    'errores_ing_solicitud' => array(
        'existe' => 'No existe el funcionario.'
        
    ),
    
       'reg_tareas' => array(
        'sse_codigo' => 'Nro. Ticket',
        'mae_rut_solicitante' => 'Usuario',
        'cld_codigo' => 'Condici&oacute;n',
        'cco_codigo' => 'Repartici&oacute;n',
        'sse_fono' => 'Fono',
        'sse_problema' => 'Tipo Problema',
        'med_codigo' => 'Medio',
        'sse_fecha_ing' => 'Fecha Solicitud', 
        'sse_estado' => 'ESTADO'
        ),
    'direccion' => array(
        'direccion' => 'Calle, número, dpto, block, casa',
        'villa' => 'Población / Villa',
        'comuna' => 'Comuna',
        'fijo' => 'Teléfono fijo',
        'movil' => 'Teléfono móvil',
        'ej_movil' => '(Si es 09-1234567, ingresa 91234567)'
    ),
    'estudio' => array(
        'carrera' => 'Carrera Actual'
    ),
    'ingreso' => array(
        'tipo' => 'Tipo de ingreso',
        'bruto' => 'Monto bruto',
        'agregar' => 'Agregar ingreso',
        'legal' => 'Menos descuentos legales'
        ),
    'bien' => array(
        'rol' => 'Rol',
        'avaluo' => 'Avalúo Fiscal',
        'uso' => 'Tipo de Uso',
        'agregar' => 'Agregar bien raíz'),
    'vehiculo' => array(
        'marca' => 'Marca',
        'ano' => 'Año',
        'patente' => 'Patente',
        'avaluo' => 'Avalúo Fiscal',
        'uso' => 'Tipo de Uso',
        'agregar' => 'Agregar vehículo'
        ),
    'siguiente' => 'Siguiente',
    'borrar' => 'Borrar'
);
