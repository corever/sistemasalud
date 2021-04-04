-- --------------------------------------------------------
-- Incorporacion de nuevos campos en tabla SEREMI 
-- --------------------------------------------------------

ALTER TABLE `seremi` 
ADD COLUMN `id_decreto_delegado` int(11);

ALTER TABLE `seremi` 
ADD COLUMN `fc_decreto_delegado` date;

ALTER TABLE `seremi` 
ADD COLUMN `id_territorio` int(11);

