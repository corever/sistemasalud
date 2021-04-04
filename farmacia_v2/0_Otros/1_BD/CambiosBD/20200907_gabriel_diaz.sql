ALTER TABLE `region`
ADD `gl_latitud` VARCHAR(30) NULL DEFAULT NULL AFTER `nombre_region_corto`,
ADD `gl_longitud` VARCHAR(30) NULL DEFAULT NULL AFTER `gl_latitud`;

UPDATE	region
SET		gl_latitud	=	"-20.232689",
		gl_longitud	=	"-70.136042"
WHERE	region_id	=	2;
UPDATE	region
SET		gl_latitud	=	"-23.655776",
		gl_longitud	=	"-70.397944"
WHERE	region_id	=	3;
UPDATE	region
SET		gl_latitud	=	"-27.368584",
		gl_longitud	=	"-70.332383"
WHERE	region_id	=	4;
UPDATE	region
SET		gl_latitud	=	"-29.904899",
		gl_longitud	=	"-71.251766"
WHERE	region_id	=	5;
UPDATE	region
SET		gl_latitud	=	"-33.04864",
		gl_longitud	=	"-71.613353"
WHERE	region_id	=	6;
UPDATE	region
SET		gl_latitud	=	"-33.479361",
		gl_longitud	=	"-70.633042"
WHERE	region_id	=	7;
UPDATE	region
SET		gl_latitud	=	"-34.5755374",
		gl_longitud	=	"-71.00223110"
WHERE	region_id	=	8;
UPDATE	region
SET		gl_latitud	=	"-35.425676",
		gl_longitud	=	"-71.648958"
WHERE	region_id	=	9;
UPDATE	region
SET		gl_latitud	=	"-36.82396",
		gl_longitud	=	"-73.044973"
WHERE	region_id	=	10;
UPDATE	region
SET		gl_latitud	=	"-38.738163",
		gl_longitud	=	"-72.591269"
WHERE	region_id	=	11;
UPDATE	region
SET		gl_latitud	=	"-41.470482",
		gl_longitud	=	"-72.941322"
WHERE	region_id	=	13;
UPDATE	region
SET		gl_latitud	=	"-45.572074",
		gl_longitud	=	"-72.068376"
WHERE	region_id	=	14;
UPDATE	region
SET		gl_latitud	=	"-53.166717",
		gl_longitud	=	"-70.916665"
WHERE	region_id	=	15;
UPDATE	region
SET		gl_latitud	=	"-18.479707",
		gl_longitud	=	"-70.310482"
WHERE	region_id	=	1;
UPDATE	region
SET		gl_latitud	=	"-36.610027",
		gl_longitud	=	"-72.102127"
WHERE	region_id	=	16;
UPDATE	region
SET		gl_latitud	=	"-39.832774",
		gl_longitud	=	"-73.228373"
WHERE	region_id	=	12;

ALTER TABLE	comuna
ADD gl_latitud VARCHAR(30) NULL DEFAULT NULL AFTER comuna_nombre,
ADD	gl_longitud VARCHAR(30) NULL DEFAULT NULL AFTER gl_latitud;

