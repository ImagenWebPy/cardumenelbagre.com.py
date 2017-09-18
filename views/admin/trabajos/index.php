<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Listado de Trabajos
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= URL; ?>admin"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Trabajos</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Listado de Categorias</h3>
                        <div class="col-xs-6 pull-right">
                            <button type="button" class="btn btn-block btn-primary btnAgregarCategoria">Agregar Nueva Categoria</button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="tblCategorias" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Categoria</th>
                                    <th>Tag</th>
                                    <th>Estado</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Categoria</th>
                                    <th>Tag</th>
                                    <th>Estado</th>
                                    <th>Acción</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <!-- /.box-header -->
                    <div class="box-header">
                        <div class="col-md-4 pull-right">
                            <button type="button" class="btn btn-block btn-primary btn-Add-Contenido"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Contenido</button>
                        </div>
                    </div>
                    <div class="box-body">

                        <table id="tblTrabajos" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">Fecha</th>
                                    <th class="text-center">Título</th>
                                    <th class="text-center">Categoría</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-center">Fecha</th>
                                    <th class="text-center">Título</th>
                                    <th class="text-center">Categoría</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
    $(function () {
        //DATATABLE
        var table = $("#tblTrabajos").DataTable({
            "aaSorting": [[0, 'desc']],
            "paging": true,
            "orderCellsTop": true,
            "fixedColumns": true,
            "iDisplayLength": 50,
            "ajax": {
                "url": "<?= URL; ?>admin/listadoTrabajos/"
            },
            "columns": [
                {"data": "fecha"},
                {"data": "titulo"},
                {"data": "categoria"},
                {"data": "estado"},
                {"data": "acciones"}
            ],
            "language": {
                "url": "<?= URL; ?>public/language/Spanish.json"
            }
        });
        //EDITAR POST
        $(document).on("click", ".btnEditTrabajo", function (e) {
            if (e.handled !== true) // This will prevent event triggering more then once
            {
                var idPost = $(this).attr("data-post");
                $.ajax({
                    url: "<?= URL; ?>admin/mostrarModalEditarTrabajo",
                    type: "post",
                    dataType: "json",
                    data: {
                        post: idPost
                    },
                    success: function (data) {
                        $(".genericModal .modal-header").removeClass("modal-header").addClass("modal-header bg-primary");
                        $(".genericModal .modal-title").html(data['titulo']);
                        $(".genericModal .modal-body").html(data['contenido']);
                        $(".genericModal").modal("toggle");
                    }
                }); //END AJAX
            }
            e.handled = true;
        });
        //GUARDAR CAMBIOS POST
        $(document).on("click", ".btnGuardarCambios", function (e) {
            if (e.handled !== true) // This will prevent event triggering more then once
            {
                e.preventDefault();
                var form = new FormData($('.frmModificarPost')[0]);
                var titulo = $("input[name='titulo']");
                var fecha = $("input[name='fecha']");
                var categoria = $("input[name='categoria']");
                var tipo_evento = $("input[name='tipo_evento']");
                var tags = $("input[name='tags']");
                var contenido = $("input[name='contenido']");
                if (titulo.val().trim().length == 0) {
                    titulo.css("border", "2px solid red");
                } else {
                    titulo.css("border", "1px solid #d2d6de");
                }
                if (fecha.val().trim().length == 0) {
                    fecha.css("border", "2px solid red");
                } else {
                    fecha.css("border", "1px solid #d2d6de");
                }
                if (tags.val().trim().length == 0) {
                    tags.css("border", "2px solid red");
                } else {
                    tags.css("border", "1px solid #d2d6de");
                }
                if (titulo.val().trim().length > 0 && fecha.val().trim().length > 0 && tags.val().trim().length > 0) {
                    $('.frmModificarPost').append("<input type='hidden' name='tags2' value='" + tags.val() + "' />");
                    $(".frmModificarPost").submit();
                }
            }
            e.handled = true;
        });
        //SUBIR IMAGENES
        $(document).on("click", ".btnAddImagen", function (e) {
            if (e.handled !== true) // This will prevent event triggering more then once
            {
                $(".divSubir").toggle();
                $(".demo_multi").css('display', 'inline-block');
            }
            e.handled = true;
        });
        //SUBIR VIDEO
        $(document).on("click", ".btnAddVideo", function (e) {
            if (e.handled !== true) // This will prevent event triggering more then once
            {
                $(".divSubirVideo").toggle();
                $(".demo_video").css('display', 'inline-block');
            }
            e.handled = true;
        });
        //BTN MOSTRAR IMG
        $(document).on("click", ".btnMostrarImg", function (e) {
            if (e.handled !== true) // This will prevent event triggering more then once
            {
                var id = $(this).attr("data-id");
                $.ajax({
                    url: "<?= URL; ?>admin/mostrarImgBtn",
                    type: "post",
                    dataType: "json",
                    data: {
                        id: id
                    },
                    success: function (data) {
                        $('#mostrarImg' + data['id']).html(data['content']);
                    }
                }); //END AJAX
            }
            e.handled = true;
        });
        //BTN IMG PRINCIPAL
        $(document).on("click", ".btnImgPrincipal", function (e) {
            if (e.handled !== true) // This will prevent event triggering more then once
            {
                var id = $(this).attr("data-id");
                $.ajax({
                    url: "<?= URL; ?>admin/imgPrincipal",
                    type: "post",
                    dataType: "json",
                    data: {
                        id: id
                    },
                    success: function (data) {
                        if (data.result != false) {
                            $('#imgPrincipal' + data.id).html(data.content);
                            $('#imgPrincipal' + data.id_old).html(data.content_old);
                        }
                    }
                }); //END AJAX
            }
            e.handled = true;
        });
        //BTN ELIMINAR IMG
        $(document).on("click", ".btnEliminarImg", function (e) {
            if (e.handled !== true) // This will prevent event triggering more then once
            {
                var id = $(this).attr("data-id");
                $.ajax({
                    url: "<?= URL; ?>admin/eliminarIMG",
                    type: "post",
                    dataType: "json",
                    data: {
                        id: id
                    },
                    success: function (data) {
                        if (data.result != false) {
                            $("#imagenGaleria" + data.id).remove();
                        }
                    }
                }); //END AJAX
            }
            e.handled = true;
        });
        //BTN ELIMINAR IMG
        $(document).on("click", ".btn-Add-Contenido", function (e) {
            if (e.handled !== true) // This will prevent event triggering more then once
            {
                $.ajax({
                    url: "<?= URL; ?>admin/agregarContenido",
                    type: "post",
                    dataType: "json",
                    success: function (data) {
                        $('.genericModal').modal('toggle');
                        $('.genericModal .modal-header').addClass('modal-header bg-primary');
                        $('.genericModal .modal-header').html('Agregar Contenido');
                        $('.genericModal .modal-body').html(data);
                    }
                }); //END AJAX
            }
            e.handled = true;
        });
        //GUARDAR CAMBIOS POST
        $(document).on("click", ".btnFrmAddContenido ", function (e) {
            if (e.handled !== true) // This will prevent event triggering more then once
            {
                e.preventDefault();
                var form = new FormData($('.frmModificarPost')[0]);
                var titulo = $("input[name='titulo']");
                var fecha = $("input[name='fecha']");
                var categoria = $("input[name='categoria']");
                var tipo_evento = $("input[name='tipo_evento']");
                var tags = $("input[name='tags']");
                var contenido = $("input[name='contenido']");
                var video = $("input[name='video']");
                if (titulo.val().trim().length == 0) {
                    titulo.css("border", "2px solid red");
                    titulo.focus();
                } else {
                    titulo.css("border", "1px solid #d2d6de");
                }
                if (fecha.val().trim().length == 0) {
                    fecha.css("border", "2px solid red");
                } else {
                    fecha.css("border", "1px solid #d2d6de");
                }
                if (tags.val().trim().length == 0) {
                    tags.css("border", "2px solid red");
                } else {
                    tags.css("border", "1px solid #d2d6de");
                }
                if (video.val().trim().length == 0) {
                    video.css("border", "2px solid red");
                } else {
                    video.css("border", "1px solid #d2d6de");
                }
                if (titulo.val().trim().length > 0 && fecha.val().trim().length > 0 && tags.val().trim().length > 0 && video.val().trim().length > 0) {
                    $('.frmAgregarPost').append("<input type='hidden' name='tags2' value='" + tags.val() + "' />");
                    $(".frmAgregarPost").submit();
                }
            }
            e.handled = true;
        });
        //CAMBIAR ESTADO LISTADO
        $(document).on("click", ".linkListaEstadoPost", function (e) {
            if (e.handled !== true) // This will prevent event triggering more then once
            {
                var id = $(this).attr("data-post");
                $.ajax({
                    url: "<?= URL; ?>admin/cambiarEstadoPost",
                    type: "POST",
                    dataType: "json",
                    data: {
                        id: id
                    },
                    success: function (data) {
                        if (data.estado == 1) {
                            $('#estadoPost' + data.id).removeClass('pointer label label-danger linkListaEstadoPost').addClass(data.clase);
                        } else {
                            $('#estadoPost' + data.id).removeClass('pointer label label-success linkListaEstadoPost').addClass(data.clase);
                        }
                        $('#estadoPost' + data.id).html(data.texto);
                    }
                }); //END AJAX
            }
            e.handled = true;
        });
        $(document).on("submit", "#frmModificarVideo", function (e) {
            if (e.handled !== true) // This will prevent event triggering more then once
            {
                e.preventDefault(); // avoid to execute the actual submit of the form.
                var url = "<?= URL ?>admin/modificarVideoTrabajo"; // the script where you handle the form input.
                $.ajax({
                    type: "POST",
                    url: url,
                    data: $("#frmModificarVideo").serialize(), // serializes the form's elements.
                    success: function (data)
                    {
                        $('.divSubirVideo').toggle();
                        $('input[data="' + data['id'] + '"]').val(data['decripcion']);
                        $('#postVideo' + data['id_post']).html(data['video']);
                    }
                });

            }
            e.handled = true;
        });
        $(document).on("click", ".btnDeletePost", function (e) {
            if (e.handled !== true) // This will prevent event triggering more then once
            {
                var id = $(this).attr("data-post");
                $.ajax({
                    url: "<?= URL; ?>admin/modalEliminarPost",
                    type: "POST",
                    data: {id: id},
                    dataType: "json"
                }).done(function (data) {
                    $(".genericModal .modal-header").removeClass("modal-header").addClass("modal-header bg-primary");
                    $(".genericModal .modal-title").html(data['titulo']);
                    $(".genericModal .modal-body").html(data['contenido']);
                    $(".genericModal").modal("toggle");
                });
            }
            e.handled = true;
        });
        $(document).on("submit", "#frmEliminarPost", function (e) {
            var url = "<?= URL ?>admin/deletePost"; // the script where you handle the form input.
            var id = $("#btnEliminarPost").attr("data-id");
            $.ajax({
                type: "POST",
                url: url,
                data: {id: id}, // serializes the form's elements.
                success: function (data)
                {
                    if (data['type'] == 'success') {
                        $("#trabajo_" + data['id']).remove();
                        $(".genericModal").modal("toggle");
                    }
                }
            });
            e.preventDefault(); // avoid to execute the actual submit of the form.
        });
        $("#tblCategorias").DataTable({
            "aaSorting": [[0, "asc"]],
            "paging": true,
            "orderCellsTop": true,
            //"scrollX": true,
            //"scrollCollapse": true,
            "fixedColumns": true,
            "iDisplayLength": 10,
            "ajax": {
                "url": "<?= URL ?>admin/cargarDTCategorias/",
                "type": "post"
            },
            "columns": [
                {"data": "categoria"},
                {"data": "tag"},
                {"data": "estado"},
                {"data": "accion"}
            ],
            "language": {
                "url": "<?= URL ?>public/language/Spanish.json"
            }
        });
        $(document).on("click", ".btnAgregarCategoria", function (e) {
            if (e.handled !== true) // This will prevent event triggering more then once
            {
                $.ajax({
                    url: "<?= URL; ?>admin/modalAgregarCategoria",
                    type: "POST",
                    dataType: "json"
                }).done(function (data) {
                    $(".genericModal .modal-header").removeClass("modal-header").addClass("modal-header bg-primary");
                    $(".genericModal .modal-title").html(data['titulo']);
                    $(".genericModal .modal-body").html(data['contenido']);
                    $(".genericModal").modal("toggle");
                });
            }
            e.handled = true;
        });
        $(document).on("click", ".btnEditarCategoria", function (e) {
            if (e.handled !== true) // This will prevent event triggering more then once
            {
                var id = $(this).attr("data-id");
                $.ajax({
                    url: "<?= URL; ?>admin/modalEditarCategoria",
                    type: "POST",
                    data: {id: id},
                    dataType: "json"
                }).done(function (data) {
                    $(".genericModal .modal-header").removeClass("modal-header").addClass("modal-header bg-primary");
                    $(".genericModal .modal-title").html(data['titulo']);
                    $(".genericModal .modal-body").html(data['contenido']);
                    $(".genericModal").modal("toggle");
                });
            }
            e.handled = true;
        });
        $(document).on("submit", "#frmEditarCateoria", function (e) {
            var url = "<?= URL ?>admin/editCategoria"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#frmEditarCateoria").serialize(), // serializes the form's elements.
                success: function (data)
                {
                    if (data['type'] == 'success') {
                        $("#categoria" + data['id']).html(data['row']);
                        $(".genericModal").modal("toggle");
                    }
                }
            });
            e.preventDefault(); // avoid to execute the actual submit of the form.
        });
        $(document).on("click", ".btnEliminarCategoria", function (e) {
            if (e.handled !== true) // This will prevent event triggering more then once
            {
                var id = $(this).attr("data-id");
                $.ajax({
                    url: "<?= URL; ?>admin/modalEliminarCategoria",
                    type: "POST",
                    data: {id: id},
                    dataType: "json"
                }).done(function (data) {
                    $(".genericModal .modal-header").removeClass("modal-header").addClass("modal-header bg-primary");
                    $(".genericModal .modal-title").html(data['titulo']);
                    $(".genericModal .modal-body").html(data['contenido']);
                    $(".genericModal").modal("toggle");
                });
            }
            e.handled = true;
        });
        $(document).on("submit", "#frmEliminarCategoria", function (e) {
            var url = "<?= URL ?>admin/deleteCategoria"; // the script where you handle the form input.
            var id = $("#btnEliminarCategoria").attr("data-id");
            $.ajax({
                type: "POST",
                url: url,
                data: {id: id}, // serializes the form's elements.
                success: function (data)
                {
                    if (data['type'] == 'success') {
                        $("#categoria" + data['id']).remove();
                        $(".genericModal").modal("toggle");
                    }
                }
            });
            e.preventDefault(); // avoid to execute the actual submit of the form.
        });
    });
</script>