<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head>
	<style>
        .header-table {
            background-color: #508188;
            margin: 2%;
            width: 96%;
            color: #ffffff;
        }

        .header-table th, td {
            text-align: left;
            padding: 5px;
        }

        .title {
            padding: 5px 20px;
            font-size: 20px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .title h1, h3 {
            margin-left: 10px;
        }

        .title h3 {
            margin-top: 20px;
        }

        .subheader-table {
            margin: 2%;
            width: 96%;
        }           
        .subheader-table td {
            vertical-align: top;
        }
        .subheader-table dt {
            font-size: 11px;
            color: #999;
            margin-bottom: 5px;
        }
        .subheader-table dd {
            margin: 0;
        }
        .subheader-table td:last-child {
            text-align: right;
        }
        .subheader-table dd {
            font-size: 28px;
            font-weight: bold;
        }

        .detail-table {
            margin          : 2%;
            width           : 96%;
            border-top      : 2px solid #CCC;
            border-bottom   : 2px solid #CCC;
        }
        .detail-table tr:nth-child(even){
            background-color: #f2f2f2;
        }
        .detail-table th, td {
            padding: 5px;
        }
        .detail-table th {
            border-bottom: 2px solid #CCC;
        }
        .detail-table td:nth-child(2), td:nth-child(4) {
            text-align: right;
        }
        .detail-table td:nth-child(3) {
            text-align: center;
        }

        .footer-table {
            margin  : 2%;
            width   : 96%;
        }
        .footer-table td {
            padding     : 5px;
            text-align  : right;
            font-weight : bold;
        }
        
        ion-footer button {
            margin: 0 !important;
        }

	</style>
        <?php echo $html ?>
</html>