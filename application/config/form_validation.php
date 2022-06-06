<?php
if( ! defined('BASEPATH') ) exit('No direct script access allowed');


$config = array(
	'searchlists_post'	=>	array(
			array( 'field'=>'nombre', 'label'=>'nombre','rules'=>'trim|required' ),
			array( 'field'=>'paterno', 'label'=>'apaterno','rules'=>'trim|required' ),
			array( 'field'=>'materno', 'label'=>'amaterno','rules'=>'trim' ),
			array( 'field'=>'rfc', 'label'=>'rfc','rules'=>'trim' ),
			array( 'field'=>'tipo', 'label'=>'buscar','rules'=>'trim|required'),
			array( 'field'=>'curp', 'label'=>'curp','rules'=>'trim' ),
			),
	'searchlistsm_post'	=>	array(
			array( 'field'=>'razon_social', 'label'=>'nombre','rules'=>'trim|required' ),
			array( 'field'=>'rfc', 'label'=>'rfc','rules'=>'trim' ),
			array( 'field'=>'busqueda', 'label'=>'buscar','rules'=>'trim|required' ),
			),
		'searchperson_post'	=>	array(
				array( 'field'=>'tipo_busqueda', 'label'=>'tipo_busqueda','rules'=>'trim|required' ),
				array( 'field'=>'tipo_persona', 'label'=>'tipo_persona','rules'=>'trim|required' ),
				array( 'field'=>'nombre', 'label'=>'nombre','rules'=>'trim|required' ),
				array( 'field'=>'apaterno', 'label'=>'apaterno','rules'=>'trim' ),
				array( 'field'=>'amaterno', 'label'=>'amaterno','rules'=>'trim' ),
				array( 'field'=>'curp', 'label'=>'curp','rules'=>'trim' ),
				array( 'field'=>'rfc', 'label'=>'rfc','rules'=>'trim' ),
		),

    'searchpersonPruebas_post'	=>	array(
				array( 'field'=>'id_entidad', 'label'=>'id_entidad','rules'=>'trim|required' ),
				array( 'field'=>'nombre', 'label'=>'nombre','rules'=>'trim|required'),
				array( 'field'=>'apaterno', 'label'=>'apaterno','rules'=>'trim' ),
				array( 'field'=>'amaterno', 'label'=>'amaterno','rules'=>'trim' ),
				),

		'searchpersonpld_post'	=>	array(
				array( 'field'=>'tipo_busqueda', 'label'=>'tipo_busqueda','rules'=>'trim|required' ),
        array( 'field'=>'id_entidad', 'label'=>'id_entidad','rules'=>'trim|required' ),
				array( 'field'=>'tipo_persona', 'label'=>'tipo_persona','rules'=>'trim|required' ),
				array( 'field'=>'nombre', 'label'=>'nombre','rules'=>'trim|required' ),
				array( 'field'=>'apaterno', 'label'=>'apaterno','rules'=>'trim' ),
				array( 'field'=>'amaterno', 'label'=>'amaterno','rules'=>'trim' ),
				array( 'field'=>'curp', 'label'=>'curp','rules'=>'trim' ),
				array( 'field'=>'rfc', 'label'=>'rfc','rules'=>'trim' ),
		),
		'paises_post'	=>	array(
				array( 'field'=>'pais', 'label'=>'pais','rules'=>'trim|required' ),
        ),

        'searchpersonlpb_post'	=>	array(
                        array( 'field'=>'tipo_busqueda', 'label'=>'tipo_busqueda','rules'=>'trim|required' ),
                        array( 'field'=>'id_entidad', 'label'=>'id_entidad','rules'=>'trim|required' ),
                        array( 'field'=>'tipo_persona', 'label'=>'tipo_persona','rules'=>'trim|required' ),
                        array( 'field'=>'nombre', 'label'=>'nombre','rules'=>'trim|required' ),
                        array( 'field'=>'apaterno', 'label'=>'apaterno','rules'=>'trim' ),
                        array( 'field'=>'amaterno', 'label'=>'amaterno','rules'=>'trim' ),
                        array( 'field'=>'curp', 'label'=>'curp','rules'=>'trim' ),
                        array( 'field'=>'rfc', 'label'=>'rfc','rules'=>'trim' ),
        ),

				'lpb_post'	=>	array(
                        array( 'field'=>'nombre', 'label'=>'nombre','rules'=>'trim|required' ),
                        array( 'field'=>'paterno', 'label'=>'paterno','rules'=>'trim' ),
                        array( 'field'=>'materno', 'label'=>'materno','rules'=>'trim' ),
                        array( 'field'=>'rfc', 'label'=>'rfc','rules'=>'trim' ),
                        array( 'field'=>'curp', 'label'=>'curp','rules'=>'trim' ),
                        array( 'field'=>'nacionalidad', 'label'=>'nacionalidad','rules'=>'trim' ),
                        array( 'field'=>'observaciones', 'label'=>'observaciones','rules'=>'trim' ),
                        array( 'field'=>'actividad', 'label'=>'actividad','rules'=>'trim' ),
											  array( 'field'=>'fecha', 'label'=>'fecha','rules'=>'trim' ),
											  array( 'field'=>'situacion_contribuyente', 'label'=>'situacion_contribuyente','rules'=>'trim' ),
												array( 'field'=>'numero_oficio', 'label'=>'numero_oficio','rules'=>'trim' ),
												 array( 'field'=>'id_entidad', 'label'=>'id_entidad','rules'=>'trim|required' ),
        ),
	);




?>
