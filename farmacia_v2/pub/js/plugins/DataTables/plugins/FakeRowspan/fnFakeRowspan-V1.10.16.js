/**
 * Creates `rowspan` cells in a column when there are two or more cells in a
 * row with the same content, effectively grouping them together visually.
 *
 * **Note** - this plug-in currently only operates correctly with
 * **server-side processing**.
 *
 *  @name fnFakeRowspan
 *  @summary Create a rowspan for cells which share data
 *  @author Fredrik Wendel
 *
 *  @param {interger} iColumn Column index to have row span
 *  @param {boolean} [bCaseSensitive=true] If the data check should be case
 *    sensitive or not.
 *  @returns {jQuery} jQuery instance
 *
 *  @example
 *    $('#example').dataTable().fnFakeRowspan(3);
 */

jQuery.fn.dataTableExt.oApi.fnFakeRowspan = function ( oSettings, iColumn, bCaseSensitive ) {
    //debugger;
    /* Fail silently on missing/errorenous parameter data. */
    if (isNaN(iColumn)) {
        return false;
    }

    if (iColumn < 0 || iColumn > oSettings.aoColumns.length-1) {
        alert ('Invalid column number choosen, must be between 0 and ' + (oSettings.aoColumns.length-1));
        return false;
    }

    bCaseSensitive = (typeof(bCaseSensitive) != 'boolean' ? true : bCaseSensitive);

    function fakeRowspan () {
        //debugger;
        var firstOccurance = null,
            value = null,
            rowspan = 0;
        jQuery.each(oSettings.aoData, function (i, oData) {
            var cellPosition = getCellOfColumn(iColumn);
            var data = oData._aData;
            var res = jQuery.isArray(data);
            if(res){
                var val = oData._aData[iColumn];
                //console.log(oData.nTr.childNodes);
                //console.log(oData.nTr.childNodes[cellPosition]);
                cell = oData.nTr.childNodes[cellPosition];
            }
            else{
                var keys = Object.keys( oData._aData );
                var val = oData._aData[keys[iColumn]],
                cell = oData.nTr.childNodes[cellPosition];
            }
            
            /* Use lowercase comparison if not case-sensitive. */
            if (!bCaseSensitive) {
                val = val.toLowerCase();
            }
            /* Reset values on new cell data. */
            if (val != value) {
                value = val;
                firstOccurance = cell;
                rowspan = 0;
            }

            if (val == value) {
                rowspan++;
            }

            if (firstOccurance !== null && firstOccurance !== undefined && val == value && rowspan > 1) {
                //oData.nTr.removeChild(cell);
                $(oData.nTr.childNodes[cellPosition]).hide(); // hide rows
                firstOccurance.rowSpan = rowspan;
            }
        });
    }

    function getCellOfColumn(iColumn){
        var cellPosition = 0;
        if(iColumn == 0){
            cellPosition = 1;
        }
        else if(iColumn > 0){
            cellPosition = (iColumn*2)+1;
        }

        return cellPosition;
    }

    oSettings.aoDrawCallback.push({ "fn": fakeRowspan, "sName": "fnFakeRowspan" });

    return this;
};

/*
* https://cdn.datatables.net/plug-ins/1.10.16/api/fnFakeRowspan.js
* */