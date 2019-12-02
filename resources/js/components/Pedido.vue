<template>
  <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Escritorio</a></li></ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Pedidos
                    
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterio">
                                <option value="nombre_cliente">Nombre Cliente</option>
                                <option value="estado">Estado</option>
                                </select>
                                <input type="text" v-model="buscar" @keyup.enter="listarPedido(1, buscar, criterio)" class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listarPedido(1, buscar, criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Productos</th>
                                <th>Fecha</th>
                                <th>Nombre Cliente</th>
                                <th>Observaciones</th>
                                <th>Sala</th>
                                <th>Asiento</th>
                                <th>Hora</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="pedido in arrayPedido" :key="pedido.id">
                                <td v-text="pedido.productos"></td>
                                <td v-text="pedido.fecha"></td>
                                <td v-text="pedido.nombre_cliente"></td>
                                <td v-text="pedido.observaciones"></td>
                                <td v-text="pedido.sala"></td>
                                <td v-text="pedido.asiento"></td>
                                <td v-text="pedido.hora"></td>
                                <td v-text="pedido.estado"></td>
                                <!-- <td>
                                    <div v-if="alumno.condicion" >
                                    <span class="badge badge-success">Activo</span>
                                    </div>

                                    <div v-else >
                                    <span class="badge badge-danger">Inactivo</span>
                                    </div>
                                </td> -->
                            </tr>
                            
                        </tbody>
                    </table>

                    <nav>
                        <ul class="pagination">
                            <li class="page-item" v-if="pagination.current_page > 1">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page -1, buscar, criterio)">Ant</a>
                            </li>
                            <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active': '']">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscar, criterio)" v-text="page"></a>
                            </li>
                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1, buscar, criterio)">Sig</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>
        <!--Inicio del modal agregar/actualizar-->
        <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                        <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <!-- <div class="modal-body">
                        <form action="#" method="POST" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Número de control*</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="numero_control" class="form-control" placeholder="Número de control">
                                    
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="nombre" class="form-control" placeholder="Nombre del alumno">
                                    
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email">email*</label>
                                <div class="col-md-9">
                                    <input type="email" v-model="email" class="form-control" placeholder="Ingrese email">
                                </div>
                            </div>
                            <div v-show="errorAlumno" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjAlumno" :key="error" v-text="error"></div>
                                </div>
                            </div>
                        </form>
                    </div> -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarAlumno()">Guardar</button>
                        <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarAlumno()">Actualizar</button>
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
            return{
                pedido_id: 0,
                productos : '',
                fecha : '',
                nombre_cliente : '',
                observaciones : '',
                sala : '',
                asiento : '',
                hora : '',
                estado : '',
                arrayPedido : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorAlumno : 0,
                errorMostrarMsjAlumno : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0
                },
                offset : 3,
                criterio : 'nombre_cliente',
                buscar : ''

            }
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },


            
            //Calcula los elementos de la paginacion
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;             

            }
        },
        methods : {

            
            listarPedido (page, buscar, criterio){
                //'alumno' es la route que nos regresa los alumnos
                let me = this;
                var url = 'https://serviciosalas.herokuapp.com/api/pedido';
                axios.get(url).then(function (response) {
                    // handle success
                    var respuesta = response.data;
                    me.arrayPedido = respuesta.pedidos.data;
                    me.pagination = respuesta.pagination;
                    console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },



            cambiarPagina(page, buscar, criterio){
                let me = this;
                //Actualiza la pagina actual
                me.pagination.current_page = page;
                //Envia la peticion para visualizar la data de esa pagina
                me.listarPedido(page, buscar, criterio);
            },

            cerrarModal(){
                this.modal=0;
                this.tituloModal = '';
                this.numero_control = '';
                this.nombre = '';
                this.email = '';
            },


        mounted() {
            this.listarPedido(1, this.buscar, this.criterio);
        }
    }
}
</script>