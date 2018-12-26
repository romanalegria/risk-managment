<template>
    <main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item"><a href="#">Admin</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Empresa Contratista
                <button type="button" @click="abrirModal('contratista','registrar')" class="btn btn-secondary">
                    <i class="icon-plus"></i>&nbsp;Nuevo
                </button>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <select class="form-control col-md-3" v-model="criterio">
                              <option value="S017EmCRut">Rut</option>
                              <option value="S017EmCNom">Razón Social</option>
                            </select>
                            <input type="text" v-model="buscar" @keyup.enter="listarContratista(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                            <button type="submit" @click="listarContratista(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>Rut</th>
                            <th>Nombre</th>
                            <th>Razón Social</th>
                            <th>Vigencia</th>
                            

                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="contratista in arrayContratista" :key="contratista.EmCCod">
                            <td>
                                <button type="button" @click="abrirModal('contratista','actualizar',contratista)" class="btn btn-warning btn-sm">
                                  <i class="icon-pencil"></i>
                                </button> &nbsp;                               
                            </td>
                            <td v-text="contratista.EmCRut"></td>
                            <td v-text="contratista.EmCNom"></td>
                            <td v-text="contratista.EmCRso"></td>
                            <td>
                                <div v-if="contratista.EmPVig">
                                    <span class="badge badge-success">Vigente</span>
                                </div>
                                <div v-else>
                                    <span class="badge badge-danger">No Vigente</span>
                                </div>                                 
                            </td>                                                       
                        </tr>                     
                       
                    </tbody>
                </table>
                <nav>
                    <ul class="pagination">
                        <li class="page-item" v-if="pagination.current_page > 0">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                        </li>
                        <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActive ? 'active' : '']">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                        </li>                       
                        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- Fin ejemplo de tabla Listado -->
    </div>
    <!--Inicio del modal agregar/actualizar-->
    <div class="modal fade" :class="{'mostrar' : modal}"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-primary modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-text="tituloModal"></h4>
                    <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Rut</label>
                            <div class="col-md-6">
                                <input type="text" id="EmCRut" v-model="EmCRut" class="form-control" placeholder="Rut de la empresa contratista">                               
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                            <div class="col-md-9">
                                <input type="text" id="EmCNom" v-model="EmCNom" class="form-control" placeholder="Nombre de la empresa contratista">                               
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="email-input">Razón Social</label>
                            <div class="col-md-9">
                                <input type="text" id="EmCRso" v-model="EmCRso" class="form-control" placeholder="Razón social de la empresa contratista">
                            </div>
                        </div>
                        <div class="form-group row">                           
                                <label class="col-md-3 form-control-label" for="email-input">Vigencia</label>
                                <div class="col-md-9">
                                    <select class="form-control" id="EmPVig" name="EmPVig" v-model="EmPVig">
                                      <option value="1">Vigente</option>
                                      <option value="0">No Vigente</option>
                                    </select>                                    
                                </div>
                           
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="email-input">Numero adherente a mutualidad</label>
                            <div class="col-md-9">
                                <input type="number" v-model="EmCNam" class="form-control" placeholder="Numero adherente mutialidad">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="email-input">Mutualidad empresa</label>
                            <div class="col-md-9">
                                <input type="text" v-model="EmCCmu" class="form-control" placeholder="Codigo mutualidad">
                            </div>
                        </div>
                        <div class="form-group row">                           
                                <label class="col-md-3 form-control-label" for="email-input">Perido cierre requisitos</label>
                                <div class="col-md-9">
                                    <select class="form-control" id="EmCTpr" name="EmPVig" v-model="EmCTpr">
                                      <option value="1">Diario</option>
                                      <option value="2">Mensual</option>
                                    </select>                                    
                                </div>
                           
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="email-input">Dia del mes cierre (si es mensual)</label>
                            <div class="col-md-9">
                                <input type="number" v-model="EmCFcr" class="form-control" placeholder="Numero de dia de cierre">
                            </div>
                        </div>  
                        <div class="form-group row">                           
                                <label class="col-md-3 form-control-label" for="email-input">Periodo cierre actividades</label>
                                <div class="col-md-9">
                                    <select class="form-control" id="EmCTpa" name="EmPVig" v-model="EmCTpa">
                                      <option value="1">Diario</option>
                                      <option value="2">Mensual</option>
                                    </select>                                    
                                </div>
                           
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="email-input">Dia del mes cierre activad (si es mensual)</label>
                            <div class="col-md-9">
                                <input type="number" v-model="EmCFca" class="form-control" placeholder="Numero de dia de cierre actividades">
                            </div>
                        </div>  

                        <div v-show="errorContratista" class="form-group row div-error">
                            <div class="text-center text-error">
                                <div v-for="error in errorMostrarMsjContratista" :key="error" v-text="error">
                                    
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarContratista()">Guardar</button>
                    <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarContratista()">Actualizar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->
   
