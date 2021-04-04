UPDATE	`ws_acceso_sistemas`
SET		`json_permisos` =
'[
	{
		"metodo": "negociar",
		"limite_dia": 5000,
		"limite_hora": 1000,
		"estado": 1,
		"fc_vigencia": null
	},{
		"metodo": "registrarEstablecimiento",
		"limite_dia": 500,
		"limite_hora": 100,
		"estado": 1,
		"fc_vigencia": null
	}
]'
WHERE	`id_sistema` = 1;
ALTER TABLE `ws_auditoria` CHANGE `id_auditoria_ws` `id_auditoria_ws` INT(11) NOT NULL AUTO_INCREMENT;