@extends('admin.template.main')
@section('tittle', 'Lista de Apoderados')

<link href="{{ asset('/css/dropzone.css') }}" rel="stylesheet">
@section('content')
<!--Cargar Apoderos desde Excel-->
  <div class="container">
        <div class="row"    >
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Subir Archivo 
                </div>
                <div class="panel-body">
                    {!! Form::open(['route'=> 'admin.apoderados.up', 'method' => 'POST', 'files'=>'true', 'id' => 'my-dropzone' , 'class' => 'dropzone']) !!}
                    <div class="dz-message" style="height:50px;">
                        Arrastre su archivo aqui
                    </div>
                    <div class="dropzone-previews"></div>
                    <button type="submit" class="btn btn-success" id="submit">Subir</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
<hr>
<!--Fin de Cargar-->

{!! Html::script('js/dropzone.js'); !!}
    <script>
        Dropzone.options.myDropzone = {
            autoProcessQueue: false,
            uploadMultiple: false,
            maxFilezise: 10,
            maxFiles: 1,
            
            init: function() {
                var submitBtn = document.querySelector("#submit");
                myDropzone = this;
                
                submitBtn.addEventListener("click", function(e){
                    e.preventDefault();
                    e.stopPropagation();
                    myDropzone.processQueue();
                });
                this.on("addedfile", function(file) {
                    alert("file uploaded");
                });
                
                this.on("complete", function(file) {
                    myDropzone.removeFile(file);
                });
 
                this.on("success", 
                    myDropzone.processQueue.bind(myDropzone)
                );
            }
        };
    </script>