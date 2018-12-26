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
                <i class="fa fa-align-justify"></i> Módulo
                <button type="button" @click="abrirModal('modulo','registrar')" class="btn btn-secondary">
                    <i class="icon-plus"></i>&nbsp;Nuevo
                </button>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <select class="form-control col-md-3" v-model="criterio">
                              <option value="S02ModDes">Nombre</option>
                              <option value="S02ModDes">Descripción</option>
                            </select>
                            <input type="text" v-model="buscar" @keyup.enter="listarModulo(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                            <button type="submit" @click="listarModulo(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Opciones</th>                            
                            <th>Descripción</th>
                            <th>Tipo empresa</th>
                            <th>Vigencia</th>        
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="modulo in arrayModulo" :key="modulo.ModCod">
                            <td>
                                <button type="button" @click="abrirModal('modulo','actualizar',modulo)" class="btn btn-warning btn-sm">
                                  <i class="icon-pencil"></i>
                                </button> &nbsp;                                
                            </td>
                            <td v-text="modulo.ModDes"></td>                            
                            <td>
                                <template v-if="modulo.ModTem === 1">
                                    <span class="badge badge-success">Principal</span>
                                </template>
                                <template v-else>
                                    <span class="badge badge-success">Contratista/SubContratista</span>
                                </template>                                 
                            </td>
                            <td>
                                <div v-if="modulo.ModVig">
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
                        <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
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
                            <label class="col-md-3 form-control-label" for="text-input">Descripción</label>
                            <div class="col-md-9">
                                <input type="text"  v-model="ModDes" class="form-control" placeholder="Descripción del módulo">                               
                            </div>
                        </div>
                       
                        <div class="form-group row">                           
                                <label class="col-md-3 form-control-label" for="email-input">Tipo empresa</label>
                                <div class="col-md-9">
                                    <select class="form-control"  v-model="ModTem">
                                      <option value="1">Principal</option>
                                      <option value="2">Contratista/SubContratista</option>
                                    </select>                                    
                                </div>
                           
                        </div>
                        <div class="form-group row">                           
                                <label class="col-md-3 form-control-label" for="email-input">Vigencia</label>
                                <div class="col-md-9">
                                    <select class="form-control"  v-model="ModVig">
                                      <option value="1">Vigente</option>
                                      <option value="0">No Vigente</option>
                                    </select>                                    
                                </div>
                           
                        </div>
                        
                        <div v-show="errorModulo" class="form-group row div-error">
                            <div class="text-center text-error">
                                <div v-for="error in errorMostrarMsjModulo" :key="error" v-text="error">
                                    
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarModulo()">Guardar</button>
                    <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarModulo()">Actualizar</button>
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
                modulo_id : 0,              
                ModCod : '',
                ModDes : '',
                ModTem : '',                
                ModVig : '',
                FecTra : '',
                FecMod : '',                
                tituloModal : '',
                tipoAccion : 0,
                arrayModulo : [],
                modal : 0,
                errorModulo : 0,
                errorMostrarMsjModulo : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,

                },
                offset : 3,
                criterio : 'ModDes',
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
            listarModulo (page,buscar,criterio){
                let me = this;
                var url = '/modulo?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;                
                axios.get(url).then(function (response) {
                   var respuesta = response.data;
                   me.arrayModulo = respuesta.modulo.data ;
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
                me.listarModulo(page,buscar,criterio);
            },
            registrarModulo (){

                if(this.validarModulo())
                {
                    return;
                }

                let me = this;
                axios.post('/modulo/registrar',{
                    'ModDes' : this.ModDes,
                    'ModTem' : this.ModTem,                    
                    'ModVig' : this.ModVig                    
                }).then(function (response) {
                  me.cerrarModal();
                  me.listarModulo(1,'','ModDes');
                })
                .catch(function (error) {
                   console.log(error);
                });
            },
            actualizarModulo() {

                //if(this.validarModulo())
                //{
                 //  return;
                //}

                let me = this;               
                axios.put('/modulo/actualizar/' + me.modulo_id,{                    
                    'ModDes' : this.ModDes,
                    'ModTem' : this.ModTem,                    
                    'ModVig' : this.ModVig

                    
                }).then(function (response) {                  
                  me.cerrarModal();
                  me.listarModulo(1,'','ModDes');
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            desactivarModulo(id){
                  const swalWithBootstrapButtons = swal.mixin({
                  confirmButtonClass: 'btn btn-success',
                  cancelButtonClass: 'btn btn-danger',
                  buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                  title: 'Esta seguro de desactivar este modulo?',                  
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {

                     let me = this;
                    axios.put('/modulo/desactivar/'+ id,{                   
                        'ModCod' : id
                    }).then(function (response) {                     
                      me.listarModulo(1,'','ModDes');
                      swalWithBootstrapButtons(
                      'Desactivado!',
                      'El modulo ha sido desactivado.',
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
              activarModulo(id){
                  const swalWithBootstrapButtons = swal.mixin({
                  confirmButtonClass: 'btn btn-success',
                  cancelButtonClass: 'btn btn-danger',
                  buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                  title: 'Esta seguro de activar este modulo?',                  
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {

                     let me = this;
                    axios.put('/modulo/activar/'+ id,{                   
                        //'PerCon' : 1                
                    }).then(function (response) {                     
                      me.listarModulo(1,'','PerNom');
                      swalWithBootstrapButtons(
                      'Activado!',
                      'El modulo ha sido activado.',
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
            validarModulo(){
                this.validarModulo = 0;
                this.errorMostrarMsjModulo = [];

                if(!this.ModDes) this.errorMostrarMsjModulo.push("La descripción del modulo no puede ser vacio");                
                if(!this.ModTem) this.errorMostrarMsjModulo.push("Falta seleccionar tipo de empresa");
                if(!this.ModVig) this.errorMostrarMsjModulo.push("Falta seleccionar vigencia");
                
                if(this.errorMostrarMsjModulo.length) this.errorModulo = 1;

                return this.errorModulo;
            },
            cerrarModal (){
                this.modal=0;
                this.tituloModal='';
                this.ModCod = '';
                this.ModDes = '';
                this.ModTem = '';
                this.ModVig = '';
                this.FecTra = '';
                this.FecMod = '';
                
            },
            abrirModal (modelo, accion, data = []){
                switch(modelo){
                    case "modulo":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Módulo';
                                this.ModCod = '';
                                this.ModDes = '';
                                this.ModTem = '';                                
                                this.ModVig = '';
                                this.FecTra = '';
                                this.FecMod = '';                                
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                console.log(data);
                                this.modal = 1;
                                this.tituloModal = "Actualizar Módulo";                               
                                 this.tipoAccion = 2;
                                this.modulo_id = data['ModCod'];
                                this.ModDes = data['ModDes'];
                                this.ModTem = data['ModTem'];                                
                                this.ModVig = data['ModVig'];                                            
                                break;

                            }
                        }
                    }
                }
            }
        },
        mounted() {
            this.listarModulo(1,this.buscar,this.criterio);
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
