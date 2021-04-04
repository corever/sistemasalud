UPDATE	`maestro_vista`
SET		`nombre_vista`	=	'Empresa Farmacéutica',
		`gl_url`		=	'Farmacia/Farmacias/Empresa',
		`fk_modulo`		=	'1',
		`link_vista`	=	'empresa'
WHERE	`m_v_id`		=	46;

UPDATE	`maestro_vista`
SET		`nombre_vista`	=	'Establecimiento Farmacéutico',
		`gl_url`		=	'Farmacia/Farmacias/Establecimiento',
		`link_vista`	=	'establecimiento',
		`fk_modulo`		=	'1'
WHERE	`m_v_id`		=	47;