
var MantenedorEmt = Class({

	loadGrid : function(){
		setTimeout(this.bindMapa,1000);
	},

    bindMapa : function(){        
		var mapa = new MapaFormulario("map");
		mapa.seteaIcono("static/images/markers/mordedor.png");
		mapa.seteaZoom(17);
		mapa.inicio();
		mapa.cargaMapa();
		mapa.setMarkerInputs();
    }
});

$(document).ready(function() {
    var listado = new MantenedorEmt();
	listado.loadGrid();
});
