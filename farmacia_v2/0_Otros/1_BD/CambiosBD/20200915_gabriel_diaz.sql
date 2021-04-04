UPDATE	`maestro_vista`
SET		`gl_url`	=	'Farmacia/Farmacias/Establecimiento'
WHERE	`m_v_id`	=	5;

UPDATE	`maestro_vista`
SET		`gl_url`	=	'Farmacia/Farmacias/Empresa'
WHERE	`m_v_id`	=	4;

update		`local`
LEFT JOIN	comuna	ON	local.fk_comuna	=	comuna.comuna_id
SET			`local`.`id_region_midas`	=	comuna.fk_region_midas,
			`local`.`id_comuna_midas`	=	comuna.id_comuna_midas;