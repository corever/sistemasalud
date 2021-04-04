ALTER TABLE	`farmacia`
ADD			`gl_token`	VARCHAR(255) NULL DEFAULT NULL
AFTER		`farmacia_id`;

ALTER TABLE	`farmacia`
ADD	INDEX(`gl_token`);

-- Atención! - Se debe ejecutar función "regularizarFarmacia" en Farmacia/Farmacias/Empresa