var tabla = document.querySelector("#tabla");
		 
var dataTable = new DataTable(tabla,{
	perPage:32,
	perPageSelect:[32, 50, 75, 100, 125, 150, 175, 200, 225, 250, 275, 300, 350, 400, 450, 500],
	labels: {
	placeholder: "Buscar...",
	perPage: "{select} resultados por página",
	noRows: "Sin resultados",
	info: "Mostrando {start} a {end} de {rows} registros",
	
}
});
