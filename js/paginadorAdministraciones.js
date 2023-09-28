var tabla = document.querySelector("#tabla");
		 
var dataTable = new DataTable(tabla,{
	perPage:10,
	perPageSelect:[5,10,15,20,25,30,50],
	labels: {
	placeholder: "Buscar...",
	perPage: "{select} resultados por página",
	noRows: "Sin resultados",
	info: "Mostrando {start} a {end} de {rows} registros",
	
}
});