</main>
</template>

<script>
    export default {
        data (){
            return {  
                contratista_id : 0,              
                EmCCod : '',
                EmPCod : '',
                EmCRut : '',
                EmCNom : '',
                EmCRso : '',
                EmPVig : '',
                EmCTip : '',
                EmCNam : '',
                EmCCmu : '',
                EmCTpr : '',
                EmCFcr : '',
                EmCTpa : '',
                EmCFca : '',
                EmCFca : '',
                EmCCmu : '',                
                tituloModal : '',
                tipoAccion : 0,
                arrayContratista : [],
                modal : 0,
                errorContratista : 0,
                errorMostrarMsjEmpresa : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,

                },
                offset : 3,
                criterio : 'EmCNom',
                buscar : ''
                
            }
            
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            pagesNumber: function(){
                if(!this.pagination.to){
                    return []
                }

                var from = this.pagination.current_page - this.offset;
                if (from < 1){
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if (to >= this.pagination.last_page)
                {
                    to = this.pagination.last_page;
                }

                var pagesArrray = [];
                while (from <= to) {
                    pagesArrray.push(from)
                    from++;
                }
                return pagesArrray;
            } 
        },
        methods :  {
            listarContratista(page,buscar,criterio){
                let me = this;
                var url = '/contratista?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;            
                axios.get(url).then(function (response) {
                   var respuesta = response.data;
                   me.arrayContratista = respuesta.contratista.data ;
                   me.pagination = respuesta.pagination;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });

            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                me.pagination.current_page = page;
                me.listarContratista(page,buscar,criterio);
            },
            registrarContratista(){

                if(this.validarContratista())
                {
                    return;
                }

                let me = this;
                axios.post('/contratista/registrar',{
                       'EmCCod' : this.EmCCod,
                       'EmPCod' : this.EmPCod,
                       'EmCRut' : this.EmCRut,
                       'EmCNom' : this.EmCNom,
                       'EmCRso' : this.EmCRso,
                       'EmPVig' : this.EmPVig,
                       'EmCTip' : this.EmCTip,
                       'EmCNam' : this.EmCNam,
                       'EmCCmu' : this.EmCCmu,
                       'EmCTpr' : this.EmCTpr,
                       'EmCFcr' : this.EmCFcr,
                       'EmCTpa' : this.EmCTpa,
                       'EmCFca' : this.EmCFca,
                       'EmCFca' : this.EmCFca,
                       'EmCCmu' : this.EmCCmu
                    
                    
                }).then(function (response) {
                  me.cerrarModal();
                  me.listarContratista(1,'','EmCNom');
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            actualizarContratista() {

                //if(this.validarPerfil())
                //{
                 //   return;
                //}

                let me = this;               
                axios.put('/contratista/actualizar/'+ me.contratista_id,{                    
                    'EmCCod' : this.EmCCod,
                    'EmPCod' : this.EmPCod,
                    'EmCRut' : this.EmCRut,
                    'EmCNom' : this.EmCNom,
                    'EmCRso' : this.EmCRso,
                    'EmPVig' : this.EmPVig,
                    'EmCTip' : this.EmCTip,
                    'EmCNam' : this.EmCNam,
                    'EmCCmu' : this.EmCCmu,
                    'EmCTpr' : this.EmCTpr,
                    'EmCFcr' : this.EmCFcr,
                    'EmCTpa' : this.EmCTpa,
                    'EmCFca' : this.EmCFca,
                    'EmCFca' : this.EmCFca,
                    'EmCCmu' : this.EmCCmu
                    
                }).then(function (response) {                  
                  me.cerrarModal();
                  me.listarcontratista(1,'','EmCNom');
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            desactivarContratista(id){
                  const swalWithBootstrapButtons = swal.mixin({
                  confirmButtonClass: 'btn btn-success',
                  cancelButtonClass: 'btn btn-danger',
                  buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                  title: 'Esta seguro de desactivar este contratista?',                  
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {

                     let me = this;
                    axios.put('/contratista/desactivar/'+ id,{                   
                        //'PerCod' : id
                    }).then(function (response) {                     
                      me.listarContratista(1,'','EmCNom');
                      swalWithBootstrapButtons(
                      'Desactivado!',
                      'La empresa ha sido desactivada.',
                      'success'

                    )
                    })                   
                    .catch(function (error) {
                        // handle error
                        
                    });
                    
                  } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                  ) {
                    
                  }
                })
            },
              activarContratista(id){
                  const swalWithBootstrapButtons = swal.mixin({
                  confirmButtonClass: 'btn btn-success',
                  cancelButtonClass: 'btn btn-danger',
                  buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                  title: 'Esta seguro de activar la empresa?',                  
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {

                     let me = this;
                    axios.put('/contratista/activar/'+ id,{                   
                        //'PerCon' : 1                
                    }).then(function (response) {                     
                      me.listarEmpresa(1,'','EmCNom');
                      swalWithBootstrapButtons(
                      'Activado!',
                      'La empresa ha sido activada.',
                      'success'
                    )
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(id);
                    });
                    
                  } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                  ) {
                    
                  }
                })
            },
            validarContratista(){
                this.validarContratista = 0;
                this.errorMostrarMsjContratista = [];

                if(!this.EmCRut) this.errorMostrarMsjContratista.push("El rut de la empresa no puede ser vacio");
                if(!this.EmCNom) this.errorMostrarMsjContratista.push("El nombre de la empresa no puede ser vacio");
                if(!this.EmCRso) this.errorMostrarMsjContratista.push("La razón social de la empresa no puedo ser vacio");
                
                if(this.errorMostrarMsjContratista.length) this.errorContratista = 1;

                return this.errorContratista;
            },
            cerrarModal (){
                this.modal=0;
                this.tituloModal='';
                this.EmCCod = '',
                this.EmPCod = '',
                this.EmCRut = '',
                this.EmCNom = '',
                this.EmCRso = '',
                this.EmPVig = '',
                this.EmCTip = '',
                this.EmCNam = '',
                this.EmCCmu = '',
                this.EmCTpr = '',
                this.EmCFcr = '',
                this.EmCTpa = '',
                this.EmCFca = '',               
                this.EmCCmu = ''
            },
            abrirModal (modelo, accion, data = []){
                switch(modelo){
                    case 'contratista':
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Empresa Contratista';
                                this.EmCCod = '',
                                this.EmPCod = '',
                                this.EmCRut = '',
                                this.EmCNom = '',
                                this.EmCRso = '',
                                this.EmPVig = '',
                                this.EmCTip = '',
                                this.EmCNam = '',
                                this.EmCCmu = '',
                                this.EmCTpr = '',
                                this.EmCFcr = '',
                                this.EmCTpa = '',
                                this.EmCFca = '',                              
                                this.EmCCmu = '',
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal = 1;
                                this.tituloModal = "Actualizar Empresa Contratista";                               
                                this.contratista_id = data['EmCCod'];
                                this.EmCCod = data['EmCCod'];
                                this.EmPCod = data['EmPCod'];
                                this.EmCRut = data['EmCRut'];
                                this.EmCNom = data['EmCNom'];
                                this.EmCRso = data['EmCRso'];
                                this.EmPVig = data['EmPVig'];
                                this.EmCTip = data['EmCTip'];
                                this.EmCNam = data['EmCNam'];
                                this.EmCCmu = data['EmCCmu'];
                                this.EmCTpr = data['EmCTpr'];
                                this.EmCFcr = data['EmCFcr'];
                                this.EmCTpa = data['EmCTpa'];
                                this.EmCFca = data['EmCFca'];
                                this.EmCCmu = data['EmCCmu'];                
                                this.tipoAccion = 2;
                                break;
                            }
                        }
                    }
                }
            }
        },
        mounted() {
            this.listarContratista(1,this.buscar,this.criterio);
        }
    }
</script>
<style>
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>