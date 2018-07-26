import { Component } from '@angular/core';
import {FormControl} from '@angular/forms';
import { Angular5Csv } from 'angular5-csv/Angular5-csv';
import 'hammerjs';
declare var jquery:any;
declare var $ :any;
declare var M:any;
declare var vis: any;
declare var document:any;

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'app';
  toppings = new FormControl();
  public operaciones;

  public nombre:string = "";
  public tiempo:any = "";
  public predecesores:string[] = [];

  private grafoEditable: boolean = true;
  private seleccionado:number;


  public opciones:string[];

  public nodos  = [];
  public arcos = [];
  
  //Variable que define si es viable exportar a excel o no
  public exportable: boolean = false;
  public editable:boolean = false;

  constructor() {
  }

  ngOnInit(){
    //called after the constructor and called  after the first ngOnChanges() 
    M.AutoInit();
    $(function () {
      $('select').multipleSelect();
    });
    let temp = JSON.parse(localStorage.getItem('guardadas'));
    this.operaciones = temp != null ? temp : [];
    temp = JSON.parse(localStorage.getItem('opciones'));
    this.opciones = temp != null ? temp : ["-"];
    //temp = JSON.parse(localStorage.getItem('nodos'));
    //this.nodos = temp != null ? temp : [];
    //this.generarGrafo();
 }


 public actualizarOperacion():void {

  if(this.validarInserción()){

    if(this.validarRepetidoEdit(this.nombre)){
      alert("No pueden existir operaciones con nombres repetidos");
      return;
    }

    if(this.validarInicio()){
      alert("Un nodo inicial solo puede tener como predecesor a '-' ");
      return;
    }

    if(this.validarCiclo(this.nombre)){
      alert("Una operación no puede ser predecesora de ella misma");
      return;
    }

    this.operaciones[this.seleccionado].nombre = this.nombre;
    this.operaciones[this.seleccionado].tiempo = this.tiempo;
    this.operaciones[this.seleccionado].predecesores = this.predecesores;
    
    
    this.limpiarOperaciones();

    this.nombre = "";
    this.tiempo = "";
    this.predecesores = [];
    this.editable = false;
    this.seleccionado = -1;
    this.grafoEditable = true;
    this.exportable = false;
    localStorage.setItem('guardadas', JSON.stringify(this.operaciones));
    localStorage.setItem('opciones', JSON.stringify(this.opciones));
  }

  else {
    alert("Por favor ingrese todos los campos");
  }
}

  public anadirOperacion():void {
    if(this.validarInserción()){

      if(this.validarRepetido(this.nombre)){
        alert("No pueden existir operaciones con nombres repetidos");
        return;
      }

      if(this.validarCiclo(this.nombre)){
        alert("Una operación no puede ser predecesora de ella misma");
        return;
      }

      if(this.validarInicio()){
        alert("Un nodo inicial solo puede tener como predecesor a '-' ");
        return;
      }

      this.operaciones.push({
        nombre: this.nombre,
        tiempo: this.tiempo,
        predecesores: this.predecesores,
        lf : 0
      });
      this.opciones.push(this.nombre);  
      
      this.limpiarOperaciones();

      this.nombre = "";
      this.tiempo = "";
      this.predecesores = [];
      this.grafoEditable = true;
      this.exportable = false;
      localStorage.setItem('guardadas', JSON.stringify(this.operaciones));
      localStorage.setItem('opciones', JSON.stringify(this.opciones));
      //location.reload();
    } else {
      alert("Por favor ingrese todos los campos");
    }
    
  }

  private validarInicio():boolean{
    return (this.predecesores.includes("-") && this.predecesores.length > 1);
  }

  private limpiarOperaciones():void{
    for(let i = 0; i < this.operaciones.length; i++){
      this.operaciones[i].es = "";
      this.operaciones[i].lf = 0;
      this.operaciones[i].ls = "";
      this.operaciones[i].ef = "";
      this.operaciones[i].holgura = "";
      this.operaciones[i].critico = "";
    }
  }

  public seleccionarEliminar(indice:number):void {
    this.seleccionado = indice;
    console.log("esta seleccionando el eliminado");
  }

  private validarCiclo(n:string){
    for(let i = 0; i < this.predecesores.length; i++){
      if(n == this.predecesores[i]){
        return true;
      }
    }

    return false;
  }

  private validarRepetido(n:string):boolean{
    for(let i = 0; i < this.operaciones.length; i++){
      if(n == this.operaciones[i].nombre){
        return true;
      }
    }
    return false;
  }

  private validarRepetidoEdit(n:string):boolean{
    for(let i = 0; i < this.operaciones.length; i++){
      if(n == this.operaciones[i].nombre && i != this.seleccionado){
        return true;
      }
    }
    return false;
  }

  private validarInserción():boolean{
    let rta = true;
    if(this.validarCampo(this.nombre) || this.validarCampo(this.tiempo) || this.predecesores.length == 0){
      rta = false;
    }
    return rta;
  }

  private validarCampo(campo:any):boolean{
    return (campo == null || campo == "" || campo == undefined);
  }

  public eliminar():void {
    let indice = this.seleccionado;
    let name:string = this.operaciones[indice].nombre;
    this.operaciones.splice(indice);
    let index:number = this.opciones.indexOf(name);
    this.opciones.splice(index);
    this.limpiarOperaciones();
    this.grafoEditable = true;
    this.exportable = false;
    localStorage.setItem('guardadas', JSON.stringify(this.operaciones));
    localStorage.setItem('opciones', JSON.stringify(this.opciones));
    //location.reload();
  }

  private calcularEarlyStart(i:number):number{
      let pred = this.operaciones[i].predecesores;
      let rta = 0;
      if(pred[0] == "-"){
        rta = 0;
      } else {
        
        if(pred.length > 1){
           let  max:number = 0;
           for(let j = 0; j < pred.length; j++){
              let temp = this.darEarlyFinish(pred[j]);
                if (temp > max){
                  max = temp;
                }              
            }
           rta =  max;
        } else {
          rta = this.darEarlyFinish(pred[0]);
        }
      }

      return rta;
  }



  private darEarlyFinish(nombre:string):number {
    let rta:number = 0;
    for(let x = 0; x < this.operaciones.length; x++){
      if(this.operaciones[x].nombre == nombre){
        rta = this.operaciones[x].ef;
      }
    }
    return rta;
  }

  private calcularEarlyFinish(indice:number):number{
    console.log(this.operaciones[indice]);
    return  parseInt(this.operaciones[indice].es,10) + parseInt(this.operaciones[indice].tiempo,10);
  }

  private calcularLateStart(indice:number){
    return parseInt(this.operaciones[indice].lf, 10) - parseInt(this.operaciones[indice].tiempo,10);
  }

  private calcularLateFinish(lateStart, indice, arreglo){
    console.log(lateStart, indice, arreglo);

    if(this.operaciones[indice].lf == 0){
      this.operaciones[indice].lf = lateStart;
      this.operaciones[indice].ls = this.calcularLateStart(indice);
    } else {
      if(this.operaciones[indice].lf > lateStart){
        this.operaciones[indice].lf = lateStart;
        this.operaciones[indice].ls = this.calcularLateStart(indice);
      }
    }

    let pred = this.operaciones[indice].predecesores;

    //console.log("esta llegando hasta pred:", pred);

    
    for(let i = 0; i < pred.length; i++){
      if(pred[i] != "-"){
        arreglo.push( {
          predecesor: pred[i],
          lateStart: this.operaciones[indice].ls
        });
      }
      
    }

    
    console.log(arreglo[0]);

    arreglo.shift();

    console.log(arreglo[0]);
  }

  private esPredecesor(param):boolean{
    for(let i = 0; i<this.operaciones.length; i ++){
      let temp = this.operaciones[i].predecesores;
      for(let j = 0; j < temp.length; j++){
        if(temp[j] == param){
          return true;
        }
      }
    }
    return false;
  }

  private darFinales(){
    let respuesta = [];
    for(let i = 0; i < this.operaciones.length; i++){
      if(!this.esPredecesor(this.operaciones[i].nombre)){
        respuesta.push(i);
      }
    }
    return respuesta;
  }

  private calcularHolgura(indice):number{
    return parseInt(this.operaciones[indice].lf,10) -  parseInt(this.operaciones[indice].ef,10);
  }

  public calcular():void {

    if(!this.existeInicial()){
      alert("Debe existir al menos un nodo inicial para poder calcular el camino crítico");
      return;
    }

    for(let i = 0; i < this.operaciones.length; i++){
      this.operaciones[i].es = this.calcularEarlyStart(i);
      this.operaciones[i].ef = this.calcularEarlyFinish(i);
    }

    let finales = this.darFinales();

    let arreglo = [];

    for(let i = 0; i < finales.length; i++){
      let indice = finales[i];
      this.operaciones[indice].lf = this.operaciones[indice].ef;
      this.operaciones[indice].ls = this.calcularLateStart(indice);

      let pred = this.operaciones[indice].predecesores;
      console.log("estos son los predecesores del final", pred);
      for(let j = 0; j < pred.length; j++){
        arreglo.push( {
          predecesor: pred[j],
          lateStart: this.operaciones[indice].ls
        });
      }

    }

    while(arreglo.length != 0){
      let temp = arreglo[0];

      console.log("esta es la variable temp", temp);
      
      let ls = temp.lateStart;
      let name = temp.predecesor;
      

      let indice = 0;

      for(let x = 0; x <this.operaciones.length; x++){
        if(this.operaciones[x].nombre == name){
          indice = x;
          break;
        }
      }

      this.calcularLateFinish(ls, indice, arreglo);
    }

    for(let i = 0; i < this.operaciones.length; i++){
      this.operaciones[i].holgura = this.calcularHolgura(i);
    }

    this.caminoCritico();
    this.exportable = true;
  }


  tabSelectionChanged(event){
    // Get the selected tab
    let selectedTab = event.tab;
    console.log(selectedTab);
    // Call some method that you want 
    this.calcularGrafo();
  }

  public calcularGrafo(){
    console.log("estamos calculando el grafo beiby");

    this.nodos = [];
    this.arcos = [];

    for(let i = 0; i < this.operaciones.length; i++){
      console.log(this.operaciones[i]);
      //let grupo = this.operaciones[i].predecesores.includes("-") ? "inicial" : "restante";
      this.nodos.push({
        id: i,
        label: this.operaciones[i].nombre
      });

      let tempPredecesores = this.operaciones[i].predecesores;
      for(let j = 0; j < tempPredecesores.length; j++){
        for(let x = 0; x < this.operaciones.length; x++){
          if(this.operaciones[x].nombre == tempPredecesores[j]){
            this.arcos.push({
              from: x,
              to: i
            })
          }
        }
      }
    }

    this.generarGrafo();
    console.log(this.nodos);
  }

  private existeInicial():boolean {
    let rta = false;
    for(let i = 0; i < this.operaciones.length; i++){
      let actual = this.operaciones[i];
      if(actual.predecesores.includes("-")){
        rta = true;
        break;
      }
    }
    return rta;
  }

  private caminoCritico(){
    for(let i = 0; i < this.operaciones.length; i++){
      this.operaciones[i].critico = this.operaciones[i].holgura == 0 ? "y" : "n";
    }
  }

  public generarGrafo(){

    if(!this.grafoEditable){
      return;
    }

    var nodes = new vis.DataSet(this.nodos);
  // create an array with edges
  var edges = new vis.DataSet(this.arcos);
  // create a network
  var container = document.getElementById('mynetwork');
  // provide the data in the vis format
  var data = {
      nodes: nodes,
      edges: edges
  };

  var options = {
    nodes: {fixed:false},
    edges: {
      arrows:'to',
      smooth: true
    }
  };
  //var options = {};
  // initialize your network!
  var network = new vis.Network(container, data, options);

  this.grafoEditable = false;
 }

 public generarReporte(){
  let reporte = []; 
  for(let i = 0; i < this.operaciones.length; i++){
    let temp = {
      Operacion: this.operaciones[i].nombre,
      Tiempo: this.operaciones[i].tiempo,
      Predecesores : this.operaciones[i].predecesores,
      Early_Start: this.operaciones[i].es,
      Early_Finish: this.operaciones[i].ef,
      Late_Start: this.operaciones[i].ls,
      Late_Finish: this.operaciones[i].lf,
      Holgura: this.operaciones[i].holgura
    }
    reporte.push(temp);
   }

   let options = { 
    fieldSeparator: ';',
    quoteStrings: '"',
    decimalseparator: '.',
    showLabels: true, 
    showTitle: true,
    useBom: true,
    noDownload: false,
    headers: ["Operacion", "Tiempo", "Predecesores", "Early Start", "Early Finish", "Late Start", "Late Finish", "Holgura"]
  };

   console.log("esta es la info del reporte");
   console.log(reporte);
   new Angular5Csv(reporte, 'CPM', options);
 }


  

 public editar(indice:number){
    if(indice == -1){
      this.editable = false;
      this.nombre = "";
      this.tiempo = "";
      this.predecesores = [];
      return;
    }

   this.seleccionado = indice;
   let seleccionado = this.operaciones[indice];
   this.nombre = seleccionado.nombre;
   this.tiempo = seleccionado.tiempo;
   this.predecesores = seleccionado.predecesores;
   this.editable = true;
 }


}