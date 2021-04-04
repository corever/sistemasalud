<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

<link href='{$static}template/plugins/fullcalendar/fullcalendar.min.css' rel='stylesheet' />
<link href='{$static}template/plugins/fullcalendar/fullcalendar.print.min.css' rel='stylesheet' media='print' />

<section class="content-header">
    <h1><i class="fa fa-calendar"></i> <span>{$origen}</span></h1>
</section>

<section class="content">
    <div class="row">
	
		<div class="top-spaced"></div>
		<div class="panel panel-primary">
			<div class="panel-heading">
				Calendario
			</div>
			
			<div class="top-spaced"></div>
			
			<div class="panel-body">
                <input type="text" value="{$arrAgendaExamenes}" id="arrAgendaExamenes" name="arrAgendaExamenes" class="hidden">
				<div id='calendarPacientes'></div>
			</div>

			<div class="top-spaced"></div>
			
		</div>
    </div>
    
</section>
</body>