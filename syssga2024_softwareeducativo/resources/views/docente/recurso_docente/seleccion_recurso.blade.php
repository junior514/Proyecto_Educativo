<div class="modal fade modal-slide-in-center" aria-hidden="true" role="dialog" tabindex="-1"
    id="modal-add-recurso-{{ $l->idLeccion }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-white" style="background: #0059D1;">
                <h4 style="margin: 0px">Selecione un recurso</h4>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
                        {{-- <a href="#" class="btn btn-default" style="background-color:#3276b1; color: #FFF;"> --}}
                        <a href="#" class="btn btn-default" style="background-color:#7e7f7f; color: #FFF;">
                            <i class="fa fa-book fa-4x" style=""></i><br>
                            Contenido
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
                        {{-- <a href="#" class="btn btn-default" style="background-color:#5bc0de; color: #FFF;"> --}}
                        <a href="#" class="btn btn-default" style="background-color:#7e7f7f; color: #FFF;">
                            <i class="fa fa-comments fa-4x"></i><br>
                            Foro
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
                        <a href="{{ route('create_tarea', $l->idLeccion) }}"
                            class="btn btn-default" style="background-color:#d9534f; color: #FFF;">
                            {{-- <a href="#" class="btn btn-default" style="background-color:#7e7f7f; color: #FFF;"> --}}
                            <i class="fa fa-tasks fa-4x"></i><br>
                            Tarea
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
                        {{-- <a href="#" class="btn btn-default" style="background-color:#5cb85c; color: #FFF;"> --}}
                        <a href="#" class="btn btn-default" style="background-color:#7e7f7f; color: #FFF;">
                            <i class="fa fa-question fa-4x"></i><br>
                            Cuestionario
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