UPDATE comuna SET  gl_latitud	=	'-18.477677', gl_longitud	=	'-70.311822' WHERE	comuna_id	=	1;
UPDATE comuna SET  gl_latitud	=	'-19.010661', gl_longitud	=	'-69.860076' WHERE	comuna_id	=	2;
UPDATE comuna SET  gl_latitud	=	'-17.869381', gl_longitud	=	'-69.581695' WHERE	comuna_id	=	3;
UPDATE comuna SET  gl_latitud	=	'-18.196932', gl_longitud	=	'-69.559871' WHERE	comuna_id	=	4;
UPDATE comuna SET  gl_latitud	=	'-20.2686722', gl_longitud	=	'-70.10491689999998' WHERE	comuna_id	=	5;
UPDATE comuna SET  gl_latitud	=	'-19.312901218468397', gl_longitud	=	'-69.42663448460695' WHERE	comuna_id	=	6;
UPDATE comuna SET  gl_latitud	=	'-19.27628451426181', gl_longitud	=	'-68.63856867199706' WHERE	comuna_id	=	7;
UPDATE comuna SET  gl_latitud	=	'-19.9972461', gl_longitud	=	'-69.77185150000003' WHERE	comuna_id	=	8;
UPDATE comuna SET  gl_latitud	=	'-20.2307033', gl_longitud	=	'-70.1356692' WHERE	comuna_id	=	9;
UPDATE comuna SET  gl_latitud	=	'-20.489483', gl_longitud	=	'-69.330511' WHERE	comuna_id	=	10;
UPDATE comuna SET  gl_latitud	=	'-20.2567092', gl_longitud	=	'-69.78601279999998' WHERE	comuna_id	=	11;
UPDATE comuna SET  gl_latitud	=	'-23.6509279', gl_longitud	=	'-70.39750219999996' WHERE	comuna_id	=	12;
UPDATE comuna SET  gl_latitud	=	'-22.4543923', gl_longitud	=	'-68.92938190000001' WHERE	comuna_id	=	13;
UPDATE comuna SET  gl_latitud	=	'-22.34408226891233', gl_longitud	=	'-69.66432809829712' WHERE	comuna_id	=	14;
UPDATE comuna SET  gl_latitud	=	'-23.0985013', gl_longitud	=	'-70.4455041' WHERE	comuna_id	=	15;
UPDATE comuna SET  gl_latitud	=	'-21.2256917', gl_longitud	=	'-68.25478020000003' WHERE	comuna_id	=	16;
UPDATE comuna SET  gl_latitud	=	'-22.9087073', gl_longitud	=	'-68.19971559999999' WHERE	comuna_id	=	17;
UPDATE comuna SET  gl_latitud	=	'-22.890124592402437', gl_longitud	=	'-69.31840112963869' WHERE	comuna_id	=	18;
UPDATE comuna SET  gl_latitud	=	'-25.407073844125676', gl_longitud	=	'-70.48051357269281' WHERE	comuna_id	=	19;
UPDATE comuna SET  gl_latitud	=	'-22.0857976', gl_longitud	=	'-70.1930064' WHERE	comuna_id	=	20;
UPDATE comuna SET  gl_latitud	=	'-28.75944400000001', gl_longitud	=	'-70.48666700000001' WHERE	comuna_id	=	21;
UPDATE comuna SET  gl_latitud	=	'-27.0667', gl_longitud	=	'-70.81781419999999' WHERE	comuna_id	=	22;
UPDATE comuna SET  gl_latitud	=	'-26.3450046', gl_longitud	=	'-70.62419299999999' WHERE	comuna_id	=	23;
UPDATE comuna SET  gl_latitud	=	'-27.3665763', gl_longitud	=	'-70.33215869999998' WHERE	comuna_id	=	24;
UPDATE comuna SET  gl_latitud	=	'-26.3902488', gl_longitud	=	'-70.04753019999998' WHERE	comuna_id	=	25;
UPDATE comuna SET  gl_latitud	=	'-28.51209399999999', gl_longitud	=	'-71.07959670000002' WHERE	comuna_id	=	26;
UPDATE comuna SET  gl_latitud	=	'-28.4664', gl_longitud	=	'-71.2192' WHERE	comuna_id	=	27;
UPDATE comuna SET  gl_latitud	=	'-27.4671706', gl_longitud	=	'-70.26521960000002' WHERE	comuna_id	=	28;
UPDATE comuna SET  gl_latitud	=	'-28.5757953', gl_longitud	=	'-70.75710090000001' WHERE	comuna_id	=	29;
UPDATE comuna SET  gl_latitud	=	'-30.23579489999999', gl_longitud	=	'-71.0828027' WHERE	comuna_id	=	30;
UPDATE comuna SET  gl_latitud	=	'-31.398889', gl_longitud	=	'-71.45611099999996' WHERE	comuna_id	=	31;
UPDATE comuna SET  gl_latitud	=	'-31.1790967', gl_longitud	=	'-71.00509579999999' WHERE	comuna_id	=	32;
UPDATE comuna SET  gl_latitud	=	'-29.95900090000001', gl_longitud	=	'-71.33891829999999' WHERE	comuna_id	=	33;
UPDATE comuna SET  gl_latitud	=	'-31.6308', gl_longitud	=	'-71.1653' WHERE	comuna_id	=	34;
UPDATE comuna SET  gl_latitud	=	'-29.51140472215097', gl_longitud	=	'-71.20045065879822' WHERE	comuna_id	=	35;
UPDATE comuna SET  gl_latitud	=	'-29.9026691', gl_longitud	=	'-71.25193739999997' WHERE	comuna_id	=	36;
UPDATE comuna SET  gl_latitud	=	'-31.9121865', gl_longitud	=	'-71.51120170000002' WHERE	comuna_id	=	37;
UPDATE comuna SET  gl_latitud	=	'-30.6978944', gl_longitud	=	'-70.95868889999997' WHERE	comuna_id	=	38;
UPDATE comuna SET  gl_latitud	=	'-30.604304', gl_longitud	=	'-71.19698819999996' WHERE	comuna_id	=	39;
UPDATE comuna SET  gl_latitud	=	'-30.028621800337945', gl_longitud	=	'-70.51665902137756' WHERE	comuna_id	=	40;
UPDATE comuna SET  gl_latitud	=	'-30.82609950000001', gl_longitud	=	'-71.25779119999999' WHERE	comuna_id	=	41;
UPDATE comuna SET  gl_latitud	=	'-30.277525519466963', gl_longitud	=	'-70.66987752914429' WHERE	comuna_id	=	42;
UPDATE comuna SET  gl_latitud	=	'-31.782493', gl_longitud	=	'-70.9607105' WHERE	comuna_id	=	43;
UPDATE comuna SET  gl_latitud	=	'-30.0319', gl_longitud	=	'-70.7081' WHERE	comuna_id	=	44;
UPDATE comuna SET  gl_latitud	=	'-33.36831', gl_longitud	=	'-71.6703' WHERE	comuna_id	=	45;
UPDATE comuna SET  gl_latitud	=	'-32.4258064', gl_longitud	=	'-71.06616209999999' WHERE	comuna_id	=	46;
UPDATE comuna SET  gl_latitud	=	'-32.857493', gl_longitud	=	'-70.62580689999999' WHERE	comuna_id	=	47;
UPDATE comuna SET  gl_latitud	=	'-33.5482466', gl_longitud	=	'-71.60457450000001' WHERE	comuna_id	=	48;
UPDATE comuna SET  gl_latitud	=	'-32.875133', gl_longitud	=	'-70.64882899999998' WHERE	comuna_id	=	49;
UPDATE comuna SET  gl_latitud	=	'-32.9299468', gl_longitud	=	'-71.51860649999998' WHERE	comuna_id	=	50;
UPDATE comuna SET  gl_latitud	=	'-33.398596', gl_longitud	=	'-71.6981538' WHERE	comuna_id	=	51;
UPDATE comuna SET  gl_latitud	=	'-33.4557162', gl_longitud	=	'-71.66693409999999' WHERE	comuna_id	=	52;
UPDATE comuna SET  gl_latitud	=	'-32.7980018', gl_longitud	=	'-71.1437211' WHERE	comuna_id	=	53;
UPDATE comuna SET  gl_latitud	=	'-27.11299', gl_longitud	=	'-109.34958059999997' WHERE	comuna_id	=	54;
UPDATE comuna SET  gl_latitud	=	'-33.64581779855622', gl_longitud	=	'-78.82383273016359' WHERE	comuna_id	=	55;
UPDATE comuna SET  gl_latitud	=	'-32.78779579999999', gl_longitud	=	'-71.20399629999997' WHERE	comuna_id	=	56;
UPDATE comuna SET  gl_latitud	=	'-32.8258069', gl_longitud	=	'-71.2273055' WHERE	comuna_id	=	57;
UPDATE comuna SET  gl_latitud	=	'-32.44990180000001', gl_longitud	=	'-71.23259580000001' WHERE	comuna_id	=	58;
UPDATE comuna SET  gl_latitud	=	'-33.0095283', gl_longitud	=	'-71.25958880000002' WHERE	comuna_id	=	59;
UPDATE comuna SET  gl_latitud	=	'-32.8409806', gl_longitud	=	'-70.956166' WHERE	comuna_id	=	60;
UPDATE comuna SET  gl_latitud	=	'-32.8337995', gl_longitud	=	'-70.59721789999998' WHERE	comuna_id	=	61;
UPDATE comuna SET  gl_latitud	=	'-32.73330000000001', gl_longitud	=	'-71.20421149999999' WHERE	comuna_id	=	62;
UPDATE comuna SET  gl_latitud	=	'-32.9958297', gl_longitud	=	'-71.1812984' WHERE	comuna_id	=	63;
UPDATE comuna SET  gl_latitud	=	'-32.7670303', gl_longitud	=	'-70.83330000000001' WHERE	comuna_id	=	64;
UPDATE comuna SET  gl_latitud	=	'-32.5072087', gl_longitud	=	'-71.44850129999998' WHERE	comuna_id	=	65;
UPDATE comuna SET  gl_latitud	=	'-32.25', gl_longitud	=	'-70.93330000000003' WHERE	comuna_id	=	66;
UPDATE comuna SET  gl_latitud	=	'-32.722005', gl_longitud	=	'-71.41170039999997' WHERE	comuna_id	=	67;
UPDATE comuna SET  gl_latitud	=	'-32.628461', gl_longitud	=	'-70.71774340000002' WHERE	comuna_id	=	68;
UPDATE comuna SET  gl_latitud	=	'-32.8803027', gl_longitud	=	'-71.2497156' WHERE	comuna_id	=	69;
UPDATE comuna SET  gl_latitud	=	'-33.0482707', gl_longitud	=	'-71.4408752' WHERE	comuna_id	=	70;
UPDATE comuna SET  gl_latitud	=	'-32.77231010000001', gl_longitud	=	'-71.5333' WHERE	comuna_id	=	71;
UPDATE comuna SET  gl_latitud	=	'-32.8352416', gl_longitud	=	'-70.70103670000003' WHERE	comuna_id	=	72;
UPDATE comuna SET  gl_latitud	=	'-33.5922807', gl_longitud	=	'-71.60551229999999' WHERE	comuna_id	=	73;
UPDATE comuna SET  gl_latitud	=	'-32.8004995', gl_longitud	=	'-70.57980320000001' WHERE	comuna_id	=	74;
UPDATE comuna SET  gl_latitud	=	'-32.75000000000001', gl_longitud	=	'-70.72081149999997' WHERE	comuna_id	=	75;
UPDATE comuna SET  gl_latitud	=	'-32.7470027', gl_longitud	=	'-70.6587073' WHERE	comuna_id	=	76;
UPDATE comuna SET  gl_latitud	=	'-33.635833', gl_longitud	=	'-71.62805600000002' WHERE	comuna_id	=	77;
UPDATE comuna SET  gl_latitud	=	'-33.04723799999999', gl_longitud	=	'-71.61268849999999' WHERE	comuna_id	=	78;
UPDATE comuna SET  gl_latitud	=	'-33.0516935', gl_longitud	=	'-71.39062339999998' WHERE	comuna_id	=	79;
UPDATE comuna SET  gl_latitud	=	'-33.01534809999999', gl_longitud	=	'-71.55002760000002' WHERE	comuna_id	=	80;
UPDATE comuna SET  gl_latitud	=	'-32.5538059', gl_longitud	=	'-71.4581359' WHERE	comuna_id	=	81;
UPDATE comuna SET  gl_latitud	=	'-42.378003', gl_longitud	=	'-73.651798' WHERE	comuna_id	=	82;
UPDATE comuna SET  gl_latitud	=	'-33.731915', gl_longitud	=	'-70.742231' WHERE	comuna_id	=	83;
UPDATE comuna SET  gl_latitud	=	'-33.628194', gl_longitud	=	'-70.770057' WHERE	comuna_id	=	84;
UPDATE comuna SET  gl_latitud	=	'-33.500749', gl_longitud	=	'-70.709519' WHERE	comuna_id	=	85;
UPDATE comuna SET  gl_latitud	=	'-33.434858', gl_longitud	=	'-70.730044' WHERE	comuna_id	=	86;
UPDATE comuna SET  gl_latitud	=	'-33.204807', gl_longitud	=	'-70.675752' WHERE	comuna_id	=	87;
UPDATE comuna SET  gl_latitud	=	'-33.383446', gl_longitud	=	'-70.677602' WHERE	comuna_id	=	88;
UPDATE comuna SET  gl_latitud	=	'-33.398397', gl_longitud	=	'-71.127384' WHERE	comuna_id	=	89;
UPDATE comuna SET  gl_latitud	=	'-33.564028', gl_longitud	=	'-70.675615' WHERE	comuna_id	=	90;
UPDATE comuna SET  gl_latitud	=	'-33.681842', gl_longitud	=	'-70.985108' WHERE	comuna_id	=	91;
UPDATE comuna SET  gl_latitud	=	'-33.463599', gl_longitud	=	'-70.701278' WHERE	comuna_id	=	92;
UPDATE comuna SET  gl_latitud	=	'-33.374789', gl_longitud	=	'-70.649025' WHERE	comuna_id	=	93;
UPDATE comuna SET  gl_latitud	=	'-33.413347', gl_longitud	=	'-70.666295' WHERE	comuna_id	=	94;
UPDATE comuna SET  gl_latitud	=	'-33.747420', gl_longitud	=	'-70.900116' WHERE	comuna_id	=	95;
UPDATE comuna SET  gl_latitud	=	'-33.529919', gl_longitud	=	'-70.663584' WHERE	comuna_id	=	96;
UPDATE comuna SET  gl_latitud	=	'-33.537088', gl_longitud	=	'-70.586124' WHERE	comuna_id	=	97;
UPDATE comuna SET  gl_latitud	=	'-33.532433', gl_longitud	=	'-70.623861' WHERE	comuna_id	=	98;
UPDATE comuna SET  gl_latitud	=	'-33.587773', gl_longitud	=	'-70.633397' WHERE	comuna_id	=	99;
UPDATE comuna SET  gl_latitud	=	'-33.446470', gl_longitud	=	'-70.546141' WHERE	comuna_id	=	100;
UPDATE comuna SET  gl_latitud	=	'-33.285037', gl_longitud	=	'-70.877380' WHERE	comuna_id	=	101;
UPDATE comuna SET  gl_latitud	=	'-33.409332', gl_longitud	=	'-70.567308' WHERE	comuna_id	=	102;
UPDATE comuna SET  gl_latitud	=	'-33.357689', gl_longitud	=	'-70.511874' WHERE	comuna_id	=	103;
UPDATE comuna SET  gl_latitud	=	'-33.519326', gl_longitud	=	'-70.691010' WHERE	comuna_id	=	104;
UPDATE comuna SET  gl_latitud	=	'-33.446574', gl_longitud	=	'-70.722864' WHERE	comuna_id	=	105;
UPDATE comuna SET  gl_latitud	=	'-33.490635', gl_longitud	=	'-70.599213' WHERE	comuna_id	=	106;
UPDATE comuna SET  gl_latitud	=	'-33.521463', gl_longitud	=	'-70.762566' WHERE	comuna_id	=	107;
UPDATE comuna SET  gl_latitud	=	'-33.517241', gl_longitud	=	'-71.123586' WHERE	comuna_id	=	108;
UPDATE comuna SET  gl_latitud	=	'-33.686780', gl_longitud	=	'-71.216045' WHERE	comuna_id	=	109;
UPDATE comuna SET  gl_latitud	=	'-33.459518', gl_longitud	=	'-70.597858' WHERE	comuna_id	=	110;
UPDATE comuna SET  gl_latitud	=	'-33.575862', gl_longitud	=	'-70.813824' WHERE	comuna_id	=	111;
UPDATE comuna SET  gl_latitud	=	'-33.813328', gl_longitud	=	'-70.737956' WHERE	comuna_id	=	112;
UPDATE comuna SET  gl_latitud	=	'-33.490096', gl_longitud	=	'-70.675792' WHERE	comuna_id	=	113;
UPDATE comuna SET  gl_latitud	=	'-33.606497', gl_longitud	=	'-70.877531' WHERE	comuna_id	=	114;
UPDATE comuna SET  gl_latitud	=	'-33.485871', gl_longitud	=	'-70.547143' WHERE	comuna_id	=	115;
UPDATE comuna SET  gl_latitud	=	'-33.679667', gl_longitud	=	'-70.583014' WHERE	comuna_id	=	116;
UPDATE comuna SET  gl_latitud	=	'-33.431494', gl_longitud	=	'-70.611057' WHERE	comuna_id	=	117;
UPDATE comuna SET  gl_latitud	=	'-33.4421948', gl_longitud	=	'-70.7667027' WHERE	comuna_id	=	118;
UPDATE comuna SET  gl_latitud	=	'-33.620226', gl_longitud	=	'-70.591315' WHERE	comuna_id	=	119;
UPDATE comuna SET  gl_latitud	=	'-33.359090', gl_longitud	=	'-70.728871' WHERE	comuna_id	=	120;
UPDATE comuna SET  gl_latitud	=	'-33.429280', gl_longitud	=	'-70.692999' WHERE	comuna_id	=	121;
UPDATE comuna SET  gl_latitud	=	'-33.405892', gl_longitud	=	'-70.638563' WHERE	comuna_id	=	122;
UPDATE comuna SET  gl_latitud	=	'-33.401565', gl_longitud	=	'-70.707589' WHERE	comuna_id	=	123;
UPDATE comuna SET  gl_latitud	=	'-33.585796', gl_longitud	=	'-70.699551' WHERE	comuna_id	=	124;
UPDATE comuna SET  gl_latitud	=	'-33.496346', gl_longitud	=	'-70.626743' WHERE	comuna_id	=	125;
UPDATE comuna SET  gl_latitud	=	'-33.768167', gl_longitud	=	'-70.276530' WHERE	comuna_id	=	126;
UPDATE comuna SET  gl_latitud	=	'-33.495089', gl_longitud	=	'-70.651496' WHERE	comuna_id	=	127;
UPDATE comuna SET  gl_latitud	=	'-33.894642', gl_longitud	=	'-71.456634' WHERE	comuna_id	=	128;
UPDATE comuna SET  gl_latitud	=	'-33.535854', gl_longitud	=	'-70.644564' WHERE	comuna_id	=	129;
UPDATE comuna SET  gl_latitud	=	'-33.449288', gl_longitud	=	'-70.669287' WHERE	comuna_id	=	130;
UPDATE comuna SET  gl_latitud	=	'-33.664827', gl_longitud	=	'-70.928011' WHERE	comuna_id	=	133;
UPDATE comuna SET  gl_latitud	=	'-33.084425', gl_longitud	=	'-70.928487' WHERE	comuna_id	=	134;
UPDATE comuna SET  gl_latitud	=	'-33.386826', gl_longitud	=	'-70.563540' WHERE	comuna_id	=	135;
UPDATE comuna SET  gl_latitud	=	'-34.7255387', gl_longitud	=	'-71.27259249999997' WHERE	comuna_id	=	136;
UPDATE comuna SET  gl_latitud	=	'-34.70924', gl_longitud	=	'-71.0412713' WHERE	comuna_id	=	137;
UPDATE comuna SET  gl_latitud	=	'-34.0370319', gl_longitud	=	'-70.67286410000003' WHERE	comuna_id	=	138;
UPDATE comuna SET  gl_latitud	=	'-34.26949169158072', gl_longitud	=	'-70.95440643541258' WHERE	comuna_id	=	139;
UPDATE comuna SET  gl_latitud	=	'-34.2877978', gl_longitud	=	'-71.0855512' WHERE	comuna_id	=	140;
UPDATE comuna SET  gl_latitud	=	'-34.228986', gl_longitud	=	'-70.95792879999999' WHERE	comuna_id	=	141;
UPDATE comuna SET  gl_latitud	=	'-34.0666916', gl_longitud	=	'-70.73256459999999' WHERE	comuna_id	=	142;
UPDATE comuna SET  gl_latitud	=	'-34.2051972', gl_longitud	=	'-71.6547276' WHERE	comuna_id	=	143;
UPDATE comuna SET  gl_latitud	=	'-34.29204500000001', gl_longitud	=	'-71.30915099999999' WHERE	comuna_id	=	144;
UPDATE comuna SET  gl_latitud	=	'-34.11727199999999', gl_longitud	=	'-71.72517599999998' WHERE	comuna_id	=	145;
UPDATE comuna SET  gl_latitud	=	'-34.7284166', gl_longitud	=	'-71.64582430000002' WHERE	comuna_id	=	146;
UPDATE comuna SET  gl_latitud	=	'-34.179452', gl_longitud	=	'-70.65651509999998' WHERE	comuna_id	=	147;
UPDATE comuna SET  gl_latitud	=	'-34.4423905', gl_longitud	=	'-70.9463887' WHERE	comuna_id	=	148;
UPDATE comuna SET  gl_latitud	=	'-34.3984467', gl_longitud	=	'-71.62157150000002' WHERE	comuna_id	=	149;
UPDATE comuna SET  gl_latitud	=	'-34.6523209', gl_longitud	=	'-71.1968597' WHERE	comuna_id	=	150;
UPDATE comuna SET  gl_latitud	=	'-33.9593954', gl_longitud	=	'-71.82951880000002' WHERE	comuna_id	=	151;
UPDATE comuna SET  gl_latitud	=	'-34.233', gl_longitud	=	'-70.88299999999998' WHERE	comuna_id	=	152;
UPDATE comuna SET  gl_latitud	=	'-34.596538112864785', gl_longitud	=	'-71.36247217655182' WHERE	comuna_id	=	153;
UPDATE comuna SET  gl_latitud	=	'-34.6519651', gl_longitud	=	'-71.90014480000002' WHERE	comuna_id	=	154;
UPDATE comuna SET  gl_latitud	=	'-34.4772681', gl_longitud	=	'-71.487259' WHERE	comuna_id	=	155;
UPDATE comuna SET  gl_latitud	=	'-34.3963392', gl_longitud	=	'-71.1700793' WHERE	comuna_id	=	156;
UPDATE comuna SET  gl_latitud	=	'-34.3573785', gl_longitud	=	'-71.28725959999997' WHERE	comuna_id	=	157;
UPDATE comuna SET  gl_latitud	=	'-34.3867245', gl_longitud	=	'-72.00477309999997' WHERE	comuna_id	=	158;
UPDATE comuna SET  gl_latitud	=	'-34.6337953', gl_longitud	=	'-71.11082729999998' WHERE	comuna_id	=	159;
UPDATE comuna SET  gl_latitud	=	'-34.6026565', gl_longitud	=	'-71.65529329999998' WHERE	comuna_id	=	160;
UPDATE comuna SET  gl_latitud	=	'-34.3554003', gl_longitud	=	'-70.9704681' WHERE	comuna_id	=	161;
UPDATE comuna SET  gl_latitud	=	'-34.17013240000001', gl_longitud	=	'-70.7406259' WHERE	comuna_id	=	162;
UPDATE comuna SET  gl_latitud	=	'-34.4023791', gl_longitud	=	'-70.86744110000001' WHERE	comuna_id	=	163;
UPDATE comuna SET  gl_latitud	=	'-34.2883749', gl_longitud	=	'-70.815833' WHERE	comuna_id	=	164;
UPDATE comuna SET  gl_latitud	=	'-34.5858603', gl_longitud	=	'-70.9907801' WHERE	comuna_id	=	165;
UPDATE comuna SET  gl_latitud	=	'-34.4349435', gl_longitud	=	'-71.09137479999998' WHERE	comuna_id	=	167;
UPDATE comuna SET  gl_latitud	=	'-34.6324213', gl_longitud	=	'-71.35921159999998' WHERE	comuna_id	=	168;
UPDATE comuna SET  gl_latitud	=	'-35.9676285', gl_longitud	=	'-72.3222331' WHERE	comuna_id	=	169;
UPDATE comuna SET  gl_latitud	=	'-35.73329999999999', gl_longitud	=	'-72.5333' WHERE	comuna_id	=	170;
UPDATE comuna SET  gl_latitud	=	'-35.699248', gl_longitud	=	'-71.4146915' WHERE	comuna_id	=	171;
UPDATE comuna SET  gl_latitud	=	'-35.33330000000001', gl_longitud	=	'-72.41669999999999' WHERE	comuna_id	=	172;
UPDATE comuna SET  gl_latitud	=	'-35.0958545', gl_longitud	=	'-72.02088909999998' WHERE	comuna_id	=	173;
UPDATE comuna SET  gl_latitud	=	'-34.9779853', gl_longitud	=	'-71.25288030000002' WHERE	comuna_id	=	174;
UPDATE comuna SET  gl_latitud	=	'-35.58994300000001', gl_longitud	=	'-72.2763046' WHERE	comuna_id	=	175;
UPDATE comuna SET  gl_latitud	=	'-34.9725157', gl_longitud	=	'-71.7993371' WHERE	comuna_id	=	176;
UPDATE comuna SET  gl_latitud	=	'-34.9852447', gl_longitud	=	'-71.98498799999999' WHERE	comuna_id	=	177;
UPDATE comuna SET  gl_latitud	=	'-35.846407', gl_longitud	=	'-71.59961369999996' WHERE	comuna_id	=	178;
UPDATE comuna SET  gl_latitud	=	'-35.9636265', gl_longitud	=	'-71.68312509999998' WHERE	comuna_id	=	179;
UPDATE comuna SET  gl_latitud	=	'-35.5183364', gl_longitud	=	'-71.68849119999999' WHERE	comuna_id	=	180;
UPDATE comuna SET  gl_latitud	=	'-35.1164987', gl_longitud	=	'-71.2829759' WHERE	comuna_id	=	181;
UPDATE comuna SET  gl_latitud	=	'-36.14064839999999', gl_longitud	=	'-71.82275279999999' WHERE	comuna_id	=	182;
UPDATE comuna SET  gl_latitud	=	'-35.3838823', gl_longitud	=	'-71.44719199999997' WHERE	comuna_id	=	183;
UPDATE comuna SET  gl_latitud	=	'-35.8141512', gl_longitud	=	'-72.57499789999997' WHERE	comuna_id	=	184;
UPDATE comuna SET  gl_latitud	=	'-35.3960652', gl_longitud	=	'-71.79745630000002' WHERE	comuna_id	=	185;
UPDATE comuna SET  gl_latitud	=	'-34.9253441', gl_longitud	=	'-71.3156315' WHERE	comuna_id	=	186;
UPDATE comuna SET  gl_latitud	=	'-36.05766010000001', gl_longitud	=	'-71.7656136' WHERE	comuna_id	=	187;
UPDATE comuna SET  gl_latitud	=	'-35.2808267', gl_longitud	=	'-71.25995069999999' WHERE	comuna_id	=	188;
UPDATE comuna SET  gl_latitud	=	'-34.960474', gl_longitud	=	'-71.12572499999999' WHERE	comuna_id	=	189;
UPDATE comuna SET  gl_latitud	=	'-34.9984205', gl_longitud	=	'-71.34458219999999' WHERE	comuna_id	=	190;
UPDATE comuna SET  gl_latitud	=	'-35.536927', gl_longitud	=	'-71.48602900000003' WHERE	comuna_id	=	191;
UPDATE comuna SET  gl_latitud	=	'-35.5930962', gl_longitud	=	'-71.73250209999998' WHERE	comuna_id	=	192;
UPDATE comuna SET  gl_latitud	=	'-35.3074574', gl_longitud	=	'-71.52349859999998' WHERE	comuna_id	=	193;
UPDATE comuna SET  gl_latitud	=	'-35.42324440000001', gl_longitud	=	'-71.64848039999998' WHERE	comuna_id	=	194;
UPDATE comuna SET  gl_latitud	=	'-34.8702993', gl_longitud	=	'-71.16640330000001' WHERE	comuna_id	=	195;
UPDATE comuna SET  gl_latitud	=	'-34.8837446', gl_longitud	=	'-71.99539720000001' WHERE	comuna_id	=	196;
UPDATE comuna SET  gl_latitud	=	'-35.6761961', gl_longitud	=	'-71.7439129' WHERE	comuna_id	=	197;
UPDATE comuna SET  gl_latitud	=	'-35.750077', gl_longitud	=	'-71.5837328' WHERE	comuna_id	=	198;
UPDATE comuna SET  gl_latitud	=	'-37.3313164', gl_longitud	=	'-71.67642769999998' WHERE	comuna_id	=	199;
UPDATE comuna SET  gl_latitud	=	'-37.2457765', gl_longitud	=	'-73.31666439999998' WHERE	comuna_id	=	200;
UPDATE comuna SET  gl_latitud	=	'-36.7421593', gl_longitud	=	'-72.30177179999998' WHERE	comuna_id	=	201;
UPDATE comuna SET  gl_latitud	=	'-37.0332999', gl_longitud	=	'-72.39999999999998' WHERE	comuna_id	=	202;
UPDATE comuna SET  gl_latitud	=	'-37.8058201', gl_longitud	=	'-73.39197389999998' WHERE	comuna_id	=	203;
UPDATE comuna SET  gl_latitud	=	'-36.95321659999999', gl_longitud	=	'-73.01737800000001' WHERE	comuna_id	=	204;
UPDATE comuna SET  gl_latitud	=	'-36.60626179999999', gl_longitud	=	'-72.1023351' WHERE	comuna_id	=	205;
UPDATE comuna SET  gl_latitud	=	'-36.6291031', gl_longitud	=	'-72.1397968' WHERE	comuna_id	=	206;
UPDATE comuna SET  gl_latitud	=	'-36.1386156', gl_longitud	=	'-72.79452179999998' WHERE	comuna_id	=	207;
UPDATE comuna SET  gl_latitud	=	'-36.4833', gl_longitud	=	'-72.69999999999999' WHERE	comuna_id	=	208;
UPDATE comuna SET  gl_latitud	=	'-36.628285', gl_longitud	=	'-71.83180500000003' WHERE	comuna_id	=	209;
UPDATE comuna SET  gl_latitud	=	'-36.82013519999999', gl_longitud	=	'-73.0443904' WHERE	comuna_id	=	210;
UPDATE comuna SET  gl_latitud	=	'-38.0149266', gl_longitud	=	'-73.22928780000001' WHERE	comuna_id	=	211;
UPDATE comuna SET  gl_latitud	=	'-37.0340769', gl_longitud	=	'-73.14048379999997' WHERE	comuna_id	=	212;
UPDATE comuna SET  gl_latitud	=	'-37.4762431', gl_longitud	=	'-73.34212430000002' WHERE	comuna_id	=	213;
UPDATE comuna SET  gl_latitud	=	'-36.9', gl_longitud	=	'-72.0333' WHERE	comuna_id	=	214;
UPDATE comuna SET  gl_latitud	=	'-36.82378750000001', gl_longitud	=	'-72.66847180000002' WHERE	comuna_id	=	215;
UPDATE comuna SET  gl_latitud	=	'-36.9737875', gl_longitud	=	'-72.9368437' WHERE	comuna_id	=	216;
UPDATE comuna SET  gl_latitud	=	'-37.273322743127736', gl_longitud	=	'-72.71869445034184' WHERE	comuna_id	=	217;
UPDATE comuna SET  gl_latitud	=	'-37.6097143', gl_longitud	=	'-73.64832939999997' WHERE	comuna_id	=	218;
UPDATE comuna SET  gl_latitud	=	'-37.6261237', gl_longitud	=	'-73.46226639999998' WHERE	comuna_id	=	219;
UPDATE comuna SET  gl_latitud	=	'-37.4629159', gl_longitud	=	'-72.36122510000001' WHERE	comuna_id	=	220;
UPDATE comuna SET  gl_latitud	=	'-37.0920575', gl_longitud	=	'-73.1545822' WHERE	comuna_id	=	221;
UPDATE comuna SET  gl_latitud	=	'-37.7178812', gl_longitud	=	'-72.23743430000002' WHERE	comuna_id	=	222;
UPDATE comuna SET  gl_latitud	=	'-37.50590619999999', gl_longitud	=	'-72.6737875' WHERE	comuna_id	=	223;
UPDATE comuna SET  gl_latitud	=	'-37.5862531', gl_longitud	=	'-72.5320562' WHERE	comuna_id	=	224;
UPDATE comuna SET  gl_latitud	=	'-36.40000000000001', gl_longitud	=	'-72.39999999999998' WHERE	comuna_id	=	225;
UPDATE comuna SET  gl_latitud	=	'-36.975945', gl_longitud	=	'-72.099464' WHERE	comuna_id	=	226;
UPDATE comuna SET  gl_latitud	=	'-36.73330000000001', gl_longitud	=	'-72.98329999999999' WHERE	comuna_id	=	227;
UPDATE comuna SET  gl_latitud	=	'-36.702644', gl_longitud	=	'-71.890314' WHERE	comuna_id	=	228;
UPDATE comuna SET  gl_latitud	=	'-36.527862', gl_longitud	=	'-72.428440' WHERE	comuna_id	=	229;
UPDATE comuna SET  gl_latitud	=	'-37.6875544', gl_longitud	=	'-71.99866259999999' WHERE	comuna_id	=	230;
UPDATE comuna SET  gl_latitud	=	'-37.4741645', gl_longitud	=	'-71.98362050000003' WHERE	comuna_id	=	231;
UPDATE comuna SET  gl_latitud	=	'-32.8803027', gl_longitud	=	'-71.2497156' WHERE	comuna_id	=	232;
UPDATE comuna SET  gl_latitud	=	'-36.283567', gl_longitud	=	'-72.533452' WHERE	comuna_id	=	233;
UPDATE comuna SET  gl_latitud	=	'-36.652153', gl_longitud	=	'-72.596793' WHERE	comuna_id	=	234;
UPDATE comuna SET  gl_latitud	=	'-36.426846', gl_longitud	=	'-71.968393' WHERE	comuna_id	=	235;
UPDATE comuna SET  gl_latitud	=	'-36.550252', gl_longitud	=	'-71.550019' WHERE	comuna_id	=	236;
UPDATE comuna SET  gl_latitud	=	'-36.799561', gl_longitud	=	'-72.031074' WHERE	comuna_id	=	238;
UPDATE comuna SET  gl_latitud	=	'-36.500624', gl_longitud	=	'-72.216555' WHERE	comuna_id	=	239;
UPDATE comuna SET  gl_latitud	=	'-36.83053539999999', gl_longitud	=	'-73.11673680000001' WHERE	comuna_id	=	240;
UPDATE comuna SET  gl_latitud	=	'-37.2620301', gl_longitud	=	'-72.72311189999999' WHERE	comuna_id	=	241;
UPDATE comuna SET  gl_latitud	=	'-37.66670000000001', gl_longitud	=	'-72.01670000000001' WHERE	comuna_id	=	242;
UPDATE comuna SET  gl_latitud	=	'-37.1749687', gl_longitud	=	'-72.9457031' WHERE	comuna_id	=	243;
UPDATE comuna SET  gl_latitud	=	'-36.7247834', gl_longitud	=	'-73.11698079999996' WHERE	comuna_id	=	244;
UPDATE comuna SET  gl_latitud	=	'-38.3441867', gl_longitud	=	'-73.4936495' WHERE	comuna_id	=	245;
UPDATE comuna SET  gl_latitud	=	'-36.431550', gl_longitud	=	'-72.663580' WHERE	comuna_id	=	247;
UPDATE comuna SET  gl_latitud	=	'-37.2923048', gl_longitud	=	'-71.9512186' WHERE	comuna_id	=	248;
UPDATE comuna SET  gl_latitud	=	'-37.09637707446593', gl_longitud	=	'-72.5632667724609' WHERE	comuna_id	=	249;
UPDATE comuna SET  gl_latitud	=	'-37.122712', gl_longitud	=	'-72.013281' WHERE	comuna_id	=	250;
UPDATE comuna SET  gl_latitud	=	'-37.797287', gl_longitud	=	'-72.709133' WHERE	comuna_id	=	251;
UPDATE comuna SET  gl_latitud	=	'-38.712489', gl_longitud	=	'-73.165813' WHERE	comuna_id	=	252;
UPDATE comuna SET  gl_latitud	=	'-37.958874', gl_longitud	=	'-72.431871' WHERE	comuna_id	=	253;
UPDATE comuna SET  gl_latitud	=	'-38.931747', gl_longitud	=	'-72.028600' WHERE	comuna_id	=	254;
UPDATE comuna SET  gl_latitud	=	'-38.441029', gl_longitud	=	'-71.889754' WHERE	comuna_id	=	255;
UPDATE comuna SET  gl_latitud	=	'-39.361577', gl_longitud	=	'-71.587481' WHERE	comuna_id	=	256;
UPDATE comuna SET  gl_latitud	=	'-38.062459', gl_longitud	=	'-72.376761' WHERE	comuna_id	=	257;
UPDATE comuna SET  gl_latitud	=	'-38.958144', gl_longitud	=	'-72.627374' WHERE	comuna_id	=	258;
UPDATE comuna SET  gl_latitud	=	'-38.4127801', gl_longitud	=	'-72.7823172' WHERE	comuna_id	=	259;
UPDATE comuna SET  gl_latitud	=	'-39.100955', gl_longitud	=	'-72.676340' WHERE	comuna_id	=	260;
UPDATE comuna SET  gl_latitud	=	'-38.508975', gl_longitud	=	'-72.453507' WHERE	comuna_id	=	261;
UPDATE comuna SET  gl_latitud	=	'-39.368186', gl_longitud	=	'-72.631525' WHERE	comuna_id	=	262;
UPDATE comuna SET  gl_latitud	=	'-38.454545', gl_longitud	=	'-71.369709' WHERE	comuna_id	=	263;
UPDATE comuna SET  gl_latitud	=	'-37.979546', gl_longitud	=	'-72.834310' WHERE	comuna_id	=	264;
UPDATE comuna SET  gl_latitud	=	'-38.712999', gl_longitud	=	'-73.1574428' WHERE	comuna_id	=	265;
UPDATE comuna SET  gl_latitud	=	'-38.852785', gl_longitud	=	'-71.693289' WHERE	comuna_id	=	266;
UPDATE comuna SET  gl_latitud	=	'-38.7434351', gl_longitud	=	'-72.9635725' WHERE	comuna_id	=	267;
UPDATE comuna SET  gl_latitud	=	'-38.7673148', gl_longitud	=	'-72.6109099' WHERE	comuna_id	=	268;
UPDATE comuna SET  gl_latitud	=	'-38.4161051', gl_longitud	=	'-72.3778105' WHERE	comuna_id	=	269;
UPDATE comuna SET  gl_latitud	=	'-38.9799535', gl_longitud	=	'-72.6503328' WHERE	comuna_id	=	270;
UPDATE comuna SET  gl_latitud	=	'-36.975945', gl_longitud	=	'-72.099464' WHERE	comuna_id	=	271;
UPDATE comuna SET  gl_latitud	=	'-41.317058', gl_longitud	=	'-72.983315' WHERE	comuna_id	=	272;
UPDATE comuna SET  gl_latitud	=	'-18.196932', gl_longitud	=	'-69.559871' WHERE	comuna_id	=	273;
UPDATE comuna SET  gl_latitud	=	'-37.673983', gl_longitud	=	'-72.589086' WHERE	comuna_id	=	274;
UPDATE comuna SET  gl_latitud	=	'-38.737271', gl_longitud	=	'-72.590016' WHERE	comuna_id	=	275;
UPDATE comuna SET  gl_latitud	=	'-38.9992981', gl_longitud	=	'-73.0975742' WHERE	comuna_id	=	276;
UPDATE comuna SET  gl_latitud	=	'-39.177372', gl_longitud	=	'-73.168088' WHERE	comuna_id	=	277;
UPDATE comuna SET  gl_latitud	=	'-38.2476676', gl_longitud	=	'-72.6854357' WHERE	comuna_id	=	278;
UPDATE comuna SET  gl_latitud	=	'-38.233790', gl_longitud	=	'-72.349697' WHERE	comuna_id	=	279;
UPDATE comuna SET  gl_latitud	=	'-38.6653034', gl_longitud	=	'-72.2310324' WHERE	comuna_id	=	280;
UPDATE comuna SET  gl_latitud	=	'-39.282723', gl_longitud	=	'-72.230494' WHERE	comuna_id	=	281;
UPDATE comuna SET  gl_latitud	=	'-39.888513', gl_longitud	=	'-73.431551' WHERE	comuna_id	=	282;
UPDATE comuna SET  gl_latitud	=	'-40.125025', gl_longitud	=	'-72.381741' WHERE	comuna_id	=	283;
UPDATE comuna SET  gl_latitud	=	'-40.295234', gl_longitud	=	'-73.079601' WHERE	comuna_id	=	284;
UPDATE comuna SET  gl_latitud	=	'-40.321437', gl_longitud	=	'-72.482457' WHERE	comuna_id	=	285;
UPDATE comuna SET  gl_latitud	=	'-39.451111', gl_longitud	=	'-72.779639' WHERE	comuna_id	=	286;
UPDATE comuna SET  gl_latitud	=	'-39.862813', gl_longitud	=	'-72.818536' WHERE	comuna_id	=	287;
UPDATE comuna SET  gl_latitud	=	'-39.666037', gl_longitud	=	'-72.953093' WHERE	comuna_id	=	288;
UPDATE comuna SET  gl_latitud	=	'-39.540064', gl_longitud	=	'-72.965921' WHERE	comuna_id	=	289;
UPDATE comuna SET  gl_latitud	=	'-39.817599', gl_longitud	=	'-73.242476' WHERE	comuna_id	=	290;
UPDATE comuna SET  gl_latitud	=	'-39.642306', gl_longitud	=	'-72.337384' WHERE	comuna_id	=	291;
UPDATE comuna SET  gl_latitud	=	'-40.070272', gl_longitud	=	'-72.873286' WHERE	comuna_id	=	292;
UPDATE comuna SET  gl_latitud	=	'-40.331187', gl_longitud	=	'-72.948834' WHERE	comuna_id	=	293;
UPDATE comuna SET  gl_latitud	=	'-41.867847', gl_longitud	=	'-73.828347' WHERE	comuna_id	=	294;
UPDATE comuna SET  gl_latitud	=	'-41.772890', gl_longitud	=	'-73.132342' WHERE	comuna_id	=	295;
UPDATE comuna SET  gl_latitud	=	'-42.480377', gl_longitud	=	'-73.762489' WHERE	comuna_id	=	296;
UPDATE comuna SET  gl_latitud	=	'-42.917295', gl_longitud	=	'-72.710749' WHERE	comuna_id	=	297;
UPDATE comuna SET  gl_latitud	=	'-42.6098746', gl_longitud	=	'-73.7584514' WHERE	comuna_id	=	298;
UPDATE comuna SET  gl_latitud	=	'-41.4871444', gl_longitud	=	'-72.3300471' WHERE	comuna_id	=	299;
UPDATE comuna SET  gl_latitud	=	'-42.4405428', gl_longitud	=	'-73.6374494' WHERE	comuna_id	=	300;
UPDATE comuna SET  gl_latitud	=	'-42.378003', gl_longitud	=	'-73.651798' WHERE	comuna_id	=	301;
UPDATE comuna SET  gl_latitud	=	'-41.1470594', gl_longitud	=	'-73.431413' WHERE	comuna_id	=	302;
UPDATE comuna SET  gl_latitud	=	'-41.1134427', gl_longitud	=	'-73.0610424' WHERE	comuna_id	=	303;
UPDATE comuna SET  gl_latitud	=	'-43.1832961', gl_longitud	=	'-71.8688887' WHERE	comuna_id	=	304;
UPDATE comuna SET  gl_latitud	=	'-42.022373', gl_longitud	=	'-72.689454' WHERE	comuna_id	=	305;
UPDATE comuna SET  gl_latitud	=	'-41.2548538', gl_longitud	=	'-73.0157805' WHERE	comuna_id	=	306;
UPDATE comuna SET  gl_latitud	=	'-41.396715', gl_longitud	=	'-73.462989' WHERE	comuna_id	=	307;
UPDATE comuna SET  gl_latitud	=	'-41.6108543', gl_longitud	=	'-73.6059163' WHERE	comuna_id	=	308;
UPDATE comuna SET  gl_latitud	=	'-40.577255', gl_longitud	=	'-73.114884' WHERE	comuna_id	=	309;
UPDATE comuna SET  gl_latitud	=	'-43.616942', gl_longitud	=	'-71.799847' WHERE	comuna_id	=	310;
UPDATE comuna SET  gl_latitud	=	'-41.467782', gl_longitud	=	'-72.940667' WHERE	comuna_id	=	311;
UPDATE comuna SET  gl_latitud	=	'-40.9768332', gl_longitud	=	'-72.8841503' WHERE	comuna_id	=	312;
UPDATE comuna SET  gl_latitud	=	'-41.317058', gl_longitud	=	'-72.983315' WHERE	comuna_id	=	313;
UPDATE comuna SET  gl_latitud	=	'-42.5958828', gl_longitud	=	'-73.6979392' WHERE	comuna_id	=	314;
UPDATE comuna SET  gl_latitud	=	'-40.9072002', gl_longitud	=	'-73.1731541' WHERE	comuna_id	=	315;
UPDATE comuna SET  gl_latitud	=	'-40.70642', gl_longitud	=	'-72.6458488' WHERE	comuna_id	=	316;
UPDATE comuna SET  gl_latitud	=	'-42.6186003', gl_longitud	=	'-73.7822368' WHERE	comuna_id	=	317;
UPDATE comuna SET  gl_latitud	=	'-43.1160902', gl_longitud	=	'-73.6183659' WHERE	comuna_id	=	318;
UPDATE comuna SET  gl_latitud	=	'-42.1427585', gl_longitud	=	'-73.4765069' WHERE	comuna_id	=	319;
UPDATE comuna SET  gl_latitud	=	'-42.5358993', gl_longitud	=	'-73.4295083' WHERE	comuna_id	=	320;
UPDATE comuna SET  gl_latitud	=	'-40.794789', gl_longitud	=	'-73.216377' WHERE	comuna_id	=	321;
UPDATE comuna SET  gl_latitud	=	'-40.488690', gl_longitud	=	'-73.405154' WHERE	comuna_id	=	322;
UPDATE comuna SET  gl_latitud	=	'-40.4124885', gl_longitud	=	'-73.0146813' WHERE	comuna_id	=	323;
UPDATE comuna SET  gl_latitud	=	'-45.407120', gl_longitud	=	'-72.698910' WHERE	comuna_id	=	324;
UPDATE comuna SET  gl_latitud	=	'-46.541087', gl_longitud	=	'-71.725439' WHERE	comuna_id	=	325;
UPDATE comuna SET  gl_latitud	=	'-44.732535', gl_longitud	=	'-72.680989' WHERE	comuna_id	=	326;
UPDATE comuna SET  gl_latitud	=	'-47.253776', gl_longitud	=	'-72.574874' WHERE	comuna_id	=	327;
UPDATE comuna SET  gl_latitud	=	'-45.572513', gl_longitud	=	'-72.068985' WHERE	comuna_id	=	328;
UPDATE comuna SET  gl_latitud	=	'-43.896042', gl_longitud	=	'-73.745841' WHERE	comuna_id	=	329;
UPDATE comuna SET  gl_latitud	=	'-44.239157', gl_longitud	=	'-71.850837' WHERE	comuna_id	=	330;
UPDATE comuna SET  gl_latitud	=	'-48.467232', gl_longitud	=	'-72.559444' WHERE	comuna_id	=	331;
UPDATE comuna SET  gl_latitud	=	'-46.292670', gl_longitud	=	'-71.938678' WHERE	comuna_id	=	332;
UPDATE comuna SET  gl_latitud	=	'-47.801475', gl_longitud	=	'-73.535814' WHERE	comuna_id	=	333;
UPDATE comuna SET  gl_latitud	=	'-52.2522515', gl_longitud	=	'-71.9176342' WHERE	comuna_id	=	334;
UPDATE comuna SET  gl_latitud	=	'-54.9333299', gl_longitud	=	'-67.6188557' WHERE	comuna_id	=	335;
UPDATE comuna SET  gl_latitud	=	'-53.295283', gl_longitud	=	'-70.369668' WHERE	comuna_id	=	336;
UPDATE comuna SET  gl_latitud	=	'-52.774197', gl_longitud	=	'-69.289192' WHERE	comuna_id	=	337;
UPDATE comuna SET  gl_latitud	=	'-41.317058', gl_longitud	=	'-72.983315' WHERE	comuna_id	=	338;
UPDATE comuna SET  gl_latitud	=	'-53.164589', gl_longitud	=	'-70.917853' WHERE	comuna_id	=	339;
UPDATE comuna SET  gl_latitud	=	'-52.601358', gl_longitud	=	'-71.505489' WHERE	comuna_id	=	340;
UPDATE comuna SET  gl_latitud	=	'-52.554785', gl_longitud	=	'-70.406665' WHERE	comuna_id	=	341;
UPDATE comuna SET  gl_latitud	=	'-54.2947188', gl_longitud	=	'-69.1696887' WHERE	comuna_id	=	342;
UPDATE comuna SET  gl_latitud	=	'-51.258423', gl_longitud	=	'-72.344755' WHERE	comuna_id	=	343;
UPDATE comuna SET  gl_latitud	=	'-33.3190376', gl_longitud	=	'-71.40763179999999' WHERE	comuna_id	=	344;
UPDATE comuna SET  gl_latitud	=	'-36.7866757', gl_longitud	=	'-73.10995309999998' WHERE	comuna_id	=	345;
UPDATE comuna SET  gl_latitud	=	'-36.295826', gl_longitud	=	'-71.901895' WHERE	comuna_id	=	348;
UPDATE comuna SET  gl_latitud	=	'-38.600278', gl_longitud	=	'-72.8445786' WHERE	comuna_id	=	349;
UPDATE comuna SET  gl_latitud	=	'-52.554785', gl_longitud	=	'-70.406665'	WHERE	comuna_id	=	237;
UPDATE comuna SET  gl_latitud	=	'-37.8796649', gl_longitud	=	'-71.63878999999997'	WHERE	comuna_id	=	346;
UPDATE comuna SET  gl_latitud	=	'-33.97937429724559', gl_longitud	=	'-70.71193268569334'	WHERE	comuna_id	=	166;

ALTER TABLE `local`
ADD `gl_token` VARCHAR(255) NULL DEFAULT NULL AFTER `fk_farmacia`;

UPDATE local 
SET gl_token = SHA1(CONCAT("local_token_",local.local_id));

ALTER TABLE `local`
ADD `bo_ws` TINYINT(1) NULL DEFAULT '0' AFTER `gl_token`;